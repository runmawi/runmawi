<?php include('header.php'); ?>

<style type="text/css">
      #myProgress {
    background-color: #8b0000; 
    cursor: pointer;
    border-radius: 10px;
  }
    .form-control{
        color: #000!important;
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
    
  
 
  padding: 25px;
  /*background: linear-gradient(180deg, #151517 127.69%, #282834 0% );*/
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
      padding:5px 15px;
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
      <p ><h3 class="text-center">No Audio Available</h3>
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
          <audio id="myAudio" ontimeupdate="onTimeUpdate()" autoplay >
            <source id="source-audio" src="" autoplay type="audio/mpeg"> Your browser does not support the audio element.
          </audio>
              <!-- <div class="cinetpay_button"> -->
                  <!-- CinetPay Button -->
                  <!-- <button onclick="cinetpay_checkout()" id="enable_button" style="display:none;margin-left: 72%;position: absolute;margin-top: 20px;"
                      class="btn2  btn-outline-primary">Purchase to Play Audio</button> -->

                                     <!-- Subscriber Button -->
                         
                                      <!-- <a href="<?php echo URL::to('/becomesubscriber'); ?>"  ><button  id="Subscriber_button" style="display:none;margin-left: 72%;position: absolute;margin-top: 20px;"
                      class="btn2  btn-outline-primary">Become Subscriber</button> 
                      </a> -->


            
              <!-- </div> -->
              <div class="stripe_button">
                  <!-- stripe Button -->
                  <button onclick="stripe_checkout()" id="enable_button" style="display:none;margin-left: 72%;position: absolute;margin-top: 20px;"
                      class="btn2  btn-outline-primary">Purchase to Play Audio</button>

                                     <!-- Subscriber Button -->
                         
                                      <a href="<?php echo URL::to('/becomesubscriber'); ?>"  ><button  id="Subscriber_button" style="display:none;margin-left: 66%;position: absolute;margin-top: 20px;"
                      class="btn bd btn-action">Subscribe to continue listening</button> 
                      </a>

              </div>
           <div class="player-ctn" style="background-image:linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1)),url('<?= URL::to('/').'/public/uploads/albums/'. $album->album ?>');background-size: cover;
    background-repeat: no-repeat;
    background-position: right;">
            <div class="row align-items-center mb-4">

              <div class="col-sm-3">
                <img height="150" width="150" id="audio_img" src="">
              </div>

              <div class="col-sm-8 col-md-8 col-xs-8">
                <div class="album_bg">
                  <div class="album_container">
                    <div class="blur"></div>
                    <div class="overlay_blur">

                      <h4 class="hero-title album mb-2"> <?= $album->albumname; ?></h4>
                      <!-- <p class="mt-2">Music by    <br>A. R. Rahman</p> -->

                      <div class="d-flex" style="justify-content: space-between;width: 33%;align-items: center;">

                        <div onclick="toggleAudio()">
                          <button class="btn bd btn-action" id="vidbutton" style="width:80px" ><i class="fa fa-play mr-2" aria-hidden="true"  ></i> Play</button>
                        </div>

                      <a aria-hidden="true" class="albumfavorite <?php echo albumfavorite($album->id);?>" data-authenticated="<?= !Auth::guest() ?>" data-album_id="<?= $album->id ?>"><?php if(albumfavorite($album->id) == "active"): ?><i id="ff" class="fa fa-heart" aria-hidden="true"></i><?php else: ?><i id="ff" class="fa fa-heart-o" aria-hidden="true"></i><?php endif; ?></a>
                        <i class="ri-thumb-up-line like" aria-hidden="true"  id="ff"  data-authenticated="<?= !Auth::guest() ?>"></i>
                        <i class="ri-thumb-down-line dislike" aria-hidden="true"   id="ff" data-authenticated="<?= !Auth::guest() ?>"></i>

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
                      <div>
                    <?php if(!Auth::guest()){ ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      Create PlayList
                    </button>
                    <?php } ?>
                    </div>
                  </div>

                  </div>
              </div>    
            </div>
          </div>
        </div>

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
          <div class="playlist-ctn"> <h6 class="mb-2 font-weight-bold">AUDIO LIST <i class="fa fa-arrow-right" aria-hidden="true"></i></h6>
        </div>
      </div>
        </div>
    </div>
</div>
    </div>

<div class="clear"></div>  

<?php } ?>
<div class="container-fluid overflow-hidden">
<div class="row album-top-30 mt-3 p-0">  
<div class="col-sm-12">
<p  class="album-title">Other Albums </p>
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
<!-- Playlist  -->

