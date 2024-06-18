
<?php 
    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
    $episode_id = $episode->id ; 
    $advertisement_id = $episode->episode_ads ; 
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();
?>

<script>

   let episode_ads = <?php echo json_encode( $episode_ads ); ?> ;
   let video_url = "<?php echo $episode_details->Episode_url; ?>";

    document.addEventListener('DOMContentLoaded', () => { 

        var player = new videojs('episode-player',{
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,

            controlBar: {
                volumePanel: { inline: false },
                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'subtitlesButton': {},
                    'playbackRateMenuButton': {},
                    'fullscreenToggle': {},  
                },
                pictureInPictureToggle: true,
            }

        //   controls: [   'play-large','restart','rewind','play','fast-forward','progress',
        //                'current-time','mute','volume','captions','settings','pip','airplay',
        //                'fullscreen'
        //            ],

        //    ads:{ 
        //          enabled: true, 
        //          tagUrl: episode_ads 
        //    }
        });

       const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');

        skipForwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() + 10);
        });

        skipBackwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() - 10);
        });

        player.on('userinactive', () => {
        // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
        if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
            skipForwardButton.style.display = 'none';
            skipBackwardButton.style.display = 'none';
            playPauseButton.style.display = 'none';
            backButton.style.display = 'none';
        }
        });

        player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
        if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
            skipForwardButton.style.display = 'block';
            skipBackwardButton.style.display = 'block';
            playPauseButton.style.display = 'block';
            backButton.style.display = 'block';
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

                // Skip Intro & Skip Recap 

                player.on("loadedmetadata", function() {
            console.log("p",player);

            const player_duration_Seconds        =  player.duration();
            const video_skip_intro_seconds       = '<?= $episode_details->video_skip_intro_seconds ?>' ;
            const video_intro_start_time_seconds = '<?= $episode_details->video_intro_start_time_seconds ?>' ;
            const video_intro_end_time_seconds   = '<?= $episode_details->video_intro_end_time_seconds ?>' ;

            const video_skip_recap_seconds       = '<?= $episode_details->video_skip_recap_seconds ?>' ;
            const video_recap_start_time_seconds = '<?= $episode_details->video_recap_start_time_seconds ?>'  ;
            const video_recap_end_time_seconds   = '<?= $episode_details->video_recap_end_time_seconds ?>'  ;

            if( player_duration_Seconds != "Infinity" && !!video_skip_intro_seconds && !!video_intro_start_time_seconds && !!video_intro_end_time_seconds ){
                player.skipButton({
                    text: "Skip Intro",
                    from: video_intro_start_time_seconds,
                    to: video_skip_intro_seconds,
                    position: "bottom-right",
                    offsetH: 46,
                    offsetV: 96
                });

                player.on("timeupdate", function() {
                    if(video_intro_end_time_seconds <= player.currentTime() ){
                        $(".vjs-fg-skip-button").removeAttr("style").hide();
                    }
                });
            }

            if(  player_duration_Seconds != "Infinity" &&  !!video_skip_recap_seconds && !!video_recap_start_time_seconds && !!video_recap_end_time_seconds ){
                player.skipButton({
                    text: "Skip Recap",
                    from: video_recap_start_time_seconds,
                    to: video_skip_recap_seconds,
                    position: "bottom-right",
                    offsetH: 46,
                    offsetV: 96
                });

                player.on("timeupdate", function() {
                    if(video_recap_end_time_seconds <= player.currentTime() ){
                        $(".vjs-fg-skip-button").removeAttr("style").hide();
                    }
                });
            }
        });
        
        player.hlsQualitySelector({ // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });

        player.on('loadedmetadata', () => {
            const qualityLevels = player.qualityLevels();

            for (let i = 0; i < qualityLevels.length; i++) {
            // Customize label to show height in pixels or any desired format
            qualityLevels[i].label = `${qualityLevels[i].height}p`;
            }
        });
        

        player.ima.initializeAdDisplayContainer();

        function requestMidrollAd(vastTagMidroll) {

            midrollRequested = true;

            player.ima.changeAdTag(vastTagMidroll);

            player.ima.requestAds();
        }

        player.on("timeupdate", function() {

        var currentTime = player.currentTime();

        var timeSinceLastMidroll = currentTime - lastMidrollTime;

        if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {

            lastMidrollTime = currentTime;
            // console.log("Midroll triggered");

            const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);

            const vastTagMidroll = vastTagMidrollArray[random_array_index];

            requestMidrollAd(vastTagMidroll);
        }
        });
        player.on("ended", function() {

        if (!postrollTriggered) {

            postrollTriggered = true;

            player.ima.requestAds({
                adTagUrl: vastTagPostroll,
            });

            // console.log("Postroll ads requested");
        }});

        player.on("adsready", function() {

            if (midrollRequested) {
                // console.log("Ads ready - midroll");
            } else {
                // console.log("Ads ready - preroll");
                player.src(video_url);
            }
        });
        player.on("aderror", function() {

            console.log("Ads aderror");
            player.play();

        });
        player.on("adend", function() {

            if (lastMidrollTime > 0) {
                //   console.log("A midroll ad has finished playing.");
                midrollRequested = false;
            } else {
                //   console.log("The preroll ad has finished playing.");
                prerollTriggered = true;
            }
            player.play();

            });


    });


