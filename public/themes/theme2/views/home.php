<!-- Header Start -->
<?php include('header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
$order_settings_list = App\OrderHomeSetting::get();  
?>
<!-- Header End -->


<!-- Slider Start -->
<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="slider m-0 p-0">
        <?php include('partials/home/slider.php'); ?>
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
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                  <?php include('partials/home/continue-watching.php'); ?>
              </div>
           </div>
        </div>
    </section>

<!-- Top Watched Videos -->
    <?php 
        foreach($order_settings as $key => $value){
         //  if($value == ){}
         if($value->video_name == 'Recommendation'){
    if(count($top_most_watched) > 0){ ?>
       <section id="iq-favorites">
            <div class="fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <?php include('partials/home/Top_videos.blade.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php } ?>


<!-- Most Watched Videos User -->
    <?php if(count($most_watch_user) > 0){ ?>
       <section id="iq-favorites">
            <div class="fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <?php include('partials/home/most_watched_user.blade.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php } ?>


<!-- Most Watched Videos Country -->
   <?php 
      if(count($Most_watched_country) > 0){ ?>
       <section id="iq-favorites">
            <div class="fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <?php include('partials/home/most_watched_country.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php } ?>


   <!-- Preference By Genres -->
   <?php 
      if(($preference_genres) != null && count($preference_genres) > 0){ ?>
         <section id="iq-favorites">
            <div class="fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <?php include('partials/home/preference_genres.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php } ?>

   <!-- Preference By Language -->
   <?php 
   if(($preference_Language) != null && count($preference_Language) > 0 ){ ?>
   <section id="iq-favorites">
            <div class="fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <?php include('partials/home/preference_Language.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php } } ?>


<!-- Recently Added Movies -->
    <?php
       if($value->video_name == 'latest_videos'){
         if($home_settings->latest_videos == 1){ ?>
      <section id="iq-favorites">
         <div class="fluid">
            <div class="row">
               <div class="col-sm-12 overflow-hidden">
                  <?php include('partials/home/latest-videos.php'); ?>
               </div>
            </div>
         </div>
      </section>
   <?php } }?>

<!-- Live Videos -->
<?php
 if($value->video_name == 'live_videos'){
if($home_settings->live_videos == 1){ ?>
    <section id="iq-favorites">
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <?php include('partials/home/live-videos.php'); ?>
              </div>
           </div>
        </div>
</section>
<?php } }?>


<?php 
       if($value->video_name == 'audios'){
if($home_settings->audios == 1){ ?>
    <section id="iq-favorites">
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <?php include('partials/home/latest-audios.php'); ?>
              </div>
           </div>
        </div>
</section>
<?php } } ?>


<?php
       if($value->video_name == 'albums'){
if($home_settings->albums == 1){ ?>
    <section id="iq-favorites">
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <?php include('partials/home/latest-albums.php'); ?>
              </div>
           </div>
        </div>
</section>
<?php } }?>

<!--  Series  -->


<?php 
       if($value->video_name == 'series'){
         if($home_settings->series == 1){ ?>
    <section id="iq-favorites">
        <div class="container-fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <?php include('partials/home/latest-series.php'); ?>
              </div>
           </div>
        </div>
</section>
<?php } } ?>


<!--  Featured Movies  -->
<?php
       if($value->video_name == 'featured_videos'){
if ( GetTrendingVideoStatus() == 1 ) { ?>
  <section id="iq-favorites">
    <div class="fluid">
      <div class="row">
        <div class="col-sm-12 overflow-hidden">
          <?php if ( count($featured_videos) > 0 ) { 
            include('partials/home/trending-videoloop.php');
          } else {  ?>
            <!-- <p class="no_video"> No Video Found</p> -->
          <?php }  ?>
        </div>
      </div>
    </div>
  </section>

<?php } }?>
 
  <?php /*<section id="iq-topten">
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
                             foreach($latest_videos as $top10_video): ?>
                           <li>
                              <a href="<?php echo URL::to('home') ?>">
                              <img src="<?php echo URL::to('/').'/public/uploads/images/'.$top10_video->image;  ?>" class="img-fluid" alt="">
                              </a>
                           </li> 
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                        <div class="vertical_s">
                           <ul id="top-ten-slider-nav" class="list-inline p-0 m-0  d-flex align-items-center">
                                <?php  if(isset($latest_videos)) :
                             foreach($latest_videos as $top10_video): ?>
                              <li>
                                 <div class="block-images position-relative active">
                                    <a href="<?php echo URL::to('home') ?>">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$top10_video->image;  ?>" class="img-fluid" alt="">
                                    </a>
                                    <div class="block-description">
                                       <h5><?php echo __($top10_video->title); ?></h5>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">10+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $top10_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                          <a href="<?php echo URL::to('category') ?><?= '/videos/' . $top10_video->slug ?>" class="btn btn-hover" tabindex="0">
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
                             foreach($suggested_videos as $latest_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                       <h6><?php echo __($latest_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">11+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl3<?= $latest_video->id;?>">
                                          <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                              Play Now</span></button>
                                       </div>
                                         <div>
                                            <button class="show-details-button" data-id="<?= $latest_video->id;?>">
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
                             foreach($suggested_videos as $latest_video): ?>
                        <div class="modal fade bd-example-modal-xl3<?= $latest_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content" style="background-color: transparent !important;">
                                     <div class="modal-body playvid">
                             <?php if($latest_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $latest_video->embed_code ?>
                                        </div>
                                    <?php  elseif($latest_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls  poster="<?= URL::to('/public/') . '/uploads/images/' . $latest_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $latest_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$latest_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$latest_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $latest_video::where('id','=',$videonext->id)->pluck('title'); ?>
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

                                        <source src="<?= $latest_video->trailer; ?>" type='video/mp4' label='auto' >

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
                                    onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $latest_video->id;?>"  ><span aria-hidden="true">X</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php endforeach; 
                                       endif; ?>
             <?php if(isset($suggested_videos)) :
                                foreach($suggested_videos as $latest_video): ?>
                                <div class="thumb-cont" id="<?= $latest_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="<?= $latest_video->id;?>"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $latest_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($latest_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $latest_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $latest_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                            
                                                       <!-- <div class="btn btn-danger btn-right-space br-0">
                                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                                </div>-->
                                        <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $latest_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
    
    <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>" >

    
        <?php if (!empty($latest_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>"  muted="muted">
                                    <source src="<?= $latest_video->trailer; ?>" type="video/mp4">
                 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="thumb-img">
      
                       <?php } ?>  
                  <div class="play-button-trail" >
        
<!--      <a  href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">  
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
        </div></a>-->
                <div class="detail-block">
<!--          <a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                <p class="movie-title"><?php echo __($latest_video->title); ?></p>
          </a>-->
          
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $latest_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $latest_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $latest_video->duration); ?></span>
          </p>-->

        </div>
    </div>
    </a>
    <div class="block-contents">
      <!--<p class="movie-title padding"><?php echo __($latest_video->title); ?></p>-->
        </div>
  </div> 
              
    </div>
    <div id="like<?= $latest_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $latest_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
  </div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $latest_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $latest_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $latest_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $latest_video->id;?>">DETAILS </a>           
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
                             foreach($trending_videos as $latest_video): ?>
                           <li>
                              <a href="javascript:void(0);">
                                 <div class="movie-slick position-relative">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                 </div>
                              </a>
                           </li>
                            <?php endforeach; 
                                       endif; ?>
                        </ul>
                        <ul id="trending-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                            <?php  if(isset($trending_videos)) :
                             foreach($trending_videos as $latest_video): ?>
                           <li>
                              <div class="tranding-block position-relative"
                                 style="background-image: url('<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>');">
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
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($latest_video->title); ?></h1>
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
                                                   <a href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>" class="btn btn-hover mr-2" tabindex="0"><i
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
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($latest_video->title); ?></h1>
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
                                                         <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
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
                                                   <!--<div class="e-item">
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
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($latest_video->title); ?></h1>
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
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($latest_video->title); ?></h1>
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
         </section>*/ ?>

        <section id="iq-tvthrillers" class="s-margin">
            <?php 
       if($value->video_name == 'category_videos'){
         if ( GetCategoryVideoStatus() == 1 ) { ?>
            <div class="fluid">
               <?php
                     $getfeching = App\Geofencing::first();
                     $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                     $userIp = $geoip->getip();    
                     $countryName = $geoip->getCountry();

                     $Multiuser=Session('subuser_id');
                     $Multiprofile= App\Multiprofile::where('id',$Multiuser)->first();

                     $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();

      // blocked videos
                      $block_videos = App\BlockVideo::where('country_id',$countryName)->get();
                      if(!$block_videos->isEmpty()){
                         foreach($block_videos as $block_video){
                            $blockvideos[]=$block_video->video_id;
                         }
                      }   
                      else{
                        $blockvideos[]='';
                      } 

                    foreach($parentCategories as $category) {
                       if( $Multiprofile != null ){
                           if($Multiprofile->user_type == "Kids"){
                         
                        $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                             ->where('category_id','=',$category->id)->where('active', '=', '1')
                                             ->where('status', '=', '1')->where('draft', '=', '1')
                                             ->where('age_restrict','<',18);

                           if($getfeching !=null && $getfeching->geofencing == 'ON'){
                              $videos = $videos  ->whereNotIn('videos.id',$blockvideos); }
                              if($Family_Mode == 1){
                                 $videos = $videos->where('age_restrict', '<', 18);
                             }
                             if($Kids_Mode == 1){
                                 $videos = $videos->where('age_restrict', '<', 10);
                             }
                              $videos = $videos ->get();
                           }else{
                     $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                          ->where('category_id','=',$category->id)->where('active', '=', '1')
                                          ->where('status', '=', '1')->where('draft', '=', '1');

                     if($getfeching !=null && $getfeching->geofencing == 'ON'){
                        $videos = $videos  ->whereNotIn('videos.id',$blockvideos);
                        }
                        if($Family_Mode == 1){
                           $videos = $videos->where('age_restrict', '<', 18);
                       }
                       if($Kids_Mode == 1){
                           $videos = $videos->where('age_restrict', '<', 10);
                       }
                      $videos = $videos ->get();
                       } } else {

                      
                     $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                          ->where('category_id','=',$category->id)->where('active', '=', '1')
                                          ->where('status', '=', '1')->where('draft', '=', '1');
                                          
                     
                     if($getfeching !=null && $getfeching->geofencing == 'ON'){
                        $videos = $videos  ->whereNotIn('videos.id',$blockvideos);
                           }
                           if($Family_Mode == 1){
                              $videos = $videos->where('age_restrict', '<', 18);
                          }
                          if($Kids_Mode == 1){
                              $videos = $videos->where('age_restrict', '<', 10);
                          }
                     $videos = $videos ->get();
                     }
                ?>
                        <?php if (count($videos) > 0) { 
                            include('partials/category-videoloop.php');
                        } else { ?>
                        <p class="no_video"> <!--<?php echo __('No Video Found');?>--></p>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php } } }?>

<!-- Most watched Videos - category -->

               <?php
                  $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();
                  foreach($parentCategories as $category){

                  $top_category_videos = App\RecentView::select('recent_views.video_id','videos.*',DB::raw('COUNT(recent_views.video_id) AS count')) 
                  ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                  ->join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                  ->groupBy('recent_views.video_id')->orderByRaw('count DESC' )
                  ->where('categoryvideos.category_id','=',$category->id)
                  ->limit(20)
                  ->get();  
                  ?>

                  <?php if (count($top_category_videos) > 0) { 
                     include('partials/home/most_Watched_category.blade.php');
               } else { ?>
               <p class="no_video"> <!--<?php echo __('No Video Found');?>--></p>
               <?php } } ?>
        </section> 
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");    
  var lazyloadThrottleTimeout;
  
  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }    
    
    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }
  
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});

//  family & Kids Mode Restriction   

$( document ).ready(function() {
   $('.kids_mode').click(function () {
      var kids_mode = $(this).data("custom-value");
               $.ajax({
               url: "<?php echo URL::to('/kidsMode');?>",
               type: "get",
               data:{
                  kids_mode:kids_mode, 
               },
               success: function (response) {
                  location.reload();               
               },
            });   
   });

   $('.family_mode').click(function () {
         var family_mode = $(this).data("custom-value");

               $.ajax({
               url: "<?php echo URL::to('/FamilyMode');?>",
               type: "get",
               data:{
                  family_mode:family_mode, 
               },
               success: function (response) {
                  location.reload();               
               },
            });   
   });

   $('.family_mode_off').click(function () {
         var family_mode = $(this).data("custom-value");

               $.ajax({
               url: "<?php echo URL::to('/FamilyModeOff');?>",
               type: "get",
               data:{
                  family_mode:family_mode, 
               },
               success: function (response) {
                  location.reload();               
               },
            });   
   });

   $('#kids_mode_off').click(function () {
      var kids_mode = $(this).data("custom-value");
               $.ajax({
               url: "<?php echo URL::to('/kidsModeOff');?>",
               type: "get",
               data:{
                  kids_mode:kids_mode, 
               },
               success: function (response) {
                  location.reload();               
               },
            });   
   });

});
 </script>

  <?php include('footer.blade.php');?>
<!-- End Of MainContent -->
