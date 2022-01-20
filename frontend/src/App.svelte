<script>
	import { onMount } from 'svelte';
	import { config, _reactionsData } from './stores.js';
	import { remoteRequest } from './helper';

	let emojiList = [];
	let id;
	_reactionsData.subscribe((value) => {
		// console.log(value);
		emojiList = value.emojiList;
		id = value.id;
	});

	onMount(() => {
		let url = getRequestUrlById(id);
		
		remoteRequest(url).then(value => {
			// console.log();
			let list = value.json.meta;
			Object.keys(list).forEach(key => {
				// console.log(key, list[key]);
				emojiList.forEach((element, index) => {
					if(element.id == key){
						emojiList[index].count = list[key];
					}
					// console.log(index, element);

				});
			});
			// console.log(emojiList);
		});
	});

	function getRequestUrlById(id){
		let url = $config.baseRestApi + $config.endpoint;
		return url + id;
	}

	function handleClick(e){
		let data = {
			"action": e.target.dataset.action
		};

		let url = getRequestUrlById(id);

		console.log(url, data);
		let args = {
			'method': 'POST',
			"body": JSON.stringify(data)
		};

		remoteRequest(url, args).then(value => {
			console.log(value);
			let list = value.json.meta;
			Object.keys(list).forEach(key => {
				// console.log(key, list[key]);
				emojiList.forEach((element, index) => {
					if(element.id == key){
						emojiList[index].count = list[key];
					}
					// console.log(index, element);

				});
			});
		});
	}
</script>

<div class="reactions-emoji-app">
	{#each emojiList as item}
		<button data-action="{item.id}" on:click={handleClick}>
		<span class="reactions-emoji-app--char">{item.char}</span>
		{#if item.count}
		<span class="reactions-emoji-app--count">{item.count}</span>
		{/if}
		</button>
	{/each}

</div>

<style>
	button {
		background: transparent;
		border: none;
	}
</style>