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

class WP_Post_Actions_Singleton {

    private static $_instance = null;
    private function __construct() {
        add_filter( 'the_content', array($this, 'add_actions_s'));
    }

    //загружаем шаблон из папки, если обнаружен параметр view=cover
    function add_actions_s($content) {
        $post = get_post();
        ?>

            <div class="post_actions_s">
                <?php do_action( 'add_action_for_post_s', $post->ID); ?> 
            </div>

        <?php
        
        return $content;
    } 


    /**
     * Служебные функции одиночки
     */
    protected function __clone() {
        // ограничивает клонирование объекта
    }
    static public function getInstance() {
        if(is_null(self::$_instance))
        {
        self::$_instance = new self();
        }
        return self::$_instance;
    }    
    
} $WP_Post_Actions = WP_Post_Actions_Singleton::getInstance();