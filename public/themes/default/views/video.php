<?php include 'header.php'; ?>


<?php

$ads_details = App\AdsVideo::join('advertisements', 'advertisements.id', 'ads_videos.ads_id')
    ->where('ads_videos.video_id', $video->id)
    ->pluck('ads_path')
    ->first();

$default_ads_url = App\Setting::pluck('default_ads_url')->first();
$default_ads_status = App\Video::where('id', $video->id)
    ->pluck('default_ads')
    ->first();

if ($default_ads_url != null && $default_ads_status == 1) {
    $default_ads = $default_ads_url;
} else {
    $default_ads = null;
}

if ($ads_details != null) {
    $ads_path = $ads_details;
} else {
    $ads_path = $default_ads;
}

include 'Adstagurl.php';

$autoplay = $video_tag_url == null ? 'autoplay' : '';

$CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first() ;

?>


<?php

$category_name = App\CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug')->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
->where('categoryvideos.video_id', $video->id)->get();

$Movie_name = App\LanguageVideo::select('languages.name as movie_name','languages.id as id')->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
->where('languagevideos.video_id', $video->id)->get();

$str = $video->m3u8_url;
if(!empty($str)){
$request_url = 'm3u8';
// dd($video->m3u8);  
}
if(!empty($request_url)){
?>
<input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url; ?>">
<?php } ?>


<input type="hidden" name="video_id" id="video_id" value="<?php echo $video->id; ?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo $playerui_settings->watermark_logo; ?>">
<input type="hidden" name="video_title" id="video_title" value="<?php echo $video->title; ?>">

<input type="hidden" name="current_time" id="current_time" value="<?php if (isset($watched_time)) {
    echo $watched_time;
} else {
    echo '0';
} ?>">
<input type="hidden" id="videoslug" value="<?php if (isset($video->slug)) {
    echo $video->slug;
} else {
    echo '0';
} ?>">
<input type="hidden" id="base_url" value="<?php echo URL::to('/'); ?>">
<input type="hidden" id="video_type" value="<?php echo $video->type; ?>">
<input type="hidden" id="video_video" class="video_video" value="video">
<input type="hidden" id="adsurl" value="<?php if (isset($ads->ads_id)) {
    echo get_adurl($ads->ads_id);
} ?>">
<style>
    
    .plyr__video-embed {
        position: relative;
    }
    span1{
        background-color: rgba(109,102,96,0.5);
        padding: 9px;
    }
    .countdown span1{
        margin: 2px 2px auto;
    }
    td {}

    th {
        text-align: center;
    }

    tr:nth-child(1) th:nth-child(1) {
        width: 55%;
    }

    .table-dark td,
    .table-dark th,
    .table-dark thead th {
        color: #fff;
    }

    .flk {
        font-size: 12px;
        font-weight: 300;
    }

    .pay {
        font-size: 12px;
    }

    .vjs-error .vjs-error-display .vjs-modal-dialog-content {
        font-size: 2.4em;
        text-align: center;
        padding-top: 20%;
    }
hr {
    height: 8px;
    // background-color: red;
    background-image: linear-gradient(90deg, red, transparent);
    
    border: 0;
    height: 1px;
    margin-bottom: 0!important;
    margin-top: 0!important;
}
    .vjs-seek-to-live-control {
        display: none !important;
    }

    input.skips,
    input#Recaps_Skip {
        background-color: #21252952;
        color: white;
        padding: 15px 32px;
        text-align: center;
        margin: 4px 2px;
    }

    .modal-header {
        padding: 10px !important;

    }

    .modal-title {
        color: #000;
        font-weight: 700;
        font-size: 24px !important;
        line-height: 33px;

    }

    label {
        font-size: 14px;
        line-height: 21px;
        padding-left: 5px;
        color: #000;
    }

    .modal-body {
        border-top: 1px solid rgba(0, 0, 0, 0.2) !important;
        border: none;
    }

    .modal-footer {

        border-top: 1px solid rgba(0, 0, 0, 0.2) !important;
        border: none;
    }

    .badge-secondary {
        color: #000;
        background: #F1F1F1;
        border-radius: 5px;
        font-weight: 700;
        font-size: 18px;
        line-height: 21px;
    }

    .modal-body a {
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        color: #000 !important;
    }

    .movie {
        font-weight: 700;
        font-size: 30px !important;
        line-height: 38px;
    }

    #intro_skip {
        display: none;
    }

    .button.close {
        color: red;
    }

    #Auto_skip {
        display: none;
    }

    .modal-content {
        background-color: #fff;
        border: 0px solid #F1F1F1;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        padding: 0;
    }

    .modal-dialog {
        max-width: 695px !important;
    }

    .modal {
        top: 2%;
    }

    #end_card_video {
        /* end_card_video */
        display: none;
    }

    h4 {
        font-size: 22px !important;
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

    div#url_linkdetails {
        position: absolute;
        top: 22%;
        left: 10%;
        font-size: x-large;

    }

    .intro_skips,
    .Recap_skip {
        position: absolute;
        z-index: 5;
        top: 60%;
        right: 0;
        display: flex;
        justify-content: flex-end;


    }

    .skips {
        position: absolute;
        top: -20%;
    }

    .end_card_video {
        position: absolute;

        left: 65%;

    }

    .countdown {
        text-align: center;
        font-size: 60px;
        margin-top: 0px;
        color: #fff;
        font-weight:bolder;
    }

    h2 {
        text-align: center;
        font-size: 60px;
        margin-top: 0px;
    }

    .btn1 {
        padding: 9px 30px !important;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid;

        font-size: 1rem;
        line-height: 1.5;
    }

    .btn2 {
        padding: 13px 45px !important;
        font-weight: 400;

        border: 1px solid;


    }

    .subsc-video {
        font-size: 18px !important;
    }

    .img__wrap {
        position: relative;
        height: 200px;
        widows: 250px;

    }

    .img__wrap {
        transform: scale(1.0);
    }

    .img__description_layer {
        position: absolute;
        cursor: pointer;
        padding: 30px 20px;
        bottom: 0;
        left: 0;
        right: 0;
        background-image: linear-gradient(to bottom, rgba(4, 8, 15, 0.9), rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9));
        color: #fff;
        visibility: hidden;
        opacity: 0;
        width: 300px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;

        /* transition effect. not necessary */
        transition: opacity .2s, visibility .2s;
    }

    .img__wrap:hover .img__description_layer {
        visibility: visible;
        opacity: 1;
    }

    .img__description {
        transition: .2s;
        transform: translateY(1em);
    }

    .img__wrap:hover .img__description {
        transform: translateY(0);
    }

    input[type=radio] {
        width: 18px;
        height: 18px;
        margin-right: 5px;
    }

    .swal2-container.swal2-center>.swal2-popup {
        background: linear-gradient(180deg, #C4C4C4 50%, rgba(196, 196, 196, 0) 100%);

    }

    .swal2-html-container {
        color: #fff !important;
    }

       /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
      content: none; 
    } 

    ol.breadcrumb {
        color: white;
        background-color: transparent !important  ;
        font-size: revert;
    }

    #videoPlayer {
        width: 100%;
        height: 100%;
        /* margin: 0 auto !important;  */
        object-fit: contain;
    }

    #video {
        width: 100%;
        height: 100%;
        /* margin: 0 auto !important;  */
        object-fit: contain;
    }

</style>

<?php if (Session::has('message')): ?>
    <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;" ><?php  echo Session::get('message') ?></div>
<?php endif ;?>

<?php

$package = App\User::where('id',1)->first();
$pack = $package->package;

                                // Auth Users 

