import App from './App.svelte';

let items = document.querySelectorAll('.reactions-emoji');


items.forEach(el => {
	let id = el.getAttribute('data-id');
	let meta = JSON.parse(el.getAttribute('data-meta'));


	new App({
		target: el,
		props: {
			id: id,
			meta: meta,
		}
	});
});
