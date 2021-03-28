<?php 

/**
 * Admin Options Page: editor for adding|updating posts  
 * 
 * @author: Alex Lead
 * @package: WP AL Frontend Editor 
 * @version: 1.0.2
 *   
 */

if (!defined('ABSPATH')) exit;

//add admin styles for plugin
wp_enqueue_style('alshc-admin-style') ;

?>
<h2><?php _e( 'WP FRONTEND EDITOR: MANUAL', 'alshc-frontent-editor' ); ?></h2>
<br />
<p> <?php _e( 'Create a page for Frontend Editor.', 'alshc-frontent-editor' ); ?></p>
<p> <?php _e( 'Put below shortcode on the created page:', 'alshc-frontent-editor' ); ?></p>
<p> [alshc_post_editor] </p>
<p> <?php _e( 'Select the created page on below form.', 'alshc-frontent-editor' ); ?></p>
<p> <?php _e( 'Set roles capabilities on below table, turn on capability on "WP editor use" column. If a user has not capability then he will not have access to the Editor.', 'alshc-frontent-editor' ); ?></p>
<p> <?php _e( 'Let you make settings on below forms.', 'alshc-frontent-editor' ); ?> </p>
<br />
<h2> <?php _e( 'WP FRONTEND EDITOR: SETTINGS', 'alshc-frontent-editor' ); ?></h2>
<br />
<div>
<form action="" method="post">
	<?php 
			// hidden fields;
			// hdden verification for post - random field  
			wp_nonce_field(); 
		?>
	<input type="hidden" name="alshc_options_set" value='set'>

	<div>
	<h3><?php _e( 'SET EDITOR PAGE', 'alshc-frontent-editor' ); ?></h3>
	<p><?php _e( 'Select the page with Editor shortcode', 'alshc-frontent-editor' ); ?></p>
	<p><?php _e( 'If you choose incorrect page then you can not edit to posts.', 'alshc-frontent-editor' ); ?></p>
	
		<?php
			$pages_args = array(
				'selected'         => get_option('alshc_page_shortcode'),
				'name'             => 'alshc_page_id'
			);

		wp_dropdown_pages($pages_args);
		?>
	<br />
	</div>
	<h3><?php _e( 'ROLES CAPABILITIES FOR EDITOR USE', 'alshc-frontent-editor' ); ?></h3>
		<p><?php _e( 'Please set capabilities on below table. Frontend editor is vissible for users with the capability of "WP editor use".', 'alshc-frontent-editor' ); ?></p>
		<p><?php _e( 'ATTENTION! If user`s role has not a capability to edit to others posts, the user can not edit other posts too.', 'alshc-frontent-editor' ); ?></p>
	<div class="table">
		<div class="row">
			<div class="cell"> <?php _e( 'ROLES', 'alshc-frontent-editor' ); ?> </div>
			<div class="cell"> <?php _e( 'WP editor use', 'alshc-frontent-editor' ); ?> </div>
			<div class="cell"> <?php _e( 'PUBLISHING', 'alshc-frontent-editor' ); ?> </div>
			<div class="cell"> <?php _e( 'EDIT POST', 'alshc-frontent-editor' ); ?> </div>
			<div class="cell"> <?php _e( 'EDIT TO PUBLISHED POSTS', 'alshc-frontent-editor' ); ?> </div>
			<div class="cell"> <?php _e( 'EDIT TO OTHERS POSTS', 'alshc-frontent-editor' ); ?> </div>
		</div>

<?php
   
    // get all user roles from DB
	$wp_roles			= new WP_Roles();
	$all_roles = $wp_roles->roles;

	// prepare form for every role 
	foreach($all_roles as $key=>$role){
	// ------ start foreach -----
	?>
		<div class="row">
			<div class="cell">
	<?php
		echo translate_user_role($role['name']);
	?>	
			</div>	
			<div class="cell"> 
			<input type="checkbox" name="<?php echo $role['name'];?>_alshc_editor_use" value="use" <?php if($role['capabilities']['alshc_editor_use']) {echo 'checked';};?>>
			</div>
			<div class="cell"> 
			<input type="checkbox" name="<?php echo $role['name'];?>_publish_posts" value="use"  <?php if($role['capabilities']['publish_posts']) {echo 'checked';};?> disabled>
			</div>
			<div class="cell"> 
			<input type="checkbox" name="<?php echo $role['name'];?>_edit_posts" value="use" <?php if ($role['capabilities']['edit_posts']) {echo 'checked';};?> disabled>
			</div>
			<div class="cell"> 
			<input type="checkbox" name="<?php echo $role['name'];?>_edit_published_posts" value="use" <?php if ($role['capabilities']['edit_published_posts']) {echo 'checked';};?> disabled>
			</div>
			<div class="cell"> 
			<input type="checkbox" name="<?php echo $role['name'];?>_edit_others_posts" value="use" <?php if ($role['capabilities']['edit_others_posts']) {echo 'checked';};?> disabled>
			</div>
		</div>
	<?php
	// ------ end foreach -----
	}
?>
	</div>
	<br />
	<br />
	<input type="submit" value="<?php _e( 'SAVE', 'alshc-frontent-editor' ); ?>">
</form>
</div>