if(empty($new_date) || Auth::user()->role == 'admin'){

    if(!Auth::guest()) {

        if( !empty($ppv_video_play) || $video_access == 'free' || Auth::user()->role == 'registered' || 
            $video->global_ppv == null && $video->access == 'subscriber' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'registered' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'subscriber' && Auth::user()->role == 'subscriber' || $video->access == 'ppv' && Auth::user()->role == 'admin' || $video->access == 'subscriber' && Auth::user()->role == 'admin' || $video->access == 'registered' && Auth::user()->role == 'admin'|| $video->access == 'registered' && Auth::user()->role == 'subscriber'
            || $video->access == 'registered' && Auth::user()->role == 'registered' || Auth::user()->role == 'admin'){

                if ( $ppv_exist > 0 || $video_access == 'free' || Auth::user()->subscribed() && $video->type != "" || 
                Auth::user()->role == 'admin' && $video->type != "" || Auth::user()->role =="subscriber" && $video->type != ""
                || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $video->type != "")) { ?>

                    <div id="video_bg">
                        <div class="col-sm-12 intro_skips">
                            <input type="button" class="skips" value="Skip Intro" id="intro_skip">
                            <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
                        </div>

                        <div class="col-md-7 end_card_video" id="end_card_video" style="position: absolute; top: 15%; width: 300%; height: 300%;z-index:1;">
                            <div class="col-md-12">
                                <?php foreach($endcardvideo as $val) { ?>
                                    <a href="<?php echo URL::to('category'); ?><?= '/videos/' . $val->slug ?>">
                                        <img id="endcard" src="<?php echo URL::to('/') . '/public/uploads/images/' . $val->image; ?>" alt="">
                                    </a>
                                <?php  } ?>
                            </div>
                            <div class="col-md-6"></div>
                        </div>

                    <div class=" page-height">
                        <?php $paypal_id = Auth::user()->paypal_id;

                        $paypal_subscription = !empty($paypal_id) && !empty(PaypalSubscriptionStatus() ) ? PaypalSubscriptionStatus() : " ";

                        if($ppv_exist > 0  || $video_access == 'free' || Auth::user()->subscribed() || $paypal_subscription =='CANCE' || $video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() ) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
                            
                            <?php if($video->type == 'embed'): ?>
                                <div id="video_container" class="fitvid">
                                    <?php if(!empty($video->embed_code)){?>
                                        <div class="plyr__video-embed" id="player">
                                            <iframe src="<?php if (!empty($video->embed_code)) {
                                                echo $video->embed_code;
                                            } else {
                                                echo $video->trailer;
                                            } ?>" allowfullscreen allowtransparency allow="<?= $autoplay ?>"></iframe>
                                        </div>
                                    <?php } ?>
                                </div>

                            <?php  elseif($video->type == ''):  ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">

                                    <video <?= $autoplay ?> id="video" allow="autoplay" class="adstime_url"
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                        <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '.m3u8'; ?>" type='application/x-mpegURL' label='auto'>
                                        <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                                foreach ($subtitles as $key => $subtitles_file) { ?>
                                            <track kind="captions" src="<?= $subtitles_file->url ?>"
                                                srclang="<?= $subtitles_file->sub_language ?>"
                                                label="<?= $subtitles_file->shortcode ?>" default>
                                            <?php } } } ?>
                                    </video>

                                    <div class="playertextbox hide">
                                        <!--<h2>Up Next</h2>-->
                                        <p><?php if(isset($videonext)){ ?>
                                            <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                            <?php }elseif(isset($videoprev)){ ?>
                                            <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                            <?php } ?>

                                            <?php if(isset($videos_category_next)){ ?>
                                            <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                            <?php }elseif(isset($videos_category_prev)){ ?>
                                            <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                            <?php } ?></p>
                                    </div>

                                    <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '.m3u8'; ?>">
                                </div>
                                </div>

                            <?php  elseif($video->type == 'aws_m3u8'):  ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">

                                    <video <?= $autoplay ?> id="video" allow="<?= $autoplay ?>" class="adstime_url"
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                        <source src="<?php echo $video->m3u8_url; ?>" type='application/x-mpegURL' label='auto'>
                                        <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                        foreach ($subtitles as $key => $subtitles_file) { ?>
                                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                                        srclang="<?= $subtitles_file->sub_language ?>"
                                        label="<?= $subtitles_file->shortcode ?>" default>
                                    <?php } } } ?>
                                    </video>
                                </div>

                            <?php  elseif($video->type == 'mp4_url'):  ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                    <video id="videoPlayer" <?= $autoplay ?> class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                    
                                        <source src="<?php if (!empty($video->mp4_url)) { echo $video->mp4_url; } else { echo $video->trailer; } ?>" type='video/mp4' label='auto'>
                                    
                                        <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                                foreach ($subtitles as $key => $subtitles_file) { ?>
                                                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                                                        srclang="<?= $subtitles_file->sub_language ?>"
                                                            label="<?= $subtitles_file->shortcode ?>" default>
                                        <?php } } } ?>
                                    </video>

                                    <div class="playertextbox hide">
                                        <p>
                                            <?php if(isset($videonext)){ ?>
                                                <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                            <?php }elseif(isset($videoprev)){ ?>
                                            <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                                <?php } ?>

                                            <?php if(isset($videos_category_next)){ ?>
                                                <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                            <?php }elseif(isset($videos_category_prev)){ ?>
                                                <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>

                            <?php  elseif($video->type == 'm3u8_url'):  ?>

                                <video <?= $autoplay ?> id="video" allow="<?= $autoplay ?>" class="adstime_url"
                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                    <source src="<?php if (!empty($video->m3u8_url)) {
                                        echo $video->m3u8_url;
                                    } else {
                                        echo $video->trailer;
                                    } ?>" type='application/x-mpegURL' label='auto'>
                                    <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                        foreach ($subtitles as $key => $subtitles_file) { ?>
                                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                                        srclang="<?= $subtitles_file->sub_language ?>"
                                        label="<?= $subtitles_file->shortcode ?>" default>
                                    <?php } } } ?>
                                </video>
                            <?php  else: ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                    <video id="videoPlayer" class="adstime_url"
                                            poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                                            data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                            <!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                                            <source src="<?php if (!empty($video->m3u8_url)) {
                                                echo $video->m3u8_url;
                                            } else {
                                                echo $video->trailer;
                                            } ?>" type='application/x-mpegURL' label='auto'>

                                        <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                            foreach ($subtitles as $key => $subtitles_file) { ?>
                                        <track kind="captions" src="<?= $subtitles_file->url ?>"
                                            srclang="<?= $subtitles_file->sub_language ?>"
                                            label="<?= $subtitles_file->shortcode ?>" default>
                                        <?php } } } ?>
                                    </video>

                                    <div class="playertextbox hide">
                                        <!--<h2>Up Next</h2>-->
                                        <p><?php if(isset($videonext)){ ?>
                                            <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                            <?php }elseif(isset($videoprev)){ ?>
                                            <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                            <?php } ?>

                                            <?php if(isset($videos_category_next)){ ?>
                                            <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                            <?php }elseif(isset($videos_category_prev)){ ?>
                                            <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                            <?php } ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>

                            <div id="subscribers_only">
                                <div class="container-fluid">

                                <h2 class="text-left"><?php echo $video->title; ?></h2>

                                <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo $video->description; ?></p>

                                <h4>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h4>
                                <div class="clear"></div>

                                    <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>

                                        <form method="get" action="<?= URL::to('/') ?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
                                            <button id="button">Become a subscriber to watch this video</button>
                                        </form>

                                    <?php else: ?>

                                        <form method="get" action="<?= URL::to('signup') ?>">
                                            <button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for
                                                Free!<?php endif; ?></button>
                                        </form>

                                    <?php endif; ?>

                                <?php if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                                    <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"
                                        class="view-count rent-video btn btn-primary">
                                        <?php echo __('Purchase Now'); ?> </button>
                                    <?php } ?>
                            </div></div>

                        <?php endif; ?>
                    </div>


                <?php } elseif( $ppv_exist > 0 || $video_access == 'free' || Auth::user()->subscribed() && $pack == "Business" || Auth::user()->role == 'admin' && $pack == "Business" || Auth::user()->role =="subscriber" && $pack == "Business"
                        || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $pack == "Business")) {

                    if(!empty($video->path)){ ?>

                        <div id="video_container" class="fitvid" style="z-index: 9999;">
                            <video id="video" class="adstime_url" controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>

                                <source type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '.m3u8'; ?>">
                            
                                <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                <track kind="captions" src="<?= $subtitles_file->url ?>"
                                    srclang="<?= $subtitles_file->sub_language ?>"
                                    label="<?= $subtitles_file->shortcode ?>" default>
                                <?php } } } ?>

                            </video>
                        </div>

                        <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '.m3u8'; ?>">
                    <?php } 

                } elseif ( ( $ppv_exist == 0 &&  ($video->access = "subscriber" &&  Auth::user()->role == "registered"  ) ||  $video->access = "ppv"  ) && $video->free_duration_status == 1 && $video->free_duration != null ) {   ?>       

                    <?php  include('Free_duration_video_player.php'); ?>  

                    <?php if(  $video->type == 'embed'): ?>
              
                        <div id="subscribers_only" style="background: linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;padding-top:150px;">
                            <div class="container-fluid">
                                <h2 class="text-left"><?php echo $video->title; ?></h2>

                                <div class="text-white col-lg-7 p-0">
                                <p style="margin:0 auto;"> <?php echo $video->description; ?></p>
                                </div>

                                <h4 class="mb-3">Sorry, this video is only available to  Subscribers / PPV Rent </h4>
                                
                                <div>
                                <a href="<?= URL::to('/signup') ?>" class="btn btn-primary" >Become a Subscribers to watch this vide</a> 
                                </div>
                            </div>
                        </div>
              
                    <?php  elseif( $video->type == '' && ($video->processed_low != 100 || $video->processed_low == null) ):  ?>
              
                       <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                          <video id=""  class="adstime_url"  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                             <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
                             
                             <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                             
                             <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
                                <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
                             <?php } if($value->sub_language == "German"){?>
                                <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
                             <?php } if($value->sub_language == "Spanish"){ ?>
                                <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
                             <?php } if($value->sub_language == "Hindi"){ ?>
                                <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
                             <?php }
                                } } else {  } ?>
              
                          </video>
                       </div>
              
                    <?php  elseif( $video->type == '' && ($video->processed_low == 100 || $video->processed_low != null)): ?>
              
                       <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                          
                          <video id="PPV_free_duration_videoPlayer" controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                             <source  type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
                             <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
                                <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                             <?php } if($value['sub_language'] == "German"){ ?>
                                <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                             <?php } if($value['sub_language'] == "Spanish"){ ?>
                                <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                             <?php } if($value['sub_language'] == "Hindi"){ ?>
                                <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                             <?php } } } else { }  ?>  
                          </video>
                       </div>
              
                    <?php  elseif(   $video->type == 'mp4_url'): ?>
              
                       <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                          <video id="PPV_free_duration_videoPlayer_MP4" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                             <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
                             <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                                <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
                                   <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
                                <?php } if($value->sub_language == "German"){?>
                                   <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
                                <?php } if($value->sub_language == "Spanish"){ ?>
                                   <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
                                <?php } if($value->sub_language == "Hindi"){ ?>
                                   <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
                                <?php }
                                } } else {  } ?>  
                          </video>
                       </div>
              
                    <?php  elseif($video->type == 'm3u8_url'):  ?>
              
                       <video  id="PPV_free_duration_videoPlayer_M3U8_url"  allow="<?= $autoplay ?>"  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                          <source src="<?php if(!empty($video->m3u8_url)){ echo $video->m3u8_url; }else { echo $video->trailer;} ?>"  type='application/x-mpegURL' label='auto' >
                          <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
                          <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                          <?php } if($value['sub_language'] == "German"){?>
                          <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                          <?php } if($value['sub_language'] == "Spanish"){ ?>
                          <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                          <?php } if($value['sub_language'] == "Hindi"){ ?>
                          <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                          <?php }
                             } } else {  } ?>  
                       </video>
                    <?php endif; 
                }else {  ?>

                <div id="subscribers_only"style="background: linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)),url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-position:center; background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;">
                    <div id="subscribers_only">
                        <div class="clear"></div>
                        <div class="container-fluid">

                            <div style="padding-top:8%;">
                                <h4 class=""><?php echo $video->title; ?></h4>
                                <div class="text-white col-lg-7 p-0">
                                    <p class=" " style="margin:0 auto";><?php echo $video->description; ?></p>
                                </div>

                                <h4>
                                    Sorry, this video is only available to Subscribers or PPV users
                                    <?php if($video->access == 'subscriber'): ?><?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?>
                                </h4>

                                <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'guest' && !empty($video->ppv_price) ){ ?>
                                    
                                    <div class="d-flex align-items-baseline">
                                        <form class="text-center" method="get" action="<?= route('payment_becomeSubscriber') ?>">
                                            <button style="margin-top: 0%;" class="btn btn-primary"id="button"> subscribe to watch this video</button>
                                        </form>

                                <?php }elseif(Auth::guest()){ ?>

                                    <form method="get" action="<?= URL::to('signup') ?>">
                                        <button id="button" style="margin-top: 0%;">Signup Now <?php if($video->access == 'subscriber'): ?>to Purchase this video
                                            <?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
                                    </form>

                                <?php } ?>

                                <?php if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                                    <button style="margin-left:1%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                                        <?php echo __('Purchase Now'); ?> 
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <?php }
        
        } else { ?>

            <?php if($video->access == 'subscriber' && Auth::user()->role == 'registered'){  ?>
                <div  id="subscribers_only"style="background:  linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;">
                <div id="subscribers_only">
                    <div class="clear"></div>
                    <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
                        <h4 class="text-center"><?php echo $video->title; ?></h4>
                        <p class="text-center text-white col-lg-8" style="";><?php echo $video->description; ?></p>

                        <h6>
                            <p style="margin-left:14%">Sorry, this video is only available to</p>
                            <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?>
                        </h6>
                        
                        <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'guest' && !empty($video->ppv_price) ){ ?>
                            <form method="get" action="<?= route('payment_becomeSubscriber') ?>">
                                <button style="margin-left: 27%;margin-top: 0%;" class="btn btn-primary"id="button">Purchase to
                                    watch this video</button>
                            </form>

                        <?php }elseif(Auth::guest()){ ?>
                            <form method="get" action="<?= URL::to('signup') ?>">
                                <button id="button" style="margin-top: 0%;">
                                    Signup Now <?php if($video->access == 'subscriber'): ?>to Purchase this video
                                    <?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?>
                                </button>
                            </form>
                        <?php } ?>

                        <?php if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                            <button style="margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"bclass="view-count rent-video btn btn-primary">
                                <?php echo __('Purchase Now'); ?>
                            </button>
                        <?php }  ?>

            <?php } else if($video->access == 'subscriber' && $video->global_ppv == 1 && Auth::user()->role == 'subscriber'){   ?>
                
                    <div id="subscribers_only"style="background:  linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;">
                    <div id="subscribers_only">
                        <div class="clear"></div>
                        <div style="margin-left: -20%;position: absolute;top: 20%;left: 20%;width: 100%;">
                            <h4 class="text-center"><?php echo $video->title; ?></h4>
                            <p class="text-center text-white col-lg-8" style="";><?php echo $video->description; ?></p>
                            <h2>
                                <p style="margin-left:14%">Purchase to watch this PPV video</p>
                            </h2>
                            <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'ppv'|| !Auth::guest() && $video->access == 'guest' && !empty($video->ppv_price) ){ ?>
                                
                                <form method="get" action="<?= route('payment_becomeSubscriber') ?>">
                                    <button style="margin-left: 27%;margin-top: 0%;"
                                        class="btn btn-primary"id="button">Purchase to watch this video
                                    </button>
                                </form>

                                <button style="margin-left: 46%;margin-top: 0%;" data-toggle="modal"
                                    data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                                    <?php echo __('Purchase Now'); ?> 
                                </button>

                            <?php }else{ ?>

                                <form method="get" action="<?= URL::to('signup') ?>">
                                    <button id="button" style="margin-top: 0%;">Signup Now <?php if($video->access == 'subscriber'): ?>to Purchase
                                        this video <?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?>
                                    </button>
                                </form>
                                
                            <?php } 

                        } elseif ( ( ($video->access = "subscriber" &&  Auth::user()->role == "registered"  ) ||  $video->access = "ppv"  ) && $video->free_duration_status == 1 && $video->free_duration != null ) {  ?>       

                            <?php  include('Free_duration_video_player.php'); ?>  

                            <?php if(  $video->type == 'embed'): ?>

                                <div id="subscribers_only" style="background: linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;padding-top:150px;">
                                    <div class="container-fluid">
                                        <h2 class="text-left"><?php echo $video->title; ?></h2>

                                        <div class="text-white col-lg-7 p-0">
                                        <p style="margin:0 auto;"> <?php echo $video->description; ?></p>
                                        </div>

                                        <h4 class="mb-3"> / PPV Rent </h4>
                                        
                                        <div>
                                        <a href="<?= URL::to('/signup') ?>" class="btn btn-primary" >Become a Subscribers to watch this vide</a> 
                                        </div>
                                    </div>
                                </div>

                            <?php  elseif( $video->type == '' && ($video->processed_low != 100 || $video->processed_low == null) ):  ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                    <video id="" <?= $autoplay ?>  class="adstime_url"  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                                        <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
                                        
                                        <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                                        
                                        <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
                                        <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "German"){?>
                                        <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "Spanish"){ ?>
                                        <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "Hindi"){ ?>
                                        <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
                                        <?php }
                                        } } else {  } ?>

                                    </video>
                                </div>

                            <?php  elseif( $video->type == '' && ($video->processed_low == 100 || $video->processed_low != null)): ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                    
                                    <video id="PPV_free_duration_videoPlayer" <?= $autoplay ?>   controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                                        <source  type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
                                        <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
                                        <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                                        <?php } if($value['sub_language'] == "German"){ ?>
                                        <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                                        <?php } if($value['sub_language'] == "Spanish"){ ?>
                                        <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                                        <?php } if($value['sub_language'] == "Hindi"){ ?>
                                        <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                                        <?php } } } else { }  ?>  
                                    </video>
                                </div>

                            <?php  elseif(   $video->type == 'mp4_url'): ?>

                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                    <video id="PPV_free_duration_videoPlayer_MP4"  <?= $autoplay ?>    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                                        <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
                                        <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                                        <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
                                            <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "German"){?>
                                            <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "Spanish"){ ?>
                                            <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
                                        <?php } if($value->sub_language == "Hindi"){ ?>
                                            <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
                                        <?php }
                                        } } else {  } ?>  
                                    </video>
                                </div>

                            <?php  elseif($video->type == 'm3u8_url'):  ?>

                                <video  <?= $autoplay ?> id="PPV_free_duration_videoPlayer_M3U8_url"  allow="<?= $autoplay ?>"  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                                    <source src="<?php if(!empty($video->m3u8_url)){ echo $video->m3u8_url; }else { echo $video->trailer;} ?>"  type='application/x-mpegURL' label='auto' >
                                    <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
                                    <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                                    <?php } if($value['sub_language'] == "German"){?>
                                    <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                                    <?php } if($value['sub_language'] == "Spanish"){ ?>
                                    <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                                    <?php } if($value['sub_language'] == "Hindi"){ ?>
                                    <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                                    <?php }
                                        } } else {  } ?>  
                                </video>
                            <?php endif; 
                    } else {  ?>


                    <div id="subscribers_only"style="background:  linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;">
                        <div id="subscribers_only">
                            <div class="clear"></div>
                            <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
                                <h4 class="text-center"><?php echo $video->title; ?></h4>
                                <p class="text-center text-white col-lg-8" style="margin:0 auto";>
                                    <?php echo $video->description; ?>
                                </p>

                                <h2>
                                    <p style="margin-left:14%">Sorry, this video is only available to</p>
                                    <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered
                                    Users<?php endif; ?>
                                </h2>

                                <?php if(!Auth::guest() && $video->access == 'subscriber'  ){ ?>
                                    <form method="get" action="<?= route('payment_becomeSubscriber') ?>">
                                        <button style="margin-left: 27%;margin-top: 0%;"
                                            class="btn btn-primary"id="button">Purchase to watch this
                                            video</button>
                                    </form>

                                <?php }elseif(Auth::guest()){ ?>
                                    <form method="get" action="<?= URL::to('signup') ?>">
                                        <button id="button" style="margin-top: 0%;">Signup Now
                                            <?php if($video->access == 'subscriber'): ?>to Purchase this video <?php elseif($video->access == 'registered'): ?>for
                                            Free!<?php endif; ?></button>
                                    </form>
                                <?php }

                                if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                                    <button style="margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                                        <?php echo __('Purchase Now'); ?> 
                                    </button>
                                <?php } 
            } ?>
                                    </div>
                                </div>
                            </div>
        <?php }
    }

    elseif($video->access == 'subscriber' && Auth::user()->role == 'registered' || $video->access == 'ppv' && Auth::user()->role == 'registered'){  ?>
            <div id="subscribers_only"style="background:  linear-gradient(rgba(0,0,0, 0),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 500px; margin-top: 20px;">
                <div id="subscribers_only">
                    <h4 class="text-center"><?php echo $video->title; ?></h4>

                    <p class="text-center text-white col-lg-8" style="margin:0 auto";>
                        <?php echo $video->description; ?>
                    </p>

                    <h2 style="margin-left:14%">Sorry, this video is only available to
                        <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered
                        Users<?php endif; ?>
                    </h2>

                    <div class="clear"></div>
                    <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
                        <form method="get" action="<?= route('payment_becomeSubscriber') ?>">
                            <button style="margin-left: 27%;" id="button">Become a subscriber to watch this
                                video</button>
                        </form>
                    <?php else: ?>
                    
                        <form method="get" action="<?= URL::to('signup') ?>">
                            <button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a
                                Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
                        </form>
                    <?php endif; ?>

                    <?php if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                        <button style="margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                            <?php echo __('Purchase Now'); ?>
                            </button>
                    <?php } ?>
                </div>
    <?php }

}elseif(!empty($new_date)){ ?>
        <div id="subscribers_only"style="background: linear-gradient(rgba(0,0,0, 0.5),rgba(0,0,0, 100)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 550px; margin-top: 20px;padding-top:100px;">
            
            <h2> COMING SOON </h2>

                <?php if(!empty($video->description) && $settings->show_description == 1 ) : ?>
                    <div class="text-white col-lg-7 text-center" style="margin:0 auto;">
                        <p class="  mt-2 "><?php echo __($video->description); ?> </p>
                    </div>
                <?php endif; ?><hr>

            <p class="countdown mb-0" id="demo"></p><hr>
        </div>
<?php } ?>

                            <!-- For Guest users -->
