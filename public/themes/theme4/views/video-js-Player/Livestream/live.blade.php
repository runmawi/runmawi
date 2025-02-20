@php
     include(public_path('themes/theme4/views/header.php'));
     include( public_path('themes/theme4/views/video-js-Player/Livestream/live-ads.blade.php'));
     include( public_path('themes/theme4/views/video-js-Player/Livestream/live-player-script.blade.php'));
@endphp

@if(Auth::check() && !Auth::guest())
    @php
        $user_name = Auth::user()->username;
        $user_img = Auth::user()->avatar;
        $user_avatar = $user_img !== 'default.png' ? URL::to('public/uploads/avatars/') . '/' . $user_img : URL::to('/assets/img/placeholder.webp');
    @endphp
@endif

<style type="text/css">

    .close {
       color: red;
       text-shadow: none;
    }

    .come-from-modal.left .modal-dialog,
    .come-from-modal.right .modal-dialog {
       margin: auto;
       width: 400px;
       background-color: #000 !important;
       height: 100%;
       -webkit-transform: translate3d(0%, 0, 0);
       -ms-transform: translate3d(0%, 0, 0);
       -o-transform: translate3d(0%, 0, 0);
       transform: translate3d(0%, 0, 0);
    }

    .come-from-modal.left .modal-content,
    .come-from-modal.right .modal-content {
       height: 100%;
       overflow-y: auto;
       border-radius: 0px;
    }

    .come-from-modal.left .modal-body,
    .come-from-modal.right .modal-body {
       padding: 15px 15px 80px;
    }

    .come-from-modal.right.fade .modal-dialog {
       right: 0;
       -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
       -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
       -o-transition: opacity 0.3s linear, right 0.3s ease-out;
       transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .come-from-modal.right.fade.in .modal-dialog {
       right: 0;
    }

    #sidebar-wrapper {
       height: calc(100vh - 80px - 75px) !important;
       border-radius: 10px;
       box-shadow: inset 0 0 10px #000000;
       color: #fff;
       transition: margin 0.25s ease-out;
    }

    .list-group-item-action:hover {
       color: #000 !important;
    }

    .list-group-item-light {
       background-color: transparent;
    }

    .list-group-item-light:hover {
       background-color: #fff;
       color: #000 !important;
    }

    a.list-group-item {
       border: none;
    }

    .list-group-flush::-webkit-scrollbar-thumb {
       background-color: red;
       border-radius: 2px;
       border: 2px solid red;
       width: 2px;
    }

    .list-group-flush {
       overflow-x: hidden !important;
       overflow: scroll;
       height: calc(91vh - 80px - 75px) !important;
       scroll-behavior: auto;
       scrollbar-color: rebeccapurple green !important;
    }

    .list-group-flush::-webkit-scrollbar {
       width: 8px;
    }

    .list-group-flush::-webkit-scrollbar-track {
       background: rgba(255, 255, 255, 0.2);

    }

    #sidebar-wrapper .sidebar-heading {
       padding: 10px 10px;
       font-size: 1.2rem;

    }

    .plyr__video-embed {
       position: relative;
    }

    #video_bg_dim {
       position: absolute;
       top: 0;
       bottom: 0;
       left: 0;
       right: 0;
    }

    .countdown {
       text-align: center;
       font-size: 60px;
       margin-top: 0px;
       color: red;
    }

    .favorites-slider .slick-prev, #trending-slider-nav .slick-prev {color: var(--iq-white); left: 0;top: 38%;}
    .favorites-slider .slick-next, #trending-slider-nav .slick-next {color: var(--iq-white);right: 0;top: 38%;}

    .fp-ratio {
       padding-top: 64% !important;
    }

    h2 {
       text-align: center;
       font-size: 35px;
       margin-top: 0px;
       font-weight: 400;
    }

    h3 {
       text-align: center;
       font-size: 25px;
       margin-top: 0px;
       font-weight: 400;
    }

    #videoPlayer {
       width: 100%;
       height: 100%;
       margin: 20px auto;
    }

    .plyr audio,.plyr iframe,.plyr video {
       display: block;
    }

    .plyr--video {
       height: calc(100vh - 80px - 75px);
       max-width: none;
       width: 100%;
    }

    .custom-skip-forward-button, .custom-skip-backward-button{
     top: 23% !important;
    }
    #video_bg p{color: #fff;}

    /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
       content: none;
    }

    ol.breadcrumb {
       color: white;
       background-color: transparent !important;
       font-size: revert;
    }

    .vjs-skin-hotdog-stand {
       color: #FF0000;
    }

    .vjs-skin-hotdog-stand .vjs-control-bar {
       background: #FFFF00;
    }

    .vjs-skin-hotdog-stand .vjs-play-progress {
       background: #FF0000;
    }

     .vjs-icon-hd:before{
        display:none;
    }
    .row{margin-right:0 !important}
    li.slick-slide{padding:3px;}
    .favorites-slider .slick-list {overflow: hidden;}

    body.light .modal-content{background: <?php echo GetAdminLightBg(); ?>!important;color: <?php echo GetAdminLightText(); ?>!important;} /* #9b59b6 */
    /* body.dark-theme .modal-content{background-color: <?php echo GetAdminDarkBg(); ?>!important;;color: <?php echo GetAdminDarkText(); ?>;}  */

    div#video\ sda{position:relative;}
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 2%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    body.light-theme span { color: white !important;}
    .my-video.video-js .vjs-big-play-button span{ color: black !important;}
    @media (max-width: 500px) {
        .category-name {
            display: inline-block;
            max-width: 5ch; /* Adjust to fit exactly 10 characters */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

        .responsive-iframe {
        position: relative !important;
        height: calc(100vh - 85px)!important;
    }

    
/* payment modal */
    #purchase-modal-dialog{max-width: 100% !important;margin: 0;}
    #purchase-modal-dialog .modal-content{min-height: 100vh;max-height: 245vh;}
    #purchase-modal-dialog .modal-header.align-items-center{height: 70px;border: none;}
    #purchase-modal-dialog .modal-header.align-items-center .col-12{height: 50px;}
    #purchase-modal-dialog .modal-header.align-items-center .d-flex.align-items-center.justify-content-end{height: 50px;}
    #purchase-modal-dialog .modal-header.align-items-center img{height: 100%;width: 100%;}
    .col-sm-7.col-12.details{border-radius: 10px;padding: 0 1.5rem;}
    /* .modal-open .modal{overflow-y: hidden;} */
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
</style>

<!-- video-js Style  -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="{{ asset('public/themes/theme4/assets/css/video-js/videojs.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
<link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet">
<link href="{{ asset('public/themes/theme4/assets/css/video-js/videos-player.css') }}" rel="stylesheet">
<link href="{{ asset('public/themes/theme4/assets/css/video-js/video-end-card.css') }}" rel="stylesheet">

<!-- Style -->
<link rel="preload" href="{{ URL::to('public/themes/theme4/assets/css/style.css') }}" as="style">

<!-- video-js Script  -->

<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
<script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
<script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
<script src="{{ asset('assets/js/video-js/videojs.ads.min.js') }}"></script>
<script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
<script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
<script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
<script src="{{ asset('assets/js/video-js/end-card.js') }}"></script>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypal_signature; ?>"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<input type="hidden" name="video_id" id="video_id" value="{{ $video->id }}">

                        {{-- Session Message --}}
@if (Session::has('message'))
    <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;">
        {{ Session::get('message') }}
    </div>
@endif
               {{-- Message Note --}}
<div id="message-note" ></div>

<div id="video_bg">
                        {{-- Player --}}
    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/video-js-Player/Livestream/live-player", ['Livestream_details' => $Livestream_details, 'play_btn_svg' => $play_btn_svg, 'enable_ppv_rent_live' => $enable_ppv_rent_live, 'button_text' => $button_text, 'subscribe_btn' => $subscribe_btn])->content() !!}

    @php
        $Current_time = Carbon\Carbon::now(current_timezone())->isoFormat('h:mm A');
        $startTime = Carbon\Carbon::parse($Livestream_details->program_start_time)->isoFormat('h:mm A');
        $recurring_program_Status = false;

        if($Current_time == $startTime || $startTime <= $Current_time){
            $recurring_program_Status = true;
        }
    @endphp

    @if( $Livestream_details->publish_type == "publish_now" || $Livestream_details->users_video_visibility_status == true || $recurring_program_Status == true )

        <div class="mar-left video-details">
            <div class="row">

                            {{-- BREADCRUMBS --}}

                <div class="col-sm-12 col-md-12 col-xs-12 p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bc-icons-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text" href="<?= route('liveList') ?>"><?= ucwords( __('Livestreams')) ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>
        
                                    @foreach ($category_name as $key => $video_category_name)
                                        @php $category_name_length = count($category_name); @endphp
                                        <li class="breadcrumb-item">
                                            <a class="black-text category-name" href="{{ route('LiveCategory', [$video_category_name->categories_slug]) }}">
                                                {{ ucwords($video_category_name->categories_name) }}{{ $key != $category_name_length - 1 ? ' - ' : '' }}
                                            </a>
                                            <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                        </li>
                                    @endforeach
        
                                    
        
                                    <li class="breadcrumb-item"><a class="black-text">{{ __($video->title)}}</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-9 col-md-9 col-xs-12">
                    <h1 class="trending-text big-title text-uppercase mt-3"><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
                        <!-- Category -->
                    <ul class="p-0 list-inline d-flex align-items-center movie-content">
                        <li class="text-white"><?//= $videocategory ;?></li>
                    </ul>
                </div>
        
                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right"> 
                        <div class="views">
                            <span class="view-count"><i class="fa fa-eye"></i> 
                                <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                            </span>
                        </div>
                    </div>
                </div>  
            </div>  

            <?php 
                if(!empty($video->publish_time)){
                        $originalDate = $video->publish_time;
                        $publishdate = date('d F Y', strtotime($originalDate));
                }else{
                        $originalDate = $video->created_at;
                        $publishdate = date('d F Y', strtotime($originalDate));
                }
            ?>

            <div class=" align-items-center text-white text-detail p-0">
                <span class="badge badge-secondary p-2"><?php echo __(@$video->languages->name);?></span>
                <span class="badge badge-secondary p-2"><?php echo (@$video->categories->name);?></span>
                <span class="badge badge-secondary p-2"><?php echo __('Published On'); ?> : <?php  echo $publishdate;?></span>
                <span class="badge badge-secondary p-2"><?php echo (@$video->age_restrict);?></span>
            </div>

            <?php if(!Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                <!-- Social Share, Like Dislike -->
                                <?php include(public_path('themes/theme4/views/partials/live-social-share.php')) ; ?>                   
                        </ul>
                    </div>
                </div>
    
            <?php } ?>

            <?php if(Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                <!-- Social Share, Like Dislike -->
                                <?php include(public_path('themes/theme4/views/partials/live-social-share.php')) ; ?>                   
                        </ul>
                    </div>
    
                </div>
            <?php   }?>

            <div class="mar-left">
                <div class="text-white col-md-6 p-0">
                    <p class="trending-dec w-100 mb-0 text-white">
                         {{ __(html_entity_decode(strip_tags($video->description))) }}
                        </p>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="video-details-container">
                            <?php if (!empty($video->details)) { ?>
                                <h6 class="mt-3 mb-1"><?php echo __('Live Details'); ?></h6>
                                <p class="trending-dec w-100 mb-3 text-white">{{ __(html_entity_decode(strip_tags($video->details))) }}</p>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>

                            <!-- CommentSection -->

            <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('livestream')->first() == 1 ): ?>
                <div class="">
                    <div class=" mar-left video-list you-may-like overflow-hidden mt-3">
                        <h4 class="" style="color:#fffff;">{{ __('Comments') }}</h4>
                        <?php include(public_path('themes/theme4/views/comments/index.blade.php')) ; ?>                   
                    </div>
                </div>
            <?php endif; ?>

            @if ( count($Related_videos) > 0 )
                <div class="channels-list video-list you-may-like overflow-hidden">
                    <h4 class="mar-left" style="color:#fffff;">{{ __('Related Live Streams') }}</h4>
                    <div class="channel-row favorites-contens sub_dropdown_image">  
                        <div class="video-list live-videos">
                            @foreach ($Related_videos as $related_video)
                                <div class="item depends-row">
                                    <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                        <div class="position-relative">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="flickity-lazyloaded" alt="{{ $related_video->title }}">
                                            <div class="controls">
                                                <a href="<?php echo URL::to('live/'.$related_video->slug ) ?>">
                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        
            {{-- Rent Modal  --}}
        @if ( $Livestream_details->access == "ppv" && !is_null($Livestream_details->ppv_price) )
            <div class="modal fade" id="live-purchase-now-modal" tabindex="-1" role="dialog" aria-labelledby="live-purchase-now-modal-Title" aria-hidden="true">
                <div id="purchase-modal-dialog" class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content container-fluid bg-dark">
    
                        <div class="modal-header align-items-center">
                            <div class="row">
                                <div class="col-12">
                                    <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                                @if(Auth::check() && (Auth::user()->role == 'registered' || Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin'))
                                    <img src="{{ $user_avatar }}" alt="{{ $user_name }}">
                                    <h5 class="pl-4">{{ $user_name }}</h5>
                                @endif
                                
                            </div>
                        </div>
    
                        <div class="modal-body">
                            <div class="row justify-content-between m-0">
                                <h3 class="font-weight-bold">{{ $Livestream_details->title}}</h3>
                                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p class="text-white">{{ 'You are currently on plan.' }}</p>
                            <div class="row justify-content-between m-0" style="gap: 4rem;">
                                <div class="col-sm-4 col-12 p-0" style="">
                                    <img class="img__img w-100" src="{{ URL::to('public/uploads/images/'.$Livestream_details->player_image) }}" class="img-fluid" alt="{{ $Livestream_details->title }}" style="border-radius: 10px;">
                                </div>
    
                                <div class="col-sm-7 col-12 details">
    
                                    <div class="movie-rent btn">
    
                                        <div class="d-flex justify-content-between title">
                                            <h3 class="font-weight-bold">{{ ( $Livestream_details->title) }}</h3>
                                        </div>
    
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="col-8 d-flex justify-content-start p-0" style="max-width: none;">
                                                <span class="descript text-white">{{ $ppv_live_description }}</span>
                                            </div>
                                            <div class="col-4">
                                                <h3 class="pl-2" style="font-weight:700;" id="price-display">{{ $currency->enable_multi_currency == 1 ? Currency_Convert($Livestream_details->ppv_price) :  $currency->symbol .$Livestream_details->ppv_price }}</h3>
                                            </div>
                                        </div>
    
                                        <div class="mb-0 mt-3 p-0 text-left">
                                            <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2"> {{ __('Select payment method') }} : </h5>
                                        </div>
    
                                        <!-- Stripe Button -->
                                        @if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe')
                                            <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                <input type="radio" class="payment_btn" id="tres_important" name="payment_method" value="{{ $stripe_payment_setting->payment_type }}" data-value="stripe">
                                                {{ $stripe_payment_setting->payment_type }}
                                            </label>
                                        @endif

                                        <!-- Razorpay Button -->
                                        @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay')
                                            <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                <input type="radio" class="payment_btn" id="important" name="payment_method" value="{{ $Razorpay_payment_setting->payment_type }}" data-value="Razorpay">
                                                {{ $Razorpay_payment_setting->payment_type }}
                                            </label>
                                        @endif

                                        <!-- Paystack Button -->
                                        @if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack')
                                            <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                <input type="radio" class="payment_btn" name="payment_method" value="{{ $Paystack_payment_setting->payment_type }}" data-value="Paystack">
                                                {{ $Paystack_payment_setting->payment_type }}
                                            </label>
                                        @endif

                                            <!-- PayPal Button -->
                                        @if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal')
                                            <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                <input type="radio" class="payment_btn" name="payment_method" value="{{ $paypal_payment_setting->payment_type }}" data-value="PayPal">
                                                {{ $paypal_payment_setting->payment_type }}
                                            </label>
                                        @endif

                                    </div>
                                    <div class=" becomesubs-page">
                                        <div class="Stripe_button row mt-3 justify-content-around">  
                                            <div class="Stripe_button col-md-6 col-6 btn"> <!-- Stripe Button -->
                                                <button class="btn text-white"
                                                    onclick="location.href ='{{  $currency->enable_multi_currency == 1 ? route('Stripe_payment_live_PPV_Purchase',[ $Livestream_details->id,PPV_CurrencyConvert($Livestream_details->ppv_price) ]) : route('Stripe_payment_live_PPV_Purchase',[ $Livestream_details->id, $Livestream_details->ppv_price ]) }}' ;">
                                                    {{ __('Continue') }}
                                                </button>
                                            </div>
                                            <div class="Stripe_button col-md-5 col-5 btn">
                                                <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
                                                    {{'Cancel'}}
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row mt-3 justify-content-around"> 
                                            <div class="Razorpay_button col-md-6 col-6 btn"> <!-- Razorpay Button -->
                                                @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay')
                                                <button class="btn text-white "
                                                onclick="location.href ='{{ route('RazorpayLiveRent', [$Livestream_details->id, $Livestream_details->ppv_price]) }}' ;">
                                                {{ __('Continue') }}
                                            </button>
                                                @endif
                                            </div>
                                            <div class="Razorpay_button col-md-5 col-5 btn">
                                                <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
                                                    {{'Cancel'}}
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row mt-3 justify-content-around"> 
                                            <div class="paystack_button col-md-6 col-6 btn"> <!-- Paystack Button -->
                                                @if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack')
                                                    <button class="btn text-white "
                                                        onclick="location.href ='{{ route('RazorpayLiveRent', [$Livestream_details->id, $Livestream_details->ppv_price]) }}' ;">
                                                        {{ __('Continue') }}
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="paystack_button col-md-5 col-5 btn">
                                                <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
                                                    {{'Cancel'}}
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row mt-3 justify-content-around"> <!-- PayPal Button -->
                                        <?php if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                                <div class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" onclick="paypal_checkout(<?php echo $Livestream_details->id; ?>, <?php echo $Livestream_details->ppv_price; ?>)">
                                                    <?= ("Continue") ?>
                                                </div>
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
        @endif
    @endif
    

    <div class="clear"></div>
</div>

<script>
    $(".share").on("mouseover", function() {
        $(".share a").show();
    }).on("mouseout", function() {
        $(".share a").hide();
    });
</script>

<!-- RESIZING FLUID VIDEO for VIDEO JS -->

<script type="text/javascript">
    $(document).ready(function() {
        $('a.block-thumbnail').click(function() {
            var myPlayer = videojs('video_player');
            var duration = myPlayer.currentTime();

            $.post('<?= URL::to('watchhistory') ?>', {
                video_id: '<?= $video->id ?>',
                _token: '<?= csrf_token() ?>',
                duration: duration
            }, function(data) {});
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

<script>



function paypal_checkout(live_id, amount) {

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
                    url: '<?= URL::to('paypal-ppv-live') ?>',
                    method: 'post',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        amount: amount,
                        live_id: live_id,
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

    $(".slider").slick({

        infinite: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    infinite: true
                }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                dots: true
            }
            },
            {
            breakpoint: 300,
            settings: "unslick" // destroys slick
        }]
    });
</script>

    <!-- PPV Purchase -->

<script type="text/javascript">
    // var ppv_exits = "<?php echo $ppv_exists; ?>";

    // if (ppv_exits == 1) {

    //     var i = setInterval(function() {
    //         PPV_live_PurchaseUpdate();
    //     }, 60 * 1000);

    //     window.onload = unseen_expirydate_checking();

    //     function PPV_live_PurchaseUpdate() {

    //         $.ajax({
    //             type: 'post',
    //             url: '<?= route('PPV_live_PurchaseUpdate') ?>',
    //             data: {
    //                 "_token": "<?= csrf_token() ?>",
    //                 "live_id": "<?php echo $video->id; ?>",
    //             },
    //             success: function(data) {
    //                 if (data.status == true) {
    //                     window.location.reload();
    //                 }
    //             }
    //         });
    //     }

    //     function unseen_expirydate_checking() {

    //         $.ajax({
    //             type: 'post',
    //             url: '<?= route('unseen_expirydate_checking') ?>',
    //             data: {
    //                 "_token": "<?= csrf_token() ?>",
    //                 "live_id": "<?php echo $video->id; ?>",
    //             },
    //             success: function(data) {
    //                 console.log(data);
    //                 if (data.status == true) {
    //                     window.location.reload();
    //                 }
    //             }
    //         });
    //     }
    // }

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
            }else if (payment_gateway == "PayPal") {

                $('.paypal_button').show();

            }
        });

    // Modal
        $("#live-purchase-now-button").click(function(){
            $("#live-purchase-now-modal").modal();
        });

     });
