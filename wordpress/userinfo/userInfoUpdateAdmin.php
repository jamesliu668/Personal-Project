<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	define('ROOT_PATH', plugin_dir_path(__FILE__));

	if ( !is_user_logged_in() ) {
		//this plugin is only for logged in user
		return;
	}
	
	checkInstall();
	
	global $current_user;
	get_currentuserinfo();
	
	//update option if there is
	if(!empty($_POST['isUpdatePredefineUser'])
		&& !empty($_SERVER["HTTP_REFERER"])
		&& !empty($_POST["token"]))
	{
		$securityToken = md5($current_user->user_login.$current_user->ID);
		if($_POST["token"] == $securityToken)
		{
			update_option( 'isUpdatePredefineUser', $_POST['isUpdatePredefineUser'] );
		}
	}

	add_submenu_page( 'users.php', "Force Email Update", "Force Email Update", 'manage_options', 'userinfoupdate-menu-handle', 'userInfoUpdateWidget');
	//add turn on/off widget on dashboard
	/*
	wp_add_dashboard_widget(
		'user_info_update',         // Widget slug.
		'User Info Change',         // Title.
		'userInfoUpdateWidget'			// Display function.
	);
	*/
?>


<?php
	function checkInstall() {
		$version = get_option( 'userInfoUpdateVersion', '0');
		if($version == "0")
		{
			//install db
			global $wpdb;
			$table_name = "User_UpdateList";
			
			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			  `userid` INT NOT NULL COMMENT 'from wordpress' ,
			  `isEmailUpdated` TINYINT NOT NULL ,
			  `isPasswordUpdated` TINYINT NOT NULL ,
			  PRIMARY KEY (`userid`) )
			ENGINE = InnoDB";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			update_option( "userInfoUpdateVersion", "1.0" );
		}
	}
	
	function userInfoUpdateWidget() {
		global $current_user;
		
		//check state
		if(get_option( 'isUpdatePredefineUser', 'off') == 'off') {
			$onState = "";
			$offState = "checked";
		} else {
			$onState = "checked";
			$offState = "";
		}
		
		$actionURL = get_admin_url()."users.php?page=userinfoupdate-menu-handle";
		$securityToken = md5($current_user->user_login.$current_user->ID);
		
		echo "<h2>Force Predefined User to Update Email and Password</h2>
		<p>Set \"on\" to enable predefined users to update their email and password when they log in at first time!</p><form action=\"$actionURL\" method=\"POST\"><div style=\"padding: 0 0 16px 0;\">Changing Predefined User Info</div>
		<div style=\"margin: 0 0 10px 0; height: 20px;\">
			<div style=\"float: left;\"><input style=\"margin: 0px 5px 0 0;\" type=\"radio\" name=\"isUpdatePredefineUser\" value=\"on\" id=\"isOnYes\" $onState/><label for=\"isOnYes\">On</label></div>
			<div style=\"float: left; margin: 0px 0 0 50px;\"><input style=\"margin: 0px 5px 0 0;\" type=\"radio\" name=\"isUpdatePredefineUser\" value=\"off\" id=\"isOnNo\" $offState/><label for=\"isOnNo\">Off</label></div>
		</div>
		<div>
			<input type=\"hidden\" value=\"$securityToken\" name=\"token\"/>
			<input type=\"submit\" value=\"Submit\" class=\"button button-primary\"/>
		</div>
		</form>";
	}
?>