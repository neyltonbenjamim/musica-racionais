self.addEventListener('install',function(event){
	self.skipWaiting();
	console.log('Instalando...');
	console.log(event);
	event.waitUntil(
		caches.open('v7').then(function(cache) {
			return cache.addAll([
					'./',
					'./index.php',
					'./background.jpg',
					'./main.js',
					'./style.css',
					'./manifest.json'
				]);
			})
		);
});

self.addEventListener('activate', function(event){
	console.log('Ativando...');
	console.log(event);
});

self.addEventListener('fetch',function(event){
	// console.log(event);
});