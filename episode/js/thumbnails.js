$(document).ready(function(){
  var videoslug = $("#videoslug").val();
  // alert(videoslug);
  if(videoslug != '0'){
    var base_url = $("#base_url").val();
    var src = base_url+"/storage/app/public/"+videoslug+".gif";
  }
  videojs.getPlayer('Player').ready(function() {
    var myPlayer = this;
    var thumb_data = {
      "0": {
        "src": src,
        "width": 120
      },
    };
    myPlayer.thumbnails(thumb_data);
  });
});

