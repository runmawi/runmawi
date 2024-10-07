<?php
	//require "mysqlconnect.php";
	
	if(isset($_POST["id"])) $pageid = $_POST["id"];
	if(isset($_POST["param1"] ))$param1 = $_POST["param1"];
	$filename = "page/home.php";

	switch($pageid){
		case "formRegularEven": 
			$filename = "formRegularEven.php"; 
			break;	
		case "formRegularOdd": 
			$filename = "formRegularOdd.php"; 
			break;	
		case "formRepeaterEven": 
			$filename = "formRepeaterEven.php"; 
			break;	
		case "formRepeaterOdd": 
			$filename = "formRepeaterOdd.php"; 
			break;	
		case "pay": 
			$filename = "pay.php"; 
			break;	
		case "verify": 
			$filename = "verify.php"; 
			break;	
		case "invoice": 
			$filename = "page/invoice.php"; 
			break;	
		case "admin": 
			$filename = "page/admin.php"; 
			break;	
		default: $filename = "page/home.php"; break;
	}
	

	if(file_exists($filename))
		require $filename;
	else
		require "Error";
?>
