<style>
.vjs-seek-to-live-control {
            display: none !important;
        }
.vjs-picture-in-picture-control{
            display: none !important;
        }
</style>
<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="//googleads.github.io/videojs-ima/node_modules/videojs-contrib-ads/dist/videojs.ads.min.js"></script>
    <script src="//googleads.github.io/videojs-ima/dist/videojs.ima.js"></script>
   <!-- video js -->
   <!-- <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script> -->
        <!-- <script src="https://cdn.sc.gl/videojs-hotkeys/0.2/videojs.hotkeys.min.js"></script> -->
        <!-- <script src='js/videojs.thumbnails.js'></script> -->
      <!-- <script type="text/javascript" src="js/videojs-contrib-hls.min.js"></script> -->
        <!-- <script type="text/javascript" src="js/videojs-contrib-hls.js"></script> -->
          <!-- <script src="js/forward.js"></script> -->
  	<!-- <script src="assets/videojs-resolution-switcher/lib/videojs-resolution-switcher.js"></script> -->

          <?php 
    if($playerui_settings->thumbnail == 1){  ?>
             <!-- <script src="https://players.brightcove.net/videojs-thumbnails/videojs.thumbnails.js"></script>
            <script src="js/thumbnails.js"></script> -->
     <?php } else{ } ?>
          <script src="js/seekbutton.js"></script>

     <?php 
    if($playerui_settings->watermark == 1){  ?>
             <script src="js/watermark.js"></script>
                <script type="text/javascript" src="js/videojs-watermark.min.js"></script>

     <?php } else{ } ?>
    <script src="js/videojs-contrib-hls.js"></script>  

     <script type="text/javascript" src="js/videoplayer.js"></script>

            <!-- <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script> -->
            <!-- <script src="js/videojs-contrib-quality-levels.js"></script> -->

            
   
            <script src="js/video-quality-selector.js"></script>

            <!-- <script src="js/videojs-seek.min.js"></script> -->

            <script src="js/videojs-seek.js"></script>  

       

</body>
</html>
