
<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" /> -->
    <link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<style>
    #videotitle{
        position: absolute;
        z-index: +1;
        color: white;
        top: 6%;
        left: 2%;
    }
    #videofavicon{
        position: absolute;
        z-index: +1;
        color: white;
        top: 10%;
        left: 2%;
    }
</style>

<?php
    if ($video->type == "mp4_url") {
        $videos_url = $video->mp4_url;
        $video_player_type = 'video/mp4';
    } elseif ($video->type == "m3u8_url") {
        $videos_url = $video->m3u8_url;
        $video_player_type = 'application/x-mpegURL';
    } elseif ($video->type == "embed") {
        $videos_url = $video->embed_code;
        $video_player_type = 'video/webm';
    } elseif ($video->type == null && pathinfo($video->mp4_url, PATHINFO_EXTENSION) == "mp4") {
        $videos_url = URL::to('/storage/app/public/' . $video->path . '.m3u8');
        $video_player_type = 'application/x-mpegURL';
    } else {
        $videos_url = null;
        $video_player_type = null;
    }
?>
    <input type="hidden" id="video_type" value="<?php echo $video->type;?>">
        <div id="video_container" class="fitvid">
       
        @if ( $video->type == "embed" )

                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>

                    <iframe class="" src="<?= $videos_url ?>" poster="<?= $video->player_image ?>"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen style="width: 100%; height: 100vh;">
                    </iframe>
                <!-- before we have 75vh -->
            @else
            <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                    width="auto" height="auto" poster="{{ $video->player_image }}" playsinline="playsinline"
                    autoplay>
                    <source src="{{ $videos_url }}" type="{{ $video_player_type }}">

                                    {{-- Subtitle --}}
                        @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1 && isset($subtitles) && count($subtitles) > 0)
                            @foreach($subtitles as $subtitles_file)
                                <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                                    label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                            @endforeach
                        @endif
                </video>

            @endif
        </div>


<script>

        if (!videojs.getPlugin('hlsQualitySelector')) {
            videojs.registerPlugin('hlsQualitySelector', function(options) {
                console.log('hlsQualitySelector plugin registered');
            });
        }

        var videoId = "<?php echo $video->id; ?>";
        var PPV_Plan = "";

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
                html5: {
                    vhs: {
                        overrideNative: true,
                    }
                }
            });

            const playPauseButton = document.querySelector('.vjs-big-play-button');
            const skipForwardButton = document.querySelector('.custom-skip-forward-button');
            const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
            const backButton = document.querySelector('.staticback-btn');
            const titleButton = document.querySelector('.vjs-title-bar');
            var controlBar = player.getChild('controlBar');

            player.on('loadedmetadata', function() {
                console.log('Video metadata loaded');

                player.on('timeupdate', function() {
                    var currentTime = player.currentTime();
                    var duration = player.duration();
                    saveContinueWatching(videoId, duration, currentTime);
                });

                player.on('pause', function() {
                    var currentTime = player.currentTime();
                    var duration = player.duration();
                    saveContinueWatching(videoId, duration, currentTime);
                });

                window.addEventListener('beforeunload', function() {
                    var currentTime = player.currentTime();
                    var duration = player.duration();
                    saveContinueWatching(videoId, duration, currentTime);
                });
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
                    skipButton = true;
                } else if (event.type === 'mouseleave') {
                    // console.log("not hovered");
                    hovered = false;
                    skipButton = false;
                }
            }

            // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
            if (skipForwardButton && skipBackwardButton) {
                if(hovered == false && remainingDuration == false){
                    skipForwardButton.style.visibility = 'hidden';
                    skipBackwardButton.style.visibility = 'hidden';
                    // playPauseButton.style.visibility = 'hidden';
                    $('.vjs-big-play-button').hide();
                    backButton.style.visibility = 'hidden';
                    titleButton.style.visibility = 'hidden';
                }
            }
        });

        player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
            if (skipForwardButton && skipBackwardButton) {
                if(player.currentTime != player.duration){
                    skipForwardButton.style.visibility = 'visible';
                    skipBackwardButton.style.visibility = 'visible';
                    // playPauseButton.style.visibility = 'visible';
                    $('.vjs-big-play-button').show();
                    backButton.style.visibility = 'visible';
                    titleButton.style.visibility = 'visible';
                }
            }
        });

        player.ready(() => {
            playPauseButton.addEventListener('click', e => {
                var playing = document.querySelector('.vjs-playing');
                if(playing){
                    console.log("pause triggered");
                    player.pause();
                }
                else{
                    console.log("play triggered");
                    player.play();
                }
            })
        });

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

    .vjs-watermark:hover{
        opacity: 100%;
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
