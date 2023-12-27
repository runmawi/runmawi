<script>
    let video_url =
        "https://demo.unified-streaming.com/k8s/features/stable/video/tears-of-steel/tears-of-steel.ism/.m3u8";

    var player = videojs('my-video');

    player.concat({
        manifests: [{
            url: 'https://demo.unified-streaming.com/k8s/features/stable/video/tears-of-steel/tears-of-steel.ism/.m3u8',
            mimeType: 'application/x-mpegURL'
        }, {
            url: 'https://s3.amazonaws.com/_bc_dml/example-content/bipbop-advanced/bipbop_16x9_variant.m3u8',
            mimeType: 'application/x-mpegURL'
        }],
        targetVerticalResolution: 720,
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
