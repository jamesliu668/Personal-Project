<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	define('ROOT_PATH', plugin_dir_path(__FILE__));

	if ( !is_user_logged_in() ) {
		//this plugin is only for logged in user
		return;
	}
	
	global $current_user;
	get_currentuserinfo();
	
	//update user info if there is
	if(!empty($_POST['userinfo_email'])
		&& !empty($_POST['userinfo_pass'])
		&& !empty($_POST['userinfo_repass'])
		&& !empty($_SERVER["HTTP_REFERER"])
		&& !empty($_POST["token"]))
	{
		$securityToken = md5($current_user->user_login.$current_user->ID);
		if($_POST["token"] == $securityToken && $_POST['userinfo_pass'] == $_POST['userinfo_repass'])
		{
			updateUserInfo($_POST['userinfo_email'], $_POST['userinfo_pass']);
		}
	}
	else if(!empty($_POST['userinfo_email']) && !empty($_POST["token"]) && !empty($_POST["action"]) && $_POST["action"] == 'checkemail')
	{
		$securityToken = md5($current_user->user_login.$current_user->ID);
		if($_POST["token"] == $securityToken)
		{
			echo checkEmail($_POST['userinfo_email']) ? "true" : "false";
			exit();
		}
	}
	else
	{
		$optionState = get_option( 'isUpdatePredefineUser', 'off');
		if($optionState == "on") {
			showHTML();
		}
	}
?>


<?php
	function showHTML() {
		global $current_user;
		$userRole = ($current_user->data->wp_capabilities);
		//only for subscriber role
		if(in_array("subscriber", $current_user->roles))
		{
			//check db if the user is updated his information
			if(empty($current_user->user_email)) {
				require_once(ROOT_PATH . "model/UserInfoUpdateDTO.php");
				require_once(ROOT_PATH . "model/UserInfoUpdateDAO.php");
				$userDAO = new UserInfoUpdateDAO();
				$userDTO = $userDAO->getItemByItemID($current_user->ID);
				if($userDTO == false || $userDTO->isEmailUpdated == 0 || $userDTO->isPasswordUpdated == 0) {
					$securityToken = md5($current_user->user_login.$current_user->ID);
					require_once(ROOT_PATH."htmlTemplate.php");
				}
			}
		}
	}
	
	function updateUserInfo($email, $pass) {
		global $current_user;
		$currentUserID = $current_user->ID;
		
		if(checkEmail($email))
		{
			echo "<script language=\"javascript\" type=\"text/javascript\">alert(\"Your email already exists, please change another email address!\");window.location.href=\"". curPageURL() ."\"</script>";
		}
		else
		{
			//update password
			wp_set_password($pass, $current_user->ID);
			
			//update user email
			wp_update_user( array ( 'ID' => $current_user->ID, 'user_email' => $email ) ) ;
			
			require_once(ROOT_PATH . "model/UserInfoUpdateDTO.php");
			require_once(ROOT_PATH . "model/UserInfoUpdateDAO.php");
			$userDAO = new UserInfoUpdateDAO();
			$userDTO = $userDAO->getItemByItemID($current_user->ID);
			if($userDTO == false) {
				$userDTO = new UserInfoUpdateDTO();
				$userDTO->userid = $current_user->ID;
				$userDTO->isEmailUpdated = 1;
				$userDTO->isPasswordUpdated = 1;
				$userDAO->add($userDTO);
			} else {
				$userDTO->isEmailUpdated = 1;
				$userDTO->isPasswordUpdated = 1;
				$userDAO->update($userDTO);
			}
			
			wp_set_auth_cookie( $currentUserID, true);
			echo "<script language=\"javascript\" type=\"text/javascript\">alert(\"Your information is updated successfully!\");window.location.href=\"". curPageURL() ."\"</script>";
		}
	}
	
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function checkEmail($email) {
		$args = array(
			'search'         => $email,
			'search_columns' => array( 'user_email' ),
		);
		$user_query = new WP_User_Query( $args );
		//if 1 or more, the email already exists
		if($user_query->total_users > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>