<script>
    let videos = <?php echo json_encode($default_scheduler_datas); ?>;

    const currentTime = '<?php echo $currentTime; ?>';

        // const currentTime = "15:12:21";

        const player = videojs('video-player', {
            controlBar: {
                volumePanel: { inline: false },
                children: {
                    // 'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {},
                },
                pictureInPictureToggle: true,
            }
        });


        // console.log('pause',player.paused());
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