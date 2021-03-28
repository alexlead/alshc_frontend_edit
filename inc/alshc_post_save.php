<?php 

/**
 * Save data: editor for adding|updating posts  
 * 
 * @author: Alex Lead
 * @package: WP AL Frontend Editor 
 * @version: 1.0.2
 * 
 */

if (!defined('ABSPATH')) exit;

// @get $_POST from frontend editor form  
// @return array for post save to DB
function prepare_post(){
    $post_data = array(   
        // post default data array
        // post modifed date 
        'post_modified' => date('Y-m-d H:i:s'),
        // post comment status - default status
        'comment_status' => get_option('default_comment_status'),
        //post publishing status - set status 'published' as default
        'post_status' => 'publish'
    );

    // post ID setting - if post_id does not set @return NULL - for new post
    if(isset($_POST['post_id'])&&$_POST['post_id']>0){
        $post_data['ID'] = sanitize_key($_POST['post_id']);
    } else {
        $post_data['post_date'] = date('Y-m-d H:i:s');
    }

    // post author
    if (isset($_POST['post_author'])){
        $post_data['post_author'] = sanitize_text_field($_POST['post_author']);
    }
    // post title
    if (isset($_POST['post_title'])){
        $post_data['post_title'] = sanitize_text_field($_POST['post_title']);
    }
    // post category
    if (isset($_POST['post_category'])){
        $post_data['post_category'] = array(sanitize_key($_POST['post_category']));
    }
    // post tags - tags string 
    if (isset($_POST['post_tags'])){
        $post_data['tags_input'] = explode(',', sanitize_text_field($_POST['post_tags']));
    }
    // post content
    if (isset($_POST['post_content'])){
        $post_data['post_content'] = wp_kses_post($_POST['post_content']);
    }

    return $post_data;

}

// @action function save post data to DB
// @return array with post id and errors
function alshc_save_post(){
    // insert post to DB
    $result['id'] = wp_insert_post(prepare_post(), true);
    // add errors to array if isset
    if( is_wp_error( $result['id']) ){
        $result['error'] = $$result['id']->get_error_message();
    } 
    return $result;
}

$alshc_post_save_res = alshc_save_post();