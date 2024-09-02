<?php
    include public_path('themes/default/views/header.php');
    include public_path('themes/default/views/episode_ads.blade.php');

    $autoplay = $episode_ads == null ? 'autoplay' : '';
    $series = App\series::first();
    $series = App\series::where('id', $episode->series_id)->first();
    $SeriesSeason = App\SeriesSeason::where('id', $episode->season_id)->first();
    $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first() ;

?>

<!-- video-js Style  -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet">
<!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css"
    rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/videos-player.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet">
<link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

<!-- video-js Script  -->

<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs.ads.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs.ima.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/end-card.js') ?>"></script>
<script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>

    <style>

    /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
            content: none;
        }

        ol.breadcrumb {
                color: white;
                background-color: transparent !important  ;
                font-size: revert;
        }
        @media (max-width:768px){
            .col-6 p{
                font-size: 12px;
            }
            button#button {
                font-size: 12px;
            }
            div#subscribers_only{
                padding-top: 40px !important;
            }
        }
        .vjs-icon-hd:before{
        display:none;
    }
    #episode-player_ima-ad-container div{ overflow:hidden;}
    #episode-player { position: relative; }
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    #series_container { position: relative;}
    .slick-arrow{z-index: 99;}
    .slick-next{right:0;}
    .slick-prev{left:10px;}
    .view-count .rent-video .btn .btn-primary{
        text-transform: uppercase;
    }
    .custom-skip-forward-button, .custom-skip-backward-button{
        top: -250px !important;
    }
    .vjs-fullscreen .custom-skip-backward-button, .vjs-fullscreen .custom-skip-forward-button {
        top: -335px !important;
    }
    .custom-skip-backward-button{
        left: 31% !important;
    }
    @media (min-width:601px){
        .my-video.vjs-fluid{height: calc(100vh - 85px)!important;}
    }
    @media only screen and (max-width: 600px) {
        .custom-skip-forward-button, .custom-skip-backward-button {
            /* right: 20%; */
            top: 46% !important;
        }
    }
    @media screen and (max-width: 768px) {
        .description{
            margin-top: 5%;
        }
    }
    </style>

    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;">
            {{ Session::get('message') }}
        </div>
    @endif


    <!-- free content - hide & show -->

    <!-- <div class="row free_content">
      <div class="col-md-12">
         <p class="Subscribe">Subscribe to watch</p>
      </div>

      <div class="col-md-12">
         <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
               <button style="margin-left: 34%;margin-top: 0%;" class="btn btn-primary"id="button">Become a subscriber to watch this video</button>
         </form>
      </div>

      <div class="col-md-12"> <p class="Subscribe">Play Again</p>
         <div class="play_icon">
            <a href="#" onclick="window.location.reload(true);"><i class="fa fa-play-circle" aria-hidden="true"></i></a>
         </div>
      </div>
   </div> -->

    <input type="hidden" value="{{ url('/') }}" id="base_url">
    <input type="hidden" id="videoslug" value="{{ isset($episode->path) ? $episode->path : '0' }}">
    <input type="hidden" value="{{ $episode->type }}" id="episode_type">



    <div id="series_bg">
        <div class="">
            @if(!Auth::guest())
                @if($free_episode > 0)
                    @if($free_episode > 0)

                            <div id="series_container">
                                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                </button>

                                <div class="titlebutton">{{$episode_details->title}}</div>

                                <!-- <button class="custom-skip-forward-button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                                </button>

                                <button class="custom-skip-backward-button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                                </button> -->

                                <video id="episode-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                                    width="auto" height="auto" poster="<?= $episode_details->Player_thumbnail ?>" playsinline="playsinline"
                                    autoplay>
                                        <source src="<?= $episode_details->Episode_url ?>"
                                        type="<?= $episode_details->Episode_player_type ?>">
                                        @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1)
                                            @if(isset($episodesubtitles) && count($episodesubtitles) > 0 )
                                                @foreach ($episodesubtitles as $episodesubtitles_file)
                                                    <track kind="subtitles" src="{{ $episodesubtitles_file->url }}"
                                                        srclang="{{ $episodesubtitles_file->sub_language }}"
                                                        label="{{ $episodesubtitles_file->shortcode }}" default>
                                                @endforeach
                                            @endif
                                        @endif
                                    <!-- <p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web -->
                                        <!-- browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5
                                            series</a></p> -->
                                </video>
                            </div>
                        <!-- @endif -->
                        <!-- <div class="logo_player"> </div> -->
                        <!-- Intro Skip and Recap Skip -->
                        <div class="col-sm-12 intro_skips">
                            <input type="button" class="skips" value="Skip Intro" id="intro_skip">
                            <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
                        </div>

                        <div class="col-sm-12 Recap_skip">
                            <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip" style="display:none;">
                        </div>
                        <!-- Intro Skip and Recap Skip -->
                    @else
                        <div id="subscribers_only" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('{{ url('/public/uploads/images/' . $episode->player_image) }}'); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">
                            <div class="container-fluid">
                                <p class="epi-name text-left m-0 mt-2">
                                    <?= __($episode->title) ?>
                                </p>

                                <p class="desc-name text-left m-0 mt-1">
                                    <?= __(html_entity_decode(strip_tags($episode->episode_description))) ?>
                                </p>
                                <h4>
                                    @if ($SeriesSeason->access == 'subscriber')
                                        {{ __('Subscribe to view more') }}
                                    @elseif($episode->access == 'registered')
                                        {{ __('Purchase to view Video') }}
                                    @endif
                                </h4>
                                <div class="clear"></div>
                            </div>
                            @if(!Auth::guest() && $SeriesSeason->access == 'ppv')
                                <div class="container-fluid mt-3">
                                    <div class="d-flex">

                                        @if(!Auth::guest() && Auth::user()->role != 'subscriber')
                                            <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
                                            </form>
                                        @endif
                                        <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                                            {{ __('PURCHASE NOW') }}
                                        </button>
                                        <!-- <button  data-toggle="modal" data-target="#exampleModalCenter"
                                            class="view-count rent-video btn btn-primary">
                                            <?php echo __('Purchase Now'); ?> </button>
                                        </div> -->
                                    </div>
                                </div>
                            @elseif(!Auth::guest() && $SeriesSeason->access == 'subscriber')
                                <div class="container-fluid mt-3">
                                    <form method="get" action="{{ url('/becomesubscriber') }}">
                                        <button class="btn btn-primary" id="button">{{ __('Subscribe to view more') }}</button>
                                    </form>
                                </div>
                            @else
                                <div class="container-fluid mt-3">
                                    <div class="d-flex series">

                                        @if(!Auth::guest() && Auth::user()->role != 'subscriber')
                                            <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
                                            </form>
                                        @endif
                                    <form method="get" action="{{ url('/play_series/'.@$series->slug) }}">
                                        <button data-toggle="modal" data-target="#exampleModalCenter1" class="view-count rent-video btn btn-primary">
                                            {{ __('PURCHASE NOW') }}
                                        </button>
                                    </form>

                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                <!-- @elseif(@$checkseasonppv_exits == 0 && $free_episode > 0) -->
                    <!-- {{--  -->
                    <!-- <div id="series_container">
                        <video id="videoPlayer" muted autoplay class="video-js vjs-default-skin" controls preload="auto"
                                poster="{{ url('/public/uploads/images/' . $episode->player_image) }}" data-setup="{}"
                                width="100%" style="width:100%;" data-authenticated="{{ !Auth::guest() }}">
                                <source src="{{ $season[0]->trailer }}" type='video/mp4' label='auto'>

                                @if(@$playerui_settings['subtitle'] == 1 && isset($episodesubtitles))
                                    @foreach($episodesubtitles as $episodesubtitles_file)
                                        <track kind="captions" src="{{ $episodesubtitles_file->url }}"
                                            srclang="{{ $episodesubtitles_file->sub_language }}"
                                            label="{{ $episodesubtitles_file->shortcode }}" default>
                                    @endforeach
                                @endif
                        </video>

                        <div style="background: url({{ url('/public/uploads/images/' . $episode->player_image) }}); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
                            <div id="ppv">
                                <h2>Purchase to Watch the Episodes
                                    @if($episode->access == 'subscriber')
                                        Subscribers
                                    @elseif($episode->access == 'registered')
                                        Registered Users
                                    @endif
                                </h2>
                                <div class="clear"></div>
                                @if(!Auth::guest())
                                    <form method="get" action="{{ url('/') }}/user/{{ Auth::user()->username }}/upgrade_subscription">
                                        <button id="button">Purchase to Watch {{ $currency->symbol . ' ' . $episode->ppv_price }}</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div> -->
                    <!-- --}} -->
                @else
                    <div id="subscribers_only" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('{{ url('/public/uploads/images/' . $episode->player_image) }}'); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">
                        <div class="container-fluid">
                            <div class="col-12 col-md-6 col-sm-6 p-0">
                                <h4>{{ $episode->title }}</h4>
                                <p class="text-white col-lg-8">{{ html_entity_decode(strip_tags($episode->episode_description)) }}</p>
                            </div>
                            <div class="col-6"></div>
                            <div class="clear"></div>
                        </div>
                        @if(!Auth::guest() && $SeriesSeason->access == 'ppv' && $series->access != 'subscriber')
                            <div class="container-fluid mt-3">
                                    <div class="d-flex">

                                    @if(!Auth::guest() && Auth::user()->role != 'subscriber')
                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                            <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
                                        </form>
                                    @endif
                                    <a onclick="pay({{ $SeriesSeason->access == 'ppv' && $SeriesSeason->ppv_price != null && $CurrencySetting == 1 ? PPV_CurrencyConvert($SeriesSeason->ppv_price) : ($SeriesSeason->access == 'ppv' && $SeriesSeason->ppv_price != null && $CurrencySetting == 0 ? __($SeriesSeason->ppv_price) : '') }})">
                                        <button type="button" class="btn2 btn-outline-primary">{{ __('PURCHASE NOW') }}</button>
                                    </a>
                                </div>
                            </div>
                        @elseif(!Auth::guest() && $SeriesSeason->access == 'subscriber')
                            <div class="container-fluid mt-3">
                                <form method="get" action="{{ url('/becomesubscriber') }}">
                                    <button class="btn btn-primary" id="button">{{ __('Subscribe to view more') }}</button>
                                </form>
                            </div>
                        @else
                            <div class="container-fluid mt-3">
                            <div class="d-flex series">

                                    @if(!Auth::guest() && Auth::user()->role != 'subscriber')
                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                            <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
                                        </form>
                                    @endif
                                    <form method="get" action="{{ url('/play_series/'.@$series->slug) }}">
                                    <button data-toggle="modal" data-target="#exampleModalCenter1" class="view-count rent-video btn btn-primary">
                                        {{ __('PURCHASE NOW') }}
                                    </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
            @endif
        </div>
    </div>


    <input type="hidden" class="seriescategoryid" data-seriescategoryid="{{ $episode->genre_id }}" value="{{ $episode->genre_id }}">
    <br>

    <div class="">
        <div class="container-fluid" id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb pl-3">
                    <li class="breadcrumb-item">
                        <a class="black-text" href="{{ route('series.tv-shows') }}">{{ ucwords(__('Series')) }}</a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    @foreach($category_name as $key => $series_category_name)
                        @php $category_name_length = count($category_name); @endphp
                        <li class="breadcrumb-item">
                            <a class="black-text" href="{{ route('SeriesCategory', [$series_category_name->categories_slug]) }}">
                                {{ ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') }}
                            </a>
                            <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                        </li>
                    @endforeach

                    <li class="breadcrumb-item">
                        <a class="black-text" href="{{ route('play_series', [$series->slug]) }}">
                            {{ strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title) }}
                        </a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <li class="breadcrumb-item">
                        <a class="black-text">
                            {{ strlen($episode->title) > 50 ? ucwords(substr($episode->title, 0, 120) . '...') : ucwords($episode->title) }}
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>


    <div class="container-fluid series-details">
        <div id="series_title">
            <div class="">
                                    <!-- @if ( ($free_episode > 0 && Auth::user()->role != 'admin') || (@$checkseasonppv_exits > 0 && Auth::user()->role != 'admin') || ($ppv_exits > 0 && Auth::user()->role != 'admin') || Auth::guest())

                        <div class="row align-items-center justify-content-between"
                            style="background: url({{ URL::to('public/uploads/images/' . $episode->player_image) }} ); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">

                            <div class="col-md-12 p-0">
                                <span class="text-white"
                                    style="font-size: 129%;font-weight: 700;">{{ __('Purchase to Watch the Series') }}
                                    :</span>
                                @if ($series->access == 'subscriber')
                                @elseif($series->access == 'registered')
                                @endif
                                </p>
                            </div>

                            @if (!empty($season))
                                <div class="col-md-6">
                                    <input type="hidden" id="season_id" name="season_id"
                                        value="{{ $season[0]->id }}">
                                    @if (@$Stripepayment->stripe_status == 1)
                                        <button class="btn btn-primary" onclick="pay({{ $season[0]->ppv_price }})">
                                            {{ __('Purchase For') }}
                                            {{ $currency->symbol . ' ' . $season[0]->ppv_price }}
                                        </button>
                                    @elseif(@$PayPalpayment->paypal_status == 1)

                                    @elseif(@$Razorpay_payment_settings->status == 1)

                                    @elseif(@$Paystack_payment_settings->status == 1)

                                    @elseif(@$CinetPay_payment_settings->status == 1)
                                        <input type="hidden" id="ppv_price" name="ppv_price"
                                            value="<?php echo $season[0]->ppv_price; ?>">

                                        <button onclick="cinetpay_checkout()" id=""
                                            class="btn2  btn-outline-primary">{{ __('Purchase For') }}
                                            {{ $currency->symbol . ' ' . $season[0]->ppv_price }} </button>
                                </div>
                            @else
                                <button class="btn btn-primary" id="enable_any_payment">
                                    {{ __('Purchase For') }}
                                    {{ $currency->symbol . ' ' . $season[0]->ppv_price }} </button>
                            @endif
                        </div>
                    @endif
                    @endif -->
            </div>

            <div class="">
                <div class="container-fluid" id="nav-tab" role="tablist">
                    <div class="bc-icons-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="black-text" href="{{ route('series.tv-shows') }}">{{ ucwords(__('Series')) }}</a>
                                <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>

                            @foreach($category_name as $key => $series_category_name)
                                @php $category_name_length = count($category_name); @endphp
                                <li class="breadcrumb-item">
                                    <a class="black-text" href="{{ route('SeriesCategory', [$series_category_name->categories_slug]) }}">
                                        {{ ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' ' : '') }}
                                    </a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>
                            @endforeach

                            <li class="breadcrumb-item">
                                <a class="black-text" href="{{ route('play_series', [$series->slug]) }}">
                                    {{ strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title) }}
                                </a>
                                <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>

                            <li class="breadcrumb-item">
                                <a class="black-text">
                                    {{ strlen($episode->title) > 50 ? ucwords(substr($episode->title, 0, 120) . '...') : ucwords($episode->title) }}
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="container-fluid description">
                <span class="text-white" style="font-size: 120%;font-weight: 700;">{{ __("You're watching") }}:</span>
                <p class="mb-0" style="font-size: 80%;color: white;">
                    @php
                        $seasons = App\SeriesSeason::where('series_id', '=', $SeriesSeason->series_id)->with('episodes')->get();
                        $Episode = App\Episode::where('season_id', '=', $SeriesSeason->id)->where('series_id', '=', $SeriesSeason->series_id)->get();
                    @endphp

                    @foreach($seasons as $key => $seasons_value)
                        @if(!empty($SeriesSeason) && $SeriesSeason->id == $seasons_value->id)
                            {{ 'Season ' . ($key+1) . ' ' }}
                        @endif
                    @endforeach

                    @foreach ($Episode as $key => $Episode_value)
                            @if (!empty($episode) && $episode->id == $Episode_value->id)
                                {{ 'Episode' . ' ' . $episode->episode_order . ' ' }}
                            @endif
                    @endforeach
                </p>

                <p class="" style="font-size: 100%;color: white;font-weight: 700;">{{ $episode->title }}</p>
                <p class="desc">{{ html_entity_decode(strip_tags($episode->episode_description)) }}</p>
            </div>

            <div class="container-fluid">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    <li>
                        @if(is_null($episode_watchlater))
                            <span id="episode_add_watchlist_{{ $episode->id }}" class="slider_add_watchlist" aria-hidden="true"
                                data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}"
                                onclick="episodewatchlater(this)"> <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </span>
                        @else
                            <span id="episode_add_watchlist_{{ $episode->id }}" class="slider_add_watchlist" aria-hidden="true"
                                data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}"
                                onclick="episodewatchlater(this)"> <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </li>

                    <li>
                        @if(is_null($episode_Wishlist))
                            <span id="episode_add_wishlist_{{ $episode->id }}" class="episode_add_wishlist_" aria-hidden="true"
                                data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}"
                                onclick="episodewishlist(this)"><i class="fa ri-heart-line" aria-hidden="true"></i>
                            </span>
                        @else
                            <span id="episode_add_wishlist_{{ $episode->id }}" class="episode_add_wishlist_" aria-hidden="true"
                                data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}"
                                onclick="episodewishlist(this)"> <i class="fa fa-heart" aria-hidden="true"></i>
                            </span>
                        @endif
                    </li>

                    
  <li>
    <span id="episode_like_{{ $episode->id }}" class="episode_like_" aria-hidden="true"
        data-list="{{ empty($like_dislike->liked) ? $episode->id : 'remove' }}" 
        data-video-id="{{ $episode->id }}" 
        onclick="episodelike(this)">
        <i class="{{ empty($like_dislike->liked) ? 'ri-thumb-up-line' : 'ri-thumb-up-fill' }}" aria-hidden="true"></i>
    </span>
