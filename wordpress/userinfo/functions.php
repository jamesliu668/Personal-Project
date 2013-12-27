<?php

/*****************************
 * add following code in your theme functions.php
 */
function user_info_plugin() {
    $wp_root_path = str_replace('/wp-content/themes', '', get_theme_root());
    require_once($wp_root_path."/wp-content/plugins/userinfo/userInfoUpdate.php");
}
add_action( 'wp_loaded', 'user_info_plugin' );


function user_info_update_widgets() {
    $wp_root_path = str_replace('/wp-content/themes', '', get_theme_root());
    require_once($wp_root_path."/wp-content/plugins/userinfo/userInfoUpdateAdmin.php");
}

add_action( 'admin_menu', 'user_info_update_widgets' );

?>