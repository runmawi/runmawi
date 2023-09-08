@php
    include public_path('themes/default/views/header.php');
@endphp

{{-- video-js Style --}}

    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">

{{-- video-js Script --}}

    <script src="https://vjs.zencdn.net/7.11.8/video.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@2.0.6/dist/videojs-contrib-quality-levels.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.js"></script>

    <div class="col-md-12 container">
        <video id="player" class="video-js vjs-theme-fantasy" controls preload="auto" width="640" height="268"  >
            <source src="https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8" type="application/x-mpegURL">
        </video>
    </div>

<script>

    var player = videojs('player', {
        aspectRatio: '16:9',
        playbackRates: [0.5,1,1.5,2,3,4]
    });

    player.httpSourceSelector();
    
</script>

@php include public_path('themes/default/views/footer.blade.php'); @endphp