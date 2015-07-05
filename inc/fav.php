<?php


class WP_Post_Actions_Fav_Singleton {

    private static $_instance = null;
    private function __construct() {
        add_action('add_action_for_post_s', array($this, 'print_btn_callback'));
        add_action('template_redirect', array($this, 'run_actions'));
        add_shortcode('select_fav', array($this, 'select_fav_cb'));
        add_action( 'pre_get_posts', array($this, 'pre_get_posts_callback'));

    }
    
    function pre_get_posts_callback( $query ) {
        if(! $query->is_main_query() ) return;
        
        if($_REQUEST['fav_s'] != '1') return;
        
        $user_id = get_current_user_id();
        
        //Get original meta query
		$meta_query = $query->get('meta_query');
        
		//Add our meta query to the original meta queries
		$meta_query[] = array(
		                    'key'=>'favorite',
		                    'value'=> $user_id,
		                );
        
		$query->set('meta_query', $meta_query);
        //var_dump($query);
        //exit;
        
        return;
    }

    function select_fav_cb($atts){
        global $wp;
        
        if($_REQUEST['fav_s'] == '1') {
            $url_action = add_query_arg('fav_s', null, home_url($wp->request));
            $url_text = "Показать все";
        } else {
            $url_action = add_query_arg('fav_s','1', home_url($wp->request));
            $url_text = "Показать отобранные";
        }

        ?>
            <div>
                <a href="<?php echo $url_action ?>"><?php echo $url_text; ?></a>
            </div>
        <?php
    }
    
    function run_actions(){
        
        if(isset($_REQUEST['site_action'])) $site_action = $_REQUEST['site_action'];
        if(isset($_REQUEST['post_id'])) $post_id = $_REQUEST['post_id'];
        
        $user_id = get_current_user_id();
        
        if($site_action == 'fav' and $post_id) {
            $fav_list = get_post_meta($post_id, 'favorite');
            if(in_array($user_id, $fav_list)) {
                delete_post_meta($post_id, 'favorite', $user_id);
            } else {
                add_post_meta($post_id, 'favorite', $user_id);
            }
            global $wp;
            $url_wp_redirect = add_query_arg( array('site_action' => null, 'post_id' => null), home_url($wp->request) );
            
            wp_redirect( $url_wp_redirect );
            exit;

        }
    }
    
    function print_btn_callback($post_id){
        global $wp;
        $post = get_post();

        $url_action = add_query_arg( array('site_action' => 'fav', 'post_id' => $post->ID), home_url($wp->request)  );
        $favorite_list = get_post_meta($post->ID, 'favorite');
        $user_id = get_current_user_id();
        
        if(in_array( $user_id, $favorite_list )){
            $btn_text = '<span class="glyphicon glyphicon-star"></span> Убрать из избранного';
        } else {
            $btn_text = '<span class="glyphicon glyphicon-star-empty"></span> Добавить в избранное';
        }
                
        ?>
            <a class="btn btn-default" href="<?php echo $url_action ?>"><?php echo $btn_text ?></a>
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
    
} $WP_Post_Actions_Fav = WP_Post_Actions_Fav_Singleton::getInstance();