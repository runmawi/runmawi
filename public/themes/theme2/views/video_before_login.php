<?php include('header.php'); ?>

<?php 

$ads_details = App\AdsVideo::join('advertisements','advertisements.id','ads_videos.ads_id') 
            ->where('ads_videos.video_id', $video->id)->pluck('ads_path')->first(); 

$default_ads_url    = App\Setting::pluck('default_ads_url')->first();
$default_ads_status = App\Video::where('id',$video->id)->pluck('default_ads')->first(); 

if($default_ads_url !=null && $default_ads_status == 1){
  $default_ads = $default_ads_url ;
}else{
  $default_ads = null ;
}

    if($ads_details != null){ 
      $ads_path = $ads_details; 
    }else{ 
      $ads_path = $default_ads ;
}  ?>

<?php

$str = $video->m3u8_url;
if(!empty($str)){
$request_url = 'm3u8';
// dd($video->m3u8);  
}
if(!empty($request_url)){
?>
<input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url ?>">
<?php } ?>

<input type="hidden" name="ads_path" id="ads_path" value="<?php echo  $ads_path;?>">

<input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo  $playerui_settings->watermark_logo ;?>">

  <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
  <input type="hidden" id="videoslug" value="<?php if(isset($video->slug)) { echo $video->slug; } else{ echo "0";}?>">
  <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
  <input type="hidden" id="video_type" value="<?php echo $video->type;?>">
  <input type="hidden" id="user_logged_out" value="<?php echo Auth::guest();?>">
  <input type="hidden" id="video_video" value="video">
  <input type="hidden" id="adsurl" value="<?php if(isset($ads->ads_id)){echo get_adurl($ads->ads_id);}?>">

<input type="hidden" name="processed_low" id="processed_low" value="<?php echo  $video->processed_low;?>">
<!-- For Guest users -->      
<?php if(Auth::guest() && $video->access == "guest"  && empty($video->ppv_price)
    //  || Auth::guest() && $video->access == "subscriber"  && empty($video->ppv_price)
     ) {
    // dd(Auth::guest());
        ?>
  <div id="video_bg">
   <div class=" page-height">
     <?php 

          //  $paypal_id = Auth::user()->paypal_id;
           if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
           $paypal_subscription = PaypalSubscriptionStatus();
           } else {
             $paypal_subscription = "";  
           }
           ?>
         <?php if( $video->access == "guest"  && $video->type == 'embed'): ?>
           <div id="video_container" class="fitvid">
             <?php
              if(!empty($video->embed_code)){?>
              <div class="plyr__video-embed" id="player">
            <iframe
              src="<?php if(!empty($video->embed_code)){ echo $video->embed_code; }else { echo $video->trailer;} ?>"
              allowfullscreen
              allowtransparency
              allow="autoplay"
            ></iframe>
          </div>
             <?php } ?>
           </div>
         
           <?php  elseif($video->type == '' && $video->processed_low != 100 || $video->processed_low == null ): ?>
           
             
           <div id="video_container" class="fitvid" atyle="z-index: 9999;">
         <!-- Current time: <div id="current_time"></div> -->
         <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
            <!-- <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
            <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
             <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' > 
          
             <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
             <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
             <?php } if($value->sub_language == "German"){?>
             <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
             <?php } if($value->sub_language == "Spanish"){ ?>
             <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
             <?php } if($value->sub_language == "Hindi"){ ?>
             <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
             <?php }
             } } else {  } ?>  
         </video>

     </div>
     <?php  elseif($video->type == ''&& $video->processed_low == 100 || $video->processed_low != null): ?>
     
       
     <div id="video_container" class="fitvid" atyle="z-index: 9999;">
   <!-- Current time: <div id="current_time"></div> -->
   <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
      <source 
        type="application/x-mpegURL" 
        src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"
      >
      <!-- </video> -->
              <!-- <video id="video"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   > -->
      <!-- Captions are optional -->
      <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
          <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
          <?php } if($value['sub_language'] == "German"){ ?>
          <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
          <?php } if($value['sub_language'] == "Spanish"){ ?>
          <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
          <?php } if($value['sub_language'] == "Hindi"){ ?>
          <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
          <?php } } } else { }  ?>  
      </video>

