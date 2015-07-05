<?php


class WP_Post_Actions_Delete_Singleton {

    private static $_instance = null;
    private function __construct() {
        add_action('add_action_for_post_s', array($this, 'print_delete_callback'));
        add_action('template_redirect', array($this, 'run_actions'));
    }
    
    function run_actions(){
        
        if(isset($_REQUEST['site_action'])) $site_action = $_REQUEST['site_action'];
        if(isset($_REQUEST['post_id'])) $post_id = $_REQUEST['post_id'];
        
        if($site_action == 'delete' and $post_id) {
            wp_update_post( array('post_status' => 'trash', 'ID' => $post_id) );
            
            global $wp;
            $url_wp_redirect = add_query_arg( array('site_action' => null, 'post_id' => null), home_url($wp->request)  );
            
            wp_redirect( $url_wp_redirect );
            exit;

        }
    }


    function print_delete_callback($post_id){
        global $wp;
        $post = get_post();

        $url_action = add_query_arg( array('site_action' => 'delete', 'post_id' => $post->ID), home_url($wp->request)  );
        
        ?>
            <a class="btn btn-default" href="<?php echo $url_action ?>">Удалить</a>
        <?php
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
    
} $WP_Post_Actions_Delete = WP_Post_Actions_Delete_Singleton::getInstance();