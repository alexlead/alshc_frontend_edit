<?php 

if (!defined('ABSPATH')) exit;

//add admin styles for plugin
wp_enqueue_style('alshc-admin-style') ;

?>
<h2> WP FRONTEND EDITOR: MANUAL</h2>
<br />
<p> Create a page for Frontend Editor.</p>
<p> Put below shortcode on the created page: </p>
<p> [alshc_post_editor] </p>
<p> Select the created page on below form. </p>
<p> Set roles capabilities on below table, turn on capability on "WP editor use" column. If a user has not capability then he will not have access to the Editor.</p>
<p> Let you make settings on below forms. </p>
<br />
<h2> WP FRONTEND EDITOR: SETTINGS</h2>
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
	<h3>SET EDITOR PAGE</h3>
	<p>Select the page with Editor shortcode</p>
	<p>If you choose incorrect page then you can not edit to posts.</p>
	
		<?php
			$pages_args = array(
				'selected'         => get_option('alshc_page_shortcode'),
				'name'             => 'alshc_page_id'
			);

		wp_dropdown_pages($pages_args);
		?>
	<br />
	</div>
	<h3>ROLES CAPABILITIES FOR EDITOR USE</h3>
		<p>Pleas set capabilities on below table. Frontend editor is vissible for users with the capability of "WP editor use".</p>
		<p>ATTENTION! If user`s role has not a capability to edit to others posts, the user can not edit other posts too.</p>
	<div class="table">
		<div class="row">
			<div class="cell"> ROLES </div>
			<div class="cell"> WP editor use </div>
			<div class="cell"> PUBLISHING </div>
			<div class="cell"> EDIT POST </div>
			<div class="cell"> EDIT TO PUBLISHED POSTS </div>
			<div class="cell"> EDIT TO OTHERS POSTS </div>
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
		echo $role['name'];
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
	<input type="submit" value="SAVE">
</form>
</div>