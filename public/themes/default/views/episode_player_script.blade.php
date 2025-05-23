<!-- <?php
    $user = !Auth::guest() ? Auth::User()->id : 'guest' ;
    $episode_id = $episode->id ;
    $advertisement_id = $episode->episode_ads ;
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();
?> -->



<script>
    var video_viewcount_limit = "<?php echo $video_viewcount_limit; ?>";
    var played_views = "<?php echo $episode_details->played_views; ?>";
    var user_role = "<?php echo $user_role; ?>";
    let video_url = "<?php echo $episode_details->Episode_url; ?>";
    let episode_ads = <?php echo json_encode( $episode_ads ); ?> ;

    var episodeId = "<?php echo $episode_details->id; ?>";
    var userId = "<?php echo auth()->id(); ?>";
    <?php if (!empty($next_episode) && is_object($next_episode)): ?>
        var next_episode = "<?php echo $next_episode->slug; ?>";
        var next_episode_slug = "<?php echo URL::to('episode/' . $series->slug . '/' . $next_episode->slug); ?>";
        console.log('Next episode slug: ' + next_episode_slug);
    <?php else: ?>
        var next_episode = "";
        var next_episode_slug = "";
        console.log('No next episode');
    <?php endif; ?>

    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('episode-player', { // Video Js Player
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,

            controlBar: {
                volumePanel: { inline: false },
                // descriptionsButton: true,
                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {},
                    // 'audioTrackButton': {},
                },
                pictureInPictureToggle: true,
            }
        });


        if (next_episode_slug) {

            player.on('ended', function() {
                // $('#episode-player').css('opacity', '0.1');
                $('.vjs-tech').css('opacity', '0.1');
                $('.vjs-big-play-button').css('opacity', '0.1');
                $('.vjs-control-bar').css('opacity', '0.1');
                $('.custom-skip-backward-button').css('opacity', '0.1');
                $('.custom-skip-forward-button').css('opacity', '0.1');
                $('.cancel_card').show();
                $('.next-episode').hide();

                $('.next-epi-cancel').on('click', function(event) {
                    $('.cancel_card').hide();
                    $('#episode-player').css('opacity', '1');
                    next_episode_slug = '';
                });

                redirectTimeout = setTimeout(() => {
                    window.location.href = next_episode_slug;
                }, 5000);
            });
        }


        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const backButton = document.querySelector('.staticback-btn');
        const titleButton = document.querySelector('.vjs-title-bar');
        const nextEpisodeButton = document.querySelector('.next-episode');
        const cancelCard = document.querySelector('.cancel_card');
        var controlBar = player.getChild('controlBar');

        $(nextEpisodeButton).hide();

        player.el().appendChild(skipForwardButton);
        player.el().appendChild(skipBackwardButton);
        player.el().appendChild(titleButton);
        player.el().appendChild(backButton); 
        if(next_episode_slug){
            player.el().appendChild(nextEpisodeButton); 
            player.el().appendChild(cancelCard);
        } 
        
        // Continue watching script
        function EpisodeContinueWatching(episodeId, duration, currentTime) {
            if (duration > 0) {
                var watch_percentage = (currentTime * 100 / duration);
                $.ajax({
                    url: "<?php echo URL::to('EpisodeContinueWatching');?>",
                    type: 'POST',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        episode_id: episodeId,
                        duration: duration,
                        currentTime: currentTime,
                        watch_percentage: watch_percentage,
                    },
                });
            }
            // console.log('duration: ' + duration);
            // console.log('currentTime: ' + currentTime);
            // console.log('watch_percentage: ' + watch_percentage);
        }

        function updateNextEpisodeButtonOpacity(duration, currentTime) {
            const timeRemaining = duration - currentTime;
            
            // Check if we are within the last 10 seconds
            if (timeRemaining <= 10) {
                $(nextEpisodeButton).show();

                // Calculate opacity based on time remaining
                const opacity = 0.5 + (1 - (timeRemaining / 10)) * 0.5;
                nextEpisodeButton.style.opacity = opacity;
            } else {
                $(nextEpisodeButton).hide();
            }
        }

        player.on('loadedmetadata', function() {
            console.log('Video metadata loaded');

            player.on('timeupdate', function() {
                var currentTime = player.currentTime();
                var duration = player.duration();

                updateNextEpisodeButtonOpacity(duration, currentTime);

                EpisodeContinueWatching(episodeId, duration, currentTime);
            });

            player.on('pause', function() {
                var currentTime = player.currentTime();
                var duration = player.duration();
                EpisodeContinueWatching(episodeId, duration, currentTime);
            });

            window.addEventListener('beforeunload', function() {
                var currentTime = player.currentTime();
                var duration = player.duration();
                EpisodeContinueWatching(episodeId, duration, currentTime);
            });
        });


        let viewCountSent = false;

        function EpisodePartnerMonetization(videoId, currentTime) {
            currentTime = Math.floor(currentTime);
            var countview;

            if ((user_role === 'registered' || user_role === 'subscriber' || user_role === 'guest' ) && !viewCountSent && currentTime > video_viewcount_limit) {
                viewCountSent = true;
                countview = 1;
                $.ajax({
                    url: "<?php echo URL::to('EpisodePartnerMonetization');?>",
                    type: 'POST',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        video_id: videoId,
                        currentTime: currentTime,
                        countview: countview,
                    },
                });
            }
        }


        if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
            player.on('timeupdate', function() {
                var currentTime = player.currentTime();
                EpisodePartnerMonetization(videoId, currentTime);
            });

            player.on('pause', function() {
                var currentTime = player.currentTime();
                EpisodePartnerMonetization(videoId, currentTime);
            });
        }

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                var currentTime = player.currentTime();
                EpisodePartnerMonetization(videoId, currentTime);
            }
        });

        function updateControls() {
            var isMobile = window.innerWidth <= 768;
            var controlBar = player.controlBar;

            if (controlBar.getChild('subtitlesButton')) {
                controlBar.removeChild('subtitlesButton');
            }
            if (controlBar.getChild('playbackRateMenuButton')) {
                controlBar.removeChild('playbackRateMenuButton');
            }
            if (controlBar.getChild('settingsMenuButton')) {
                controlBar.removeChild('settingsMenuButton');
            }

            if (!isMobile){
                controlBar.addChild('subtitlesButton');
                controlBar.addChild('playbackRateMenuButton');
            } 
            else{
                controlBar.addChild('settingsMenuButton', {
                    entries: [
                        'subtitlesButton',
                        'playbackRateMenuButton',
                    ]
                });
            }
        }

        player.on('loadedmetadata', function() {
            updateControls();
        });

        window.addEventListener('resize', function() {
            updateControls();
        });
  
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
                    // playPauseButton.style.display = 'none';
                    $('.vjs-big-play-button').hide();
                    backButton.style.display = 'none';
                    titleButton.style.display = 'none';
                }
            }
        });

        player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
        if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
            skipForwardButton.style.display = 'block';
            skipBackwardButton.style.display = 'block';
            // playPauseButton.style.display = 'block';
            $('.vjs-big-play-button').show();
            backButton.style.display = 'block';
            titleButton.style.display = 'block';
        }
        });
        
        console.log('Entered Picture-in-Picture mode');
            player.on('enterpictureinpicture', function() {
                console.log('Entered Picture-in-Picture mode');
                player.controlBar.hide();
                playPauseButton.style.visibility = "hidden";
                skipForwardButton.style.visibility = 'hidden';
                skipBackwardButton.style.visibility = 'hidden';
                titleButton.style.visibility = 'hidden';
            });

            player.on('leavepictureinpicture', function() {
                console.log('Exited Picture-in-Picture mode');
                player.controlBar.show();
                playPauseButton.style.visibility = "visible";
                skipForwardButton.style.visibility = 'visible';
                skipBackwardButton.style.visibility = 'visible';
                titleButton.style.visibility = 'visible';
            });

        // Skip Intro & Skip Recap

        player.on("loadedmetadata", function() {
            // console.log("p",player);

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

        // Watermark
        // let enable_watermark  = '<?//= $playerui->watermark ?>';
        // if (enable_watermark == 1 ) {
        //     player.ready(function() {
        //         var watermark = document.createElement('div');
        //         watermark.className = 'vjs-watermark';
        //         watermark.innerHTML = '<img src="<?//= $playerui->watermark_logo ?>" alt="Watermark">';
        //         player.el().appendChild(watermark);
        //     });
        // }

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
                console.log("Midroll triggered");

                const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);
                const vastTagMidroll = vastTagMidrollArray[random_array_index];                

                requestMidrollAd(vastTagMidroll);
            }

        });

        
        player.on("timeupdate", function() {
            
            const duration = player.duration();

            if ( duration != "Infinity" ) {

                const currentTime = player.currentTime();

                if (!postrollTriggered && duration - currentTime < 2) {

                    console.log("Postroll Ads requested");

                    player.ima.initializeAdDisplayContainer();
                    player.ima.changeAdTag(vastTagPostroll);
                    player.ima.requestAds();
                    postrollTriggered = true;
                }
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
    .vjs-watermark {
        opacity: <?php echo $playerui_settings->watermark_opacity; ?>;
        cursor: pointer;
        width: <?php echo $playerui_settings->watermar_width; ?>;
        /* float: right; */
        position: relative;
        top:<?php echo $playerui_settings->watermark_top; ?>;
        right: <?php echo $playerui_settings->watermark_right; ?>;
        left:<?php echo $playerui_settings->watermark_left; ?>;
        bottom:<?php echo $playerui_settings->watermark_bottom; ?>;
        transform: translate(-50%, 0%);
    }
    .vjs-watermark:hover{
        opacity: 100%;
    }
    .vjs-watermark img{
        width: 100%;
        height: 100%;
    }
</style>
