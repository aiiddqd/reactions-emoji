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

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use Exception;
use WP_Error;
use Throwable;

CONST META_KEY = 'reactions_emoji';

add_action('plugin_loaded', function(){
    add_shortcode('reactions-emoji', function(){

        $content = '<div class="reactions-emoji"></div>';
        return $content;
    });

    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\assets');

    add_action('rest_api_init', function(){

        register_rest_route( 'reem/v1', '/reactions/(?P<post_id>\d+)', [
            [
                'methods'             => 'GET',
                'callback'            => __NAMESPACE__ . '\get_reactions',
                'permission_callback' => '__return_true',
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback'            => __NAMESPACE__ . '\update_reactions',
                'permission_callback' => '__return_true',
            ]
        ]);
    
    });

});

/**
 * example https://dev.local/wp-json/reem/v1/reactions/5
 */
function get_reactions(WP_REST_Request $request){

        try {
        if( ! $post_id = (int)$request->get_param( 'post_id' )){
            throw new Exception( "no way )" );
        }
        if( ! $post = get_post($post_id)){
            throw new Exception( "no way )" );
        }
    
        
        $data = [];
        $data['success'] = true;
        $data['meta'] = [];
        $data['id'] = $post_id;

        if($meta = get_post_meta($post->ID, META_KEY, true)){
            $data['meta'] = $meta;
        }
        // var_dump($meta); exit;
        
        return new WP_REST_Response( $data, 200 );
    } catch( Throwable $e ) {
        return new WP_Error( "rest_error", 'no way' );
    }
}

function update_reactions(WP_REST_Request $request){

    try {
        if( ! $post_id = (int)$request->get_param( 'post_id' )){
            throw new Exception( "no way )" );
        }
        if( ! $post = get_post($post_id)){
            throw new Exception( "no way )" );
        }
    
        $value = $request->get_json_params();

        update_post_meta($post->ID, META_KEY, $value);
        $data = [];
        $data['success'] = true;
        $data['meta'] = $value;
        $data['id'] = $post_id;
    
        return new WP_REST_Response( $data, 200 );
    } catch( Throwable $e ) {
        return new WP_Error( "rest_error", 'no way' );
    }


}

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

