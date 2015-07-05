<?php
/*
Plugin Name: WP Post Actions
Plugin URI: https://github.com/systemo-biz/wp-post-actions
Description: Actions for posts in WordPress
Version: 20150703
Author: Systemo
Author URI: http://systemo.biz
License: MIT
*/

include 'inc/delete.php';
include 'inc/fav.php';

//загружаем шаблон из папки, если обнаружен параметр view=cover
function add_actions_s($content) {
    //$post = get_post();
    ob_start();
    ?>

        <div class="post_actions_s">
            <?php do_action( 'add_action_for_post_s', $post->ID); ?> 
        </div>

    <?php
    $html = ob_get_contents(); //упаковка вывода в переменную
    ob_end_clean(); //очистка вывода
    return $content . $html;
} 
add_filter( 'the_content', 'add_actions_s', 11111);
add_filter( 'the_excerpt', 'add_actions_s', 11111);
