@php
     include(public_path('themes/default/views/header.php'));
     include( public_path('themes/default/views/video-js-Player/Livestream/live-ads.blade.php'));
     include( public_path('themes/default/views/video-js-Player/Livestream/live-player-script.blade.php'));    
@endphp

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
    body.dark-theme .modal-content{background-color: <?php echo GetAdminDarkBg(); ?>!important;;color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
 
    div#video\ sda{position:relative;}
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 2%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    @media (max-width: 500px) {
        .category-name {
            display: inline-block;
            max-width: 5ch; /* Adjust to fit exactly 10 characters */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    .modal {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        display: none;
        overflow: hidden;
        outline: 0;
    }

    .responsive-iframe {
        position: relative !important;
    }
</style>

<!-- video-js Style  -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
<link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet">
<link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet">
<link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet">

<!-- Style -->
<link rel="preload" href="{{ URL::to('public/themes/default/assets/css/style.css') }}" as="style">

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
    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/video-js-Player/Livestream/live-player", ['Livestream_details' => $Livestream_details, 'play_btn_svg' => $play_btn_svg])->content() !!}

    <div class="container-fluid video-details">
        <div class="row">

                        {{-- BREADCRUMBS --}}
            <div class="col-sm-12 col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"  href="{{ route('liveList') }}"> {{ucwords(__('Livestreams')) }}</a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                @empty($category_name)
                                    @foreach ($category_name as $key => $video_category_name) 
                                        <?php $category_name_length = count($category_name); ?>
                                        <li class="breadcrumb-item">
                                            <a class="black-text"
                                                href= "{{route ('LiveCategory', [$video_category_name->categories_slug])}} ">
                                                {{ ucwords($video_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '')}} 
                                            </a>
                                        </li>
                                    @endforeach

                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                @endempty

                                <li class="breadcrumb-item"><a class="black-text">{{ strlen($video->title) > 50 ? ucwords(substr($video->title, 0, 120) . '...') : ucwords($video->title) }}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 col-md-9 col-xs-12">
                <h1 class="trending-text big-title text-uppercase mt-3">
                    {!!  optional($Livestream_details)->title !!}
                </h1>
            </div>

            <div class="col-sm-3 col-md-3 col-xs-12">
                <div class=" d-flex mt-4 pull-right">
                    <div class="views">
                        <span class="view-count"><i class="fa fa-eye"></i>
                            {{ isset($view_increment) && $view_increment ? $video->views + 1 : $video->views }} {{  __('Views')  }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

                <!-- languages, categories time, public_current_time ,age_restrict -->
        <div class=" align-items-center text-white text-detail p-0">
            <span class="badge badge-secondary p-2">{{ __(@$video->languages->name) }}</span>
            <span class="badge badge-secondary p-2">{{ __(@$video->categories->name) }}</span>
            <span class="badge badge-secondary p-2">{{ __('Published On :'. $Livestream_details->public_current_time ) }} </span>
            <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->age_restrict) }}</span>
        </div>

                <!-- Social Share, Like Dislike -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-12">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/video-js-Player/Livestream/live-socail-share", ['Livestream_details' => $Livestream_details, 'play_btn_svg' => $play_btn_svg])->content() !!}
                </ul>
            </div>
        </div>
    </div>

            {{-- Description --}}
    <div class="container-fluid">
        <div class="text-white col-md-6 p-0">
            <p class="trending-dec w-100 mb-0 text-white"> {!! html_entity_decode(__($video->description)) !!}</p>
            <p class="trending-dec w-100 mb-3 text-white">{!! html_entity_decode(__($video->details)) !!}</p>
        </div>
    </div>

            {{-- CommentSection  --}}

    @if (App\CommentSection::first() != null && App\CommentSection::pluck('livestream')->first() == 1)
        <div class="row">
            <div class=" container-fluid video-list you-may-like overflow-hidden">
                <h4 style="color:#fffff;">{{ __('Comments') }} </h4>
                <?php include public_path('themes/default/views/comments/index.blade.php'); ?>
            </div>
        </div>
    @endif

            {{-- Related Videos --}}
    <div class="row">
        <div class="container-fluid video-list you-may-like overflow-hidden">
            <h4 style="color:#fffff;">{{ __('Related Videos') }}</h4>
            <div class="slider">
                <?php include public_path('themes/default/views/partials/live_related_video.blade.php'); ?>
            </div>
        </div>
    </div>

            {{-- Rent Modal  --}}
    @if ( $Livestream_details->access == "ppv" && !is_null($Livestream_details->ppv_price) )
        <div class="modal fade" id="live-purchase-now" tabindex="-1" role="dialog"aria-labelledby="live-purchase-nowTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:black">
                            {{ __('Purchase Now') }}
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-4 p-0" style="">
                                <img class="img__img w-100" src="{{ $Livestream_details->Thumbnail }}" class="img-fluid" alt="live-image">
                            </div>

                            <div class="col-sm-8">

                                <h4 class=" text-black movie mb-3">{{ __(@$Livestream_details->title) }}</h4>
                                <span class="badge badge-secondary  mb-2 ml-1">{{ $Livestream_details->duration != null ? gmdate('H:i:s', $Livestream_details->duration)  : null  }} </span><br>

                                <a type="button" class="mb-3 mt-3" data-dismiss="modal" style="font-weight:400;">{{ __('Amount') }}:
                                    <span class="pl-2" style="font-size:20px;font-weight:700;"> {{ $currency->enable_multi_currency == 1 ? Currency_Convert($Livestream_details->ppv_price) :  $currency->symbol .$Livestream_details->ppv_price }}</span>
                                </a><br>

                                <label class="mb-0 mt-3 p-0" for="method">
                                    <h5 style="font-size:20px;line-height: 23px;" class="font-weight-bold text-black mb-2"> {{ __('Payment Method') }} : </h5>
                                </label>

                                <!-- Stripe Button -->
                                @if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe')
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="tres_important" checked name="payment_method" value="{{ $stripe_payment_setting->payment_type }}" data-value="stripe">
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

                                <!-- CinetPay Button -->
                                {{-- @if ( $CinetPay_payment_settings && $CinetPay_payment_settings->payment_type == 'CinetPay' && $CinetPay_payment_settings->status == 1)
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" name="payment_method" value="{{ $CinetPay_payment_settings->payment_type }}" data-value="CinetPay">
                                        {{ $CinetPay_payment_settings->payment_type }}
                                    </label>
                                @endif --}}
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">

                        <div class="Stripe_button"> <!-- Stripe Button -->
                            <button class="btn2  btn-outline-primary "
                                onclick="location.href ='{{  $currency->enable_multi_currency == 1 ? route('Stripe_payment_live_PPV_Purchase',[ $Livestream_details->id,PPV_CurrencyConvert($Livestream_details->ppv_price) ]) : route('Stripe_payment_live_PPV_Purchase',[ $Livestream_details->id, $Livestream_details->ppv_price ]) }}' ;">
                                {{ __('Continue') }}
                            </button>
                        </div>

                        <div class="Razorpay_button"> <!-- Razorpay Button -->
                            @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay')
                                <button class="btn2  btn-outline-primary "
                                    onclick="location.href ='{{ route('RazorpayLiveRent', [$Livestream_details->id, $Livestream_details->ppv_price]) }}' ;">
                                    {{ __('Continue') }}
                                </button>
                            @endif
                        </div>

                        <div class="paystack_button"> <!-- Paystack Button -->
                            @if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack')
                                <button class="btn2  btn-outline-primary"
                                    onclick="location.href ='{{ route('Paystack_live_Rent', ['live_id' => $Livestream_details->id, 'amount' => $Livestream_details->ppv_price]) }}' ;">
                                    {{ __('Continue') }}
                                </button>
                            @endif
                        </div>

                        {{-- <div class="cinetpay_button"> <!-- Cinetpay Button -->
                            @if ($CinetPay_payment_settings && $CinetPay_payment_settings->payment_type == 'CinetPay')
                                <button onclick="cinetpay_checkout()" id=""
                                    class="btn2  btn-outline-primary">{{ __('Continue') }}</button>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
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

        $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

        $(".payment_btn").click(function() {

            $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

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

<?php
    // include('m3u_file_live.blade.php');
    include public_path('themes/default/views/footer.blade.php');
?>