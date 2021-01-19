<?php 

if (!defined('ABSPATH')) exit;

// function save changes in roles options to DB
function checkRolesCapabilities(){

    // save id of page with shortcode 
    if(isset($_POST['alshc_page_id'])){
        add_option('alshc_page_shortcode',$_POST['alshc_page_id']);
    }


    // get all user roles from DB
	$wp_roles = new WP_Roles();
	$all_roles = $wp_roles->roles;

    // capability to change
    $cap = 'alshc_editor_use'; 

	// prepare form for every role 
	foreach($all_roles as $key=>$role){
        $tmp_role = get_role($key);

        if(isset($_POST[$role['name'].'_alshc_editor_use'])&&$_POST[$role['name'].'_alshc_editor_use']=='use'){  
            $tmp_role->add_cap($cap ); 
        } else {
            $tmp_role->remove_cap($cap );
        }
    }

}

checkRolesCapabilities();