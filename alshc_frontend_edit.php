<?php

/**
 * Plugin Name: WP FRONTEND PUBLISH EDITOR
 * Description: Shortcode for adding system editor on frontend
 * Plugin URI: https://github.com/alexlead/alshc_frontend_edit
 * Version: 1.0.2
 * Author: Alexander Lead
 * Author URI: https://codepen.io/alexlead/
 * Requires at least: 4.8
 * Tested up to: 5.7
 * Text Domain: alshc-frontent-editor
 * Domain Path: /languages/
 *  
 **/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {	
	exit;
}

//define plugin paths
if ( ! defined( 'ALSHC_FE_EDITOR_PLUGIN_DIR' ) ) {

	define( 'ALSHC_FE_EDITOR_PLUGIN_DIR',  dirname( __FILE__ )  );

}

if ( ! defined( 'ALSHC_FE_EDITOR_PLUGIN_URL' ) ) {

    define( 'ALSHC_FE_EDITOR_PLUGIN_URL',  plugins_url( '', __FILE__ )  );

}


//---------------------- FRONTEND -------------------------

// register scripts for frontend
if( !function_exists( 'alshc_register_scripts' ) ) {

    function alshc_register_scripts(){
 
        wp_enqueue_script("alshc-script", ALSHC_FE_EDITOR_PLUGIN_URL.'/assets/js/script.js', array());
        
        // load Editor 
        wp_enqueue_script( "alshc_wpimage" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/wpimage.js");
        wp_enqueue_script( "alshc_underline" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/underline.js");
        wp_enqueue_script( "alshc_delimiter" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/delimiter.js");
        wp_enqueue_script( "alshc_embed" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/embed.js");
        wp_enqueue_script( "alshc_header" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/header.js");
        wp_enqueue_script( "alshc_image" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/image.js");
        wp_enqueue_script( "alshc_link" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/link.js");
        wp_enqueue_script( "alshc_list" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/list.js");
        wp_enqueue_script( "alshc_marker" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/marker.js");
        wp_enqueue_script( "alshc_paragraph" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/paragraph.js");
        wp_enqueue_script( "alshc_quote" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/quote.js");
        wp_enqueue_script( "alshc_htmltoeditjs" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/htmltoeditjs.js");
        wp_enqueue_script( "alshc_editor" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/editor.js");
        wp_enqueue_script( "alshc_edjsHTML" , ALSHC_FE_EDITOR_PLUGIN_URL."/assets/js/vendor/edjsHTML.browser.js");
        
    }
}

// getting empty editor form for shortcode
if( !function_exists( 'alshc_post_editor_new_post' ) ) {

    function alshc_post_editor_new_post(){

        // register style files
        wp_enqueue_style('alshc-style', ALSHC_FE_EDITOR_PLUGIN_URL.'/assets/css/style.css');

        // register js script files
        wp_enqueue_media ();
        alshc_register_scripts();

        // check if we need to save a post
        if(isset($_POST['alshc_post_save'])&&$_POST['alshc_post_save']=='post_save'){

            // verification of special hidden field
            if(wp_verify_nonce($_POST['_wpnonce'])){

                require (ALSHC_FE_EDITOR_PLUGIN_DIR.'/inc/alshc_post_save.php');

            }

        }

        // Check user capabilities
        if( current_user_can('alshc_editor_use') ){


            // open with editor form
            require (ALSHC_FE_EDITOR_PLUGIN_DIR.'/view/alshc_new_post_editor.php');

        };

    }

}

// SHORTCODE FOR EDITOR REGISTER
add_shortcode('alshc_post_editor', 'alshc_post_editor_new_post');


// change edit post link URL

if(!function_exists('alshc_post_edit_link')){
    function alshc_post_edit_link($link, $before, $after){
        
        // get post ID
        $post_id = get_the_ID();
        // get editor page from 
        $base_page = get_option('alshc_page_shortcode');

        $url = "/?page_id=".$base_page."&alshc=edit&alshc_id=".$post_id;
        return $url;
    }

}

add_filter('get_edit_post_link','alshc_post_edit_link', 10, 3);


// add edit link to posts
// @get function get content of a page
// @return content with additional link 
if( !function_exists( 'alshc_edit_post_link' ) ) {

    function alshc_edit_post_link($content){

        $res = $content;

        // check if content is part of feed, then do nothing
        if(!is_feed()){

            if(is_single()){

                // check if user has rights for editing pages
                if(current_user_can('alshc_editor_use')){

                    // get post id
                    $post_id = get_the_ID();

                    
                    // get page id with editor  
                    $base_page = get_option('alshc_page_shortcode');
                        

                    if($post_id!=$base_page||!is_page()){
                    
                        // check if user can edit to this post

                        $post_author = get_post( $post_id, 'ARRAY_A' );
                        $tmp_current_user = get_current_user_id();
                        if ( current_user_can('edit_others_posts') || $post_author['post_author'] == $tmp_current_user ) {
                            // prepare link
                            $res .= "<div class='alshc-edit alshc-edit-button'><a href='/?page_id=".$base_page."&alshc=edit&alshc_id=".$post_id."'>";
                            $res .= __( "Edit" , 'alshc-frontent-editor' );
                            $res .= "</a></div>";
                            
                        }
                    }
                
                }
            
            }

        }
    
        return $res;
    
    }

}

// hook for adding post editing link
add_filter ('the_content', 'alshc_edit_post_link');

// add style to header for button
if( !function_exists( 'alshc_add_button_style' ) ) {

    function alshc_add_button_style(){

		wp_enqueue_style('alshc-button-style', ALSHC_FE_EDITOR_PLUGIN_URL.'/assets/css/button.css');
    }

}

add_action('wp_head', 'alshc_add_button_style');

//---------------------- ADMIN -------------------------

// Menu item function
// ADD menu item in admin panel
if( !function_exists( 'alshc_menu_config' ) ) {

    function alshc_menu_config(){
    
        add_menu_page( 'WP FRONTEND PUBLISH EDITOR', 'WP FRONTEND PUBLISH EDITOR', 'manage_options', 'alshc_editor_setting', 'alshc_editor_setting', 'dashicons-id-alt', 10);
        
    }
}
    
// getting empty editor form for shortcode
if( !function_exists( 'alshc_editor_setting' ) ) {

    function alshc_editor_setting(){

        //register style
        wp_register_style('alshc-admin-style', ALSHC_FE_EDITOR_PLUGIN_URL.'/assets/css/admin-style.css', array(), '1.0', 'all');
        
        //change capabilities if we need
        if(isset($_POST['alshc_options_set'])&&$_POST['alshc_options_set']=='set'){

            if(wp_verify_nonce($_POST['_wpnonce'])){
                
                include (ALSHC_FE_EDITOR_PLUGIN_DIR.'/inc/alshc_admin_save_options.php');

            }
        }

        // Check user capabilities
        if( current_user_can('manage_options') ){

            // open with editor form
            include (ALSHC_FE_EDITOR_PLUGIN_DIR.'/admin/alshc_user_setting.php');

        };

    }

}

if(is_admin()){

    // adding menu page in admin
    add_action('admin_menu', 'alshc_menu_config');

}

// add local file

add_action( 'plugins_loaded', 'alshc_language_files_init' );
function alshc_language_files_init(){
	load_plugin_textdomain( 'alshc-frontent-editor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

