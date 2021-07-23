<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- video js -->
    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
    <link href="css/videojs.thumbnails.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.3.0/video-js.min.css" rel="stylesheet">
    <?php 
// echo "<pre>";
// print_r($playerui_settings);
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
    <link rel="stylesheet" href="css/video-quality-selector.css">
    




    <!-- <script src="/dist/videojs-preview-thumbnails.js"></script> -->

<!-- old scr cdn -->

       <!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
 
</head>

<body class="hold-transition sidebar-mini layout-fixed">