</li>

<li>
    <span id="episode_dislike_{{ $episode->id }}" class="episode_dislike_" aria-hidden="true"
        data-list="{{ empty($like_dislike->disliked) ? $episode->id : 'remove' }}" 
        data-video-id="{{ $episode->id }}" 
        onclick="episodedislike(this)">
        <i class="{{ empty($like_dislike->disliked) ? 'ri-thumb-down-line' : 'ri-thumb-down-fill' }}" aria-hidden="true"></i>
    </span>
</li>
                    

                    <li class="share">
                        <span><i class="ri-share-fill"></i></span>
                        <div class="share-box">
                            <div class="d-flex align-items-center">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= URL::to('episode/') . '/' . $series->title . '/' . $episode->slug ?>"
                                    class="share-ico"><i class="ri-facebook-fill"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?= URL::to('episode/') . '/' . $series->title . '/' . $episode->slug ?>"
                                    class="share-ico"><i class="ri-twitter-fill"></i>
                                </a>
                                <a href="#" onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <a onclick="EmbedCopy();" class="share-ico"><span><i class="ri-links-fill mt-1"></i></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div></div>
    </div>

    <input type="hidden" class="seriescategoryid" data-seriescategoryid="{{ $episode->genre_id }}" value="{{ $episode->genre_id }}">
    <br>

    <div class="container-fluid series-details">
        <div id="series_title">
            <div class="">
                <div class="row align-items-center justify-content-between">
                    @if($free_episode > 0 || $ppv_exits > 0 || Auth::user()->role == 'admin' || Auth::guest())
                    @else
                        <div class="col-md-6 pl-4">
                            @if($series->access == 'subscriber')
                                {{ __('Subscribers') }}
                            @elseif($series->access == 'registered')
                                {{ __('Registered Users') }}
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if (!empty($season))
                                <input type="hidden" id="season_id" name="season_id" value="{{ $season[0]->id }}">
                                <!--
                                <button class="btn btn-primary" onclick="pay({{ $season[0]->ppv_price }})">
                                    {{ __('Purchase For') }} {{ $currency->symbol . ' ' . $season[0]->ppv_price }}
                                </button>
                                -->
                            @endif
                        </div>
                    @endif

                    <!--
                    <div class="col-md-2 text-center text-white">
                        <span class="view-count" style="float:right;">
                            <i class="fa fa-eye"></i>
                            @if(isset($view_increment) && $view_increment == true)
                                {{ $episode->views + 1 }}
                            @else
                                {{ $episode->views }}
                            @endif
                            Views
                        </span>
                    </div>
                    -->

                    <!--
                    <div>
                        @if ($episode->ppv_status != null && Auth::User() != "admin" || $episode->ppv_price != null && Auth::User()->role != "admin")
                            <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-episode">
                                {{ __('Purchase for').' '.$currency->symbol.' '.$episode->ppv_price }}
                            </button>
                        @endif
                    </div>
                    -->
                </div>

                <?php
                    $media_url = URL::to('episode/') . '/' . $series->title . '/' . $episode->slug;
                    $embed_media_url = URL::to('/episode/embed') . '/' . $series->title . '/' . $episode->slug;
                    $url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>';
                ?>

                @if(isset($episodenext))
                    <div class="next_episode" style="display: none;">{{ $episodenext->id }}</div>
                    <div class="next_url" style="display: none;">{{ $url }}</div>
                @elseif(isset($episodeprev))
                    <div class="prev_episode" style="display: none;">{{ $episodeprev->id }}</div>
                    <div class="next_url" style="display: none;">{{ $url }}</div>
                @endif

                <div class="col-sm-12 d-flex row">
                    @if($episode->search_tags != null)
                        <h4>Tags:</h4>
                        <span class="mb-0" style="font-size: 100%;color: white;">{{ $episode->search_tags }}</span>
                    @endif
                </div>

                <!-- Comment Section -->
                @if(App\CommentSection::first() != null && App\CommentSection::pluck('episode')->first() == 1)
                    <div class="row">
                        <div class="container-fluid pl-4 video-list you-may-like overflow-hidden">
                            <h4 class="" style="color:#ffffff;">{{ __('Comments') }}</h4>
                            <?php
                                include public_path('themes/default/views/comments/index.blade.php');
                            ?>
                        </div>
                    </div>
                @endif

                <!-- Remaining Episodes -->
                <!-- Recommend Series Based on Category -->
                @php
                    include public_path('themes/default/views/partials/Episode/Other_episodes_list.blade.php');
                    include public_path('themes/default/views/partials/Episode/Recommend_series_episode_page.blade.php');
                @endphp

            </div>
        </div>
    </div>


    <div class="clear">
        <h2 id="tags">
            @if(isset($episode->tags))
                @foreach($episode->tags as $key => $tag)
                    <span><a href="{{ url('/episode/tag/' . $tag->name) }}">{{ $tag->name }}</a></span>
                    @if($key + 1 != count($episode->tags))
                        ,
                    @endif
                @endforeach
            @endif
        </h2>
        <div class="clear"></div>
        <div id="social_share">
        <!--<p>Share This episode:</p>
        {{-- @include('partials.social-share') --}}-->
        </div>
    </div>

    <div class="clear"></div>
    <!-- Free content - Video Not display  -->
