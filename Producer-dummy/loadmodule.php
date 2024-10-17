<?php	
	require "required/session.php";
	require "required/mysqlconnect.php";
	
	$id = $_POST["id"];
	$param1 = $_POST["param1"];
	
	$filename = "home.php";
	switch($id){
		case "login": $filename = "required/login.php"; break;
		
		
		default: $filename = "home.php"; break;
	}
	
	$filename = "page/" . $filename;
	
	if(file_exists($filename))
		require $filename;
	else
		require "errorpage.php";
?>
