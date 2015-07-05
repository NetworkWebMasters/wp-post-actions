<?php

//syndication_permalink

function print_url_btn_callback(){
    $post = get_post();
    
    $url = get_post_meta($post->ID, 'syndication_permalink', true);
    ?>
    <a href="<?php echo $url ?>" class="btn btn-default" target="_blank">Просмотреть</a>
    <?php
}        add_action('add_action_for_post_s', 'print_url_btn_callback');
