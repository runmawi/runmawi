
<script>
    const videoData = [
        { url: 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', startTime: 0, endTime: 10 },
        { url: 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', startTime: 10, endTime: 20 },
        // Add more video entries as needed
    ];

    const video = document.getElementById('dynamicVideo');

    function changeVideoSource() {
        const currentTime = video.currentTime;

        for (const entry of videoData) {
            if (currentTime >= entry.startTime && currentTime < entry.endTime && video.src !== entry.url) {
                video.src = entry.url;
                video.load(); // Load the new video source
                video.play(); // Play the new video
                break; // Exit the loop after changing the source
            }
        }
    }

    video.addEventListener('timeupdate', changeVideoSource);
</script>