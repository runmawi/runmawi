<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- video js -->
    

    <link href="assets/video.js/dist/video-js.min.css" rel="stylesheet">
	<link href="assets/videojs-watermark/dist/videojs-watermark.css" rel="stylesheet">
  	<link href="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" /> -->
    <link href="css/videojs.thumbnails.css" rel="stylesheet">
    <!-- <link href="https://vjs.zencdn.net/7.3.0/video-js.min.css" rel="stylesheet"> -->
    <?php 
// echo "<pre>";
// print_r($playerui_settings->watermark);
// exit();

    if($playerui_settings->thumbnail == 1){  ?>
       <link rel="stylesheet" type="text/css" href="https://players.brightcove.net/videojs-thumbnails/videojs.thumbnails.css">

     <?php } else{
            } ?>
    <link rel="stylesheet" href="css/videojs-seek-buttons.css">
    <!-- <link rel="stylesheet" href="css/videojs-watermark.css"> -->
<?php 
// echo "<pre>";
// print_r($playerui_settings);
// exit();
    if($playerui_settings->watermark == 1){ 
         ?>
    <!-- <link rel="stylesheet" href="css/videojs.watermark.css"> -->
    <style>
        /* .vjs-watermark img {
    width: 10%;
    float: right;
    position: absolute;
    top: 50%;
    right: 0px;
    transform: translate(-50%, 0%);
} */
          .vjs-watermark img {
              
    width: <?php echo $playerui_settings->watermar_width; ?>;
    float: right;
    position: absolute;
    top:<?php echo $playerui_settings->watermark_top; ?>;
    right: <?php echo $playerui_settings->watermark_right; ?>;
    left:<?php echo $playerui_settings->watermark_left; ?>;
    bottom:<?php echo $playerui_settings->watermark_bottom; ?>;
    transform: translate(-50%, 0%);
}

              </style>
       
<?php } else{
            } ?>
    <link rel="stylesheet" href="css/video.css">
    <!-- <link rel="stylesheet" href="css/video-quality-selector.css"> -->
    

    <link href="assets/video.js/dist/video-js.min.css" rel="stylesheet">
	<link href="assets/videojs-watermark/dist/videojs-watermark.css" rel="stylesheet">
  	<link href="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">
		.video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
		.video-js .vjs-watermark-top-right {right: 5%;top: 50%;}
		.video-js .vjs-watermark-content {opacity: 0.3;}
		.vjs-menu-button-popup .vjs-menu {width: auto;}
	</style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script src="js/videojs-ie8.min.js"></script>  
    <script src='js/video.js'></script>  
    <script src="js/videojs-flash.js"></script>  
    <script src="js/videojs-contrib-hls.js"></script>  
	<script src="assets/videojs-watermark/dist/videojs-watermark.js"></script>
  	<script src="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.js"></script>

        <!-- <script src="js/videoplayer.js"></script> -->

    <!-- <script src="/dist/videojs-preview-thumbnails.js"></script> -->

<!-- old scr cdn -->

       <!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
 <?php 
    if($playerui_settings->thumbnail == 1){  ?>
             <script src="https://players.brightcove.net/videojs-thumbnails/videojs.thumbnails.js"></script>
            <script src="js/thumbnails.js"></script>
     <?php } else{
            } ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

