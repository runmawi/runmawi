<?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
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
// print_r($playerui_settings->watermark);
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/videojs-ie8.min.js"></script>  
    <script src='js/video.js'></script>  
    
    <?php 
    if($playerui_settings->thumbnail == 1){  ?>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript" src = "jquery-2.1.1.min.js"></script>

<script src="https://players.brightcove.net/videojs-thumbnails/videojs.thumbnails.js"></script>
     <script src="js/thumbnails.js"></script>
     <?php } else{
            } ?>
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo  $playerui_settings->watermark_logo ;?>">      
<?php 
    if($playerui_settings->watermark == 1){  
        // dd($playerui_settings->watermark)
        ?>     
                <script type="text/javascript" src="js/videojs-watermark.min.js"></script>
                <script src="js/watermark.js"></script>
                <script src="js/videoplayer.js"></script>

     <?php } else{
            } ?>
            <script>

                
            </script>
    <script src="js/videojs-flash.js"></script>  
    <script src="js/videojs-contrib-hls.js"></script>  
	<script src="assets/videojs-watermark/dist/videojs-watermark.js"></script>
  	<script src="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.js"></script>

        <!-- <script src="js/videoplayer.js"></script> -->

    <!-- <script src="/dist/videojs-preview-thumbnails.js"></script> -->


</head>

<body class="hold-transition sidebar-mini layout-fixed">

<style type="text/css">

    .video-js{height: 500px !important;}
    .video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
    .vjs-big-play-button{
    top: 50% !important;
    left: 50% !important;
    margin: -25px 0 0 -25px;
    width: 50px !important;
    height: 50px !important;
    border-radius: 25px !important;
    }
    .vjs-texttrack-settings { display: none; }
    .video-js .vjs-big-play-button{ border: none !important; }
        #video_container{height: auto;overflow: auto;padding: 15px 0 !important;width: 80%;margin: 0 auto;}
    /*    #video_bg_dim {background: #1a1b20;}*/
        .video-js .vjs-tech {outline: none;}

        .video-details{margin: 0 auto;padding-bottom: 30px;}
        .video-details h1{margin: 0 0 10px;color: #fff;}
        .vid-details{margin-bottom: 20px;}
        #tags{margin-bottom: 10px;}
        .share{display: flex;align-items: center;}
        .share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
        .share a{padding: 0 20px;}
        .cat-name span{margin-right: 10px;}


    </style>