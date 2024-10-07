<?php
	require "required/mysqlconnect.php";
	require "required/config.php";
	
	if(isset($_POST['userid']) && isset($_POST['password'])){
		//Get parameters from form submit
		$userid = $_POST['userid'];
		$password = $_POST['password'];

		//First, check if the user's phone or email exist
		$status=1;
		
		if($status == 1){
			//Fech details of user for response
			$sql = "select id, username, phone, email from producers where (phone='$userid' or email='$userid') and password = '$password'";
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res) == 1){
				$row = mysqli_fetch_array($res);
				session_start();
				
				$_SESSION['runmawi_producer_userid'] = $row[0];
				$_SESSION['runmawi_producer_username'] = $row[1];
					
			}
		}
	}	
	header("location:$url_host");
?>