</div>
           <?php  elseif($video->type == 'mp4_url'): 
    // dd($video->type );

    ?>
    
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                  <!-- <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                  <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
                   <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' > 
                
                   <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){  if($value->sub_language == "English"){ ?>
                   <track label="English" kind="subtitles" srclang="en" src="<?= $value->url ?>" >
                   <?php } if($value->sub_language == "German"){?>
                   <track label="German" kind="subtitles" srclang="de" src="<?= $value->url ?>" >
                   <?php } if($value->sub_language == "Spanish"){ ?>
                   <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value->url ?>" >
                   <?php } if($value->sub_language == "Hindi"){ ?>
                   <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value->url ?>" >
                   <?php }
                   } } else {  } ?>  
               </video>
 
               <div class="playertextbox hide">
                   <!--<h2>Up Next</h2>-->
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
   <?php  else: ?>
               <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
<!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                   <source src="<?php if(!empty($video->m3u8_url)){ echo $video->m3u8_url; }else { echo $video->trailer;} ?>"  type='application/x-mpegURL' label='auto' > 

                   <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
                   <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                   <?php } if($value['sub_language'] == "German"){?>
                   <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                   <?php } if($value['sub_language'] == "Spanish"){ ?>
                   <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                   <?php } if($value['sub_language'] == "Hindi"){ ?>
                   <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                   <?php }
                   } } else {  } ?>  
               </video>
               <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
 
               <div class="playertextbox hide">
                   <!--<h2>Up Next</h2>-->
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
 
 
  <?php }elseif( Auth::guest() && $video->access == "guest" && empty($video->ppv_price ) && !empty($video->path) || Auth::guest() && $video->access == "guest" && $video->path != "public" && empty($video->ppv_price )){  ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
      <source 
        type="application/x-mpegURL" 
        src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"
      >
    </video>
               <!-- <video id="video"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   > -->
  <!-- Captions are optional -->
  <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
           <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "German"){ ?>
           <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "Spanish"){ ?>
           <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "Hindi"){ ?>
           <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
           <?php } } } else { }  ?>  
