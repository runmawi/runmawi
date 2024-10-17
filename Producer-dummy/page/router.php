<?php
	//This module explode the url and extract page id and parameters
	
	$pageid = "home";
	$param1 = "";
	$param2 = "";
	$param3 = "";
	$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url_meta = $url;
	$arr = explode("?", $url);
	if(sizeof($arr) > 1){
		$pageid = $arr[1];
		$arr = explode("/", $pageid);
		if(sizeof($arr) >1){
			$pageid = $arr[0];
			$param1 = $arr[1];	
			if(sizeof($arr) >2){
				$param2 = $arr[2];
				if(sizeof($arr) >3)
					$param3 = $arr[3];
			}
		}
	}
	
	
	
	switch($pageid){
		case "login": $filename = "login.php"; break;
		case "stats": $filename = "stats.php"; break;
		case "stats_tvshow": $filename = "stats_tvshow.php"; break;
		case "stats_livestream": $filename = "stats_livestream.php"; break;
		case "changepassword": $filename = "profile.php"; break;
		
		default: $filename = "home.php"; break;
	}
	
	$filename = "page/" . $filename;
	
	if(!file_exists($filename))
		$filename =  "errorpage.php";
?>