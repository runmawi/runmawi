const CACHE_NAME = 'runmawi-auth-v1';
const ASSETS_TO_CACHE = [
  '/assets/css/bootstrap.min.css',
  '/assets/css/style.css',
  '/assets/img/lan/inst.webp',
  '/assets/img/lan/twitter-x.webp',
  '/assets/img/lan/fb.webp',
  '/assets/img/lan/youtube.webp',
  // Add other critical assets here
];

// Install service worker and cache assets
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(ASSETS_TO_CACHE))
  );
});

// Serve cached content when offline
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});

// Clean up old caches
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
