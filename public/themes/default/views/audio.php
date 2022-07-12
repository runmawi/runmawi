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
    th,td {
    padding: 10px;
    color: #fff!important;
}
    tr{
        border:#141414;
    }
p{
color: #fff;
}
    .slick-track{
        width: 45%!important;
    }
.fa-heart{color: red !important;}
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
border-radius: 25px;

}

.audio-lpk:hover {
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
/* Player Style */
.audioPlayer .jp-jplayer, #jplayer-audio-container {}
.audioPlayer .jp-controls button {text-indent: 0;}
.jp-audio, .jp-video {background: black;font-family: sans-serif;font-size: .75rem;max-width: 85rem;width: 100%;position: fixed;
    top: 85%;
    z-index: 5;margin-left: -110px;}
    .jp-btn{background-color: red;border-radius: 50%;}
.jp-type-playlist {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;-moz-flex-direction: column;-ms-flex-direction: column;flex-direction: column;height: 100%;}
.jp-type-playlist .jp-close {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-gui {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-playlist {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;overflow-y: auto;}
.jp-btn {border: 0;padding: 0;outline: none;background: none;color: #fff;height: 1.5rem;line-height: 1.5rem;padding: 0 15px;}
.jp-gui {background: rgba(255, 255, 255, 0.05);padding: 1rem;}
.jp-gui .jp-title {display: inline-block;color: #fff;height: 1.5rem;width: 50%;text-align: right;line-height: 1.5rem;overflow: hidden;opacity: 0.5;}
.jp-gui .jp-toggles {display: inline-block;float: right;}
.jp-gui .jp-toggles .jp-repeat,
.jp-gui .jp-toggles .jp-shuffle {display: inline-block;float: left;vertical-align: top;opacity: 0.5;}
.jp-gui .jp-toggles .jp-shuffle i,.jp-gui .jp-toggles .jp-repeat i{font-size: 1.6rem;}
.jp-gui .jp-times {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;margin-top: .5rem;}
.jp-gui .jp-times .jp-current-time,
.jp-gui .jp-times .jp-duration {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;color: #fff;font-size: .6rem;opacity: 0.5;}
    ..jp-gui .jp-controls-holder .jp-controls{
        width: 40%
            margin:0 auto;
    }
.jp-gui .jp-times .jp-current-time {text-align: left;}
.jp-gui .jp-times .jp-duration {text-align: right;}
.jp-gui .jp-volume-controls {display: inline-block;float: right;}
.jp-gui .jp-volume-controls .jp-volume-max {display: none !important;}
.jp-gui .jp-volume-controls .jp-mute {display: inline-block;float: left;vertical-align: top;margin-right: -.75rem;opacity: 0.5;}
.jp-gui .jp-volume-controls .jp-volume-bar {display: none !important;float: left;vertical-align: top;width: 2.5rem;height: 2px;background: rgba(255, 255, 255, 0.5);margin: .65rem 0;}
.jp-gui .jp-volume-controls .jp-volume-bar .jp-volume-bar-value {background: #fff;height: 2px;}
.jp-gui .jp-controls-holder .jp-controls {/*padding: 1rem 0;*/display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-align-items: center;-moz-align-items: center;-ms-align-items: center;align-items: center;width: 40%;margin: 0 auto;}
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
.jp-gui button {background: transparent;color: #fff;border: 0;}
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
<p class="mt-2">Album <a href="<?php echo URL::to('/').'/album/'.$album_slug;?>"><?php echo ucfirst($album_name); ?></a></p>
<div class="d-flex" style="justify-content: space-between;width: 40%;align-items: center;">
<button class="btn bd" id="vidbutton"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</button>
<a aria-hidden="true" class="favorite <?php echo audiofavorite($audio->id);?>" data-authenticated="<?= !Auth::guest() ?>" data-audio_id="<?= $audio->id ?>"><?php if(audiofavorite($audio->id) == "active"): ?><i id="ff" class="fa fa-heart" ></i><?php else: ?><i id="ff" class="fa fa-heart-o" ></i><?php endif; ?></a>
<i id="ff" class="fa fa-ellipsis-h" aria-hidden="true"></i>
<div class="dropdown">
    <i id="ff" class="fa fa-share-alt " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"  style="background-color: black;border:1px solid white;padding: 0;">
        <a class="dropdown-item popup" href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" target="_blank">
            <i class="fa fa-twitter" style="color: #00acee;padding: 10px;border-radius: 50%;font-size: 26px;"></i>
        </a>
        <div class="divider" style="border:1px solid white"></div>
        <a class="dropdown-item popup" href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" target="_blank"><i class="fa fa-facebook" style="color: #3b5998;padding: 10px;border-radius: 50%; font-size: 26px;"></i></a>
    </div>
</div>
<!-- Share -->
</div>

</div>
</div>
</div>
</div>
</div>
<div class="row mt-5">
<div class="col-sm-12 db">

<div class="audio-lp">
<p  class="album-title">Other Songs from <?= ucfirst($album_name); ?></p>
  <table style="width:100%;color:#fff;">  
<tr style="border-bottom:1px solid #fff;">
    <th>Track </th>
    <th>Song list</th>
    <th>Singer by</th>
    <th>Lyrics by</th>
    <th>Favourite</th>
    <th>Duration</th></tr>
      <?php foreach($related_audio as $other_audio){ ?>
      <tr class="audio-lpk">


   
        
          <td> <img src="<?= URL::to('/').'/public/uploads/images/'. $other_audio->image ?>"  class="img-responsive" / width="50"></td>
           <td><a href="<?php echo URL::to('/').'/audio/'.$other_audio->slug;?>"><?php echo ucfirst($other_audio->title); ?></a></td>
           <td><?php echo get_audio_artist($other_audio->id); ?></td>
           <td>Arstist</td>
           <td><a aria-hidden="true" class="favorite <?php echo audiofavorite($other_audio->id);?>" data-authenticated="<?= !Auth::guest() ?>" data-audio_id="<?= $other_audio->id ?>"><?php if(audiofavorite($other_audio->id) == "active"): ?><i class="fa fa-heart" ></i><?php else: ?><i class="fa fa-heart-o" ></i><?php endif; ?></a></td>
           <td><?php echo gmdate('H:i:s', $other_audio->duration); ?></td>
      
   

          </tr>
      <?php } ?>
    </table>
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
    
<h4  class="album-title">Other Albums </h4>
<ul class="album_list mt-3" style="display: flex;">
    <?php foreach ($other_albums as $other_album) { ?>
        <li>
            <?php if($other_album->album != ''){ ?>
                <a href="<?php echo URL('/').'/album/'.$other_album->slug; ?>">
                <img src="<?= URL::to('/').'/public/uploads/albums/' . $other_album->album ?>"  class="img-responsive" width="200" height="150"/>
                <div class="play-block">
                    <a href=""> <i class="fa fa-play flexlink" aria-hidden="true"></i> </a>
                </div>
                    
            </a>
            <p class="mt-2"><?php echo ucfirst($other_album->albumname);?>
            <?php  } ?> </p>
          
        </li>
    <?php } ?>
</ul>
</div>

</div>
<?php endif; ?>

<div class="">
<!-- <audio  id="video_player" onended="autoplay1()" autoplay class="audio-js vjs-default-skin my-div" controls preload="auto"  style="width: 100%;height: 50px;position: fixed;width: 100%;left: 0;bottom: 0;  z-index: 9999;" controlsList="nodownload">
<source src="<?= $audio->mp3_url; ?>" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
 -->
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
  <div class="jp-type-single">
    <div class="jp-gui jp-interface">
      
      <div class="jp-controls-holder">
        <div class="jp-controls">
            <div class="jp-volume-controls" style="width:100%;">
                <button class="jp-mute" role="button" tabindex="0"><i class="fa fa-volume-off" style="font-size:26px;"></i></button>
                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                <div class="jp-volume-bar">
                  <div class="jp-volume-bar-value"></div>
              </div>
          </div>
          <button class="jp-play" role="button" tabindex="0"><i class="fa fa-play"></i></button>
          <button class="jp-stop" role="button" tabindex="0" style="width: 100%"><i class="fa fa-stop"></i></button>
          <div class="jp-toggles">
          <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
        </div>
        </div>
        <div class="jp-progress">
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
        </div>
        <div class="jp-current-time" role="timer" aria-label="time" style="
    width: 10%;display: inline-block;color: white;">&nbsp;</div>
        <div class="jp-duration" role="timer" aria-label="duration" style="
    width: 10%;float: right;color: white;display: inline-flex;">&nbsp;</div>
        
      </div>
    </div>
    <div class="jp-details">
      <div class="jp-title" aria-label="title">&nbsp;</div>
    </div>
    <div class="jp-no-solution">
      <span>Update Required</span>
      To play the media you will need to either update your browser to a recent version or update your <a href="https://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
    </div>
  </div>
</div>
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



<script type="text/javascript">

var base_url = $('#base_url').val();

$(document).ready(function(){
$('.favorite').click(function(){
if($(this).data('authenticated')){
$.post('/saka/favorite', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
$(this).toggleClass('active');
} else {
window.location = base_url+'/signup';
}
});

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
//Audio Favorite
      $('.favorite').click(function(){
        if($(this).data('authenticated')){
          $.post('<?= URL::to('favorite') ?>', { audio_id : $(this).data('audio_id'), _token: '<?= csrf_token(); ?>' }, function(data){});
          $(this).toggleClass('active');
          $(this).html("");
              if($(this).hasClass('active')){
                $(this).html('<i class="fa fa-heart"></i>');
              }else{
                $(this).html('<i class="fa fa-heart-o"></i>');
              }
        } else {
          window.location = '<?= URL::to('login') ?>';
        }
      });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/jplayer/jquery.jplayer.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/add-on/jplayer.playlist.min.js"></script>

<script type="text/javascript">
    var ppbutton = document.getElementById("vidbutton");

    $player = $("#jquery_jplayer_1")
    jPlayer_method = $player.jPlayer
    $player.jPlayer({
        ready: function () {
           jPlayer_method.call( $player, "setMedia",  <?php echo $json_list;?>);
       },
       cssSelectorAncestor: "#jp_container_1",
       swfPath: "src/swf/",
       solution: "html, flash",
       supplied: "mp3",
       preload: "auto",
       useStateClassSkin: true,
       autoBlur: false,
       smoothPlayBar: true,
       keyEnabled: true,
       remainingDuration: true,
       toggleDuration: true,
       pause: function(e) {
        ppbutton.innerHTML = '<i class="fa fa-play mr-2" aria-hidden="true"></i> Play';
    },
    play: function(e) {
        ppbutton.innerHTML = '<i class="fa fa-pause mr-2" aria-hidden="true"></i> Pause';
    }
});
    
    $("#vidbutton").on("click", function(e) {
        e.preventDefault();
        $(".jp-play").trigger("click");
    });
</script>
<?php include('footer.blade.php'); ?>
