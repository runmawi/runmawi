<script>
    let videos = <?php echo json_encode($epg_scheduler_datas); ?>;

    const currentTime = '<?php echo $currentTime; ?>';

        // const currentTime = "15:12:21";

        const player = videojs('video-player', {
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
          // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
          if (playPauseButton) {
            playPauseButton.style.display = 'none';
          }
        });

        player.on('useractive', () => {
          // Show the Play pause, skip forward and backward buttons when the user becomes active
          if (playPauseButton) {
            playPauseButton.style.display = 'block';
          }
        });


        function timeToSeconds(time) {
            const parts = time.split(':');
            return (+parts[0]) * 3600 + (+parts[1]) * 60 + (+parts[2]);
        }

        function playScheduledVideos() {
            const currentDateTime = new Date();
            const currentSeconds = timeToSeconds(currentTime);

            let currentVideoIndex = 0;
            let videoFound = false;

            function playNextVideo() {
                if (currentVideoIndex >= videos.length) {
                    if (!videoFound) {
                        document.getElementById('no-video-message').style.display = 'block';
                        player.el().style.display = 'none';
                    }
                    return;
                }

                const video = videos[currentVideoIndex];
                const startTime = timeToSeconds(video.start_time);
                const endTime = timeToSeconds(video.end_time);
                const duration = timeToSeconds(video.duration);

                let playStartTime = 0;

                if (currentSeconds < startTime) {
                    const waitTime = startTime - currentSeconds;
                    setTimeout(() => {
                        player.src({ type: video.video_player_type, src: video.url });
                        player.play();
                    }, waitTime * 1000);
                } else if (currentSeconds >= startTime && currentSeconds <= endTime) {
                    videoFound = true;
                    playStartTime = currentSeconds - startTime;
                    player.src({ type: video.video_player_type, src: video.url });
                    player.currentTime(playStartTime);
                    player.play();
                } else {
                    currentVideoIndex++;
                    playNextVideo();
                    return;
                }

                player.on('ended', function() {
                    currentVideoIndex++;
                    playNextVideo();
                });
            }

            playNextVideo();
        }

        // Start the video schedule
        playScheduledVideos();

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

    .vjs-progress-control{
        pointer-events: none;
    }
</style>