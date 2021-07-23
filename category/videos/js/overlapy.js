$(document).ready(function(){
    videojs.getPlayer('videoPlayer').ready(function() {
        var myPlayer = this;
    
        myPlayer.watermark(thumb_data);
      });
    });