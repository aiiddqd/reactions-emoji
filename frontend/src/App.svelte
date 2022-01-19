<script>
	import { config } from './stores.js';

	let emojies = [
		{ id: 'like', char: "👍" },
		{ id: 'dislike', char: "👎" },
		{ id: 'smile', char: "😂" },
	];


	config.subscribe((value) => {

		console.log(value);
	});
</script>

<div class="reactions-emoji-app">
	{#each emojies as item}
		<button>{item.char}</button>
	{/each}

</div>

<style>
	button {
		background: transparent;
		border: none;
	}
</style>