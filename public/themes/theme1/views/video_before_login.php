<?php
 include(public_path('themes/theme1/views/header.php')); ?>

<style>
         /* <!-- BREADCRUMBS  */

         .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
          content: none; 
      } 

      ol.breadcrumb {
            color: white;
            background-color: transparent !important  ;
            font-size: revert;
      }
      
</style>
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
} 

include('Adstagurl.php'); 

$autoplay = $video_tag_url == null ? "autoplay" : "" ;    


 ?>

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
              allow="<?= $autoplay ?>"
            ></iframe>
          </div>
             <?php } ?>
           </div>
         
           <?php  elseif($video->type == '' && $video->processed_low != 100 || $video->processed_low == null ): ?>
           
             
           <div id="video_container" class="fitvid" atyle="z-index: 9999;">
         <!-- Current time: <div id="current_time"></div> -->
         <video id="videoPlayer" <?= $autoplay ?> class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
   <video  <?= $autoplay ?> id="video"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"  type='application/x-mpegURL' label='auto' > 
 
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
               <video id="videoPlayer" <?= $autoplay ?> class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
           <?php  elseif($video->type == 'm3u8_url'):  ?>
        
        <video  <?= $autoplay ?> id="video"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
   <?php  else: ?>
               <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video  id="videoPlayer" <?= $autoplay ?> class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
               <video id="video" <?= $autoplay ?> controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
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

    <div id="subscribers_only" style="background: url(<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
      <h4 class="text-center"><?= $video->title; ?></h4>

      <p class="text-center text-white col-lg-8" style="margin:0 auto";>
         <?= $video->description; ?>
      </p> <br>

      <h2>
        <?php
          if($video->access == 'subscriber') { ?>
            <p style="text-align:center"> <?=  'Sorry, this video is only available to Subscribers' ?> </p>
        <?php
          } elseif($video->access == 'registered') { ?>
            <p style="text-align:center"> <?=  'Sorry, this video is only available to Registered' ?> </p>
        <?php
          } elseif( $video->access == 'ppv'){ ?>
            <p style="text-align:center"> <?=  'Sorry, this video is only available to PPV users' ?> </p>
        <?php
          }
        ?>
      </h2>

      <div class="clear"></div> <br>

      <div style="text-align:center">
        <?php if( Auth::guest() && ( $video->access == "registered")){ ?>

          <form method="get" action="<?= URL::to('signup') ?>">
            <button  class="btn btn-primary" id="button"><?= __('Become a '. $video->access .' to watch this video') ?></button>
          </form>

        <?php }elseif ( Auth::guest() && ( $video->access == "subscriber" ) ) { ?>

          <form method="get" action="<?= route('payment_becomeSubscriber')  ?>">
            <button  class="btn btn-primary" id="button"><?= __('Become a '. $video->access .' to watch this video') ?></button>
          </form>
            
        <?php }elseif ( Auth::guest() && ( $video->access == "ppv" ) ) {?>

          <form method="get" action="<?= URL::to('login') ?>">
            <button  class="btn btn-primary" id="button"><?= __('Purchase to watch this video for ' . $currency->symbol .$video->ppv_price) ?></button>
          </form>

        <?php } ?>
      </div>
    </div>
  <?php  } ?>
            

  <input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">
    <div class="container-fluid video-details" >
        <div class="trending-info g-border p-0">
            <div class="row">

                                  <!-- BREADCRUMBS -->
                                  <div class="col-sm-12 col-md-12 col-xs-12">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="bc-icons-2">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item"><a class="black-text" href="<?= route('latest-videos') ?>"><?= __(ucwords('videos')) ?></a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                      </li>

                                      <?php foreach ($category_name as $key => $video_category_name) { ?>
                                        <?php $category_name_length = count($category_name); ?>
                                        <li class="breadcrumb-item">
                                            <a class="black-text" href="<?php echo route('video_categories',[ $video_category_name->categories_slug ])?>">
                                                <?= __(ucwords($video_category_name->categories_name)) . ($key != $category_name_length - 1 ? ' - ' : '') ?> 
                                            </a>
                                            <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                        </li>
                                      <?php } ?>

                                      

                                      <li class="breadcrumb-item"><a class="black-text"><?php echo (strlen($video->title) > 50) ? ucwords(substr($video->title,0,120).'...') : ucwords($video->title); ?> </a></li>
                                  </ol>
                              </div>
                          </div>
                      </div>
                </div>

                <div class="col-sm-9 col-md-9 col-xs-12">
                  
                                        <!--  Video thumbnail image-->
                  <?php if( $video->enable_video_title_image == 1  &&  $video->video_title_image != null){ ?>
                    <div class="d-flex col-md-6">
                       <img src="<?= URL::to('public/uploads/images/'.$video->video_title_image )?>" class="c-logo" alt="<?= $video->title ?>">
                    </div>
                                                        <!-- Video Title  -->
                  <?php }else{ ?>
                    <h1 class="trending-text big-title text-uppercase mt-3">
                        <?php echo (strlen($video->title) > 15) ? substr($video->title,0,80).'...' : $video->title;  if( Auth::guest() ) { } ?>
                      </h1>
                  <?php } ?>

                        <!-- Category -->
                    <ul class="p-0 list-inline d-flex align-items-center movie-content">
                     <li class="text-white"><?//= $videocategory ;?></li>
                    </ul>
                </div>
                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right">     
                        <?php if($video->trailer != ''){ ?>
                            <div class="watchlater btn btn-secondary btn-lg btn-block watch_trailer"><i class="ri-film-line"></i><?= __('Watch Trailer') ?> </div>
                            <div style=" display: none;" class="skiptrailer btn btn-default skip"><?= __('Skip') ?></div>
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
        <!-- url link -->
<div class=" page-height">
<div id="watch_trailer" class="fitvid" atyle="z-index: 9999;">
               
               <?php  if($video->trailer_type !=null && $video->trailer_type == "video_mp4" || $video->trailer_type == "mp4_url"  ){ ?>

                   <video  class="videoPlayer1" 
                         controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                         type="video/mp4" src="<?php echo $video->trailer;?>">
                   </video>
                   <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8" ){ ?>

                      <video  <?= $autoplay ?> id="videos" class=""  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                          controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                          type="application/x-mpegURL">
                          <source type="application/x-mpegURL"  src="<?php echo $video->trailer;?>" >
                      </video>

               <?php }elseif($video->trailer_type !=null && $video->trailer_type == "m3u8_url" ){ ?>

                   <video  class="videoPlayer1" 
                         controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                         type="application/x-mpegURL">
                   </video>

               <?php }elseif($video->trailer_type !=null && $video->trailer_type == "embed_url" ){ ?>

                       <div class="videoPlayer1" id="">
                         <iframe src="<?php echo $video->trailer ?>" allowfullscreen allowtransparency>
                         </iframe>
                       </div>

               <?php  } ?>
             </div>

             <div class="col-sm-12 mt-4 p-0" style="margin-top: 2%;">
                <?php if(!empty($video->description) && $settings->show_description == 1 ) { ?>
                    <h5>Description:</h5>
                    <div class="text-white">
                        <p class="trending-dec w-100 mb-0 text-white mt-3"><?php echo __($video->description); ?></p>
                    </div>
                <?php  }?>

                <?php if(!empty($subtitles_name) && $settings->show_subtitle == 1 ) { ?>
                    <h5>Subtitles:</h5>
                    <div class="text-white">
                        <p class="trending-dec w-100 mb-0 text-white mt-3"><?php echo __( $subtitles_name); ?></p>
                    </div>
                <?php  }?>

                <?php if(!empty($video->details)  && $settings->show_Links_and_details == 1) { ?>
                  <div class="col-sm-6 p-0">
                    
                    <div class="text-white">
                       
                    </div>
                </div>
              <?php  }?>

                
                <?php if(!empty($subtitles_name) && $settings->show_subtitle == 1 ) { ?>
                  <h4>Links & details</h4>
                    <div class="text-white">
                    <?php    $details = html_entity_decode($video->details) ; 
                                            $detail = strip_tags($details); ?>
                        <p class="trending-dec w-100 mb-0 text-white"><?php echo __($detail); ?></p>                    </div>
                <?php  }?>

             </div>

             

   <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;"><?= __('Rent Now') ?></h4>
           
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
            <button type="button" class="btn btn-primary"  data-dismiss="modal"><?= __('Close') ?></button>
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

    
    <?php 
 if((count($artists) > 0) && $settings->show_artist == 1 ) { ?>
 <h4 >Cast & Crew</h4>
          <div class="row">
                <div class="favorites-contens">
                    
                    <ul class="category-page list-inline row p-0 mb-0 m-3">
                       <?php foreach($artists as $key => $artist){  ?>
                       <li class="slide-item col-sm-1 col-md-1 col-xs-12">
                          <a  href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_slug); ?>"  >
                             <div class="block-images position-relative">
                                   <!-- block-images -->
                                <div class="img-box">
                                    <img src="<?= URL::to('/') . '/public/uploads/artists/'.$artist->image ?>" alt="" class="w-100">
                                     <div class="p-tag2">
                                           <p class="trending-dec w-100 mb-0 text-white mt-2" ><?php echo $artist->artist_slug ; ?> </p>
                                    </div>
                                 </div>
                                <div class="">
                               <a  href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_name); ?>"  > </a>   
                                </div>
                            </div>
                          </a>
                       </li>
                         <?php }   ?>
                    </ul>
                 </div>
          </div>