<div class="container-fluid">

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-black" id="exampleModalLabel">Create PlayList</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	        
      <form  id="my-playlist-form" accept-charset="UTF-8"  enctype="multipart/form-data"  action="<?= URL::to('/playlist/store') ?>" method="post">
      
      <div class="col-sm-10 p-0">
            <label for="name">PlayList Title</label>
            <input name="title" id="title" placeholder="PlayList Title" class="form-control text-black"  />
          </div>
          <div class="col-sm-10 p-0">
		
            <label for="name">PlayList Image</label>
            <input type="file" name="image" id="image" />
          </div>
     
      <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
<br>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" id="store-play-list" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

</div>

<?php                 
$payment_settings = App\PaymentSetting::first();

$mode = $payment_settings->live_mode;
if ($mode == 0) {
    $secret_key = $payment_settings->test_secret_key;
    $publishable_key = $payment_settings->test_publishable_key;
} elseif ($mode == 1) {
    $secret_key = $payment_settings->live_secret_key;
    $publishable_key = $payment_settings->live_publishable_key;
} else {
    $secret_key = null;
    $publishable_key = null;
} ?>


<input type="hidden" id="publishable_key" name="publishable_key"
                        value="<?php echo $publishable_key; ?>">

<script type="text/javascript">
$(document).ready(function() {

  
$('#store-play-list').click(function(){
				$('#my-playlist-form').submit();
			});


$(".my-div").on("contextmenu",function(){
return false;
}); 
});
</script>

<!--<script type="text/javascript">

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

//   function loadNewTrackold(index){

//     var access = listAudio[index].access

//     var audioppv_id  = listAudio[index].id
            


//       if(access == 'guest'){
//         // alert(access);
//       var player = document.querySelector('#source-audio')

//       player.src = listAudio[index].mp3_url

//       document.querySelector('.title').innerHTML = listAudio[index].title
//  var image = document.querySelector('#audio_img')
//     image.src = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].image
   
//       this.currentAudio = document.getElementById("myAudio");
//       this.currentAudio.load()
//       this.toggleAudio()
//       this.updateStylePlaylist(this.indexAudio,index)
//       this.indexAudio = index;
//     }else if(access == 'ppv'){ 

//       var audioppv = <?php echo json_encode($audioppv) ?>;
      
//       var countaudioppv = [];    

//       // audioppv.forEach(element => console.log(element));
//       audioppv.forEach(element => {
//             if(element.audio_id == audioppv_id) {
//               // alert(audioppv_id);
//               countaudioppv.push(1) 
//             }       
//           });

//         if(countaudioppv.length > 0 || role == 'subscriber'){
//             var player = document.querySelector('#source-audio')

//             player.src = listAudio[index].mp3_url

//             document.querySelector('.title').innerHTML = listAudio[index].title

//             this.currentAudio = document.getElementById("myAudio");
//             this.currentAudio.load()
//             this.toggleAudio()
//             this.updateStylePlaylist(this.indexAudio,index)
//             this.indexAudio = index;
//         }else{
//             var player = document.querySelector('#source-audio')

//             player.src = ''

//             document.querySelector('.title').innerHTML = listAudio[index].title

