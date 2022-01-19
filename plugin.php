<?php 
/*
 * Plugin Name: Reactions Emoji
 * Version:     1.0.0
 * @link https://unicode.org/emoji/charts/full-emoji-list.html
 * @link https://twemoji.twitter.com/ 
 * @link https://www.wired.com/2016/02/facebook-reactions-totally-redesigned-like-button/
 * @link https://svelte.dev/repl/c28366e7572444bd83f5cb265f941d42?version=3.31.0
 * @link https://github.com/iamcal/emoji-data
 * @link https://projects.iamcal.com/emoji-data/table.htm
 */


namespace ReactionsEmoji\Init;

add_action('plugin_loaded', function(){
    add_shortcode('reactions-emoji', function(){

        $content = '<div class="reactions-emoji"></div>';
        return $content;
    });

    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\assets');
});

function assets(){

    $file_path = '/frontend/public/build/bundle.js';
    $file_path_abs = __DIR__ . $file_path;
    $file_url = plugins_url($file_path, __FILE__);

    wp_enqueue_script('reactions-emoji', $file_url, [], filemtime($file_path_abs), true);

}

function get_emojies_list(){
    $list = [
        "smile" => "😃",
        "hahaha" => "😂",
        "sad" => "😐"
    ];

    return $list;
}

