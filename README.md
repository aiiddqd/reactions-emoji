# Reactions wity Emoji, WordPress, SvelteJS

- roadmap https://github.com/uptimizt/reactions-emoji/issues/1
- concepts https://github.com/uptimizt/reactions-emoji/issues/2

# demo

url https://bizzapps.ru/b/gist/


<img width="930" alt="2022-01-22-16-40-52-s2q62" src="https://user-images.githubusercontent.com/1852897/150640765-3ce3f9d1-6d7c-4f19-bbb8-56215d8d253e.png">


## manual add

add shortcode to post `[reactions-emoji]`

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
