import App from './App.svelte';

let targetEl = document.querySelector('.reactions-emoji');
const app = new App({
	target: targetEl
});

export default app;