<?php 
    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
    $livestream_id = $video->id ; 
    $advertisement_id = $video->live_ads ; 
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();
?>

<script>

    let user = <?php echo json_encode($user); ?>

    let live_ads = <?php echo json_encode( $live_ads ); ?> ;

    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#live_player_mp4',{

           controls: [   'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings','pip','airplay',
                        'fullscreen'
		            ],

            ads:{ 
                  enabled: true, 
                  tagUrl: live_ads 
            },
            
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


    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#acc_audio',{

        controls: [   'play-large','play','progress',
                        'current-time','mute','volume','captions','settings','airplay',
                        'fullscreen'
                    ],
           
        });
    });

    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#Embed_player',{

          controls: [   'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings','pip','airplay',
                        'fullscreen'
		            ],
                    
        });
    });


    document.addEventListener("DOMContentLoaded", () => {
        const video = document.querySelector("#live_player");
        const source = video.getElementsByTagName("source")[0].src;
  
        const defaultOptions = {};

        if (!Hls.isSupported()) {

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: live_ads
            }

            video.src = source;
            var player = new Plyr(video, defaultOptions);
        } 
        else
        {
            const hls = new Hls();
            hls.loadSource(source);
            
                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                const availableQualities = hls.levels.map((l) => l.height)
                availableQualities.unshift(0) 

                defaultOptions.quality = {
                    default: 0, //Default - AUTO
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
                tagUrl: live_ads
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

        video.addEventListener('timeupdate', () => {
            const thirtyMinutesInSeconds = 30 * 1;
            if (video.currentTime >= thirtyMinutesInSeconds) {
                video.pause();
                hidePlayerControls(player);
                displayModal();
            }
        });

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

        function displayModal() {

            const modal = document.getElementById("modal");
            modal.style.display = "block";

        }

        function hidePlayerControls(player) {
            const controlsElements = document.getElementsByClassName("plyr__controls");

            if (controlsElements.length > 0) {
                const controlsElement = controlsElements[0];

                controlsElement.style.display = "none";
            }
        }       
    });

    function Ads_Redirection_URL_Count(timestamp_time){

        $.ajax({
              type:'get',
              url:'<?= route('Advertisement_Redirection_URL_Count') ?>',
              data: {
                        "Count" : 1 , 
                        "source_type" : "livestream",
                        "source_id"   : "<?php echo $livestream_id ?>",
                        "adverister_id" : "<?php echo $adverister_id ?>",
                        "adveristment_id" : "<?php echo $advertisement_id ?>",
                        "user" : "<?php echo $user ?>",
                        "timestamp_time" : timestamp_time ,
                  },
                  success:function(data) {
                }
          });
        }

    function Ads_Views_Count(){

        $.ajax({
              type:'get',
              url:'<?= route('Advertisement_Views_Count') ?>',
              data: {
                        "Count" : 1 , 
                        "source_type" : "livestream",
                        "source_id"   : "<?php echo $livestream_id ?>",
                        "adverister_id" : "<?php echo $adverister_id ?>",
                        "adveristment_id" : "<?php echo $advertisement_id ?>",
                        "user" : "<?php echo $user ?>",
                  },
                  success:function(data) {
                }
          });
    }

</script>

<div id="modal" class="modal">

    <div class="modal-content">
        <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
            <div id="video_bg_dim"></div>
            <div class="row justify-content-center pay-live">
                <div class="col-md-4 col-sm-offset-4">
                    <div class="ppv-block">
                        <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>
                        <div class="clear"></div>
                        <?php if(Auth::guest()){ ?>
                            <a href="<?php echo URL::to('/login');?>"><button class="btn btn-primary btn-block" >Purchase For Pay <?php echo $currency->symbol.' '.$video->ppv_price; ?></button></a>
                        <?php }else{ ?>
                            <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)">Purchase For Pay <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>