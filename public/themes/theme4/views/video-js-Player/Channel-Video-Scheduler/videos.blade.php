@php include public_path('themes/theme4/views/header.php');  @endphp

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >

    
{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>
    
{{-- Player HTML --}}

    <div class="container-fluid p-0">
        <video id="channel-video-scheduler-player" class="video-js vjs-theme-fantasy vjs-icon-hd vjs-layout-x-large" 
            controls preload="auto"  poster="{{ $AdminEPGChannel->Player_image_url }}" style="width:100%;height:100%;">
        </video>
    </div>

@php 
    include public_path('themes/theme4/views/video-js-Player/Channel-Video-Scheduler/Player_Script.blade.php');
    include public_path('themes/theme4/views/footer.blade.php'); 
@endphp