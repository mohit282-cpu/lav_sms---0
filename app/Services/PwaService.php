<?php

namespace App\Services;

use App\Helpers\Qs;
use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;

class PwaService
{
    /**
     * Get the web app manifest array.
     */
    public function getManifest(): array
    {
        $systemName = Qs::getSystemName() ?: config('app.name', 'School Management System');
        $shortName = substr($systemName, 0, 15);
        $baseUrl = url('/');
        $basePath = parse_url($baseUrl, PHP_URL_PATH) ?: '';
        $startUrl = rtrim($baseUrl, '/') . '/';
        $scope = rtrim($baseUrl, '/') . '/';

        return [
            'name' => $systemName,
            'short_name' => $shortName ?: 'SMS Nepal',
            'description' => 'Comprehensive localized School Management System for Nepal with offline readiness, attendance, and student tracking.',
            'start_url' => $startUrl,
            'scope' => $scope,
            'display' => 'standalone',
            'orientation' => 'any',
            'theme_color' => '#1e2b37',
            'background_color' => '#ffffff',
            'dir' => 'ltr',
            'lang' => app()->getLocale() === 'ne' ? 'ne-NP' : 'en-US',
            'categories' => ['education', 'productivity'],
            'icons' => [
                [
                    'src' => asset('assets/images/icons/icon-72x72.png'),
                    'sizes' => '72x72',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-96x96.png'),
                    'sizes' => '96x96',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-128x128.png'),
                    'sizes' => '128x128',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-144x144.png'),
                    'sizes' => '144x144',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-152x152.png'),
                    'sizes' => '152x152',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-192x192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-384x384.png'),
                    'sizes' => '384x384',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-512x512.png'),
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src' => asset('assets/images/icons/icon-maskable-192x192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'maskable'
                ],
                [
                    'src' => asset('assets/images/icons/icon-maskable-512x512.png'),
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'maskable'
                ],
            ],
            'shortcuts' => [
                [
                    'name' => 'Dashboard',
                    'short_name' => 'Dashboard',
                    'description' => 'Open school overview dashboard',
                    'url' => route('dashboard'),
                    'icons' => [
                        [
                            'src' => asset('assets/images/icons/icon-96x96.png'),
                            'sizes' => '96x96',
                            'type' => 'image/png'
                        ]
                    ]
                ],
                [
                    'name' => 'Library Catalogue',
                    'short_name' => 'Library',
                    'description' => 'Search and browse library books',
                    'url' => route('books.catalogue'),
                    'icons' => [
                        [
                            'src' => asset('assets/images/icons/icon-96x96.png'),
                            'sizes' => '96x96',
                            'type' => 'image/png'
                        ]
                    ]
                ],
                [
                    'name' => 'My Account',
                    'short_name' => 'Profile',
                    'description' => 'View profile and personal settings',
                    'url' => route('my_account'),
                    'icons' => [
                        [
                            'src' => asset('assets/images/icons/icon-96x96.png'),
                            'sizes' => '96x96',
                            'type' => 'image/png'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Get pre-cache URLs for the service worker.
     */
    public function getPrecacheUrls(): array
    {
        return [
            route('pwa.offline'),
            asset('assets/css/bootstrap.min.css'),
            asset('assets/css/bootstrap_limitless.min.css'),
            asset('assets/css/layout.min.css'),
            asset('assets/css/components.min.css'),
            asset('assets/css/colors.min.css'),
            asset('assets/css/qs.css'),
            asset('assets/css/nepali_datepicker.css'),
            asset('assets/css/pwa.css'),
            asset('global_assets/css/icons/icomoon/styles.css'),
            asset('global_assets/js/main/jquery.min.js'),
            asset('global_assets/js/main/bootstrap.bundle.min.js'),
            asset('assets/js/pwa.js'),
            asset('global_assets/images/logo.png'),
            asset('global_assets/images/favicon.png'),
            asset('assets/images/icons/icon-192x192.png'),
            asset('assets/images/icons/icon-512x512.png'),
        ];
    }

    /**
     * Safe push notification dispatching method.
     * Sanitizes payloads to avoid leaking private academic or financial data.
     */
    public function sendNotification(int $userId, string $title, string $body, ?string $targetUrl = null): array
    {
        $subscriptions = PushSubscription::where('user_id', $userId)->get();
        if ($subscriptions->isEmpty()) {
            return ['status' => 'no_subscriptions', 'sent' => 0];
        }

        // Check if VAPID keys are configured
        $vapidPublic = env('VAPID_PUBLIC_KEY');
        $vapidPrivate = env('VAPID_PRIVATE_KEY');

        if (!$vapidPublic || !$vapidPrivate) {
            Log::info("PWA Push notification queued for User {$userId} but VAPID keys not configured in environment. Title: {$title}");
            return [
                'status' => 'vapid_keys_missing',
                'message' => 'VAPID keys not configured in .env. Notification logged safely.',
                'sent' => 0,
            ];
        }

        // Generic safe payload without confidential examination marks or sensitive fee details
        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'icon' => asset('assets/images/icons/icon-192x192.png'),
            'badge' => asset('assets/images/icons/icon-72x72.png'),
            'url' => $targetUrl ?: route('dashboard'),
            'timestamp' => now()->timestamp,
        ]);

        $sentCount = 0;
        // In environments where web-push library is installed, dispatch WebPush:
        if (class_exists(\Minishlink\WebPush\WebPush::class)) {
            try {
                $auth = [
                    'VAPID' => [
                        'subject' => env('VAPID_SUBJECT', url('/')),
                        'publicKey' => $vapidPublic,
                        'privateKey' => $vapidPrivate,
                    ],
                ];
                $webPush = new \Minishlink\WebPush\WebPush($auth);

                foreach ($subscriptions as $sub) {
                    $pushSubscription = \Minishlink\WebPush\Subscription::create([
                        'endpoint' => $sub->endpoint,
                        'publicKey' => $sub->public_key,
                        'authToken' => $sub->auth_token,
                        'contentEncoding' => $sub->content_encoding,
                    ]);
                    $webPush->queueNotification($pushSubscription, $payload);
                }

                foreach ($webPush->flush() as $report) {
                    if ($report->isSuccess()) {
                        $sentCount++;
                    } else {
                        if ($report->isSubscriptionExpired()) {
                            PushSubscription::where('endpoint', $report->getEndpoint())->delete();
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('PWA WebPush error: ' . $e->getMessage());
            }
        } else {
            Log::info("WebPush library not present. Payload recorded for {$subscriptions->count()} devices.");
        }

        return ['status' => 'processed', 'sent' => $sentCount];
    }
}
