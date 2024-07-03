<script>

    let video_url = "<?php echo $episode_details->Episode_url; ?>";

    document.addEventListener("DOMContentLoaded", function() {

    var player = videojs('episode-player', { // Video Js Player 
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
                    // 'audioTrackButton': {} 
            },
            pictureInPictureToggle: true,
        }
    });

    const skipForwardButton = document.querySelector('.custom-skip-forward-button');
    const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
    const playPauseButton = document.querySelector('.vjs-big-play-button');

    skipForwardButton.addEventListener('click', function() {
        player.currentTime(player.currentTime() + 10);
    });

    skipBackwardButton.addEventListener('click', function() {
        player.currentTime(player.currentTime() - 10);
    });

    player.on('userinactive', () => {
        // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
        if (skipForwardButton && skipBackwardButton && playPauseButton) {
            skipForwardButton.style.display = 'none';
            skipBackwardButton.style.display = 'none';
            playPauseButton.style.display = 'none';
        }
    });

    player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const playPauseButton = document.querySelector('.vjs-big-play-button');
        if (skipForwardButton && skipBackwardButton && playPauseButton) {
            skipForwardButton.style.display = 'block';
            skipBackwardButton.style.display = 'block';
            playPauseButton.style.display = 'block';
        }
    });

        // Skip Intro & Skip Recap 

        player.on("loadedmetadata", function() {

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


        player.hlsQualitySelector({ // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });

        var vastTagPreroll  = '<?= $pre_advertisement ?>'; // Advertisement
        var vastTagPostroll = '<?= $post_advertisement ?>';

        var prerollTriggered = false;
        var postrollTriggered = false;

        const vastTagMidroll_array = '<?php echo $mid_advertisement; ?>';
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
    .vjs-fg-skip-button{
	    background: #2971ea !important;
	    border-radius: 10px !important;
    }
</style>