<script>
    document.addEventListener("DOMContentLoaded", function() {

    const player = videojs('channel-video-scheduler-player', {
        controlBar: {
            volumePanel: { inline: false },
            children: {
                // 'flexibleWidthSpacer': {},
                'progressControl': {},
                'subtitlesButton': {},
                'fullscreenToggle': {},
            },
            pictureInPictureToggle: true,
        }
    });

    // Function to reload the video player when paused for 10sec & more.
    var pauseStartTime = null;
    var totalPausedTime = 0;
    player.on('pause', function() {
        pauseStartTime = new Date();
    });

    player.on('play', function() {
        if (pauseStartTime !== null) {
            var pauseEndTime = new Date();
            var pauseDuration = (pauseEndTime - pauseStartTime) / 1000;

            totalPausedTime += pauseDuration;
            pauseStartTime = null;

            // console.log("Total paused time: " + Math.floor(totalPausedTime));
            if(Math.floor(totalPausedTime) >= 10){
                player.pause();
                window.location.reload();
            }
            totalPausedTime = 0;
        }
    });

    const playPauseButton = document.querySelector('.vjs-big-play-button');
    player.on('userinactive', () => { 
    if (playPauseButton) {
        playPauseButton.style.display = 'none';
    }
    });

    player.on('useractive', () => {
    if (skipForwardButton && skipBackwardButton && playPauseButton) {
        playPauseButton.style.display = 'block';
    }
    });
        // Hls Quality Selector - M3U8 

        player.hlsQualitySelector({
            displayCurrentQuality: true,
        });

        // Concat 

        let videoList = <?php echo json_encode($AdminEPGChannel->ChannelVideoScheduler); ?>;

        let manifests = videoList.map(function(item) {
            return {
                url: item.videos_list.url,
                mimeType: item.videos_list.mimeType,
            };
        });

        // console.log( videoList );

        player.concat({

            manifests: manifests,

            targetVerticalResolution: 720,

            callback: (err, result) => {
                if (err) {
                    console.error(err);
                    return;
                }

                // console.log(result);

                player.src({
                    src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
                    type: 'application/vnd.videojs.vhs+json',
                });
            }
        });
    });
</script>

<style>
    .vjs-progress-control{
        pointer-events: none;
    }
</style>