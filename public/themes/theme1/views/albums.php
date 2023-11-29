<?php include('header.php'); ?>
<style type="text/css">
     #myProgress {
   background-color: #8b0000; 
  cursor: pointer;
  border-radius: 10px;
}
  
#myBar {
  width: 0%;
  height: 3px;
  background-color:red;
  border-radius: 10px;
}
    .title{
        text-align: left!important;
        color: #fff;
    }
.logo {
  fill: red;
}
    .play-border{
        border:1px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        padding: 10px;
        border-width:2px;
    }

.btn-action{
  cursor: pointer;
  /*padding-top: 10px;*/
  width: 30px;
}

.btn-ctn{
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
.infos-ctn{
padding-top: 8px;
    display: flex;
  align-items: center;
  justify-content: space-between;
}

.btn-ctn > div {
 padding: 5px;
 margin-top: 18px;
 margin-bottom: 18px;
}

.infos-ctn > div {
 margin-bottom: 8px;
 color: #fff;
    text-align: left;
}

.first-btn{
  margin-left: 3px;
}

.duration{
  margin-left: 10px;
}

.title{
  margin-left: 10px;
  /*
  text-align: center;
    border-top:1px solid rgba(255, 255, 255,0.1)*/
}

.player-ctn{
  
 
  padding: 10px;
  background: linear-gradient(180deg, #151517 127.69%, #282834 0% );
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);

  margin:auto;
   
    border-radius: 10px;
 
}

.playlist-track-ctn{
  display: flex;
    padding-left: 10px;
  background-color: #464646;
  margin-top: 3px;
    margin-right: 10px;
  border-radius: 5px;
  cursor: pointer;
    align-items: center;
}
.playlist-track-ctn:last-child{
  /*border: 1px solid #ffc266; */
}

.playlist-track-ctn > div{
  margin:5px;
    color: #fff;
}
.playlist-info-track{
  width: 80%;
  
    padding: 2px;
}
.playlist-info-track,.playlist-duration{
  /*padding-top: 7px;
  padding-bottom: 7px;*/
  color: #e9cc95;
  font-size: 14px;
  pointer-events: none;
}
   .playlist-ctn {
 
}
    .playlist-ctn::-webkit-scrollbar {
width: 2px;
}
.playlist-ctn::-webkit-scrollbar-track {
  background: rgba(255,255,255,0.2);
    
}
.playlist-ctn::-webkit-scrollbar-thumb {
  background-color: red;
  border-radius: 2px;
  border: 2px solid red;
     width: 2px;
}
.playlist-ctn{
   padding-bottom: 20px;
    overflow: scroll;
    scroll-behavior: auto;
    min-height:335px;
    scrollbar-color: rebeccapurple green!important;
    overflow-x: hidden;
}
.active-track{
  background: #4d4d4d;
  color: #ffc266 !important;
  font-weight: bold;
  
}

.active-track > .playlist-info-track,.active-track >.playlist-duration,.active-track > .playlist-btn-play{
  color: #ffc266 !important;
}


.playlist-btn-play{
    color: #fff!important;
  pointer-events: none;
  padding-top: 5px;
  padding-bottom: 5px;
}
.fas{
  color: rgb(255,0,0);
  font-size: 20px;
}
    .img-responsive{
        border-radius: 10px;
    }
    
.fa-heart{color: red !important;}
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
.bd{
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
.flexlink{
position: relative;
top: 63px;
left: -121px;
}
#ff{
border: 1px solid #fff;
    border-radius: 50%;
    padding: 5px;
    font-size: 12px;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
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
</style>

<?php if( count($album_audios) == 0 ){ ?>

<div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
    <p ><h3 class="text-center"><?= __('No Audio Available') ?></h3> 
</div>

<?php }else{ ?>

<?php if (isset($error)) { ?>
<h2 class="text-center"><?php echo $message;?></h2>

<?php } else { ?>

<input type="hidden" value="<?php echo URL('/');?>" id="base_url">
<div id="audio_bg" >
<div class="container-fluid">
<div class="row album-top-30 mt-4 align-items-center">
   <div class="col-lg-8">
 <audio id="myAudio" ontimeupdate="onTimeUpdate()">
  <!-- <source src="audio.ogg" type="audio/ogg"> -->
  <source id="source-audio" src="" type="audio/mpeg">
  <?= __('Your browser does not support the audio element') ?>.
</audio>
<div class="player-ctn">
    <div class="row align-items-center mb-4">
    <div class="col-sm-3">
<img src="<?= URL::to('/').'/public/uploads/albums/'. $album->album ?>"  class="img-responsive" width="200" height="200">
</div>
<div class="col-sm-8 col-md-8 col-xs-8">
<div class="album_bg">
<div class="album_container">
<div class="blur"></div>
<div class="overlay_blur">
 <h4 class="hero-title album mb-2"> <?= $album->albumname; ?></h4>
     <p class="mt-2"> <?= __('Music by') ?>    <br>A. R. Rahman</p>
    <div class="d-flex" style="justify-content: space-between;width: 33%;align-items: center;">

    <div onclick="toggleAudio()">
      <button class="btn bd btn-action" id="vidbutton" style="width:90px" ><i class="fa fa-play mr-2" aria-hidden="true"  ></i>  <?= __('Play') ?></button>
    </div>

        <a aria-hidden="true" class="albumfavorite <?php echo albumfavorite($album->id);?>" data-authenticated="<?= !Auth::guest() ?>" data-album_id="<?= $album->id ?>"><?php if(albumfavorite($album->id) == "active"): ?><i id="ff" class="fa fa-heart" aria-hidden="true"></i><?php else: ?><i id="ff" class="fa fa-heart-o" aria-hidden="true"></i><?php endif; ?></a>
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
</div></div>

  
  <div id="myProgress">
    <div id="myBar"></div>
  </div>
    <div class="infos-ctn">
    <div class="timer">00:00</div>
    <div class="title"></div>
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
 
</div>

</div>
        <div class="col-lg-4">
            <div class="play-border">
                <div class="playlist-ctn">                <h6 class="mb-2 font-weight-bold"> <?= __('AUDIO LIST') ?> <i class="fa fa-arrow-right" aria-hidden="true"></i>
</h6></div></div>
        </div>
    </div>
</div>
    </div>

<div class="clear"></div>  

<?php } ?>
<div class="container-fluid overflow-hidden">
<div class="row album-top-30 mt-3 p-0">  
<div class="col-sm-12">
<p  class="album-title"> <?= __('Other Albums') ?> </p>
<div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
 <?php foreach ($other_albums as $other_album) { ?>
                       <li class="slide-item">
                            <a href="<?php echo URL('/').'/album/'.$other_album->slug;?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?= URL::to('/').'/public/uploads/albums/' . $other_album->album ?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                           <a class="d-flex" href="<?php echo URL('/').'/album/'.$other_album->slug;?>">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> 
                                               <p><?php echo ucfirst($other_album->albumname);?></p>
                                           
                                        </a>
                                 
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>

  


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

</div>
<script>
  function createTrackItem(index,name,duration){

    var trackItem = document.createElement('div');
    trackItem.setAttribute("class", "playlist-track-ctn");
    trackItem.setAttribute("id", "ptc-"+index);
    trackItem.setAttribute("data-index", index);
    document.querySelector(".playlist-ctn").appendChild(trackItem);

    var playBtnItem = document.createElement('div');
    playBtnItem.setAttribute("class", "playlist-btn-play");
    playBtnItem.setAttribute("id", "pbp-"+index);
    document.querySelector("#ptc-"+index).appendChild(playBtnItem);

    var btnImg = document.createElement('i');
    btnImg.setAttribute("class", "fas fa-play");
    btnImg.setAttribute("height", "40");
    btnImg.setAttribute("width", "40");
    btnImg.setAttribute("id", "p-img-"+index);
    document.querySelector("#pbp-"+index).appendChild(btnImg);

    var trackInfoItem = document.createElement('div');
    trackInfoItem.setAttribute("class", "playlist-info-track");
    trackInfoItem.innerHTML = name
    document.querySelector("#ptc-"+index).appendChild(trackInfoItem);

    var trackDurationItem = document.createElement('div');
    trackDurationItem.setAttribute("class", "playlist-duration");

    var measuredTime = new Date(null);
    measuredTime.setSeconds(duration); 
    var MHSTime = measuredTime.toISOString().substr(11, 8);
    
    trackDurationItem.innerHTML = MHSTime

    document.querySelector("#ptc-"+index).appendChild(trackDurationItem);

  }

  var listAudio = <?php echo json_encode($album_audios); ?>;

  for (var i = 0; i < listAudio.length; i++) {
      createTrackItem(i,listAudio[i].title,listAudio[i].duration);
  }

  var indexAudio = 0;

  function loadNewTrack(index){

    var player = document.querySelector('#source-audio')

    player.src = listAudio[index].mp3_url

    document.querySelector('.title').innerHTML = listAudio[index].title

    this.currentAudio = document.getElementById("myAudio");
    this.currentAudio.load()
    this.toggleAudio()
    this.updateStylePlaylist(this.indexAudio,index)
    this.indexAudio = index;
  }

  var playListItems = document.querySelectorAll(".playlist-track-ctn");

  for (let i = 0; i < playListItems.length; i++){
    playListItems[i].addEventListener("click", getClickedElement.bind(this));
  }

  function getClickedElement(event) {
    for (let i = 0; i < playListItems.length; i++){
      if(playListItems[i] == event.target){
        var clickedIndex = event.target.getAttribute("data-index")
        if (clickedIndex == this.indexAudio ) { // alert('Same audio');
            this.toggleAudio()
        }else{
            loadNewTrack(clickedIndex);
        }
      }
    }
  }

  document.querySelector('#source-audio').src = <?php echo json_encode($first_album_mp3_url) ; ?>  
  document.querySelector('.title').innerHTML = <?php echo json_encode($first_album_title) ; ?>  

  var currentAudio = document.getElementById("myAudio");

  currentAudio.load()
  
  currentAudio.onloadedmetadata = function() {
        document.getElementsByClassName('duration')[0].innerHTML = this.getMinutes(this.currentAudio.duration)
  }.bind(this);

  var interval1;

  function toggleAudio() {

    if (this.currentAudio.paused) {
      document.querySelector('#icon-play').style.display = 'none';
      document.querySelector('#icon-pause').style.display = 'block';
      document.querySelector('#ptc-'+this.indexAudio).classList.add("active-track");
      this.playToPause(this.indexAudio)
      this.currentAudio.play();
    }else{
      document.querySelector('#icon-play').style.display = 'block';
      document.querySelector('#icon-pause').style.display = 'none';
      this.pauseToPlay(this.indexAudio)
      this.currentAudio.pause();
    }
  }

  function pauseAudio() {
    this.currentAudio.pause();
    clearInterval(interval1);
  }

  var timer = document.getElementsByClassName('timer')[0]

  var barProgress = document.getElementById("myBar");


  var width = 0;

  function onTimeUpdate() {
    var t = this.currentAudio.currentTime
    timer.innerHTML = this.getMinutes(t);
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


  function setBarProgress(){
    var progress = (this.currentAudio.currentTime/this.currentAudio.duration)*100;
    document.getElementById("myBar").style.width = progress + "%";
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

  var progressbar = document.querySelector('#myProgress')
  progressbar.addEventListener("click", seek.bind(this));


  function seek(event) {
    var percent = event.offsetX / progressbar.offsetWidth;
    this.currentAudio.currentTime = percent * this.currentAudio.duration;
    barProgress.style.width = percent*100 + "%";
  }

  function forward(){
    this.currentAudio.currentTime = this.currentAudio.currentTime + 5
    this.setBarProgress();
  }

  function rewind(){
    this.currentAudio.currentTime = this.currentAudio.currentTime - 5
    this.setBarProgress();
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
    document.querySelector('#ptc-'+oldIndex).classList.remove("active-track");
    this.pauseToPlay(oldIndex);
    document.querySelector('#ptc-'+newIndex).classList.add("active-track");
    this.playToPause(newIndex)
  }

  function playToPause(index){
    var ele = document.querySelector('#p-img-'+index)
    ele.classList.remove("fa-play");
    ele.classList.add("fa-pause");
  }

  function pauseToPlay(index){
    var ele = document.querySelector('#p-img-'+index)
    ele.classList.remove("fa-pause");
    ele.classList.add("fa-play");
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

<?php include('footer.blade.php'); ?>
