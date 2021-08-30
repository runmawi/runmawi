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
#circle{
border-radius: 50%;
}
</style>

<?php if (isset($error)) { ?>
<h2 class="text-center"><?php echo $message;?></h2>

<?php } else { ?>

<input type="hidden" value="<?php echo URL('/');?>" id="base_url">
<div id="audio_bg" >
<div id="audio_bg_dim" <?php if($audio->access == 'guest' || ($audio->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
<div class="container">

<?php if($audio->access == 'guest' || ( ($audio->access == 'subscriber' || $audio->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $audio->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') || (($audio->access == 'subscriber' || $audio->access == 'registered') && $ppv_status == 1)): ?>


<!-- <?php //if($audio->type == 'file'): ?>

<div class="row">

<div class="col-sm-4">
<img src="<?= Config::get('site.uploads_url') . '/images/' . $audio->image ?>" class="img-responsive" />
<div class="carousel-caption">
<audio controls style="width: 67%;height: 33px;" autoplay onended="autoplay1()" class="audio-js vjs-default-skin" controls preload="auto"  >
<source src="<?= $audio->mp3_url; ?>" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>
</div>

<div class="col-sm-8">
<h3  class="albumstyle"> Albums List</h3>
</div>

</div>

<?php  //else: ?> -->

<?php if($audio): ?>
<?php if ( $audio->ppv_status == 1 && $settings->ppv_status == 1 && $ppv_status == 0 && Auth::user()->role != 'admin') { ?>
<div id="subscribers_only">
<a  class="text-center btn btn-success" id="paynowbutton"> Pay for View  </a>
</div>
<?php } else { ?>                

<div class="row album-top-30 mt-4 align-items-center">
<div class="col-sm-4 ">
<img src="<?= URL::to('/').'/public/uploads/images/'. $audio->image ?>"  class="img-responsive" / width="350">

<!-- -->
</div>
<div class="col-sm-8 col-md-8 col-xs-8">
<div class="album_bg">
<div class="album_container">
<div class="blur"></div>
<div class="overlay_blur">
<h2 class="hero-title album"> <?= $audio->title; ?></h2>
<p class="mt-2">Music by <?php echo get_audio_artist($audio->id); ?></p>
<p class="mt-2">Album <?php echo ucfirst($album_name); ?></p>
<div class="d-flex" style="justify-content: space-between;width: 40%;align-items: center;">
<button class="btn bd" id="vidbutton"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</button>
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
<p  class="album-title">Other Songs from <?= ucfirst($album_name); ?></p>
<div class="d-flex justify-content-around" style="align-items: center;color:#fff;">
    <div>Album Name </div>
    <div>Song list</div>
    <div>Singer by</div>
    <div>Lyrics by</div>
    <div>Favourite</div>
    <div>Duration</div>
</div>
</li>
<?php foreach($related_audio as $other_audio){ ?>
    <li class="aud-lp">
        <div class="d-flex justify-content-around" style="align-items: center;">
           <img src="<?= URL::to('/').'/public/uploads/images/'. $other_audio->image ?>"  class="img-responsive" / width="50">
           <div><a href="<?php echo URL::to('/').'/audio/'.$other_audio->slug;?>"><?php echo ucfirst($other_audio->title); ?></a></div>
           <div><?php echo get_audio_artist($other_audio->id); ?></div>
           <div>Arstist</div>
           <div><i class="fa fa-heart-o" aria-hidden="true"></i></div>
           <div><?php echo gmdate('H:i:s', $other_audio->duration); ?></div>
       </div>
   </li>
<?php } ?>
</ul>
</div>
</div>

<?php if(isset($audionext)){ ?>
<div class="next_audio" style="display: none;"></div>
<div class="next_url" style="display: none;"><?php echo  URL::to('/').'/audio/'.$current_slug.'/'.$audionext ?></div>
<?php }elseif(isset($audioprev)){ ?>
<div class="prev_audio" style="display: none;"><?= $audioprev->id ?></div>
<div class="next_url" style="display: none;"><?= $url ?></div>
<?php } ?>

<?php if(isset($audios_category_next)){ ?>
<div class="next_cat_audio" style="display: none;"><?= $audios_category_next->id ?></div>
<?php }elseif(isset($audios_category_prev)){ ?>
<div class="prev_cat_audio" style="display: none;"><?= $audios_category_prev->id ?></div>
<?php } ?>
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
<?php endif; ?>

<div class="">
<audio  id="video_player" onended="autoplay1()" autoplay class="audio-js vjs-default-skin my-div" controls preload="auto"  style="width: 100%;height: 50px;position: fixed;width: 100%;left: 0;bottom: 0;  z-index: 9999;" controlsList="nodownload">
<source src="<?= $audio->mp3_url; ?>" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>


<?php else: ?>

<div id="subscribers_only">
<h2>Sorry, this audio is only available to <?php if($audio->access == 'subscriber'): ?>Subscribers<?php elseif($audio->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
<div class="clear"></div>
<?php if(!Auth::guest() && $audio->access == 'subscriber'): ?>
<form method="get" action="/user/<?= Auth::user()->username ?>/upgrade_subscription">
<button id="button">Become a subscriber to watch this audio</button>
</form>
<?php else: ?>
<form method="get" action="/signup">
<button id="button">Signup Now <?php if($audio->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($audio->access == 'registered'): ?>for Free!<?php endif; ?></button>
</form>
<?php endif; ?>
</div>

<?php endif; ?>
</div>
</div>

</div>
<?php } ?>
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
<script src="./css/jquery-luna.js" type="text/javascript"></script>
<script>
$(function(){
var $audioPlayer = $(".audio-player").luna(
{
songs:["song.mp3"],
onStatusChange: function(e){
console.log(e);
}
}
);
});
</script>
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


/*Play and Pause*/
var ppbutton = document.getElementById("vidbutton");
ppbutton.addEventListener("click", playPause);
myVideo = document.getElementById("video_player");
function playPause() { 
    if (myVideo.paused) {
        myVideo.play();
        ppbutton.innerHTML = "Pause";
        }
    else  {
        myVideo.pause(); 
        ppbutton.innerHTML = "Play";
        }
}
</script>

<?php include('footer.blade.php'); ?>
