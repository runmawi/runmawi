$(document).ready(function(){
  var videoslug = $("#videoslug").val();
  if(videoslug != '0'){
    var base_url = $("#base_url").val();
    var src = base_url+"/storage/app/public/"+videoslug+".gif";
  }
  videojs.getPlayer('videoPlayer').ready(function() {
    var player = this;
    var thumb_data = {
      "0": {
        "src": src,
        "width": 120
      },
    };

    player.thumbnails(thumb_data);
  });
});

