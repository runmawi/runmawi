<?php include public_path('themes/theme6/views/header.php'); ?>

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

    select:valid {
        color: #808080 !important;
    }

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

    /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }

    .seasonpublisheddate {
        font-weight: bold !important;
        font-size: 19px !important;
    }

    .list-inline {
        list-style: none;
    }

    #season_id {
        background-color: var(--iq-bg1);
        border: none;
        border-radius: 0;
        color: var(--iq-white);
    }

    #season_id option {
        line-height: calc(1.5em + 1.2em);
        padding-left: 0.625em;
    }
</style>

<?php
$series = $series_data;
$media_url = URL::to('play_series/' . $series->slug);
$ThumbnailSetting = App\ThumbnailSetting::first();

$Series_Category = App\SeriesCategory::select('category_id', 'series_id', 'name', 'slug')
    ->join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
    ->where('series_id', $series->id)
    ->get();

$latest_Episode = App\Episode::where('active',1)->where('status',1)->where('series_id',$series->id)->latest()->first();

?>

<div id="myImage" class="container"
    style="background: url( {{ URL::to('public/uploads/images/' . $series->player_image) }} ) right no-repeat, linear-gradient(90deg, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0) 40%); background-size: cover;  padding: 0px 0px 0px;">
    <div> </div>
    <div class="container-fluid pt-5">
        <div id="series_bg_dim" class="{{ ($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest())) ? '' : 'darker' }}"></div>

        <div class="row mt-3 align-items-center">
            <?php if ( $ppv_exits > 0 || $video_access == 'free' ||
                ($series->access == 'guest' && $series->ppv_status != 1) ||
                (($series->access == 'subscriber' || $series->access == 'registered') &&
                    !Auth::guest() &&
                    Auth::user()->subscribed() &&
                    $series->ppv_status != 1) ||
                (!Auth::guest() &&
                    (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) ||
                (!Auth::guest() &&
                    $series->access == 'registered' &&
                    $settings->free_registration &&
                    Auth::user()->role != 'registered' &&
                    $series->ppv_status != 1)
            ) : ?>

            <div class="col-md-7 p-0">
                <div id="series_title" class="show-movie">
                    <div class=" p-2 text-white ">
                        <div class="trending-info p-0">
                                                        
                                                        {{-- Ṭitle --}}
                            <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">
                                {{ strlen($series->title) > 17 ? substr($series->title, 0, 18) . '...' : $series->title }}
                            </h1>

                                                        {{-- Rating --}}
                            <div class="slider-ratting d-flex align-items-center" data-animation-in="fadeInLeft">
                                @if (optional($series)->rating)
                                    <ul
                                        class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                                        @php $rating = ($series->rating / 2) ; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($rating >= $i)
                                                <li><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            @elseif ($rating + 0.5 == $i)
                                                <li><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                                            @else
                                                <li><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                            @endif
                                        @endfor
                                    </ul>
                                @endif
                                <span class="text-white ml-3">{{ $series->rating ? $series->rating / 2 : ' ' }}</span>
                            </div>

                                                        {{-- Category --}}
                            <ul class="p-0 mt-2 list-inline d-flex flex-wrap movie-content">
                                @foreach ($Series_Category as $key => $Series_Category_details)
                                    <li class="trending-list"><a class="text-primary title"
                                            href=" {{ URL::to('/series/category/' . $Series_Category_details->slug) }}">{{ $Series_Category_details->name }}</a>
                                    </li>
                                @endforeach
                            </ul>

                                                        {{-- year & season Count --}}
                            <div class="d-flex flex-wrap align-items-center text-white text-detail sesson-date">
                                <span> {{ App\SeriesSeason::where('series_id', $series->id)->count() }} Seasons</span>
                                <span class="trending-year">{{ optional($series)->year }}</span>
                            </div>

                                                        {{-- Details --}}
                            <div class="trending-">
                                <p class="m-0">{!! html_entity_decode(optional($series)->details) !!}</p>
                            </div>
                        </div>

                                                        {{-- Episode --}}
                        @if( $latest_Episode != null )
                            <div class="position-relative mt-5">
                                <a href="{{ URL::to('episode/'. $series->slug.'/'.$latest_Episode->slug ) }}" class="d-flex align-items-center">
                                    <div class="play-button"> <i class="ri-play-fill"></i></div>
                                    <h4 class="w-name text-white font-weight-700">Watch latest Episode</h4>
                                </a>
                            </div>
                        @endif

                        <div class="col-12 mt-auto mb-auto mt-3 p-0">
                            <ul class="list-inline p-0 mt-5 share-icons music-play-lists">
                                <li class="share mb-0">
                                    <span><i class="ri-share-fill"></i></span>
                                    <div class="share-box">
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="share-ico"><i class="ri-facebook-fill"></i></a>
                                            <a href="#" class="share-ico"><i class="ri-twitter-fill"></i></a>
                                            <a href="#" class="share-ico"><i class="ri-links-fill"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-0"><span><i class="ri-heart-fill"></i></span></li>
                                <li class="mb-0"><span><i class="ri-add-line"></i></span></li>
                            </ul>

                            <ul
                                class="p-0 list-inline d-flex flex-wrap align-items-center movie-content movie-space-action flex-wrap iq_tag-list">
                                @if (optional($series)->search_tag)

                                    <li class="text-primary text-lable"><i class="fa fa-tags font-Weight-900"
                                            aria-hidden="true"></i>TAGS:</li>
                                            
                                    <li> <p class="tag-list m-0" >{{ optional($series)->search_tag }}</p></li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center" id="theDiv">
            </div>
        </div>
    </div>
</div>

<section id="tabs" class="project-tab">
    <div class="container-fluid p-0">

        <!-- BREADCRUMBS -->

        <!-- <div class="row">
            <div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
                <div class="bc-icons-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="black-text"
                                href="<?= route('series.tv-shows') ?>"><?= ucwords('Series') ?></a>
                            <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                        </li>

                        <?php foreach ($category_name as $key => $series_category_name) { ?>
                        <?php $category_name_length = count($category_name); ?>
                        <li class="breadcrumb-item">
                            <a class="black-text"
                                href="<?= route('SeriesCategory', [$series_category_name->categories_slug]) ?>">
                                <?= ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                            </a>
                        </li>
                        <?php } ?>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                        <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title); ?> </a></li>
                    </ol>
                </div>
            </div>
        </div> -->

        <!-- <div class="row">
            <div class="col-md-12 mt-4">
                <nav class="nav-justified">
                    <div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
                        <h4 class="ml-3">Episode</h4>

                    </div>
                </nav>
            </div> -->

        <div class="container-fluid mt-5">
            <div class="favorites-contens">

                {{-- Season Depends Episode --}}

                @if(($season)->isNotEmpty())

                    <div class="col-md-3 p-0" style="width:150px">
                        <select class="form-control season-depends-episode" id="season_id" name="season_id" style="box-shadow: none;">
                            @foreach ($season as $key => $seasons)
                                <option data-key="{{ $key + 1 }}" value="{{ $seasons->id }}"> {{ 'Season '. ($key + 1) }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="data">
                        @partial('season_depends_episode_section')
                    </div>
                @endif

                <ul class="category-page list-inline row p-3 mb-0">
                    <?php 
                    foreach($season as $key => $seasons):  
                      foreach($seasons->episodes as $key => $episodes):
                        if($seasons->ppv_interval > $key):
							 ?>

                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id ?>">
                        <a href="<?php echo URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug; ?>">
                            <div class="block-images position-relative episodes_div season_<?= $seasons->id ?>">
                                <div class="img-box">
                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" class="img-fluid w-100">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>

                                    <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                    <p class="p-tag"><?php echo 'Free'; ?></p>
                                    <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$settings->ppv_price;
                                    ?></p> -->
                                    <?php }elseif(!empty($seasons->ppv_price)){?>
                                    <p class="p-tag"><?php echo 'Free'; ?></p>
                                    <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$seasons->ppv_price;
                                    ?></p> -->
                                    <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                    <p class="p-tag"><?php echo 'Free'; ?></p>
                                    <?php } ?>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="block-description"></div>


                            <h6><?= $episodes->title ?></h6>
                            <p class="text-white desc mb-0"><?= gmdate('H:i:s', $episodes->duration) ?></p>

                           

                        </a>
                    </li>

                    <?php else : ?>
                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id ?>">
                        <a href="<?php echo URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug; ?>">
                        

                        </a>
                    </li>
                    <?php endif;	endforeach; 
						                      endforeach; ?>
                </ul>


