@php
    include public_path('themes/theme4/views/header.php');
@endphp

<style type="text/css">
    .nav-pills li a {
        color: #fff !important;
    }

    nav {
        margin: 0 auto;
        align-items: center;
    }

    .desc {
        font-size: 14px;
    }

    h1 {
        font-size: 50px !important;
        font-weight: 500;
    }

    select:invalid {
        color: grey !important;
    }

    /* select:valid {
        color: #fff !important;
    } */

    .plyr__video-wrapper::before {
        display: none;
    }

    .img-fluid {
        min-height: 0px !important;
    }

    .form-control {
        line-height: 25px !important;
        font-size: 18px !important;

    }

    .sea {
        font-size: 14px;
    }

    .pls i {
        font-size: 25px;
        font-size: 25px;
    }

    .pls ul {
        list-style: none;
    }

    .close {
        /* float: right; */
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #FF0000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        display: flex !important;
        justify-content: end !important;
    }

    .modal-content {
        background-color: transparent;
    }

    .modal-dialog {
        max-width: 900px !important;
    }

    .modal {
            top: 40px;
        }

    .ply {
        width: 40px;
    }
    .model_close-button{
        border: 2px solid;
        width: 30px;
        height: 30px;
        font-size: 27px;
    }
    .model_close-button:hover{
        background:white;
        color:black;

    }
    .drp-close.model_close-button:hover {
        transform: none;
    }
    .trending-dec.mt-2 span.text-primary{
        cursor: pointer;
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

    body.dark-theme .block-description {
        background-image: none;
        backdrop-filter: none;
    }
    .form-control:focus{
        background-color: transparent;
        box-shadow:none;
    }
     .form-control option {
        background: #121111!important;
        color: #ffffff!important;
    }
   
</style>

<?php
    $series = $series_data;
    $media_url = URL::to('play_series/' . $series->slug);
    $ThumbnailSetting = App\ThumbnailSetting::first();
?>

<div id="myImage" style="background:linear-gradient(90deg, rgba(0, 0, 0, 1.3)47%, rgba(0, 0, 0, 0.3))40%, url(<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>);background-position:right; background-repeat: no-repeat; background-size:cover;padding:0px 0px 20px; ">
    <!-- <div class="dropdown_thumbnail" >
        <img  src="<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" alt="" style="height:450px;">
    </div> -->
    <!-- BREADCRUMBS -->

    <div class="row mr-2">
        <div class="nav container-fluid pl-0 mar-left " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('series.tv-shows') ?>"><?= ucwords(__('Channels')) ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <?php foreach ($category_name as $key => $series_category_name) { ?>
                    <?php $category_name_length = count($category_name); ?>
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="<?= route('SeriesCategory', [$series_category_name->categories_slug]) ?>">
                            <?= ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                        </a>
                        
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>
                    <?php } ?>

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title); ?> </a></li>
                </ol>
            </div>
        </div>
     </div>

    <div class="container-fluid pl-0">
        <div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker" <?php endif; ?>></div>

        <div class="container-fluid pl-3">
            @if( $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
                && !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
                Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
                $settings->free_registration && Auth::user()->role != 'registered' && $series->ppv_status != 1) )

            <div class="col-md-7 pl-0">
                <div id="series_title">
                    <div class="container-fluid pl-0">
                        <h3> {{ $series->title }} </h3>

                        <div class="row text-white">

                            <div class="col-lg-8 col-md-8 pl-3">

                                <?php echo __('Season'); ?> <span class="sea"> 1 </span> 
                                - <?php echo __('U/A English'); ?>

                                <p class="trending-dec mt-2" data-bs-toggle="modal" data-bs-target="#discription-Modal"> {!! substr($series->description, 0, 200) ? html_entity_decode(substr($series->description, 0, 200)) . "..." . " <span class='text-primary'> See More </span>": html_entity_decode($series->description ) !!} </p>
                                
                                    <!-- Model for banner discription -->
                                        <div class="modal fade info_model" id='discription-Modal' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                                <div class="container">
                                                    <div class="modal-content" style="border:none;">
                                                        <div class="modal-body">
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <img  src="<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" width="100%" alt="">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                                                <h2 class="caption-h2">{{ $series->title }}</h2>

                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                                                <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="trending-dec mt-4">{{ html_entity_decode($series->description ) }}</div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                <div class="row p-0 mt-3 align-items-center">

                                    <div class="col-md-2">
                                        <a data-video="{{ $series->trailer }}" data-toggle="modal" data-target="#videoModal">
                                            <img class="ply" src="{{ URL::to('assets/img/default_play_buttons.svg') }}" />
                                        </a>
                                    </div>

                                    <div class="col-md-1 pls  d-flex text-center mt-2">
                                        <div></div>
                                        <ul>
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

                                                        <a href="#" onclick="Copy();" class="share-ico"><i
                                                                class="ri-links-fill"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>Share
                                        </ul>
                                    </div>
                                </div>

                                <div class="modal fade modal-xl" id="videoModal" data-keyboard="false"
                                    data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                    aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <button type="button" class="close videoModalClose" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="modal-body">

                                                <video id="videoPlayer1" controls poster="{{ URL::to('public/uploads/images/' . $series->player_image) }}"
                                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="" type="video/mp4">
                                                </video>

                                                <video id="videos" class="" controls poster="{{ URL::to('public/uploads/images/' . $series->player_image) }}"
                                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                                    type="application/x-mpegURL">
                                                    <source id="m3u8urlsource" type="application/x-mpegURL" src="">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>

                                <script>
                                    const player = new Plyr('#videoPlayer1');
                                </script>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<section id="tabs" class="project-tab">
    <div class="container-fluid p-0">

        

        <div class=" ">
            <div class="col-md-12 mt-4 p-0">
                <nav class="nav-justified p-0 m-0 w-100">
                    <div class="nav" id="nav-tab" role="tablist">
                        <h4 class="ml-3"> {{ 'Episode' }} </h4>
                    </div>
                </nav>
            </div>

            <div class="container-fluid pl-3">
                <div class="favorites-contens">
                    <div class="col-md-3 p-0 mt-4">
                        <select class="form-control" id="season_id" name="season_id">
                            @foreach ($season as $key => $seasons)
                                <option data-key="{{ $key + 1 }}" value={{ 'season_' . $seasons->id }}>
                                    {{ $seasons->series_seasons_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="trending-contens sub_dropdown_image mt-3">
                        <ul id="trending-slider-nav" class= " list-inline m-0 row align-items-center" >
                            @foreach ($season as $key => $seasons)
                                @forelse ($seasons->episodes as $key => $episodes)
                                    @if ($seasons->ppv_interval > $key)
                                        <li class="slide-item episodes_div season_<?= $seasons->id ?>">
                                            <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                            <div class=" position-relative">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="img-fluid" >
                                                    <div class="controls">
                                                        <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                        </a>

                                                        <nav>
                                                        <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                        </nav>
                                                                                                        
                                                        <p class="trending-dec" >
                                                            {{ $episodes->description}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @else
                                        <li class="slide-item  episodes_div season_<?= $seasons->id ?>">
                                            <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                                <div class=" position-relative">
                                                    <img src="{{ URL::to('public/uploads/images/' . $episodes->image) }}" class="img-fluid w-100" >
                                                    <div class="controls">
                                                        <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                        </a>

                                                        <nav>
                                                        
                                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="fas fa-info-circle"  ></i><span>More info</span></button>
                                                    
                                                        </nav>
                                                                                                        
                                                        <p class="trending-dec" >
                                                            {{ $episodes->description}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @empty
                                    <li>
                                        <div class="e-item col-lg-3 col-sm-12 col-md-6">
                                            <div class="block-image position-relative">
                                                <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                                            </div>
                                        </div>
                                    </li>
                                @endforelse
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @elseif(Auth::guest() && $series->access == 'subscriber')
        </div>

        <div class="col-sm-12">
            <div id="ppv">
                <h2 class="text-center" style="margin-top:80px;">{{ __('Purchase to Watch the Series') }}
                    @if ($series->access == 'subscriber') 
                        {{ __('Subscribers') }}
                    @elseif($series->access == 'registered')
                        {{ __('Registered Users') }} @endif
                </h2>
                <div class="clear"></div>
            </div>

            <div class="col-md-2 text-center text-white">
                <div class="col-md-4">
                    @if ($series->ppv_status == 1 && !Auth::guest() && Auth::User()->role != 'admin')
                        <button class="btn btn-primary" onclick="pay(<?php echo $settings->ppv_price; ?>)">
                            {{ 'Purchase For'.$currency->symbol ." ".$settings->ppv_price }}
                        </button>
                    @endif
                    <br>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>



@endif
<?php $payment_type = App\PaymentSetting::get(); ?>

@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">
                    {{ __('Rent Now') }}
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2" style="width:52%;">
                        <span id="paypal-button"></span>
                    </div>

                    <?php $payment_type = App\PaymentSetting::get(); ?>

                    <div class="col-sm-4">
                        <label for="method">
                            <h3> {{ __('Payment Method') }} </h3>
                        </label>
                        @foreach ($payment_type as $payment)
                            @if ($payment->stripe_status == 1 || $payment->paypal_status == 1)
                                @if ($payment->live_mode == 1 && $payment->stripe_status == 1)
                                    <label class="radio-inline">
                                        <input type="radio" id="tres_important" checked name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        @if (!empty($payment->stripe_lable))
                                            {{ $payment->stripe_lable }}
                                        @else
                                            {{ $payment->payment_type }}
                                        @endif
                                    </label>
                                @elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1)
                                    <label class="radio-inline">
                                        <input type="radio" id="important" name="payment_method"
                                            value="{{ $payment->payment_type }}">
                                        @if (!empty($payment->paypal_lable))
                                            {{ $payment->paypal_lable }}
                                        @else
                                            {{ $payment->payment_type }}
                                        @endif
                                    </label>
                                @elseif($payment->live_mode == 0 && $payment->stripe_status == 1)
                                    <input type="radio" id="tres_important" checked name="payment_method"
                                        value="{{ $payment->payment_type }}">
                                    @if (!empty($payment->stripe_lable))
                                        {{ $payment->stripe_lable }}
                                    @else
                                        {{ $payment->payment_type }}
                                    @endif <br>
                                @elseif($payment->paypal_live_mode == 0 && $payment->paypal_status == 1)
                                    <input type="radio" id="important" name="payment_method"
                                        value="{{ $payment->payment_type }}">
                                    @if (!empty($payment->paypal_lable))
                                        {{ $payment->paypal_lable }}
                                    @else
                                        {{ $payment->payment_type }}
                                    @endif
                                @endif
                            @else
                                {{ __('Please Turn on Payment Mode to Purchase') }}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="pay({{ $settings->ppv_price }})">
                    <button type="button" class="btn btn-primary" id="submit-new-cat">{{ 'Continue' }}</button>
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="publishable_key" id="publishable_key" value="<?= $publishable_key ?>">
<input type="hidden" name="series_id" id="series_id" value="<?= $series->id ?>">

<input type="hidden" name="m3u8url_datasource" id="m3u8url_datasource" value="">

<script src="https://checkout.stripe.com/checkout.js"></script>

<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to('/purchase-series'); ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<script type="text/javascript">
    var purchase_series = $('#purchase_url').val();
    var publishable_key = $('#publishable_key').val();

    $(document).ready(function() {

        $('.videoModalClose').click(function() {
            $('#videoPlayer1')[0].pause();
            $('#videos')[0].pause();

        });

        var imageseason = '<?= $season_trailer ?>';
        $("#videoPlayer1").hide();
        $("#videos").hide();

        var obj = JSON.parse(imageseason);
        // console.log(obj)
        var season_id = $('#season_id').val();
        $.each(obj, function(i, $val) {
            if ('season_' + $val.id == season_id) {
                console.log('season_' + $val.id)
                if ($val.trailer_type == 'mp4_url' || $val.trailer_type == null) {
                    $("#videoPlayer1").show();
                    $("#videos").hide();
                    $("#videoPlayer1").attr("src", $val.trailer);


                    $('.videoModalClose').click(function() {
                        $('#videoPlayer1')[0].pause();
                    });

                } else {
                    $("#videoPlayer1").hide();
                    $("#videos").show();
                    $("#m3u8urlsource").attr("src", $val.trailer);

                    $('.videoModalClose').click(function() {
                        $('#videos')[0].pause();
                    });
                }
            }
        });

        $('#season_id').change(function() {
            var season_id = $('#season_id').val();

            $.each(obj, function(i, $val) {
                if ('season_' + $val.id == season_id) {
                    console.log('season_' + $val.id)
                    $("#myImage").attr("src", $val.image);
                    if ($val.trailer_type == 'mp4_url' || $val.trailer_type == null) {
                        $("#videoPlayer1").show();
                        $("#videos").hide();

                        $("#videoPlayer1").attr("src", $val.trailer);
                    } else {
                        $("#videoPlayer1").hide();
                        $("#videos").show();
                        $("#m3u8urlsource").attr("src", $val.trailer);
                    }

                    $(".sea").empty();
                    // alert($val.id);
                    var id = $val.id;
                    $(".sea").html(i + 1);
                }
            });
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function pay(amount) {
        var series_id = $('#series_id').val();

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
                    url: '<?php echo URL::to('purchase-series'); ?>',
                    method: 'post',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        tokenId: token.id,
                        amount: amount,
                        series_id: series_id
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
            description: 'PAY PeR VIEW',
            amount: amount * 100
        });
    }

    var first = $('select').val();
    $(".episodes_div").hide();
    $("." + first).show();

    $('select').on('change', function() {
        $(".episodes_div").hide();
        $("." + this.value).show();
    });

    var imageseason = '<?= $season_trailer ?>';
    $("#videoPlayer1").hide();
    $("#videos").hide();

    var obj = JSON.parse(imageseason);
    console.log(obj)
    var season_id = $('#season_id').val();

    $.each(obj, function(i, $val) {

        if ($val.trailer_type == 'm3u8_url') {

            document.addEventListener("DOMContentLoaded", () => {

                var video = document.querySelector('#videos');

                var source = $val.trailer;

                const defaultOptions = {};

                if (!Hls.isSupported()) {
                    video.src = source;
                    var player = new Plyr(video, defaultOptions);
                } else {

                    const hls = new Hls();
                    hls.loadSource(source);

                    hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                        const availableQualities = hls.levels.map((l) => l.height)
                        availableQualities.unshift(0) //prepend 0 to quality array

                        // Add new qualities to option
                        defaultOptions.quality = {
                            default: 0, //Default - AUTO
                            options: availableQualities,
                            forced: true,
                            onChange: (e) => updateQuality(e),
                        }
                        // Add Auto Label 
                        defaultOptions.i18n = {
                            qualityLabel: {
                                0: 'Auto',
                            },
                        }

                        hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                            var span = document.querySelector(
                                ".plyr__menu__container [data-plyr='quality'][value='0'] span"
                            )
                            if (hls.autoLevelEnabled) {
                                span.innerHTML =
                                    `AUTO (${hls.levels[data.level].height}p)`
                            } else {
                                span.innerHTML = `AUTO`
                            }
                        })

                        // Initialize new Plyr player with quality options
                        var player = new Plyr(video, defaultOptions);
                    });

                    hls.attachMedia(video);
                    window.hls = hls;
                }

                function updateQuality(newQuality) {
                    if (newQuality === 0) {
                        window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                    } else {
                        window.hls.levels.forEach((level, levelIndex) => {
                            if (level.height === newQuality) {
                                console.log("Found quality match with " + newQuality);
                                window.hls.currentLevel = levelIndex;
                            }
                        });
                    }
                }
            });
        }
    });

    $('#season_id').change(function() {
        var season_id = $('#season_id').val();
        $.each(obj, function(i, $val) {
            if ('season_' + $val.id == season_id) {
                console.log('season_' + $val.id)
                $("#myImage").attr("src", $val.image);
                if ($val.trailer_type == 'mp4_url' || $val.trailer_type == null) {
                    $("#videoPlayer1").show();
                    $("#videos").hide();
                    $("#videoPlayer1").attr("src", $val.trailer);
                } else {
                    $("#videoPlayer1").hide();
                    $("#videos").show();
                    $("#m3u8urlsource").attr("src", $val.trailer);

                    if ($val.trailer_type == 'm3u8_url') {

                        document.addEventListener("DOMContentLoaded", () => {

                            var video = document.querySelector('#videos');

                            var source = $val.trailer;

                            const defaultOptions = {};

                            if (!Hls.isSupported()) {
                                video.src = source;
                                var player = new Plyr(video, defaultOptions);
                            } else {
                                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                                const hls = new Hls();
                                hls.loadSource(source);

                                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                                    // Transform available levels into an array of integers (height values).
                                    const availableQualities = hls.levels.map((l) => l
                                        .height)
                                    availableQualities.unshift(
                                        0) //prepend 0 to quality array

                                    // Add new qualities to option
                                    defaultOptions.quality = {
                                        default: 0, //Default - AUTO
                                        options: availableQualities,
                                        forced: true,
                                        onChange: (e) => updateQuality(e),
                                    }
                                    // Add Auto Label 
                                    defaultOptions.i18n = {
                                        qualityLabel: {
                                            0: 'Auto',
                                        },
                                    }

                                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event,
                                        data) {
                                        var span = document.querySelector(
                                            ".plyr__menu__container [data-plyr='quality'][value='0'] span"
                                        )
                                        if (hls.autoLevelEnabled) {
                                            span.innerHTML =
                                                `AUTO (${hls.levels[data.level].height}p)`
                                        } else {
                                            span.innerHTML = `AUTO`
                                        }
                                    })

                                    // Initialize new Plyr player with quality options
                                    var player = new Plyr(video, defaultOptions);
                                });

                                hls.attachMedia(video);
                                window.hls = hls;
                            }

                            function updateQuality(newQuality) {
                                if (newQuality === 0) {
                                    window.hls.currentLevel = -
                                        1; //Enable AUTO quality if option.value = 0
                                } else {
                                    window.hls.levels.forEach((level, levelIndex) => {
                                        if (level.height === newQuality) {
                                            console.log("Found quality match with " +
                                                newQuality);
                                            window.hls.currentLevel = levelIndex;
                                        }
                                    });
                                }
                            }
                        });
                    }
                }

                $(".sea").empty();
                var id = $val.id;
                $(".sea").html(i + 1);
            }
        });
    })

    function Copy() {
        var media_path = '<?= $media_url ?>';;
        var url = navigator.clipboard.writeText(window.location.href);
        var path = navigator.clipboard.writeText(media_path);
        $("body").append(
            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
        );
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    }
</script>

<script>
    
    $( window ).on("load", function() {
        $('.cnt-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.cnt-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.cnt-videos-slider-nav',
        });

        $('.cnt-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.cnt-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.cnt-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.cnt-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.cnt-videos-slider').hide();
        });
    });
</script>