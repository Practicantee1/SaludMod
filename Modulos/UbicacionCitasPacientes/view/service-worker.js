// service-worker.js
self.addEventListener('install', (event) => {
    self.skipWaiting();
  });
  
  self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
  });
  
  self.addEventListener('fetch', (event) => {
    // Añadir headers de seguridad para solicitudes multimedia
    if (event.request.destination === 'video' || 
        event.request.url.includes('getUserMedia')) {
      event.respondWith(
        fetch(event.request).then(response => {
          const newHeaders = new Headers(response.headers);
          newHeaders.set('Access-Control-Allow-Origin', '*');
          newHeaders.set('Access-Control-Allow-Methods', 'GET, POST');
  
          return new Response(response.body, {
            status: response.status,
            statusText: response.statusText,
            headers: newHeaders
          });
        })
      );
    }
  });