<script>
	let emojies = [
		{ id: 'like', char: "👍" },
		{ id: 'dislike', char: "👎" },
		{ id: 'smile', char: "😂" },
	];
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