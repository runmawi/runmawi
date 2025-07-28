<?php include(public_path('themes/theme5-nemisha/views/header.php'));  
   $audio = $audios ;
   
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
padding-top: 10px;
width: 30px;
}
.btn-ctn, .infos-ctn{
display: flex;
align-items: center;
justify-content: space-evenly;
}
.infos-ctn{
padding-top: 20px;
}
.btn-ctn > div {
padding: 5px;
margin-top: 18px;
margin-bottom: 18px;
}
.infos-ctn > div {
margin-bottom: 8px;
color: rgb(0, 82, 204);
text-align: left;
}
.first-btn{
margin-left: 3px;
}
.duration{
margin-left: 10px;
}
.title{
/*margin-left: 10px;
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
max-height:335px;
scrollbar-color: rebeccapurple green!important;
overflow-x: hidden;
}
.active-track{
background: #4d4d4d;
color: #ffc266 !important;
font-weight: bold;
}
label{
color: #000;
}
.active-track > .playlist-info-track,.active-track >.playlist-duration,.active-track > .playlist-btn-play{
color: #ffc266 !important;
}
.form-control{
color: #000!important;
font-weight: 700;
border-radius: 5px;
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
.audio-js *, .audio-js :after, .audio-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.vjs-texttrack-settings { display: none; }
.audio-js .vjs-big-play-button{ border: none !important; }
.bd{padding:10px 15px;background: #ed1c24 !important;}
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
.img-responsive{
border-radius: 10px;
}
.fa-heart{color: red !important;}
.flexlink{
position: relative;
top: 63px;
left: -121px;
}
#ff{
border: 2px solid #fff;
border-radius: 50%;
padding: 10px;
font-size: 16px;
color: #fff;
display: flex;
justify-content: center;
align-items: center;
}
.audio-lp{
background: linear-gradient(180deg, #151517 127.69%, #282834 0% );
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
/* <!-- BREADCRUMBS  */
   .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
       content: none; 
   } 
   
   ol.breadcrumb {
         color: white;
         background-color: transparent !important  ;
         font-size: revert;
   }
ul.share-icon-aud li {display: inline-block; padding: 0 6px;}
@media(max-width: 767px) { ul.share-icon-aud li {padding: 5px 2px;} }

</style>
<?php if (Session::has('message')): ?>
    <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;" ><?php  echo Session::get('message') ?></div>
<?php endif ;?>

<?php if (isset($error)) { ?>
   <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;">
       <p ><h3 class="text-center"><?php echo $message;?></h3>
   </div>
   <?php } else { ?>
   
   <input type="hidden" value="<?php echo URL('/');?>" id="base_url">
   <div id="audio_bg" >
   <div id="audio_bg_dim" <?php if($audio->access == 'guest' || ($audio->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
   <div class="container-fluid">
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
<?php if (  !Auth::guest() && $audio->ppv_status == 1 && $settings->ppv_status == 1 && $ppv_status == 0 && Auth::user()->role != 'admin' ) { ?>
<div id="subscribers_only">
   <a class="text-center btn btn-success" id="paynowbutton"> Pay for View  </a>
</div>
<?php } else { ?>                
<div class="row album-top-30 mt-4 ">
   <div class="col-lg-8">
      <div class="player-ctn" id="player-ctn" style="background-image:linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1)),url('<?= URL::to('/').'/public/uploads/images/'. $audio->player_image ?>');background-size: cover;background-repeat: no-repeat;background-position: right;">
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
                        <p class="mt-2">Music by <?php echo get_audio_artist($audio->id); ?></p>
                        <p class="mt-2">Album <a href="<?php echo URL::to('/').'/album/'.$album_slug;?>"><?php echo ucfirst($album_name); ?></a></p>
                        <div class="d-flex" style="justify-content: space-between;width: auto;align-items: center;">
                           <ul class="p-0 share-icon-aud">
                              <li >
                                 <div onclick="toggleAudio()">
                                    <button class="btn bd btn-action" id="vidbutton" style="width:100%;" ><i class="fa fa-play mr-2" aria-hidden="true"  ></i> Play</button>
                                 </div>
                              </li>
                              <li>
                                 <a aria-hidden="true" class="favorite <?php echo audiofavorite($audio->id);?>" data-authenticated="<?= !Auth::guest() ?>" data-audio_id="<?= $audio->id ?>"><?php if(audiofavorite($audio->id) == "active"): ?><i id="ff" class="fa fa-heart" ></i><?php else: ?><i id="ff" class="fa fa-heart-o" ></i><?php endif; ?></a>
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
                              <li>
                              <div>
                                 <?php if(!Auth::guest()){ ?>
                                 <button type="button" style="width:100%;" class="btn bd btn-primary" data-toggle="modal" data-target="#exampleModal">
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
            <?php /*{ ?> <img src="<?= URL::to('/').'/public/uploads/images/'. $audio->image ?>"  class="img-responsive mb-2" / width="100">
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
      <!-- <div class="col-sm-12 db p-0 mt-4">
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
         </div>-->
   </div>
   <div class="col-lg-4 p-0">
      <audio id="myAudio" ontimeupdate="onTimeUpdate()">
         <source id="source-audio" src="" type="audio/mpeg">
         Your browser does not support the audio element.
      </audio>
      <div class="play-border">
         <div class="playlist-ctn">
            <h6 class="mb-2 font-weight-bold">AUDIO LIST <i class="fa fa-arrow-right" aria-hidden="true"></i></h6>
         </div>
      </div>
   </div>
</div>
</div>
<div class="row mt-5">
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
                  <input name="title" id="title" placeholder="PlayList Title" class="form-control text-black" />
                  <small id="title-error" class="text-danger" style="display: none;">Playlist title is required.</small>
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
   <!-- BREADCRUMBS -->
   <div class="ml-2">
      <div class="row">
         <div class=" container-fluid video-list you-may-like overflow-hidden">
            <div class="bc-icons-2">
               <ol class="breadcrumb" style="isplay: flex; justify-content: start;align-items: center;">
                  <li class="breadcrumb-item"><a class="black-text" href="<?= route('Audios_list') ?>"><?= ucwords('Audios') ?></a>
                     <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                  </li>
                  <?php foreach ($category_name as $key => $audio_category_name) { ?>
                  <?php $category_name_length = count($category_name); ?>
                  <li class="breadcrumb-item">
                     <a class="black-text" href="<?= route('AudioCategory',[ $audio_category_name->categories_slug ])?>">
                     <?= ucwords($audio_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?> 
                     </a>
                  </li>
                  <?php } ?>
                  <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                  <li class="breadcrumb-item"><a class="black-text"><?php echo (strlen($audio->title) > 50) ? ucwords(substr($audio->title,0,120).'...') : ucwords($audio->title); ?> </a></li>
               </ol>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Comment Section -->
<?php if( App\CommentSection::first() != null && App\CommentSection::pluck('audios')->first() == 1 ): ?>
<div class="row">
   <div class=" container-fluid video-list you-may-like overflow-hidden">
      <h4 class="" style="color:#fffff;"><?php echo __('Comments');?></h4>
      <?php include('comments/index.blade.php');?>
   </div>
</div>
<?php endif; ?>
<div class="container-fluid">
   <div class="row album-top-30 mt-3">
      <div class="col-sm-12">
         <h4  class="album-title">Other Albums </h4>
         <div class="favorites-contens">
         <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php foreach ($other_albums as $other_album) { ?>
               <li class="slide-item">
                  <?php if($other_album->album != ''){ ?>
                  <a href="<?php echo URL('/').'/album/'.$other_album->slug; ?>">
                     <div class="block-images position-relative">
                        <div class="img-box">
                           <img src="<?= URL::to('/').'/public/uploads/albums/' . $other_album->album ?>"  class="img-responsive w-100" />   
                        </div>
                        <div class="block-description">
                           <div class="hover-buttons text-white">
                              <p class="mt-2"><?php echo ucfirst($other_album->albumname);?> </p>
                           </div>
                           <?php  } ?> 
                        </div>
                     </div>
                  </a>
               </li>
              <?php } ?>
            </ul>
         </div>
      </div>
   </div>
   <?php endif; ?>
   <div class="">
      <!-- <audio  id="video_player" onended="autoplay1()" autoplay class="audio-js vjs-default-skin my-div" controls preload="auto"  style="width: 100%;height: 50px;position: fixed;width: 100%;left: 0;bottom: 0;  z-index: 9999;" controlsList="nodownload">
         <source src="<?= $audio->mp3_url; ?>" type="audio/mpeg">
         Your browser does not support the audio element.
         </audio>
         
         <div id="jquery_jplayer_1" class="jp-jplayer"></div>
         <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
           <div class="jp-type-single">
             <div class="jp-gui jp-interface">
                 <div class="jp-details">
                     <img src="<?= URL::to('/').'/public/uploads/images/'. $audio->image ?>"  class="img-responsive" width="50">
               <div class="jp-title text-white" aria-label="title">&nbsp;</div>
             </div>
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
             
             <div class="jp-no-solution">
               <span>Update Required</span>
               To play the media you will need to either update your browser to a recent version or update your <a href="https://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
             </div>
           </div>
         </div>
         </div> -->
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
</div>
<script type="text/javascript">
   $('#store-play-list').click(function (e) {
      e.preventDefault();
      let title = $('#title').val().trim();
      if (title === '') {
         $('#title-error').show();
         return false;
      } else {
         $('#title-error').hide();
      }
      $('#my-playlist-form').submit();
   });
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
   
   var listAudio = <?php echo json_encode($ablum_audios); ?>;
   
   for (var i = 0; i < listAudio.length; i++) {
       createTrackItem(i,listAudio[i].title,listAudio[i].duration);
   }
   
   var indexAudio = 0;
   
   function loadNewTrack(index){
     
     var player = document.querySelector('#source-audio')
     player.src = listAudio[index].mp3_url
     document.querySelector('.title').innerHTML = listAudio[index].title
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
   
   document.querySelector('#source-audio').src = <?php echo json_encode(@$audios->mp3_url) ; ?>  
   document.querySelector('.title').innerHTML = <?php echo json_encode(@$audios->title) ; ?>  
   var player_images = '<?php echo URL::to('/public/uploads/images/');?>'; 
   var audio_images = player_images +'/' + <?php echo json_encode(@$audio->image) ; ?>;
   $("#audio_img").attr('src', audio_images);
   
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
<?php include(public_path('themes/theme5-nemisha/views/footer.blade.php')); ?>