<?php
    $free_content_duration = $episode->free_content_duration;
    $user_access = $episode->access;
    $Auth = Auth::guest();
    $SeriesSeason = App\SeriesSeason::where('id', $episode->season_id)->first();
?>
    <!-- Modal
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLongTitle"
                        style="color:#000;font-weight: 700;">{{ __('Rent Now') }}</h4>
                    <img src="{{ url('/public/uploads/images/' . $episode->player_image) }}" alt="" width="50" height="60">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2" style="width:52%;">
                            <span id="paypal-button"></span>
                        </div>
                        @php
                            $payment_type = App\PaymentSetting::get();
                        @endphp
                        <div class="col-sm-4">
                            <span class="badge badge-secondary p-2">{{ __($episodes->title) }}</span>
                            <span class="badge badge-secondary p-2">{{ __($episodes->age_restrict) . ' ' . '+' }}</span>

                            <span class="trending-year">{{ $episode->year != 0 ? $episode->year : '' }}</span>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __($currency->symbol . ' ' . $episodes->ppv_price) }}</button>
                            <label for="method">
                                <h3>{{ __('Payment Method') }}</h3>
                            </label>
                            @foreach($payment_type as $payment)
                                @if($payment->live_mode == 1)
                                    <label class="radio-inline">
                                        <input type="radio" id="tres_important" checked name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        {{ !empty($payment->stripe_lable) ? $payment->stripe_lable : $payment->payment_type }}
                                    </label>
                                @elseif($payment->paypal_live_mode == 1)
                                    <label class="radio-inline">
                                        <input type="radio" id="important" name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        {{ !empty($payment->paypal_lable) ? $payment->paypal_lable : $payment->payment_type }}
                                    </label>
                                @elseif($payment->live_mode == 0)
                                    <label class="radio-inline">
                                        <input type="radio" id="tres_important" checked name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        {{ !empty($payment->stripe_lable) ? $payment->stripe_lable : $payment->payment_type }}
                                    </label><br>
                                @elseif($payment->paypal_live_mode == 0)
                                    <label class="radio-inline">
                                        <input type="radio" id="important" name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        {{ !empty($payment->paypal_lable) ? $payment->paypal_lable : $payment->payment_type }}
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a onclick="pay({{ $SeriesSeason->ppv_price }})">
                        <button type="button" class="btn btn-primary" id="submit-new-cat">{{ __('Continue') }}</button>
                    </a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div> -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

    <div class="modal-header">
        <h4 class="modal-title text-center" id="exampleModalLongTitle"
            style="">Rent Now</h4>

        <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

    <div class="modal-body">
        <div class="row justify-content-between">
            <div class="col-sm-4 p-0" style="">
                <img class="img__img w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $episode->image; ?>"
                    class="img-fluid" alt="">
            </div>

            <div class="col-sm-8">
                <h4 class=" text-black movie mb-3"><?php echo __($episode->title); ?> ,
                    <span
                        class="trending-year mt-2"><?php if ($episode->year == 0) {
                            echo '';
                        } else {
                            echo $episode->year;
                        } ?></span>
                </h4>
                <span
                    class="badge badge-secondary   mb-2"><?php echo __($episode->age_restrict) . ' ' . '+'; ?></span>
                <span
                    class="badge badge-secondary  mb-2"><?php echo __(isset($episode->categories->name)); ?></span>
                <span
                    class="badge badge-secondary  mb-2"><?php echo __(isset($episode->languages->name)); ?></span>
                <span
                    class="badge badge-secondary  mb-2 ml-1"><?php echo __($episode->duration); ?></span><br>

                <a type="button" class="mb-3 mt-3" data-dismiss="modal"
                    style="font-weight:400;">Amount: <span class="pl-2"
                        style="font-size:20px;font-weight:700;">
                        <?php if(@$SeriesSeason->access == 'ppv' && @$SeriesSeason->ppv_price != null && $CurrencySetting == 1){ echo __(Currency_Convert(@$SeriesSeason->ppv_price)); }else if(@$SeriesSeason->access == 'ppv' && @$SeriesSeason->ppv_price != null && $CurrencySetting == 0){ echo __(  currency_symbol() . @$SeriesSeason->ppv_price) ; } ?></span></a><br>
                <label class="mb-0 mt-3 p-0" for="method">
                    <h5 style="font-size:20px;line-height: 23px;"
                        class="font-weight-bold text-black mb-2">Payment Method
                        : </h5>
                </label>

                <?php $payment_type = App\PaymentSetting::get(); ?>

                <!-- RENT PAYMENT Stripe,Paypal,Paystack,Razorpay,CinetPay -->

                <?php  //foreach($payment_type as $payment){
                     $Stripepayment = App\PaymentSetting::where('payment_type', 'Stripe')->first();
                     $PayPalpayment = App\PaymentSetting::where('payment_type', 'PayPal')->first();
                     $Paydunyapayment =  App\PaymentSetting::where('payment_type','=','Paydunya')->where('paydunya_status',1)->first();
                     $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
                     $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
                     $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();



                          if( @$Razorpay_payment_settings->payment_type == "Razorpay"  || @$Stripepayment->payment_type == "Stripe" ||  @$PayPalpayment->payment_type == "PayPal"
                          || @$CinetPay_payment_settings->payment_type == "CinetPay" ||  @$Paystack_payment_settings->payment_type == "Paystack" ){

                              if( $Stripepayment != null && $Stripepayment->live_mode == 1 && $Stripepayment->stripe_status == 1){ ?>
                                                        <!-- Stripe -Live Mode -->

                                                        <label
                                                            class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                            <input type="radio" class="payment_btn"
                                                                id="tres_important" name="payment_method"
                                                                value=<?= $Stripepayment->payment_type ?>
                                                                data-value="stripe">
                                                            <?php if (!empty($Stripepayment->stripe_lable)) {
                                                                echo $Stripepayment->stripe_lable;
                                                            } else {
                                                                echo $Stripepayment->payment_type;
                                                            } ?>
                                                        </label> <?php }

                              elseif( $Stripepayment != null && $Stripepayment->live_mode == 0 && $Stripepayment->stripe_status == 1){ ?>
                                                        <!-- Stripe - Test Mode -->

                                                        <label
                                                            class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                            <input type="radio" class="payment_btn"
                                                                id="tres_important" name="payment_method"
                                                                value="<?= $Stripepayment->payment_type ?>"
                                                                data-value="stripe">
                                                            <!--<img class="" height="20" width="40" src="<?php echo URL::to('/assets/img/stripe.png'); ?>" style="margin-top:-5px" >-->
                                                            <?php if (!empty($Stripepayment->stripe_lable)) {
                                                                echo $Stripepayment->stripe_lable;
                                                            } else {
                                                                echo $Stripepayment->payment_type;
                                                            } ?>
                                                        </label> <?php }

                              if(  $PayPalpayment != null &&  $PayPalpayment->paypal_live_mode == 1 && $PayPalpayment->paypal_status == 1){ ?>
                                                        <!-- paypal - Live Mode -->

                                                        <label
                                                            class="radio-inline mb-0 mt-3 d-flex align-items-center">
                                                            <input type="radio" class="payment_btn" id="important"
                                                                name="payment_method"
                                                                value="<?= $PayPalpayment->payment_type ?>"
                                                                data-value="paypal">
                                                            <?php if (!empty($PayPalpayment->paypal_lable)) {
                                                                echo $PayPalpayment->paypal_lable;
                                                            } else {
                                                                echo $PayPalpayment->payment_type;
                                                            } ?>
                                                        </label> <?php }

                              elseif( $PayPalpayment != null &&  $PayPalpayment->paypal_live_mode == 0 && $PayPalpayment->paypal_status == 1){ ?>
                                                        <!-- paypal - Test Mode -->

                                    <label
                                        class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="important"
                                            name="payment_method"
                                            value="<?= $PayPalpayment->payment_type ?>"
                                            data-value="paypal">
                                        <?php if (!empty($PayPalpayment->paypal_lable)) {
                                            echo $PayPalpayment->paypal_lable;
                                        } else {
                                            echo $PayPalpayment->payment_type;
                                        } ?>
                            </label> <?php  } ?>

                                                        <!-- Razorpay -->
                                <?php if( $Razorpay_payment_settings != null && $Razorpay_payment_settings->payment_type == "Razorpay" && $Razorpay_payment_settings->status == 1){?>
                                    <label
                                        class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="important"
                                            name="payment_method"
                                            value="<?= $Razorpay_payment_settings->payment_type ?>"
                                            data-value="Razorpay">
                                        <?php echo $Razorpay_payment_settings->payment_type; ?>
                                    </label>
                                <?php }
                                                                              // <!-- Paystack -->
                              if ( $Paystack_payment_settings != null && $Paystack_payment_settings->payment_type == 'Paystack'  && $Paystack_payment_settings->status == 1 ){  ?>

                                    <label
                                        class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id=""
                                            name="payment_method"
                                            value="<?= $Paystack_payment_settings->payment_type ?>"
                                            data-value="Paystack">
                                        <?= $Paystack_payment_settings->payment_type ?>
                                    </label>
                                <?php }
                                                                        // <!-- CinetPay -->
                              if ( $CinetPay_payment_settings != null && $CinetPay_payment_settings->payment_type == 'CinetPay'  && $CinetPay_payment_settings->status == 1 ){  ?>

                                <label
                                    class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="" name="payment_method"
                                        value="<?= $CinetPay_payment_settings->payment_type ?>"
                                        data-value="CinetPay">
                                    <?= $CinetPay_payment_settings->payment_type ?>
                                </label>
                            <?php }

                                if ( $Paydunyapayment != null && $Paydunyapayment->payment_type == 'Paydunya'  && $Paydunyapayment->status == 1 ){  ?>

                                <label
                                    class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn"  name="payment_method"  value="<?= $Paydunyapayment->payment_type ?>" data-value="Paydunya">
                                    <?= $Paydunyapayment->payment_type ?>
                                </label>
                            <?php }


                              }
                          else{
                                echo "<small>Please Turn on Payment Mode to Purchase</small>";
                                // break;
                          // }
                      }?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <?php if( @$SeriesSeason->ppv_price !=null &&  @$SeriesSeason->ppv_price != " "  ){ ?>

                        <div class="Stripe_button">
                                <button class="btn2  btn-outline-primary " onclick="location.href ='<?= URL::to('Stripe_payment_series_season_PPV_Purchase/'.@$SeriesSeason->id.'/'.@$SeriesSeason->ppv_price) ?>' ;" > Continue </button>
                        </div>

                    <?php } ?>

                    <?php if( @$SeriesSeason->ppv_price !=null &&  @$SeriesSeason->ppv_price != " "  ){ ?>
                        <div class="Razorpay_button">
                            <!-- Razorpay Button -->
                            <button onclick="location.href ='<?= URL::to('RazorpayVideoRent/' . @$SeriesSeason->id . '/' . @$SeriesSeason->ppv_price) ?>' ;"
                                id="" class="btn2  btn-outline-primary"> Continue</button>
                        </div>
                    <?php }?>


                    <?php if( @$SeriesSeason->ppv_price !=null &&  @$SeriesSeason->ppv_price != " "  ){ ?>
                        <div class="paystack_button">
                            <!-- Paystack Button -->
                            <button
                                onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => @$SeriesSeason->id, 'amount' => @$SeriesSeason->ppv_price]) ?>' ;"
                                id="" class="btn2  btn-outline-primary"> Continue</button>
                        </div>
                    <?php }?>

                    <?php if( @$SeriesSeason->ppv_price !=null &&  @$SeriesSeason->ppv_price != " " || @$SeriesSeason->ppv_price !=null  || @$SeriesSeason->global_ppv == 1){ ?>
                        <div class="cinetpay_button">
                            <!-- CinetPay Button -->
                            <button onclick="cinetpay_checkout()" id="" class="btn2  btn-outline-primary">Continue</button>
                        </div>
                    <?php }?>

                    <?php if( @$SeriesSeason->ppv_price !=null &&  @$SeriesSeason->ppv_price != " "  ){ ?>
                        <div class="Paydunya_button">   <!-- Paydunya Button -->
                            <button class="btn2  btn-outline-primary " onclick="location.href ='<?= URL::to('Paydunya_SeriesSeason_checkout_Rent_payment/'.@$SeriesSeason->id.'/'.@$SeriesSeason->ppv_price) ?>' ;" > Continue </button>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>


    <div class="clear"></div>
    <input type="hidden" id="episode_id" value="<?php echo $episode->id; ?>">
    <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script>
                    window.onload = function() {
                        $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();
                    }

                    $(document).ready(function() {

                        $(".payment_btn").click(function() {

                            $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                            let payment_gateway = $('input[name="payment_method"]:checked').val();
                            // alert(payment_gateway);
                            if (payment_gateway == "Stripe") {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                                $('.Stripe_button').show();


                            } else if (payment_gateway == "Razorpay") {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                                $('.Razorpay_button').show();

                            } else if (payment_gateway == "Paystack") {

                                $('.Stripe_button,.Razorpay_button,.cinetpay_button').hide();
                                $('.paystack_button').show();
                            } else if (payment_gateway == "CinetPay") {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                                $('.cinetpay_button').show();

                            } else if (payment_gateway == "CinetPay") {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                                $('.cinetpay_button').show();

                            } else if (payment_gateway == "Paydunya") {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button').hide();

                                $('.Paydunya_button').show();

                            }
                        });
                    });
                </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $("#enable_any_payment").click(function() {
            alert('Please Enable Any Payment Mode');
        });

        function pay(amount) {
            var publishable_key = $('#publishable_key').val();

            var episode_id = $('#episode_id').val();
            var season_id = $('#season_id').val();

            var handler = StripeCheckout.configure({

                key: publishable_key,
                locale: 'auto',
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token);
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: '<?php echo URL::to('purchase-episode'); ?>',
                        method: 'post',
                        data: {
                            "_token": "<?= csrf_token() ?>",
                            tokenId: token.id,
                            amount: amount,
                            episode_id: episode_id,
                            season_id: season_id
                        },
                        success: (response) => {
                            alert("You have done  Payment !");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        },
                        error: (error) => {
                            swal('error');

                        }
                    })
                }
            });


            handler.open({
                name: '<?php $settings = App\Setting::first();
                echo $settings->website_name; ?>',
                description: 'Rent a Episode',
                amount: amount * 100
            });
        }

        $(".free_content").hide();
        var duration = <?php echo json_encode($free_content_duration); ?>;
        var access = <?php echo json_encode($user_access); ?>;
        var Auth = <?php echo json_encode($Auth); ?>;
        var pause = document.getElementById("episode-player");

        pause.addEventListener('timeupdate', function() {
            if (Auth != false) {
                if (access == 'guest' && duration !== null) {
                    if (pause.currentTime >= duration) {
                        pause.pause();
                        $("video#episode-player").hide();
                        $(".free_content").show();
                    }
                }
            }
        }, false);
    </script>

    <div class="clear"></div>
    <input type="hidden" id="episode_id" value="{{ $episode->id }}">
    <input type="hidden" id="publishable_key" name="publishable_key" value="{{ $publishable_key }}">

    <!-- <script src="https://checkout.stripe.com/checkout.js"></script>
    <script type="text/javascript">
        // videojs('videoPlayer').videoJsResolutionSwitcher();
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $("#enable_any_payment").click(function(){
            alert('Please Enable Any Payment Mode');
        });

        function pay(amount) {
            var publishable_key = $('#publishable_key').val();

            var episode_id = $('#episode_id').val();
            var season_id = $('#season_id').val();

            // alert(video_id);
            var handler = StripeCheckout.configure({

                key: publishable_key,
                locale: 'auto',
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token);
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: '<?php echo URL::to('purchase-episode'); ?>',
                        method: 'post',
                        data: {
                            "_token": "<?= csrf_token() ?>",
                            tokenId: token.id,
                            amount: amount,
                            episode_id: episode_id,
                            season_id: season_id
                        },
                        success: (response) => {
                            alert("You have done  Payment !");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        },
                        error: (error) => {
                            swal('error');
                            //swal("Oops! Something went wrong");
                            /* setTimeout(function() {
                            location.reload();
                            }, 2000);*/
                        }
                    })
                }
            });


            handler.open({
                name: '<?php $settings = App\Setting::first();
                echo $settings->website_name; ?>',
                description: 'Rent a Episode',
                amount: amount * 100
            });
        }
    </script> -->
    <script type="text/javascript">
        $(".free_content").hide();
        var duration = <?php echo json_encode($free_content_duration); ?>;
        var access = <?php echo json_encode($user_access); ?>;
        var Auth = <?php echo json_encode($Auth); ?>;
        var pause = document.getElementById("videoPlayer");

        pause.addEventListener('timeupdate', function() {
            if (Auth != false) {
                if (access == 'guest' && duration !== null) {
                    if (pause.currentTime >= duration) {
                        pause.pause();
                        $("video#videoPlayer").hide();
                        $(".free_content").show();
                    }
                }
            }
        }, false);
    </script>
    <style>
        p {
            color: #fff;
        }

        .free_content {
            margin: 100px;
            border: 1px solid red;
            padding: 5% !important;
            border-radius: 5px;
        }

        p.Subscribe {
            font-size: 48px !important;
            font-family: emoji;
            color: white;
            margin-top: 3%;
            text-align: center;
        }

        .play_icon {
            text-align: center;
            color: #c5bcbc;
            font-size: 51px !important;
        }

        .intro_skips,
        .Recap_skip {
            position: absolute;
            margin-top: -10%;
            margin-bottom: 0;
            /* z-index: -1; */
            margin-right: 0;
        }

        .plyr--video {
            height: calc(100vh - 80px - 75px);
            max-width: none;
            width: 100%;
        }

        #videoPlayer {}

        input.skips,
        input#Recaps_Skip {
            background-color: #21252952;
            color: white;
            padding: 15px 32px;
            text-align: center;
            margin: 4px 2px;
        }

        #intro_skip {
            display: none;
        }

        #Auto_skip {
            display: none;
        }
    </style>
    <!-- INTRO SKIP  -->
