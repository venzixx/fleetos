// ─────────────────────────────────────────────
//  FleetOS Service Worker
//  Handles: caching, offline fallback, push notifications
// ─────────────────────────────────────────────

const CACHE_NAME     = 'fleetos-v1';
const OFFLINE_URL    = '/offline';

// Assets to pre-cache on install
// Assets to try pre-caching on install
const PRECACHE_URLS = [
    '/',
    '/dashboard',
    '/offline',
    '/manifest.json',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
];

// ── INSTALL ──────────────────────────────────
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            // Individual adds — one 404 won't kill the whole SW install
            return Promise.allSettled(
                PRECACHE_URLS.map(url =>
                    cache.add(url).catch(err =>
                        console.warn('[FleetOS SW] Could not pre-cache:', url, err)
                    )
                )
            );
        })
    );
    self.skipWaiting();
});

// ── ACTIVATE ─────────────────────────────────
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            )
        )
    );
    // Take control of all open clients immediately
    self.clients.claim();
});

// ── FETCH ─────────────────────────────────────
// Strategy:
//   POST requests (status updates, role changes) → always network only
//   Navigation (HTML pages)                      → network first, fallback to cache/offline
//   Static assets (fonts, icons)                 → cache first
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // 1. Skip non-GET (POST forms, AJAX status updates) — let them go straight to network
    if (request.method !== 'GET') return;

    // 2. Skip browser-extension / chrome-extension requests
    if (!url.protocol.startsWith('http')) return;

    // 3. HTML navigation — network first, fallback to offline page
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then(response => {
                    // Clone and cache a fresh copy
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(c => c.put(request, clone));
                    return response;
                })
                .catch(() =>
                    caches.match(request).then(cached => cached || caches.match(OFFLINE_URL))
                )
        );
        return;
    }

    // 4. Static assets — cache first, then network
    event.respondWith(
        caches.match(request).then(cached => {
            if (cached) return cached;
            return fetch(request).then(response => {
                if (response.ok) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(c => c.put(request, clone));
                }
                return response;
            });
        })
    );
});

// ── PUSH NOTIFICATIONS ───────────────────────
self.addEventListener('push', event => {
    let data = {
        title: 'FleetOS',
        body:  'You have a new update.',
        icon:  '/icons/icon-192.png',
        badge: '/icons/icon-72.png',
        url:   '/dashboard',
    };

    // The server sends JSON like: { title, body, url }
    if (event.data) {
        try {
            const payload = event.data.json();
            data = { ...data, ...payload };
        } catch (e) {
            data.body = event.data.text();
        }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body:    data.body,
            icon:    data.icon,
            badge:   data.badge,
            vibrate: [200, 100, 200],
            data:    { url: data.url },
            actions: [
                { action: 'open',    title: '📲 Open App' },
                { action: 'dismiss', title: 'Dismiss'     },
            ],
        })
    );
});

// ── NOTIFICATION CLICK ───────────────────────
self.addEventListener('notificationclick', event => {
    event.notification.close();

    if (event.action === 'dismiss') return;

    const targetUrl = event.notification.data?.url || '/dashboard';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(windowClients => {
            // If app is already open, focus it
            for (const client of windowClients) {
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.focus();
                    client.navigate(targetUrl);
                    return;
                }
            }
            // Otherwise open a new window
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});

// ── BACKGROUND SYNC (future GPS) ─────────────
// Registered from the client via: navigator.serviceWorker.ready.then(sw => sw.sync.register('sync-status'))
self.addEventListener('sync', event => {
    if (event.tag === 'sync-status') {
        event.waitUntil(syncPendingStatus());
    }
});

async function syncPendingStatus() {
    // Placeholder — will read from IndexedDB and POST queued status updates
    // when connectivity is restored. Hook this up when you add GPS tracking.
    console.log('[FleetOS SW] Background sync triggered: sync-status');
}