</script>

    {{-- CinePay Payment --}}

<script src="https://cdn.cinetpay.com/seamless/main.js"></script>

<script>
    var ppv_price = '<?= @$video->ppv_price ?>';
    var user_name = '<?php if (!Auth::guest()) { Auth::User()->username; } else {} ?>';
    var email = '<?php if (!Auth::guest()) { Auth::User()->email; } else { } ?>';
    var mobile = '<?php if (!Auth::guest()) { Auth::User()->mobile; } else {} ?>';
    var CinetPay_APIKEY = '<?= @$CinetPay_payment_settings->CinetPay_APIKEY ?>';
    var CinetPay_SecretKey = '<?= @$CinetPay_payment_settings->CinetPay_SecretKey ?>';
    var CinetPay_SITE_ID = '<?= @$CinetPay_payment_settings->CinetPay_SITE_ID ?>';
    var video_id = $('#video_id').val();

    function cinetpay_checkout() {
        CinetPay.setConfig({
            apikey: CinetPay_APIKEY,
            site_id: CinetPay_SITE_ID,
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
                    url: '<?php echo URL::to('CinetPay-live-rent'); ?>',
                    type: "post",
                    data: {
                        _token: '<?php echo csrf_token(); ?>',
                        amount: ppv_price,
                        live_id: video_id,

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
</script>

    
<script>
    var elem = document.querySelector('.live-rel-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
 </script>

<?php
    // include('m3u_file_live.blade.php');
    include public_path('themes/theme4/views/footer.blade.php');
?>
