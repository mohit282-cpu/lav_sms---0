/**
 * Progressive Web App Service Worker
 * Application: Laravel School Management System (Nepal Edition)
 * Version: 1.0.0
 *
 * Security Notice:
 * - This service worker NEVER caches authenticated HTML documents, student records,
 *   examination marks, fee payments, session tokens, or private user data.
 * - All state-changing requests (POST, PUT, PATCH, DELETE) bypass the service worker entirely.
 * - Navigation requests use a strict Network-Only strategy with fallback to a branded /offline page.
 */

const CACHE_VERSION = 'lav-sms-v1.0.0';
const PRECACHE_NAME = `lav-sms-precache-${CACHE_VERSION}`;
const RUNTIME_STATIC_CACHE = `lav-sms-static-${CACHE_VERSION}`;

// Pre-cached core static assets and offline fallback
const PRECACHE_URLS = [
    './offline',
    './assets/css/bootstrap.min.css',
    './assets/css/bootstrap_limitless.min.css',
    './assets/css/layout.min.css',
    './assets/css/components.min.css',
    './assets/css/colors.min.css',
    './assets/css/qs.css',
    './assets/css/nepali_datepicker.css',
    './assets/css/pwa.css',
    './global_assets/css/icons/icomoon/styles.css',
    './global_assets/js/main/jquery.min.js',
    './global_assets/js/main/bootstrap.bundle.min.js',
    './assets/js/pwa.js',
    './global_assets/images/logo.png',
    './global_assets/images/favicon.png',
    './assets/images/icons/icon-72x72.png',
    './assets/images/icons/icon-192x192.png',
    './assets/images/icons/icon-512x512.png',
    './assets/images/icons/icon-maskable-192x192.png',
    './assets/images/icons/icon-maskable-512x512.png'
];

/**
 * Install Event: Pre-cache essential assets & offline page
 */
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(PRECACHE_NAME)
            .then((cache) => {
                // Fetch each asset gracefully so one missing asset doesn't break installation
                return Promise.allSettled(
                    PRECACHE_URLS.map((url) => {
                        return cache.add(new Request(url, { cache: 'reload' })).catch((err) => {
                            console.warn(`[PWA SW] Pre-cache skipped for: ${url}`, err);
                        });
                    })
                );
            })
            .then(() => self.skipWaiting())
    );
});

/**
 * Activate Event: Clean up outdated caches
 */
self.addEventListener('activate', (event) => {
    const expectedCaches = [PRECACHE_NAME, RUNTIME_STATIC_CACHE];

    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!expectedCaches.includes(cacheName)) {
                        console.log(`[PWA SW] Deleting obsolete cache: ${cacheName}`);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

/**
 * Fetch Event: Routing & Caching Strategies
 */
self.addEventListener('fetch', (event) => {
    const { request } = event;

    // 1. Never intercept non-GET requests (POST, PUT, PATCH, DELETE)
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // 2. Ignore browser extension requests and cross-origin analytics/APIs
    if (url.protocol !== 'http:' && url.protocol !== 'https:') {
        return;
    }

    // 3. HTML Navigation Requests (Network-First with Offline Fallback)
    // CRITICAL: We NEVER cache dynamic HTML pages to prevent leaking private student/fee/marks data
    const isNavigation = request.mode === 'navigate' ||
        (request.headers.get('accept') && request.headers.get('accept').includes('text/html'));

    if (isNavigation) {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    return networkResponse;
                })
                .catch(async () => {
                    // When offline, serve the pre-cached branded offline fallback page
                    const cache = await caches.open(PRECACHE_NAME);
                    const offlineFallback = await cache.match('./offline') || await cache.match('/offline');
                    if (offlineFallback) {
                        return offlineFallback;
                    }
                    return new Response(
                        `<!DOCTYPE html><html><head><meta charset="utf-8"><title>Offline - School Management System</title><style>body{font-family:sans-serif;text-align:center;padding:50px;background:#f4f6f9;color:#333;}.card{background:#fff;padding:30px;border-radius:8px;max-width:500px;margin:0 auto;box-shadow:0 4px 6px rgba(0,0,0,0.1);}</style></head><body><div class="card"><h2>Offline Mode</h2><p>You are currently offline. Please check your internet connection.</p><button onclick="window.location.reload()" style="background:#1e88e5;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;">Retry Connection</button></div></body></html>`,
                        {
                            headers: { 'Content-Type': 'text/html; charset=utf-8' }
                        }
                    );
                })
        );
        return;
    }

    // 4. Static Assets (CSS, JS, Fonts, Images): Cache-First with Network Revalidation
    const isStaticAsset = /\.(css|js|woff2?|ttf|eot|svg|png|jpg|jpeg|gif|ico|webp)$/i.test(url.pathname);

    if (isStaticAsset) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                if (cachedResponse) {
                    // Return cached asset immediately, revalidate in background
                    fetch(request).then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            caches.open(RUNTIME_STATIC_CACHE).then((cache) => {
                                cache.put(request, networkResponse.clone());
                            });
                        }
                    }).catch(() => { /* Network failed, cached response was already served */ });

                    return cachedResponse;
                }

                // Not in cache: fetch from network and cache
                return fetch(request).then((networkResponse) => {
                    if (!networkResponse || networkResponse.status !== 200 || networkResponse.type === 'opaque') {
                        return networkResponse;
                    }

                    const responseToCache = networkResponse.clone();
                    caches.open(RUNTIME_STATIC_CACHE).then((cache) => {
                        cache.put(request, responseToCache);
                    });

                    return networkResponse;
                }).catch(() => {
                    // Asset fetch failed and not cached
                    return new Response('', { status: 408, statusText: 'Asset Unavailable Offline' });
                });
            })
        );
        return;
    }

    // Default: Normal network fetch
    event.respondWith(fetch(request));
});

/**
 * Message Event: Client commands (e.g. skip waiting on update)
 */
self.addEventListener('message', (event) => {
    if (event.data && event.data.action === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});

/**
 * Push Notification Event
 */
self.addEventListener('push', (event) => {
    let data = {
        title: 'School Notice',
        body: 'You have a new update in the School Portal.',
        icon: './assets/images/icons/icon-192x192.png',
        badge: './assets/images/icons/icon-72x72.png',
        url: './dashboard'
    };

    if (event.data) {
        try {
            data = Object.assign(data, event.data.json());
        } catch (e) {
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: data.icon,
        badge: data.badge,
        data: { url: data.url },
        vibrate: [100, 50, 100],
        actions: [
            { action: 'open_url', title: 'Open Portal' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

/**
 * Notification Click Event
 */
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const targetUrl = event.notification.data && event.notification.data.url
        ? event.notification.data.url
        : './dashboard';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url.includes(targetUrl) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
