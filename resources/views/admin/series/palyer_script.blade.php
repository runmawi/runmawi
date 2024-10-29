
<script>

    if (!videojs.getPlugin('hlsQualitySelector')) {
        videojs.registerPlugin('hlsQualitySelector', function(options) {
            console.log('hlsQualitySelector plugin registered');
        });
    }

    let video_url = "<?php echo $episodeURL; ?>";
    var videoId = "<?php echo $episodes->id; ?>";

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

        player.el().appendChild(skipForwardButton);
        player.el().appendChild(skipBackwardButton);
        player.el().appendChild(titleButton);
        player.el().appendChild(backButton);
        
      
        player.on('loadedmetadata', function() {
            updateControls();
        });

        window.addEventListener('resize', function() {
            updateControls();
        });
            // Hls Quality Selector - M3U8
            player.hlsQualitySelector({
                displayCurrentQuality: true,
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
