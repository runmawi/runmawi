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

        @if ( $videodetail->type == "embed" )

            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>

            <div class="custom-skip-forward-button" onclick="skipDuration(10)">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512">
                <path fill="#ffffff" d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/>
            </svg>
            </div> 

               
            <div class="custom-skip-backward-button" onclick="skipDuration(-10)">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512">
                    <path fill="#ffffff" d="M125.7 160H176c17.7 0 32 14.3 32 32s-14.3 32-32 32H48c-17.7 0-32-14.3-32-32V64c0-17.7 14.3-32 32-32s32 14.3 32 32v51.2L97.6 97.6c87.5-87.5 229.3-87.5 316.8 0s87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3s-163.8-62.5-226.3 0L125.7 160z"/>
                </svg>
            </div>  

            <video id="my-video" class="vjs-big-play-centered vjs-theme-city my-video video-js vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" >
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">

                
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

    include public_path('themes/default/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/default/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/default/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/default/views/footer.blade.php'); 


@endphp


<style>
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    .staticback-btn{display:none;}
    .container-fluid:hover .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; }
    .custom-skip-backward-button .custom-skip-forward-button{font-size: 45px;color: white;}
</style>
