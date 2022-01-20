<script>
  import { onMount } from "svelte";
  import { _reactionsData } from "./stores.js";
  import { remoteRequest } from "./helper";

  let emojiList = [];
  export let id;
  export let meta;
  _reactionsData.subscribe((value) => {
    console.log(value);
    emojiList = value.emojiList;
    // id = value.id;
  });

  onMount(() => {
    // console.log(id, meta);
	renderCount(meta);
  });

  function renderCount(meta) {
    let list = meta;
    Object.keys(list).forEach((key) => {
      // console.log(key, list[key]);
      emojiList.forEach((element, index) => {
        if (element.id == key) {
          emojiList[index].count = list[key];
        }
        // console.log(index, element);
      });
    });
  }

  function getRequestUrlById(id) {
    let url = $_reactionsData.restBaseUrl;
    return url + id;
  }

  function handleClick(e) {
    let data = {
      action: e.target.getAttribute('data-action')
    };

	if(data.action == undefined){
		data.action = e.target.parentElement.getAttribute('data-action')
	}
    // console.log(data);

    let url = getRequestUrlById(id);

    let args = {
      method: "POST",
      body: JSON.stringify(data),
    };

    remoteRequest(url, args).then((value) => {
      console.log(value);
	  renderCount(value.json.meta);
	  
    });
  }
</script>

<div class="reactions-emoji-app">
  {#each emojiList as item}
    <button data-action={item.id} on:click|once={handleClick}>
      {item.char}
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
	z-index: 1;
  }

  .reactions-emoji-app--count {
	  z-index: -1;
  }
</style>