<!-- Starring -->

                    {{-- <div class="sectionArtists-Artists">   
                        <div class="Headingartist-artist">Starring</div>
                            <div class="listItems">
                                <a href="https://dev-flick.webnexs.org/artist/The_Chainsmokers_-_Halsey">
                                <div class="listItem">
                                    <div class="profileImg">
                                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                            <img src="https://templates.iqonic.design/streamit/frontend/html/images/genre/43.jpg">
                                        </span>
                                    </div>
                                    <div class="name">The Chainsmokers - Halsey</div>
                                    <div class="character">Art Director</div>
                                </div>
                                </a>
                                                  
                            </div>
                    </div> --}}



            </div>
        </div>
        <?php elseif( Auth::guest() && $series->access == "subscriber"):
						
					// }
						?>
    </div>

    <!-- <div  style="background: url(<?= URL::to('/') . '/public/uploads/images/' . $series->image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;"> -->
    <div class="col-sm-12">
        <div id="ppv">
            <h2 class="text-center" style="margin-top:80px;">Purchase to Watch the Series
                <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
            <div class="clear"></div>
        </div>
        <!-- </div>  -->


        <div class="col-md-2 text-center text-white">
            <div class="col-md-4">
                <?php if ( $series->ppv_status == 1 && !Auth::guest() && Auth::User()->role !="admin") { ?>
                <button class="btn btn-primary" onclick="pay(<?php echo $settings->ppv_price; ?>)">
                    Purchase For <?php echo $currency->symbol . ' ' . $settings->ppv_price; ?></button>
                <?php } ?>
                <br>
                <!-- </div> -->

                <!-- </div> -->
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</section>

