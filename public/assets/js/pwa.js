/**
 * Progressive Web App Client Module
 * Application: Laravel School Management System (Nepal Edition)
 */

(function () {
    'use strict';

    var deferredInstallPrompt = null;
    var newWorkerWaiting = null;
    var isSubmittingForm = false;

    // Detect if user is currently submitting a form or making a transaction
    document.addEventListener('submit', function () {
        isSubmittingForm = true;
        setTimeout(function () {
            isSubmittingForm = false;
        }, 15000);
    }, true);

    /**
     * 1. Service Worker Registration & Lifecycle
     */
    function registerServiceWorker() {
        if (!('serviceWorker' in navigator)) {
            return;
        }

        // Determine base path for sw.js (supports subdirectories)
        var swPath = window.PWA_SW_PATH || './sw.js';

        navigator.serviceWorker.register(swPath, { scope: './' })
            .then(function (registration) {
                console.log('[PWA] Service Worker registered with scope:', registration.scope);

                // Check for updates
                registration.addEventListener('updatefound', function () {
                    var installingWorker = registration.installing;
                    if (!installingWorker) return;

                    installingWorker.addEventListener('statechange', function () {
                        if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            newWorkerWaiting = installingWorker;
                            showUpdateNotification();
                        }
                    });
                });

                if (registration.waiting && navigator.serviceWorker.controller) {
                    newWorkerWaiting = registration.waiting;
                    showUpdateNotification();
                }
            })
            .catch(function (error) {
                console.warn('[PWA] Service Worker registration failed:', error);
            });

        // Handle controller change (reloads after skipWaiting only if safe)
        var refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', function () {
            if (refreshing || isSubmittingForm) return;
            refreshing = true;
            window.location.reload();
        });
    }

    /**
     * 2. App Update Notification
     */
    function showUpdateNotification() {
        var banner = document.getElementById('pwa-update-banner');
        if (!banner) {
            banner = document.createElement('div');
            banner.id = 'pwa-update-banner';
            banner.innerHTML = '<span>' + (window.PWA_I18N_UPDATE || 'New version available!') + '</span>' +
                '<button type="button" id="pwa-update-btn">' + (window.PWA_I18N_UPDATE_BTN || 'Update Now') + '</button>';
            document.body.appendChild(banner);

            document.getElementById('pwa-update-btn').addEventListener('click', function () {
                if (isSubmittingForm) {
                    alert('Please wait until your current action completes before updating.');
                    return;
                }
                if (newWorkerWaiting) {
                    newWorkerWaiting.postMessage({ action: 'SKIP_WAITING' });
                }
            });
        }
        banner.style.display = 'flex';
    }

    /**
     * 3. Installation Flow & Banner
     */
    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredInstallPrompt = e;

        // Check if user dismissed prompt recently (7 days cooldown)
        var dismissedUntil = localStorage.getItem('pwa_install_dismissed_until');
        if (dismissedUntil && parseInt(dismissedUntil, 10) > Date.now()) {
            return;
        }

        showInstallBanner();
    });

    function showInstallBanner() {
        var banner = document.getElementById('pwa-install-banner');
        if (!banner) {
            banner = document.createElement('div');
            banner.id = 'pwa-install-banner';
            var iconSrc = window.PWA_ICON_PATH || './assets/images/icons/icon-192x192.png';
            var appName = window.PWA_APP_NAME || 'School Management System';

            banner.innerHTML =
                '<img src="' + iconSrc + '" alt="App Icon" class="pwa-banner-icon">' +
                '<div class="pwa-banner-content">' +
                '  <div class="pwa-banner-title">' + appName + '</div>' +
                '  <p class="pwa-banner-desc">' + (window.PWA_I18N_INSTALL_DESC || 'Install school portal for quick offline access') + '</p>' +
                '</div>' +
                '<div class="pwa-banner-actions">' +
                '  <button type="button" class="pwa-btn-install" id="pwa-btn-trigger-install">' + (window.PWA_I18N_INSTALL_BTN || 'Install') + '</button>' +
                '  <button type="button" class="pwa-btn-close" id="pwa-btn-dismiss-install" title="Dismiss">&times;</button>' +
                '</div>';
            document.body.appendChild(banner);

            document.getElementById('pwa-btn-trigger-install').addEventListener('click', triggerInstallPrompt);
            document.getElementById('pwa-btn-dismiss-install').addEventListener('click', dismissInstallBanner);
        }
        banner.style.display = 'flex';
    }

    function triggerInstallPrompt() {
        if (!deferredInstallPrompt) return;

        deferredInstallPrompt.prompt();
        deferredInstallPrompt.userChoice.then(function (choiceResult) {
            if (choiceResult.outcome === 'accepted') {
                console.log('[PWA] User accepted the install prompt');
            } else {
                console.log('[PWA] User dismissed the install prompt');
                // Cooldown 7 days
                localStorage.setItem('pwa_install_dismissed_until', Date.now() + (7 * 24 * 60 * 60 * 1000));
            }
            deferredInstallPrompt = null;
            var banner = document.getElementById('pwa-install-banner');
            if (banner) banner.style.display = 'none';
        });
    }

    function dismissInstallBanner() {
        var banner = document.getElementById('pwa-install-banner');
        if (banner) banner.style.display = 'none';
        // Cooldown 7 days
        localStorage.setItem('pwa_install_dismissed_until', Date.now() + (7 * 24 * 60 * 60 * 1000));
    }

    window.addEventListener('appinstalled', function () {
        console.log('[PWA] App successfully installed');
        var banner = document.getElementById('pwa-install-banner');
        if (banner) banner.style.display = 'none';
        localStorage.setItem('pwa_is_installed', 'true');
    });

    /**
     * 4. Connectivity Indicators
     */
    function updateOnlineStatus() {
        var indicator = document.getElementById('pwa-offline-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'pwa-offline-indicator';
            document.body.appendChild(indicator);
        }

        if (navigator.onLine) {
            if (indicator.style.display === 'block') {
                indicator.className = 'online-restored';
                indicator.textContent = '● ' + (window.PWA_I18N_ONLINE || 'Connection Restored');
                setTimeout(function () {
                    indicator.style.display = 'none';
                    indicator.className = '';
                }, 3000);
            }
        } else {
            indicator.className = '';
            indicator.textContent = '● ' + (window.PWA_I18N_OFFLINE || 'Offline Mode - Live actions require connection');
            indicator.style.display = 'block';
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    /**
     * 5. Push Notifications Client Manager
     */
    window.PwaPush = {
        isSupported: function () {
            return ('serviceWorker' in navigator) && ('PushManager' in window);
        },
        subscribe: function (publicKey, subscribeUrl) {
            if (!this.isSupported()) {
                return Promise.reject(new Error('Push notifications not supported on this browser.'));
            }

            return navigator.serviceWorker.ready.then(function (reg) {
                var convertedKey = urlBase64ToUint8Array(publicKey);
                return reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: convertedKey
                });
            }).then(function (subscription) {
                var csrf = document.querySelector('meta[name="csrf-token"]') ?
                    document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

                return fetch(subscribeUrl || './pwa/push/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(subscription)
                }).then(function (res) { return res.json(); });
            });
        },
        unsubscribe: function (unsubscribeUrl) {
            if (!this.isSupported()) return Promise.resolve();

            return navigator.serviceWorker.ready.then(function (reg) {
                return reg.pushManager.getSubscription();
            }).then(function (sub) {
                if (!sub) return Promise.resolve();

                var endpoint = sub.endpoint;
                return sub.unsubscribe().then(function () {
                    var csrf = document.querySelector('meta[name="csrf-token"]') ?
                        document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

                    return fetch(unsubscribeUrl || './pwa/push/unsubscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ endpoint: endpoint })
                    });
                });
            });
        }
    };

    function urlBase64ToUint8Array(base64String) {
        var padding = '='.repeat((4 - base64String.length % 4) % 4);
        var base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        var rawData = window.atob(base64);
        var outputArray = new Uint8Array(rawData.length);
        for (var i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    /**
     * 6. Offline Attendance Drafts Module (Privacy & Session Isolated)
     */
    function purgeAllAttendanceDrafts() {
        for (var i = localStorage.length - 1; i >= 0; i--) {
            var key = localStorage.key(i);
            if (key && (key.indexOf('lav_sms_att_') === 0 || key === 'lav_sms_attendance_drafts')) {
                localStorage.removeItem(key);
            }
        }
    }

    function enforceUserSessionIsolation() {
        var currentUserId = window.PWA_USER_ID ? String(window.PWA_USER_ID) : null;
        var lastKnownUser = localStorage.getItem('lav_sms_active_uid');

        if (lastKnownUser !== currentUserId) {
            purgeAllAttendanceDrafts();
            if (currentUserId) {
                localStorage.setItem('lav_sms_active_uid', currentUserId);
            } else {
                localStorage.removeItem('lav_sms_active_uid');
            }
        }
    }

    // Purge drafts on explicit logout click or logout form submission
    document.addEventListener('click', function (e) {
        var target = e.target && e.target.closest ? e.target.closest('a[href*="logout"]') : null;
        if (target) {
            purgeAllAttendanceDrafts();
        }
    });

    document.addEventListener('submit', function (e) {
        if (e.target && (e.target.id === 'logout-form' || (e.target.action && e.target.action.indexOf('logout') !== -1))) {
            purgeAllAttendanceDrafts();
        }
    });

    window.PwaAttendance = {
        getStorageKey: function () {
            var userId = window.PWA_USER_ID;
            return userId ? 'lav_sms_att_drafts_uid_' + userId : null;
        },
        saveDraft: function (classId, sectionId, dateBs, records) {
            var storageKey = this.getStorageKey();
            if (!storageKey) {
                console.warn('[PWA Attendance] Draft saving skipped: Unauthenticated user.');
                return null;
            }

            // Data minimization: Store ONLY student IDs and validated status codes ('P','A','L','H')
            var sanitizedRecords = {};
            if (typeof records === 'object' && records !== null) {
                for (var stId in records) {
                    if (Object.prototype.hasOwnProperty.call(records, stId) && /^\d+$/.test(stId)) {
                        var status = String(records[stId]).trim().toUpperCase();
                        if (['P', 'A', 'L', 'H'].indexOf(status) !== -1) {
                            sanitizedRecords[parseInt(stId, 10)] = status;
                        }
                    }
                }
            }

            var drafts = this.getDrafts();
            var draftKey = classId + '_' + sectionId + '_' + dateBs;
            drafts[draftKey] = {
                draft_id: 'draft_' + Date.now() + '_' + Math.random().toString(36).substr(2, 6),
                class_id: parseInt(classId, 10),
                section_id: parseInt(sectionId, 10),
                date_bs: String(dateBs).trim(),
                records: sanitizedRecords,
                saved_at: new Date().toISOString(),
                sync_status: 'draft'
            };
            localStorage.setItem(storageKey, JSON.stringify(drafts));
            return draftKey;
        },
        getDrafts: function () {
            var storageKey = this.getStorageKey();
            if (!storageKey) return {};

            try {
                return JSON.parse(localStorage.getItem(storageKey)) || {};
            } catch (e) {
                return {};
            }
        },
        clearDraft: function (draftKey) {
            var storageKey = this.getStorageKey();
            if (!storageKey) return;

            var drafts = this.getDrafts();
            delete drafts[draftKey];
            localStorage.setItem(storageKey, JSON.stringify(drafts));
        },
        purgeAll: purgeAllAttendanceDrafts
    };

    // Run session isolation check immediately
    enforceUserSessionIsolation();

    // Initialize on DOM load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', registerServiceWorker);
    } else {
        registerServiceWorker();
    }
})();
