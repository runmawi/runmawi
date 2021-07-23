// 
var secondvideo = document.getElementById('videoPlayer');
secondvideo.addEventListener('play', function(e) { 
    // The video is playing
    // alert('dfs');
    // console.log("Playing video");
    // console.log(secondvideo.currentTime);

});

secondvideo.addEventListener('pause', function(e) { 
    // The video is paused
    // console.log("Paused video");
    // console.log(secondvideo.currentTime);
});
secondvideo.addEventListener('seeking', function(e) { 
    // The user seeked a new timestamp in playback
    // console.log("Seeking in video");
    // console.log(secondvideo.currentTime);
});
var seekBarClickedTime;

// +++ Define the middleware function+++
var getSeekedTime = function(player) {
//   alert('sdfd');
    return {
    // +++ Set seek time in setCurrentTime method +++
    setCurrentTime: function setCurrentTime(ct) {
      seekBarClickedTime = ct;
      return ct;
    }
  };
};

// Register the middleware with the player
videojs.use("*", getSeekedTime);

// Initialize mouseup event on seekbar
$(document).ready(function(){
videojs.getPlayer("videoPlayer").ready(function() {
  var myPlayer = this;
  myPlayer.controlBar.progressControl.seekBar.on("mouseup", function(event) {
    displayTimesHere.innerHTML += seekBarClickedTime + "<br>";
  });
});
});