<?php endif;?>
<?php $payment_type = App\PaymentSetting::get(); ?>

<?php include public_path('themes/theme6/views/footer.blade.php'); ?>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">
                    Rent Now</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2" style="width:52%;">
                        <span id="paypal-button"></span>
                    </div>
                    <?php $payment_type = App\PaymentSetting::get(); ?>

                    <div class="col-sm-4">
                        <label for="method">
                            <h3>Payment Method</h3>
                        </label>
                        <label class="radio-inline">
                            <?php  foreach($payment_type as $payment){
                          if($payment->stripe_status == 1 || $payment->paypal_status == 1){ 
                          if($payment->live_mode == 1 && $payment->stripe_status == 1){ ?>
                            <input type="radio" id="tres_important" checked name="payment_method"
                                value="{{ $payment->payment_type }}">
                            <?php if (!empty($payment->stripe_lable)) {
                                echo $payment->stripe_lable;
                            } else {
                                echo $payment->payment_type;
                            } ?>
                        </label>
                        <?php }elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?>
                        <label class="radio-inline">
                            <input type="radio" id="important" name="payment_method"
                                value="{{ $payment->payment_type }}">
                            <?php if (!empty($payment->paypal_lable)) {
                                echo $payment->paypal_lable;
                            } else {
                                echo $payment->payment_type;
                            } ?>
                        </label>
                        <?php }elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>
                        <input type="radio" id="tres_important" checked name="payment_method"
                            value="{{ $payment->payment_type }}">
                        <?php if (!empty($payment->stripe_lable)) {
                            echo $payment->stripe_lable;
                        } else {
                            echo $payment->payment_type;
                        } ?>
                        <br>
                        <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?>
                        <input type="radio" id="important" name="payment_method"
                            value="{{ $payment->payment_type }}">
                        <?php if (!empty($payment->paypal_lable)) {
                            echo $payment->paypal_lable;
                        } else {
                            echo $payment->payment_type;
                        } ?>

                        <?php  } }else{
                            echo "Please Turn on Payment Mode to Purchase";
                            break;
                         }
                         }?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="pay(<?php echo $settings->ppv_price; ?>)">
                    <button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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


    // alert(livepayment);

    $(document).ready(function() {

        $('.videoModalClose').click(function() {
            $('#videoPlayer1')[0].pause();
            $('#videos')[0].pause();

        });

        var imageseason = '<?= $season_trailer ?>';
        // console.log(imageseason)
        $("#videoPlayer1").hide();
        $("#videos").hide();

        var obj = JSON.parse(imageseason);
        console.log(obj)
        var season_id = $('#season_id').val();
        $.each(obj, function(i, $val) {
            if ('season_' + $val.id == season_id) {
                // alert($val.trailer_type)	
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
                    // $("#theDiv").append("<img id='theImg' src=$val.image/>");
                    $("#myImage").attr("src", $val.image);
                    // $("#videoPlayer1").attr("src", $val.trailer);
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
</script>

<script type="text/javascript">
    var first = $('select').val();
    $(".episodes_div").hide();
    $("." + first).show();

    $('select').on('change', function() {
        $(".episodes_div").hide();
        $("." + this.value).show();
    });
</script>

<script>
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
                    // For more Hls.js options, see https://github.com/dailymotion/hls.js
                    const hls = new Hls();
                    hls.loadSource(source);

                    // From the m3u8 playlist, hls parses the manifest and returns
                    // all available video qualities. This is important, in this approach,
                    // we will have one source on the Plyr player.
                    hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                        // Transform available levels into an array of integers (height values).
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

                        // alert($('#videos').attr("src"));
                        // alert(sourcevaltrailer);

                        document.addEventListener("DOMContentLoaded", () => {

                            // alert(sourcevaltrailer);
                            var video = document.querySelector('#videos');
                            // var sourcess = video.getElementsByTagName("source")[0].src;
                            // alert(sourcess);
                            var source = $val.trailer;
                            // alert(source);

                            const defaultOptions = {};

                            if (!Hls.isSupported()) {
                                video.src = source;
                                var player = new Plyr(video, defaultOptions);
                            } else {
                                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                                const hls = new Hls();
                                hls.loadSource(source);

                                // From the m3u8 playlist, hls parses the manifest and returns
                                // all available video qualities. This is important, in this approach,
                                // we will have one source on the Plyr player.
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
                // alert($val.id);
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
    $(".season-depends-episode").change(function() {
        
        const season_id = $(this,':selected').val();

        const series_id = $('#series_id').val();

        $.ajax({
            type: "get",
            url: "{{ route('front-end.series.season-depends-episode') }}",
            data: {
                series_id: series_id ,
                season_id: season_id ,
            },
            success: function(data) {
                $(".data").html(data);
            },
        });
    });
</script>
