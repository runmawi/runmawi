<script>
    var ads_position = "<?php echo $Advertisement->ads_position ?>";
    var ads_path = "<?php echo $Advertisement->ads_path ?>";
    var ads_video = "<?php echo $Advertisement->ads_video ?>";

    let users_video_visibility_free_duration_status = 1;

    document.addEventListener("DOMContentLoaded", function () {
        var player = videojs('my-video', {
            aspectRatio: '16:9',
            autoplay: false,
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            volumePanel: false,
            controlBar: {
                children: {
                    'playToggle': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'playbackRateMenuButton': {},
                    'fullscreenToggle': {},
                },
            }
        });

        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');

        player.el().appendChild(skipForwardButton);
        player.el().appendChild(skipBackwardButton);

        skipForwardButton.addEventListener('click', function () {
            player.currentTime(player.currentTime() + 10);
        });

        skipBackwardButton.addEventListener('click', function () {
            player.currentTime(player.currentTime() - 10);
        });

        // Ads Marker
        player.on("loadedmetadata", function () {
            var CheckPreAds = ads_position === 'pre' || ads_position === 'all' ? ads_path : null;
            var CheckPostAds = ads_position === 'post' || ads_position === 'all' ? ads_path : null;
            var checkMidrollAds_array = ads_position === 'mid' || ads_position === 'all' ? 1 : 0;
            const midrollincreaseInterval = 300;

            const markers = [];
            const total = player.duration();

            if (total != 'Infinity') {
                if (CheckPreAds) markers.push({ time: 0 });

                if (midrollincreaseInterval && checkMidrollAds_array > 0) {
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
        var vastTagPreroll = ads_position === 'pre' || ads_position === 'all' ? ads_path : null;
        var vastTagPostroll = ads_position === 'post' || ads_position === 'all' ? ads_path : null;

        var prerollTriggered = false;
        var postrollTriggered = false;

        var vastTagMidrollArray = null;
        if (ads_position === 'mid' || ads_position === 'all') {
            try {
                vastTagMidrollArray = JSON.parse(ads_path);
                console.log("vastTagMidrollArray-try",vastTagMidrollArray);
                
                if (!Array.isArray(vastTagMidrollArray)) {
                    vastTagMidrollArray = [ads_path];
                    console.log("vastTagMidrollArray-if",vastTagMidrollArray);
                    
                }
            } catch (e) {
                vastTagMidrollArray = [ads_path];
                console.log("vastTagMidrollArray-catch",vastTagMidrollArray);
                
            }
        }

        var midrollRequested = false;
        var lastMidrollTime = 0;
        var midrollInterval = 300;

        player.ima({
            adTagUrl: prerollTriggered ? '' : vastTagPreroll,
            showControlsForAds: true,
            debug: false,
            adsRenderingSettings: {
                loadVideoTimeout: 15000,
            }
        });
        player.ima.initializeAdDisplayContainer();

        function requestMidrollAd(vastTagMidroll) {
            player.ima.changeAdTag(vastTagMidroll);
            player.ima.requestAds();
            midrollRequested = true;
        }

        player.on("timeupdate", function () {
            var currentTime = player.currentTime();
            var Player_duration = player.duration();

            // Mid ads
            var timeSinceLastMidroll = currentTime - lastMidrollTime;
            if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {
                lastMidrollTime = currentTime;
                const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);                
                const vastTagMidroll = vastTagMidrollArray[random_array_index];
                
                requestMidrollAd(vastTagMidroll);
            }

            // Postroll
            if (!postrollTriggered && Player_duration - currentTime < 2) {
                console.log("player.ima.changeAdTag(vastTagPostroll)",player.ima.changeAdTag(vastTagPostroll));
                
                player.ima.changeAdTag(vastTagPostroll);
                player.ima.requestAds();
                postrollTriggered = true;
            }
            
        });

        // Handle Ad Errors
        player.on("aderror", function (event) {
            console.error("Ad error: ", event);
            midrollRequested = false; // Reset midroll status on failure
            player.play();
        });

        player.on("adend", function () {
            midrollRequested = false;
            prerollTriggered = false;
            postrollTriggered = false;
            player.play();
        });

        // Key controls
        document.addEventListener('keydown', function (e) {
            if (e.code === 'Space') {
                e.preventDefault();
                player.paused() ? player.play() : player.pause();
            }
            if (e.code === 'ArrowRight') {
                e.preventDefault();
                player.currentTime(player.currentTime() + 10);
            }
            if (e.code === 'ArrowLeft') {
                e.preventDefault();
                player.currentTime(player.currentTime() - 10);
            }
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