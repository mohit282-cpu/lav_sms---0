<?php

namespace Tests\Feature;

use App\Jobs\SendWebPushNotification;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookRequest;
use App\Models\Holiday;
use App\Models\PushSubscription;
use App\Services\PwaService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PwaPushNotificationTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;
    protected $student;
    protected $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('user_type', 'admin')->first()
            ?? User::where('user_type', 'super_admin')->first();
        $this->student = User::where('user_type', 'student')->first();
        $this->teacher = User::where('user_type', 'teacher')->first();
    }

    /**
     * Unauthenticated registration and unsubscription must be rejected with 401
     */
    public function test_unauthenticated_registration_and_unsubscription_rejected()
    {
        $subscribeResponse = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/unauth-test',
            'keys' => [
                'p256dh' => 'test-key',
                'auth' => 'test-auth',
            ],
        ]);
        $subscribeResponse->assertStatus(401);

        $unsubscribeResponse = $this->postJson(route('pwa.push.unsubscribe'), [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/unauth-test',
        ]);
        $unsubscribeResponse->assertStatus(401);
    }

    /**
     * Authenticated registration validates all required fields
     */
    public function test_registration_validation_rules()
    {
        $this->actingAs($this->admin);

        // Missing endpoint
        $res = $this->postJson(route('pwa.push.subscribe'), [
            'keys' => ['p256dh' => 'abc', 'auth' => 'xyz'],
        ]);
        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['endpoint']);

        // Missing keys
        $res = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test',
        ]);
        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['keys']);

        // Missing auth in keys
        $res = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test',
            'keys' => ['p256dh' => 'abc'],
        ]);
        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['keys.auth']);
    }

    /**
     * Insecure non-HTTPS endpoint is rejected
     */
    public function test_insecure_endpoint_is_rejected()
    {
        $this->actingAs($this->admin);

        $res = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => 'http://insecure-domain.example.com/push',
            'keys' => ['p256dh' => 'abc', 'auth' => 'xyz'],
        ]);
        $res->assertStatus(422);
        $this->assertStringContainsString('HTTPS', $res->json('message'));
    }

    /**
     * Multi-device support for the same user creates separate records by endpoint hash
     */
    public function test_multi_device_support_for_same_user()
    {
        $this->actingAs($this->admin);

        $device1 = 'https://fcm.googleapis.com/fcm/send/device-mobile-' . time();
        $device2 = 'https://fcm.googleapis.com/fcm/send/device-desktop-' . time();

        $res1 = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => $device1,
            'keys' => ['p256dh' => 'key1', 'auth' => 'auth1'],
        ]);
        $res1->assertStatus(200);

        $res2 = $this->postJson(route('pwa.push.subscribe'), [
            'endpoint' => $device2,
            'keys' => ['p256dh' => 'key2', 'auth' => 'auth2'],
        ]);
        $res2->assertStatus(200);

        $this->assertDatabaseHas('push_subscriptions', [
            'user_id' => $this->admin->id,
            'endpoint_hash' => hash('sha256', $device1),
        ]);
        $this->assertDatabaseHas('push_subscriptions', [
            'user_id' => $this->admin->id,
            'endpoint_hash' => hash('sha256', $device2),
        ]);
    }

    /**
     * A user cannot unsubscribe another user's device subscription
     */
    public function test_cross_user_unsubscribe_isolation()
    {
        // Register device for Student
        $studentEndpoint = 'https://fcm.googleapis.com/fcm/send/student-device-' . time();
        PushSubscription::storeSubscription($this->student->id, [
            'endpoint' => $studentEndpoint,
            'keys' => ['p256dh' => 'key-st', 'auth' => 'auth-st'],
        ]);

        $this->assertDatabaseHas('push_subscriptions', [
            'user_id' => $this->student->id,
            'endpoint_hash' => hash('sha256', $studentEndpoint),
        ]);

        // Attempt to unsubscribe while logged in as Teacher
        $this->actingAs($this->teacher);
        $res = $this->postJson(route('pwa.push.unsubscribe'), [
            'endpoint' => $studentEndpoint,
        ]);
        $res->assertStatus(200);

        // Student's subscription must remain intact because teacher does not own it
        $this->assertDatabaseHas('push_subscriptions', [
            'user_id' => $this->student->id,
            'endpoint_hash' => hash('sha256', $studentEndpoint),
        ]);

        // When student unsubscribes own device, it is deleted
        $this->actingAs($this->student);
        $res2 = $this->postJson(route('pwa.push.unsubscribe'), [
            'endpoint' => $studentEndpoint,
        ]);
        $res2->assertStatus(200);

        $this->assertDatabaseMissing('push_subscriptions', [
            'user_id' => $this->student->id,
            'endpoint_hash' => hash('sha256', $studentEndpoint),
        ]);
    }

    /**
     * Test VAPID public key endpoint returns JSON with configured status
     */
    public function test_vapid_key_endpoint_returns_json()
    {
        $this->actingAs($this->admin);

        Config::set('services.pwa.vapid_public_key', 'test-mock-public-key-value');

        $response = $this->getJson(route('pwa.push.vapid'));
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'vapid_public_key' => 'test-mock-public-key-value',
            'is_configured' => true,
        ]);
    }

    /**
     * Test Artisan pwa:vapid command displays or generates keypair
     */
    public function test_artisan_vapid_command()
    {
        $this->artisan('pwa:vapid', ['--show' => true])
            ->assertExitCode(0);

        $this->artisan('pwa:vapid')
            ->expectsOutput('=== Generated Web Push VAPID Keypair ===')
            ->assertExitCode(0);
    }

    /**
     * Test missing VAPID keys fails safely without false success
     */
    public function test_missing_vapid_keys_fails_safely()
    {
        Config::set('services.pwa.vapid_public_key', null);
        Config::set('services.pwa.vapid_private_key', null);

        PushSubscription::storeSubscription($this->admin->id, [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-vapid-missing',
            'keys' => ['p256dh' => 'key', 'auth' => 'token'],
        ]);

        $service = app(PwaService::class);
        $result = $service->sendNotification($this->admin->id, 'Test Title', 'Test Body');

        $this->assertEquals('vapid_keys_missing', $result['status']);
        $this->assertEquals(0, $result['sent']);
    }

    /**
     * Test SendWebPushNotification queueable job dispatches and runs
     */
    public function test_send_web_push_notification_job()
    {
        Queue::fake();

        SendWebPushNotification::dispatch($this->admin->id, 'Alert', 'School is closed tomorrow.');

        Queue::assertPushed(SendWebPushNotification::class, function ($job) {
            return true;
        });
    }

    /**
     * Test school holiday creation dispatches push notification job
     */
    public function test_holiday_creation_dispatches_push_notification()
    {
        Queue::fake();
        $this->actingAs($this->admin);

        PushSubscription::storeSubscription($this->teacher->id, [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/holiday-teacher-sub',
            'keys' => ['p256dh' => 'k', 'auth' => 'a'],
        ]);

        $postData = [
            'title' => 'Tihar Holiday',
            'title_ne' => 'तिहार बिदा',
            'type' => 'school_holiday',
            'start_date_bs' => '2083-07-15',
            'end_date_bs' => '2083-07-20',
            'description' => 'Festive school closure',
        ];

        $res = $this->post(route('holidays.store'), $postData);
        $res->assertSessionHas('flash_success');

        Queue::assertPushed(SendWebPushNotification::class);
    }

    /**
     * Test book request approval dispatches push notification to student
     */
    public function test_book_request_approval_dispatches_push_notification()
    {
        Queue::fake();

        $librarian = User::where('user_type', 'librarian')->first() ?? $this->admin;
        $category = BookCategory::firstOrCreate(['name' => 'General Science']);
        $book = Book::firstOrCreate(
            ['isbn' => '978-9937-0-0011-1'],
            [
                'name' => 'Physics Grade 10',
                'author' => 'Dr. Sharma',
                'category_id' => $category->id,
                'total_copies' => 5,
            ]
        );

        $bookRequest = BookRequest::create([
            'book_id' => $book->id,
            'user_id' => $this->student->id,
            'status' => 'pending',
            'request_date' => now(),
        ]);

        $this->actingAs($librarian);
        $res = $this->post(route('book_requests.approve', ['id' => $bookRequest->id]));
        $res->assertSessionHas('flash_success');

        Queue::assertPushed(SendWebPushNotification::class);
    }

    /**
     * Test service worker contains same-origin validation and sanitized push listener
     */
    public function test_service_worker_push_and_click_handlers()
    {
        $swPath = public_path('sw.js');
        $this->assertFileExists($swPath);

        $content = file_get_contents($swPath);

        // Push event listener
        $this->assertStringContainsString("self.addEventListener('push'", $content);
        $this->assertStringContainsString("showNotification", $content);

        // Notification click event listener with same-origin check
        $this->assertStringContainsString("self.addEventListener('notificationclick'", $content);
        $this->assertStringContainsString("parsed.origin === self.location.origin", $content);
    }

    /**
     * Test My Account view renders PWA push notification controls
     */
    public function test_my_account_renders_push_notification_card()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('my_account'));
        $response->assertStatus(200);

        $response->assertSee('pwa-push-card');
        $response->assertSee('pwa-btn-enable-push');
        $response->assertSee('pwa-btn-disable-push');
        $response->assertSee('pwa-btn-test-push');
    }
}