//             this.currentAudio = document.getElementById("myAudio");
//             this.currentAudio.load()
//             this.toggleAudio()
//             this.updateStylePlaylist(this.indexAudio,index)
//             this.indexAudio = index;

//             document.getElementById("enable_button").setAttribute("data-price", listAudio[index].ppv_price);
//             document.getElementById("enable_button").setAttribute("audio-id", listAudio[index].id);

//             document.querySelector('#enable_button').style.display = 'block';
//             alert("Purchase Audio");   


//         }
//     }else if(access == 'subscriber'){ 


//       var role = <?php echo json_encode($role) ?>;
//       // alert(role);

//       if(role == 'subscriber'){
//             var player = document.querySelector('#source-audio')

//             player.src = listAudio[index].mp3_url

//             document.querySelector('.title').innerHTML = listAudio[index].title

//             this.currentAudio = document.getElementById("myAudio");
//             this.currentAudio.load()
//             this.toggleAudio()
//             this.updateStylePlaylist(this.indexAudio,index)
//             this.indexAudio = index;
//         }else{
//             var player = document.querySelector('#source-audio')

//             player.src = ''

//             document.querySelector('.title').innerHTML = listAudio[index].title

//             this.currentAudio = document.getElementById("myAudio");
//             this.currentAudio.load()
//             this.toggleAudio()
//             this.updateStylePlaylist(this.indexAudio,index)
//             this.indexAudio = index;

//             document.querySelector('#Subscriber_button').style.display = 'block';
//             alert("Become Subscriber to Listen this Audio");   


//         }

//     }