<?php
    $Auto_skip = App\HomeSetting::first();
    $Intro_skip = App\Episode::where('id', $episode->id)->first();
    $start_time = $Intro_skip->intro_start_time;
    $end_time = $Intro_skip->intro_end_time;
    $SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();

    $StartParse = date_parse($start_time);
    $startSec = $StartParse['hour'] * 60 * 60 + $StartParse['minute'] * 60 + $StartParse['second'];

    $EndParse = date_parse($end_time);
    $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];

    $SkipIntroParse = date_parse($Intro_skip['skip_intro']);
    $skipIntroTime = $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];

    // dd($SkipIntroPermission);

?>
    <script>
        var SkipIntroPermissions = <?php echo json_encode($SkipIntroPermission); ?>;
        var video = document.getElementById("videoPlayer");
        var button = document.getElementById("intro_skip");
        var Start = <?php echo json_encode($startSec); ?>;
        var End = <?php echo json_encode($EndSec); ?>;
        var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;
        var IntroskipEnd = <?php echo json_encode($skipIntroTime); ?>;
        //   alert(SkipIntroPermissions);

        if (SkipIntroPermissions == 0) {
            button.addEventListener("click", function(e) {
                video.currentTime = IntroskipEnd;
                $("#intro_skip").remove(); // Button Shows only one tym
                video.play();
            })
            if (AutoSkip != 1) {
                // alert(AutoSkip);

                this.video.addEventListener('timeupdate', (e) => {
                    document.getElementById("intro_skip").style.display = "none";
                    document.getElementById("Auto_skip").style.display = "none";
                    var RemoveSkipbutton = End + 1;

                    if (Start <= e.target.currentTime && e.target.currentTime < End) {
                        document.getElementById("intro_skip").style.display = "block"; // Manual skip
                    }
                    if (RemoveSkipbutton <= e.target.currentTime) {
                        $("#intro_skip").remove(); // Button Shows only one tym
                    }
                });
            } else {
                this.video.addEventListener('timeupdate', (e) => {
                    document.getElementById("Auto_skip").style.display = "none";
                    document.getElementById("intro_skip").style.display = "none";

                    var before_Start = Start - 5;
                    var trigger = Start - 1;

                    if (before_Start <= e.target.currentTime && e.target.currentTime < Start) {
                        document.getElementById("Auto_skip").style.display = "block";
                        if (trigger <= e.target.currentTime) {
                            document.getElementById("intro_skip").click(); // Auto skip
                        }
                    }
                });
            }
        }
    </script>
    <!-- Recap video skip -->
