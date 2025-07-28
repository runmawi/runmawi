<?php

include public_path('themes/theme4/views/header.php');
include public_path('themes/theme4/views/episode_ads.blade.php');

$series = App\series::first();
$series = App\series::where('id', $episode->series_id)->first();
$SeriesSeason = App\SeriesSeason::where('id', $episode->season_id)->first();
$CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first() ;
$Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();
$Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
$CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
?>

<?php if(Auth::check() && !Auth::guest()): ?>
   <?php
        $user_name = Auth::user()->username;
        $user_img = Auth::user()->avatar;
        $user_avatar = $user_img !== 'default.png' ? URL::to('public/uploads/avatars/') . '/' . $user_img : URL::to('/assets/img/placeholder.webp');
    ?>
<?php endif; ?>

<!-- video-js Style  -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet">
<!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css"
    rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/videos-player.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet">
<link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

<!-- video-js Script  -->

<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<!-- Video.js IMA plugin newly added-->
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@6.6.4/dist/videojs.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@1.8.0/dist/videojs.ima.min.js"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ads.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ima.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/end-card.js') ?>"></script>
<script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>


<style>
    /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }
    .vjs-icon-hd:before{
        display:none;
    }
    #episode-player_ima-ad-container div{ overflow:hidden;}
    #episode-player { position: relative; }
    #series_container .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1; left:1%; color: white; border: none; cursor: pointer;  font-size:25px; }
    #series_container { position: relative;}
    .vjs-title-bar { top: 1% !important; }
    .slick-arrow{z-index: 99;}
    .slick-next{right:0;}
    .slick-prev{left:10px;}
    body.light-theme span { color: white !important;}
    .my-video.video-js .vjs-big-play-button span{ color: black !important;}
    .my-video.vjs-fluid{height: calc(100vh - 70px)!important;}
    .vjs-loading-spinner {top: 52%;left: 49.85%;}
    @media only screen and (max-width: 600px) {
        .custom-skip-forward-button, .custom-skip-backward-button {
            top: 46% !important;
        }
    }

    
  /* payment modal */
  #purchase-modal-dialog{max-width: 100% !important;margin: 0;}
  #purchase-modal-dialog .modal-content{height: 100vh;}
  #purchase-modal-dialog .modal-header.align-items-center{height: 70px;border: none;}
  #purchase-modal-dialog .modal-header.align-items-center .col-12{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center .d-flex.align-items-center.justify-content-end{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center img{height: 100%;width: 100%;}
  .col-sm-7.col-12.details{border-radius: 10px;padding: 0 1.5rem;}
  .modal-open .modal{overflow-y: hidden;}
  div#video-purchase-now-modal{padding-right: 0 !important;}
  .movie-rent.btn{width: 100%;padding: 10px 15px;background-color: #000 !important;}
  .col-md-12.btn {margin-top: 2rem;}
  .d-flex.justify-content-between.title{border-bottom: 1px solid rgba(255, 255, 255, .5);padding: 10px 0;}
  .btn-primary-dark {
      background-color: rgba(var(--btn-primary-rgb), 0.8); /* Darker version */
  }

  .btn-primary-light {
      background-color: rgba(var(--btn-primary-rgb), 0.3); /* Lighter version */
  }
  .close-btn {color: #fff;background: #000;padding: 0;border: 2px solid #fff;border-radius: 50%;line-height: 1;width: 30px;height: 30px;cursor: pointer;outline: none;}
  .payment_btn {width: 20px;height: 20px;margin-right: 10px;}
  .quality_option {width: 15px;height: 15px;margin-right: 10px;}
  span.descript::before {content: '•';margin-right: 5px;color: white;font-size: 16px;}
  input[type="radio"].payment_btn,input[type="radio"].quality_option {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid white;
      border-radius: 50%;
      background-color: transparent;
      cursor: pointer;
      position: relative;
  }

  input[type="radio"].payment_btn:checked,input[type="radio"].quality_option:checked {
      background-color: black;
      border-color: white;
  }

  input[type="radio"].payment_btn:checked::before, input[type="radio"].quality_option:checked::before {
      content: '';
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: white;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
  }
  .skips{display: none;}

  @media only screen and (max-width: 600px) {
    .my-video.vjs-fluid {
      padding-top: 0 !important;
      height: 45vh !important;
  }
}
@media (max-width: 767px) {
    .my-video.vjs-fluid {
      padding-top: 0 !important;
      height: 45vh !important;
  }
}

</style>

@if (Session::has('message'))
    <div id="successMessage" class="alert alert-info col-md-4"
        style="z-index: 999; position: fixed !important; right: 0;">
        {{ Session::get('message') }}
    </div>
@endif


<input type="hidden" value="<?php echo URL::to('/'); ?>" id="base_url">

<input type="hidden" id="videoslug" value={{ isset($episode->path) ? $episode->path : '0' }}>

<input type="hidden" value="{{ $episode->type }}" id='episode_type'>

<div id="series_bg">
    <div class="">
        @if (!Auth::guest())
            @if($episode_play_access > 0)
                <div id="series_container">
                    <button class="staticback-btn" onclick="history.back()" title="Back Button">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </button>

                    <div class="vjs-title-bar">{{$episode_details->title}}</div>

                    <button class="custom-skip-forward-button">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                    </button>

                    <button class="custom-skip-backward-button">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                    </button>

                    @if(!empty($next_episode))
                        <div class="next-episode" onclick="window.location.href = '{{ $next_episode_slug }}'">
                            <span class="play-icon">▶</span> Next Episode
                        </div>

                        <div class="card cancel_card container-fluid" style="display: none;">
                            <div class="d-flex align-items-center justify-content-center">
                                <h5 style="color: red !important;">{{ "Next Episode" }}</h5>
                                <h2 class="text-white" style="color: #fff !important;">{{ $next_episode->title }}</h2>
                                {{-- <button class="next-epi-cancel">Cancel</button> --}}
                            </div>
                            
                        </div>
                    @endif

                    @if($episode_details->type == 'embed_video_url')

                        <iframe class="" src="<?= $episode_details->Episode_url ?>" poster="<?= $episode_details->Player_thumbnail ?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen style="width: 100%; height: 100vh;">
                        </iframe>
                    @else

                    <video id="episode-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                    width="auto" height="auto" poster="<?= $episode_details->Player_thumbnail ?>" playsinline="playsinline"
                    >
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
                    </video>
                    @endif
                </div>
                <!-- Intro Skip and Recap Skip -->
                <div class="col-sm-12 intro_skips">
                    <input type="button" class="skips" value="Skip Intro" id="intro_skip">
                    <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
                </div>

                <div class="col-sm-12 Recap_skip">
                    <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip" style="display:none;">
                </div>
            @else
                <div id="subscribers_only" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('{{ url('/public/uploads/images/' . $episode->player_image) }}'); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">
                    <div class="container-fluid">
                        <p class="epi-name text-left m-0 mt-2">
                            <?= __($episode->title) ?>
                        </p>

                        @if(!empty($episode->episode_description))
                            @php
                                $description = preg_replace('/#(\w+)/', '<span class="d-flex">#$1</span>', $episode->episode_description);
                            @endphp
                            <p class="desc-name text-left m-0 mt-1"> <p>{!! nl2br($description) !!}</p></p>
                        @endif

                        @if (Auth::check() && Auth::user()->role == 'subscriber')
                            <a class="btn mt-3" data-toggle="modal" data-target="#season-purchase-now-modal">
                                <div class="playbtn text-white" style="gap:5px">
                                    <span class="text pr-2"> <?=  __('Purchase Now') ?> </span>
                                </div>
                            </a>
                        @elseif(Auth::check() && Auth::user()->role == 'registered')
                            <div class="d-flex mt-3">
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
                                </form>
                                <a class="btn mr-3" data-toggle="modal" data-target="#season-purchase-now-modal">
                                    <div class="playbtn text-white" style="gap:5px">
                                        <span class="text pr-2"> <?=  __('Purchase Now') ?> </span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            
        @endif
    </div>
</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="{{ $episode->genre_id }}" value="{{ $episode->genre_id }}">
<br>

<div class="">
    <div class="nav-fill mar-left " id="nav-tab" role="tablist">
        <div class="bc-icons-2">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a class="black-text"
                        href="{{ route('series.tv-shows') }} ">{{ ucwords(__('Series')) }}</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                </li>

                @foreach ($category_name as $key => $series_category_name)
                    <?php $category_name_length = count($category_name); ?>
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="{{ route('SeriesCategory', [$series_category_name->categories_slug]) }}">
                            {{ ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') }}
                        </a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>
                @endforeach

                <li class="breadcrumb-item">
                    <a class="black-text"
                        href="{{ URL::to('/play_series/'.$series->slug) }}">{{ strlen(@$series->title) > 50 ? ucwords(substr(@$series->title, 0, 120) . '...') : ucwords(@$series->title) }}
                    </a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                </li>

                <li class="breadcrumb-item">
                    <a class="black-text">{{ strlen(@$episode->title) > 50 ? ucwords(substr(@$episode->title, 0, 120) . '...') : ucwords($episode->title) }}
                    </a>
                </li>
            </ol>
        </div>
    </div>
    <div>
        <div class="mar-left series-details">
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
                <div class="col-md-12 pl-0">
                    <span class="text-white" style="font-size: 120%;font-weight: 700;">{{ __("You're watching") }}:</span>
                    <p class="mb-0" style=";font-size: 80%;color: white;">

                        <?php
                        $seasons = App\SeriesSeason::where('series_id', '=', $SeriesSeason->series_id)
                            ->with('episodes')
                            ->get();
                        
                        $Episode = App\Episode::where('season_id', '=', $SeriesSeason->id)
                            ->where('series_id', '=', $SeriesSeason->series_id)
                            ->get();
                        
                        ?>

                        

                    <p class="" style=";font-size: 100%;color: white;font-weight: 700;">{{ $episode->title }}</p>
                    @if(!empty($episode->episode_description))
                        @php
                            $description = preg_replace('/#(\w+)/', '<span class="d-flex">#$1</span>', $episode->episode_description);
                        @endphp
                        <p class=""> <p>{!! nl2br($description) !!}</p></p>
                    @endif

                    <?php
                    $media_url = URL::to('episode') . '/' . $series->slug . '/' . $episode->slug;
                    $embed_media_url = URL::to('/episode/embed') . '/' . $series->slug . '/' . $episode->slug;
                    $url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>';
                    ?>

                    <div class="col-md-12 pl-0">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                            <li>
                                @if ($episode_watchlater == null)
                                    <span id="{{ 'episode_add_watchlist_' . $episode->id }}"
                                        class="slider_add_watchlist" aria-hidden="true"
                                        data-list="{{ $episode->id }}" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodewatchlater(this)">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <span id="{{ 'episode_add_watchlist_' . $episode->id }}"
                                        class="slider_add_watchlist" aria-hidden="true"
                                        data-list="{{ $episode->id }}" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodewatchlater(this)">
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </li>
                            <li>
                                @if ($episode_Wishlist == null)
                                    <span id="{{ 'episode_add_wishlist_' . $episode->id }}"
                                        class="episode_add_wishlist_" aria-hidden="true"
                                        data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}" onclick="episodewishlist(this)">
                                        <i class="ri-heart-line" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <span id="{{ 'episode_add_wishlist_' . $episode->id }}"
                                        class="episode_add_wishlist_" aria-hidden="true"
                                        data-list="{{ $episode->id }}" data-myval="10" data-video-id="{{ $episode->id }}" onclick="episodewishlist(this)">
                                        <i class="ri-heart-fill" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </li>

                            <li>
                                @if (empty($like_dislike->liked) || (!empty($like_dislike->liked) && $like_dislike->liked == 0))
                                    <span id="{{ 'episode_like_' . $episode->id }}" class="episode_like_"
                                        aria-hidden="true" data-list="{{ $episode->id }}" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodelike(this)">
                                        <i class="ri-thumb-up-line" aria-hidden="true">
                                        </i>
                                    </span>
                                @else
                                    <span id="{{ 'episode_like_' . $episode->id }}" class="episode_like_"
                                        aria-hidden="true" data-list="remove" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodelike(this)">
                                        <i class="ri-thumb-up-fill" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </li>

                            <li>
                                @if (empty($like_dislike->disliked) || (!empty($like_dislike->disliked) && $like_dislike->disliked == 0))
                                    <span id="{{ 'episode_dislike_' . $episode->id }}" class="episode_dislike_"
                                        aria-hidden="true" data-list="{{ $episode->id }}" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodedislike(this)">
                                        <i class="ri-thumb-down-line" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <span id="{{ 'episode_dislike_' . $episode->id }}" class="episode_dislike_"
                                        aria-hidden="true" data-list="remove" data-myval="10"
                                        data-video-id="{{ $episode->id }}" onclick="episodedislike(this)">
                                        <i class="ri-thumb-down-fill" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </li>

                            <li class="share">
                                <span><i class="ri-share-fill"></i></span>
                                <div class="share-box">
                                    <div class="d-flex align-items-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-facebook-fill"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-twitter-fill"></i>
                                        </a>
                                        <a href="#" onclick="Copy();" class="share-ico">
                                            <i class="ri-links-fill"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @if($Series_access == "guest" && $Season_access == "free")
                                <li>
                                    <a href="#" onclick="EmbedCopy();" class="share-ico"><span><i
                                                class="ri-links-fill mt-1"></i></span></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    {{-- <div class="description">
                        {!! strlen($series->description) > 400 ?  html_entity_decode(substr($series->description, 0, 400 )) . "..." . " <span class='text-primary' data-bs-toggle='modal' data-bs-target='#video-details-description'>See More</span>" :  html_entity_decode($series->description)  !!}
                    </div> --}}

                    <!-- <div class="desc">
                        @if (strlen($series->description) > 500)
                            @php
                                $shortDescription = html_entity_decode(substr($series->description, 0, 500)) . '...';
                                $fullDescription = html_entity_decode($series->description);
                            @endphp

                            {{ $shortDescription . " <span class='text-primary' data-bs-toggle='modal' data-bs-target='#video-details-description'>See More</span>" }}
                        @else
                            {{ html_entity_decode($series->description) }}
                        @endif
                    </div> -->

                    <!-- Model for banner description -->

                    <div class="modal fade info_model" id='video-details-description' tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                            <div class="container">
                                <div class="modal-content" style="border:none;background:#0f3b5d;">
                                    <div class="modal-body">
                                        <div class="col-lg-12">
                                            <div class="row justify-content-end">
                                                <button type="button" class="btn-close-white" aria-label="Close"
                                                    data-bs-dismiss="modal">
                                                    <span aria-hidden="true"><i class="fas fa-times"
                                                            aria-hidden="true"></i></span>
                                                </button>
                                                <div class="trending-dec mt-4"> {{ $series->description }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Watchlater & Wishlist -->

            </div>
            <div></div>
        </div>
    </div>

    <input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>"
        value="<?= $episode->genre_id ?>">
    <br>
    <div class="mar-left series-details">
        <div id="series_title">
            <div class="">
                <div class="row align-items-center justify-content-between">
                    @if ($free_episode > 0 || $ppv_exits > 0 || Auth::user()->role == 'admin' || Auth::guest())
                    @else
                        <!-- <div class="col-md-6 p-0">
                            <span class="text-white"
                                style="font-size: 129%;font-weight: 700;">{{ __('Purchase to Watch the Series') }}
                            </span>
                            @if ($series->access == 'subscriber')
                                {{ __('Subscribers') }}
                            @elseif($series->access == 'registered')
                                {{ __('Registered Users') }}
                            @endif
                            </p>
                        </div> -->
                        <!-- <div class="col-md-6">
                            @if (!empty($season))
                                <input type="hidden" id="season_id" name="season_id" value="{{ $season[0]->id }}">
                                <button class="btn btn-primary" onclick="pay({{ $season[0]->ppv_price }})">
                                    {{ __('Purchase For') }}
                                    {{ $currency->symbol . ' ' . $season[0]->ppv_price }} </button>
                        </div>
                    @endif -->
                    @endif

                </div>

                <?php
                $media_url = URL::to('episode/') . '/' . $series->title . '/' . $episode->slug;
                $embed_media_url = URL::to('/episode/embed') . '/' . $series->title . '/' . $episode->slug;
                $url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>';
                ?>
            </div>

            <div class="series-details-container"><?= $episode->details ?></div>

            @if (isset($episodenext))
                <div class="next_episode" style="display: none;"> {{ $episodenext->id }}</div>
                <div class="next_url" style="display: none;"> {{ $url }}</div>
            @elseif(isset($episodeprev))
                <div class="prev_episode" style="display: none;">{{ $episodeprev->id }}</div>
                <div class="next_url" style="display: none;">{{ $url }}</div>
            @endif

            <div class="col-sm-12 d-flex row">
                @if ($episode->search_tags != null)
                    <h4>Tags : </h4>
                    <span class="mb-0" style=";font-size: 100%;color: white;"> <?= $episode->search_tags ?> </span>
                @endif
            </div>

            <!-- Comment Section -->

            @if (App\CommentSection::first() != null && App\CommentSection::pluck('episode')->first() == 1)
                <div class="">
                    <div class="  video-list you-may-like overflow-hidden">
                        <h4 class="" style="color:#fffff;">{{ __('Comments') }} </h4>
                        <?php
                        include public_path('themes/theme4/views/comments/index.blade.php');
                        ?>
                    </div>
                </div>
            @endif

            <!-- Remaing Episodes -->
            <!-- Recommend Series Based on Category -->
            

            <?php
                include public_path('themes/theme4/views/partials/Episode/Other_episodes_list.blade.php');
            ?>
            
                @if(count($series_lists) > 0)
                    @php
                        include public_path('themes/theme4/views/partials/Episode/Recommend_series_episode_page.blade.php');
                    @endphp
                @endif
        </div>
    </div>
    <div class="clear">
        <h2 id="tags">
            @if (isset($episode->tags))
                @foreach ($episode->tags as $key => $tag)
                    <span><a href="/episode/tag/<?= $tag->name ?>"> {{ $tag->name }}
                        </a>
                    </span>
                    @if ($key + 1 != count($episode->tags))
                    @endif
                @endforeach;
            @endif
        </h2>

        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="modal fade" 
            id="season-purchase-now-modal" tabindex="-1" 
            role="dialog" aria-labelledby="season-purchase-now-modal-Title" 
            aria-hidden="true">
            <div id="purchase-modal-dialog" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content container-fluid bg-dark">

                      <div class="modal-header align-items-center">
                          <div class="row">
                              <div class="col-12">
                                  <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">
                              </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-end">
                              <?php if (Auth::check() && (Auth::user()->role == 'registered' || Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin')): ?>
                                  <img src="<?php echo $user_avatar; ?>" alt="<?php echo $user_name; ?>">
                                  <h5 class="pl-4"><?php echo $user_name; ?></h5>
                              <?php endif; ?>
                          </div>
                      </div>

                      <div class="modal-body">
                          <div class="row justify-content-between m-0">
                              <h3 class="font-weight-bold"><?php echo $SeriesSeason->series_seasons_name; ?></h3>
                              <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                              </button>
                          </div>
                          <p class="text-white">You are currently on plan.</p>
                          <div class="row justify-content-between m-0" style="gap: 4rem;">
                              <div class="col-sm-4 col-12 p-0">
                                  <img class="img__img w-100" src="<?php echo $SeriesSeason->image; ?>" class="img-fluid" alt="<?php echo $SeriesSeason->series_seasons_name; ?>" style="border-radius: 10px;">
                              </div>

                              <div class="col-sm-7 col-12 details">
                                  <div class="movie-rent btn">
                                      <div class="d-flex justify-content-between title">
                                          <h3 class="font-weight-bold"><?php echo $SeriesSeason->series_seasons_name; ?></h3>
                                      </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="col-8 d-flex justify-content-start p-0">
                                                    <span class="descript text-white">{{ __($ppv_series_description) }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <h3 class="pl-2" style="font-weight:700;" id="price-display">
                                                        <?php echo $currency->enable_multi_currency == 1 ? Currency_Convert($SeriesSeason->ppv_price) : $currency->symbol .$SeriesSeason->ppv_price; ?>
                                                    </h3>
                                                </div>
                                        </div>

                                        <div class="mb-0 mt-3 p-0 text-left">
                                            <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2">Select payment method:</h5>
                                        </div>

                                      <!-- Stripe Button -->
                                      <?php if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="tres_important" name="payment_method" value="<?php echo $stripe_payment_setting->payment_type; ?>" data-value="stripe">
                                              <?php echo !empty($stripe_payment_setting->stripe_lable) ? $stripe_payment_setting->stripe_lable : 'Stripe'; ?>
                                          </label>
                                      <?php endif; ?>

                                      <!-- Razorpay Button -->
                                      <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $Razorpay_payment_setting->payment_type; ?>" data-value="Razorpay">
                                              <?php echo !empty($Razorpay_payment_setting->razorpay_lable) ? $Razorpay_payment_setting->razorpay_lable : 'Razorpay'; ?>
                                          </label>
                                      <?php endif; ?>

                                      <!-- Paystack Button -->
                                      <?php if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" name="payment_method" value="<?php echo $Paystack_payment_setting->payment_type; ?>" data-value="Paystack">
                                              <?php echo $Paystack_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>

                                                <!-- PayPal Button -->
                                        <?php if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $paypal_payment_setting->payment_type; ?>" data-value="PayPal">
                                              <?php echo !empty($paypal_payment_setting->paypal_lable) ? $paypal_payment_setting->paypal_lable : 'Paypal'; ?>
                                          </label>
                                      <?php endif; ?>
                                  </div>

                                  <div class="becomesubs-page">
                                      <div class="Stripe_button row mt-3 justify-content-around">  
                                          <div class="Stripe_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('Stripe_payment_series_season_PPV_Purchase/'.$SeriesSeason->id.'/'.$SeriesSeason->ppv_price) ?>' ;"> <!-- Stripe Button -->
                                              <?= ("Continue") ?>
                                          </div>
                                          <div class="Stripe_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                          </div>
                                      </div>

                                      <div class="row mt-3 justify-content-around">  <!-- Razorpay Button -->
                                        <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                          <div class="Razorpay_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('RazorpayVideoRent/' . $SeriesSeason->id . '/' . $SeriesSeason->ppv_price) ?>' ;">
                                             <?= ("Continue") ?>
                                          </div>
                                        <?php endif; ?>
                                          <div class="Razorpay_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                          </div>
                                      </div>

                                      <div class="row mt-3 justify-content-around"> <!-- Paystack Button -->
                                        <?php if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack'): ?>
                                          <div class="paystack_button col-md-6 col-6 btn text-white" onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => $SeriesSeason->id, 'amount' => $SeriesSeason->ppv_price]) ?>' ;"> 
                                                <?= ("Continue") ?>
                                          </div>
                                        <?php endif; ?>
                                          <div class="paystack_button col-md-5 col-5 btn">
                                            <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                            </button>
                                          </div>
                                      </div>

                                      <div class="row mt-3 justify-content-around"> <!-- PayPal Button -->
                                        <?php if (!Auth::guest() && $paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                                <div class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" onclick="paypal_checkout(<?php echo $SeriesSeason->id; ?>, <?php echo $SeriesSeason->ppv_price; ?>)">
                                                    <?= ("Continue") ?>
                                                </div>
                                                <?php else :?>
                                                <a href="<?= URL::to('/login') ?>" >  
                                                    <div class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now">
                                                        <?= ("Continue") ?>
                                                    </div></a>
                                            <?php endif; ?>

                                          <div class="paypal_button col-md-5 col-5 btn">
                                            <button type="button" class="btn text-white paypal_pay_now" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                            </button>
                                          </div>
                                      </div>

                                        <!-- PayPal Button Container -->
                                        <div id="paypal-button-container"></div>

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

    <!-- Free content - Video Not display  -->

    <?php
    $free_content_duration = $episode->free_content_duration;
    $user_access = $episode->access;
    $Auth = Auth::guest();
    ?>

    <!-- Modal
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLongTitle"
                        style="color:#000;font-weight: 700;">
                        {{ __('Rent Now') }}
                    </h4>
                    <img src=" {{ URL::to('public/uploads/images/' . $episode->player_image) }}" alt=""
                        width="50" height="60">
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-2" style="width:52%;">
                            <span id="paypal-button"></span>
                        </div>

                        <?php $payment_type = App\PaymentSetting::get(); ?>
                        <div class="col-sm-4">
                            <span class="badge badge-secondary p-2">{{ __($episodes->title) }} </span>
                            <span
                                class="badge badge-secondary p-2">{{ __($episodes->age_restrict) . ' ' . '+' }}</span>

                            <span class="badge badge-secondary p-2"></span>
                            <span class="trending-year"> {{ $episode->year == 0 ? ' ' : $episode->year }}</span>
                            <button type="button" class="btn btn-primary"
                                data-dismiss="modal">{{ __($currency->symbol . ' ' . $episodes->ppv_price) }}</button>
                            <label for="method">
                                <h3>{{ __('Payment Method') }}</h3>
                            </label>

                            <label class="radio-inline">
                                @foreach ($payment_type as $payment)
                                    @if ($payment->live_mode == 1)
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
                            <input type="radio" id="tres_important" checked name="payment_method"
                                value="{{ $payment->payment_type }}">
                            {{ !empty($payment->stripe_lable) ? $payment->stripe_lable : $payment->payment_type }}
                            </label><br>
                        @elseif($payment->paypal_live_mode == 0)
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
                    <a onclick="pay({{ $episode->ppv_price }})">
                        <button type="button" class="btn btn-primary"
                            id="submit-new-cat">{{ __('Continue') }}</button>
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

    <?php 
          foreach($season as $key => $seasons): ?>
             <div class="modal fade" 
            id="season-purchase-now-modal-<?= $seasons->id; ?>" tabindex="-1" 
            role="dialog" aria-labelledby="season-purchase-now-modal-<?= $seasons->id; ?>-Title" 
            aria-hidden="true" style="top: 0;">
            <div id="purchase-modal-dialog" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content container-fluid bg-dark">

                      <div class="modal-header align-items-center">
                          <div class="row">
                              <div class="col-12">
                                  <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">
                              </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-end">
                              <?php if (Auth::check() && (Auth::user()->role == 'registered' || Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin')): ?>
                                  <img src="<?php echo $user_avatar; ?>" alt="<?php echo $user_name; ?>">
                                  <h5 class="pl-4"><?php echo $user_name; ?></h5>
                              <?php endif; ?>
                          </div>
                      </div>

                      <div class="modal-body">
                          <div class="row justify-content-between m-0">
                              <h3 class="font-weight-bold"><?php echo $seasons->series_seasons_name; ?></h3>
                              <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                              </button>
                          </div>
                          <p class="text-white">You are currently on plan.</p>
                          <div class="row justify-content-between m-0" style="gap: 4rem;">
                              <div class="col-sm-4 col-12 p-0">
                                  <img class="img__img w-100" src="<?php echo $seasons->image; ?>" class="img-fluid" alt="<?php echo $seasons->series_seasons_name; ?>" style="border-radius: 10px;">
                              </div>

                              <div class="col-sm-7 col-12 details">
                                  <div class="movie-rent btn">
                                      <div class="d-flex justify-content-between title">
                                          <h3 class="font-weight-bold"><?php echo $seasons->series_seasons_name; ?></h3>
                                      </div>

                                      <div class="d-flex justify-content-between align-items-center mt-3">
                                          <div class="col-8 d-flex justify-content-start p-0">
                                              <span class="descript text-white"><?php echo $ppv_series_description; ?></span>
                                          </div>
                                          <div class="col-4">
                                              <h3 class="pl-2" style="font-weight:700;" id="price-display">
                                                  <?php echo $currency->enable_multi_currency == 1 ? Currency_Convert($seasons->ppv_price) : $currency->symbol .$seasons->ppv_price; ?>
                                              </h3>
                                          </div>
                                      </div>

                                      <div class="mb-0 mt-3 p-0 text-left">
                                          <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2">Select payment method:</h5>
                                      </div>

                                      <!-- Stripe Button -->
                                      <?php if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="tres_important" name="payment_method" value="<?php echo $stripe_payment_setting->payment_type; ?>" data-value="stripe">
                                              <?php echo $stripe_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>

                                      <!-- Razorpay Button -->
                                      <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $Razorpay_payment_setting->payment_type; ?>" data-value="Razorpay">
                                              <?php echo $Razorpay_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>

                                      <!-- Paystack Button -->
                                      <?php if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" name="payment_method" value="<?php echo $Paystack_payment_setting->payment_type; ?>" data-value="Paystack">
                                              <?php echo $Paystack_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>

                                                <!-- PayPal Button -->
                                        <?php if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $paypal_payment_setting->payment_type; ?>" data-value="PayPal">
                                              <?php echo $paypal_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>
                                  </div>

                                  <div class="becomesubs-page">
                                      <div class="Stripe_button row mt-3 justify-content-around">  
                                          <div class="Stripe_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('Stripe_payment_series_season_PPV_Purchase/'.$seasons->id.'/'.$seasons->ppv_price) ?>' ;"> <!-- Stripe Button -->
                                              <?= ("Continue") ?>
                                          </div>
                                          <div class="Stripe_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                          </div>
                                      </div>

                                      <div class="row mt-3 justify-content-around">  <!-- Razorpay Button -->
                                        <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                          <div class="Razorpay_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('RazorpaySeriesSeasonRent/' . $seasons->id . '/' . $seasons->ppv_price) ?>' ;">
                                             <?= ("Continue") ?>
                                          </div>
                                        <?php endif; ?>
                                          <div class="Razorpay_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                          </div>
                                      </div>


                                      <div class="row mt-3 justify-content-around"> <!-- Paystack Button -->
                                        <?php if (!Auth::guest() && $paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                            <div class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" onclick="paypal_checkout(<?php echo $seasons->id; ?>, <?php echo $seasons->ppv_price; ?>)">
                                                <?= ("Continue") ?>
                                            </div>
                                        <?php else :?>
                                            <a href="<?= URL::to('/login') ?>" >  <div style='#fff !important;'class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" >
                                            <?= ("Continue") ?>
                                            </div></a>
                                        <?php endif; ?>

                                          <div class="paypal_button col-md-5 col-5 btn" id="paypal_pay_cancel">
                                            <button type="button" class="btn text-white paypal_pay_now" data-dismiss="modal" aria-label="Close">
                                              <?= ("Cancel") ?>
                                            </button>
                                          </div>
                                      </div>
                                        <!-- PayPal Button Container -->
                                        <div id="paypal-button-container"></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        <?php endforeach; ?>


    <div class="clear"></div>
    <input type="hidden" id="episode_id" value="<?php echo $episode->id; ?>">
    <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script>

  
        function paypal_checkout(seasons_id, amount) {
            $('#paypal-button-container').empty();
                $('#paypal_pay_cancel').hide();
                $('.paypal_pay_now').hide();
        
                paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: amount,
                                }
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function (details) {
                            console.log(details);
                            $.ajax({
                                url: '<?= URL::to('paypal-ppv-series-season') ?>',
                                method: 'post',
                                data: {
                                    _token: '<?= csrf_token() ?>',
                                    amount: amount,
                                    SeriesSeason_id: seasons_id,
                                },
                                success: function(response) {
                                    console.log("Server response:", response);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                },
                                error: function(error) {
                                    swal('error');
                                }
                            });
                        });
                    },
                    onError: function (err) {
                        console.error(err);
                    }
                }).render('#paypal-button-container'); 
            }
        
        
          $(document).ready(function() {
        
            $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button,.paypal_button').hide();
        
            $(".payment_btn").click(function() {
        
                $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button,.paypal_button').hide();
        
                let payment_gateway = $('input[name="payment_method"]:checked').val();
        
                if (payment_gateway == "Stripe") {
        
                    $('.Stripe_button').show();
        
                } else if (payment_gateway == "Razorpay") {
        
                    $('.Razorpay_button').show();
        
                } else if (payment_gateway == "Paystack") {
        
                    $('.paystack_button').show();
        
                } else if (payment_gateway == "CinetPay") {
        
                    $('.cinetpay_button').show();
                }
                else if (payment_gateway == "PayPal") {
        
                    $('.paypal_button').show();
        
                }
            });
        
        
          });
        
        </script>
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
    
    ?>

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
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode removed from watchlater</div>'
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
                        $(id).find($(".ri-heart-line")).removeClass('ri-heart-line').addClass('ri-heart-fill');

                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to wishlist</div>'
                        );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                    } else if (data.message == "Add the Watch list") {
                        $(id).data('myval');
                        $(id).data('myval', 'add');
                        $(id).find($(".ri-heart-fill")).removeClass('ri-heart-fill').addClass('ri-heart-line');

                        $("body").append(
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 20%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode removed from wishlist</div>'
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
            var media_path = '<?= $media_url ?>';;
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 66px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
            );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }

        function EmbedCopy() {
            var media_path = '<?= $url_path ?>';
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 66px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>'
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
                }
            });
            CinetPay.onError(function(data) {
                console.log(data);
            });
        }

        window.onload = function () {
            setTimeout(function () {
                $(".header_top_position_img").fadeOut('fast');
            }, 4000);
        };

    </script>

     

<?php
    include public_path('themes/theme4/views/footer.blade.php');
    // include public_path('themes/theme4/views/episode_player_script.blade.php');
?>