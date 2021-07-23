$(document).ready(function(){
videojs.getPlayer('videoPlayer').ready(function() {
    var player = this;

    player.thumbnails(thumb_data);
  });
});
  var thumb_data = {
      "0": {
          "src": "http://solutions.brightcove.com/bcls/assets/images/sea-lionfish-thumbnail.png",
          "width": 120
      },
    //   "29": {
    //       "src": "http://solutions.brightcove.com/bcls/assets/images/sea-anemone-thumbnail.png"
    //   },
    //   "54": {
    //       "src": "http://solutions.brightcove.com/bcls/assets/images/sea-clownfish-thumbnail.png"
    //   },
    //   "84": {
    //       "src": "http://solutions.brightcove.com/bcls/assets/images/sea-seahorse-thumbnail.png"
    //   },
    //   "114": {
    //       "src": "http://solutions.brightcove.com/bcls/assets/images/sea-crab-thumbnail.png"
    //   },
    //   "143": {
    //       "src": "http://solutions.brightcove.com/bcls/assets/images/sea-dolphins-thumbnail.png"
    //   }
  };