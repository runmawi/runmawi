<script>

    let video_url = "<?php echo $Livestream_details->livestream_URL; ?>";
    var videoId = "<?php echo $Livestream_details->id; ?>";
    var userId = "<?php echo auth()->id(); ?>";

    document.addEventListener("DOMContentLoaded", function() {
        var player = videojs('live-stream-player', { // Video Js Player 
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
        });

        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');
        
        player.on('userinactive', () => {
          if (playPauseButton) {
            playPauseButton.style.display = 'none';
            backButton.style.display = 'none';
          }
        });

        player.on('useractive', () => {
          if (playPauseButton) {
            playPauseButton.style.display = 'block';
            backButton.style.display = 'block';
          }
        });

        const liveControl = document.querySelector('.vjs-live-display');
        const span = document.createElement('span');
        span.className = "live_dot";
        span.textContent = ".";
        liveControl.insertBefore(span, liveControl.firstChild);

        // Ads Marker


        function LivestreamPartnerMonetization(videoId, currentTime) {
            currentTime = Math.floor(currentTime);
            console.log(currentTime);

            var countview;

            if ((user_role === 'registered' || user_role === 'subscriber') && currentTime == monetization_view_limit && !viewCountSent) {
                viewCountSent = true;
                countview = 1;
                console.log('AJAX request will be sent.');

                $.ajax({
                    url: "<?php echo URL::to('LivestreamPartnerMonetization');?>",
                    type: 'POST',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        video_id: videoId,
                        currentTime: currentTime,
                        countview: countview,
                    },
                    success: function(response) {
                        console.log('View count incremented and monetization updated:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to increment view count:', error);
                    }
                });
            }

            console.log('currentTime: ' + currentTime);
            console.log('countview: ' + countview);
        }

        player.on('timeupdate', function() {
            var currentTime = player.currentTime();
            LivestreamPartnerMonetization(videoId, currentTime);  
        });

        player.on('pause', function() {
            var currentTime = player.currentTime();
            LivestreamPartnerMonetization(videoId, currentTime);  

        });

        window.addEventListener('beforeunload', function() {
            var currentTime = player.currentTime();
            LivestreamPartnerMonetization(videoId, currentTime);  
        });


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
</style>