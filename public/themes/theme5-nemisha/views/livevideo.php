<?php include 'header.php'; ?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
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

    .fp-ratio {
        padding-top: 64% !important;
    }

    h2 {
        text-align: center;
        font-size: 35px;
        margin-top: 0px;
        font-weight: 400;
    }

    #live_player_mp4 {
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

    .modal {
        position: fixed;
        top: 0;
        right: auto;
        bottom: 0;
        left: 0;
        z-index: 1050;
        display: none;
        overflow: hidden;
        outline: 0;
    }
</style>

<style>
    .vjs-skin-hotdog-stand {
        color: #FF0000;
    }

    .vjs-skin-hotdog-stand .vjs-control-bar {
        background: #FFFF00;
    }

    .vjs-skin-hotdog-stand .vjs-play-progress {
        background: #FF0000;
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

</style>

<input type="hidden" name="video_id" id="video_id" value="<?php echo $video->id; ?>">

<?php

include('livevideo_ads.blade.php');  

$autoplay = $live_ads == null ? "autoplay" : "" ;    

$str = $video->mp4_url;

if(!empty($str)){
    $uri_parts = explode('.', $video->mp4_url);
    $request_url = end($uri_parts);
}

$rtmp_url = $video->rtmp_url;


$Rtmp_url = str_replace ('rtmp', 'http', $rtmp_url);

if(empty($new_date)){

if(!Auth::guest()){
if(!empty($password_hash)){
if ($ppv_exist > 0 ||  Auth::user()->subscribed() || $video_access == "free"  || Auth::user()->role == "admin" || $video->access == "guest" && $video->ppv_price == null ) { ?>
<div id="video_bg">
    <div class="">
        <div id="video sda" class="fitvid" style="margin: 0 auto;">

            <?php if(!empty($video->mp4_url && $request_url != "m3u8"  && $video->url_type == "mp4" )){  ?>

            <video id="live_player_mp4" <?= $autoplay ?> class=""
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?= $video->mp4_url ?>"
                type="application/x-mpegURL" data-authenticated="<?= !Auth::guest() ?>">
                <source src="<?= $video->mp4_url ?>" type='application/x-mpegURL' label='Auto' res='auto' />
                <source src="<?php echo $video->mp4_url; ?>" type='application/x-mpegURL' label='480p' res='480' />
                <!-- <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/>  -->
            </video>

            <?php }elseif(!empty($video->embed_url)  && $video->url_type == "embed"){ ?>
            <div class="plyr__video-embed" id="player">
                <iframe src="<?php if (!empty($video->embed_url)) {
                    echo $video->embed_url;
                } else {
                } ?>" allowfullscreen allowtransparency allow="autoplay">
                </iframe>
            </div>
            <?php  }elseif(!empty($request_url == "m3u8")  && $video->url_type == "mp4"){  ?>

            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->mp4_url; ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
            <input type="hidden" id="live" name="live" value="live">
            <input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url; ?>">

            <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source type="application/x-mpegURL" src="<?php echo $video->mp4_url; ?>">
            </video>

            <?php }elseif(!empty($video->url_type == "Encode_video")){  ?>

            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->hls_url; ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
            <input type="hidden" id="live" name="live" value="live">
            <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

            <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source type="application/x-mpegURL" src="<?php echo $video->hls_url; ?>">
            </video>

            <?php  }elseif(!empty($video->url_type ) && $video->url_type == "live_stream_video"){  ?>

            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
            <input type="hidden" id="live" name="live" value="live">
            <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

            <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source type="application/x-mpegURL" src="<?php echo $video->live_stream_video; ?>">
            </video>

            <?php  }elseif(!empty($video->url_type ) && $video->url_type == "acc_audio_url"){  ?>

            <video id="acc_audio" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source src="<?php echo $video->acc_audio_url; ?>">
            </video>

            <?php  }elseif(!empty($video->url_type ) && $video->url_type == "acc_audio_file"){  ?>

            <video id="acc_audio" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source src="<?php echo $video->acc_audio_file; ?>">
            </video>

            <?php  }elseif(!empty($video->url_type ) && $video->url_type == "aws_m3u8"){  ?>

            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
            <input type="hidden" id="live" name="live" value="live">
            <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

            <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                <source type="application/x-mpegURL" src="<?php echo $video->hls_url; ?>">
            </video>

            <?php  }elseif(!empty($video->url_type ) && $video->url_type == "m3u_url"){   ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 ">
                        <div class="border-end" id="sidebar-wrapper">
                            <div class="sidebar-heading border-bottom">Channels</div>
                            <div class="list-group list-group-flush">
                                <?php foreach( $M3U_channels as $M3U_index => $M3U_channel ){ ?>
                                <a data-toggle="modal" data-target="#M3U-Modal" data-MU3-category="<?= $M3U_index ?>"
                                    data-MU3-url="<?= $M3U_files ?>"
                                    class="list-group-item list-group-item-action list-group-item-light"
                                    onclick="m3u_url(this)"> <?= $M3U_index ?> </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">

                        <?php $m3u_url = session('m3u_url_link'); ?>

                        <video controls <?= $autoplay ?> crossorigin playsinline
                            poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                            data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' style="height:100%;">
                            <source type="application/x-mpegURL" src="<?php echo $m3u_url; ?>">
                        </video>
                    </div>
                </div>
            </div>

            <?php } ?>

            <!-- Modal - M3U Modal  -->

            <div class="modal fade  come-from-modal right" id="M3U-Modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background:#1B1212;">

                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"> Channel Category </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body data-plans ">
                            <div class="list-group list-group-flush"
                                style="height: calc(100vh - 80px - 75px)!important;">
                                <p> <?= 'Please wait a short while' ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="playertextbox hide">
                <p> <?php if (isset($videonext)) { ?>
                    <?= App\LiveStream::where('id', '=', $videonext->id)->pluck('title') ?>
                    <?php } elseif (isset($videoprev)) { ?>
                    <?= App\LiveStream::where('id', '=', $videoprev->id)->pluck('title') ?>
                    <?php } ?>

                    <?php if (isset($videos_category_next)) { ?>
                    <?= App\LiveStream::where('id', '=', $videos_category_next->id)->pluck('title') ?>
                    <?php } elseif (isset($videos_category_prev)) { ?>
                    <?= App\LiveStream::where('id', '=', $videos_category_prev->id)->pluck('title') ?>
                    <?php } ?>
                </p>
            </div>
        </div>

        <?php  } else {  ?>
        <div id="subscribers_only"
            style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.4)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
            <div id="video_bg_dim" <?php if ( ($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?> class="darker"<?php endif; ?>></div>
            <div class="row justify-content-center pay-live">
                <div class="col-md-4 col-sm-offset-4">
                    <div class="ppv-block">
                        <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>

                        <h4 class="text-center" style="margin-top:40px;"><a
                                href="<?= URL::to('/') . '/stripe/billings-details' ?>">
                                <p>Click Here To Become Subscriber</p>
                            </a></h4>

                        <!-- PPV button -->
                        <?php $users = Auth::user(); ?>

                        <?php if ( ($ppv_exist == 0 ) && (  $users->role!="admin")  ) { ?>
                        <button data-toggle="modal" data-target="#exampleModalCenter"
                            class="view-count btn btn-primary btn-block rent-video">
                            <?php echo __('Purchase Now '); ?> </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } }
}

else{  

        if (Auth::guest() && empty($video->ppv_price)) {  ?>
        <div id="video_bg">
            <div class="">
                <div id="video sda" class="fitvid" style="margin: 0 auto;">

                    <?php if(!empty($video->mp4_url && $request_url != "m3u8"  && $video->url_type == "mp4" )){  ?>

                    <video id="live_player_mp4" <?= $autoplay ?> onplay="playstart()" onended="autoplay1()"
                        class="video-js vjs-default-skin vjs-big-play-centered"
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                        src="<?= $video->mp4_url ?>" type="application/x-mpegURL"
                        data-authenticated="<?= !Auth::guest() ?>">
                        <source src="<?= $video->mp4_url ?>" type='application/x-mpegURL' label='Auto'
                            res='auto' />
                        <source src="<?php echo $video->mp4_url; ?>" type='application/x-mpegURL' label='480p'
                            res='480' />
                    </video>

                    <?php }elseif(!empty($video->embed_url)  && $video->url_type == "embed"){ ?>
                    <div class="plyr__video-embed" id="Embed_player">
                        <iframe src="<?php if (!empty($video->embed_url)) {
                            echo $video->embed_url;
                        } else {
                        } ?>" allowfullscreen allowtransparency allow="autoplay">
                        </iframe>
                    </div>
                    <?php  }elseif(!empty($request_url == "m3u8")  && $video->url_type == "mp4"){  ?>

                    <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->mp4_url; ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
                    <input type="hidden" id="live" name="live" value="live">
                    <input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url; ?>">

                    <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source type="application/x-mpegURL" src="<?php echo $video->mp4_url; ?>">
                    </video>

                    <?php }elseif(!empty($video->url_type == "Encode_video")){  ?>

                    <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->hls_url; ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
                    <input type="hidden" id="live" name="live" value="live">
                    <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

                    <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source type="application/x-mpegURL" src="<?php echo $video->hls_url; ?>">
                    </video>

                    <?php  }elseif(!empty($video->url_type ) && $video->url_type == "live_stream_video"){  ?>

                    <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
                    <input type="hidden" id="live" name="live" value="live">
                    <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

                    <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source type="application/x-mpegURL" src="<?php echo $video->live_stream_video; ?>">
                    </video>

                    <?php  }elseif(!empty($video->url_type ) && $video->url_type == "acc_audio_url"){  ?>

                    <video id="acc_audio" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source src="<?php echo $video->acc_audio_url; ?>">
                    </video>

                    <?php  }elseif(!empty($video->url_type ) && $video->url_type == "acc_audio_file"){  ?>

                    <video id="acc_audio" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source src="<?php echo $video->acc_audio_file; ?>">
                    </video>

                    <?php  }elseif(!empty($video->url_type ) && $video->url_type == "aws_m3u8"){  ?>

                    <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo $video->type; ?>">
                    <input type="hidden" id="live" name="live" value="live">
                    <input type="hidden" id="request_url" name="request_url" value="<?php echo 'm3u8'; ?>">

                    <video id="live_player" <?= $autoplay ?> controls crossorigin playsinline
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls
                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                        <source type="application/x-mpegURL" src="<?php echo $video->hls_url; ?>">
                    </video>

                    <?php }elseif(!empty($video->url_type ) && $video->url_type == "m3u_url"){   ?>

                    <div class="container-fluid">
                        <div class="row ">
                            <div class="col-lg-9">

                                <?php $m3u_url = session('m3u_url_link'); ?>

                                <video controls <?= $autoplay ?> crossorigin playsinline
                                    poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                                    <source type="application/x-mpegURL" src="<?php echo $m3u_url; ?>">
                                </video>
                            </div>

                            <div class="col-lg-3 p-0">
                                <div class="border-end" id="sidebar-wrapper">
                                    <div class="sidebar-heading border-bottom">Channels</div>
                                    <div class="list-group list-group-flush">
                                        <?php foreach( $M3U_channels as $M3U_index => $M3U_channel ){ ?>
                                        <a data-toggle="modal" data-target="#M3U-url-modal"
                                            data-MU3-category="<?= $M3U_index ?>" data-MU3-url="<?= $M3U_files ?>"
                                            class="list-group-item list-group-item-action list-group-item-light"
                                            onclick="m3u_url(this)"> <?= $M3U_index ?> </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal - M3U Modal  -->

                    <div class="modal fade  come-from-modal right" id="M3U-url-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="background:#1B1212;">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel"> Channel Category </h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>

                                <div class="modal-body data-plans ">
                                    <div class="list-group list-group-flush"
                                        style="height: calc(100vh - 80px - 75px)!important;">
                                        <p> <?= 'Please wait a short while' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                    <?php  } else { ?>
                    <div
                        id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                        <div id="video_bg_dim" <?php if (($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?>
                            class="darker"<?php endif; ?>></div>
                        <div class="row justify-content-center pay-live">
                            <div class="col-md-4 col-sm-offset-4">
                                <div class="ppv-block">
                                    <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>
                                    <div class="clear"></div>
                                    <?php if(Auth::guest()){ ?>
                                    <a href="<?php echo URL::to('/login'); ?>"><button class="btn btn-primary btn-block">Purchase
                                            For Pay <?php echo $currency->symbol . ' ' . $video->ppv_price; ?></button></a>
                                    <?php }else{ ?>
                                    <button class="btn btn-primary btn-block"
                                        onclick="pay(<?php echo $video->ppv_price; ?>)">Purchase For Pay
                                        <?php echo $currency->symbol . ' ' . $video->ppv_price; ?></button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
    }
    } elseif(!empty($new_date)){ ?>
                    <div
                        id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                        <h2> COMING SOON </h2>
                        <p class="countdown" id="demo"></p>
                    </div>
                    <?php }
    ?>

                    <input type="hidden" class="videocategoryid"
                        data-videocategoryid="<?= $video->video_category_id ?>"
                        value="<?= $video->video_category_id ?>">

                    <div class="container-fluid video-details">
                        <div class="row">

                                                <!-- BREADCRUMBS -->
                            <div class="col-sm-12 col-md-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="bc-icons-2">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a class="black-text" href="<?= route('liveList') ?>"><?= ucwords('Livestreams') ?></a>
                                                <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                                </li>

                                                <?php foreach ($category_name as $key => $video_category_name) { ?>
                                                <?php $category_name_length = count($category_name); ?>
                                                <li class="breadcrumb-item">
                                                    <a class="black-text" href="<?= route('LiveCategory',[ $video_category_name->categories_slug ])?>">
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

                            <div class="col-sm-9 col-md-9 col-xs-12">
                                <h1 class="trending-text big-title text-uppercase mt-3"><?php echo __($video->title); ?>
                                    <?php if( Auth::guest() ) { ?> <?php } ?></h1>
                                <!-- Category -->
                                <ul class="p-0 list-inline d-flex align-items-center movie-content">
                                    <li class="text-white">
                                        <?//= $videocategory ;?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class=" d-flex mt-4 pull-right">
                                    <div class="views">
                                        <span class="view-count"><i class="fa fa-eye"></i>
                                            <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?>
                                            <?php echo __('Views'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Year, Running time, Age -->
                        <?php
                        if (!empty($video->publish_time)) {
                            $originalDate = $video->publish_time;
                            $publishdate = date('d F Y', strtotime($originalDate));
                        } else {
                            $originalDate = $video->created_at;
                            $publishdate = date('d F Y', strtotime($originalDate));
                        }
                        ?>
                        <div class=" align-items-center text-white text-detail container-fluid">
                            <span class="badge badge-secondary p-2"><?php echo __(@$video->languages->name); ?></span>
                            <span class="badge badge-secondary p-2"><?php echo __(@$video->categories->name); ?></span>
                            <span class="badge badge-secondary p-2">Published On : <?php echo $publishdate; ?></span>
                            <span class="badge badge-secondary p-2"><?php echo __($video->age_restrict); ?></span>

                       

                        <?php if(!Auth::guest()) { ?>
                        <div class="row container-fluid">
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                    <!-- Social Share, Like Dislike -->
                                    <?php include 'partials/live-social-share.php'; ?>
                                </ul>
                            </div>

                            <!--                    <div class="col-sm-6 col-md-6 col-xs-12">-->
                            <!--
                  <div class="d-flex align-items-center series mb-4">
                     <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                           alt=""></a>
                     <span class="text-gold ml-3">#2 in Series Today</span>
                  </div>
-->
                            <!--                        <ul class="list-inline p-0 mt-4 rental-lists">-->
                            <!-- Subscribe -->
                            <!--
                    <li>
                        <?php     
                            $user = Auth::user(); 
                            if (  ($user->role!="subscriber" && $user->role!="admin") ) { ?>
                                <a href="<?php echo URL::to('/becomesubscriber'); ?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?> </span></a>
                        <?php } ?>
                    </li>
-->

                            </ul>
                        </div>

                    </div>

                    <?php } ?>

                    <?php if(Auth::guest()) { ?>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                                <!-- Social Share, Like Dislike -->
                                <?php include 'partials/live-social-share.php'; ?>
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
                                <?php if ($video->access == 'subscriber' ) { ?>

                                <li>
                                    <a href="<?php echo URL::to('/login'); ?>"><span
                                            class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?>
                                        </span></a>
                                </li>
                                <?php } ?>
                                <!-- PPV button -->
                                <?php if ($video->access != 'guest' ) { ?>
                                <li>
                                    <a data-toggle="modal" data-target="#exampleModalCenter"
                                        class="view-count btn btn-primary rent-video" href="<?php echo URL::to('/login'); ?>">
                                        <?php echo __('Rent'); ?> </a>
                                </li>
                                <?php   }?>

                            </ul>
                        </div>
                    </div></div></div>
                    <?php   }?>
                    <div class="container-fluid">
                        <div class="text-white col-md-6 p-0">
                            <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="video-details-container">
                                <?php if (!empty($video->details)) { ?>
                                <h6 class="mt-3 mb-1">Live Details</h6>
                                <p class="trending-dec w-100 mb-3 text-white"><?= $video->details ?></p>
                                <?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('livestream')->first() == 1 ): ?>
                <div class="row">
                    <div class=" container-fluid video-list you-may-like overflow-hidden">
                        <h4 class="" style="color:#fffff;"><?php echo __('Comments'); ?></h4>
                        <?php include 'comments/index.blade.php'; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class=" container-fluid video-list you-may-like overflow-hidden">
                        <h4 class="" style="color:#fffff;"><?php echo __('Related Videos'); ?></h4>
                        <div class="slider">
                            <?php include 'partials/live_related_video.blade.php'; ?>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:black">Rent
                                Now</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <div class="modal-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-4 p-0" style="">
                                    <img class="img__img w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->image; ?>" class="img-fluid"
                                        alt="">
                                </div>

                                <div class="col-sm-8">
                                    <h4 class=" text-black movie mb-3"><?php echo __($video->title); ?> , <span
                                            class="trending-year mt-2"><?php if ($video->year == 0) {
                                                echo '';
                                            } else {
                                                echo $video->year;
                                            } ?></span></h4>
                                    <span class="badge badge-secondary   mb-2"><?php echo __($video->age_restrict) . ' ' . '+'; ?></span>
                                    <span class="badge badge-secondary  mb-2 ml-1"><?php echo __($video->duration); ?></span><br>

                                    <a type="button" class="mb-3 mt-3" data-dismiss="modal"
                                        style="font-weight:400;">Amount: <span class="pl-2"
                                            style="font-size:20px;font-weight:700;">
                                            <?php echo __($currency->symbol . ' ' . $video->ppv_price); ?></span></a><br>
                                    <label class="mb-0 mt-3 p-0" for="method">
                                        <h5 style="font-size:20px;line-height: 23px;"
                                            class="font-weight-bold text-black mb-2">Payment Method : </h5>
                                    </label>

                                    <!-- Stripe Button -->
                                    <?php if( $stripe_payment_setting != null && $stripe_payment_setting->payment_type == "Stripe" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="tres_important" checked
                                            name="payment_method" value=<?= $stripe_payment_setting->payment_type ?>
                                            data-value="stripe">
                                        <?php echo $stripe_payment_setting->payment_type; ?>
                                    </label>
                                    <?php } ?>


                                    <!-- Razorpay Button -->
                                    <?php if( $Razorpay_payment_setting != null && $Razorpay_payment_setting->payment_type == "Razorpay" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="important"
                                            name="payment_method"
                                            value="<?= $Razorpay_payment_setting->payment_type ?>"
                                            data-value="Razorpay">
                                        <?php echo $Razorpay_payment_setting->payment_type; ?>
                                    </label>
                                    <?php } ?>

                                    <!-- Paystack Button -->
                                    <?php if( $Paystack_payment_setting != null && $Paystack_payment_setting->payment_type == "Paystack" ){?>
                                    <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id=""
                                            name="payment_method"
                                            value="<?= $Paystack_payment_setting->payment_type ?>"
                                            data-value="Paystack">
                                        <?php echo $Paystack_payment_setting->payment_type; ?>
                                    </label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">

                            <div class="Stripe_button">
                                <!-- Stripe Button -->
                                <button class="btn2  btn-outline-primary" onclick="pay(<?php echo $video->ppv_price; ?>)">
                                    Continue </button>
                            </div>

                            <div class="Razorpay_button">
                                <!-- Razorpay Button -->
                                <?php if( $Razorpay_payment_setting != null && $Razorpay_payment_setting->payment_type == "Razorpay" ){?>
                                <button class="btn2  btn-outline-primary "
                                    onclick="location.href ='<?= URL::to('RazorpayLiveRent/' . $video->id . '/' . $video->ppv_price) ?>' ;">
                                    Continue </button>
                                <?php } ?>
                            </div>

                            <?php if( $video->ppv_price != null &&  $video->ppv_price != " " ) {?>
                            <div class="paystack_button">
                                <!-- Paystack Button -->
                                <?php if( $Paystack_payment_setting != null && $Paystack_payment_setting->payment_type == "Paystack" ){?>
                                <button class="btn2  btn-outline-primary"
                                    onclick="location.href ='<?= route('Paystack_live_Rent', ['live_id' => $video->id, 'amount' => $video->ppv_price]) ?>' ;">
                                    Continue </button>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($videonext)) { ?>
            <div class="next_video" style="display: none;"><?= $videonext->slug ?></div>
            <div class="next_url" style="display: none;"><?= $url ?></div>
            <?php } elseif (isset($videoprev)) { ?>
            <div class="prev_video" style="display: none;"><?= $videoprev->slug ?></div>
            <div class="next_url" style="display: none;"><?= $url ?></div>
            <?php } ?>

            <?php if (isset($videos_category_next)) { ?>
            <div class="next_cat_video" style="display: none;"><?= $videos_category_next->slug ?></div>
            <?php } elseif (isset($videos_category_prev)) { ?>
            <div class="prev_cat_video" style="display: none;"><?= $videos_category_prev->slug ?></div>
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
<!--<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js' ?>"></script>-->
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

<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


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
        document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

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
</script>

<script>
    window.onload = function() {
        $('.Razorpay_button,.paystack_button').hide();
    }

    $(document).ready(function() {

        $(".payment_btn").click(function() {

            $('.Razorpay_button,.Stripe_button,.paystack_button').hide();

            let payment_gateway = $('input[name="payment_method"]:checked').val();

            if (payment_gateway == "Stripe") {

                $('.Stripe_button').show();
                $('.Razorpay_button,.paystack_button').hide();

            } else if (payment_gateway == "Razorpay") {

                $('.paystack_button,.Stripe_button').hide();
                $('.Razorpay_button').show();

            } else if (payment_gateway == "Paystack") {

                $('.Stripe_button,.Razorpay_button').hide();
                $('.paystack_button').show();
            }
        });
    });
</script>

<?php
include 'm3u_file_live.blade.php';
include 'footer.blade.php';
?>