</video>
</div>
  <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
    <?php }else{ 
      if(!empty($video->path) && $video->path != "public"){ $hls = "hls" ;}else{ $hls = "" ;}
     ?>
  <input type="hidden" id="hls" name="hls" value="<?php echo $hls; ?>">
    <div id="video" class="fitvid" style="margin: 0 auto;">
        
        <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" 
        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" 
        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
         src="<?php echo $video->trailer; ?>"  type="video/mp4" >
            <source src="<?= $video->trailer; ?>" type='video/mp4' label='Auto' res='auto' />

        <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
        <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
        <?php } if($value['sub_language'] == "German"){ ?>
        <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
        <?php } if($value['sub_language'] == "Spanish"){ ?>
        <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
        <?php } if($value['sub_language'] == "Hindi"){ ?>
        <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
        <?php } } } else { } ?>  
        </video>  
    </div>
  <?php  } ?>
            

  <input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">
    <div class="container-fluid video-details" style="width:90%!important;">
        <div class="trending-info g-border p-0">
            <div class="row">
                <div class="col-sm-9 col-md-9 col-xs-12">
                    <h1 class="trending-text big-title text-uppercase mt-3"><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
                        <!-- Category -->
                    <ul class="p-0 list-inline d-flex align-items-center movie-content">
                     <li class="text-white"><?//= $videocategory ;?></li>
                    </ul>
                </div>
                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right">     
                        <?php if($video->trailer != ''){ ?>
                            <div class="watchlater btn btn-secondary btn-lg btn-block watch_trailer"><i class="ri-film-line"></i> Watch Trailer</div>
                            <div style=" display: none;" class="skiptrailer btn btn-default skip">Skip</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Year, Running time, Age -->
          <div class="d-flex align-items-center text-white text-detail">
             <span class="badge badge-secondary p-3"><?php echo __($video->age_restrict);?></span>
             <span class="ml-3"><?php echo __($video->duration);?></span>
             <span class="trending-year"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
          </div>
            
        <?php if(!Auth::guest()) { ?>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-12">
                 <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                      <!-- Watchlater -->
                     <li><span class="watchlater <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($watchlatered->id)): ?> class="ri-add-circle-fill" <?php else: ?> class="ri-add-circle-line" <?php endif; ?>></i></span></li>
                      <!-- Wishlist -->
                     <li><span class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line" <?php endif; ?> ></i></span></li>
                      <!-- Social Share, Like Dislike -->
                         <?php include('partials/social-share.php'); ?>                     
                  </ul>
            </div>
                
            <div class="col-sm-6 col-md-6 col-xs-12">
<!--
                  <div class="d-flex align-items-center series mb-4">
                     <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                           alt=""></a>
                     <span class="text-gold ml-3">#2 in Series Today</span>
                  </div>
-->                 
                <ul class="list-inline p-0 mt-4 rental-lists">
                <!-- Subscribe -->
                    <li>
                        <?php     
                            $user = Auth::user(); 
                            if (  ($user->role!="subscriber" && $user->role!="admin") ) { ?>
                                <a href="<?php echo URL::to('/becomesubscriber');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                        <?php } ?>
                    </li>
                    <!-- PPV button -->
                    <li>
                        <?php if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin")  ) { ?>
                            <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                            <?php echo __('Rent');?> </button>
                        <?php } ?>
                    </li>
                    <li>
                        <div class="btn btn-default views text-white">
                            <span class="view-count"><i class="fa fa-eye"></i> 
                                <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?php } ?>
        
           <?php if(Auth::guest()) { ?>
  
            <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                     <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                          <!-- Watchlater -->
                         <li><span class="watchlater <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($watchlatered->id)): ?> class="ri-add-circle-fill" <?php else: ?> class="ri-add-circle-line" <?php endif; ?>></i></span></li>
                          <!-- Wishlist -->
                         <li><span class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line" <?php endif; ?> ></i></span></li>
                          <!-- Social Share, Like Dislike -->
                             <?php include('partials/social-share.php'); ?>                     
                      </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
<!--
                      <div class="d-flex align-items-center series mb-4">
                         <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                               alt=""></a>
                         <span class="text-gold ml-3">#2 in Series Today</span>
                      </div>
    -->                 
                    <ul class="list-inline p-0 mt-4 rental-lists">
                                      <!-- Subscribe -->
                                      <?php if($video->access == "guest"){ ?> 
                    <?php }elseif($video->access == "subscriber"){ ?> 
                      <li>
                            <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                        </li>
                        <li>
                            <div class="btn btn-default views">
                                <span class="view-count"><i class="fa fa-eye"></i> 
                                    <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                                </span>
                            </div>
                        </li>
                    <?php }
                    elseif($video->access == "ppv"){ ?> 
                        <!-- PPV button -->
                        <li>
                            <a class="view-count btn btn-primary rent-video text-white" href="<?php echo URL::to('/login');?>">
                                <?php echo __('Rent');?> </a>
                        </li>
                        <li>
                            <div class="btn btn-default views">
                                <span class="view-count"><i class="fa fa-eye"></i> 
                                    <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                                </span>
                            </div>
                        </li>
                    <?php }else{ ?>

                     <?php } ?>

                    </ul>
                </div>
            </div>
            <?php   }?>

<!-- logo In player -->

        <div class="logo_player"> </div>
        
        <div class="text-white">
            <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
        </div>
   <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
           
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-sm-2" style="width:52%;">
                    <span id="paypal-button"></span> 
                  </div>
                  
                  <div class="col-sm-4">
                    <a onclick="pay(<?php echo PvvPrice();?>)">
                        <img src="<?php echo URL::to('/assets/img/card.png');?>" class="rent-card">
                    </a>
                  </div>
              </div>                    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"  data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <?php if(isset($videonext)){ ?>
    <div class="next_video" style="display: none;"><?= $videonext->slug ?></div>
    <div class="next_url" style="display: none;"><?= $url ?></div>
    <?php }elseif(isset($videoprev)){ ?>
    <div class="prev_video" style="display: none;"><?= $videoprev->slug ?></div>
    <div class="next_url" style="display: none;"><?= $url ?></div>
    <?php } ?>

    <?php if(isset($videos_category_next)){ ?>
    <div class="next_cat_video" style="display: none;"><?= $videos_category_next->slug ?></div>
    <?php }elseif(isset($videos_category_prev)){ ?>
    <div class="prev_cat_video" style="display: none;"><?= $videos_category_prev->slug ?></div>
    <?php } ?>

    <div class="clear"></div>
<!--
    <div id="tags">Tags: 
    <php foreach($video->tags as $key => $tag): ?>
      <span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>
    <php endforeach; ?>
    </div>
