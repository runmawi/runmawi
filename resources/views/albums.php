<?php include('header.php'); ?>
<style type="text/css">
.audio-js *, .audio-js :after, .audio-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.vjs-texttrack-settings { display: none; }
.audio-js .vjs-big-play-button{ border: none !important; }
.bd{border-radius: 25px!important;
background: #2bc5b4!important;}
.bd:hover{

}
p{
color: #fff;
}
.flexlink{
position: relative;
top: 63px;
left: -121px;
}
#ff{
border: 1px solid #fff;
border-radius: 50%;
padding: 10px;
font-size: 20px;
color: #fff;
}
li{
list-style: none; 
}
.audio-lp{
background: #000000;
padding: 33px;

}
.audio-lp li{
list-style: none;
color:#fff;
padding: 10px 10px;
}
.audio-lp li:hover {
background-color: #1414;
color:#fff;
border: 1px #e9ecef;
border-radius: .25rem;
border-bottom-left-radius:0;
border-bottom-right-radius:0;

}
.aud-lp{
border-bottom: 1px solid #141414;
}
/* Player Style */
.audioPlayer .jp-jplayer, #jplayer-audio-container {width: 100%;}
.audioPlayer .jp-controls button {text-indent: 0;}
.jp-audio, .jp-video {background: black;font-family: sans-serif;font-size: .75rem;margin: 0 auto;max-width: 35rem;width: 100%;}
.jp-type-playlist {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;-moz-flex-direction: column;-ms-flex-direction: column;flex-direction: column;height: 100%;}
.jp-type-playlist .jp-close {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-gui {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-playlist {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;overflow-y: auto;}
.jp-btn {border: 0;padding: 0;outline: none;background: none;color: #fff;height: 1.5rem;line-height: 1.5rem;padding: 0 15px;}
.jp-gui {background: rgba(255, 255, 255, 0.05);padding: 1rem;}
.jp-gui .jp-title {display: inline-block;color: #fff;height: 1.5rem;width: 7.5rem;line-height: 1.5rem;overflow: hidden;opacity: 0.5;}
.jp-gui .jp-toggles {display: inline-block;float: right;}
.jp-gui .jp-toggles .jp-repeat,
.jp-gui .jp-toggles .jp-shuffle {display: inline-block;float: left;vertical-align: top;opacity: 0.5;}
.jp-gui .jp-times {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;margin-top: .5rem;}
.jp-gui .jp-times .jp-current-time,
.jp-gui .jp-times .jp-duration {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;color: #fff;font-size: .6rem;opacity: 0.5;}
.jp-gui .jp-times .jp-current-time {text-align: left;}
.jp-gui .jp-times .jp-duration {text-align: right;}
.jp-gui .jp-volume-controls {display: inline-block;float: right;}
.jp-gui .jp-volume-controls .jp-volume-max {display: none !important;}
.jp-gui .jp-volume-controls .jp-mute {display: inline-block;float: left;vertical-align: top;margin-right: -.75rem;opacity: 0.5;}
.jp-gui .jp-volume-controls .jp-volume-bar {display: none !important;float: left;vertical-align: top;width: 2.5rem;height: 2px;background: rgba(255, 255, 255, 0.5);margin: .65rem 0;}
.jp-gui .jp-volume-controls .jp-volume-bar .jp-volume-bar-value {background: #fff;height: 2px;}
.jp-gui .jp-controls-holder .jp-controls {padding: 1rem 0;display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-align-items: center;-moz-align-items: center;-ms-align-items: center;align-items: center;width: 100%;}
.jp-gui .jp-controls-holder .jp-controls button {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;height: 2.5rem;line-height: 2.5rem;}
.jp-gui .jp-controls-holder .jp-controls button i {font-size: 1.25rem;}
.jp-gui .jp-controls-holder .jp-controls button:active i {color: #09f;}
.jp-gui .jp-controls-holder .jp-progress .jp-seek-bar {background: rgba(255, 255, 255, 0.5);height: .15rem;}
.jp-gui .jp-controls-holder .jp-progress .jp-seek-bar .jp-play-bar {background: #fff;height: .15rem;}
.jp-state-playing .jp-play i {color: #09f;}
.jp-state-playing .jp-play i:before {content: "\f04c";}
.jp-state-looped .jp-repeat {opacity: 1 !important;}
.jp-state-looped .jp-repeat i {color: #09f;}
.jp-state-shuffled .jp-shuffle {opacity: 1 !important;}
.jp-state-shuffled .jp-shuffle i {color: #09f;}
.jp-state-muted .jp-mute {opacity: 1 !important;}
.jp-state-muted .jp-mute i {color: #09f;}
.jp-playlist {background: rgba(255, 255, 255, 0);}
.jp-playlist > ul {padding: 0;margin: 0;list-style: none;}
.jp-playlist > ul > li {display: block;padding: 0 !important;}
.jp-playlist > ul > li > div > a.jp-playlist-item {display: block;padding: .75rem 1rem;outline: none;color: rgba(255, 255, 255, 0.5);}
.jp-playlist > ul > li > div > a.jp-playlist-item.jp-playlist-current {background: rgba(255, 255, 255, 0.2);color: #fff;}
.jp-playlist > ul > li:nth-child(odd) > div > a {background: rgba(255, 255, 255, 0.1);}
.jp-gui button {background: transparent;color: #fff;}
.jp-interface {-webkit-align-content: center;-ms-align-content: center;align-content: center;-webkit-align-items: center;-ms-align-items: center;align-items: center;display: table;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;justify-content: space-between;width: 100%;}
.jp-gui .jp-toggles {-webkit-align-content: center;-ms-align-content: center;align-content: center;-webkit-align-items: center;-ms-align-items: center;align-items: center;display: table;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;width: 100%;}
.jp-controls-holder, .jp-progress {width: 100%;}
.jp-seek-bar {background: rgba(255, 255, 255, 0.5);height: .15rem;}
.jp-play-bar {background-color: #fff;height: 100%;}
.jp-gui .jp-toggles button + button {margin-left: .3rem;}
#jp_video {height: auto !important;position: relative;padding-bottom: 54.3%;width: 100% !important;}
#jp_video > * {height: 100% !important;-webkit-object-fit: cover;-ms-object-fit: cover;object-fit: cover;position: absolute;width: 100% !important;}
.sectionContainer {padding: 3.75rem 0;}
.sectionContainer + .sectionContainer {border-top: .1rem solid #fff;}
.sectionContainer:nth-child(odd) {background-color: rgba(255, 255, 255, 0.1);}
.crow {display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;margin: 0 -15px;}
.chalf {padding: 15px;width: 50%;}
@media only screen and (max-width: 991px) {
    html, body {font-size: 16px;}
    .chalf {width: 100%;}
}
</style>

<?php if (isset($error)) { ?>
<h2 class="text-center"><?php echo $message;?></h2>

<?php } else { ?>

<input type="hidden" value="<?php echo URL('/');?>" id="base_url">
<div id="audio_bg" >
<div class="container">
<div class="row album-top-30 mt-4 align-items-center">
<div class="col-sm-4 ">
<img src="<?= URL::to('/').'/public/uploads/albums/'. $album->album ?>"  class="img-responsive" / width="350">
</div>
<div class="col-sm-8 col-md-8 col-xs-8">
<div class="album_bg">
<div class="album_container">
<div class="blur"></div>
<div class="overlay_blur">
 <h2 class="hero-title album"> <?= $album->albumname; ?></h2>
    <!-- <p class="mt-2">Music by    <br>A. R. Rahman</p> -->
    <div class="d-flex" style="justify-content: space-between;width: 40%;align-items: center;">
        <a href="" class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
        <i id="ff" class="fa fa-heart-o" aria-hidden="true"></i>
        <i id="ff" class="fa fa-ellipsis-h" aria-hidden="true"></i>
        <i id="ff" class="fa fa-share-alt" aria-hidden="true"></i>
        <!-- Share -->
    </div>
  
    </div>
</div>
</div>
</div>
</div>
<div class="row mt-5">
    <div class="col-sm-12 db">
        <ul class="audio-lp">
            <li class=" active">
                <div class="d-flex justify-content-around" style="align-items: center;color:#fff;">
                    <div>Album Name </div>
                    <div>Song list</div>
                    <div>Singer by</div>
                    <div>Lyrics by</div>
                    <div>Favourite</div>
                    <div>Duration</div>
                </div>
            </li>
            <?php foreach($album_audios as $audio){ ?>
            <li class="aud-lp">
                <div class="d-flex justify-content-around" style="align-items: center;">
                     <img src="<?= URL::to('/').'/public/uploads/images/'. $audio->image ?>"  class="img-responsive" / width="50">
                <div><a href="<?php echo URL::to('/').'/audio/'.$audio->slug;?>"><?php echo ucfirst($audio->title); ?></a></div>
                <div><?php echo get_audio_artist($audio->id); ?></div>
                <div>Arstist</div>
                <div><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                <div><?php echo gmdate('H:i:s', $audio->duration); ?></div>
                </div>
            </li>
            <?php } ?>
           
       </ul>
    </div>
</div>
</div>
</div>

<div class="clear"></div>  

<?php } ?>
<div class="container">
<div class="row album-top-30 mt-3">  
<div class="col-sm-12">
<p  class="album-title">Other Albums </p>
<ul class="album_list mt-3" style="display: flex;">
    <?php foreach ($other_albums as $other_album) { ?>
        <li>
            <?php if($other_album->album != ''){ ?>
                <a href="<?php echo URL('/').'/album/'.$other_album->slug;?>">
                <img src="<?= URL::to('/').'/public/uploads/albums/' . $other_album->album ?>"  class="img-responsive" width="200" height="150"/>
              

                <div class="play-block">
                    <a href=""> <i class="fa fa-play flexlink" aria-hidden="true"></i> </a>
                </div>
            </a>
            <?php echo ucfirst($other_album->albumname);?>
            <?php  } ?>
        </li>
    <?php }?>
</ul>
  


</div>

</div>

<div class="">
   <!--  <audio  id="video_player" onended="autoplay1()" autoplay class="audio-js vjs-default-skin my-div" controls preload="auto"  style="width: 100%;height: 50px;position: fixed;width: 100%;left: 0;bottom: 0;  z-index: 9999;" controlsList="nodownload">
        <?php foreach($album_audios as $audio){ ?>
            <source src="<?php echo $audio->mp3_url;?>" type="audio/mpeg">
          <?php } ?>
          Your browser does not support the audio element.

      </audio> -->
<div class="sectionContainer" id="profile-music">
<div class="container">
<div class="sectionHeading"><h3>Media</h3></div>
<div class="crow">
<div class="chalf">
<div id="jplayer-audio" class="jp-jplayer"></div>
<div id="jplayer-audio-container" class="jp-audio" role="application" aria-label="media player">
<div class="jp-type-playlist">
<div class="jp-gui">
<div class="jp-title"></div>
<div class="jp-volume-controls">
<button class="jp-mute jp-btn" role="button" tabindex="0"><i class="fa fa-volume-mute"></i></button>
<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
<div class="jp-volume-bar">
<div class="jp-volume-bar-value"></div>
</div>
</div>
<div class="jp-toggles">
<button class="jp-repeat jp-btn" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
<button class="jp-shuffle jp-btn" role="button" tabindex="0"><i class="fa fa-random"></i></button>
</div>
<div class="jp-controls-holder">
<div class="jp-controls">
<button class="jp-previous jp-btn" role="button" tabindex="0"><i class="fa fa-backward"></i></button>
<button class="jp-play jp-btn" role="button" tabindex="0"><i class="fa fa-play"></i></button>
<button class="jp-stop jp-btn" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
<button class="jp-next jp-btn" role="button" tabindex="0"><i class="fa fa-forward"></i></button>
</div>
<div class="jp-progress">
<div class="jp-seek-bar">
<div class="jp-play-bar"></div>
</div>
</div>
<div class="jp-times">
<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
</div>
</div>
</div>
<div class="jp-playlist">
<ul>
<li>&nbsp;</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>

</div>
<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>

<script type="text/javascript">
$(document).ready(function() {
$(".my-div").on("contextmenu",function(){
return false;
}); 
});
</script>

<script type="text/javascript">

var base_url = $('#base_url').val();

$(document).ready(function(){
$('#audio_container').fitVids();
$('.favorite').click(function(){
if($(this).data('authenticated')){
$.post('/saka/favorite', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
$(this).toggleClass('active');
} else {
window.location = base_url+'/signup';
}
});
//watchlater
//          $('.watchlater').click(function(){
//                //alert(base_url);
//                var audio_id = $(this).data('audioid');
//                //alert(audio_id);
//              if($(this).data('authenticated')){
//                   // alert();
//                  $.post(base_url+'/watchlater', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
//                  $(this).toggleClass('active');
//
//              } else {
//                  window.location = '/signup';
//              }
//          });

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
//          $('.mywishlist').click(function(){
//                var aud_id = $(this).data('audioid');
//                //alert(aud_id);
//              if($(this).data('authenticated')){
//                  $.post(base_url+'/mywishlist', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
//                  $(this).toggleClass('active');
//
//              } else {
//                  window.location = base_url+'/signup';
//              }
//          });

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

<!-- RESIZING FLUID VIDEO for VIDEO JS -->
<script type="text/javascript">
// Once the video is ready
_V_("video_player").ready(function(){

var myPlayer = this;    // Store the video object
var aspectRatio = 9/16; // Make up an aspect ratio

function resizeVideoJS(){
console.log(myPlayer.id);
// Get the parent element's actual width
var width = document.getElementById('video_container').offsetWidth;
// Set width to fill parent element, Set height
myPlayer.width(width).height( width * aspectRatio );
}

resizeVideoJS(); // Initialize the function
window.onresize = resizeVideoJS; // Call the function on resize
});
</script>

<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>
<script>
var player = videojs('video_player').videoJsResolutionSwitcher({
default: '480p', // Default resolution [{Number}, 'low', 'high'],
dynamicLabel: true
})
var res = player.currentResolution();
player.currentResolution(res);

function autoplay1() {
//alert();
var base_url = $('#base_url').val();
//      var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
//      playButton.setAttribute("id", "myPlayButton");
var next_audio_id = $(".next_audio").text();
var prev_audio_id = $(".prev_audio").text();
var next_cat_audio = $(".next_cat_audio").text();
var prev_cat_audio = $(".prev_cat_audio").text();
var url = $(".next_url").text();
if(url != ''){
//alert();

setTimeout(function(){  
window.location = url;
}, 3000);
}else if(prev_audio_id != ''){

$(".vjs-big-play-button").show();
var bar = new ProgressBar.Circle(myPlayButton, {
strokeWidth: 7,
easing: 'easeInOut',
duration: 2400,
color: '#98cb00',
trailColor: '#eee',
trailWidth: 1,
svgStyle: null
});

bar.animate(1.0);  // Number from 0.0 to 1.0
setTimeout(function(){  
window.location = base_url+url+"/"+prev_audio_id;
}, 3000);

}

if(next_cat_audio != ''){
var base_url = $('#base_url').val();
$(".vjs-big-play-button").show();
var bar = new ProgressBar.Circle(myPlayButton, {
strokeWidth: 7,
easing: 'easeInOut',
duration: 2400,
color: '#98cb00',
trailColor: '#eee',
trailWidth: 1,
svgStyle: null
});

bar.animate(1.0);  // Number from 0.0 to 1.0
setTimeout(function(){  
window.location = base_url+"/audios_category/"+next_cat_audio;
}, 3000);
}else if(prev_cat_audio != ''){

$(".vjs-big-play-button").show();
var bar = new ProgressBar.Circle(myPlayButton, {
strokeWidth: 7,
easing: 'easeInOut',
duration: 2400,
color: '#98cb00',
trailColor: '#eee',
trailWidth: 1,
svgStyle: null
});

bar.animate(1.0);  // Number from 0.0 to 1.0
setTimeout(function(){  
window.location = base_url+"/audios_category/"+prev_cat_audio;
}, 3000);

}
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js">
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/jplayer/jquery.jplayer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/add-on/jplayer.playlist.min.js"></script>

</div><script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();


jQuery(function($) {
            /* Load jPlayer */
            
    
            /* Youtube Integration Setup */
           
            $(document).on($.jPlayer.event.setmedia, function(jpEvent) {});
    
            new jPlayerPlaylist({
                jPlayer: "#jplayer-audio",
                cssSelectorAncestor: "#jplayer-audio-container"
            }, 
                    <?php echo $json_list;?>
            , {
                swfPath: "src/swf/",
                solution: "html, flash",
                supplied: "mp3",
                preload: "auto",
                wmode: "window",
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true,
                stop: function(e) {
                    $(".toggle-play").removeClass("active");
                    $(".waves").fadeOut();
                },
                pause: function(e) {
                    $(".toggle-play").removeClass("active");
                    $(".waves").fadeOut();
                },
                play: function(e) {
                    $(".toggle-play").addClass("active");
                    $(".waves").fadeIn();
                },
                ready: function(e) {}
            });
    
            $(".toggle-list").bind("click", function() {
                if (!$("body").hasClass("active")) {
                    $("body").addClass("active");
                } else {
                    $("body").removeClass("active");
                }
            });
            $(window).on("load", function() {
                $("#jp_video").jPlayer("play");
            });
            $(".toggle-play").on("click", function() {
                if (!$(".jp-audio").hasClass("jp-state-playing")) {
                    $("#jp_video").jPlayer("play");
                } else {
                    $("#jp_video").jPlayer("stop");
                }
            });
        });
</script>

<?php include('footer.blade.php'); ?>
