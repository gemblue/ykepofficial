// Import Workbox-sw
importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');
if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}

// Cache images and fonts
workbox.routing.registerRoute(
  /\.(?:png|gif|jpg|jpeg|svg|woff2)$/,
  new workbox.strategies.CacheFirst()
);

workbox.routing.registerRoute(
  new RegExp('\\.js$'),
  new workbox.strategies.StaleWhileRevalidate()
);

workbox.routing.registerRoute(
  new RegExp('\\.css$'),
  new workbox.strategies.StaleWhileRevalidate()
);

workbox.routing.registerRoute(
  new RegExp('/api/'),
  new workbox.strategies.StaleWhileRevalidate()
);

workbox.routing.registerRoute(
  new RegExp('/courses/'),
  new workbox.strategies.StaleWhileRevalidate()
);

// Menyimpan cache untuk file font selama 1 tahun
// workbox.routing.registerRoute(
//   /^https:\/\/fonts\.gstatic\.com/,
//   workbox.strategies.cacheFirst({
//     cacheName: 'google-fonts-webfonts',
//     plugins: [
//       new workbox.cacheableResponse.CacheableResponsePlugin({
//         statuses: [0, 200],
//       }),
//       new workbox.cacheableResponse.ExpirationPlugin({
//         maxAgeSeconds: 60 * 60 * 24 * 365,
//         maxEntries: 30,
//       }),
//     ],
//   })
// );


workbox.routing.registerRoute(
  /^https:\/\/api\.codepolitan\.com\/course/,
  new workbox.strategies.StaleWhileRevalidate()
);

workbox.precaching.precacheAndRoute([
  {url:'/', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
	{url:'/home', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/library', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/achievement', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/courses', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/paths', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/intcoding', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/webinar', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/evaluation', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/discussion', revision:'1'},
]);
workbox.precaching.precacheAndRoute([
  {url:'/earnings', revision:'1'},
]);