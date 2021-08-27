<!DOCTYPE html>  
<html>  
<head>  
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
    <title>Live Streaming Player</title>  
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
    <script src="js/videojs-ie8.min.js"></script>  
    <script src='js/video.js'></script>  
    <script src="js/videojs-flash.js"></script>  
    <script src="js/videojs-contrib-hls.js"></script>  
	<script src="assets/videojs-watermark/dist/videojs-watermark.js"></script>
  	<script src="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.js"></script>
</head>  
<body style="margin:0;padding:0;">  
    <div>  
     <!-- test/playlist.m3u8 -->
        <video id="video" class="video-js vjs-default-skin vjs-big-play-centered" controls data-setup='{"controls": true, "autoplay": true, "aspectRatio":"16:9", "fluid": true, "playbackRates": [0.5, 1, 1.5, 2]}' src="https://stream.infinitivehost.net/live/_360/index.m3u8" type="application/x-mpegURL" autobuffer preload>
            <source src="https://stream.infinitivehost.net/live/_360/index.m3u8" type='application/x-mpegURL' label='360p' res='360' />
            <source src="https://stream.infinitivehost.net/live/_480/index.m3u8" type='application/x-mpegURL' label='480p' res='480'/>
            <source src="https://stream.infinitivehost.net/live/_720/index.m3u8" type='application/x-mpegURL' label='720p' res='720'/>
        </video>  
    </div>  
    <script type="text/javascript">
         videojs('video').videoJsResolutionSwitcher();
		 videojs('video', {},function(){
		  var player = this;
		  window.player = player
		  player.watermark({
			image: 'assets/logo/te.png',
			fadeTime: null,
			url: 'https://www.thinkexam.com/'
		  });
		});
  
    </script>	
</body>  
</html>
