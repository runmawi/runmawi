// alert($( "#logo_path" ).val());
// console.log($( "#logo_path" ).val());
var watermark_logo = $( "#logo_path" ).val();
var player = videojs('video',{
  // autoplay : 'muted',
    controls : true,
    // poster :'https://picsum.photos/750/450',
    loop: true,
    fluid : true,
    
    // aspecRatio : '4:3',
    playbackRates:[0.25,0.5,1,1.5,2.0,2.5,3,3.5,4],
 


    plugins:{
        hotkeys : {
        // enableModifiersForNumbers : false,
        // seekStep : 05,
        },
 
        // videoJsResolutionSwitcher: {
        //   default: 'high',
        //   dynamicLabel: true
        }
  
  });
player.watermark({
  file: watermark_logo,
  xpos: 0,
  ypos: 0,
  xrepeat: 0,
  opacity: 0.5,
  
});

