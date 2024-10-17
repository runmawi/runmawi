<?php

	$DEVELOPMENT = 0; //0 for online mode, 1 for development mode
	$url_host = "https://" . $_SERVER['HTTP_HOST'] . "/producer";
	$url_host_full = "https://" . $_SERVER['HTTP_HOST'] . "/producer/";
	
	
	if($DEVELOPMENT){
		$url_host = "http://" . $_SERVER['HTTP_HOST'] . "/runmawi/producer";
		$url_host_full = "http://" . $_SERVER['HTTP_HOST'] . "/runmawi/producer?";
	}
	
	/*Set number of items to be show per page*/
	$ITEMS_PER_PAGE = 5;
?>