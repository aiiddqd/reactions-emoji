<?php
/*
 * Plugin Name: Reactions Emoji
 * Description: Use emoji and reactions with your content on WordPress sites by shortcode [reactions-emoji]
 * GitHub Plugin URI: https://github.com/uptimizt/reactions-emoji
 * Primary Branch: main
 * Version: 1.0.5
 */


namespace ReactionsEmoji\Init;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use Exception;
use WP_Error;
use Throwable;

const META_KEY = 'reactions_emoji';
const REST_NAMESPACE = 'reem/v1';
const REST_ENDPOINT = '/reactions/';

add_action('plugin_loaded', function () {
    add_shortcode('reactions-emoji', function ($atts) {

        if( ! $post = get_post()){
            return 'no post';
        }

        $data = [
            'id' => $post->ID,
            'meta' => json_encode(get_meta($post->ID)),
        ];

        $content = sprintf('<div class="reactions-emoji" data-id=%s data-meta=%s></div>', $data['id'], '\'' . $data['meta'] . '\'');
        return $content;
    });

    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\assets');

    add_action('rest_api_init', function () {
        register_rest_route('reem/v1', '/reactions/(?P<post_id>\d+)', [
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

    // add_action('init', __NAMESPACE__ . '\allow_cors');
});

function allow_cors(){
    var_dump(wp_get_environment_type()); exit;
    if(wp_get_environment_type() != "local"){
        return;
    }

    header("Access-Control-Allow-Origin: *");
}

/**
 * example https://dev.local/wp-json/reem/v1/reactions/5
 */
function get_reactions(WP_REST_Request $request)
{
    try {
        if (!$post_id = (int)$request->get_param('post_id')) {
            throw new Exception("no way )");
        }
        if (!$post = get_post($post_id)) {
            throw new Exception("no way )");
        }


        $data = [];
        $data['success'] = true;
        $data['meta'] = [];
        $data['id'] = $post_id;

        if ( $meta = get_meta($post->ID) ) {
            $data['meta'] = $meta;
        }

        return new WP_REST_Response($data, 200);
    } catch (Throwable $e) {
        return new WP_Error("rest_error", 'no way');
    }
}

function get_meta($post_id){
    $meta = get_post_meta($post_id, META_KEY, true);
    $list = get_emojies_list();

    if(empty($meta)){
        $meta = [];
        foreach($list as $key => $item){
            $meta[$item['id']] = 0;
        }
    } 
    
    return $meta;
}

function update_reactions(WP_REST_Request $request)
{

    try {
        if (!$post_id = (int)$request->get_param('post_id')) {
            throw new Exception("no way )");
        }
        if (!$post = get_post($post_id)) {
            throw new Exception("no way )");
        }

        $value = $request->get_json_params();
        if(empty($value['action'])){
            throw new Exception("no way )");
        }

        $action = $value['action'];

        $meta = get_post_meta($post->ID, META_KEY, true);
        if( ! is_array($meta)){
            $meta = [];
        }
        if(empty((int)$meta[$action])){
            $meta[$action] = 0;
        }
        $meta[$action]++;
        update_post_meta($post->ID, META_KEY, $meta);
        $data = [];
        $data['success'] = true;
        $data['meta'] = $meta;
        $data['id'] = $post_id;

        return new WP_REST_Response($data, 200);
    } catch (Throwable $e) {
        return new WP_Error("rest_error", 'no way');
    }
}

function assets()
{

    
    $file_path = '/frontend/public/build/bundle.js';
    $file_path_abs = __DIR__ . $file_path;
    $file_url = plugins_url($file_path, __FILE__);

    wp_enqueue_script('reactions-emoji', $file_url, [], filemtime($file_path_abs), true);

    $file_path = '/frontend/public/build/bundle.css';
    $file_path_abs = __DIR__ . $file_path;
    $file_url = plugins_url($file_path, __FILE__);
    wp_enqueue_style( 'reactions-emoji-style', $file_url, [], filemtime($file_path_abs) );


    $data = [
        'restBaseUrl' => rest_url(REST_NAMESPACE . REST_ENDPOINT),
        'emojiList' => get_emojies_list(),
    ];

    wp_localize_script( 'reactions-emoji', 'reactionsData', $data);

}

function get_emojies_list()
{
    $list = [
        ['id' => 'like', 'char' => '👍'],
        ['id' => 'hahaha', 'char' => '😂'],
        ['id' => 'rocket', 'char' => '🚀'],
        ['id' => 'sad', 'char' => '😐'],
        ['id' => 'dislike', 'char' => '👎']
    ];

    $list = apply_filters('reem_list', $list);

    return $list;
}