-->
        
    <div class="video-list you-may-like">
            <h4 class="Continue Watching" style="color:#fffff;"><?php echo __('Recomended Videos');?></h4>
                <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
                <?php include('partials/video-loop.php');?>
                </div>
    
    </div>
    <script type="text/javascript"> 
        videojs('videoPlayer').videoJsResolutionSwitcher(); 
    </script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <div class="clear"></div>
        <script>

          $(document).ready(function () { 

            /*Watch trailer*/
            $(".watch_trailer").click(function() {
              var videohtml = '<video controls autoplay><source src="<?php echo $video->trailer;?>"></video>';
              $("#video_container").empty();
              $(".skip").css('display','inline-block');
              $("#video_container").html(videohtml);
            });

            /*Skip Video*/
            $(document).on("click",".skip",function() {
              $("#video_container").empty();
              $(".skip").css('display','none');
              $(".page-height").load(location.href + " #video_container");
              setTimeout(function(){ 
              videojs('videoPlayer');
            }, 2000);
            });

            var vid = document.getElementById("videoPlayer_html5_api");
            vid.currentTime = $("#current_time").val();
            $(window).on("beforeunload", function() { 

              var vid = document.getElementById("videoPlayer_html5_api");
              var currentTime = vid.currentTime;
              var duration = vid.duration;
              var videoid = $('#video_id').val();
              $.post('<?= URL::to('continue-watching') ?>', { video_id : videoid,duration : duration,currentTime:currentTime, _token: '<?= csrf_token(); ?>' }, function(data){
                      //    toastr.success(data.success);
                    });
      // localStorage.setItem('your_video_'+video_id, currentTime);
      return;
    }); });

            //$(".share a").hide();
            $(".share").on("mouseover", function() {
            $(".share a").show();
            }).on("mouseout", function() {
            $(".share a").hide();
            });

            $(document).ready(function () {  
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
            });
 
            function pay(amount) {

              var video_id = $('#video_id').val();

              var handler = StripeCheckout.configure({

                key: 'pk_test_hklBv33GegQSzdApLK6zWuoC00pEBExjiP',
                locale: 'auto',
                token: function (token) {
// You can access the token ID with `token.id`.
// Get the token ID to your server-side code for use.
console.log('Token Created!!');
console.log(token);
$('#token_response').html(JSON.stringify(token));

$.ajax({
  url: '<?php echo URL::to("purchase-video") ;?>',
  method: 'post',
  data: {"_token": "<?php echo csrf_token(); ?>",tokenId:token.id, amount: amount , video_id: video_id },
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
                name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
                description: 'Rent a Video',
                amount: amount * 100
              });
            }

//watchlater
      $('.watchlater').click(function(){
        if($(this).data('authenticated')){
          $.post('<?= URL::to('watchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
          $(this).toggleClass('active');
          $(this).html("");
              if($(this).hasClass('active')){
                $(this).html('<i class="ri-add-circle-fill"></i>');
              }else{
                $(this).html('<i class="ri-add-circle-line"></i>');
              }
        } else {
          window.location = '<?= URL::to('login') ?>';
        }
      });

      //My Wishlist
      $('.mywishlist').click(function(){
        if($(this).data('authenticated')){
          $.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
          $(this).toggleClass('active');
          $(this).html("");
              if($(this).hasClass('active')){
                $(this).html('<i class="ri-heart-fill"></i>');
              }else{
                $(this).html('<i class="ri-heart-line"></i>');
              }
              
        } else {
          window.location = '<?= URL::to('login') ?>';
        }
      });

        </script>
    <script type="text/javascript">
$(document).ready(function(){
$('#videoPlayer').bind('contextmenu',function() { return false; });
});
</script>


<!-- logo on player -->

<script>
$(document).ready(function(){

  $(".logo_player").hide();
  $('.plyr__video-wrapper').bind('contextmenu', function() {
      $(".logo_player").show();
      setTimeout(function() {
            $('.logo_player').fadeOut('fast');
        }, 30000); 
    });

});
</script>

<?php
  $player_ui = App\Playerui::pluck('show_logo')->first();
  $logo = App\Setting::pluck('logo')->first();
  $logo_url = '/public/uploads/settings/'. $logo ;
    if($player_ui == 1){
?>
        <style>
            .logo_player {
            position: absolute;
            top: 50%;
            left: 80%;
            z-index: 2;
            content: '';
            height: 200px;
            width: 10%;
            background: url(<?php echo URL::to($logo_url) ; ?>) no-repeat;
            background-size: 100px auto, auto;
            }
        </style>
<?php } ?>
    
  </div>

  <?php include('footer.blade.php');?>

