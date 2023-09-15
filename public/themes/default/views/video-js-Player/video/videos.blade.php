@php 
    include public_path('themes/default/views/header.php'); 
@endphp

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

    <div class="container">
        <video id="my-video" class="video-js vjs-theme-fantasy vjs-icon-hd" controls preload="auto" width="100%" height="auto" poster="{{ $videodetail->player_image_url }}" >
            <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
        </video>
    </div>

@php 

    include public_path('themes/default/views/video-js-Player/video/videos_ads.blade.php');

    include public_path('themes/default/views/video-js-Player/video/player_script.blade.php');

    include public_path('themes/default/views/footer.blade.php'); 

@endphp