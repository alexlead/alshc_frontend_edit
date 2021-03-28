<?php

/**
 * View: editor for adding|updating posts  
 * 
 * @author: Alex Lead
 * @package: WP AL Frontend Editor 
 * @version: 1.0.2
 * 
 */

if (!defined('ABSPATH')) exit;


// empty form for new post  
$post_edit['id'] = -1; 
$post_edit['author'] = get_current_user_id();
$post_edit['post_cat'] = 1;
$post_edit['post_tags'] = "";
$post_edit['post_title'] = "";
$post_edit['post_content'] = "";


// edit post form by link
if(isset($_GET['alshc_id'])&&isset($_GET['alshc'])&&$_GET['alshc']=='edit'){

	$current_post_id = $_GET['alshc_id'];

}

//return to post saved before
if (isset($alshc_post_save_res['id'])){

	$current_post_id = $alshc_post_save_res['id'];

}

$base_page = get_option('alshc_page_shortcode');

// get data from post 
if(isset($current_post_id)&&$current_post_id!=$base_page){

	$tmp_current_user = $post_edit['author']; // take current user id to check if you can edit to the post

	$post_edit['id'] = $current_post_id; // post id to edit
	$tmp_post = get_post( $post_edit['id'], 'ARRAY_A' ); // get post data from db - will be used for taken post author id
	$post_edit['author'] = $tmp_post['post_author']; // post author save - will not be changed after updating post

	// check if user have rights to edit to current post 
	if(current_user_can('edit_others_posts')||$post_edit['author']==$tmp_current_user){

		$tmp_tags = wp_get_post_tags($post_edit['id'],  array( 'fields' => 'names' )); // get post tags from db
		$tmp_cat_array = get_the_category($post_edit['id']); // get categories post data from db
		
		$post_edit['post_cat'] = $tmp_cat_array[0]->term_id; // post category will be taken only first category if there were more then one
		$post_edit['post_tags'] = implode(',', $tmp_tags); // tags from post will be turn to string
		$post_edit['post_title'] = $tmp_post['post_title']; // post title
		$post_edit['post_content'] = $tmp_post['post_content']; // post content

	} else {
		$post_edit['id'] = -1; 
		$post_edit['author'] = get_current_user_id();	
	}
	
}

?>

<div id='new-post-editor'>

<form action="" method="post">

<?php 
	// Current User Details 


	$current_user = wp_get_current_user();

	?>
	<div class='author-details'>
		<div class="user-avatar post-author-avatar">
			<a href="<?php echo esc_url( get_author_posts_url($current_user->ID) ); ?>"><?php echo get_avatar( $current_user->ID); ?></a>
		</div>
		<div class="user-name post-author-name">
			<a href="<?php echo esc_url( get_author_posts_url($current_user->ID)  ); ?>">
			<?php echo esc_html( $current_user->display_name ); ?>
			</a>
		</div>
		<div class='editor-button editor-submit-button'>
			<input type="submit" class="post-submit post-editor-button" value="<?php _e( 'SAVE', 'alshc-frontent-editor' ); ?>">
		</div>
	</div>	
		<?php 
			// hidden fields;
			// hdden verification for post - random field  
			wp_nonce_field(); 
		?>
		<input type="hidden" name="alshc_post_save" value="post_save">
		<input type="hidden" name="post_id" value="<?php echo $post_edit['id'];?>">
		<input type="hidden" name="post_author" value="<?php echo $post_edit['author'];?>">

	<div class='post-addons'>
		<div id='addons-field-main' class="post-addons-hidden">
			<?php
				// post categories list 
				wp_dropdown_categories(array(
						'show_option_all'    => '',
						'show_option_none'   => '',
						'option_none_value'  => -1,
						'orderby'            => 'ID',
						'order'              => 'ASC',
						'show_last_update'   => 0,
						'show_count'         => 0,
						'hide_empty'         => 0,
						'selected' => $post_edit['post_cat'],
						'hierarchical' => 3,
						'name' => 'post_category',
						'id' => 'categories',
						'class' => 'editor editor-post editor-post-name'	
					)); ?>

		<input type="text" class="editor editor-post editor-post-input" name="post_tags" placeholder="<?php _e( 'Put tags here - comma is for separation', 'alshc-frontent-editor' ); ?>" value="<?php echo $post_edit['post_tags'];?>">
		</div>
	</div>	
	
	<div class='post-editor post-main'>
		<input type="text" class="editor editor-post editor-post-input editor-post-input-title" name="post_title" placeholder="<?php _e( 'Title of post', 'alshc-frontent-editor' ); ?>" value="<?php echo $post_edit['post_title'];?>">

		<textarea name="post_content" id="cont" cols="30" rows="10"><?php echo esc_html($post_edit['post_content']);?></textarea>

	</div>

</form>

<?php
// Editor here
?>
<div id="editor"></div>

				</div>