<?php
    $Recap_skip = App\Episode::where('id', $episode->id)->first();

    $RecapStart_time = $Recap_skip->recap_start_time;
    $RecapEnd_time = $Recap_skip->recap_end_time;

    $SkipRecapParse = date_parse($Recap_skip['skip_recap']);
    $skipRecapTime = $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];

    $RecapStartParse = date_parse($RecapStart_time);
    $RecapstartSec = $RecapStartParse['hour'] * 60 * 60 + $RecapStartParse['minute'] * 60 + $RecapStartParse['second'];

    $RecapEndParse = date_parse($RecapEnd_time);
    $RecapEndSec = $RecapEndParse['hour'] * 60 * 60 + $RecapEndParse['minute'] * 60 + $RecapEndParse['second'];
?>
    <script>
        var videoId = document.getElementById("videoPlayer");
        var button = document.getElementById("Recaps_Skip");
        var RecapStart = <?php echo json_encode($RecapstartSec); ?>;
        var RecapEnd = <?php echo json_encode($RecapEndSec); ?>;
        var RecapskipEnd = <?php echo json_encode($skipRecapTime); ?>;
        var RecapValue = $("#Recaps_Skip").val();

        button.addEventListener("click", function(e) {
            videoId.currentTime = RecapskipEnd;
            $("#Recaps_Skip").remove(); // Button Shows only one tym
            videoId.play();
        })
        this.videoId.addEventListener('timeupdate', (e) => {
            document.getElementById("Recaps_Skip").style.display = "none";

            var RemoveRecapsbutton = RecapEnd + 1;
            if (RecapStart <= e.target.currentTime && e.target.currentTime < RecapEnd) {
                document.getElementById("Recaps_Skip").style.display = "block";
            }

            if (RemoveRecapsbutton <= e.target.currentTime) {
                $("#Recaps_Skip").remove(); // Button Shows only one tym
            }
        });
    </script>
    <!-- Watchlater & wishlist -->
    <script>
        function episodewatchlater(ele) {
            var episode_id = $(ele).attr('data-video-id');
            var key_value = $(ele).attr('data-list');
            var id = '#episode_add_watchlist_' + key_value;
            var my_value = $(id).data('myval');

            if (my_value != "remove") {
                var url = '<?= URL::to('/episode_watchlist') ?>';
            } else if (my_value == "remove") {
                var url = '<?= URL::to('/episode_watchlist_remove') ?>';
            }

            $.ajax({
                url: url,
                type: 'get',
                data: {
                    episode_id: episode_id,
                },
                success: function(data) {

                    if (data.message == "Remove the Watch list") {

                        $(id).data('myval');
                        $(id).data('myval', 'remove');
                        $(id).find($(".fa")).toggleClass('fa fa-plus-circle').toggleClass('fa fa-minus-circle');

                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to watchlater</div>'
                            );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                    } else if (data.message == "Add the Watch list") {
                        $(id).data('myval');
                        $(id).data('myval', 'add');
                        $(id).find($(".fa")).toggleClass('fa fa-minus-circle').toggleClass('fa fa-plus-circle');

                        $("body").append(
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from watchlater</div>'
                            );
                        setTimeout(function() {
                            $('.remove_watch').slideUp('fast');
                        }, 3000);
                    } else if (data.message == "guest") {
                        window.location.replace('<?php echo URL::to('/login'); ?>');
                    }
                }
            })
        }


        function episodewishlist(ele) {
            var episode_id = $(ele).attr('data-video-id');
            var key_value = $(ele).attr('data-list');
            var id = '#episode_add_wishlist_' + key_value;
            var my_value = $(id).data('myval');

            if (my_value != "remove") {
                var url = '<?= URL::to('/episode_wishlist') ?>';
            } else if (my_value == "remove") {
                var url = '<?= URL::to('/episode_wishlist_remove') ?>';
            }

            $.ajax({
                url: url,
                type: 'get',
                data: {
                    episode_id: episode_id,
                },
                success: function(data) {

                    if (data.message == "Remove the Watch list") {

                        $(id).data('myval');
                        $(id).data('myval', 'remove');
                        $(id).find($(".fa")).toggleClass('fa ri-heart-line').toggleClass('fa fa-heart');

                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to wishlist</div>'
                            );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                    } else if (data.message == "Add the Watch list") {
                        $(id).data('myval');
                        $(id).data('myval', 'add');
                        $(id).find($(".fa")).toggleClass('fa fa-heart').toggleClass('fa ri-heart-line');

                        $("body").append(
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from wishlist</div>'
                            );
                        setTimeout(function() {
                            $('.remove_watch').slideUp('fast');
                        }, 3000);
                    } else if (data.message == "guest") {
                        window.location.replace('<?php echo URL::to('/login'); ?>');
                    }
                }
            })
        }

        
        function episodelike(ele) {
    var episode_id = $(ele).attr('data-video-id');
    var key_value = $(ele).attr('data-list');
    var url = key_value !== "remove" ? '<?= URL::to('/like-episode') ?>' : '<?= URL::to('/remove_like-episode') ?>';

    $.ajax({
        url: url,
        type: 'post',
        data: {
            episode_id: episode_id,
            _token: '<?= csrf_token() ?>'
        },
        success: function(data) {
            if (data.message === "Added to Like Episode" || data.message === "Added to Like Episode, Dislike Removed if existed") {
                // Toggle Like button to filled
                $(ele).find('i').removeClass('ri-thumb-up-line').addClass('ri-thumb-up-fill');
                $(ele).attr('data-list', 'remove');

                // Reset Dislike button to outlined if it was filled
                var dislikeButton = $('#episode_dislike_' + episode_id);
                if (dislikeButton.length) {
                    dislikeButton.find('i').removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                    dislikeButton.attr('data-list', episode_id);
                }
            } else if (data.message === "Removed from Like Episode") {
                // Toggle Like button back to outlined
                $(ele).find('i').removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');
                $(ele).attr('data-list', episode_id);
            }
        }
    });
}

