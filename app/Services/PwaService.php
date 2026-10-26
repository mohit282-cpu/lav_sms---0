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
     * Safe push notification dispatching method for a single user.
     * Sanitizes payloads to avoid leaking private academic or financial data.
     */
    public function sendNotification(int $userId, string $title, string $body, ?string $targetUrl = null): array
    {
        return $this->sendToUsers([$userId], $title, $body, $targetUrl);
    }

    /**
     * Dispatch notification to multiple users safely.
     */
    public function sendToUsers(iterable $userIds, string $title, string $body, ?string $targetUrl = null): array
    {
        $userIdArray = is_array($userIds) ? $userIds : iterator_to_array($userIds);
        if (empty($userIdArray)) {
            return [
                'status' => 'no_recipients',
                'message' => 'No recipients specified.',
                'total' => 0,
                'sent' => 0,
                'expired' => 0,
                'failed' => 0,
                'skipped' => 0,
            ];
        }

        $subscriptions = PushSubscription::whereIn('user_id', $userIdArray)->get();
        if ($subscriptions->isEmpty()) {
            return [
                'status' => 'no_subscriptions',
                'message' => 'No active push subscriptions found for recipients.',
                'total' => 0,
                'sent' => 0,
                'expired' => 0,
                'failed' => 0,
                'skipped' => 0,
            ];
        }

        $this->ensureOpenSslConfig();

        // Check if WebPush library is available
        if (!class_exists(\Minishlink\WebPush\WebPush::class)) {
            Log::error('PWA WebPush library (minishlink/web-push) is not installed or available.');
            return [
                'status' => 'dependency_missing',
                'message' => 'WebPush dependency is not installed on the server.',
                'total' => $subscriptions->count(),
                'sent' => 0,
                'expired' => 0,
                'failed' => 0,
                'skipped' => $subscriptions->count(),
            ];
        }

        // Check if VAPID keys are configured
        $vapidPublic = config('services.pwa.vapid_public_key') ?: env('VAPID_PUBLIC_KEY');
        $vapidPrivate = config('services.pwa.vapid_private_key') ?: env('VAPID_PRIVATE_KEY');
        $vapidSubject = config('services.pwa.vapid_subject') ?: env('VAPID_SUBJECT', config('app.url', 'http://localhost'));

        if (!$vapidPublic || !$vapidPrivate) {
            Log::info("PWA Push notification skipped: VAPID keys not configured in environment. Title: {$title}");
            return [
                'status' => 'vapid_keys_missing',
                'message' => 'VAPID keys not configured in server environment.',
                'total' => $subscriptions->count(),
                'sent' => 0,
                'expired' => 0,
                'failed' => 0,
                'skipped' => $subscriptions->count(),
            ];
        }

        // Generic safe payload without confidential marks, fees, or personal records
        $safeUrl = $this->sanitizeTargetUrl($targetUrl);
        $payload = json_encode([
            'title' => strip_tags($title),
            'body' => strip_tags($body),
            'icon' => asset('assets/images/icons/icon-192x192.png'),
            'badge' => asset('assets/images/icons/icon-72x72.png'),
            'url' => $safeUrl,
            'timestamp' => now()->timestamp,
        ], JSON_UNESCAPED_SLASHES);

        $validSubscriptions = [];
        $skippedCount = 0;
        foreach ($subscriptions as $sub) {
            if (empty($sub->public_key) || empty($sub->auth_token)) {
                $skippedCount++;
            } else {
                $validSubscriptions[] = $sub;
            }
        }

        if (empty($validSubscriptions)) {
            return [
                'status' => 'failed',
                'message' => 'All subscriptions are missing required encryption keys.',
                'total' => $subscriptions->count(),
                'sent' => 0,
                'expired' => 0,
                'failed' => 0,
                'skipped' => $skippedCount,
            ];
        }

        $sentCount = 0;
        $expiredCount = 0;
        $failedCount = 0;

        try {
            $auth = [
                'VAPID' => [
                    'subject' => $vapidSubject,
                    'publicKey' => $vapidPublic,
                    'privateKey' => $vapidPrivate,
                ],
            ];

            $webPush = new \Minishlink\WebPush\WebPush($auth);
            $webPush->setReuseHttpClient(true);

            foreach ($validSubscriptions as $sub) {
                $pushSubscription = \Minishlink\WebPush\Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                    'contentEncoding' => $sub->content_encoding ?: 'aesgcm',
                ]);
                $webPush->queueNotification($pushSubscription, $payload);
            }

            foreach ($webPush->flush() as $report) {
                $endpoint = $report->getEndpoint();
                $hash = hash('sha256', $endpoint);

                if ($report->isSuccess()) {
                    $sentCount++;
                } else {
                    $response = $report->getResponse();
                    $statusCode = $response ? $response->getStatusCode() : null;

                    if ($report->isSubscriptionExpired() || in_array($statusCode, [404, 410])) {
                        $expiredCount++;
                        PushSubscription::where('endpoint_hash', $hash)->delete();
                    } else {
                        $failedCount++;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Mask any private keys or endpoints in error logging
            Log::error('PWA WebPush delivery exception: ' . $e->getMessage());

            $isVapidError = stripos($e->getMessage(), 'vapid') !== false ||
                stripos($e->getMessage(), 'public key') !== false ||
                stripos($e->getMessage(), 'private key') !== false;

            return [
                'status' => $isVapidError ? 'vapid_keys_invalid' : 'error',
                'message' => $isVapidError ? 'Configured VAPID keys are invalid or malformed.' : 'Web push delivery error encountered.',
                'total' => $subscriptions->count(),
                'sent' => $sentCount,
                'expired' => $expiredCount,
                'failed' => $failedCount ?: count($validSubscriptions),
                'skipped' => $skippedCount,
            ];
        }

        // Determine clear delivery status
        $status = 'failed';
        if ($sentCount > 0) {
            $status = ($expiredCount === 0 && $failedCount === 0 && $skippedCount === 0) ? 'success' : 'partial';
        }

        return [
            'status' => $status,
            'message' => $status === 'success'
                ? 'All notifications accepted by push service.'
                : ($status === 'partial' ? 'Some notifications delivered with errors or skipped devices.' : 'No notifications could be delivered to devices.'),
            'total' => $subscriptions->count(),
            'sent' => $sentCount,
            'expired' => $expiredCount,
            'failed' => $failedCount,
            'skipped' => $skippedCount,
        ];
    }

    /**
     * Dispatch notification to all users matching a user type / role.
     */
    public function sendToRole(string $userType, string $title, string $body, ?string $targetUrl = null): array
    {
        $userIds = \App\User::where('user_type', $userType)->pluck('id')->toArray();
        return $this->sendToUsers($userIds, $title, $body, $targetUrl);
    }

    /**
     * Sanitize target URL to ensure same-origin safety.
     * Rejects protocol-relative URLs, backslash tricks, control characters,
     * dangerous schemes, port mismatches, and external origins.
     */
    public function sanitizeTargetUrl(?string $targetUrl): string
    {
        $defaultFallback = route('dashboard');

        if (empty($targetUrl) || !is_string($targetUrl)) {
            return $defaultFallback;
        }

        $targetUrl = trim($targetUrl);

        // Reject control characters (0x00 - 0x1F, 0x7F) and newlines
        if (preg_match('/[\x00-\x1F\x7F\r\n]/', $targetUrl)) {
            return $defaultFallback;
        }

        // Reject protocol-relative URLs (//example.com) and backslash-based tricks (/\, \\)
        if (str_starts_with($targetUrl, '//') || str_starts_with($targetUrl, '/\\') || str_starts_with($targetUrl, '\\\\') || str_starts_with($targetUrl, '\\/')) {
            return $defaultFallback;
        }

        // Reject backslashes anywhere in the URL to prevent browser interpretation quirks
        if (strpos($targetUrl, '\\') !== false) {
            return $defaultFallback;
        }

        // Reject dangerous pseudo-protocols/schemes
        if (preg_match('/^(javascript|data|vbscript|file|about|blob):/i', $targetUrl)) {
            return $defaultFallback;
        }

        // Handle safe relative URLs starting with '/' or './'
        if (str_starts_with($targetUrl, '/') || str_starts_with($targetUrl, './')) {
            $firstSlash = strpos($targetUrl, '/');
            $colonPos = strpos($targetUrl, ':');
            if ($colonPos !== false && $colonPos < $firstSlash) {
                return $defaultFallback;
            }
            return $targetUrl;
        }

        // Absolute URL validation
        $parts = parse_url($targetUrl);
        if ($parts === false || empty($parts['scheme']) || empty($parts['host'])) {
            return $defaultFallback;
        }

        // Scheme must be http or https
        $scheme = strtolower($parts['scheme']);
        if (!in_array($scheme, ['http', 'https'], true)) {
            return $defaultFallback;
        }

        // App URL components
        $appUrl = config('app.url') ?: 'http://localhost';
        $appParts = parse_url($appUrl);
        $appHost = strtolower($appParts['host'] ?? 'localhost');
        $targetHost = strtolower($parts['host']);

        // Host must match exactly
        if ($targetHost !== $appHost) {
            return $defaultFallback;
        }

        // Effective port check
        $appScheme = strtolower($appParts['scheme'] ?? 'http');
        $appPort = $appParts['port'] ?? ($appScheme === 'https' ? 443 : 80);
        $targetPort = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);

        if ($targetPort !== $appPort) {
            return $defaultFallback;
        }

        // Subdirectory check: If app is deployed under a subpath (e.g. /sms)
        if (!empty($appParts['path']) && $appParts['path'] !== '/') {
            $basePath = rtrim($appParts['path'], '/');
            $targetPath = $parts['path'] ?? '/';
            if ($targetPath !== $basePath && !str_starts_with($targetPath, $basePath . '/')) {
                return $defaultFallback;
            }
        }

        return $targetUrl;
    }

    /**
     * Ensure Windows OpenSSL configuration is set
     */
    protected function ensureOpenSslConfig(): void
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && empty(getenv('OPENSSL_CONF'))) {
            $candidates = [
                'Z:/Xampp/php/extras/ssl/openssl.cnf',
                'C:/xampp/php/extras/ssl/openssl.cnf',
                'Z:/Xampp/apache/bin/openssl.cnf',
                'C:/xampp/apache/bin/openssl.cnf',
            ];

            foreach ($candidates as $cnf) {
                if (file_exists($cnf)) {
                    putenv("OPENSSL_CONF={$cnf}");
                    $_ENV['OPENSSL_CONF'] = $cnf;
                    break;
                }
            }
        }
    }
}
