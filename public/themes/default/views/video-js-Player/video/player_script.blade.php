<script>

    let video_url = "<?php echo $videodetail->videos_url; ?>";
    let users_video_visibility_free_duration_status = "<?php echo $videodetail->users_video_visibility_free_duration_status; ?>";
    let free_duration_seconds   = "<?php echo $videodetail->free_duration; ?>";
    let PPV_Plan   = "<?php echo $videodetail->PPV_Plan; ?>";

    const titleButton = document.querySelector('.titlebutton');
    var remainingDuration = false;

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
                    'fullscreenToggle': {},
                    // 'audioTrackButton': {},
                },
                pictureInPictureToggle: true,
            },
        });

        var skipForwardButton = document.createElement('button');
        skipForwardButton.className = 'custom-skip-forward-button';
        skipForwardButton.innerHTML = `
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;">
                <path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path>
            </svg>`;
        skipForwardButton.onclick = function() {
            player.currentTime(player.currentTime() + 10); // Skip forward 10 seconds
        };

        var skipBackwardButton = document.createElement('button');
        skipBackwardButton.className = 'custom-skip-backward-button';
        skipBackwardButton.innerHTML = `
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;">
                <path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path>
            </svg>`;
        skipBackwardButton.onclick = function() {
            player.currentTime(player.currentTime() - 10); // Skip backward 10 seconds
        };

        var controlBar = player.getChild('controlBar');
        controlBar.el().insertBefore(skipBackwardButton, controlBar.getChild('playToggle').el());
        controlBar.el().insertBefore(skipForwardButton, controlBar.getChild('playToggle').el());

        player.on('loadedmetadata', function(){
            var isMobile = window.innerWidth <= 768;
            if(!isMobile){
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
        });

        if( PPV_Plan == '480p' ||  PPV_Plan == '720p'  ){

        const enabledResolutions = PPV_Plan === '480p'
            ? ['240p', '360p', '480p']
            : ['240p', '360p', '480p', '720p'];


            player.on('loadeddata', () => {
                const qualityLevels = player.qualityLevels();
                const levels = Array.from(qualityLevels);

                function filterQualityLevels() {
                    levels.forEach(level => {
                        const resolution = level.height + 'p';
                        if (enabledResolutions.includes(resolution)) {
                            level.enabled = true;
                        } else {
                            level.enabled = false;
                        }
                    });
                }

                filterQualityLevels();

                // Add custom quality selector button
                const qualitySelector = document.createElement('div');
                qualitySelector.className = 'vjs-quality-selector';
                qualitySelector.innerHTML = '<button class="vjs-quality-btn">Quality</button>';

                // Create the menu but keep it hidden initially
                const menu = document.createElement('div');
                menu.className = 'vjs-quality-menu list';
                enabledResolutions.forEach(res => {
                    const button = document.createElement('div');
                    button.className = 'vjs-quality-menu-item';
                    button.textContent = res;
                    button.addEventListener('click', () => {
                        const selectedResolution = res.split('p')[0];
                        levels.forEach(level => {
                            if (level.height === parseInt(selectedResolution, 10)) {
                                level.enabled = true;
                            } else {
                                level.enabled = false;
                            }
                        });
                        // Hide the menu after selection
                        menu.style.display = 'none';
                    });
                    menu.appendChild(button);
                });

                qualitySelector.appendChild(menu);

                qualitySelector.addEventListener('click', (event) => {
                    // Toggle menu visibility
                    if (menu.style.display === 'block') {
                        menu.style.display = 'none';
                    } else {
                        menu.style.display = 'block';
                    }
                    event.stopPropagation(); // Prevent event bubbling
                });

                // Hide menu when clicking outside
                document.addEventListener('click', () => {
                    menu.style.display = 'none';
                });

                // Add the custom button to the player controls
                player.controlBar.el().appendChild(qualitySelector);

                // Force update or refresh the quality selector
                player.trigger('qualityLevelschange');

                console.log('Quality levels:', Array.from(player.qualityLevels()));
            });
        }else{
            // Hls Quality Selector - M3U8
            player.hlsQualitySelector({
                displayCurrentQuality: true,
            });
        }

        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');
        var hovered = false;
        console.log("remainingDuration",remainingDuration);

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
                    skipButton = true;
                } else if (event.type === 'mouseleave') {
                    // console.log("not hovered");
                    hovered = false;
                    skipButton = false;
                }
            }

            // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(hovered == false && remainingDuration == false){
                    skipForwardButton.style.display = 'none';
                    skipBackwardButton.style.display = 'none';
                    playPauseButton.style.display = 'none';
                }
                backButton.style.display = 'none';
                titleButton.style.display = 'none';
            }
        });

        player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(player.currentTime != player.duration){
                    skipForwardButton.style.display = 'block';
                    skipBackwardButton.style.display = 'block';
                    playPauseButton.style.display = 'block';
                    backButton.style.display = 'block';
                    titleButton.style.display = 'block';
                }
            }
        });

        // player.ready(() => {
        //     var started = document.querySelector('.vjs-has-started');
        //     started.addEventListener('click', e=> {
        //         console.log("pause triggered");
        //         player.pause();
        //     })
        // });

        player.on('enterpictureinpicture', function() {
            console.log('Entered Picture-in-Picture mode');
            player.controlBar.hide();
            playPauseButton.style.display = "none";
        });

        player.on('leavepictureinpicture', function() {
            console.log('Exited Picture-in-Picture mode');
            player.controlBar.show();
            playPauseButton.style.display = "block";
        });

        //Function to Play & Pause when we press "Space Bar Button"
        function togglePlayPause(e) {
            if (e.code === 'Space') {
                e.preventDefault();
                if (player.paused()) {
                    player.play();
                } else {
                    player.pause();
                }
            }
        }
        document.addEventListener('keydown', togglePlayPause);

        //Function to "Skip Forward & Backward 10sec" when Arrow key pressed
        function handleKeydown(e) {
            if (e.code === 'ArrowRight') {
                e.preventDefault(); // Prevent default action
                var currentTime = player.currentTime();
                var newTime = Math.min(currentTime + 10, player.duration());
                player.currentTime(newTime);
            }
            if (e.code === 'ArrowLeft') {
                e.preventDefault(); // Prevent default action
                var currentTime = player.currentTime();
                var newTime = Math.min(currentTime - 10, player.duration());
                player.currentTime(newTime);
            }
        }
        document.addEventListener('keydown', handleKeydown);


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
                console.log("Midroll triggered");

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

                console.log("Postroll ads requested");
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
        // player.endcard({
        //     getRelatedContent: getRelatedContent,
        //     // getNextVid: getNextVid,
        //     count: 20
        // });
    });

    function createRelatedContent(title ,slug, image) {

        var div = document.createElement('div');
        div.setAttribute('class', 'card col-2 col-sm-2 col-md-2 col-lg-2');

        var a = document.createElement('a');
        var p = document.createElement('p');
        var img = document.createElement('img');

        img.src = "<?= URL::to('/') . '/public/uploads/images/'?>"+image;//need to set path
        a.href = "<?= URL::to('/category/videos')?>"+'/'+slug;
        p.innerHTML = title;
        a.appendChild(img);
        img.appendChild(p);
        div.appendChild(a);

        return div;
    }

    var rel_content = <?= json_encode($recomended); ?>;
    const contentBoxes = [];

    // Creating related content boxes
    rel_content.map(content => {
        const contentBox = createRelatedContent(content.title, content.slug, content.image);
        contentBoxes.push(contentBox);
    });

    function getRelatedContent(callback) {
        var list = [contentBoxes];
        setTimeout(function () {
            callback(list[0]);
        }, 0);
    }

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
        width: 5%;
        height: 5%;
        top: 65%;
        left: 90%;
        opacity: 0.5;
        cursor: pointer;
    }
    .vjs-watermark:hover{
        opacity: 1;
    }
    .vjs-watermark img{
        width: 100%;
        height: 100%;
    }
    .card{
        display: inline-block;
        /* width: 400px; */
        /* height: 200px; */
        margin : 10px;
        background: transparent;
        cursor: pointer;
    }

    @media only screen and (max-width: 600px){
        .vjs-fg-skip-button{
            bottom: 5.6em !important;
            right: 0.6em !important;
        }
        .video-js .vjs-fg-skip-button .vjs-fg-skip-button-label {
            font-size: 10px;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px){
        .vjs-fg-skip-button{
            bottom: 7.6em;
            right: 1.6em;
        }
        .video-js .vjs-fg-skip-button .vjs-fg-skip-button-label {
            font-size: 12px;
        }
    }

    .video-js .vjs-quality-selector {
    position: relative;
}
/* .vjs-quality-selector:hover .vjs-quality-menu.list {
    display: block;
} */
button.vjs-quality-btn{line-height:4rem;}

.vjs-quality-menu {
    position: absolute;
    bottom: 100%; /* Position the menu above the selector */
    left: -10px;
    background: #2b333f;
    /* border: 1px solid #ccc; */
    border-radius:5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    z-index: 100;
    display: none;
    width: 100%; /* Ensure it takes up the full width of the selector */
}
.vjs-quality-menu.list::after{
    content: "";
    top: 1.95em !important;
    margin-left: 32px;
    border-width: 8px;
    position: relative;
    border-style: solid;
    border-color: #2b333f transparent transparent transparent;
}
.vjs-quality-menu-item:hover,
.vjs-quality-menu-item .vjs-selected{
    background-color:#095ae5;
}

.vjs-quality-menu-item {
    padding: 8px 12px;
    cursor: pointer;
    list-style: none;
    margin: 0;
    padding: 0.6em 0;
    line-height: 1.2em;
    font-size: 1.2em;
    font-family: Roboto;
    text-align: center;
    text-transform: capitalize;
}

.vjs-quality-menu.list{
    position: absolute;
    /* bottom: 5.9em; */
    max-height: 20em;
    background-color: #2b333f;
    border-radius: 5px;
    width: 8em;
}

</style>
