import { writable } from 'svelte/store';

export let config = writable({}, function start(set) {
    let _config = {
        'baseRestApi': 'https://dev.local/wp-json/',
        'endpoint': 'reem/v1/reactions/',
    };
    set(_config);

});

export let _reactionsData = writable({}, function start(set) {

    if(typeof reactionsData === "undefined"){
        let list = {
            'id': 5,
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
        set(list);
    } else {
        set(reactionsData);
    }
});
