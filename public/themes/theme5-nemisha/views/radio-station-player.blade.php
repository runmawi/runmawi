<?php
$Livestream_detail = $Livestream_details;
$radio_station_url = URL::to('/radio-station');
$media_url = $radio_station_url . '/' . $Livestream_detail->slug;
?>
<style type="text/css">

    body {
    background-color: #000;
    transition: background-color 0.5s ease;
    }

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
        height:100%;
        overflow: hidden;
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
        justify-content: center;
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


    .playlist-ctn {
        padding-bottom: 20px;
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

    @media(max-width: 767px) {
        ul.share-icon-aud li {
            padding: 5px 2px;
        }
    }


    .hidden {
    display: none !important;
}

.icon-circle {
    background-color: #ED563C;
    padding: 13px;
    border-radius: 50%;
    color: white;
    font-size: 15px;
    display: inline-block; 
}

.icon-mute {
    background-color: #ED563C;
    padding: 10px;
    border-radius: 50%;
    color: white;
    font-size: 15px;
    display: inline-block; 
}


.play-radio{
    background-color: #ED563C;
    color: white;
    margin-top: 10px;
}


.show-more-btn {
        all: unset; 
        display: inline-block; 
        color: white;
        text-align: center; 
        cursor: pointer; 
        font-size: 14px;
        text-decoration: underline;
        transition: background-color 0.3s ease; 
    }


    .modal{
        right: 0;
    }

    @media (min-width: 576px) {
        #Epg_schedule_modal .modal-dialog {
            max-width: 100%;
        }
    }

    #Epg_schedule_modal .modal-content {
    background-color: transparent;
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
        <div class="row album-top-30 my-4 ">
            <div class="col-lg-8">
                <div class="player-ctn" id="player-ctn"
                    style="background-image:linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1)),url('<?= URL::to('/') . '/public/uploads/images/' . $Livestream_detail->player_image ?>');background-size: cover;background-repeat: no-repeat;background-position: right;">
                    <div class="row">
                        <div class="col-sm-3 col-md-3 col-xs-3 ">
                            <img height="150" width="150" id="audio_img" >
                            <div onclick="toggleAudio()">
                                <button class="btn btn-action play-radio" id="vidbutton"
                                    style="width:85%;"><i class="fa fa-play "
                                        aria-hidden="true"></i> Play</button>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-9 col-xs-9">
                            <div class="album_bg">
                                <div class="album_container">
                                    <div class="blur"></div>
                                    <div class="overlay_blur">
                                        <div class="row justify-content-between" style="padding:0px 12px;" >
                                            <div class="">
                                                <h2 class="hero-title album">
                                                    <div class="title"></div>
                                                </h2>
                                            </div>
                                            <div class="">
                                                <div class="btn-mute" id="toggleMute" onclick="toggleMute()">
                                                    <div id="btn-faws-volume">
                                                        <i id="icon-vol-up" class='fas fa-volume-up icon-mute'></i>
                                                        <i id="icon-vol-mute" class='fas fa-volume-mute icon-mute' style="display: none"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="">
                                            <div class="description"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="infos-ctn d-flex justify-space-between">
                        
                    </div>
                    <div id="myProgress">
                        <div id="myBar"></div>
                    </div>
                   
                    <div class="btn-ctn">
                       
                        <div class="d-flex"
                        style="justify-content: space-between;width: auto;align-items: center;">
                        <ul class="p-0 share-icon-aud">
                           <li>
                            <div class="btn-action" style="padding:0px 40px;" id="vidbutton" onclick="toggleAudio()">
                                <div id="btn-faws-play-pause">
                                    <i class='fas fa-play icon-circle' id="icon-play"></i>
                                    <i class='fas fa-pause icon-circle hidden' id="icon-pause"></i>
                                </div>
                            </div>
                           </li>
                            <li>
                                <a aria-hidden="true" 
                                class="favorite <?php echo audiofavorite($Livestream_detail->id); ?>" 
                                data-authenticated="<?= !Auth::guest() ?>" 
                                data-audio_id="<?= $Livestream_detail->id ?>"
                                onclick="toggleFavorite(this)">
                                 <?php if(audiofavorite($Livestream_detail->id) == "active"): ?>
                                     <i id="ff" class="fa fa-heart"></i>
                                 <?php else: ?>
                                     <i id="ff" class="fa fa-heart-o"></i>
                                 <?php endif; ?>
                             </a>
                            </li>
                            <li>
                                <div class="dropdown">
                                   <i id="ff" class="fa fa-share-alt " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"  style="background-color: white;border:1px solid white;padding: 0;">
                                      <a class="dropdown-item popup" href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" target="_blank">
                                      <i class="fa fa-twitter" style="color: #00acee;padding: 10px 5px;border-radius: 50%;display: inline;"></i> Twitter
                                      </a>
                                      <div class="divider" style="border:1px solid white"></div>
                                      <a class="dropdown-item popup" href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" target="_blank"><i class="fa fa-facebook" style="color: #3b5998;padding: 10px 5px;border-radius: 50%;display: inline;"></i> Facebook</a>
                                   </div>
                                </div>
                             </li>                                        
                        </ul>
                        <!-- Share -->
                    </div>
                    </div>
                    <div class="title"></div>
                </div>
        
            </div>
            <div class="col-lg-4 p-0">
                <audio id="myAudio" ontimeupdate="onTimeUpdate()">
                    <source id="source-audio" src="" type="<?= $Livestream_details->livestream_player_type ?>" >
                    Your browser does not support the audio element.
                </audio>
                <div class="play-border" style="margin: 0px; 10px;" >
                    <div class="playlist-ctn">
                        
                        <div class="row align-items-center pt-1">
                            <div class="col-12 col-md-6 mb-4">
                                <h6 class="mb-0 font-weight-bold">
                                    <span class="program-name"></span> 
                                    <i class="fa fa-music" aria-hidden="true"></i>
                                </h6>
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <div class="moreinfo text-md-right">
                                    <button 
                                        type="button" 
                                        class="btn btn-primary w-100" 
                                        data-toggle="modal" 
                                        data-target="#Epg_schedule_modal"  
                                        data-live-id="<?php echo $Livestream_detail->id; ?>"> 
                                        VIEW SCHEDULE
                                    </button>
                                </div>
                            </div>
                        </div>

                       
                        <?php if ($Livestream_detail->publish_type == 'publish_now' || $Livestream_detail->publish_type == 'publish_later'): ?>
                            <h6 class="mb-2 font-weight-bold">Current Program</h6>
                            <p>
                                <?php echo $Livestream_detail->title; ?>
                            </p>
                        <?php elseif ($Livestream_detail->publish_type == 'schedule_program'): ?>
                            <h6 class="mb-2 font-weight-bold">Current Program</h6>
                            <p>
                                <span id="current-program"></span>
                            </p>

                            <h6 class="mb-2 font-weight-bold">Next Program</h6>
                            <p>
                                <span id="next-program"></span>
                            </p>
                        <?php endif; ?>

                    

                       
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

