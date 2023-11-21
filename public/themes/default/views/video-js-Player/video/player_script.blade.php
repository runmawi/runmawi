<script>
    var player = videojs('my-video');

    // player.offset({
    //     start: 10,
    //     end: 20,
    //     restart_beginning: false //Should the video go to the beginning when it ends
    // });


    player.concat({
        manifests: [{
            url: 'https://localhost/flicknexs/storage/app/public/JO7Y5p3aBZd51Ws7.m3u8#t=12,14',
            mimeType: 'application/x-mpegURL',
        }, {
            url: 'https://localhost/flicknexs/storage/app/public/JO7Y5p3aBZd51Ws7.m3u8#t=30,60',
            mimeType: 'application/x-mpegURL'
        }],
        callback: (err, result) => {
            if (err) {
                console.error(err);
                return;
            }
            console.log(result);
            player.src({
                src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
                type: 'application/vnd.videojs.vhs+json'
            });
        }
    });
</script>
