<?php
	$currentURL = 'http';
	if (isset( $_SERVER["HTTPS"] ) && strtolower($_SERVER["HTTPS"]) == "on") {
		$currentURL .= "s";
	}
	$currentURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$currentURL .= $_SERVER['HTTP_HOST'].":".$_SERVER["SERVER_PORT"].dirname($_SERVER['PHP_SELF']).'/';
	} else {
		$currentURL .= $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
	}
	
	$homePage = $currentURL;
	$adminPage = $currentURL."RateManager.php";
	$loginPage = $currentURL."home.php";
?>