<?php } ?>

<!--
    <div id="tags">Tags: 
    <php foreach($video->tags as $key => $tag): ?>
      <span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>
    <php endforeach; ?>
    </div>
-->



<?php if(count($Reels_videos) > 0 && $ThumbnailSetting->reels_videos == 1 ){ ?>
    <div class="video-list you-may-like">
           <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
               <?php include('partials/home/Reels-video.php');?>
           </div>
   </div>
<?php } ?>

                        <!-- Comment Section -->
               
                        <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('videos')->first() == 1 ): ?>
       <div class="row">
           <div class=" container-fluid video-list you-may-like overflow-hidden">
               <h4 class="" style="color:#fffff;"><?php echo __('Comments');?></h4>
               <?php include('comments/index.blade.php');?>
           </div>
       </div>
      <?php endif; ?>
        
        <?php if( $settings->show_recommended_videos == 1 ): ?>
          <div class="video-list you-may-like overflow-hidden">
                  <h4 class="Continue Watching" style="color:#fffff;"><?php echo __('Recomended Videos');?></h4>
                      <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
                      <?php include('partials/video-loop.php');?>
                      </div>
          </div>
        <?php endif; ?>

  </div>
    <script type="text/javascript"> 
        // videojs('videoPlayer').videoJsResolutionSwitcher(); 
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

  // $(".logo_player").hide();
  // $('.plyr__video-wrapper').bind('contextmenu', function() {
  //     $(".logo_player").show();
  //     setTimeout(function() {
  //           $('.logo_player').fadeOut('fast');
  //       }, 30000); 
  //   });

});
</script>

   <!-- INTRO SKIP  -->

   <?php
    $Auto_skip = App\HomeSetting::first();
    $SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();
    $Intro_skip = App\Video::where('id',$video->id)->first();
    $start_time = $Intro_skip->intro_start_time;
    $end_time = $Intro_skip->intro_end_time;

    $StartParse = date_parse($start_time);
    $startSec = $StartParse['hour']  * 60 *  60  + $StartParse['minute']  * 60  + $StartParse['second'];

    $EndParse = date_parse($end_time);
    $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];

    $SkipIntroParse = date_parse($Intro_skip['skip_intro']);
    $skipIntroTime =  $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];

    if($Intro_skip['type'] == "mp4_url" || $Intro_skip['type'] == "m3u8_url"){
      $video_type_id = "videoPlayer";
    }else{
      $video_type_id = "video";
    }