<?php if ($Livestream_detail->stream_upload_via == 'radio_station') { ?>
    <div class="container">
    <div class="row">
        <div class=" container-fluid video-list you-may-like overflow-hidden">
            <h4 class="" style="color:#fffff;"><?php echo __('Other Radio Station'); ?></h4>
            <div class="slider">
                <?php
                    include public_path(
                        'themes/theme5-nemisha/views/partials/related-radio-station.blade.php',
                    );
                ?>
            </div>
        </div>
    </div>
    </div>
<?php }?>



<script type="text/javascript">
    $('#store-play-list').click(function(){
                    $('#my-playlist-form').submit();
                });
    
    var base_url = $('#base_url').val();
    
    $(document).ready(function(){
    
    
    //watchlater
    $('.watchlater').click(function(){
    if($(this).data('authenticated')){
    $.post('<?= URL::to('watchlater') ?>', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    $(this).toggleClass('active');
    $(this).html("");
    if($(this).hasClass('active')){
    $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
    }else{
    $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
    }
    
    } else {
    window.location = '<?= URL::to('login') ?>';
    }
    });
    
    
    //My Wishlist
    $('.mywishlist').click(function(){
    if($(this).data('authenticated')){
    $.post('<?= URL::to('mywishlist') ?>', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    $(this).toggleClass('active');
    $(this).html("");
    if($(this).hasClass('active')){
    $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
    }else{
    $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
    }
    
    } else {
    window.location = '<?= URL::to('login') ?>';
    }
    });
    
    });
    
 </script>
<script type="text/javascript">
    function toggleFavorite(element) {
      if ($(element).data('authenticated')) {
        const audioId = $(element).data('audio_id');
        const isActive = $(element).hasClass('active');
        if (isActive) {
          $.post('<?= URL::to('radio-favorite') ?>', { audio_id: audioId, _token: '<?= csrf_token(); ?>' }, function(data) {
          });
          $(element).removeClass('active');
          $(element).html('<i class="fa fa-heart-o"></i>');
        } else {
          $.post('<?= URL::to('radio-favorite') ?>', { audio_id: audioId, _token: '<?= csrf_token(); ?>' }, function(data) {
          });
          $(element).addClass('active');
          $(element).html('<i class="fa fa-heart"></i>');
        }
      } else {
        window.location = '<?= URL::to('login') ?>';
      }
    }
  </script>
  
  
 <script>
    function createTrackItem(index,name,duration,liveId){
    
      var trackItem = document.createElement('div');
      trackItem.setAttribute("id", "ptc-"+index);
      trackItem.setAttribute("data-index", index);
      document.querySelector(".playlist-ctn").appendChild(trackItem);
    
      var playBtnItem = document.createElement('div');

      var moreInfoBtn = document.createElement('button');
      document.querySelector("#ptc-" + index).appendChild(moreInfoBtn);
      moreInfoBtn.setAttribute("style", "display: none;"); // Hide the button

        moreInfoBtn.addEventListener('click', function () {
            const liveId = this.getAttribute('data-live-id');
            loadEpgContent(liveId); 
        });



    }

    function loadEpgContent(liveId) {
        $('#modal-content').html('<p>Loading...</p>');

        $.ajax({
            url: "<?php echo url('/get-epg-content'); ?>",
            method: 'GET',
            data: { live_id: liveId }, 
            success: function (response) {
                $('#modal-content').html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error); 
                $('#modal-content').html('<p>Error loading content. Please try again.</p>');
            }
        });
    }

    
    var listAudio = <?php echo json_encode($Radio_station_lists); ?>;

    listAudio = listAudio.filter(function(item) {
        return !item.embed_url; 
    });

    for (var i = 0; i < listAudio.length; i++) {
        createTrackItem(i, listAudio[i].title, listAudio[i].duration, listAudio[i].id);
    }
    
    
    var indexAudio = 0;

    function getCurrentProgram(index) {
        try {
            if (listAudio[index].publish_type === "schedule_program") {
                var startTimes = JSON.parse(listAudio[index].scheduler_program_start_time);
                var endTimes = JSON.parse(listAudio[index].scheduler_program_end_time);
                var programTitles = JSON.parse(listAudio[index].scheduler_program_title);

                if (!startTimes.length || !endTimes.length || !programTitles.length) {
                    return "No schedule available.";
                }

                var currentTime = new Date();

                for (var i = 0; i < startTimes.length; i++) {
                    var [startHour, startMinute] = startTimes[i].split(":").map(Number);
                    var [endHour, endMinute] = endTimes[i].split(":").map(Number);

                    var startDate = new Date(currentTime);
                    var endDate = new Date(currentTime);
                    startDate.setHours(startHour, startMinute, 0, 0);
                    endDate.setHours(endHour, endMinute, 0, 0);
                    if (endDate < startDate) {
                        endDate.setDate(endDate.getDate() + 1);
                    }
                    if (currentTime >= startDate && currentTime <= endDate) {
                        return `${programTitles[i]} (${formatTime(startDate)} - ${formatTime(endDate)})`;
                    }
                }
                    return "No Current Program.";
                } else {
                    return listAudio[index].title;
                }
            } catch (error) {
                console.error("Error parsing schedule data:", error);
                return "Invalid schedule data.";
        }
    }

    function getNextProgram(index) {
        try {
            if (listAudio[index].publish_type === "schedule_program") {
                var startTimes = JSON.parse(listAudio[index].scheduler_program_start_time);
                var programTitles = JSON.parse(listAudio[index].scheduler_program_title);

                if (!startTimes.length || !programTitles.length) {
                    return "No schedule available.";
                }

                var currentTime = new Date();

                for (var i = 0; i < startTimes.length; i++) {
                    var [startHour, startMinute] = startTimes[i].split(":").map(Number);
                    var startDate = new Date(currentTime);
                    startDate.setHours(startHour, startMinute, 0, 0);

                    if (currentTime < startDate) {
                        return `${programTitles[i]} (Starts at ${formatTime(startDate)})`;
                    }
                }

                return "No Next Program.";
            } else {
                return "No Program Scheduled";
            }
        } catch (error) {
            console.error("Error parsing schedule data:", error);
            return "Invalid schedule data.";
        }
    }


     
    function formatTime(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? "PM" : "AM";
        hours = hours % 12 || 12;
        minutes = minutes.toString().padStart(2, "0");
        return `${hours}:${minutes} ${ampm}`;
    }


    function loadNewTrack(index) {
        var player = document.querySelector('#source-audio');
        player.src = listAudio[index].livestream_URL; 
        document.querySelector('.title').innerHTML = listAudio[index].title; 
        document.querySelector('.description').innerHTML = listAudio[index].description; 
        document.querySelector('.program-name').innerHTML = listAudio[index].title; 
        var image = document.querySelector('#audio_img');
        image.src = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].image;
        var divElement = document.getElementById("player-ctn");
        var player_imageURL = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].player_image;
        divElement.style.backgroundImage = "linear-gradient(to left, rgba(0, 0, 0, 0.25) 0%, rgba(117, 19, 93, 1))," + "url('" + player_imageURL + "')";

        this.currentAudio = document.getElementById("myAudio");
        this.currentAudio.load(); 
        this.toggleAudio(); 
        this.updateStylePlaylist(this.indexAudio, index);
        this.indexAudio = index;

        var liveId = listAudio[index].id; 
        loadEpgContent(liveId); 
    }
    
    document.querySelector('#source-audio').src = <?php echo json_encode(@$Livestream_detail->livestream_URL) ; ?>  
    document.querySelector('.title').innerHTML = <?php echo json_encode(@$Livestream_detail->title) ; ?>  
    document.querySelector('.program-name').innerHTML = <?php echo json_encode(@$Livestream_detail->title) ; ?>  

    const descriptionText = <?php echo json_encode(@$Livestream_detail->description); ?> || '-'; 
    const descriptionElement = document.querySelector('.description');
   
    if (!descriptionText.trim() || descriptionText === '-') {
        descriptionElement.innerHTML = ''; 
    } else {
        const charLimit = 250;
        if (descriptionText.length > charLimit) {
            const truncatedText = descriptionText.substring(0, charLimit) + '...';
            descriptionElement.innerHTML = truncatedText;
            const showMoreButton = document.createElement('button');
            showMoreButton.textContent = 'Show More';
            showMoreButton.classList.add('show-more-btn'); 
            descriptionElement.parentElement.appendChild(showMoreButton);
            let isExpanded = false;
            showMoreButton.addEventListener('click', () => {
                isExpanded = !isExpanded;
                descriptionElement.innerHTML = isExpanded ? descriptionText : truncatedText;
                showMoreButton.textContent = isExpanded ? 'Show Less' : 'Show More';
            });
        } else {
            descriptionElement.innerHTML = descriptionText;
        }
    }

    
    var player_images = '<?php echo URL::to('/public/uploads/images/');?>'; 
    var audio_images = player_images +'/' + <?php echo json_encode(@$Livestream_detail->image) ; ?>;
    $("#audio_img").attr('src', audio_images);
    
    var currentAudio = document.getElementById("myAudio");
    currentAudio.load()
    currentAudio.onloadedmetadata = function() {
          document.getElementsByClassName('duration')[0].innerHTML = this.getMinutes(this.currentAudio.duration)
    }.bind(this);

    var interval1;
    
    function toggleAudio() {
        const button = document.querySelector('#vidbutton');
        const playIcon = document.querySelector('#icon-play');
        const pauseIcon = document.querySelector('#icon-pause');

        if (this.currentAudio.paused) {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            button.innerHTML = "<i class='fas fa-pause' style='color: white; font-size:15px'></i> <span style='color: white;'> Pause</span>";
            this.playToPause(this.indexAudio);
            this.currentAudio.play();
        } else {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            button.innerHTML = "<i class='fas fa-play' style='color: white; font-size:15px'></i> <span style='color: white;'> Play</span>";
            this.pauseToPlay(this.indexAudio);
            this.currentAudio.pause();
        }
    }
    
    function pauseAudio() {
      this.currentAudio.pause();
      clearInterval(interval1);
    }
    
    
    
    var width = 0;
    
    function onTimeUpdate() {
      var t = this.currentAudio.currentTime
      this.setBarProgress();
      if (this.currentAudio.ended) {
        document.querySelector('#icon-play').style.display = 'block';
        document.querySelector('#icon-pause').style.display = 'none';
        this.pauseToPlay(this.indexAudio)
        if (this.indexAudio < listAudio.length-1) {
            var index = parseInt(this.indexAudio)+1
            this.loadNewTrack(index)
        }
      }
    }
        
    function getMinutes(t){
      var min = parseInt(parseInt(t)/60);
      var sec = parseInt(t%60);
      if (sec < 10) {
        sec = "0"+sec
      }
      if (min < 10) {
        min = "0"+min
      }
      return min+":"+sec
    }
   
    
    
    function seek(event) {
      var percent = event.offsetX / progressbar.offsetWidth;
      this.currentAudio.currentTime = percent * this.currentAudio.duration;
      barProgress.style.width = percent*100 + "%";
    }
   
    function next(){
      if (this.indexAudio <listAudio.length-1) {
          var oldIndex = this.indexAudio
          this.indexAudio++;
          updateStylePlaylist(oldIndex,this.indexAudio)
          this.loadNewTrack(this.indexAudio);
      }
    }
    
    function previous(){
      if (this.indexAudio>0) {
          var oldIndex = this.indexAudio
          this.indexAudio--;
          updateStylePlaylist(oldIndex,this.indexAudio)
          this.loadNewTrack(this.indexAudio);
      }
    }
    
    function updateStylePlaylist(oldIndex,newIndex){
      this.pauseToPlay(oldIndex);
      this.playToPause(newIndex)
    }
    
    function playToPause(index){
      var ele = document.querySelector('#p-img-'+index)
   
    }
    
    function pauseToPlay(index){
      var ele = document.querySelector('#p-img-'+index)
    
    }
    
    
    function toggleMute(){
      var btnMute = document.querySelector('#toggleMute');
      var volUp = document.querySelector('#icon-vol-up');
      var volMute = document.querySelector('#icon-vol-mute');
      if (this.currentAudio.muted == false) {
         this.currentAudio.muted = true
         volUp.style.display = "none"
         volMute.style.display = "block"
      }else{
        this.currentAudio.muted = false
        volMute.style.display = "none"
        volUp.style.display = "block"
      }
    }
      
 </script>

 <script>
    var LivestreamDetail = <?php echo json_encode($Livestream_detail); ?>;
    console.log(LivestreamDetail);

    function getProgramDetails() {    
        try {
            var startTimes = LivestreamDetail.epg_program_start_time;
            var endTimes = LivestreamDetail.epg_program_end_time;
            var programTitles = LivestreamDetail.epg_program_title;
            var scheduledDays = LivestreamDetail.scheduler_program_days;
            var currentDay = new Date().getDay();

            if (!scheduledDays.includes(currentDay.toString())) {
                document.getElementById("current-program").textContent = "No program scheduled for today.";
                document.getElementById("next-program").textContent = "No program scheduled for today.";
                return;
            }

            if (!startTimes.length || !programTitles.length || !endTimes.length) {
                document.getElementById("current-program").textContent = "No schedule available.";
                document.getElementById("next-program").textContent = "No upcoming programs.";
                return;
            }

            var currentTime = new Date();
            var currentProgram = "No current program.";
            var nextProgram = "No upcoming programs.";

            for (var i = 0; i < startTimes.length; i++) {
                var [startHour, startMinute] = startTimes[i].split(":").map(Number);
                var [endHour, endMinute] = endTimes[i].split(":").map(Number);

                var startDate = new Date(currentTime);
                startDate.setHours(startHour, startMinute, 0, 0);

                var endDate = new Date(currentTime);
                endDate.setHours(endHour, endMinute, 0, 0);

                if (currentTime >= startDate && currentTime < endDate) {
                    currentProgram = `${programTitles[i]}`;
                    nextProgram = (i + 1 < startTimes.length) 
                        ? `${programTitles[i + 1]} (Starts at ${formatTime(new Date(startDate.setMinutes(startDate.getMinutes() + 60)))}.)` 
                        : "No upcoming programs.";
                    break;
                }

                if (currentTime < startDate) {
                    nextProgram = `${programTitles[i]} (Starts at ${formatTime(startDate)})`;
                    break;
                }
            }

            document.getElementById("current-program").textContent = currentProgram;
            document.getElementById("next-program").textContent = nextProgram;

        } catch (error) {
            console.error("Error parsing schedule data:", error);
            document.getElementById("current-program").textContent = "Invalid schedule data.";
            document.getElementById("next-program").textContent = "Invalid schedule data.";
        }
    }

    function formatTime(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? "PM" : "AM";
        hours = hours % 12 || 12;
        minutes = minutes.toString().padStart(2, "0");
        return `${hours}:${minutes} ${ampm}`;
    }

    document.addEventListener("DOMContentLoaded", function() {
        getProgramDetails();
    });
</script>

