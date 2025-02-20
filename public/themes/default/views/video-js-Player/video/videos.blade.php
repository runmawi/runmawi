@php include public_path('themes/default/views/header.php');  @endphp

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" /> -->
    <link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <div class="container-fluid p-0" style="position:relative">

        @if ( $videodetail->users_video_visibility_status)

            @if ( $videodetail->type == "embed" )

                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>

                    <iframe class="" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen style="width: 100%; height: 100vh;">
                    </iframe>
                <!-- before we have 75vh -->
            @else

                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>

                <div class="vjs-title-bar">{{$videodetail->title}}</div>

                <button class="custom-skip-forward-button">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                </button>

                <button class="custom-skip-backward-button">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                </button>

                <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                    width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    autoplay="false">
                    <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">

                                    {{-- Subtitle --}}
                        @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1 && isset($subtitles) && count($subtitles) > 0)
                            @foreach($subtitles as $subtitles_file)
                                <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                                    label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                            @endforeach
                        @endif
                </video>

            @endif

            <div class="video" id="visibilityMessage" style="color: white; display: none; background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $videodetail->player_image_url  }}');background-size: cover; height:100vh;">
                <div class="row container" style="padding-top:4em;">
                    <div class="col-2"></div>

                    <div class="col-lg-3 col-6 mt-5">
                        <img class="posterImg w-100"  src="{{ $videodetail->image_url }}" >
                    </div>

                    <div class="col-lg-6 col-6 mt-5">

                        <h2 class="title">{{ optional($videodetail)->title }} </h2><br>
                        <h5 class="title"> {{ $videodetail->users_video_visibility_status_message }}</h5><br>
                        <a class="btn" href="{{ $videodetail->users_video_visibility_redirect_url }}">

                            <div class="playbtn" style="gap:5px">
                                {!! $play_btn_svg !!}
                                <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                            </div>
                        </a>

                        @if( !Auth::guest() && Auth::user()->role == "registered" && $videodetail->access == "ppv")
                            <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( 'Subscribe Now' ) }} </span>
                                </div>
                            </a>
                        @endif

                         {{-- subscriber & PPV  --}}

                        {{-- @if ( $videodetail->access == "subscriber" && !is_null($videodetail->ppv_price) )
                            <a class="btn" href="{{ $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id,PPV_CurrencyConvert($videodetail->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id, $videodetail->ppv_price ]) }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif --}}
                    </div>
                </div>
            </div>

        @else

            <div class="video" style="background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $videodetail->player_image_url  }}');background-size: cover; height:100vh;">
                <div class="row container" style="padding-top:4em;">
                    <button class="staticback-btn" onclick="history.back()" title="Back Button">
                        <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                    </button>

                    <div class="col-2"></div>

                    <div class="col-lg-3 col-6 mt-5">
                        <img class="posterImg w-100"  src="{{ $videodetail->image_url }}" >
                    </div>

                    <div class="col-lg-6 col-6 mt-5">

                        <h2 class="title">{{ optional($videodetail)->title }} </h2><br>

                        <h5 class="title"> {{ $videodetail->users_video_visibility_status_message }}</h5><br>

                        <a class="btn" href="{{ $videodetail->users_video_visibility_redirect_url }}">
                            <div class="playbtn" style="gap:5px">
                                {!! $play_btn_svg !!}
                                <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                            </div>
                        </a>

                        @if( !Auth::guest() && Auth::user()->role == "registered" && $videodetail->access == "ppv")
                            <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( 'Subscribe Now' ) }} </span>
                                </div>
                            </a>
                        @endif

                            {{-- subscriber & PPV  --}}

                        {{-- @if ( $videodetail->access == "subscriber" && !is_null($videodetail->ppv_price) )
                            <a class="btn" href="{{ $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id,PPV_CurrencyConvert($videodetail->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id, $videodetail->ppv_price ]) }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif --}}

                    </div>
                </div>
            </div>
        @endif
    </div>

@php
    include public_path('themes/default/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/default/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/default/views/footer.blade.php');
@endphp


@if(isset($setting) && $setting->video_clip_enable == 1 && count($videoURl) > 0)
    @php include public_path('themes/default/views/video-js-Player/video/Concat_Player_Script.blade.php'); @endphp
@else
    @php include public_path('themes/default/views/video-js-Player/video/player_script.blade.php'); @endphp
@endif

<style>
    .my-video.vjs-fluid {
        padding-top: 0 !important;
        /* height: 100vh; */
    }
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    body.light-theme span { color: white !important;}
    .my-video.video-js .vjs-big-play-button span{ color: black !important;}
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    .custom-skip-backward-button .custom-skip-forward-button{font-size: 45px;color: white;}
</style>
