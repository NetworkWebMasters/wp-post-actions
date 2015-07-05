# WP Post Actions

# Description

add_action('add_action_for_post_s', 'add_action_for_post_s_callback');

function add_action_for_post_s_callback(){
    ?>
        <span>Тут действие</span>
    <?php
}