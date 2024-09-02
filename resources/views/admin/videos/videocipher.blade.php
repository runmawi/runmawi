<!-- <iframe
        src="https://player.vdocipher.com/v2/?otp={{ $otp }}&playbackInfo={{ $playbackInfo }}"
        style="border:0;width:720px;height:405px"
        allow="encrypted-media"
        allowfullscreen 
    ></iframe> -->

    <html>
  <body>
    <iframe
      src="https://player.vdocipher.com/v2/?otp={{ $otp }}&playbackInfo={{ $playbackInfo }}&primaryColor=4245EF"
      frameborder="0"
      allow="encrypted-media"
      style="border:0;width:720px;height:405px"
      allowfullscreen
    ></iframe>

    <script src="https://player.vdocipher.com/v2/api.js"></script>
    <script>
    const iframe = document.querySelector('iframe');
// Creating player instance
const player = VdoPlayer.getInstance(iframe);

// Get available video qualities
player.api.getVideoQualities().then(function (qualities) {
    console.log('Available Qualities:', qualities);

    if (qualities.qualities.length > 0) {
        // Assume we want to set to the highest quality
        const highestQualityId = qualities.qualities[qualities.qualities.length - 1].id;

        // Set video quality to the highest available quality
        player.api.setVideoQuality(highestQualityId).then(function () {
            console.log('Quality set to highest:', highestQualityId);
        }).catch(function (error) {
            console.error('Failed to set quality:', error);
        });
    } else {
        console.log('No manual quality options available, using adaptive streaming.');
    }
}).catch(function (error) {
    console.error('Failed to get video qualities:', error);
});

// Example: Log total played time on play event
player.video.addEventListener('play', function () {
    console.log('Video is playing');
    player.api.getTotalPlayed().then(function (data) {
        console.log('Total played time: ', data);
    });
});
    </script>
  </body>
</html>
