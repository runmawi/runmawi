
<link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/2.5.12/controls.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  
<video id="video" data-shaka-player
           width="640"
             style="width:100%;height:100%" ></video>

        <script src=https://cdn.jsdelivr.net/npm/shaka-player@4.7.11/dist/shaka-player.compiled.debug.js></script>
        <script src="https://cdn.jsdelivr.net/npm/shaka-player@4.7.11/dist/shaka-player.ui.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shaka-player@4.7.11/dist/controls.css">


<script>

    const streamApiHostName="https://video.bunnycdn.com";
    const libraryId=270162;
    const videoId="d93942ff-a5ed-42a9-bbd8-f1759098835f";
    const storageZoneId="vz-408b4d55-9c6";
    const storageDomain="b-cdn.net";

    const manifestUri =`https://${storageZoneId}.${storageDomain}/${videoId}/playlist.m3u8`;

        const fpCertificateUri=`${streamApiHostName}/FairPlay/${libraryId}/certificate`;
        const fpLicenseUri=`${streamApiHostName}/FairPlay/${libraryId}/license/?videoId=${videoId}`;
        const wvLicenseUri=`${streamApiHostName}/WidevineLicense/${libraryId}/${videoId}`;

        async function initApp() {
        // Install built-in polyfills to patch browser incompatibilities.
        shaka.polyfill.installAll();

        // Check to see if the browser supports the basic APIs Shaka needs.
        if (shaka.Player.isBrowserSupported()) {
            // Everything looks good!
            initPlayer();
        } else {
            // This browser does not have the minimum set of APIs we need.
            console.error('Browser not supported!');
        }
        }


        async function initPlayer() {
    const video = document.getElementById('video');
    const player = new shaka.Player(video);

    // Attach the UI to the video element
    const ui = new shaka.ui.Overlay(player, video.parentElement, video);
    ui.getControls();

    // If Library has Enterprise DRM enabled, configure Widevine and FairPlay license URLs
    player.configure({
        drm: {
            servers: {
                'com.widevine.alpha': wvLicenseUri,
                'com.apple.fps': fpLicenseUri
            }
        }
    });

    player.configure('drm.advanced.com\\.apple\\.fps.serverCertificateUri',
                     fpCertificateUri);

    video.addEventListener("error", (event) => {
        console.error(event);
    });

    // Attach Shaka Player to the HTML element
    await player.attach(video);

    window.player = player;

    player.addEventListener('error', onErrorEvent);

    try {
        await player.load(manifestUri);
        console.log('The video has now been loaded!');
    } catch (e) {
        onError(e);
    }
}


        function onErrorEvent(event) {
        // Extract the shaka.util.Error object from the event.
        onError(event.detail);
        }

        function onError(error) {
        // Log the error.
        console.error('Error code', error.code, 'object', error);
        }


        document.addEventListener('DOMContentLoaded', initApp);

</script>