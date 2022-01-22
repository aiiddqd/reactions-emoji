# reactions-emoji


## manual add


## auto add

```
add_filter("the_content", function($content){
    if ( ! is_singular('post')) {
        return $content;
    }

    ob_start();
    echo do_shortcode('[reactions-emoji]');

    $html = ob_get_clean();
    return $content . $html;
}, 8);
```