//    document.addEventListener("DOMContentLoaded", () => {
//        const video = document.querySelector("#video");
//        const source = video.getElementsByTagName("source")[0].src;
 
//        const defaultOptions = {};

//        if (!Hls.isSupported()) {

//            defaultOptions.ads = {
//                enabled: true, 
//                tagUrl: episode_ads
//            }

//            video.src = source;
//            var player = new Plyr(video, defaultOptions);

//                // Ads Views Count
//             player.on('adsloaded', (event) => {
//                 Ads_Views_Count();
//             });

//                 // Ads Redirection Count
//             player.on('adsclick', (event) => {
//                 Ads_Redirection_URL_Count(event.timeStamp);
//             });
//        } 
//        else
//        {
//            const hls = new Hls();
//            hls.loadSource(source);
           
//                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
//                const availableQualities = hls.levels.map((l) => l.height)
//                availableQualities.unshift(0) 

//                defaultOptions.quality = {
//                    default: 0, //Default - AUTO
//                    options: availableQualities,
//                    forced: true,        
//                    onChange: (e) => updateQuality(e),
//        }

//          // Add Auto Label 
//            defaultOptions.i18n = {
//                qualityLabel: { 0: 'Auto', },
//            }

//            defaultOptions.ads = {
//                enabled: true, 
//                tagUrl: episode_ads
//            }

//            hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
//                var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
//                if (hls.autoLevelEnabled) {
//                    span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
//                } else {
//                    span.innerHTML = `AUTO`
//                }
//            })
     
//            var player = new Plyr(video, defaultOptions);

//                // Ads Views Count
//             player.on('adsloaded', (event) => {
//                 Ads_Views_Count();
//             });

//                 // Ads Redirection Count
//             player.on('adsclick', (event) => {
//                 Ads_Redirection_URL_Count(event.timeStamp);
//             });
//      });	

//        hls.attachMedia(video);
//            window.hls = hls;		 
//        }

//        function updateQuality(newQuality) {
//            if (newQuality === 0) {
//            window.hls.currentLevel = -1;
//            } else {
//            window.hls.levels.forEach((level, levelIndex) => {
//                if (level.height === newQuality) {
//                console.log("Found quality match with " + newQuality);
//                window.hls.currentLevel = levelIndex;
//                }
//            });
//            }
//        }
//    });

//    function Ads_Views_Count(){

//         $.ajax({
//               type:'get',
//               url:'<?= route('Advertisement_Views_Count') ?>',
//               data: {
//                         "Count" : 1 , 
//                         "source_type" : "Episode",
//                         "source_id"   : "<?php echo $episode_id ?>",
//                         "adverister_id" : "<?php echo $adverister_id ?>",
//                         "adveristment_id" : "<?php echo $advertisement_id ?>",
//                         "user" : "<?php echo $user ?>",
//                   },
//                   success:function(data) {
//                 }
//           });
//     }

//      function Ads_Redirection_URL_Count(timestamp_time){

//         $.ajax({
//               type:'get',
//               url:'<?= route('Advertisement_Redirection_URL_Count') ?>',
//               data: {
//                         "Count" : 1 , 
//                         "source_type" : "Episode",
//                         "source_id"   : "<?php echo $episode_id ?>",
//                         "adverister_id" : "<?php echo $adverister_id ?>",
//                         "adveristment_id" : "<?php echo $advertisement_id ?>",
//                         "user" : "<?php echo $user ?>",
//                         "timestamp_time" : timestamp_time ,
//                   },
//                   success:function(data) {
//                 }
//           });
//         }
</script>

<style>
    .vjs-marker {
        position: absolute;
        background: #d4d42b;
        width: 5px;
        height: 110%;
        top: -5%;
        z-index: 30;
        margin-left: -3px;
    }
</style>