<script>
    var ads_position = "<?php echo $Advertisement->ads_position ?>";
    var ads_path = "<?php echo $Advertisement->ads_path ?>";
    var ads_video = "<?php echo $Advertisement->ads_video ?>";
    console.log("ads_path", ads_path);

    let users_video_visibility_free_duration_status = 1; 
    const modal = document.getElementById('largeModal');

    document.addEventListener("DOMContentLoaded", function() {
        var player = videojs('my-video', { // Video Js Player
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            controlBar: {
                children: {
                    'playToggle': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'playbackRateMenuButton': {},
                    'pictureInPictureToggle': {},
                    "volumePanel": {},
                    'fullscreenToggle': {},
                },
            }
        });


        // Ads Marker
        player.on("loadedmetadata", function () {
            var CheckPreAds = ads_position === 'pre' ? ads_path : null;
            var CheckPostAds = ads_position === 'post' ? ads_path : null;
            var checkMidrollAds_array = ads_position === 'mid' ? 1 : 0;
            const midrollincreaseInterval = 300;

            const markers = [];
            const total = player.duration();

            if (total != 'Infinity') {
                if (CheckPreAds) markers.push({ time: 0 });
                if (midrollincreaseInterval && midrollincreaseInterval != 0 && checkMidrollAds_array > 0) {
                    for (let time = midrollincreaseInterval; time < total; time += midrollincreaseInterval) {
                        markers.push({ time });
                    }
                }
                if (CheckPostAds) markers.push({ time: total });

                var marker_space = jQuery(player.controlBar.progressControl.children_[0].el_);

                markers.forEach(({ time }) => {
                    var left = (time / total * 100) + '%';
                    var el = jQuery('<div class="vjs-marker" style="left:' + left + '" data-time="' + time + '"></div>');
                    el.click(() => player.currentTime(time));
                    marker_space.append(el);
                });
            }
        });

        // Advertisement
        var vastTagPreroll = ads_position === 'pre' ? ads_path : null;
        var vastTagPostroll = ads_position === 'post' ? ads_path : null;
        console.log("vastTagPostroll",vastTagPostroll);

        var prerollTriggered = false;
        var postrollTriggered = false;

        var vastTagMidrollArray = null;
        if (ads_position === 'mid') {
            try {
                vastTagMidrollArray = JSON.parse(ads_path);
                if (!Array.isArray(vastTagMidrollArray)) { vastTagMidrollArray = [ads_path]; }
            } 
            catch (e){ vastTagMidrollArray = [ads_path]; }
        }

        var midrollRequested = false;
        var lastMidrollTime = 0;
        var midrollInterval = 300;
        
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
            const currentTime = player.currentTime();
            const duration = player.duration();
            if (!postrollTriggered && duration - currentTime < 2) {
                console.log("Postroll Ads requested");
                player.ima.initializeAdDisplayContainer();
                player.ima.changeAdTag(vastTagPostroll);
                player.ima.requestAds();
                postrollTriggered = true;
            }
        });

        player.on("adsready", function() {
            if (midrollRequested) { console.log("Ads ready - midroll"); } 
            else if(prerollTriggered) { console.log("Ads ready - preroll"); }
            else{ console.log("Ads ready - postroll"); }
        });

        player.on("aderror", function() {
            console.log("Ads aderror");
            player.play();
        });

        player.on("adend", function() {
            if (lastMidrollTime > 0) {
                console.log("A midroll ad has finished playing.");
                midrollRequested = false;
            } else if(prerollTriggered) {
                console.log("The preroll ad has finished playing.");
                prerollTriggered = false;
            } else {
                console.log("The postroll ad has finished playing.");
                postrollTriggered = false;
            }
            player.play();
        });

        // const playPauseButton = document.querySelector('.vjs-big-play-button');
        player.on('userinactive', () => {
            if (playPauseButton) { 
                // playPauseButton.style.visibility = 'hidden'; 
                $('.vjs-big-play-button').hide();
            }
        });
        player.on('useractive', () => {
            if (playPauseButton) { 
                // playPauseButton.style.visibility = 'visible'; 
                $('.vjs-big-play-button').show();
            }
        });

        function togglePlayPause(e) {
            if (e.code === '"Space') { 
                e.preventDefault(); 
                player.paused() ? player.play() : player.pause(); 
            }
        }
        document.addEventListener('keydown', togglePlayPause);
        
        function handleKeydown(e) {
            if (e.code === 'ArrowRight') {
                e.preventDefault();
                var currentTime = player.currentTime();
                var newTime = Math.min(currentTime + 10, player.duration());
                player.currentTime(newTime);
            }
            if (e.code === 'ArrowLeft') {
                e.preventDefault();
                var currentTime = player.currentTime();
                var newTime = Math.min(currentTime - 10, player.duration());
                player.currentTime(newTime);
            }
        }
        document.addEventListener('keydown', handleKeydown);

        $('.close-btn').click(function(){ 
            player.currentTime(0); 
            player.pause(); });

        $(modal).on('shown.bs.modal', function () { 
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