//   }


  
  function loadNewTrack(index){

      var access = listAudio[index].access

      var audioppv_id  = listAudio[index].id
      
      var role = <?php echo json_encode($role) ?>;
      if(role == 'admin'){
            var player = document.querySelector('#source-audio')
          player.src = listAudio[index].mp3_url
          document.querySelector('.title').innerHTML = listAudio[index].title    
          document.querySelector(".like").setAttribute("data-audio-id", listAudio[index].id);
          document.querySelector(".like").setAttribute("data-audio-slug", listAudio[index].slug);
          document.querySelector(".dislike").setAttribute("data-audio-id", listAudio[index].id);
          var image = document.querySelector('#audio_img')
          image.src = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].image 

          var divElement = document.getElementById("player-ctn");
          var player_imageURL = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].player_image 
          divElement.style.backgroundImage = "linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1))," + "url('" + player_imageURL + "')";

          this.currentAudio = document.getElementById("myAudio");
          this.currentAudio.load()
          this.toggleAudio()
          this.updateStylePlaylist(this.indexAudio,index)
          this.indexAudio = index;
      }else{

        if(access == 'guest'){
          // alert(access);

          document.querySelector('#enable_button').style.display = 'none';
          document.querySelector(".like").setAttribute("data-audio-id", listAudio[index].id);
          document.querySelector(".like").setAttribute("data-audio-slug", listAudio[index].slug);
          document.querySelector(".dislike").setAttribute("data-audio-id", listAudio[index].id);
        var player = document.querySelector('#source-audio')

        player.src = listAudio[index].mp3_url

        document.querySelector('.title').innerHTML = listAudio[index].title

        this.currentAudio = document.getElementById("myAudio");
        this.currentAudio.load()
        this.toggleAudio()
        this.updateStylePlaylist(this.indexAudio,index)
        this.indexAudio = index;
      }else if(access == 'ppv'){ 
        // alert(audioppv_id);
        var audioppv = <?php echo json_encode(@$ablum_audios); ?>;    
          document.querySelector(".like").setAttribute("data-audio-id", listAudio[index].id);
          document.querySelector(".like").setAttribute("data-audio-slug", listAudio[index].slug);
          document.querySelector(".dislike").setAttribute("data-audio-id", listAudio[index].id);
        var ppv_audio_status = 0;

        var id = audioppv_id ;
        <?php 
        $PpvPurchasestatus = App\PpvPurchase::where('user_id',Auth::user()->id)->where('audio_id',@$audio_id)->count();
        ?>
        // alert(id);
        $.ajax({
            url: '<?php echo URL::to('purchased-audio-check'); ?>',
            type: "post",
            data: {
                _token: '<?php echo csrf_token(); ?>',
                audio_id: audioppv_id,

            },
            success: function(value) {
                var ppv_audio_status  = value ;
                
                return ppv_audio_status;

            },
            error: (error) => {
                swal('error');
                
            }

        });
      // alert(ppv_audio_status);
      if(ppv_audio_status == 0){
            // alert(value);
            var countaudioppv = [];    

            // audioppv.forEach(element => console.log(element));
            audioppv.forEach(element => {
                  if(element.audio_id == audioppv_id) {
                    // alert(audioppv_id);
                    countaudioppv.push(1) 
                  }       
                });

              if(countaudioppv.length > 0 || role == 'subscriber'){
                  var player = document.querySelector('#source-audio')

                  player.src = listAudio[index].mp3_url

                  document.querySelector('.title').innerHTML = listAudio[index].title

                  this.currentAudio = document.getElementById("myAudio");
                  this.currentAudio.load()
                  this.toggleAudio()
                  this.updateStylePlaylist(this.indexAudio,index)
                  this.indexAudio = index;
              }else{
                  var player = document.querySelector('#source-audio')

                  player.src = ''

                  document.querySelector('.title').innerHTML = listAudio[index].title

                  this.currentAudio = document.getElementById("myAudio");
                  this.currentAudio.load()
                  this.toggleAudio()
                  this.updateStylePlaylist(this.indexAudio,index)
                  this.indexAudio = index;

                  document.getElementById("enable_button").setAttribute("data-price", listAudio[index].ppv_price);
                  document.getElementById("enable_button").setAttribute("audio-id", listAudio[index].id);

                  document.querySelector('#enable_button').style.display = 'block';
                  alert("Purchase Audio");   


              }
            }else{


            document.querySelector('#enable_button').style.display = 'none';

                var player = document.querySelector('#source-audio')

                player.src = listAudio[index].mp3_url
                // alert('ppv_audio_status');

                document.querySelector('.title').innerHTML = listAudio[index].title

                this.currentAudio = document.getElementById("myAudio");
                this.currentAudio.load()
                this.toggleAudio()
                this.updateStylePlaylist(this.indexAudio,index)
                this.indexAudio = index;
            }
      }else if(access == 'subscriber'){ 


        var role = <?php echo json_encode($role) ?>;
        // alert(role);
        document.querySelector(".like").setAttribute("data-audio-id", listAudio[index].id);
        document.querySelector(".like").setAttribute("data-audio-slug", listAudio[index].slug);
        document.querySelector(".dislike").setAttribute("data-audio-id", listAudio[index].id);
        if(role == 'subscriber'){
              var player = document.querySelector('#source-audio')

              player.src = listAudio[index].mp3_url

              document.querySelector('.title').innerHTML = listAudio[index].title

              this.currentAudio = document.getElementById("myAudio");
              this.currentAudio.load()
              this.toggleAudio()
              this.updateStylePlaylist(this.indexAudio,index)
              this.indexAudio = index;
          }else{
              var player = document.querySelector('#source-audio')

              player.src = ''

              document.querySelector('.title').innerHTML = listAudio[index].title

              this.currentAudio = document.getElementById("myAudio");
              this.currentAudio.load()
              this.toggleAudio()
              this.updateStylePlaylist(this.indexAudio,index)
              this.indexAudio = index;

              document.querySelector('#Subscriber_button').style.display = 'block';
              alert("Become Subscriber to Listen this Audio");   


          }

      }
}
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

  var access = <?php echo json_encode(@$first_album_access) ; ?>  
  var role = <?php echo json_encode(@$role) ; ?>  
  var ppv_status = <?php echo json_encode(@$ppv_status) ; ?>  
  var audiosid = <?php echo json_encode(@$first_album_id) ; ?>  
  var audioslug = <?php $first_album_slug = $album_audios->first() ? $album_audios->first()->image : null;
                   echo json_encode(@$first_album_slug) ; ?>
  // alert(ppv_status)
  if(role == 'admin'){
    document.querySelector('#source-audio').src = <?php echo json_encode(@$first_album_mp3_url) ; ?>  
    document.querySelector(".dislike").setAttribute("data-audio-id", audiosid);
    document.querySelector(".like").setAttribute("data-audio-slug", audioslug);
    document.querySelector(".like").setAttribute("data-audio-id", audiosid);
  }else{
    if(access == 'ppv' && ppv_status == 0){
      document.getElementById("enable_button").setAttribute("data-price", <?php echo json_encode(@$first_album_ppv_price) ; ?>);
      document.getElementById("enable_button").setAttribute("audio-id", <?php echo json_encode(@$first_album_id) ; ?>);
      document.querySelector('#enable_button').style.display = 'block';
      document.querySelector('#source-audio').src = '';
      document.querySelector(".dislike").setAttribute("data-audio-id", audiosid);
      document.querySelector(".like").setAttribute("data-audio-slug", audioslug);
      document.querySelector(".like").setAttribute("data-audio-id", audiosid);
          alert("Purchase Audio"); 
    }else{
      document.querySelector('#source-audio').src = <?php echo json_encode(@$first_album_mp3_url) ; ?>  
      document.querySelector(".dislike").setAttribute("data-audio-id", audiosid);
      document.querySelector(".like").setAttribute("data-audio-slug", audioslug);
      document.querySelector(".like").setAttribute("data-audio-id", audiosid);
    }
  }

  document.querySelector('.title').innerHTML = <?php echo json_encode($first_album_title) ; ?>  
  var player_images = '<?php echo URL::to('/public/uploads/images/');?>'; 
  var player_imagess = player_images +'/' + <?php echo json_encode(@$album->player_image) ; ?>;

  var first_audio_image = player_images +'/' + <?php echo json_encode($first_audio_image) ; ?>;
  $("#audio_img").attr('src', first_audio_image);
    
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
      }else{
              var url =  "<?php echo URL::to('audio/related-playlist')  ?>";
              var  audio_id = document.querySelector(".like").getAttribute("data-audio-id");
              var  audio_slug = document.querySelector(".like").getAttribute("data-audio-slug");
              var link_url = url+'/'+audio_slug;
              location.href = link_url;
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


<!-- Cinet Pay CheckOut -->

<script src="https://cdn.cinetpay.com/seamless/main.js"></script>

<script>

 
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

      var ppv_price = document.getElementById("enable_button").getAttribute("data-price");
      var audio_id = document.getElementById("enable_button").getAttribute("audio-id");

  
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
                    url: '<?php echo URL::to('CinetPay-audio-rent'); ?>',
                    type: "post",
                    data: {
                        _token: '<?php echo csrf_token(); ?>',
                        amount: ppv_price,
                        audio_id: audio_id,

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
</script>


<script src="https://checkout.stripe.com/checkout.js"></script>

<script>

function stripe_checkout() {
  
  var publishable_key = $('#publishable_key').val();

  var video_id = $('#video_id').val();

  var ppv_price = document.getElementById("enable_button").getAttribute("data-price");
  var audio_id = document.getElementById("enable_button").getAttribute("audio-id");

  // alert(ppv_price);
  // alert(audio_id);
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
              url: '<?php echo URL::to('purchase-audio'); ?>',
              method: 'post',
              data: {
                  "_token": "<?php echo csrf_token(); ?>",
                  tokenId: token.id,
                  amount: ppv_price,
                  audio_id: audio_id
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
      amount: ppv_price * 100
  });
}


  </script>

<?php include('footer.blade.php'); ?>
