<?php
	require "required/config.php";
	session_start();
	unset($_SESSION["runmawi_producer_userid"]);
	unset($_SESSION["runmawi_producer_username"]);
	header("location:$url_host");
?>