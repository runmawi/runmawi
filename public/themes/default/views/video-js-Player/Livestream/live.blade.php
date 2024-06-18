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

    .modal-content{
        background:transparent;
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

<div id="video_bg">
                        {{-- Player --}}
    {!! Theme::uses('default')->load('public/themes/default/views/video-js-Player.Livestream.live-player', [ 'Livestream_details' => $Livestream_details , 'play_btn_svg' => $play_btn_svg])->content() !!}

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
                    <?php include public_path('themes/default/views/partials/live-social-share.php'); ?>
                </ul>
            </div>
        </div>
    </div>

        {{-- For Guest - subscriber , PPV button --}}
    @if (Auth::guest())
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-12">
                <ul class="list-inline p-0 mt-4 rental-lists">
                    <!-- Subscribe -->
                    @if ($video->access == 'subscriber')
                        <li>
                            <a href="{{ url('/login') }}">
                                <span class="view-count btn btn-primary subsc-video">{{ __('Subscribe') }}</span>
                            </a>
                        </li>
                    @endif

                    <!-- PPV button -->
                    @if ($video->access != 'guest')
                        <li>
                            <a data-toggle="modal" data-target="#exampleModalCenter" href="{{ url('/login') }}" class="view-count btn btn-primary rent-video"> {{ __('Rent') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif

        {{-- Description --}}
    <div class="container-fluid">
        <div class="text-white col-md-6 p-0">
            <p class="trending-dec w-100 mb-0 text-white"> {!! html_entity_decode(__($video->description)) !!}</p>
            <p class="trending-dec w-100 mb-3 text-white">{!! html_entity_decode(__($video->details)) !!}</p>
        </div>
    </div>

    <!-- CommentSection -->

    @if (App\CommentSection::first() != null && App\CommentSection::pluck('livestream')->first() == 1)
        <div class="row">
            <div class=" container-fluid video-list you-may-like overflow-hidden">
                <h4 style="color:#fffff;">{{ __('Comments') }} </h4>
                <?php include public_path('themes/default/views/comments/index.blade.php'); ?>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="container-fluid video-list you-may-like overflow-hidden">
            <h4 style="color:#fffff;">{{ __('Related Videos') }}</h4>
            <div class="slider">
                <?php include public_path('themes/default/views/partials/live_related_video.blade.php'); ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:black">
                        {{ __('Rent Now') }}
                    </h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-4 p-0" style="">
                            <img class="img__img w-100" src="{{ url('/public/uploads/images/' . $video->image) }}" class="img-fluid" alt="">
                        </div>

                        <div class="col-sm-8">
                            <h4 class=" text-black movie mb-3">
                                {{ __($video->title) }},
                                <span class="trending-year mt-2">
                                    @if ($video->year == 0)
                                        {{ '' }}
                                    @else
                                        {{ $video->year }}
                                    @endif
                                </span>
                            </h4>

                            <span class="badge badge-secondary  mb-2">{{ __($video->age_restrict) . ' ' . '+' }}</span>
                            <span class="badge badge-secondary  mb-2 ml-1">{{ __($video->duration) }}</span><br>

                            <a type="button" class="mb-3 mt-3" data-dismiss="modal" style="font-weight:400;">{{ __('Amount') }}:
                                <span class="pl-2" style="font-size:20px;font-weight:700;"> {{ __($currency->symbol . ' ' . $video->ppv_price) }}</span>
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
{{-- 
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
                            @if ( $CinetPay_payment_settings && $CinetPay_payment_settings->payment_type == 'CinetPay' && $CinetPay_payment_settings->status == 1)
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
                        <button class="btn2  btn-outline-primary" onclick="pay({{ $video->ppv_price }})">
                            {{ __('Continue') }}
                        </button>
                    </div>
{{-- 
                    <div class="Razorpay_button"> <!-- Razorpay Button -->
                        @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay')
                            <button class="btn2  btn-outline-primary "
                                onclick="location.href ='{{ route('RazorpayLiveRent', ['id' => $video->id, 'amount' => $video->ppv_price]) }}' ;">
                                {{ __('Continue') }}
                            </button>
                        @endif
                    </div>

                    @if ($video->ppv_price && $video->ppv_price != ' ')
                        <div class="paystack_button"> <!-- Paystack Button -->
                            @if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack')
                                <button class="btn2  btn-outline-primary"
                                    onclick="location.href ='{{ route('Paystack_live_Rent', ['live_id' => $video->id, 'amount' => $video->ppv_price]) }}' ;">
                                    {{ __('Continue') }}
                                </button>
                            @endif
                        </div>
                    @endif

                    @if ($video->ppv_price && $video->ppv_price != ' ')
                        <div class="cinetpay_button"> <!-- Cinetpay Button -->
                            @if ($CinetPay_payment_settings && $CinetPay_payment_settings->payment_type == 'CinetPay')
                                <button onclick="cinetpay_checkout()" id=""
                                    class="btn2  btn-outline-primary">{{ __('Continue') }}</button>
                            @endif
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>

    <script>
        $(".share").on("mouseover", function() {
            $(".share a").show();
        }).on("mouseout", function() {
            $(".share a").hide();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#video_container').fitVids();
            $('.favorite').click(function() {
                if ($(this).data('authenticated')) {
                    $.post('<?= URL::to('favorite') ?>', {
                        video_id: $(this).data('videoid'),
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    $(this).toggleClass('active');
                } else {
                    window.location = '<?= URL::to('login') ?>';
                }
            });
            //watchlater
            $('.watchlater').click(function() {

                if ($(this).data('authenticated')) {
                    $.post('<?= URL::to('ppvWatchlater') ?>', {
                        video_id: $(this).data('videoid'),
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    $(this).toggleClass('active');
                    $(this).html("");
                    if ($(this).hasClass('active')) {
                        $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
                    } else {
                        $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
                    }
                } else {
                    window.location = '<?= URL::to('login') ?>';
                }
            });

            //My Wishlist
            $('.mywishlist').click(function() {
                if ($(this).data('authenticated')) {
                    $.post('<?= URL::to('ppvWishlist') ?>', {
                        video_id: $(this).data('videoid'),
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    $(this).toggleClass('active');
                    $(this).html("");
                    if ($(this).hasClass('active')) {
                        $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
                    } else {
                        $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
                    }

                } else {
                    window.location = '<?= URL::to('login') ?>';
                }
            });

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

    <input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to('/purchase-live'); ?>">
    <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script type="text/javascript">
        var livepayment = $('#purchase_url').val();
        var publishable_key = $('#publishable_key').val();

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function pay(amount) {
            var video_id = $('#video_id').val();
            var handler = StripeCheckout.configure({
                key: publishable_key,
                locale: 'auto',
                token: function(token) {
                    console.log('Token Created!!'); // You can access the token ID with `token.id`.
                    console.log(token); // Get the token ID to your server-side code for use.
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: '<?php echo URL::to('purchase-live'); ?>',
                        method: 'post',
                        data: {
                            "_token": "<?= csrf_token() ?>",
                            tokenId: token.id,
                            amount: amount,
                            video_id: video_id
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
                description: 'PAY PeR VIEW',
                amount: amount * 100
            });
        }
    </script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

    <script>
        $(".slider").slick({

            // normal options...
            infinite: false,

            // the magic
            responsive: [{

                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    infinite: true
                }

            }, {

                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    dots: true
                }

            }, {

                breakpoint: 300,
                settings: "unslick" // destroys slick

            }]
        });
    </script>

    <!-- PPV Purchase -->

    <script type="text/javascript">
        var ppv_exits = "<?php echo $ppv_exists; ?>";

        if (ppv_exits == 1) {

            var i = setInterval(function() {
                PPV_live_PurchaseUpdate();
            }, 60 * 1000);

            window.onload = unseen_expirydate_checking();

            function PPV_live_PurchaseUpdate() {

                $.ajax({
                    type: 'post',
                    url: '<?= route('PPV_live_PurchaseUpdate') ?>',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        "live_id": "<?php echo $video->id; ?>",
                    },
                    success: function(data) {
                        if (data.status == true) {
                            window.location.reload();
                        }
                    }
                });
            }

            function unseen_expirydate_checking() {

                $.ajax({
                    type: 'post',
                    url: '<?= route('unseen_expirydate_checking') ?>',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        "live_id": "<?php echo $video->id; ?>",
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == true) {
                            window.location.reload();
                        }
                    }
                });
            }
        }

        window.onload = function() {
            $('.Razorpay_button,.paystack_button,.cinetpay_button').hide();
        }

        $(document).ready(function() {

            $(".payment_btn").click(function() {

                $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

                let payment_gateway = $('input[name="payment_method"]:checked').val();

                if (payment_gateway == "Stripe") {

                    $('.Stripe_button').show();
                    $('.Razorpay_button,.paystack_button,.cinetpay_button').hide();

                } else if (payment_gateway == "Razorpay") {

                    $('.paystack_button,.Stripe_button,.cinetpay_button').hide();
                    $('.Razorpay_button').show();

                } else if (payment_gateway == "Paystack") {

                    $('.Stripe_button,.Razorpay_button,.cinetpay_button').hide();
                    $('.paystack_button').show();
                } else if (payment_gateway == "CinetPay") {

                    $('.Stripe_button,.Razorpay_button,.paystack_button').hide();
                    $('.cinetpay_button').show();
                }
            });
        });
    </script>

    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>

    <script>
        var ppv_price = '<?= @$video->ppv_price ?>';
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
        var video_id = $('#video_id').val();

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