<?php if(Auth::guest()) {  ?>

        <div id="video" class="adstime_url" class="fitvid" style="margin: 0 auto;">
            <video id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>" type="video/mp4">
                <source src="<?= $video->trailer ?>" type='video/mp4' label='Auto' res='auto' />
                    <?php if(@$playerui_settings['subtitle'] == 1 ){ 
                                if(isset($subtitles)){
                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                        <track kind="captions" src="<?= $subtitles_file->url ?>"
                                            srclang="<?= $subtitles_file->sub_language ?>"
                                            label="<?= $subtitles_file->shortcode ?>" default>
                                    <?php } 
                                } 
                            } 
                    ?>
            </video>
        </div>
        </div>
        </div>

<?php }elseif(Auth::guest() && empty($video->ppv_price)){ ?>

        <div id="video_bg">
            <div class=" page-height">
                <?php  if( Auth::guest() ): ?>

                    <?php if($video->type == 'embed'): ?>

                        <div id="video_container" class="fitvid">
                            <?php
                                if (!empty($video->embed_code)) {
                                    echo $video->embed_code;
                                } else {
                                    echo $video->trailer;
                                } 
                            ?>
                        </div>

                    <?php elseif($video->type == 'file'): ?>

                        <div id="video sda" class="fitvid" style="margin: 0 auto;">

                            <video id="videoPlayer" <?= $autoplay ?> class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '.m3u8'; ?>" type="application/x-mpegURL">
                                <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_1_500.m3u8'; ?>" type='application/x-mpegURL' label='360p' res='360' />
                                <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480' />
                                <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720' />

                                    <?php  if(@$playerui_settings['subtitle'] == 1 ){ 
                                                if(isset($subtitles)){
                                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                                        <track kind="captions" src="<?= $subtitles_file->url ?>"
                                                        srclang="<?= $subtitles_file->sub_language ?>"
                                                        label="<?= $subtitles_file->shortcode ?>" default>
                                                    <?php }
                                                } 
                                            } ?>
                            </video>

                            <div class="playertextbox hide">
                                <p>
                                    <?php if(isset($videonext)){ ?>

                                        <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                    <?php }elseif(isset($videoprev)){ ?>

                                        <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                    <?php } ?>

                                    <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                    <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>

                    <?php elseif($video->type == 'aws_m3u8'):  ?>

                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                            <video <?= $autoplay ?> id="video" allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                                <source src="<?php echo $video->m3u8_url; ?>" type='application/x-mpegURL' label='auto'>
                                    
                                    <?php  if(@$playerui_settings['subtitle'] == 1 ){ 
                                                if(isset($subtitles)){
                                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                                        <track kind="captions" src="<?= $subtitles_file->url ?>"
                                                            srclang="<?= $subtitles_file->sub_language ?>"
                                                            label="<?= $subtitles_file->shortcode ?>" default>
                                                    <?php } 
                                                } 
                                            } ?>
                            </video>
                        </div>

                    <?php elseif($video->type == 'mp4_url'):   ?>

                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">

                            <video id="videoPlayer" <?= $autoplay ?> class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                            
                            <source src="<?php 
                                    if (!empty($video->mp4_url)) {
                                        echo $video->mp4_url;
                                    } else {
                                        echo $video->trailer;
                                    } ?>" 
                                type='video/mp4' label='auto'>

                                <?php  if(@$playerui_settings['subtitle'] == 1 ){
                                            if(isset($subtitles)){
                                                foreach ($subtitles as $key => $subtitles_file) { ?>
                                                        <track kind="captions" src="<?= $subtitles_file->url ?>"
                                                        srclang="<?= $subtitles_file->sub_language ?>"
                                                        label="<?= $subtitles_file->shortcode ?>" default>
                                                <?php } 
                                            } 
                                        } ?>

                            </video>

                            <div class="playertextbox hide">
                            
                                <p>
                                    <?php if(isset($videonext)){ ?>
                                        <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                    <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                    <?php } ?>

                                    <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                    <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>

                    <?php elseif($video->type == 'm3u8_url'):  ?>

                        <video <?= $autoplay ?> id="video" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="video/mp4">
                            
                            <source src="<?php
                                if (!empty($video->m3u8_url)) {
                                    echo $video->m3u8_url;
                                } else {
                                    echo $video->trailer;
                                } ?>" type='application/x-mpegURL' label='auto'>

                                <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                <track kind="captions" src="<?= $subtitles_file->url ?>"
                                    srclang="<?= $subtitles_file->sub_language ?>"
                                    label="<?= $subtitles_file->shortcode ?>" default>
                                <?php } } } ?>
                        </video>

                    <?php else: ?>

                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">

                            <video <?= $autoplay ?> id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                src="<?php echo $video->trailer; ?>" type="video/mp4">

                                <source src="<?php if ($video->type == 'm3u8_url') {
                                    echo $video->m3u8_url;
                                } else {
                                    echo $video->trailer;
                                } ?>" type="application/x-mpegURL" label='auto'>

                                <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($subtitles)){
                                    foreach ($subtitles as $key => $subtitles_file) { ?>
                                <track kind="captions" src="<?= $subtitles_file->url ?>"
                                    srclang="<?= $subtitles_file->sub_language ?>"
                                    label="<?= $subtitles_file->shortcode ?>" default>
                                <?php } } } ?>
                            </video>

                            <div class="playertextbox hide">
                                <p><?php if(isset($videonext)){ ?>
                                    <?= Video::where('id', '=', $videonext->id)->pluck('title') ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                    <?= Video::where('id', '=', $videoprev->id)->pluck('title') ?>
                                    <?php } ?>

                                    <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                                    <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                
                <?php else: ?>

                    <div id="subscribers_only">
                        <h4 class="text-center"><?php echo $video->title; ?></h4>

                        <p class="text-center text-white col-lg-8" style="margin:0 auto";>
                            <?php echo $video->description; ?>
                        </p>

                        <h2>Sorry, this video is only available to
                            <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered' ): ?>Registered
                            Users<?php elseif($video->access == 'ppv' ): ?>PPV<?php endif; ?>
                        </h2>

                        <div class="clear"></div>
                            <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
                                <form method="get"
                                    action="<?= URL::to('/') ?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
                                    <button id="button">Become a subscriber to watch this video</button>
                                </form>
                            <?php else: ?>
                                <form method="get" action="<?= URL::to('signup') ?>">
                                </form>
                            <?php endif; ?>

                            <?php if(!Auth::guest() && $video->ppv_price != '' && $video->ppv_price != null || $video->global_ppv == 1 ){ ?>
                                <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal"
                                    data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary">
                                    <?php echo __('Purchase Now'); ?> 
                                </button>
                            <?php } ?>
                    </div>
                <?php endif; ?>
            </div>
