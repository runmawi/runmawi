@php include public_path('themes/default/views/header.php');  @endphp
{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>

    <div class="container-fluid p-0">
            <div id="video-container">
                <video id="video-player" class="vjs-theme-city my-video video-js vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls preload="auto" width="auto" height="auto" controls preload="auto" width="640" height="360"></video>
                <div id="no-video-message">No video available for now</div>
            </div>
    </div>

@php 
    include public_path('themes/default/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/default/views/DefaultVideoScheduler/player_script.blade.php');
    include public_path('themes/default/views/footer.blade.php'); 
@endphp

@php  @endphp

<style>
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    .staticback-btn{display:none;}
    .container-fluid:hover .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size: 25px; }
    .custom-skip-backward-button .custom-skip-forward-button{font-size: 45px;color: white;}
</style>