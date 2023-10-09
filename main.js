if('serviceWorker' in navigator){
	window.addEventListener('load',() =>{
		navigator.serviceWorker.register('./sw.js')
		.then(function(e){
			console.log('Registrando...');
			console.log(e);
		},function(e){
			console.log('Falha:');
			console.log(e);
		});
	});
}


window.addEventListener('load',function(){
	createIframe();
	document.querySelectorAll('.next-musica').forEach(function(e){
		e.addEventListener('click',function(event){
			event.preventDefault();
			let active = document.querySelector('.active');
			active.classList.remove('active');
			this.classList.add('active');
			next(this.getAttribute('data-id'));
			history.pushState({title: this.getAttribute('title')}, '?watch='+this.getAttribute('data-id'),'?watch='+this.getAttribute('data-id'));
			document.querySelector('.js_title').innerHTML = 'Ouvir Música - '+this.getAttribute('title');
			document.title = 'Ouvir Música - '+this.getAttribute('title');

			pegarLetra(this.getAttribute('data-id'),this.getAttribute('data-artista'),this.getAttribute('data-title'));
		})
	});

	document.querySelector('#js_artista').addEventListener('change', function(){
		location.href = location.origin+location.pathname+'?artista='+encodeURI(this.value);
	})
});

window.addEventListener('popstate', function (event) {
	$id = location.search.replace('?watch=','');
    next($id);
    let active = document.querySelector('.active');
	active.classList.remove('active');
	document.getElementById($id).classList.add('active');
	document.querySelector('.js_title').innerHTML = 'Ouvir Música - '+document.getElementById($id).getAttribute('data-title');
	document.title = 'Ouvir Música - '+document.getElementById($id).getAttribute('data-title');
	pegarLetra($id,document.getElementById($id).getAttribute('data-artista'),document.getElementById($id).getAttribute('data-title'));
});


let player;
// let id = '7l-tp7yyJaE';
let id = document.querySelector('.list > ul > li > a').getAttribute('data-id');
document.querySelector('.list > ul > li > a').classList.add('active');
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {

		videoId: id,
		width:'100%',
		height:'100%',
		playerVars : {
				'modestbranding': 1,
				'rel': 0,
				'autoplay' : 1,
				'iv_load_policy': 3,
				// 'cc_load_policy': 1,//legenda
				'egm':0,
				'showinfo':0,
				'enablejsapi':1,
				'fs':0,
				'color': 'white'
			},
		events:{
				'onReady': onPlayerReady,
				'onStateChange':onPlayerStateChange
			}
	});
}

function onPlayerReady(event)
{
	event.target.playVideo();
}

function onPlayerStateChange(event){
	if(event.data === 0){
		let active = document.querySelector('.active');
		let activeParent = active.parentElement;
		active.classList.remove('active');

		if(!!activeParent.nextElementSibling){
			let a = activeParent.nextElementSibling.querySelector('a');
			next(a.getAttribute('data-id'));
			a.classList.add('active');

			history.pushState({title: a.getAttribute('title')}, '?watch='+a.getAttribute('data-id'),'?watch='+a.getAttribute('data-id'));
			
			document.querySelector('.js_title').innerHTML = 'Ouvir Música - '+a.getAttribute('title');
			document.title = 'Ouvir Música - '+a.getAttribute('title');
			pegarLetra(a.getAttribute('data-id'),a.getAttribute('data-artista'),a.getAttribute('data-title'));
			return;
		}

		let activeFirst = document.querySelector('.list ul li a');
		next(activeFirst.getAttribute('data-id'));
		activeFirst.classList.add('active');

		history.pushState({title: activeFirst.getAttribute('title')}, '?watch='+activeFirst.getAttribute('data-id'),'?watch='+activeFirst.getAttribute('data-id'));
			
		document.querySelector('.js_title').innerHTML = 'Ouvir Música - '+activeFirst.getAttribute('title');
		document.title = 'Ouvir Música - '+activeFirst.getAttribute('title');
		pegarLetra(activeFirst.getAttribute('data-id'),activeFirst.getAttribute('data-artista'),activeFirst.getAttribute('data-title'));


	}
}

function createIframe(){
	
	let box = document.querySelector('.content-musica');
	box.style.backgroundImage = 'url(http://img.youtube.com/vi/'+id+'/mqdefault.jpg)';
	let tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    box.appendChild(tag);
}

function next(id)
{
	player.loadVideoById({'videoId': id});
}

window.addEventListener('DOMContentLoaded',() =>{
	setTimeout(function() {
		
		let options = {
			address : 'Endereco'		
		};
		console.log(options.age);
		let value = "Brasil, Bahia, Santa Maria da Vitória";
		
		let worker = new Worker('web-worker.js');
		
		worker.postMessage({
			'nome'				: 'Neylton',
			'sobrenome'			: 'Benjmaim',
			[options.address] 	: value
		});

	}, 5000);
});

function pegarLetra(id, artista, musica)
{
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'ajax.php');
	let formData = new FormData();
	formData.append('id',id);
	formData.append('artista',artista);
	formData.append('title',musica);
	xhr.addEventListener('load',function(){
		document.querySelector('.letra').innerHTML = this.response;
	})
	xhr.send(formData);
}


// let worker = new Worker('web-worker.js');
// worker.postMessage({data:document.querySelector('iframe')});