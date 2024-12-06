<?php
$Livestream_detail = $Livestream_details;
$Radio_station_lists = $Radio_station_lists;
// dd($Radio_station_lists);
?>
<style type="text/css">
    #myProgress {
        background-color: #8b0000;
        cursor: pointer;
        border-radius: 10px;
    }

    #myBar {
        width: 0%;
        height: 3px;
        background-color: red;
        border-radius: 10px;
    }

    .title {
        text-align: left !important;
        color: #fff;
    }

    .logo {
        fill: red;
    }

    .play-border {
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        padding: 10px;
        border-width: 2px;
    }

    .btn-action {
        cursor: pointer;
        padding-top: 10px;
        width: 30px;
    }

    .btn-ctn,
    .infos-ctn {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .infos-ctn {
        padding-top: 20px;
    }

    .btn-ctn>div {
        padding: 5px;
        margin-top: 18px;
        margin-bottom: 18px;
    }

    .infos-ctn>div {
        margin-bottom: 8px;
        color: rgb(0, 82, 204);
        text-align: left;
    }

    .first-btn {
        margin-left: 3px;
    }

    .duration {
        margin-left: 10px;
    }

    .title {
        /*margin-left: 10px;
text-align: center;
border-top:1px solid rgba(255, 255, 255,0.1)*/
    }

    .player-ctn {
        padding: 25px;
        /*background: linear-gradient(180deg, #151517 127.69%, #282834 0% );*/
        box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
        margin: auto;
        border-radius: 10px;
    }

    .playlist-track-ctn {
        display: flex;
        padding-left: 10px;
        background-color: #464646;
        margin-top: 3px;
        margin-right: 10px;
        border-radius: 5px;
        cursor: pointer;
        align-items: center;
    }

    .playlist-track-ctn:last-child {
        /*border: 1px solid #ffc266; */
    }

    .playlist-track-ctn>div {
        margin: 5px;
        color: #fff;
    }

    .playlist-info-track {
        width: 80%;
        padding: 2px;
    }

    .playlist-info-track,
    .playlist-duration {
        /*padding-top: 7px;
padding-bottom: 7px;*/
        color: #e9cc95;
        font-size: 14px;
        pointer-events: none;
    }

    .playlist-ctn {}

    .playlist-ctn::-webkit-scrollbar {
        width: 2px;
    }

    .playlist-ctn::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.2);
    }

    .playlist-ctn::-webkit-scrollbar-thumb {
        background-color: red;
        border-radius: 2px;
        border: 2px solid red;
        width: 2px;
    }

    .playlist-ctn {
        padding-bottom: 20px;
        overflow: scroll;
        scroll-behavior: auto;
        max-height: 335px;
        scrollbar-color: rebeccapurple green !important;
        overflow-x: hidden;
    }

    .active-track {
        background: #4d4d4d;
        color: #ffc266 !important;
        font-weight: bold;
    }

    label {
        color: #000;
    }

    .active-track>.playlist-info-track,
    .active-track>.playlist-duration,
    .active-track>.playlist-btn-play {
        color: #ffc266 !important;
    }

    .form-control {
        color: #000 !important;
        font-weight: 700;
        border-radius: 5px;
    }

    .playlist-btn-play {
        color: #fff !important;
        pointer-events: none;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .fas {
        color: rgb(255, 0, 0);
        font-size: 20px;
    }

    .audio-js *,
    .audio-js :after,
    .audio-js :before {
        box-sizing: inherit;
        display: grid;
    }

    .vjs-big-play-button {
        margin: -25px 0 0 -25px;
        width: 50px !important;
        height: 50px !important;
        border-radius: 25px !important;
    }

    .vjs-texttrack-settings {
        display: none;
    }

    .audio-js .vjs-big-play-button {
        border: none !important;
    }

    .bd {
        padding: 10px 15px;
        background: #ed563c !important;
    }

    .bd:hover {}

    th,
    td {
        padding: 10px;
        color: #fff !important;
    }

    tr {
        border: #141414;
    }

    p {
        color: #fff;
    }

    .img-responsive {
        border-radius: 10px;
    }

    .fa-heart {
        color: red !important;
    }

    .flexlink {
        position: relative;
        top: 63px;
        left: -121px;
    }

    #ff {
        border: 2px solid #fff;
        border-radius: 50%;
        padding: 10px;
        font-size: 16px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .audio-lp {
        background: linear-gradient(180deg, #151517 127.69%, #282834 0%);
        padding: 33px;
        border-radius: 25px;
    }

    .audio-lpk:hover {
        background-color: #1414;
        color: #fff;
        border: 1px #e9ecef;
        border-radius: .25rem;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .aud-lp {
        border-bottom: 1px solid #141414;
    }

    .play-button {
        position: absolute;
        z-index: 10;
        top: 46%;
        left: 99px;
        transform: translateY(-50%);
        display: block;
        padding-left: 5px;
        text-align: center;
    }

    #circle {
        border-radius: 50%;
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

    ul.share-icon-aud li {
        display: inline-block;
        padding: 0 6px;
    }

    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }
    
    @media(max-width: 767px) {
        ul.share-icon-aud li {
            padding: 5px 2px;
        }
    }
</style>
<?php if (Session::has('message')): ?>
<div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;">
    <?php echo Session::get('message'); ?></div>
<?php endif ;?>

<?php if (isset($error)) { ?>
<div class="col-md-12 text-center mt-4"
    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;">
    <p>
    <h3 class="text-center"><?php echo $message; ?></h3>
</div>
<?php } else { ?>

<input type="hidden" value="<?php echo URL('/'); ?>" id="base_url">
<div id="audio_bg">
    <div id="audio_bg_dim" <?php if($Livestream_detail->access == 'guest' || ($Livestream_detail->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
    <div class="container-fluid">
        <?php if($Livestream_detail->access == 'guest' || ( ($Livestream_detail->access == 'subscriber' || $Livestream_detail->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $Livestream_detail->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') || (($Livestream_detail->access == 'subscriber' || $Livestream_detail->access == 'registered') && $ppv_status == 1)): ?>
        <?php if($Livestream_detail): ?>
        <?php if (  !Auth::guest() && $Livestream_detail->ppv_status == 1 && $settings->ppv_status == 1 && $ppv_status == 0 && Auth::user()->role != 'admin' ) { ?>
        <div id="subscribers_only">
            <a class="text-center btn btn-success" id="paynowbutton"> Pay for View </a>
        </div>
        <?php } else { ?>
        <div class="row album-top-30 mt-4 ">
            <div class="col-lg-8">
                <div class="player-ctn" id="player-ctn"
                    style="background-image:linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1)),url('<?= URL::to('/') . '/public/uploads/images/' . $Livestream_detail->player_image ?>');background-size: cover;background-repeat: no-repeat;background-position: right;">
                    <div class="row align-items-center">
                        <div class="col-sm-3 col-md-3 col-xs-3 ">
                            <img height="150" width="150" id="audio_img" src="">
                        </div>
                        <div class="col-sm-9 col-md-9 col-xs-9">
                            <div class="album_bg">
                                <div class="album_container">
                                    <div class="blur"></div>
                                    <div class="overlay_blur">
                                        <h2 class="hero-title album">
                                            <div class="title"></div>
                                        </h2>
                                        <p class="mt-2">Music by <?php echo get_audio_artist($Livestream_detail->id); ?></p>
                                        </p>
                                        <div class="d-flex"
                                            style="justify-content: space-between;width: auto;align-items: center;">
                                            <ul class="p-0 share-icon-aud">
                                                <li>
                                                    <div onclick="toggleAudio()">
                                                        <button class="btn bd btn-action" id="vidbutton"
                                                            style="width:100%;"><i class="fa fa-play mr-2"
                                                                aria-hidden="true"></i> Play</button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a aria-hidden="true" class="favorite <?php echo audiofavorite($Livestream_detail->id); ?>"
                                                        data-authenticated="<?= !Auth::guest() ?>"
                                                        data-audio_id="<?= $Livestream_detail->id ?>"><?php if(audiofavorite($Livestream_detail->id) == "active"): ?><i
                                                            id="ff"
                                                            class="fa fa-heart"></i><?php else: ?><i
                                                            id="ff"
                                                            class="fa fa-heart-o"></i><?php endif; ?></a>
                                                </li>
                                                <li>
                                                    <div class="dropdown">
                                                        <i id="ff" class="fa fa-share-alt " type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"></i>

                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <?php if(!Auth::guest()){ ?>
                                                        <button type="button" style="width:100%;"
                                                            class="btn bd btn-primary" data-toggle="modal"
                                                            data-target="#exampleModal">
                                                            Create PlayList
                                                        </button>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Share -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="infos-ctn d-flex justify-space-between">
                        <?php /*{ ?> ?> ?> <img
                            src="<?= URL::to('/') . '/public/uploads/images/' . $Livestream_detail->image ?>"
                            class="img-responsive mb-2" / width="100">
                        <?php } */?>
                    </div>
                    <div id="myProgress">
                        <div id="myBar"></div>
                    </div>
                    <div class="d-flex justify-content-between text-white">
                        <div class="timer">00:00</div>
                        <div class="duration">00:00</div>
                    </div>
                    <div class="btn-ctn">
                        <div class="btn-action first-btn" onclick="previous()">
                            <div id="btn-faws-back">
                                <i class='fas fa-step-backward'></i>
                            </div>
                        </div>
                        <div class="btn-action" onclick="rewind()">
                            <div id="btn-faws-rewind">
                                <i class='fas fa-backward'></i>
                            </div>
                        </div>
                        <div class="btn-action" onclick="toggleAudio()">
                            <div id="btn-faws-play-pause">
                                <i class='fas fa-play' id="icon-play"></i>
                                <i class='fas fa-pause' id="icon-pause" style="display: none"></i>
                            </div>
                        </div>
                        <div class="btn-play" onclick="forward()">
                            <div id="btn-faws-forward">
                                <i class='fas fa-forward'></i>
                            </div>
                        </div>
                        <div class="btn-action" onclick="next()">
                            <div id="btn-faws-next">
                                <i class='fas fa-step-forward'></i>
                            </div>
                        </div>
                        <div class="btn-mute" id="toggleMute" onclick="toggleMute()">
                            <div id="btn-faws-volume">
                                <i id="icon-vol-up" class='fas fa-volume-up'></i>
                                <i id="icon-vol-mute" class='fas fa-volume-mute' style="display: none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="title"></div>
                </div>
                
            </div>
            <div class="col-lg-4 p-0">
                <audio id="myAudio" ontimeupdate="onTimeUpdate()">
                    <source id="source-audio" src="" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <div class="play-border">
                    <div class="playlist-ctn">
                        <h6 class="mb-2 font-weight-bold">AUDIO LIST <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="clear"></div>
<?php } ?>
<!-- Playlist  -->
<div class="container-fluid">
</div>
<!-- Modal -->
<?php
include public_path('themes/theme5-nemisha/views/radio-modal.blade.php');
?>


<div class="container-fluid">
    <?php endif; ?>
    <div class="">
        <?php else: ?>
        <div id="subscribers_only">
            <h2>Sorry, this audio is only available to <?php if($Livestream_detail->access == 'subscriber'): ?>Subscribers<?php elseif($Livestream_detail->access == 'registered'): ?>Registered
                Users<?php endif; ?></h2>
            <div class="clear"></div>
            <?php if(!Auth::guest() && $Livestream_detail->access == 'subscriber'): ?>
            <form method="get" action="/user/<?= Auth::user()->username ?>/upgrade_subscription">
                <button id="button">Become a subscriber to watch this audio</button>
            </form>
            <?php else: ?>
            <form method="get" action="/signup">
                <button id="button">Signup Now <?php if($Livestream_detail->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($Livestream_detail->access == 'registered'): ?>for
                    Free!<?php endif; ?></button>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
<?php } ?>
</div>

<?php
include public_path('themes/theme5-nemisha/views/radio-player-script.blade.php');
?>