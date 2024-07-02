<script>

    let video_url = "<?php echo $videodetail->videos_url; ?>";
    let users_video_visibility_free_duration_status = "<?php echo $videodetail->users_video_visibility_free_duration_status; ?>";
    let free_duration_seconds   = "<?php echo $videodetail->free_duration; ?>";

    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('my-video', { // Video Js Player 
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
                    // 'hlsQualitySelector':{}  
                    // 'audioTrackButton': {}               
                },
                pictureInPictureToggle: true,
            }
        });

         // Hls Quality Selector - M3U8 

         player.hlsQualitySelector({ 
            displayCurrentQuality: true,
        });

        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');
        var hovered = false;

        skipForwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() + 10);
        });

        skipBackwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() - 10);
        });

        player.on('userinactive', () => {

            skipForwardButton.addEventListener('mouseenter',handleHover);
            skipBackwardButton.addEventListener('mouseenter',handleHover);
            
            skipForwardButton.addEventListener('mouseleave',handleHover);
            skipBackwardButton.addEventListener('mouseleave',handleHover);

            function handleHover(event) {
                const element = event.target;
                if (event.type === 'mouseenter') {
                    // console.log("hovered");
                    hovered = true;
                } else if (event.type === 'mouseleave') {
                    // console.log("not hovered");
                    hovered = false;
                }
            }

            // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(hovered == false){
                    skipForwardButton.style.display = 'none';
                    skipBackwardButton.style.display = 'none';
                    playPauseButton.style.display = 'none';
                }
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


        // Skip Intro & Skip Recap 

        player.on("loadedmetadata", function() {

            const player_duration_Seconds        =  player.duration();
            const video_skip_intro_seconds       = '<?= $videodetail->video_skip_intro_seconds ?>' ;
            const video_intro_start_time_seconds = '<?= $videodetail->video_intro_start_time_seconds ?>' ;
            const video_intro_end_time_seconds   = '<?= $videodetail->video_intro_end_time_seconds ?>' ;

            const video_skip_recap_seconds       = '<?= $videodetail->video_skip_recap_seconds ?>' ;
            const video_recap_start_time_seconds = '<?= $videodetail->video_recap_start_time_seconds ?>'  ;
            const video_recap_end_time_seconds   = '<?= $videodetail->video_recap_end_time_seconds ?>'  ;

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

        // player.on('userinactive', () => {
          // Hide the skip forward and backward buttons when the user becomes inactive
        //     const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        //     const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        //     if (skipForwardButton && skipBackwardButton) {
        //         skipForwardButton.style.display = 'none';
        //         skipBackwardButton.style.display = 'none';
        //     }
        // });

        // player.on('useractive', () => {
          // Show the skip forward and backward buttons when the user becomes active
        //   const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        //   const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        //   if (skipForwardButton && skipBackwardButton) {
        //     skipForwardButton.style.display = 'block';
        //     skipBackwardButton.style.display = 'block';
        //   }
        // });

        // const skipForward = (duration) => {
        //     const playerTime = player.current;
        //     playerTime.currentTime(playerTime.currentTime() + duration);
        //     console.log("player",playerTime)
        // };

        // const skipBackward = (duration) => {
        //     const pplayerTime = player.current;
        //     playerTime.currentTime(playerTime.currentTime() - duration);
        // };

        // Ads Marker

        player.on("loadedmetadata", function() {

            const CheckPreAds  = '<?= $pre_advertisement ?>'; 
            const CheckPostAds = '<?= $post_advertisement ?>';
            const midrollincreaseInterval = Number('<?= $video_js_mid_advertisement_sequence_time ?>');
            const checkMidrollAds_array = '<?php echo $mid_advertisement == null ? 0 :  count($mid_advertisement) ?>';

            const markers = [];

            const  total = player.duration();

            if ( total != 'Infinity' ) {

                if( !!CheckPreAds ){
                    markers.push({ time: 0 });
                }
                    
                if(!!midrollincreaseInterval && midrollincreaseInterval != 0 && checkMidrollAds_array > 0 ){
                    for (let time = midrollincreaseInterval; time < total; time += midrollincreaseInterval) {
                        markers.push({ time });
                    }
                }

                if( !!CheckPostAds ){
                    markers.push({ time: total });
                }
                
                var marker_space = jQuery(player.controlBar.progressControl.children_[0].el_);

                for (var i = 0; i < markers.length; i++) {

                    var left = (markers[i].time / total * 100) + '%';

                    var time = markers[i].time;

                    var el = jQuery('<div class="vjs-marker" style="left:' + left + '" data-time="' + time + '"></div>');
                        el.click(function() {
                            player.currentTime($(this).data('time'));
                        });

                    marker_space.append(el);
                }
            }
        });

       

        //Watermark
        player.ready(function() {
            var watermark = document.createElement('div');
            watermark.className = 'vjs-watermark';
            watermark.innerHTML = '<img src="<?= URL::to('/') . '/public/uploads/settings/'. $settings->logo ?>" alt="Watermark">';
            player.el().appendChild(watermark);
        });




        // Advertisement

        var vastTagPreroll  = '<?= $pre_advertisement ?>'; 
        var vastTagPostroll = '<?= $post_advertisement ?>';

        var prerollTriggered = false;
        var postrollTriggered = false;

        const vastTagMidroll_array = '<?php echo $mid_advertisement ?>';
        const vastTagMidrollArray  = vastTagMidroll_array != "" ? JSON.parse(vastTagMidroll_array) : null;

        var midrollRequested = false;
        var midrollInterval = '<?= $video_js_mid_advertisement_sequence_time ?>';
        var lastMidrollTime = 0;

        if (!prerollTriggered) {

            player.ima({
                adTagUrl: vastTagPreroll,
                showControlsForAds: true,
                debug: false,
            });
        } else {
            player.ima({
                adTagUrl: '',
                showControlsForAds: true,
                debug: false,
            });
        }

        player.ima.initializeAdDisplayContainer();

        function requestMidrollAd(vastTagMidroll) {

            midrollRequested = true;

            player.ima.changeAdTag(vastTagMidroll);

            player.ima.requestAds();
        }

        var initial_current_time = 0;
        var timeupdate_counter = 0; 

        player.on("timeupdate", function() {

            var currentTime = player.currentTime();
            var Player_duration = player.duration() ;

            // Mid ads 

            var timeSinceLastMidroll = currentTime - lastMidrollTime;

            if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {

                lastMidrollTime = currentTime;
                // console.log("Midroll triggered");

                const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);

                const vastTagMidroll = vastTagMidrollArray[random_array_index];

                requestMidrollAd(vastTagMidroll);
            }

            // Free Duration

            if ( Player_duration != "Infinity" && users_video_visibility_free_duration_status == 1 && currentTime >=  free_duration_seconds ) {
                player.pause();
                player.dispose();
                player.off('timeupdate');  
                $('#visibilityMessage').show();
                $('.custom-skip-backward-button,.custom-skip-forward-button').hide();
            }

            // Free Duration - Live

            if ( Player_duration == "Infinity" && users_video_visibility_free_duration_status == 1 && currentTime  ) {
    
                if (timeupdate_counter <= 2) {
                    initial_current_time = player.currentTime();
                    timeupdate_counter++;
                }

                let time_diff = currentTime - initial_current_time;
                let round_off_time  = parseInt(time_diff);

                if( round_off_time >=  free_duration_seconds ){
                    player.pause();
                    player.dispose();
                    player.off('timeupdate');  
                    $('#visibilityMessage').show();
                    $('.custom-skip-backward-button,.custom-skip-forward-button').hide();
                }
            }
        });

        player.on("ended", function() {

            if (!postrollTriggered) {

                postrollTriggered = true;

                player.ima.requestAds({
                    adTagUrl: vastTagPostroll,
                });

                // console.log("Postroll ads requested");
            }
        });

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

        player.on("skipDuration", function(duration){
            // console.log("!#");
        })
    });

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
    .vjs-watermark {
        position: absolute;
        width: 4%;
        height: 7%;
        top: 75%;
        left: 88%;
        opacity: 0.7;
        cursor: pointer;
    }
    .vjs-watermark:hover{
        opacity: 1;
    }
    .vjs-watermark img{
        width: 100%;
        height: 100%;
    }
</style>