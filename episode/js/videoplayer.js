// alert($( "#logo_path" ).val());
// console.log($( "#logo_path" ).val());
var watermark_logo = $( "#logo_path" ).val();
// console.log();(watermark_logo);

$(document).ready(function(){
  videojs.getPlayer('Player').ready(function() {
    var myPlayer = this;
    
    myPlayer.watermark({
      file: watermark_logo,
      xpos: 0,
      ypos: 0,
      xrepeat: 0,
      opacity: 0.5,
    });
    
  });
  });
  

