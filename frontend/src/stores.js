import { writable } from 'svelte/store';


export let _reactionsData = writable({}, function start(set) {

    if(typeof reactionsData === "undefined"){
        let data = {
            'restBaseUrl': "https://dev.local/wp-json/reem/v1/reactions/",
            'emojiList': [
                {
                    "id": "like",
                    "char": "👍",
                },
                {
                    "id": "hahaha",
                    "char": "😂"
                },
                {
                    "id": "rocket",
                    "char": "🚀"
                },
                {
                    "id": "sad",
                    "char": "😐"
                },
                {
                    "id": "dislike",
                    "char": "👎"
                }
            ]
        };
        set(data);
    } else {
        set(reactionsData);
    }
});
