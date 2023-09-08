@php
    include public_path('themes/default/views/header.php');
@endphp

{{-- video-js Style --}}

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">

{{-- video-js Script --}}

<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="{{ asset('public/themes/default/assets/js/video-js/video.min.js') }}"></script>
<script src="{{ asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
<script src="{{ asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
<script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ads.min.js') }}"></script>
<script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ima.min.js') }}"></script>

<div class="container">
    <video id="my-video" class="video-js vjs-theme-fantasy" controls preload="auto" width="100%" height="auto">
        <source src="https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8" type="application/x-mpegURL">
    </video>
</div>


@php include public_path('themes/default/views/video-js-Player/video/player_script.blade.php'); @endphp

@php include public_path('themes/default/views/footer.blade.php'); @endphp
