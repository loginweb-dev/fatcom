/*
 * @license
 * Your First PWA Codelab (https://g.co/codelabs/pwa)
 * Copyright 2019 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License
 */
'use strict';

// CODELAB: Update cache names any time any of the cached files change.
const CACHE_NAME = 'static-cache-v2';

// CODELAB: Add list of files to cache here.
const FILES_TO_CACHE = [
    '/',
    '/offline.html',
    '/img/offline.png',
    '/ecommerce_public/js/jquery-2.0.0.min.js',
    '/ecommerce_public/js/bootstrap.bundle.min.js',
    '/ecommerce_public/css/bootstrap.css',
    '/ecommerce_public/fonts/fontawesome/css/fontawesome-all.min.css',
    '/ecommerce_public/css/ui.css',
    '/ecommerce_public/css/responsive.css',
    '/ecommerce_public/js/script.js',
    '/ecommerce_public/css/toastr.min.css',
    '/ecommerce_public/js/toastr.min.js',
    '/ecommerce_public/plugins/fancybox/fancybox.min.js',
    '/ecommerce_public/plugins/fancybox/fancybox.min.css',
    '/ecommerce_public/plugins/owlcarousel/assets/owl.carousel.min.css',
    '/ecommerce_public/plugins/owlcarousel/assets/owl.theme.default.css',
    '/ecommerce_public/plugins/owlcarousel/owl.carousel.min.js',
    // Resoaurante V1
    'ecommerce_public/templates/restaurante_v1/css/bootstrap.min.css',
    'ecommerce_public/templates/restaurante_v1/css/mdb.min.css',
    'ecommerce_public/templates/restaurante_v1/css/style.css',
    'ecommerce_public/templates/restaurante_v1/js/jquery-3.4.1.min.js',
    'ecommerce_public/templates/restaurante_v1/js/popper.min.js',
    'ecommerce_public/templates/restaurante_v1/js/bootstrap.min.js',
    'ecommerce_public/templates/restaurante_v1/js/mdb.min.js',
    'ecommerce_public/plugins/snap/ohsnap.js',
];


self.addEventListener('install', (evt) => {
    // console.log('[ServiceWorker] Install');
    // CODELAB: Precache static resources here.
    evt.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
        //   console.log('[ServiceWorker] Pre-caching offline page');
          return cache.addAll(FILES_TO_CACHE);
        })
    );
  self.skipWaiting();
});

self.addEventListener('activate', (evt) => {
//   console.log('[ServiceWorker] Activate');
  // CODELAB: Remove previous cached data from disk.
  evt.waitUntil(
      caches.keys().then((keyList) => {
        return Promise.all(keyList.map((key) => {
          if (key !== CACHE_NAME) {
            console.log('[ServiceWorker] Removing old cache', key);
            return caches.delete(key);
          }
        }));
      })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (evt) => {
//   console.log('[ServiceWorker] Fetch', evt.request.url);
  // CODELAB: Add fetch event handler here.
    if (evt.request.mode !== 'navigate') {
      // Not a page navigation, bail.
      return;
    }
    evt.respondWith(
        fetch(evt.request)
            .catch(() => {
              return caches.open(CACHE_NAME)
                  .then((cache) => {
                    return cache.match('offline.html');
                  });
            })
    );
});
