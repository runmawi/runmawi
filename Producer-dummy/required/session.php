<?php
	require "mysqlconnect.php";
	session_start();
	$sessionid = session_id();
	
	//login is a variable used to denote whether the user is logged in or not
	$login = 0;
	
	$runmawi_producer_userid = "";
	$runmawi_producer_username = "";
	
	//check if sesison exists
	if(isset($_SESSION['runmawi_producer_userid'])){
		$runmawi_producer_userid = $_SESSION['runmawi_producer_userid'];
		$runmawi_producer_username = $_SESSION['runmawi_producer_username'];
	}
	else{
		require "page/login.php";
		exit;
	}
?>