function episodedislike(ele) {
    var episode_id = $(ele).attr('data-video-id');
    var key_value = $(ele).attr('data-list');
    var url = key_value !== "remove" ? '<?= URL::to('/dislike-episode') ?>' : '<?= URL::to('/remove_dislike-episode') ?>';

    $.ajax({
        url: url,
        type: 'post',
        data: {
            episode_id: episode_id,
            _token: '<?= csrf_token() ?>'
        },
        success: function(data) {
            if (data.message === "Added to Dislike Episode" || data.message === "Added to Dislike Episode, Like Removed if existed") {
                // Toggle Dislike button to filled
                $(ele).find('i').removeClass('ri-thumb-down-line').addClass('ri-thumb-down-fill');
                $(ele).attr('data-list', 'remove');

                // Reset Like button to outlined if it was filled
                var likeButton = $('#episode_like_' + episode_id);
                if (likeButton.length) {
                    likeButton.find('i').removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');
                    likeButton.attr('data-list', episode_id);
                }
            } else if (data.message === "Removed from Dislike Episode") {
                // Toggle Dislike button back to outlined
                $(ele).find('i').removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                $(ele).attr('data-list', episode_id);
            }
        }
    });
}

        function Copy() {
            var media_path = '<?= URL::to('episode/') . '/' . $series->title . '/' . $episode->slug ?>';
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
                );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }

        function EmbedCopy() {
            var media_path = '<?= '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>' ?>';
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 14%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;z-index:99;">Copied Embed URL</div>'
                );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }
    </script>


    <!-- Cinet Pay CheckOut -->

    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>

    <script>
                    var user_name = '<?php if (!Auth::guest()) {
                        Auth::User()->username;
                    } else {
                    } ?>';
                    var email = '<?php if (!Auth::guest()) {
                        Auth::User()->email;
                    } else {
                    } ?>';
                    var mobile = '<?php if (!Auth::guest()) {
                        Auth::User()->mobile;
                    } else {
                    } ?>';
                    var CinetPay_APIKEY = '<?= @$CinetPay_payment_settings->CinetPay_APIKEY ?>';
                    var CinetPay_SecretKey = '<?= @$CinetPay_payment_settings->CinetPay_SecretKey ?>';
                    var CinetPay_SITE_ID = '<?= @$CinetPay_payment_settings->CinetPay_SITE_ID ?>';
                    var season_id = $('#season_id').val();
                    var ppv_price = $('#ppv_price').val();


                    // var url       = window.location.href;
                    // alert(window.location.href);

                    function cinetpay_checkout() {
                        CinetPay.setConfig({
                            apikey: CinetPay_APIKEY, //   YOUR APIKEY
                            site_id: CinetPay_SITE_ID, //YOUR_SITE_ID
                            notify_url: window.location.href,
                            return_url: window.location.href,
                            // mode: 'PRODUCTION'

                        });



                        CinetPay.getCheckout({
                            transaction_id: Math.floor(Math.random() * 100000000).toString(), // YOUR TRANSACTION ID
                            amount: ppv_price,
                            currency: 'XOF',
                            channels: 'ALL',
                            description: 'Test paiement',
                            //Provide these variables for credit card payments
                            customer_name: user_name, //Customer name
                            customer_surname: user_name, //The customer's first name
                            customer_email: email, //the customer's email
                            customer_phone_number: "088767611", //the customer's email
                            customer_address: "BP 0024", //customer address
                            customer_city: "Antananarivo", // The customer's city
                            customer_country: "CM", // the ISO code of the country
                            customer_state: "CM", // the ISO state code
                            customer_zip_code: "06510", // postcode

                        });
                        CinetPay.waitResponse(function(data) {
                            if (data.status == "REFUSED") {

                                if (alert("Your payment failed")) {
                                    window.location.reload();
                                }
                            } else if (data.status == "ACCEPTED") {
                                $.ajax({
                                    url: '<?php echo URL::to('CinetPay-series_season-rent'); ?>',
                                    type: "post",
                                    data: {
                                        _token: '<?php echo csrf_token(); ?>',
                                        amount: ppv_price,
                                        season_id: season_id,

                                    },
                                    success: function(value) {
                                        alert("You have done  Payment !");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);

                                    },
                                    error: (error) => {
                                        swal('error');
                                    }
                                });
                                // if (alert("Your payment has been made successfully")) {
                                //     window.location.reload();
                                // }
                            }
                        });
                        CinetPay.onError(function(data) {
                            console.log(data);
                        });
                    }
    </script>

<?php
    include public_path('themes/default/views/footer.blade.php');
    include public_path('themes/default/views/episode_player_script.blade.php');
?>
