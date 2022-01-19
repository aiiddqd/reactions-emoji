import { writable } from 'svelte/store';

export let config = writable({}, function start(set) {
    let _config = {
        'baseRestApi': 'https://bizzapps.ru/wp-json/',
        'endpoint': 'reem/v1/update',
    };
    set(_config);

});
