@php include public_path('themes/default/views/header.php');  @endphp

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>

    <div class="container-fluid p-0">

        @if ( $videodetail->type == "embed" )

            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>

            <video id="my-video" class="video-js vjs-theme-fantasy vjs-icon-hd vjs-layout-x-large" controls 
                    preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    muted="muted" preload="yes" autoplay="autoplay"  >
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
            </video>
        @endif
    </div>
@php 

    include public_path('themes/theme4/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/theme4/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/theme4/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/theme4/views/footer.blade.php'); 

@endphp

<style>
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    .staticback-btn{display:none;}
    .container-fluid:hover .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; }
</style>