<?php

namespace Tests\Feature;

use App\Models\PushSubscription;
use App\Services\PwaService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PwaFeatureTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('user_type', 'admin')->first()
            ?? User::where('user_type', 'super_admin')->first();
    }

    /**
     * Test dynamic manifest endpoint returns valid JSON with required keys and correct content-type
     */
    public function test_manifest_endpoint_returns_valid_json()
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/manifest+json', $response->headers->get('Content-Type'));

        $data = $response->json();
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('short_name', $data);
        $this->assertArrayHasKey('start_url', $data);
        $this->assertArrayHasKey('display', $data);
        $this->assertEquals('standalone', $data['display']);
        $this->assertArrayHasKey('theme_color', $data);
        $this->assertArrayHasKey('background_color', $data);
        $this->assertArrayHasKey('icons', $data);
        $this->assertArrayHasKey('shortcuts', $data);

        // Verify required icon sizes exist in manifest
        $sizes = array_column($data['icons'], 'sizes');
        $this->assertContains('192x192', $sizes);
        $this->assertContains('512x512', $sizes);

        // Verify maskable icon exists
        $purposes = array_column($data['icons'], 'purpose');
        $this->assertContains('maskable', $purposes);
    }

    /**
     * Test static manifest.json file exists in public directory and is valid JSON
     */
    public function test_static_manifest_file_exists_and_is_valid()
    {
        $path = public_path('manifest.json');
        $this->assertFileExists($path);

        $json = json_decode(file_get_contents($path), true);
        $this->assertIsArray($json);
        $this->assertArrayHasKey('name', $json);
        $this->assertArrayHasKey('start_url', $json);
        $this->assertEquals('standalone', $json['display']);
    }

    /**
     * Test branded offline fallback page loads successfully
     */
    public function test_offline_fallback_page_loads_successfully()
    {
        $response = $this->get('/offline');

        $response->assertStatus(200);
        $response->assertSee('Offline Mode');
        $response->assertSee('Retry Connection');
    }

    /**
     * Test service worker endpoint returns JavaScript with correct Service-Worker-Allowed header
     */
    public function test_service_worker_script_is_served()
    {
        $response = $this->get('/sw.js');

        $response->assertStatus(200);
        $this->assertStringContainsString('javascript', $response->headers->get('Content-Type'));
        $this->assertEquals('/', $response->headers->get('Service-Worker-Allowed'));

        $content = $response->getContent();
        $this->assertStringContainsString('CACHE_VERSION', $content);
        $this->assertStringContainsString('skipWaiting', $content);
        $this->assertStringContainsString('offline', $content);
    }

    /**
     * Test all declared manifest icons exist on disk as readable files
     */
    public function test_all_manifest_icons_exist_on_disk()
    {
        $pwaService = new PwaService();
        $manifest = $pwaService->getManifest();

        foreach ($manifest['icons'] as $icon) {
            $src = $icon['src'];
            // Extract path relative to public
            $path = parse_url($src, PHP_URL_PATH);
            $localRel = ltrim($path, '/');
            // If running in subfolder like /lav_sms/assets/...
            if (str_contains($localRel, 'assets/')) {
                $sub = substr($localRel, strpos($localRel, 'assets/'));
                $fullPath = public_path($sub);
            } else {
                $fullPath = public_path($localRel);
            }

            $this->assertFileExists($fullPath, "Manifest icon not found on disk: {$src}");
            $this->assertGreaterThan(0, filesize($fullPath), "Manifest icon is empty: {$src}");
        }
    }

    /**
     * Test push subscription requires authentication
     */
    public function test_push_subscription_requires_authentication()
    {
        $response = $this->postJson('/pwa/push/subscribe', [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test authenticated user can register and unsubscribe from push notifications
     */
    public function test_authenticated_user_push_workflow()
    {
        $this->actingAs($this->admin);

        $endpoint = 'https://fcm.googleapis.com/fcm/send/test-sub-' . time();
        $subscribeResponse = $this->postJson('/pwa/push/subscribe', [
            'endpoint' => $endpoint,
            'keys' => [
                'p256dh' => 'BDH3k-mock-key-value',
                'auth' => 'mock-auth-secret',
            ],
        ]);

        $subscribeResponse->assertStatus(200);
        $subscribeResponse->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('push_subscriptions', [
            'user_id' => $this->admin->id,
            'endpoint_hash' => hash('sha256', $endpoint),
        ]);

        // Unsubscribe
        $unsubscribeResponse = $this->postJson('/pwa/push/unsubscribe', [
            'endpoint' => $endpoint,
        ]);

        $unsubscribeResponse->assertStatus(200);
        $unsubscribeResponse->assertJson(['status' => 'success']);

        $this->assertDatabaseMissing('push_subscriptions', [
            'endpoint_hash' => hash('sha256', $endpoint),
        ]);
    }
}
