<!-- resources/views/video.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Video Player</title>
    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    <style>
        #video-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        #no-video-message {
            display: none;
            font-size: 24px;
            color: red;
        }
    </style>
</head>
<body>
    <div id="video-container">
        <video id="video-player" class="video-js" controls preload="auto" width="640" height="360"></video>
        <div id="no-video-message">No video available for now</div>
    </div>

    <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
    <script src="https://unpkg.com/videojs-contrib-hls@5.15.0/dist/videojs-contrib-hls.min.js"></script>

    <script>
        // Your video data from the controller
        const videos = @json($videos);
        const currentTime = "15:52:21";

        // Initialize Video.js player
        const player = videojs('video-player');

        // Helper function to convert time string (HH:MM:SS) to seconds
        function timeToSeconds(time) {
            const parts = time.split(':');
            return (+parts[0]) * 3600 + (+parts[1]) * 60 + (+parts[2]);
        }

        // Function to start playing the scheduled videos
        function playScheduledVideos() {
            const currentDateTime = new Date();
            const currentSeconds = timeToSeconds(currentTime);

            let currentVideoIndex = 0;
            let videoFound = false;

            function playNextVideo() {
                if (currentVideoIndex >= videos.length) {
                    // No more videos to play
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

                // Determine the play start time based on the current time
                let playStartTime = 0;

                if (currentSeconds < startTime) {
                    // If current time is before the start time, wait and then play from start
                    const waitTime = startTime - currentSeconds;
                    setTimeout(() => {
                        player.src({ type: video.video_player_type, src: video.url });
                        player.play();
                    }, waitTime * 1000);
                } else if (currentSeconds >= startTime && currentSeconds <= endTime) {
                    // If current time is between start and end times, play from the corresponding time
                    videoFound = true;
                    playStartTime = currentSeconds - startTime;
                    player.src({ type: video.video_player_type, src: video.url });
                    player.currentTime(playStartTime);
                    player.play();
                } else {
                    // If current time is after the end time, skip to the next video
                    currentVideoIndex++;
                    playNextVideo();
                    return;
                }

                // Listen for the 'ended' event to play the next video
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
</body>
</html>
