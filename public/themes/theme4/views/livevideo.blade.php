
@php
    include(public_path('themes/theme4/views/header.php'));
@endphp

<!-- video-js Style  -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet">
<!-- <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/videos-player.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet">


<!-- Style -->
<link rel="preload" href="<?= URL::to('public/themes/theme4/assets/css/style.css') ?>" as="style">


<!-- video-js Script  -->

<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ads.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ima.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/end-card.js') ?>"></script>


<meta name="csrf-token" content="{{ csrf_token() }}">

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
      /*background-color: #000;*/
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
      /*background: rgb(0 0 0 / 45%);*/
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
/* .slick-next:before{display:none;} */
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

   .plyr audio,
   .plyr iframe,
   .plyr video {
      display: block;
      /* height: 100%; */
      /* width: 100%; */
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
    .my-video.vjs-fluid{height: calc(100vh - 70px)!important;}
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
</style>

<input type="hidden" name="video_id" id="video_id" value="<?php echo $video->id; ?>">

<?php if (Session::has('message')): ?>
    <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;" ><?php  echo Session::get('message') ?></div>
<?php endif ;?>

@php
    include(public_path('themes/theme4/views/livevideo_ads.blade.php'));

    $recurring_program_Status = false ;

    if ( $video->publish_type == "recurring_program" ) {

        $recurring_program_Status = true ;

        $recurring_timezone = App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first();
        
        $Current_time = Carbon\Carbon::now(current_timezone());
        $convert_time = $Current_time->copy()->timezone($recurring_timezone);

        switch ($video->recurring_program) {

            case 'custom':

                if ( $video->custom_start_program_time <= $convert_time->format('Y-m-d\TH:i:s') &&  $video->custom_end_program_time >= $convert_time->format('Y-m-d\TH:i:s') ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'daily':

                if ( $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'weekly':

                if ( $video->recurring_program_week_day == $convert_time->format('N') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'monthly':

                if ( $video->recurring_program_month_day == $convert_time->format('d') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')   ) {
                    $recurring_program_Status = false ;
                }
                break;
            
            default:
                break;
        }
    }
    
@endphp


@if ($recurring_program_Status == false) 

    <?php

    if(empty($new_date)){

        if(!Auth::guest()){
            if(!empty($password_hash)){ ?>
                <?php if ($ppv_exist > 0 ||  ( Auth::user()->role == "subscriber" && $video->access != "ppv" ) ||  ( Auth::user()->role == "subscriber" && settings_enable_rent() == 1 )  || $video_access == "free"  || Auth::user()->role == "admin" || $video->access == "guest" && $video->ppv_price == null ) { ?>
                    <div id="video_bg"> 
                        <div class="">
                            <div id="video sda" class="fitvid" style="margin: 0 auto;">

                            <?php if ( $Livestream_details->url_type == "embed" ) : ?>

                                <iframe class="responsive-iframe" src="<?= $Livestream_details->livestream_URL ?>" poster="<?= $Livestream_details->Player_thumbnail ?>"
                                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>

                            <?php else: ?>
                                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                </button>
                                <video id="live-stream-player" class="vjs-theme-city my-video video-js vjs-play-control vjs-live-control vjs-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                                    width="auto" height="auto" playsinline="playsinline" autoplay="autoplay" poster="<?= $Livestream_details->Player_thumbnail ?>">
                                    <source src="<?= $Livestream_details->livestream_URL ?>" type="<?= $Livestream_details->livestream_player_type ?>">
                                </video>

                            <?php endif; ?>  

                            <div class="playertextbox hide">
                                <p> <?php if (isset($videonext)) { ?>
                                    <?=App\LiveStream::where('id', '=', $videonext->id)->pluck('title'); ?>
                                    <?php } elseif (isset($videoprev)) { ?>
                                    <?=App\LiveStream::where('id', '=', $videoprev->id)->pluck('title'); ?>
                                    <?php } ?>

                                    <?php if (isset($videos_category_next)) { ?>
                                    <?=App\LiveStream::where('id', '=', $videos_category_next->id)->pluck('title'); ?>
                                    <?php } elseif (isset($videos_category_prev)) { ?>
                                    <?=App\LiveStream::where('id', '=', $videos_category_prev->id)->pluck('title'); ?>
                                    <?php } ?>
                                </p>
                            </div>
                    </div>

                    <?php  } elseif ( ( ($video->access = "subscriber" && ( Auth::guest() == true || Auth::user()->role == "registered" ) ) ||  ( $video->access = "ppv" && Auth::check() == true ? Auth::user()->role != "admin" : Auth::guest() ) ) && $video->free_duration_status == 1 && $video->free_duration != null ) {  ?>       

                    <div id="video_bg"> 
                    <div class="">
                        <div id="video sda" class="fitvid" style="margin: 0 auto;">

                        <?php if ( $Livestream_details->url_type == "embed" ) : ?>

                            <iframe class="responsive-iframe" src="<?= $Livestream_details->livestream_URL ?>" poster="<?= $Livestream_details->Player_thumbnail ?>"
                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>

                        <?php else: ?>
                            <video id="live-stream-player" class="vjs-big-play-centered vjs-theme-city my-video video-js vjs-live-control vjs-control vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                                width="auto" height="auto" playsinline="playsinline" autoplay="autoplay" poster="<?= $Livestream_details->Player_thumbnail ?>">
                                <source src="<?= $Livestream_details->livestream_URL ?>" type="<?= $Livestream_details->livestream_player_type ?>">
                            </video>

                        <?php endif; ?>  

                <?php  } else {  ?>       
                    <div id="subscribers_only" style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.4)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                        <div id="video_bg_dim" <?php if ( ($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?> class="darker"<?php endif; ?>></div>
                        <div class="row justify-content-center pay-live">
                            <div class="col-md-5 col-sm-offset-5 text-center">
                                <div class="ppv-block">
                                    <h2 class="mb-3"><?php echo __('Pay now to watch'); ?> <?php echo $video->title; ?></h2>

                                        <h4 class="text-center" style="margin-top:40px;"><a href="<?=URL::to('/') . '/stripe/billings-details' ?>"><p><?php echo __('Click here to purchase and watch this live'); ?></p></a></h4>

                                    <!-- PPV button -->
                                            <?php $users = Auth::user();  ?>

                                            <?php if ( ($ppv_exist == 0 ) && (  $users->role!="admin")  && ($video->access == "ppv")   ) { ?>
                                                <button  data-toggle="modal" data-target="#exampleModalCenter" style="width:50%;" class="view-count btn btn-primary btn-block rent-video">
                                                <?php echo __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price;  ;?> </button>
                                            <?php } ?>
                                    </div>
                            </div>
                        </div>
                    </div>
            <?php } }
        }
        else{  
            
            if (Auth::guest() && empty($video->ppv_price) && $video->free_duration_status == 0  ) { ?>
                <div id="video_bg"> 
                <div class="">
                    <div id="video sda" class="fitvid" style="margin: 0 auto;">

                    <?php if ( $Livestream_details->url_type == "embed" ) : ?>

                        <iframe class="responsive-iframe" src="<?= $Livestream_details->livestream_URL ?>" poster="<?= $Livestream_details->Player_thumbnail ?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>

                    <?php else: ?>
                        <video id="live-stream-player" class="vjs-big-play-centered vjs-theme-city vjs-live-control vjs-control my-video video-js vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                            width="auto" height="auto" playsinline="playsinline" autoplay="autoplay" poster="<?= $Livestream_details->Player_thumbnail ?>">
                            <source src="<?= $Livestream_details->livestream_URL ?>" type="<?= $Livestream_details->livestream_player_type ?>">
                        </video>

                    <?php endif; ?>
                        

            <?php  } elseif ( ( ($video->access = "subscriber" && ( Auth::guest() == true || Auth::user()->role == "registered" ) ) ||  ( $video->access = "ppv" && Auth::check() == true ? Auth::user()->role != "admin" : Auth::guest() ) ) && $video->free_duration_status == 1 && $video->free_duration != null ) {  ?>       

                <div id="video_bg"> 
                <div class="">
                    <div id="video sda" class="fitvid" style="margin: 0 auto;">

                    <?php if ( $Livestream_details->url_type == "embed" ) : ?>

                        <iframe class="responsive-iframe" src="<?= $Livestream_details->livestream_URL ?>" poster="<?= $Livestream_details->Player_thumbnail ?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>

                    <?php else: ?>

                        <video id="live-stream-player" class="vjs-big-play-centered vjs-theme-city my-video video-js vjs-play-control vjs-live-control vjs-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                            width="auto" height="auto" playsinline="playsinline" autoplay="autoplay" poster="<?= $Livestream_details->Player_thumbnail ?>">
                            <source src="<?= $Livestream_details->livestream_URL ?>" type="<?= $Livestream_details->livestream_player_type ?>">
                        </video>

                    <?php endif; ?>
                    

            <?php  } else { ?>       
                <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                    <div id="video_bg_dim" <?php if (($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?> class="darker"<?php endif; ?>></div>
                    <div class="row justify-content-center pay-live">
                        <div class="col-md-4 col-sm-offset-4">
                            <div class="ppv-block">
                                <h2 class="mb-3"><?php echo __('Pay now to watch'); ?> <?php echo $video->title; ?></h2>
                                <div class="clear"></div>
                                <?php if(Auth::guest()){ ?>
                                    <a href="<?php echo URL::to('/login');?>"><button class="btn btn-primary btn-block" ><?php echo __('Purchase For Pay'); ?> <?php echo $currency->symbol.' '.$video->ppv_price; ?></button></a>
                                <?php }else{ ?>
                                    <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)"><?php echo __('Purchase For Pay'); ?> <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
    } elseif(!empty($new_date)){ ?>
        <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
            <h2> <?php echo __('COMING SOON'); ?> </h2>
            <p class="countdown" id="demo"></p>
        </div>
    <?php } ?>

@elseif( $recurring_program_Status == true )

    <div id="" style="background: linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url({{ URL::to('/') }}/public/uploads/images/{{ $video->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 150px 10px;">
        
        <h2>{{ ucwords($video->title) }}</h2><br>

        @if ($video->publish_type == "recurring_program")
        
            @php
                $timezone = App\TimeZone::where('id',$video->recurring_timezone)->pluck('time_zone')->first();
                $startTime = Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A');
                $endTime = Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A');
            @endphp

            @if ($video->recurring_program == "daily")

                <h2>Live Streaming On {{ $video->recurring_program }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>
            
                @if ( !Auth::guest() && Auth::user()->role != "admin" && ($ppv_exist == 0 ) && ($video->access == "ppv"))
                    
                    <button data-toggle="modal" data-target="#exampleModalCenter" style="width: 32%;margin-left: 36%; margin-top:19px"  class="view-count btn btn-primary btn-block rent-video">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>

                @elseif( Auth::guest() && $video->access == "ppv")
                    <button style="width: 32%;margin-left: 36%; margin-top:19px" class="btn btn-primary btn-block" onclick="window.location.href='<?php echo route('login'); ?>'">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>
                @endif  
                
            @elseif ($video->recurring_program == "weekly")

                @switch($video->recurring_program_week_day)
                    @case(1)
                        @php $recurring_program_week_day = "Monday"; @endphp
                        @break
                    @case(2)
                        @php $recurring_program_week_day = "Tuesday"; @endphp
                        @break
                    @case(3)
                        @php $recurring_program_week_day = "Wednesday"; @endphp
                        @break
                    @case(4)
                        @php $recurring_program_week_day = "Thursday"; @endphp
                        @break
                    @case(5)
                        @php $recurring_program_week_day = "Friday"; @endphp
                        @break
                    @case(6)
                        @php $recurring_program_week_day = "Saturday"; @endphp
                        @break
                    @case(7)
                        @php $recurring_program_week_day = "Sunday"; @endphp
                        @break
                    @default
                        @php $recurring_program_week_day = "Unknown"; @endphp
                @endswitch
            
                <h2>Live Streaming On Every Week {{ $recurring_program_week_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>
               
                @if ( !Auth::guest() && Auth::user()->role != "admin" && ($ppv_exist == 0 ) && ($video->access == "ppv"))
                    
                    <button data-toggle="modal" data-target="#exampleModalCenter" style="width: 32%;margin-left: 36%; margin-top:19px"  class="view-count btn btn-primary btn-block rent-video">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>

                @elseif( Auth::guest() && $video->access == "ppv")
                    <button style="width: 32%;margin-left: 36%; margin-top:19px" class="btn btn-primary btn-block" onclick="window.location.href='<?php echo route('login'); ?>'">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>
                @endif  

            @elseif ($video->recurring_program == "monthly")
                    
                <h2>Live Streaming On Every Month on Day {{ $video->recurring_program_month_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>
            
                @if ( !Auth::guest() && Auth::user()->role != "admin" && ($ppv_exist == 0 ) && ($video->access == "ppv"))
                    
                    <button data-toggle="modal" data-target="#exampleModalCenter" style="width: 32%;margin-left: 36%; margin-top:19px"  class="view-count btn btn-primary btn-block rent-video">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>

                @elseif( Auth::guest() && $video->access == "ppv" )
                    <button style="width: 32%;margin-left: 36%; margin-top:19px" class="btn btn-primary btn-block" onclick="window.location.href='<?php echo route('login'); ?>'">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>
                @endif  

            @elseif ($video->recurring_program == "custom")

                @php
                    $customStartTime = Carbon\Carbon::parse($video->custom_start_program_time)->format('j F Y g:ia');
                    $customEndTime = Carbon\Carbon::parse($video->custom_end_program_time)->format('j F Y g:ia');
                @endphp

                <h3>Live Streaming On {{ $customStartTime }} - {{ $customEndTime }}</h3>
                <h3>({{ $timezone }})</h3>

                @if ( !Auth::guest() && Auth::user()->role != "admin" && ($ppv_exist == 0 ) && ($video->access == "ppv"))
                    
                    <button data-toggle="modal" data-target="#exampleModalCenter" style="width: 32%;margin-left: 36%; margin-top:19px"  class="view-count btn btn-primary btn-block rent-video">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>

                @elseif( Auth::guest() && $video->access == "ppv")
                    <button style="width: 32%;margin-left: 36%; margin-top:19px" class="btn btn-primary btn-block" onclick="window.location.href='<?php echo route('login'); ?>'">
                        {{ __('Purchase Now '). ' ' . $currency->symbol.' '.$video->ppv_price  }} 
                    </button>
                @endif  
            @endif
        @endif
    </div>
@endif
    
<input type="hidden" class="videocategoryid" data-videocategoryid="<?=$video->video_category_id; ?>" value="<?=$video->video_category_id; ?>">

<div class="mar-left video-details">
    <div class="row">

                                                    <!-- BREADCRUMBS -->
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

    <!-- Year, Running time, Age -->
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

                <div class="col-sm-6 col-md-6 col-xs-12">
        
                    <ul class="list-inline p-0 mt-4 rental-lists">
                        <!-- Subscribe -->
                        @if($Livestream_details->access == 'subscriber')
                            <li>
                                <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                            </li>
                        @elseif($Livestream_details->access = 'ppv')
                            <li>
                                <a data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video" href="<?php echo URL::to('/login');?>">
                                    <?php echo __('Rent');?> </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        <?php   }?>

        <div class="mar-left">
            <div class="text-white col-md-6 p-0">
                <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div class="video-details-container">
                        <?php if (!empty($video->details)) { ?>
                            <h6 class="mt-3 mb-1"><?php echo __('Live Details'); ?></h6>
                            <p class="trending-dec w-100 mb-3 text-white"><?=$video->details; ?></p>
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

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:black"><?php echo __('Rent Now'); ?></h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <div class="row justify-content-between">
                    <div class="col-sm-4 p-0" style="">
                        <img class="img__img w-100" src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid" alt="" >
                    </div>
                    
                        <div class="col-sm-8">
                        <h4 class=" text-black movie mb-3"><?php echo __($video->title);?> ,   <span class="trending-year mt-2"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span></h4>
                        <span class="badge badge-secondary   mb-2"><?php echo __($video->age_restrict).' '.'+';?></span>
                        <span class="badge badge-secondary  mb-2 ml-1"><?php echo __($video->duration);?></span><br>
                    
                        <a type="button" class="mb-3 mt-3"  data-dismiss="modal" style="font-weight:400;"><?php echo __('Amount'); ?>:   <span class="pl-2" style="font-size:20px;font-weight:700;"> <?php echo __($currency->symbol.' '.$video->ppv_price);?></span></a><br>
                        <div class="mb-0 mt-3 p-0 text-left">
                            <input type="radio" id="stripe_radio" name="roku_tvcode" value="Stripe">
                            <label for="roku_tvcode">Roku Tvcode</label><br>
                            <input type="text" id="roku_tvcode_input" name="roku_tvcode" placeholder="Enter Roku TV code" style="display: none;">
                        </div>
                        <label class="mb-0 mt-3 p-0" for="method"><h5 style="font-size:20px;line-height: 23px;" class="font-weight-bold text-black mb-2"><?php echo __('Payment Method'); ?> : </h5></label>
                    
                                    <!-- Stripe Button -->
                                <?php if( $stripe_payment_setting != null && $stripe_payment_setting->payment_type == "Stripe" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="tres_important" checked name="payment_method" value= <?= $stripe_payment_setting->payment_type ?>  data-value="stripe">
                                        <?php  echo $stripe_payment_setting->stripe_lable ;  ?>
                                    </label>      
                                <?php } ?>
                            
                                    <!-- Razorpay Button -->
                                <?php if( $Razorpay_payment_setting != null && $Razorpay_payment_setting->payment_type == "Razorpay" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?= $Razorpay_payment_setting->payment_type ?>"  data-value="Razorpay" >
                                        <?php  echo $Razorpay_payment_setting->payment_type ;  ?>
                                    </label>
                                <?php } ?>

                                    <!-- Paystack Button -->
                                <?php if( $Paystack_payment_setting != null && $Paystack_payment_setting->payment_type == "Paystack" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="" name="payment_method" value="<?= $Paystack_payment_setting->payment_type ?>"  data-value="Paystack" >
                                        <?php  echo $Paystack_payment_setting->payment_type ;  ?>
                                    </label>
                                <?php } ?>

                                
                                <!-- CinetPay Button -->
                                <?php if( $CinetPay_payment_settings != null && $CinetPay_payment_settings->payment_type == "CinetPay" && $CinetPay_payment_settings->status == 1 ){?>
                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="" name="payment_method" value="<?= $CinetPay_payment_settings->payment_type ?>"  data-value="CinetPay" >
                                    <?php  echo $CinetPay_payment_settings->payment_type ;  ?>
                                </label>
                            <?php } ?>

                        </div>
                    </div>                    
                </div>

                <div class="modal-footer">

                    <?php if( $video->ppv_price != null &&  $video->ppv_price != " " ) {?>
                        <div class="Stripe_button">  <!-- Stripe Button -->

                            <button class="btn2 btn-outline-primary" data-ppv-price="<?= $video->ppv_price ?>" data-live-id="<?= $video->id ?>" id="stripe_submit">
                                <?php echo __('Continue'); ?>
                            </button>
                        </div>
                    <?php } ?>

                                    
                <div class="Razorpay_button">   <!-- Razorpay Button -->
                    <?php if( $Razorpay_payment_setting != null && $Razorpay_payment_setting->payment_type == "Razorpay" ){?>
                            <button class="btn2  btn-outline-primary " onclick="location.href ='<?= URL::to('RazorpayLiveRent/'.$video->id.'/'.$video->ppv_price) ?>' ;" > <?php echo __('Continue'); ?> </button>
                    <?php } ?>
                </div>
                    
                <?php if( $video->ppv_price != null &&  $video->ppv_price != " " ) {?>
                    <div class="paystack_button">  <!-- Paystack Button -->
                        <?php if( $Paystack_payment_setting != null && $Paystack_payment_setting->payment_type == "Paystack" ){?>
                                <button class="btn2  btn-outline-primary" onclick="location.href ='<?= route('Paystack_live_Rent', ['live_id' => $video->id , 'amount' => $video->ppv_price] ) ?>' ;" > <?php echo __('Continue'); ?>  </button>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if( $video->ppv_price != null &&  $video->ppv_price != " " ) {?>
                    <div class="cinetpay_button">  <!-- Cinetpay Button -->
                        <?php if( $CinetPay_payment_settings != null && $CinetPay_payment_settings->payment_type == "CinetPay" ){?>
                            <button onclick="cinetpay_checkout()" id=""
                                class="btn2  btn-outline-primary"><?php echo __('Continue'); ?></button>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                </div>
            </div>
        </div>
    </div>

            <?php if (isset($videonext)) { ?>
                <div class="next_video" style="display: none;"><?=$videonext->slug; ?></div>
                <div class="next_url" style="display: none;"><?=$url; ?></div>
            <?php } elseif (isset($videoprev)) { ?>
                <div class="prev_video" style="display: none;"><?=$videoprev->slug; ?></div>
                <div class="next_url" style="display: none;"><?=$url; ?></div>
            <?php } ?>

            <?php if (isset($videos_category_next)) { ?>
                <div class="next_cat_video" style="display: none;"><?=$videos_category_next->slug; ?></div>
            <?php } elseif (isset($videos_category_prev)) { ?>
                <div class="prev_cat_video" style="display: none;"><?=$videos_category_prev->slug; ?></div>
            <?php } ?>
            <div class="clear"></div>

            <div id="social_share">
            <!--            <php include('partials/social-share.php'); ?>-->
            </div>
            <script>
                //$(".share a").hide();
                $(".share").on("mouseover", function() {
                    $(".share a").show();
                }).on("mouseout", function() {
                    $(".share a").hide();
                });
            </script>

        </div>
    </div>
</div>

     
<script>
    $(document).ready(function () {
        $('#roku_tvcode_input').hide();

        $('#stripe_radio').click(function () {
            const paymentMethod = $('#stripe_radio').val();
            if (paymentMethod === 'Stripe') {
                $('#roku_tvcode_input').show();
            } else {
                $('#roku_tvcode_input').hide();
            }
        });
        $('#stripe_submit').click( function () {
            const tvCode = $('#roku_tvcode_input').val();
            const liveId = $('#stripe_submit').data('live-id'); // Use $(this) to get the correct season ID
            const ppvPrice = $('#stripe_submit').data('ppv-price'); // Use $(this) to get the correct price

            // console.log('liveId :' + liveId);
            // console.log('ppvPrice :' + ppvPrice);

            const url = `<?= URL::to('Stripe_payment_live_PPV_Purchase') ?>/${liveId}/${ppvPrice}?roku_tvcode=${tvCode}`;
            window.location.href = url;
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#video_container').fitVids();

        $('.favorite').click(function(){
            if($(this).data('authenticated')){
                $.post('<?=URL::to('favorite') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
                $(this).toggleClass('active');
            } else {
                window.location = '<?=URL::to('login') ?>';
            }
        });

        //watchlater

        $('.watchlater').click(function(){

            if($(this).data('authenticated')){

                $.post('<?=URL::to('ppvWatchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
                $(this).toggleClass('active');
                $(this).html("");

                if($(this).hasClass('active')){
                    $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
                }else{
                    $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
                }
            } else {
                window.location = '<?=URL::to('login') ?>';
            }
        });

        //My Wishlist
        $('.mywishlist').click(function(){

            if($(this).data('authenticated')){

            $.post('<?=URL::to('ppvWishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
            $(this).toggleClass('active');
            $(this).html("");

            if($(this).hasClass('active')){
                $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
            }else{
                $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
            }

            } else {
            window.location = '<?=URL::to('login') ?>';
            }
        });

    });

</script>

<!-- RESIZING FLUID VIDEO for VIDEO JS -->

<script type="text/javascript">
    $(document).ready(function(){
        $('a.block-thumbnail').click(function(){
            var myPlayer = videojs('video_player');
            var duration = myPlayer.currentTime();

            $.post('<?=URL::to('watchhistory'); ?>', { video_id : '<?=$video->id ?>', _token: '<?= csrf_token(); ?>', duration : duration }, function(data){});
        }); 
    });
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

<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to("/purchase-live") ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<script>
    var elem = document.querySelector('.live-videos');
    var flkty = new Flickity( elem, {
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
<script type="text/javascript">
    var livepayment = $('#purchase_url').val();
    var publishable_key = $('#publishable_key').val();

    $(document).ready(function () {  
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
        token: function (token) {
            console.log('Token Created!!'); // You can access the token ID with `token.id`.
            console.log(token); // Get the token ID to your server-side code for use.
            $('#token_response').html(JSON.stringify(token));

            $.ajax({
            url: '<?php echo URL::to("purchase-live") ;?>',
            method: 'post',
            data: {"_token": "<?= csrf_token(); ?>",
                tokenId:token.id, 
                amount: amount , 
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
    name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
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
<!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->


<script>
// Set the date we're counting down to
var date = "<?= $new_date ?>";
var countDownDate = new Date(date).getTime();
// Update the count down every 1 second
var x = setInterval(function() {

// Get today's date and time
var now = new Date().getTime();

// Find the distance between now and the count down date
var distance = countDownDate - now;

// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);

// Output the result in an element with id="demo"
document.getElementById("demo").innerHTML = days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

// If the count down is over, write some text 
if (distance < 0) {
clearInterval(x);
document.getElementById("demo").innerHTML = "EXPIRED";
}
}, 1000);
</script>


        <!-- PPV Purchase -->

<script type="text/javascript">

    var ppv_exits = <?= $ppv_exists ?>;

    // if( ppv_exits == 1 ){

    //     var i = setInterval(function() { PPV_live_PurchaseUpdate(); }, 60 * 1000);

    //     window.onload = unseen_expirydate_checking();
        
    //     function PPV_live_PurchaseUpdate() {

    //     $.ajax({
    //             type:'post',
    //             url:'<?= route('PPV_live_PurchaseUpdate') ?>',
    //             data: {
    //                     "_token"   : "<?= csrf_token(); ?>",
    //                     "live_id" : "<?php echo $video->id; ?>", 
    //                 },
    //             success:function(data) {
    //                 if(data.status == true){
    //                     window.location.reload();
    //                 }
    //             }
    //             });
    //     }

    //     function unseen_expirydate_checking() {

    //         $.ajax({
    //             type:'post',
    //             url:'<?= route('unseen_expirydate_checking') ?>',
    //             data: {
    //                     "_token"   : "<?= csrf_token(); ?>",
    //                     "live_id" : "<?php echo $video->id; ?>", 
    //                 },
    //             success:function(data) {
    //                 console.log(data);
    //                 if(data.status == true){
    //                     window.location.reload();
    //                 }
    //             }
    //         });
    //     }
    // }
</script>

<script>
  window.onload = function(){ 
       $('.Razorpay_button,.paystack_button,.cinetpay_button').hide();
    }

     $(document).ready(function(){

      $(".payment_btn").click(function(){

        $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

        let payment_gateway =  $('input[name="payment_method"]:checked').val();

            if( payment_gateway  == "Stripe" ){

                $('.Stripe_button').show();
                $('.Razorpay_button,.paystack_button,.cinetpay_button').hide();

            }else if( payment_gateway == "Razorpay" ){

                $('.paystack_button,.Stripe_button,.cinetpay_button').hide();
                $('.Razorpay_button').show();

            }else if( payment_gateway == "Paystack" ){

                $('.Stripe_button,.Razorpay_button,.cinetpay_button').hide();
                $('.paystack_button').show();
            }else if( payment_gateway == "CinetPay" ){

                $('.Stripe_button,.Razorpay_button,.paystack_button').hide();
                $('.cinetpay_button').show();
            }
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

            window.onload = function () {
                setTimeout(function () {
                    $(".header_top_position_img").fadeOut('fast');
                }, 4000);
            };
        </script>

        <script>
            $(document).ready(function () {  
                let recurring_program_check_exist = <?php echo json_encode($recurring_program_Status); ?>;
            
                if(recurring_program_check_exist){
                    setInterval(function() {
                        location.reload();
                    }, 60000);
                }
            });
        </script>
@php
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp