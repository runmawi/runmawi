<?php include('header.php');?>

<link href="<?php echo URL::to('/').'/assets/dist/videojs-watermark.css';?>" rel="stylesheet">
<link href="<?php echo URL::to('/').'/assets/dist/videojs-resolution-switcher.css';?>" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.css" rel="stylesheet">
 
<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>

     
<style>
.blink_me {
animation: blinker 2s linear infinite;
}
@keyframes blinker {
50% {
opacity: 0;
}
}
.video-js{height: 500px !important;}
.video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.social_share {
display: inline-block !important;
border-radius: 5px !important;
vertical-align: middle !important;
}
.rrssb-buttons.tiny-format li {
padding-right: 7px;
}
.rrssb-buttons li {
float: left;
height: 100%;
line-height: 13px;
list-style: none;
margin: 0;
padding: 0 2.5px;
}
.video-details {
margin: 0 auto !important;
padding-bottom: 30px !important;
padding-left: 40px !important;
}
.social_share p {
display: inline-block;
font-weight: 700;
font-family: 'Roboto', sans-serif;
font-size: 16px;
}
#social_share {
display: inline-block;
vertical-align: middle;
}
#video_title h1 {
color: #fff;
font-size: 30px;
margin: 20px 0px;
line-height: 22px;
}
.btn.watchlater, .btn.mywishlist {
font-weight: 600;
font-family: 'Roboto', sans-serif;
font-size: 15px;
background: #000;
border: 1px solid #000;
color: #fff;
}
a.ytp-impression-link {
display: none !important;
}
.ytp-impression-link {
display: none !important;
}
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
#video_container{height: auto;padding-top: 120px !important;;width: 95%;margin: 0 auto;}
/*    #video_bg_dim {background: #1a1b20;}*/
.video-js .vjs-tech {outline: none;}
.video-details h1{margin: 0 0 10px;color: #fff;}
.vid-details{margin-bottom: 20px;}
#tags{margin-bottom: 10px;}
.share{display: flex;align-items: center;}
.share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
.share a{padding: 0 20px;}
.cat-name span{margin-right: 10px;}
.video-js .vjs-seek-button.skip-back.skip-10::before,
.video-js.vjs-v6 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before,
.video-js.vjs-v7 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before {
content: '\e059'
}
.btn.btn-default.views {
color: #fff !important;
}
</style>
 
<style>

.vjs-skin-hotdog-stand { color: #FF0000; }
.vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
.vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }
.rent-card{
width: 120% !important;
height: 30px !important;
}
/* scroller */
.scroller { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
.scroller::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
.scroller::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
#sidebar-scrollbar { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
#sidebar-scrollbar::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
/*#sidebar-scrollbar { height: calc(100vh - 153px) !important; }*/
#sidebar-scrollbar::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
::-webkit-scrollbar { width: 8px; height: 8px; border-radius: 5px; }
li.list-group-item {
background-color: transparent !important;
padding-right: unset !important;
}
li.list-group-item a{
background: transparent !important;
color: var(--iq-body-text) !important;
font-size: 12px !important;
padding-left: 10px !important;
}
li.list-group-item a:hover{
color: var(--iq-primary) !important;
}
.search_content{
top: 85px !important;
width: 400px !important;
margin-right: -15px !important;

}
ul.list-group {
text-align: left !important;
max-height: 450px !important;
}
li.list-group-item {
width: 375px;
}
h3 {
font-size: 24px !important;
}
.playvid {
display: block;
width: 280%;
height: auto !important;
margin-left: -410px;
}
.btn.btn-primary.close {
margin-right: -17px;
background-color: #4895d1 !important;
}
button.close {
padding: 9px 30px !important;   
border: 0;
-webkit-appearance: none;
}
.close{
margin-right: -429px !important;
margin-top:-1327px !important;
}
.modal-footer {
border-bottom: 0px !important;
border-top: 0px !important;
} 
</style>
<!-- Header End -->
<!-- Slider Start -->
<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="slider m-0 p-0">
    <?php if(isset($videos)) :
            foreach($videos as $watchlater_video): ?>
    <?php 
        $i = 1;
        foreach ($banner as $key => $bannerdetails) { ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image" >
            <a href="<?=$bannerdetails->link;  ?>">
    <div class="slide slick-bg s-bg-1" style="background: url('<?php echo URL::to('/').'/public/uploads/img/' ?>') no-repeat;background-size: cover;">
       <div class="container-fluid position-relative h-100">
          <div class="slider-inner h-100">
             <div class="row align-items-center  h-100">
                <div class="col-xl-6 col-lg-12 col-md-12">
                   <a href="javascript:void(0);">
                      <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                         <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
                      </div>
                   </a>
                   <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                      data-delay-in="0.6"><?php echo __($watchlater_video->title); ?></h1>
                   <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                      <span class="badge badge-secondary p-2">18+</span>
                      <span class="ml-3">2 Seasons</span>
                   </div>
                   <p data-animation-in="fadeInUp" data-delay-in="1.2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                      dummy text ever since the 1500s.
                   </p>
                    <!--<p data-animation-in="fadeInUp" data-delay-in="1.2" style="overflow: hidden !important;text-overflow: ellipsis !important;height: 100px;"><?php echo __($watchlater_video->description); ?>
                   </p>-->
                   <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                      <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover"><i class="fa fa-play mr-2"
                         aria-hidden="true"></i>Play Now</a>
                      <a href="https://flicknexui.webnexs.org/" class="btn btn-link">More details</a>
                   </div>
                </div>
             </div>
             <div class="trailor-video">
                <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="video-open playbtn">
                   <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                      x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7"
                      enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                      <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                         stroke-linejoin="round" stroke-miterlimit="10"
                         points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                      <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                         stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                   </svg>
                   <span class="w-trailor">Watch Trailer</span>
                </a>
             </div>
          </div>
       </div>
    </div>
    </a>
</div>
     <?php $i++; } ?>
     <?php endforeach; 
                 endif; ?>
 </div>
 <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
       fill="none" stroke="currentColor">
       <circle r="20" cy="22" cx="22" id="test"></circle>
    </symbol>
 </svg>
</section>
<!-- Slider End -->


<!-- MainContent -->
<div class="main-content">
  <section id="iq-continue">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12 overflow-hidden">
             <div class="iq-main-header d-flex align-items-center justify-content-between">
                <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Continue Watching</a></h4>                      
             </div>
             <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                     <?php  if(isset($videos)) :
                           foreach($videos as $watchlater_video): ?>
                   <li class="slide-item">
                      <a href="<?php echo URL::to('home') ?>">
                         <div class="block-images position-relative">
                            <div class="img-box">
                               <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                            </div>
                            <div class="block-description">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">   <h6><?php echo __($watchlater_video->title); ?></h6></a>
                               <div class="movie-time d-flex align-items-center my-2">
                                  <div class="badge badge-secondary p-1 mr-2">13+</div>
                                  <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                               </div>
                               <div class="hover-buttons">
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl<?= $watchlater_video->id;?>">
                                  <span class="btn btn-hover">
                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                  Play Now
                                  </span>
                                      </button> 

                               </div>
                                <div >
                                    <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                        <span class="text-center thumbarrow-sec">
                                            <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                        </span>
                                            </button></div>
                                </div>
                            <div class="block-social-info">
                               <ul class="list-inline  music-play-lists list-group-horizontal">
                                  <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                  <li><span><i class="ri-heart-fill"></i></span></li>
                                  <li><span><i class="ri-add-line"></i></span></li>
                               </ul>
                            </div>
                         </div>
                      </a>
                   </li>

                    <?php endforeach; 
                          endif; ?>
                </ul>
             </div>
          </div>
       </div>
    </div>
    <?php  if(isset($videos)) :
           foreach($videos as $watchlater_video): ?>
            <div class="modal fade bd-example-modal-xl<?= $watchlater_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="background-color: transparent !important;">
                         <div class="modal-body playvid">
                             <?php if($watchlater_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <iframe  width="100%" height="500" src="https://www.youtube.com/embed/<?= $watchlater_video->embed_code ?>" frameborder="0" allowfullscreen></iframe> <!-- <?= $watchlater_video->embed_code ?> -->
                                        </div>
                                    <?php  elseif($watchlater_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls poster="<?= URL::to('/public/') . '/uploads/images/' . $watchlater_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $watchlater_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                                    <?php  else: ?>
                                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                        <video id="videojs-seek-buttons-player" onplay="playstart()"   class="video-js vjs-default-skin" controls  poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >

                                        </video>


                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                             <?php endif; ?>
                        </div>

                        <div class="modal-footer" align="center" >
                            <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
                        onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>
                        </div>
                    </div>
                </div>
            </div>
      <?php endforeach; 
            endif; ?>
      <?php if(isset($videos)) :
            foreach($videos as $watchlater_video): ?>
                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                    <div class="img-black-back"></div>
                        <div align="right">
                            <button type="button" class="closewin btn btn-danger" id="cont_vid<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
                        </div>
                        <div class="tab-sec">
                            <div class="tab-content">
                                <div id="overview<?= $watchlater_video->id;?>" class="container tab-pane active"><br>
                                   <h1 class="movie-title-thumb"><?php echo __($watchlater_video->title); ?></h1>
                                   <p class="movie-rating">
                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $watchlater_video->rating;?></span>
                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                   </p>
                                   <p>Welcome</p>
                                    <!-- <div class="btn btn-danger btn-right-space br-0">
                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                    </div>-->
                                    <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                </div>
                                <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane ">
                                    <div class="block expand">
                                        <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >
                                            <?php if (!empty($watchlater_video->trailer)) { ?>
                                                <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
                                                <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
                                                </video>
                                            <?php } else { ?>
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
                                            <?php } ?>  
                                            <div class="play-button-trail" >

                                                <!--<a  href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">  
                                                <div class="play-block">
                                                <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                                                </div></a>-->
                                                <div class="detail-block">
                                                <!--<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
                                                </a>-->

                                                <!--<p class="movie-rating">
                                                <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                                                <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                                <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                                </p>-->
                                                </div>
                                            </div>
                                        </a>
                                        <div class="block-contents">
                                            <!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
                                        </div>
                                    </div> 
                                </div>
                                <div id="like<?= $watchlater_video->id;?>" class="container tab-pane "><br>
                                   <h2>More Like This</h2>
                                </div>
                                <div id="details<?= $watchlater_video->id;?>" class="container tab-pane ">
                                    <p><?php echo __($watchlater_video->description); ?></p>
                                </div>
                            </div>
                            <div align="center">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $watchlater_video->id;?>">OVERVIEW</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $watchlater_video->id;?>">TRAILER AND MORE</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#like<?= $watchlater_video->id;?>">MORE LIKE THIS</a>
                                    </li>
                                     <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#details<?= $watchlater_video->id;?>">DETAILS </a>        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
    <?php endforeach; 
          endif; ?>
    </section>
     <section id="iq-favorites">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="<?php echo URL::to('/latest-videos') ?>">Latest Videos</a></h4>                      
                     </div>
                     <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                             <?php  if(isset($latest_videos)) :
                             foreach($latest_videos as $watchlater_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl1<?= $watchlater_video->id;?>" >
                                          <span class="btn btn-hover">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Play Now
                                          </span>
                                           </button>
                                       </div>
                                        <div>
                                            <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button></div>
                                        </div>
                                    <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li ><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
              <?php  if(isset($latest_videos)) :
                             foreach($latest_videos as $watchlater_video): ?>
              <div class="modal fade bd-example-modal-xl1<?= $watchlater_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
        <div class="modal-body playvid">
                             <?php if($watchlater_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $watchlater_video->embed_code ?>
                                        </div>
                                    <?php  elseif($watchlater_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()" class="video-js vjs-default-skin" controls  poster="<?= URL::to('/public/') . '/uploads/images/' . $watchlater_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $watchlater_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                                    <?php  else: ?>
                                       

                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                             <?php endif; ?>
                        </div>
   
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
</div>
             <?php endforeach; 
                                       endif; ?>
                          <?php if(isset($latest_videos)) :
                                foreach($latest_videos as $watchlater_video): ?>
                                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="lv_vid<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $watchlater_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($watchlater_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $watchlater_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                            
                                                       <!-- <div class="btn btn-danger btn-right-space br-0">
                                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                                </div>-->
                                        <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
    
    <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

    
        <?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
                 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
      
                       <?php } ?>  
                  <div class="play-button-trail" >
        
<!--      <a  href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">  
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
        </div></a>-->
                <div class="detail-block">
<!--          <a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
          </a>-->
          
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
          </p>-->

        </div>
    </div>
    </a>
    <div class="block-contents">
      <!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
        </div>
  </div> 
              
    </div>
    <div id="like<?= $watchlater_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $watchlater_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
  </div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $watchlater_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $watchlater_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $watchlater_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $watchlater_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>


  
                                    </div></div>

<?php endforeach; 
endif; ?>
</section>
    <section id="iq-upcoming-movie">
        <?php if ( GetTrendingVideoStatus() == 1 ) { ?>
            <div class="video-list">
            <?php if ( count($trendings) > 0 ) { 
                include('partials/trending-videoloop.php');
            } else {  ?>
                <p class="no_video"> No Video Found</p>
            <?php } ?>
            </div>
        <?php } ?>
    </section>
      <section id="iq-topten">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title topten-title-sm">Top 10 in India</h4>
                     </div>
                     <div class="topten-contens">
                        <h4 class="main-title topten-title">Top 10 in India</h4>
                        
                        <ul id="top-ten-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                              <?php  if(isset($latest_videos)) :
                             foreach($latest_videos as $watchlater_video): ?>
                           <li>
                              <a href="<?php echo URL::to('home') ?>">
                              <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                              </a>
                           </li> 
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                        <div class="vertical_s">
                           <ul id="top-ten-slider-nav" class="list-inline p-0 m-0  d-flex align-items-center">
                                <?php  if(isset($latest_videos)) :
                             foreach($latest_videos as $watchlater_video): ?>
                              <li>
                                 <div class="block-images position-relative active">
                                    <a href="<?php echo URL::to('home') ?>">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </a>
                                    <div class="block-description">
                                       <h5><?php echo __($watchlater_video->title); ?></h5>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">10+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                          <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover" tabindex="0">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i> Play Now
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <?php endforeach; 
                                       endif; ?>
                           </ul>
                        </div>
                         
                     </div>
                  </div>
               </div>
            </div>
         </section>
     <section id="iq-suggestede" class="s-margin">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">                       
                        <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Suggested For You </a></h4>                       
                     </div>
                     <div class="suggestede-contens">
                        <ul class="list-inline favorites-slider row p-0 mb-0">
                            <?php  if(isset($suggested_videos)) :
                             foreach($suggested_videos as $watchlater_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">11+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl3<?= $watchlater_video->id;?>">
                                          <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                              Play Now</span></button>
                                       </div>
                                         <div>
                                            <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button>
                                        </div>
                                    </div>
                                    <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>
                                 </div>
                              </a>
                           </li>
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
             <?php  if(isset($suggested_videos)) :
                             foreach($suggested_videos as $watchlater_video): ?>
                        <div class="modal fade bd-example-modal-xl3<?= $watchlater_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content" style="background-color: transparent !important;">
                                     <div class="modal-body playvid">
                             <?php if($watchlater_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $watchlater_video->embed_code ?>
                                        </div>
                                    <?php  elseif($watchlater_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls  poster="<?= URL::to('/public/') . '/uploads/images/' . $watchlater_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $watchlater_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                                    <?php  else: ?>
                                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                        <video id="videojs-seek-buttons-player" onplay="playstart()"   class="video-js vjs-default-skin" controls  poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >

                                        </video>


                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                             <?php endif; ?>
                        </div>
                                    <div class="modal-footer" align="center" >
                                        <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
                                    onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php endforeach; 
                                       endif; ?>
             <?php if(isset($suggested_videos)) :
                                foreach($suggested_videos as $watchlater_video): ?>
                                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $watchlater_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($watchlater_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $watchlater_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                            
                                                       <!-- <div class="btn btn-danger btn-right-space br-0">
                                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                                </div>-->
                                        <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
    
    <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

    
        <?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
                 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
      
                       <?php } ?>  
                  <div class="play-button-trail" >
        
<!--      <a  href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">  
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
        </div></a>-->
                <div class="detail-block">
<!--          <a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
          </a>-->
          
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
          </p>-->

        </div>
    </div>
    </a>
    <div class="block-contents">
      <!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
        </div>
  </div> 
              
    </div>
    <div id="like<?= $watchlater_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $watchlater_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
  </div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $watchlater_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $watchlater_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $watchlater_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $watchlater_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>


  
  </div></div>

<?php endforeach; 
endif; ?>
         </section>
      
         <section id="iq-trending" class="s-margin">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">                      
                        <h4 class="main-title"><a href="http://flicknexui.webnexs.org/">Trending</a></h4>                        
                     </div>
                     <div class="trending-contens">
                        <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center">
                            <?php  if(isset($trending_videos)) :
                             foreach($trending_videos as $watchlater_video): ?>
                           <li>
                              <a href="javascript:void(0);">
                                 <div class="movie-slick position-relative">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                 </div>
                              </a>
                           </li>
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                        <ul id="trending-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                            <?php  if(isset($trending_videos)) :
                             foreach($trending_videos as $watchlater_video): ?>
                           <li>
                              <div class="tranding-block position-relative"
                                 style="background-image: url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>');">
                                 <div class="trending-custom-tab">
                                    <div class="tab-title-info position-relative">
                                       <ul class="trending-pills d-flex nav nav-pills justify-content-center align-items-center text-center"
                                          role="tablist">
                                          <li class="nav-item">
                                             <a class="nav-link active show" data-toggle="pill" href="#trending-data1"
                                                role="tab" aria-selected="true">Overview</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data2" role="tab"
                                                aria-selected="false">Episodes</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data3" role="tab"
                                                aria-selected="false">Trailers</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data4" role="tab"
                                                aria-selected="false">Similar Like This</a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="trending-content">
                                       <div id="trending-data1" class="overview-tab tab-pane fade active show">
                                          <div class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="res-logo">
                                                   <div class="channel-logo">
                                                      <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                   </div>
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="d-flex align-items-center text-white text-detail">
                                                <span class="badge badge-secondary p-3">18+</span>
                                                <span class="ml-3">3 Seasons</span>
                                                <span class="trending-year">2020</span>
                                             </div>
                                             <div class="d-flex align-items-center series mb-4">
                                                <a href="javascript:void(0);"><img src="assets/images/trending/trending-label.png"
                                                   class="img-fluid" alt=""></a>
                                                <span class="text-gold ml-3">#2 in Series Today</span>
                                             </div>
                                             <p class="trending-dec">Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                             </p>
                                             <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                   <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover mr-2" tabindex="0"><i
                                                      class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                                   <a href="javascript:void(0);" class="btn btn-link" tabindex="0"><i class="ri-add-line"></i>My
                                                   List</a>
                                                </div>
                                             </div>
                                             <div class="trending-list mt-4">
                                                <div class="text-primary title">Starring: <span class="text-body">Wagner
                                                   Moura, Boyd Holbrook, Joanna</span>
                                                </div>
                                                <div class="text-primary title">Genres: <span class="text-body">Crime,
                                                   Action, Thriller, Biography</span>
                                                </div>
                                                <div class="text-primary title">This Is: <span class="text-body">Violent,
                                                   Forceful</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data2" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="<?php echo URL::to('home') ?>" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="iq-custom-select d-inline-block sea-epi">
                                                <select name="cars" class="form-control season-select">
                                                   <option value="season1">Season 1</option>
                                                   <option value="season2">Season 2</option>
                                                   <option value="season3">Season 3</option>
                                                </select>
                                             </div>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>-->
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data3" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/01.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data4" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/01.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </li>
                            <?php endforeach; 
                                       endif; ?>
                           
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section id="iq-tvthrillers" class="s-margin">
             <?php if ( GetCategoryVideoStatus() == 1 ) { ?>
    <div class="container">
     
        <?php
            $parentCategories = App\VideoCategory::where('in_home','=',1)->get();
            foreach($parentCategories as $category) {
            $videos = App\Video::where('video_category_id','=',$category->id)->get();
        ?>
         <div class="row">
         <!--<a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff" >
         <h4  class="movie-title">
            <?php echo __($category->name);?> 
         </h4>
         </a>-->
        <div style="border-bottom: 1px solid #232429;"></div>
         <!-- <a href="<php echo URL::to('/').'/category/'.$category->slug;?>" class="category-heading" style="text-decoration:none;"> 
              <h4 class="Continue Watching text-left category-heading">
                  <php echo __($category->name);?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> 
              </h4>
          </a>-->
             <?php if (count($videos) > 0) { 
                include('partials/category-videoloop.php');
            } else { ?>
            <p class="no_video"> <!--<?php echo __('No Video Found');?>--></p>
            <?php } ?>
         </div>
        <?php }?>
        </div>
        <?php } ?>
         </section>
</div>
<!-- End Of MainContent -->
     <script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
  <script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl<?= $watchlater_video->id;?>').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl1<?= $watchlater_video->id;?>').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl2<?= $watchlater_video->id;?>').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl3<?= $watchlater_video->id;?>').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>


<!--  <script>
     var player = videojs('video_player').videoJsResolutionSwitcher({
        default: '480p', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      })
  $(".playertextbox").appendTo($('#video_player'));

   var res = player.currentResolution();
  player.currentResolution(res);
 
    function autoplay1() {
      
      var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
    playButton.setAttribute("id", "myPlayButton");
      var next_video_id = $(".next_video").text();
      var prev_video_id = $(".prev_video").text();
      var next_cat_video = $(".next_cat_video").text();
      var prev_cat_video = $(".prev_cat_video").text();
      var url = $(".next_url").text();
      if(next_video_id != ''){

        $(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
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
          window.location = "<?= URL::to('/');?>"+"/"+url+"/"+next_video_id;
         }, 3000);
      }else if(prev_video_id != ''){
        
        $(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
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
          window.location = "<?= URL::to('/');?>"+"/"+url+"/"+prev_video_id;
         }, 3000);
      
      }

      if(next_cat_video != ''){

        $(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
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
          window.location = "<?= URL::to('/');?>"+"/videos_category/"+next_cat_video;
         }, 3000);
      }else if(prev_cat_video != ''){
        
        $(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
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
          window.location = "<?= URL::to('/');?>"+"/videos_category/"+prev_cat_video;
         }, 3000);
      
      }
  }

  /*on video Play*/
  function playstart() {
    // if($("#video_player").data('authenticated')){
    //  $.post('<?= URL::to('watchhistory');?>', { video_id : '<?= $watchlater_video->id ?>', _token: '<?= csrf_token(); ?>' }, function(data){});
    //  $.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});

    // } else {
    //  $.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    // }
    $(".vjs-big-play-button").hide();
  }
  </script>-->


   
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

   <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>-->
   <!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->
    <script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
    <script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
    <script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<script>
  videojs('videojs-seek-buttons-player', {
    controls: true,
    plugins: {
      videoJsResolutionSwitcher: {
        default: 'low', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      }
    }
  }, function(){
    var player = this;
    window.player = player
    player.updateSrc([
      {
        src: '<?= $watchlater_video->trailer; ?>',
        type: 'video/mp4',
        label: 'SD',
        res: 360
      },
      {
        src: '<?= $watchlater_video->trailer; ?>',
        type: 'video/mp4',
        label: 'HD',
        res: 720
      }
    ])
    player.on('resolutionchange', function(){
      console.info('Source changed to %s', player.src())
    })
  })
        
</script>
<!--<script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
<script>
var vid = document.getElementById("videojs-seek-buttons-player");
vid.onloadeddata = function() {

    // get the current players AudioTrackList object
    var player = videojs('videojs-seek-buttons-player')
    let tracks = player.audioTracks();

    alert(tracks.length);

    for (let i = 0; i < tracks.length; i++) {
        let track = tracks[i];
        console.log(track);
        alert(track.language);
    }
};
</script>-->



<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
 <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>

  <script>
    // fire up the plugin
    videojs('video_player', {
    playbackRates: [0.5, 1, 1.5, 2],
      controls: true,
      muted: true,
      width: 991,
      fluid: true,
      plugins: {
        videoJsResolutionSwitcher: {
      ui: true,
          default: 'low', // Default resolution [{Number}, 'low', 'high'],
          dynamicLabel: true
        }
      }
    }, function(){
      var player = this;
      window.player = player
    player.watermark({
        image: '',
    fadeTime: null,
        url: ''
      });
    });
  </script>


      <script>
        (function(window, videojs) {
            
          var examplePlayer = window.examplePlayer = videojs('videojs-seek-buttons-player');
          var seekButtons = window.seekButtons = examplePlayer.seekButtons({
            forward: 10,
            back: 10
          });
        }(window, window.videojs));
      </script>

    <script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>
    <script>
        
      videojs('videojs-seek-buttons-player').ready(function() {
        this.hotkeys({
          volumeStep: 0.1,
          seekStep: 10,
          enableMute: true,
          enableFullscreen: true,
          enableNumbers: false,
          enableVolumeScroll: true,
          enableHoverScroll: true,

          // Mimic VLC seek behavior, and default to 5.
          seekStep: function(e) {
            if (e.ctrlKey && e.altKey) {
              return 5*60;
            } else if (e.ctrlKey) {
            
              return 60;
            } else if (e.altKey) {
              return 10;
            } else {               
              return 5;
            }
          },

          // Enhance existing simple hotkey with a complex hotkey
          fullscreenKey: function(e) {
            // fullscreen with the F key or Ctrl+Enter
            return ((e.which === 70) || (e.ctrlKey && e.which === 13));
          },

          // Custom Keys
          customKeys: {

            // Add new simple hotkey
            simpleKey: {
              key: function(e) {
                // Toggle something with S Key
                return (e.which === 83);
              },
              handler: function(player, options, e) {
                // Example
                if (player.paused()) {
                  player.play();
                } else {
                  player.pause();
                }
              }
            },

            // Add new complex hotkey
            complexKey: {
              key: function(e) {
                // Toggle something with CTRL + D Key
                return (e.ctrlKey && e.which === 68);
              },
              handler: function(player, options, event) {
                // Example
                if (options.enableMute) {
                  player.muted(!player.muted());
                }
              }
            },

            // Override number keys example from https://github.com/ctd1500/videojs-hotkeys/pull/36
            numbersKey: {
              key: function(event) {
                // Override number keys
                return ((event.which > 47 && event.which < 59) || (event.which > 95 && event.which < 106));
              },
              handler: function(player, options, event) {
                // Do not handle if enableModifiersForNumbers set to false and keys are Ctrl, Cmd or Alt
                if (options.enableModifiersForNumbers || !(event.metaKey || event.ctrlKey || event.altKey)) {
                  var sub = 48;
                  if (event.which > 95) {
                    sub = 96;
                  }
                  var number = event.which - sub;
                  player.currentTime(player.duration() * number * 0.1);
                }
              }
            },

            emptyHotkey: {
              // Empty
            },

            withoutKey: {
              handler: function(player, options, event) {
                  console.log('withoutKey handler');
              }
            },

            withoutHandler: {
              key: function(e) {
                  return true;
              }
            },

            malformedKey: {
              key: function() {
                console.log('I have a malformed customKey. The Key function must return a boolean.');
              },
              handler: function(player, options, event) {
          
              }
            }
          }
        });
      });
        
    var video = videojs('videojs-seek-buttons-player');

    video.on('pause', function() {
      this.bigPlayButton.show();
        $(".vjs-big-play-button").show();
        video.one('play', function() {
        this.bigPlayButton.hide();
      });
    });
 
$(document).ready(function () { 
    $(window).on("beforeunload", function() { 

        var vid = document.getElementById("videojs-seek-buttons-player_html5_api");
        var currentTime = vid.currentTime;
        var videoid = video_id;
            $.post('<?= URL::to('continue-watching') ?>', { video_id : videoid,currentTime:currentTime, _token: '<?= csrf_token(); ?>' }, function(data){
                      //    toastr.success(data.success);
            });
      // localStorage.setItem('your_video_'+video_id, currentTime);
        return;
    }); });

    var current_time = $('#current_time').val();
    var myPlayer = videojs('videojs-seek-buttons-player_html5_api');
    var duration = myPlayer.currentTime(current_time);
    </script>
    <?php include('footer.blade.php');?>