<?php }  ?>

<!-- Video Player Condition End -->

                        <!-- logo In player -->

                        <div class="logo_player"> </div>

                        <!-- url link -->

                        <?php if(!empty($video->url_link) ) { ?>
                        <div class="text-white" id="url_linkdetails">
                            <p class="trending-dec w-100 mb-0 text-white"><a href="<?php echo __($video->url_link); ?>"
                                    target="_blank" data-toggle="tooltip" data-placement="left"
                                    title=<?php echo __($video->url_link); ?> class="fa fa-info-circle">
                                </a></p>
                        </div>
                        <?php  }?>


                        <!-- Trailer  -->
                        <div class=" page-height">
                            <div id="watch_trailer" class="fitvid" atyle="z-index: 9999;">

                                <?php  if($video->trailer_type !=null && $video->trailer_type == "video_mp4" || $video->trailer_type == "mp4_url" ){ ?>

                                <video class="videoPlayers" controls
                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                    type="video/mp4" src="<?php echo $video->trailer; ?>">
                                </video>
                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8" ){ ?>

                                <video class="videoPlayers" controls
                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                    type="application/x-mpegURL">
                                </video>


                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8_url" ){ ?>

                                <video class="videoPlayers" controls
                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                    type="application/x-mpegURL">
                                </video>

                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "embed_url" ){ ?>

                                <div class="videoPlayers" id="">
                                    <iframe src="<?php echo $video->trailer; ?>" allowfullscreen allowtransparency
                                        allow="<?= $autoplay ?>">
                                    </iframe>
                                </div>

                                <?php  } ?>
                            </div>



                            <input type="hidden" class="videocategoryid"
                                data-videocategoryid="<?= $video->video_category_id ?>"
                                value="<?= $video->video_category_id ?>">
                            <div class="container-fluid video-details">

                                                      <!-- BREADCRUMBS -->
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bc-icons-2">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a class="black-text" href="<?= route('latest-videos') ?>"><?= ucwords('videos') ?></a>
                                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                                    </li>

                                                    <?php foreach ($category_name as $key => $video_category_name) { ?>
                                                    <?php $category_name_length = count($category_name); ?>
                                                    <li class="breadcrumb-item">
                                                        <a class="black-text" href="<?= route('video_categories',[ $video_category_name->categories_slug ])?>">
                                                            <?= ucwords($video_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?> 
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                                                    <li class="breadcrumb-item"><a class="black-text"><?php echo (strlen($video->title) > 50) ? ucwords(substr($video->title,0,120).'...') : ucwords($video->title); ?> </a></li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="trending-info g-border p-0">
                                    <div class="row align-items-center">
                                        <div class="col-sm-8 col-md-8 col-xs-12">

                                            <!--  Video thumbnail image-->
                                            <?php if( $video->enable_video_title_image == 1  &&  $video->video_title_image != null){ ?>
                                            <div class="d-flex col-md-6">
                                                <img src="<?= URL::to('public/uploads/images/' . $video->video_title_image) ?>"
                                                    class="c-logo" alt="<?= $video->title ?>">
                                            </div>
                                            <!-- Video Title  -->
                                            <?php }else{ ?>
                                            <h1 class="text-white mb-3">
                                                <?php echo strlen($video->title) > 15 ? substr($video->title, 0, 200) : $video->title;
                                                if (Auth::guest()) {
                                                } ?>
                                            </h1>
                                            <?php } ?>

                                            <!-- Category -->
                                            <ul class="p-0 list-inline d-flex align-items-center movie-content">
                                                <li class="text-white">
                                                    <?//= $videocategory ;?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-2">
                                            <div class=" views text-white text-right" style="font-size:14px;">
                                                <!-- <span class="view-count"><i class="fa fa-eye"></i>  -->
                                                <!-- <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views'); ?>  -->
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <!-- <div id="video_containers plyr__video" class="fitvid mfp-hide" atyle="z-index: 9999;"> -->
                                            <!-- <div id="video-trailer" class="mfp-hide"> -->
                                            <!-- <video id="videoPlayer"  poster="<?php echo URL::to('/') . '/public/uploads/images/' . $video->image; ?>"  class="" controls src="<?= $video->trailer ?>"  type="application/x-mpegURL" ></video>
               </div>
               <div class="trailor-video">
                        <a href="#video_containers"
                            class="video-open playbtn">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                            viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                            stroke-linejoin="round" stroke-miterlimit="10"
                            points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                            stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                        </svg>
                        <span class="w-trailor">Watch Trailer</span>
                    </a>
                    </div> -->
                                            <div class="col-sm-3 col-md-3 col-xs-12">
                                                <div class="pull-left">
                                                    <?php if($video->trailer != '' && $ThumbnailSetting->trailer == 1 ){ ?>
                                                    <!-- <div id="videoplay" class="btn1 btn-outline-danger  watch_trailer"><i class="ri-film-line"></i> Watch Trailer</div>
                           <div id="close_trailer" class="btn btn-danger  close_trailer"><i class="ri-film-line"></i> Close Trailer</div>
                           <div style=" display: none;" class="skiptrailer btn btn-default skip"> Skip</div> -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Year, Running time, Age -->
                                    <?php
                                    if (!empty($video->duration)) {
                                        $seconds = $video->duration;
                                        $H = floor($seconds / 3600);
                                        $i = ($seconds / 60) % 60;
                                        $s = $seconds % 60;
                                        $time = sprintf('%02dh %02dm', $H, $i);
                                    } else {
                                        $time = 'Not Defined';
                                    }
                                    //  dd($time);
                                    ?>
                                    <div class="d-flex align-items-center text-white text-detail">
                                        <?php if(!empty($video->age_restrict)){ ?><span
                                            class="badge  p-3"><?php echo __($video->age_restrict) . ' ' . '+'; ?></span><?php } ?>
                                        <?php if(!empty($time)){ ?><span
                                            class=""><?php echo $time; ?></span><?php } ?>
                                        <?php if(!empty($video->year)){ ?><span
                                            class="trending-year"><?php if ($video->year == 0) {
                                                echo '';
                                            } else {
                                                echo $video->year;
                                            } ?></span><?php } ?>

                                        <?php 
              $numItems = count($category_name);
              $i = 0;
              foreach($category_name as $key => $cat_name){ ?>
                                        <a href="<?php echo URL::to('/category' . '/' . $cat_name->categories_slug); ?>">
                                            <span class="category_name" style="margin-left: 5px;">
                                                <?php echo $cat_name->categories_name;
                                                if (++$i === $numItems) {
                                                    echo '';
                                                } else {
                                                    echo ',';
                                                } ?>
                                            </span>
                                        </a>
                                        <?php } ?>
                                    </div>

                                    <?php if(!Auth::guest()) { ?>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-xs-12">
                                            <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                                <!-- Watchlater -->
                                                <li><span
                                                        class="watchlater <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>"
                                                        data-authenticated="<?= !Auth::guest() ?>"
                                                        data-videoid="<?= $video->id ?>"><i <?php if(isset($watchlatered->id)): ?>
                                                            class="ri-add-circle-fill" <?php else: ?>
                                                            class="ri-add-circle-line"
                                                            <?php endif; ?>></i></span></li>
                                                <!-- Wishlist -->
                                                <li><span
                                                        class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>"
                                                        data-authenticated="<?= !Auth::guest() ?>"
                                                        data-videoid="<?= $video->id ?>"><i <?php if(isset($mywishlisted->id)): ?>
                                                            class="ri-heart-fill" <?php else: ?>
                                                            class="ri-heart-line" <?php endif; ?>></i></span>
                                                </li>
                                                <!-- Social Share, Like Dislike -->
                                                <?php include 'partials/social-share.php'; ?>
                                            </ul>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-xs-12 p-0">
                                            <ul class="list-inline p-0 mt-4 rental-lists ">
                                                <!-- Subscribe -->
                                                <li>
                                                    <?php     
                           $user = Auth::user(); 
                           if (  ($user->role!="subscriber" && $video->access != 'guest' && $user->role!="admin") ) { ?>
                                                    <a href="<?php echo URL::to('/becomesubscriber'); ?>"><span
                                                            class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?>
                                                        </span></a>
                                                    <?php } ?>
                                                </li>
                                                <!-- PPV button -->
                                                <li>
                                                    <?php //if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin" || ($user->role="subscriber" && $video->global_ppv == 1 ))  ) {
                                                    ?>
                                                    <?php if ( $ppv_exist == 0 && $video->global_ppv != null && $user->role!="admin" || $ppv_exist == 0 && $video->ppv_price != null  && $user->role!="admin") { ?>

                                                    <!-- && ($video->global_ppv == 1 ) -->
                                                    <button data-toggle="modal" data-target="#exampleModalCenter"
                                                        class="view-count btn btn-primary rent-video">
                                                        <?php echo __('Purchase Now'); ?> </button>
                                                    <?php } ?>
                                                </li>
                                                <li>
                                                    <!-- <div class=" views text-white " style="font-size:14px;">
                           <span class="view-count"><i class="fa fa-eye"></i>
                               <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views'); ?>
                           </span>
                       </div>-->
                                                </li>
                                            </ul>
                                            <!--
                 <div class="d-flex align-items-center series mb-4">
                    <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                          alt=""></a>
                    <span class="text-gold ml-3">#2 in Series Today</span>
                 </div>
-->

                                        </div>
                                    </div>

                                    <?php } ?>

                                    <?php if(Auth::guest()) { ?>

                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-xs-12">
                                            <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                                <!-- Watchlater -->
                                                <li><span
                                                        class="watchlater <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>"
                                                        data-authenticated="<?= !Auth::guest() ?>"
                                                        data-videoid="<?= $video->id ?>"><i <?php if(isset($watchlatered->id)): ?>
                                                            class="ri-add-circle-fill" <?php else: ?>
                                                            class="ri-add-circle-line"
                                                            <?php endif; ?>></i></span></li>
                                                <!-- Wishlist -->
                                                <li><span
                                                        class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>"
                                                        data-authenticated="<?= !Auth::guest() ?>"
                                                        data-videoid="<?= $video->id ?>"><i <?php if(isset($mywishlisted->id)): ?>
                                                            class="ri-heart-fill" <?php else: ?>
                                                            class="ri-heart-line" <?php endif; ?>></i></span>
                                                </li>
                                                <!-- Social Share, Like Dislike -->
                                                <?php include 'partials/social-share.php'; ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-xs-12">
                                            <!--
                     <div class="d-flex align-items-center series mb-4">
                        <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                              alt=""></a>
                        <span class="text-gold ml-3">#2 in Series Today</span>
                     </div>
   -->
                                            <ul class="list-inline p-0 mt-4 rental-lists">
                                                <!-- Subscribe -->
                                                <li>
                                                    <a href="<?php echo URL::to('/login'); ?>"><span
                                                            class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?>
                                                        </span></a>
                                                </li>
                                                <!-- PPV button -->
                                                <li>
                                                    <a class="view-count btn btn-primary rent-video text-white"
                                                        href="<?php echo URL::to('/login'); ?>">
                                                        <?php echo __('Rent'); ?> </a>
                                                </li>
                                                <li>
                                                    <div class=" views">
                                                        <span class="view-count"><i class="fa fa-eye"></i>
                                                            <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?>
                                                            <?php echo __('Views'); ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php   } ?>


                                    <!-- Intro Skip and Recap Skip -->




                                    <style>
                                        #endcard {
                                            width: 20%;
                                            height: 20%;
                                        }
                                    </style>
                                </div>
                                <div class="col-sm-12 Recap_skip">
                                    <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip"
                                        style="display:none;">
                                </div>

                                <!--End Intro Skip and Recap Skip -->


                                <!-- Trailer  -->

                                <div class="col-sm-9 p-0">
                                    <div>
                                        <?php if($video->trailer != '' && $ThumbnailSetting->trailer == 1 ){ ?>

                                        <div class="img__wrap">
                                            <img class="img__img " src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->player_image; ?>" class="img-fluid"
                                                alt="" height="200" width="300">
                                            <div class="img__description_layer">
                                                <a data-video="<?php echo $video->trailer; ?>" data-toggle="modal"
                                                    data-target="#videoModal" data-backdrop="static"
                                                    data-keyboard="false">
                                                    <p class="img__description">
                                                        <h6 class="text-center"> <?php echo strlen($video->title) > 50 ? substr($video->title, 0, 51) . '...' : $video->title; ?></h6>

                                                        <div class="movie-time  align-items-center my-2">
                                                            <p class="text-center">
                                                                <?php echo strlen($video->trailer_description) > 60 ? substr($video->trailer_description, 0, 61) . '...' : $video->trailer_description; ?>
                                                            </p>
                                                        </div>

                                                        <div class="hover-buttons text-center">
                                                            <a data-video="<?php echo $video->trailer; ?>" data-toggle="modal"
                                                                data-target="#videoModal" data-backdrop="static"
                                                                data-keyboard="false">
                                                                <span class="text-white">
                                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                    Play Now
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php //dd($video->trailer_type);
                                ?>
                                <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: transparent;border:none;">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <div class="modal-body">

                                                <?php  if($video->trailer_type !=null && $video->trailer_type == "video_mp4" || $video->trailer_type == "mp4_url"  ){ ?>

                                                <video id="videoPlayer1" class=""
                                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                                    controls
                                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                                    type="video/mp4" src="<?php echo $video->trailer; ?>">
                                                </video>
                                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8" ){ ?>

                                                <video id="videos" class=""
                                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                                    controls
                                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                                    type="application/x-mpegURL">
                                                    <source type="application/x-mpegURL" src="<?php echo $video->trailer; ?>">
                                                </video>

                                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8_url" ){ ?>

                                                <video id="videoPlayer1" class=""
                                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                                    controls
                                                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                                    type="application/x-mpegURL">
                                                </video>

                                                <?php }elseif($video->trailer_type !=null && $video->trailer_type == "embed_url" ){ ?>

                                                <div id="videoPlayer1" class=""
                                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>">
                                                    <iframe src="<?php echo $video->trailer; ?>" allowfullscreen
                                                        allowtransparency allow="<?= $autoplay ?>">
                                                    </iframe>
                                                </div>

                                                <?php  } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>


                                <!-- Trailer End  -->
                                <div class="">
                                    <div class="col-md-7 p-0" style="margin-top: 2%;">

                                        <?php if(!empty($video->description) && $settings->show_description == 1 ) : ?>
                                          <h4>Description</h4>
                                        <?php endif; ?>

                                        <div class="text-white">

                                                    <!-- Description -->
                                            <?php if(!empty($video->description) && $settings->show_description == 1 ) : ?>
                                              <p class="trending-dec w-100 mb-0 text-white mt-2 text-justify">
                                                <?php echo __($video->description); ?>
                                              </p>
                                            <?php endif; ?>

                                                      <!-- Artists -->
                                            <?php if( $settings->show_artist == 1 ):?>
                                                <?php  if(count($artists) > 0 ) { ?>
                                                  <p class="trending-dec w-100 mb-0 text-white mt-2">Starring :
                                                      <?php  
                                                        $numartists = count($artists);
                                                        $k = 0;

                                                      foreach($artists as $key => $artist){  ?>
                                                          <a href="<?php echo __(URL::to('/artist') . '/' . $artist->artist_slug); ?>">
                                                              <span class="sta">
                                                                  <?php echo $artist->artist_slug;
                                                                  if (++$k === $numartists) {
                                                                      echo '';
                                                                  } else {
                                                                      echo ',';
                                                                  }
                                                                  ?>
                                                              </span>
                                                          </a>
                                                      <?php } ?>
                                                  </p>
                                                <?php } ?>
                                              <?php endif; ?>

                                                        <!-- Genres -->
                                            <?php if( $settings->show_genre == 1 ) : ?>
                                              <p class="trending-dec w-100 mb-0 text-white mt-2">Genres :
                                                  <?php 
                                                      $numItems = count($category_name);
                                                      $i = 0;

                                                  foreach($category_name as $key => $cat_name){ ?>
                                                  <a href="<?php echo URL::to('/category' . '/' . $cat_name->categories_slug); ?>">
                                                      <span class="sta">
                                                          <?php echo $cat_name->categories_name;
                                                          if (++$i === $numItems) {
                                                              echo '';
                                                          } else {
                                                              echo ',';
                                                          } ?>
                                                      </span>
                                                  </a>
                                                  <?php } ?>
                                              </p>
                                            <?php endif; ?>

                                                      <!-- Languages -->
                                            <?php if( $settings->show_languages == 1 ) : ?>
                                              <p class="trending-dec w-100 mb-0 text-white mt-2">This Movie is :
                                                  <?php 
                                                    $numItems = count($Movie_name);
                                                    $i = 0;

                                                    foreach($Movie_name as $key => $Movie){ ?>
                                                      <a href="<?php echo URL::to('/language' . '/' . $Movie->id . '/' . $Movie->movie_name); ?>">
                                                          <span class="sta">
                                                              <?php echo $Movie->movie_name;
                                                              if (++$i === $numItems) {
                                                                  echo '';
                                                              } else {
                                                                  echo ',';
                                                              } ?>
                                                          </span>
                                                      </a>
                                                  <?php } ?>
                                              </p>
                                            <?php endif; ?>

                                                            <!-- subtitles -->
                                            <?php if($settings->show_subtitle == 1 ): ?>
                                              <p class="trending-dec w-100 mb-0 text-white mt-2">Subtitles :
                                                  <?php echo $subtitles_name; ?></p>
                                            <?php endif; ?>
                                         
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <?php if(!empty($video->details) && $settings->show_Links_and_details == 1 ) { ?>

                                    <h4>Links & details</h4>

                                    <div class="col-md-7 text-white p-0" style="font-size:18px;width:80%;">
                                        <?php $details = html_entity_decode($video->details);
                                          $detail = strip_tags($details); ?>
                                        <p class="trending-dec w-100 mb-0  mt-2"><?php echo __($video->details); ?></p>
                                    </div>
                                <?php  }?>

                                <?php if(!empty($video->pdf_files) ) { ?>
                                <h4>E-Paper:</h4>
                                <p class="p1">Download the E-Paper</p>
                                <div class="text-white">
                                    <a href="<?php echo __(URL::to('/') . '/public/uploads/videoPdf/' . $video->pdf_files); ?>" style="font-size:48px; color: #a51212 !important;"
                                        class="fa fa-file-pdf-o video_pdf" width="" height=""
                                        download></a>
                                </div>
                                <?php  }?>


                                <?php if(Auth::guest()){
$artists = [];
}else{

}
 if(count($artists) > 0 ) { ?>
                                <h4>Cast & crew</h4>

                                <div class="row">
                                    <div class="favorites-contens">
                                        <ul class="category-page list-inline row p-0 mb-0 m-3">
                                            <?php foreach($artists as $key => $artist){  ?>
                                            <li class="slide-item ">
                                                <a href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_slug); ?>">
                                                    <div class="block-images position-relative">
                                                        <!-- block-images -->
                                                        <div class="img-box">
                                                            <img src="<?= URL::to('/') . '/public/uploads/artists/' . $artist->image ?>"
                                                                alt="" width="100">
                                                            <div class="p-tag2">
                                                                <p class="trending-dec w-100 mb-0 text-white mt-2">
                                                                    <?php echo $artist->artist_name; ?> </p>
                                                            </div>
                                                        </div>

                                                        <div class="">
                                                            <a href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_slug); ?>"></a>
                                                        </div>
                                                    </div>

                                                </a>
                                            </li>
                                            <?php } }  ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- <div class="text-white">
           <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
       </div> -->
                                <!-- Button trigger modal -->

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
                                                        <img class="img__img w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->image; ?>"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <h4 class=" text-black movie mb-3"><?php echo __($video->title); ?> ,
                                                            <span
                                                                class="trending-year mt-2"><?php if ($video->year == 0) {
                                                                    echo '';
                                                                } else {
                                                                    echo $video->year;
                                                                } ?></span>
                                                        </h4>
                                                        <span
                                                            class="badge badge-secondary   mb-2"><?php echo __($video->age_restrict) . ' ' . '+'; ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2"><?php echo __(isset($video->categories->name)); ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2"><?php echo __(isset($video->languages->name)); ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2 ml-1"><?php echo __($video->duration); ?></span><br>

                                                        <a type="button" class="mb-3 mt-3" data-dismiss="modal"
                                                            style="font-weight:400;">Amount: <span class="pl-2"
                                                                style="font-size:20px;font-weight:700;">
                                                                <?php if($video->access == 'ppv' && $video->ppv_price != null && $CurrencySetting == 1){ echo __(Currency_Convert(@$video->ppv_price)); }else if($video->access == 'ppv' && $video->ppv_price != null && $CurrencySetting == 0){ echo __(@$video->ppv_price) ; } ?></span></a><br>
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
                                                                name="payment_method"
                                                                value="<?= $CinetPay_payment_settings->payment_type ?>"
                                                                data-value="CinetPay">
                                                            <?= $CinetPay_payment_settings->payment_type ?>
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
                                                <div class="Stripe_button">
                                                    <!-- Stripe Button -->
                                                    <!-- Currency_Convert(@$video->ppv_price) -->
                                                    <a onclick="pay(<?php if($video->access == 'ppv' && $video->ppv_price != null && $CurrencySetting == 1){ echo PPV_CurrencyConvert($video->ppv_price); }else if($video->access == 'ppv' && $video->ppv_price != null && $CurrencySetting == 0){ echo __(@$video->ppv_price) ; } ?>)">
                                                        <button type="button"
                                                            class="btn2  btn-outline-primary">Continue</button>
                                                    </a>
                                                </div>

                                                <?php if( $video->ppv_price !=null &&  $video->ppv_price != " "  ){ ?>
                                                <div class="Razorpay_button">
                                                    <!-- Razorpay Button -->
                                                    <button
                                                        onclick="location.href ='<?= URL::to('RazorpayVideoRent/' . $video->id . '/' . $video->ppv_price) ?>' ;"
                                                        id="" class="btn2  btn-outline-primary">
                                                        Continue</button>
                                                </div>
                                                <?php }?>


                                                <?php if( $video->ppv_price !=null &&  $video->ppv_price != " "  ){ ?>
                                                <div class="paystack_button">
                                                    <!-- Paystack Button -->
                                                    <button
                                                        onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => $video->id, 'amount' => $video->ppv_price]) ?>' ;"
                                                        id="" class="btn2  btn-outline-primary">
                                                        Continue</button>
                                                </div>
                                                <?php }?>

                                                <?php if( $video->ppv_price !=null &&  $video->ppv_price != " " || $video->ppv_price !=null  || $video->global_ppv == 1){ ?>
                                                <div class="cinetpay_button">
                                                    <!-- CinetPay Button -->
                                                    <button onclick="cinetpay_checkout()" id=""
                                                        class="btn2  btn-outline-primary">Continue</button>
                                                </div>
                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php if(isset($videonext)){ ?>
                                <div class="next_video" style="display: none;"><?= $videonext->slug ?></div>
                                <div class="next_url" style="display: none;"><?= $url ?></div>
                                <?php }elseif(isset($videoprev)){ ?>
                                <div class="prev_video" style="display: none;"><?= $videoprev->slug ?></div>
                                <div class="next_url" style="display: none;"><?= $url ?></div>
                                <?php } ?>

                                <?php if(isset($videos_category_next)){ ?>
                                <div class="next_cat_video" style="display: none;">
                                    <?= $videos_category_next->slug ?></div>
                                <?php }elseif(isset($videos_category_prev)){ ?>
                                <div class="prev_cat_video" style="display: none;">
                                    <?= $videos_category_prev->slug ?></div>
                                <?php } ?>

                                <div class="clear"></div>
                                <!--
   <div id="tags">Tags:
   <php foreach($video->tags as $key => $tag): ?>
     <span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>
   <php endforeach; ?>
   </div>
-->


                                <?php if(count($Reels_videos) > 0 && $ThumbnailSetting->reels_videos == 1 ){ ?>
                                <div class="video-list you-may-like">
                                    <div class="slider"
                                        data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
                                        <?php include 'partials/home/Reels-video.php'; ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('videos')->first() == 1 ): ?>
                        <div class="row m-0 p-0">
                            <div class=" container-fluid video-list you-may-like overflow-hidden">
                                <h4 class="" style="color:#fffff;"><?php echo __('Comments'); ?></h4>
                                <?php include 'comments/index.blade.php'; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class=" container-fluid video-list you-may-like overflow-hidden">
                            <h4 class="Continue Watching" style="color:#fffff;"><?php echo __('Recomended Videos'); ?></h4>
                            <div class="slider"
                                data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
                                <?php include 'partials/video-loop.php'; ?>
                            </div>
                        </div>


                        <?php  if(Auth::guest()){ ?>
                        <?php }else{ ?>
                        <input type="hidden" id="publishable_key" name="publishable_key"
                            value="<?php echo $publishable_key; ?>">
                        <?php } ?>
                        <?php if(!empty($video->m3u8_url)){ ?>
                        <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->m3u8_url; ?>">
                        <?php } ?>
                        <?php if(!empty($ads_path)){ ?>
                        <input type="hidden" id="ads_path" name="ads_path" value="<?php echo $ads_path; ?>">
                        <?php } ?>


                    </div>

                    <input type="hidden" id="publishable_key" name="publishable_key"
                        value="<?php echo $publishable_key; ?>">

                    <script type="text/javascript">
                        // videojs('videoPlayer').videoJsResolutionSwitcher(); 
                    </script>
                    <script src="https://checkout.stripe.com/checkout.js"></script>
                    <div class="clear"></div>


                    <script>
                        // $('#myVideo2').show();
                        // $(document).ready(function(){
                        // $('#playVid').click(function(){
                        // $('#myVideo1').hide();
                        // $('#myVideo2').show();
                        //   $('#playVid').play(); 
                        //   $('#mysVideo').pause(); 
                        // });
                        // });

                        $(document).ready(function() {

                        })



                        //  })

                        //  $(videoPlayers).on("load",function(){
                        //   // alert(url);
                        //   alert(duration);
                        //             alert(currentTimevideoPlayers);
                        //  })


                        /*Watch trailer*/
                        //  $(".watch_trailer").click(function() {
                        //    var videohtml = '<video id="videoPlayer" controls autoplay><source src="<?php echo $video->trailer; ?>"></video>';
                        //    $("#video_container").empty();
                        //    $(".skip").css('display','inline-block');
                        //    $("#video_container").html(videohtml);
                        //  });


                        var vid = document.getElementById("videoPlayer");
                        $('#watch_trailer').hide();
                        $('#close_trailer').hide();
                        $('.trailer_description').hide();

                        // Play Trailer
                        $('#videoplay').click(function() {
                            // alert('test');
                            $('#video_container').hide();
                            const player = new Plyr('.videoPlayers');
                            $('#watch_trailer').show();
                            $('#videoplay').hide();
                            $('#close_trailer').show();
                            $('.trailer_description').show();

                        });

                        // Close Trailer
                        $('#close_trailer').click(function() {
                            // alert('test');
                            $('#watch_trailer').hide();
                            const player = new Plyr('.videoPlayers');
                            $('#video_container').show();
                            $('#videoplay').show();
                            $('#close_trailer').hide();
                            $('.trailer_description').hide();

                        });


                        /*Skip Video*/
                        //  $(document).on("click",".skip",function() {
                        //    $("#video_container").empty();
                        //    $(".skip").css('display','none');
                        //    $(".page-height").load(location.href + " #video_container");
                        //    setTimeout(function(){ 
                        //    videojs('videoPlayer');
                        //  }, 2000);
                        //  });
                        //     $.ajaxSetup({
                        //         headers: {
                        //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //          }
                        //  });



                        $(window).on("beforeunload", function() {

                            var vid = document.getElementById("videoPlayer");
                            var currentTime = vid.currentTime;
                            var duration = vid.duration;
                            var videotype = '<?= $video->type ?>';

                            var videoid = $('#video_id').val();
                            $.post('<?= URL::to('continue-watching') ?>', {
                                video_id: videoid,
                                duration: duration,
                                currentTime: currentTime,
                                _token: '<?= csrf_token() ?>'
                            }, function(data) {
                                //    toastr.success(data.success);
                            });

                            // localStorage.setItem('your_video_'+video_id, currentTime);
                            return;
                        });


                        $(window).on("beforeunload", function() {

                            var videotype = '<?= $video->type ?>';
                            //   if(){
                            //     var vid = document.getElementById("videoPlayer");

                            //   }else{
                            //  var vid = document.getElementById("video");

                            //   }
                            var vid = document.getElementById("videoPlayer");
                            var currentTime = vid.currentTime;
                            var duration = vid.duration;
                            var bufferedTimeRanges = vid.buffered;
                            var bufferedTimeRangesLength = bufferedTimeRanges.length;
                            var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
                            var videotype = '<?= $video->type ?>';
                            var videoid = $('#video_id').val();
                            $.post('<?= URL::to('player_analytics_create') ?>', {
                                video_id: videoid,
                                duration: duration,
                                currentTime: currentTime,
                                seekableEnd: seekableEnd,
                                bufferedTimeRanges: bufferedTimeRangesLength,
                                _token: '<?= csrf_token() ?>'
                            }, function(data) {});
                            return;
                        });

                        $(vid).click(function() {
                            // alert(url);
                            $.post('<?= URL::to('purchase-videocount') ?>', {
                                    video_id: videoid,
                                    _token: '<?= csrf_token() ?>'
                                },
                                function(data) {
                                    //    toastr.success(data.success);
                                });
                            return;

                        })




                        //  $(window).on("beforeunload", function() { 

                        // var vid = document.getElementById("video");
                        //   var currentTime = vid.currentTime;
                        //   var duration = vid.duration;
                        // var bufferedTimeRanges = vid.buffered;
                        // var bufferedTimeRangesLength = bufferedTimeRanges.length;
                        // var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
                        //   var videotype= '<?= $video->type ?>';
                        //   var videoid = $('#video_id').val();
                        //   $.post('<?= URL::to('player_analytics_store') ?>', { video_id : videoid,duration : duration,currentTime:currentTime,seekableEnd : seekableEnd,bufferedTimeRanges : bufferedTimeRangesLength,_token: '<?= csrf_token() ?>' }, function(data){
                        // });
                        // return;
                        // }); 

                        // });

                        //$(".share a").hide();
                        $(".share").on("mouseover", function() {
                            $(".share a").show();
                        }).on("mouseout", function() {
                            $(".share a").hide();
                        });

                        $(document).ready(function() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        });

                        function pay(amount) {
                            var publishable_key = $('#publishable_key').val();

                            var video_id = $('#video_id').val();

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
                                        url: '<?php echo URL::to('purchase-video'); ?>',
                                        method: 'post',
                                        data: {
                                            "_token": "<?php echo csrf_token(); ?>",
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
                                description: 'Rent a Video',
                                amount: amount * 100
                            });
                        }

                        //watchlater
                        // $('.watchlater').click(function(){
                        //   if($(this).data('authenticated')){
                        //     $.post('<?// URL::to('watchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?// csrf_token(); ?>' }, function(data){});
                        //     $(this).toggleClass('active');
                        //     $(this).html("");
                        //         if($(this).hasClass('active')){
                        //           $(this).html('<i class="ri-add-circle-fill"></i>');
                        //         }else{
                        //           $(this).html('<i class="ri-add-circle-line"></i>');
                        //         }
                        //   } else {
                        //     window.location = '<?= URL::to('login') ?>';
                        //   }
                        // });

                        //My Wishlist
                        $('.mywishlist').click(function() {
                            if ($(this).data('authenticated')) {
                                $.post('<?= URL::to('mywishlist') ?>', {
                                    video_id: $(this).data('videoid'),
                                    _token: '<?= csrf_token() ?>'
                                }, function(data) {});
                                $(this).toggleClass('active');
                                $(this).html("");
                                if ($(this).hasClass('active')) {
                                    $(this).html('<i class="ri-heart-fill"></i>');
                                    $(".add_data_test").empty();
                                    $(".add_data_test").append("<div>Remove from Wishlist</div> ");
                                    $("body").append(
                                        '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>'
                                    );
                                    setTimeout(function() {
                                        $('.add_watch').slideUp('fast');
                                    }, 3000);
                                } else {
                                    $(this).html('<i class="ri-heart-line"></i>');
                                    $(".add_data_test").empty();
                                    //  $(this).html('<i class="ri-heart-line"></i>');
                                    $(".add_data_test").append("<div>Added to  Wishlist</div> ");
                                    $("body").append(
                                        '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>'
                                    );
                                    setTimeout(function() {
                                        $('.remove_watch').slideUp('fast');
                                    }, 3000);

                                }

                            } else {
                                window.location = '<?= URL::to('login') ?>';
                            }
                        });


                        $('.watchlater').click(function() {
                            if ($(this).data('authenticated')) {
                                $.post('<?= URL::to('addwatchlater') ?>', {
                                        video_id: $(this).data('videoid'),
                                        _token: '<?= csrf_token() ?>'
                                    },
                                    function(data) {});
                                $(this).toggleClass('active');
                                $(this).html("");
                                if ($(this).hasClass('active')) {
                                    $(this).html('<i class="ri-add-circle-fill"></i>');
                                    $(".add_data_test").empty();
                                    $(".add_data_test").append("<div>Remove from Watchlater</div> ");
                                    $("body").append(
                                        '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to watchlater </div>'
                                    );
                                    setTimeout(function() {
                                        $('.add_watch').slideUp('fast');
                                    }, 3000);
                                    //  alert();

                                } else {
                                    //  $(this).html('<i class="ri-add-circle-line"></i>');
                                    $(this).html('<i class="ri-heart-line"></i>');
                                    $(".add_data_test").empty();
                                    //  $(this).html('<i class="ri-heart-line"></i>');
                                    $(".add_data_test").append("<div>Added to Watchlater</div> ");
                                    $("body").append(
                                        '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from watchlater</div>'
                                    );
                                    setTimeout(function() {
                                        $('.remove_watch').slideUp('fast');
                                    }, 3000);
                                }

                            } else {
                                window.location = '<?= URL::to('login') ?>';
                            }
                        });
                    </script>

                    <!-- INTRO SKIP  -->

                    <?php
                    $Auto_skip = App\HomeSetting::first();
                    $SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();
                    $Intro_skip = App\Video::where('id', $video->id)->first();
                    $start_time = $Intro_skip->intro_start_time;
                    $end_time = $Intro_skip->intro_end_time;
                    
                    $StartParse = date_parse($start_time);
                    $startSec = $StartParse['hour'] * 60 * 60 + $StartParse['minute'] * 60 + $StartParse['second'];
                    
                    $EndParse = date_parse($end_time);
                    $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];
                    
                    $SkipIntroParse = date_parse($Intro_skip['skip_intro']);
                    $skipIntroTime = $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];
                    
                    if ($Intro_skip['type'] == 'mp4_url' || $Intro_skip['type'] == 'm3u8_url') {
                        $video_type_id = 'videoPlayer';
                    } else {
                        $video_type_id = 'video';
                    }
                    
                    $ContinueWatching = App\ContinueWatching::where('user_id', '=', Auth::User()->id)
                        ->where('videoid', '=', $video->id)
                        ->orderby('created_at', 'desc')
                        ->first();
                    if (!empty($ContinueWatching)) {
                        $Currenttime = $ContinueWatching['currentTime'];
                    } else {
                        $Currenttime = 0;
                    }
                    
                    ?>

                    <script>
                        // Continue Watching Video start's at watched time

                        var video_type_Ids = <?php echo json_encode($video_type_id); ?>;
                        var Currenttime = <?php echo json_encode($Currenttime); ?>;
                        var video = document.getElementById(video_type_Ids);
                        if (Currenttime > 0) {
                            var watch_percentage = Currenttime;
                            this.video.currentTime = Currenttime;
                            this.video.play();
                        }
                        // Continue Watching End


                        // Strat video end card
                        var videotype_Ids = <?php echo json_encode($video_type_id); ?>;
                        // alert(videotype_Ids);
                        var video = document.getElementById(videotype_Ids);
                        // alert(video);
                        this.video.addEventListener('timeupdate', (e) => {
                            var duration = video.duration;
                            var endtime = duration - 5;
                            // alert();
                            document.getElementById("end_card_video").style.display = "none";
                            if (e.target.currentTime >= endtime) {
                                // document.getElementById("end_card_video").style.display = "block"; // Manual show
                                document.getElementById("end_card_video").style.display = "none";

                            }

                        });
                        // End video end card

                        var SkipIntroPermissions = <?php echo json_encode($SkipIntroPermission); ?>;
                        var videotype_Id = <?php echo json_encode($video_type_id); ?>;
                        var video = document.getElementById(videotype_Id);
                        var button = document.getElementById("intro_skip");
                        var Start = <?php echo json_encode($startSec); ?>;
                        var End = <?php echo json_encode($EndSec); ?>;
                        var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;
                        var IntroskipEnd = <?php echo json_encode($skipIntroTime); ?>;





                        if (SkipIntroPermissions == 1) {
                            button.addEventListener("click", function(e) {
                                video.currentTime = IntroskipEnd;
                                $("#intro_skip").remove(); // Button Shows only one tym
                                video.play();
                            })


                            if (AutoSkip != 1) {
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
                    $Recap_skip = App\Video::where('id', $video->id)->first();
                    $RecapStart_time = $Recap_skip->recap_start_time;
                    $RecapEnd_time = $Recap_skip->recap_end_time;
                    
                    $RecapStartParse = date_parse($RecapStart_time);
                    $RecapstartSec = $RecapStartParse['hour'] * 60 * 60 + $RecapStartParse['minute'] * 60 + $RecapStartParse['second'];
                    
                    $SkipRecapParse = date_parse($Recap_skip['skip_recap']);
                    $skipRecapTime = $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];
                    
                    $RecapEndParse = date_parse($RecapEnd_time);
                    $RecapEndSec = $RecapEndParse['hour'] * 60 * 60 + $RecapEndParse['minute'] * 60 + $RecapEndParse['second'];
                    ?>

                    <script>
                        var videotypeId = <?php echo json_encode($video_type_id); ?>;
                        var videoId = document.getElementById(videotypeId);
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

                    <!-- Link on Player -->

                    <script>
                        document.getElementById("url_linkdetails").style.display = "none";
                        var video_player = document.getElementById(videotypeId);
                        var start_urltime = <?php echo json_encode($video->url_linksec); ?>;
                        var End_urltime = <?php echo json_encode($video->urlEnd_linksec); ?>;

                        this.video_player.addEventListener('timeupdate', (e) => {
                            document.getElementById("url_linkdetails").style.display = "none";

                            if (start_urltime <= e.target.currentTime && e.target.currentTime < End_urltime) {
                                document.getElementById("url_linkdetails").style.display = "block";
                            }
                        });




                        // Tool Tip
                        $(document).ready(function() {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
                    </script>


                    <!-- logo on player -->

                    <script>
                        $(document).ready(function() {

                            // $(".logo_player").hide();
                            // $('.plyr__video-wrapper').bind('contextmenu', function() {

                            //   $(".logo_player").show();
                            //   setTimeout(function() {
                            //         $('.logo_player').fadeOut('fast');
                            //     }, 30000); 
                            // });

                        });
                    </script>


                    <!-- Ads Start -->

                    <?php
                    
                    if (plans_ads_enable() == 1) {
                        // include 'AdsvideoPre.php';
                        // include 'AdsvideoMid.php';
                        // include 'AdsvideoPost.php';
                    }
                    
                    ?>

                    <!-- Ads End -->


                    <?php
  $player_ui = App\Playerui::pluck('show_logo')->first();
  $logo = App\Setting::pluck('logo')->first();
  $logo_url = '/public/uploads/settings/'. $logo ;
    if($player_ui == 1){
?>
                    <style>
                        .logo_player {
                            position: absolute;
                            top: 70%;
                            left: 80%;
                            z-index: 2;
                            content: '';
                            height: 86px;
                            width: 10%;
                            background: url(<?php echo URL::to($logo_url); ?>) no-repeat;
                            background-size: 100px auto, auto;
                        }
                    </style>
                    <?php } ?>


                </div>

                <script>
                    
                    // Set the date we're counting down to
                    var date = "<?= $new_date ?>";
                    var countDownDate = new Date(date).getTime();
                    var days, hours, minutes, seconds;
                    // alert(countDownDate)
                    // Update the count down every 1 second
                    var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();
                        // alert(now)

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;
                        // alert(distance)
                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById("demo").innerHTML = 
                            
                            "<span1>" + days + "d "+ "</span1><span1>" + hours+ "h " + "</span1><span1>" + minutes+ "m "  + "</span1><span1>" + seconds  + "s "+ "</span1>"; 
//                            days + "d " + hours + "h " +
//                            minutes + "m " + seconds + "s ";

                        // If the count down is over, write some text 
                        if (distance < 0) {
                            clearInterval(x);
                            // document.getElementById("demo").innerHTML = "EXPIRED";
                            location.reload();
                        }
                    }, 1000);
                </script>

                <script>
                    window.onload = function() {
                        $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button').hide();
                    }

                    $(document).ready(function() {

                        $(".payment_btn").click(function() {

                            $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

                            let payment_gateway = $('input[name="payment_method"]:checked').val();
                            // alert(payment_gateway);
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

                <script>
                    $(function() {
                        $(".video").click(function() {
                            var theModal = $(this).data("target"),
                                videoSRC = $(this).attr("data-video"),
                                videoSRCauto = videoSRC + "";
                            $(theModal + ' source').attr('src', videoSRCauto);
                            $(theModal + ' video').load();
                            $(theModal + ' button.close').click(function() {
                                $(theModal + ' source').attr('src', videoSRC);
                            });
                        });
                    });
                </script>


                <?php include 'footer.blade.php'; ?>

                <!-- Trailer m3u8 -->


                <script>
                    const player = new Plyr('#videoPlayer1');

                    var trailer_video_m3u8 = <?php echo json_encode($video->trailer); ?>;
                    var trailer_video_type = <?php echo json_encode($video->trailer_type); ?>;


                    if (trailer_video_type == "m3u8_url") {
                        (function() {
                            var video = document.querySelector('#videoPlayer1');

                            if (Hls.isSupported()) {
                                var hls = new Hls();
                                hls.loadSource(trailer_video_m3u8);
                                hls.attachMedia(video);
                                hls.on(Hls.Events.MANIFEST_PARSED, function() {});
                            }

                        })();

                    } else if (trailer_video_type == "m3u8") {
                        // alert(trailer_video_type);
                        document.addEventListener("DOMContentLoaded", () => {
                            const videos = document.querySelector('#videos');
                            // alert(video);
                            const sources = videos.getElementsByTagName("source")[0].src;
                            // alert(sources);
                            const defaultOptions = {};




                            if (Hls.isSupported()) {
                                const hlstwo = new Hls();
                                hlstwo.loadSource(sources);

                                // From the m3u8 playlist, hls parses the manifest and returns
                                // all available video qualities. This is important, in this approach,
                                // we will have one source on the Plyr player.
                                hlstwo.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                                    // Transform available levels into an array of integers (height values).
                                    const availableQualities = hlstwo.levels.map((l) => l.height)
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

                                    hlstwo.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                                        var span = document.querySelector(
                                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                                        if (hlstwo.autoLevelEnabled) {
                                            span.innerHTML = `AUTO (${hlstwo.levels[data.level].height}p)`
                                        } else {
                                            span.innerHTML = `AUTO`
                                        }
                                    })

                                    // Initialize new Plyr player with quality options
                                    var player = new Plyr(videos, defaultOptions);
                                });

                                hlstwo.attachMedia(videos);
                                window.hlstwo = hlstwo;
                            }

                            function updateQuality(newQuality) {
                                if (newQuality === 0) {
                                    window.hlstwo.currentLevel = -1; //Enable AUTO quality if option.value = 0
                                } else {
                                    window.hlstwo.levels.forEach((level, levelIndex) => {
                                        if (level.height === newQuality) {
                                            console.log("Found quality match with " + newQuality);
                                            window.hlstwo.currentLevel = levelIndex;
                                        }
                                    });
                                }
                            }
                        });

                    }


                    // Trailer - Modal
                    $(document).ready(function() {
                        $(".close").click(function() {
                            $('#videoPlayer1')[0].pause();
                        });
                    });
                </script>

                <!-- Cinet Pay CheckOut -->

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
                                    url: '<?php echo URL::to('CinetPay-video-rent'); ?>',
                                    type: "post",
                                    data: {
                                        _token: '<?php echo csrf_token(); ?>',
                                        amount: ppv_price,
                                        video_id: video_id,

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
                </script>
                <?php include 'register_pop_up.php'; ?>
