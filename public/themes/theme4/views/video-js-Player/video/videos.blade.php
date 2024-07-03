@php include public_path('themes/default/views/header.php');  @endphp

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" />
    <!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme4/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-watermark@2.0.0/dist/videojs-watermark.min.css" rel="stylesheet">

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
    <!-- <script src="https://vjs.zencdn.net/7.15.4/video.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/videojs-watermark@0.2.2/dist/videojs-watermark.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/videojs-watermark@2.0.0/dist/videojs-watermark.min.js"></script>



    <div class="container-fluid p-0">

        @if ( $videodetail->type == "embed" )

            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

        <button class="staticback-btn" onclick="history.back()" title="Back Button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </button>


        <button class="custom-skip-forward-button">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
        </button>  

        <button class="custom-skip-backward-button">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
        </button> 
            
            <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                    preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    muted="muted" autoplay="autoplay"  >
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
            
                <!-- <track kind="descriptions" src="descriptions.vtt" srclang="en" label="English" default>
                <track kind="descriptions" src="descriptions.vtt" srclang="tn" label="Tamil">    -->
            
                @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1)
                    @if(isset($subtitles) && count($subtitles) > 0)
                        @foreach($subtitles as $subtitles_file)
                            <track kind="subtitles" src="{{ $subtitles_file->url }}"
                                srclang="{{ $subtitles_file->sub_language }}"
                                label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif>
                        @endforeach
                    @endif
                @endif
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
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    /* .vjs-watermark {
      width: 100px;
      height: auto;
      position: absolute;
      bottom: 10px;
      right: 10px;
      z-index: 1000;
      opacity: 0.5;
    } */
</style> 