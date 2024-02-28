
<?php 
    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
    $episode_id = $episode->id ; 
    $advertisement_id = $episode->episode_ads ; 
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();
?>

<script>

   let episode_ads = <?php echo json_encode( $episode_ads ); ?> ;

   document.addEventListener('DOMContentLoaded', () => { 

   const player = new Plyr('#videoPlayer',{

          controls: [   'play-large','restart','rewind','play','fast-forward','progress',
                       'current-time','mute','volume','captions','settings','pip','airplay',
                       'fullscreen'
                   ],

           ads:{ 
                 enabled: true, 
                 tagUrl: episode_ads 
           }
       });

             // Ads Views Count
        player.on('adsloaded', (event) => {
            Ads_Views_Count();
        });

            // Ads Redirection Count
        player.on('adsclick', (event) => {
            Ads_Redirection_URL_Count(event.timeStamp);
        });

   });


   document.addEventListener("DOMContentLoaded", () => {
       const video = document.querySelector("#video");
       const source = video.getElementsByTagName("source")[0].src;
 
       const defaultOptions = {};

       if (!Hls.isSupported()) {

           defaultOptions.ads = {
               enabled: true, 
               tagUrl: episode_ads
           }

           video.src = source;
           var player = new Plyr(video, defaultOptions);

               // Ads Views Count
            player.on('adsloaded', (event) => {
                Ads_Views_Count();
            });

                // Ads Redirection Count
            player.on('adsclick', (event) => {
                Ads_Redirection_URL_Count(event.timeStamp);
            });
       } 
       else
       {
           const hls = new Hls();
           hls.loadSource(source);
           
               hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
               const availableQualities = hls.levels.map((l) => l.height)
               availableQualities.unshift(0) 

               defaultOptions.quality = {
                   default: 0, //theme7 - AUTO
                   options: availableQualities,
                   forced: true,        
                   onChange: (e) => updateQuality(e),
       }

         // Add Auto Label 
           defaultOptions.i18n = {
               qualityLabel: { 0: 'Auto', },
           }

           defaultOptions.ads = {
               enabled: true, 
               tagUrl: episode_ads
           }

           hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
               var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
               if (hls.autoLevelEnabled) {
                   span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
               } else {
                   span.innerHTML = `AUTO`
               }
           })
     
           var player = new Plyr(video, defaultOptions);

               // Ads Views Count
            player.on('adsloaded', (event) => {
                Ads_Views_Count();
            });

                // Ads Redirection Count
            player.on('adsclick', (event) => {
                Ads_Redirection_URL_Count(event.timeStamp);
            });
     });	

       hls.attachMedia(video);
           window.hls = hls;		 
       }

       function updateQuality(newQuality) {
           if (newQuality === 0) {
           window.hls.currentLevel = -1;
           } else {
           window.hls.levels.forEach((level, levelIndex) => {
               if (level.height === newQuality) {
               console.log("Found quality match with " + newQuality);
               window.hls.currentLevel = levelIndex;
               }
           });
           }
       }
   });

   function Ads_Views_Count(){

        $.ajax({
              type:'get',
              url:'<?= route('Advertisement_Views_Count') ?>',
              data: {
                        "Count" : 1 , 
                        "source_type" : "Episode",
                        "source_id"   : "<?php echo $episode_id ?>",
                        "adverister_id" : "<?php echo $adverister_id ?>",
                        "adveristment_id" : "<?php echo $advertisement_id ?>",
                        "user" : "<?php echo $user ?>",
                  },
                  success:function(data) {
                }
          });
    }

     function Ads_Redirection_URL_Count(timestamp_time){

        $.ajax({
              type:'get',
              url:'<?= route('Advertisement_Redirection_URL_Count') ?>',
              data: {
                        "Count" : 1 , 
                        "source_type" : "Episode",
                        "source_id"   : "<?php echo $episode_id ?>",
                        "adverister_id" : "<?php echo $adverister_id ?>",
                        "adveristment_id" : "<?php echo $advertisement_id ?>",
                        "user" : "<?php echo $user ?>",
                        "timestamp_time" : timestamp_time ,
                  },
                  success:function(data) {
                }
          });
        }


</script>