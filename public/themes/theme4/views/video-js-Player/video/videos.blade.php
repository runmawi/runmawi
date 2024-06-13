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
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </button>


            <button class="custom-skip-forward-button">
            <svg width="56" height="58" viewBox="0 0 56 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M47.5494 22.5385C49.5419 28.0918 49.1582 34.4531 45.938 39.9377C40.1725 49.7375 27.562 53.0251 17.7571 47.2682C7.95228 41.5113 4.66975 28.8922 10.4266 19.0873C14.4012 12.3179 21.6401 8.65949 28.9677 8.93799" stroke="white" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.4856 2.49956L31.9713 8.0691L26.4018 17.5549" fill="white"/>
                <path d="M22.4856 2.49956L31.9713 8.0691L26.4018 17.5549L22.4856 2.49956Z" stroke="white" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.0465 25.0804H22.0065L19.6265 26.2804L19.2065 24.4204L22.3665 22.8604H24.4265V35.8704H22.0465V25.0804Z" fill="white"/>
                <path d="M38.0966 29.2804C38.0966 33.4604 36.4566 36.0904 33.3566 36.0904C30.3566 36.0904 28.7466 33.3704 28.7266 29.4004C28.7266 25.3604 30.4466 22.6304 33.4866 22.6304C36.6366 22.6404 38.0966 25.4404 38.0966 29.2804ZM31.2166 29.4004C31.1966 32.5604 32.0766 34.2004 33.4366 34.2004C34.8766 34.2004 35.6366 32.4404 35.6366 29.3204C35.6366 26.3004 34.9166 24.5204 33.4366 24.5204C32.1166 24.5204 31.1966 26.1404 31.2166 29.4004Z" fill="white"/>
            </svg>
            </button>  

            <button class="custom-skip-backward-button">
            <svg width="56" height="58" viewBox="0 0 56 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.57317 22.5385C5.58064 28.0918 5.96437 34.4531 9.18457 39.9377C14.9501 49.7375 27.5606 53.0251 37.3654 47.2682C47.1703 41.5113 50.4528 28.8922 44.6959 19.0873C40.7213 12.3179 33.4825 8.65949 26.1548 8.93799" stroke="white" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M32.637 2.49956L23.1512 8.0691L28.7208 17.5549" fill="white"/>
                <path d="M32.637 2.49956L23.1512 8.0691L28.7208 17.5549L32.637 2.49956Z" stroke="white" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.8659 25.0804H19.8259L17.4459 26.2804L17.0259 24.4204L20.1859 22.8604H22.2459V35.8704H19.8659V25.0804Z" fill="white"/>
                <path d="M35.9159 29.2804C35.9159 33.4604 34.2759 36.0904 31.1759 36.0904C28.1759 36.0904 26.5659 33.3704 26.5459 29.4004C26.5459 25.3604 28.2659 22.6304 31.3059 22.6304C34.4559 22.6404 35.9159 25.4404 35.9159 29.2804ZM29.0359 29.4004C29.0159 32.5604 29.8959 34.2004 31.2559 34.2004C32.6959 34.2004 33.4559 32.4404 33.4559 29.3204C33.4559 26.3004 32.7359 24.5204 31.2559 24.5204C29.9359 24.5204 29.0159 26.1404 29.0359 29.4004Z" fill="white"/>
            </svg>
            </button> 
            
            <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                    preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    muted="muted" preload="yes" autoplay="autoplay"  >
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

    include public_path('themes/theme4/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/theme4/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/theme4/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/theme4/views/footer.blade.php'); 

@endphp

<style>
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
</style> 