?>

<!-- Ads Start -->

<?php

  include('AdsvideoPre.php'); 
  include('AdsvideoMid.php');
  include('AdsvideoPost.php');


?>

 


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
            height: 100px;
            width: 100px;
            background: url(<?php echo URL::to($logo_url) ; ?>) no-repeat;
            background-size: 100px auto, auto;
            }
        
        </style>
<?php } ?>
    
  </div>



  <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>

<script>

  const player = new Plyr('#videoPlayer1'); 

  var trailer_video_m3u8 = <?php echo json_encode($video->trailer) ; ?> ;
  var trailer_video_type =  <?php echo json_encode($video->trailer_type) ; ?> ;
  

  if(trailer_video_type == "m3u8_url"){
    (function () {
      var video = document.querySelector('#videoPlayer1');

      if (Hls.isSupported()) {
          var hls = new Hls();
          hls.loadSource(trailer_video_m3u8);
          hls.attachMedia(video);
          hls.on(Hls.Events.MANIFEST_PARSED,function() {
        });
      }
      
    })();

  }else if(trailer_video_type == "m3u8"){
  // alert(trailer_video_type);
  document.addEventListener("DOMContentLoaded", () => {
  const videos = document.querySelector('#videos');
  // alert(video);
  const sources = videos.getElementsByTagName("source")[0].src;
  // alert(sources);
  const defaultOptions = {};

  if (Hls.isSupported()) {
    const hlstwo = new Hls();
    hlstwo.loadSource(sources);
    hlstwo.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      const availableQualities = hlstwo.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(videos, defaultOptions);
    });
    hlstwo.attachMedia(videos);
    window.hlstwo = hlstwo;
  }

  function updateQuality(newQuality) {
    window.hlstwo.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hlstwo.currentLevel = levelIndex;
      }
    });
  }
});

  }
   

   

</script>

<?php include(public_path('themes/theme1/views/footer.blade.php')); ?>
