 
<?php include('header.php');  ?>

<input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo  $playerui_settings->watermark_logo ;?>">

  <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
  <input type="hidden" id="videoslug" value="<?php if(isset($video->slug)) { echo $video->slug; } else{ echo "0";}?>">
  <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
  <input type="hidden" id="adsurl" value="<?php if(isset($ads->ads_id)){echo get_adurl($ads->ads_id);}?>">
  <style>
    .vjs-error.vjs-error-display.vjs-modal-dialog-content {
   font-size: 2.4em;
   text-align: center;
   padding-top: 20%; 
}
.vjs-seek-to-live-control {
           display: none !important;
       }
  </style>
<?php

// $ppv_video = \DB::table('ppv_purchases')->where('user_id',Auth::user()->id)->get();
// exit();
// echo "<pre>";

if(!Auth::guest()) {

if(!Auth::guest()) {

if( !empty($ppv_video_play) || Auth::user()->role == 'registered' ||  $video->global_ppv == null && $video->access == 'subscriber' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'registered' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'subscriber' && Auth::user()->role == 'subscriber' || $video->access == 'ppv' && Auth::user()->role == 'admin' || $video->access == 'subscriber' && Auth::user()->role == 'admin' || $video->access == 'registered' && Auth::user()->role == 'admin'|| $video->access == 'registered' && Auth::user()->role == 'subscriber'|| $video->access == 'registered' && Auth::user()->role == 'registered' || Auth::user()->role == 'admin'){

//  dd(Auth::user()->role); 
      
  if ( $ppv_exist > 0  || Auth::user()->subscribed() || Auth::user()->role == 'admin' || Auth::user()->role =="subscriber" || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered')) { ?>
<?php //dd(Auth::user()->role); ?>

 <div id="video_bg">
   <div class=" page-height">
     <?php 
           $paypal_id = Auth::user()->paypal_id;
           if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
           $paypal_subscription = PaypalSubscriptionStatus();
           } else {
             $paypal_subscription = "";  
           }
           if($ppv_exist > 0  || Auth::user()->subscribed() || $paypal_subscription =='CANCE' || $video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() ) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
         <?php if($video->type == 'embed'): ?>
           <div id="video_container" class="fitvid">
             <?php
              if(!empty($video->embed_code)){
               echo $video->embed_code;
             }else{
               echo $video->trailer;
             } ?>
           </div>
         <?php  elseif($video->type == 'file'): ?>

           <div id="video sda" class="fitvid" style="margin: 0 auto;">

           
             <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>"
             controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"  type="application/x-mpegURL" >
             <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_1_500.m3u8'; ?>" type='application/x-mpegURL' label='360p' res='360' />
               <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
                 <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 



                   <?php
                   if($playerui_settings['subtitle'] == 1 ){

                     foreach($subtitles as $key => $value){


                       if($value['sub_language'] == "English"){
                         ?>
                         <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                         <?php } 
                         if($value['sub_language'] == "German"){
                           ?>
                           <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                           <?php }
                           if($value['sub_language'] == "Spanish"){
                             ?>
                             <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                             <?php }
                             if($value['sub_language'] == "Hindi"){
                               ?>
                               <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                               <?php }
                             }
                           }else{

                           } 
                           ?>  
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
           <?php  elseif($video->type == 'mp4_url'):   ?>
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="videoPlayer" autoplay class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                  <!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                   <source src="<?php if(!empty($video->mp4_url)){ echo $video->mp4_url; }else { echo $video->trailer;} ?>"  type='video/mp4' label='auto' > 
                   <track label="German" kind="subtitles" srclang="de" src="http://localhost/flicknexs/public/uploads/subtitles/20-de.vtt" >
                   <track label="Hindi" kind="subtitles" srclang="hi" src="http://localhost/flicknexs/public/uploads/subtitles/20-hi.vtt" >

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
               <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
<!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                   <source src="<?php if($video->type == "m3u8_url"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>" type='application/x-mpegURL' label='auto' > 

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
     <?php else: ?>

       <div id="subscribers_only">
         <h2>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered' ): ?>Registered Users<?php elseif($video->access == 'ppv' ): ?>PPV<?php endif; ?></h2>
         <div class="clear"></div>
         <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
           <form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
             <button id="button">Become a subscriber to watch this video</button>
           </form>
         <?php else: ?>
           <form method="get" action="<?= URL::to('signup') ?>">
           </form>
         <?php endif; ?>
       </div>
     
     <?php endif; ?>            
   </div>
 

 <?php }
/* For Registered User */       
   else { ?>       
       <div id="video" class="fitvid" style="margin: 0 auto;">
       
       <!-- <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" > -->
       <video  autoplay id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
           <source src="<?= $video->trailer; ?>" type='video/mp4' label='Auto' res='auto' />

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
 <?php } } 
}elseif($video->access == 'subscriber' && Auth::user()->role == 'registered' || $video->access == 'ppv' && Auth::user()->role == 'registered'){  ?>
<div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">

 <div id="subscribers_only">
 <div class="clear"></div>
 <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
 <h2 ><p style ="margin-left:14%">Sorry, this video is only available to</p> <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
 <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'ppv'): ?>
   <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
     <button style="margin-left: 27%;margin-top: 0%;" class="btn btn-primary"id="button">Become a subscriber to watch this video</button>
   </form>
 <?php else: ?>
   <form method="get" action="<?= URL::to('signup') ?>">
     <button id="button" style="margin-top: 0%;">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
   </form>
 <?php endif; ?>
</div>
</div>
</div>


<?php } } ?>
<!-- For Guest users -->      
 <?php if(Auth::guest() && !empty($video->ppv_price)) {  ?>
  <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
    
    <div id="subscribers_only">
    <div class="clear"></div>
    <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
    <h2 ><p style ="margin-left:14%">Sorry, this video is only available to</p> <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
    <?php if(Auth::guest() && $video->access == 'ppv'): ?>
      <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
        <button style="margin-left: 27%;margin-top: 0%;" class="btn btn-primary"id="button">Become a subscriber to watch this video</button>
      </form>
    <?php else: ?>
      <form method="get" action="<?= URL::to('signup') ?>">
        <button id="button" style="margin-top: 0%;">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
      </form>
    <?php endif; ?>
   </div>
   </div>
   </div>
  <?php }elseif(Auth::guest() && empty($video->ppv_price)){ ?>
    <div id="video_bg">
<div class=" page-height">
  <?php 
        if( Auth::guest() ): ?>
      <?php if($video->type == 'embed'): ?>
        <div id="video_container" class="fitvid">
          <?php
           if(!empty($video->embed_code)){
            echo $video->embed_code;
          }else{
            echo $video->trailer;
          } ?>
        </div>
      <?php  elseif($video->type == 'file'): ?>

        <div id="video sda" class="fitvid" style="margin: 0 auto;">

        
          <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>"
          controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"  type="application/x-mpegURL" >
          <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_1_500.m3u8'; ?>" type='application/x-mpegURL' label='360p' res='360' />
            <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
              <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 



                <?php
                if($playerui_settings['subtitle'] == 1 ){

                  foreach($subtitles as $key => $value){


                    if($value['sub_language'] == "English"){
                      ?>
                      <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
                      <?php } 
                      if($value['sub_language'] == "German"){
                        ?>
                        <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
                        <?php }
                        if($value['sub_language'] == "Spanish"){
                          ?>
                          <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
                          <?php }
                          if($value['sub_language'] == "Hindi"){
                            ?>
                            <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
                            <?php }
                          }
                        }else{

                        } 
                        ?>  
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
        <?php  elseif($video->type == 'mp4_url'):   ?>
        
          
              <div id="video_container" class="fitvid" atyle="z-index: 9999;">
            <!-- Current time: <div id="current_time"></div> -->
            <video id="videoPlayer" autoplay class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
               <!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                <source src="<?php if(!empty($video->mp4_url)){ echo $video->mp4_url; }else { echo $video->trailer;} ?>"  type='video/mp4' label='auto' > 
                <track label="German" kind="subtitles" srclang="de" src="http://localhost/flicknexs/public/uploads/subtitles/20-de.vtt" >
                <track label="Hindi" kind="subtitles" srclang="hi" src="http://localhost/flicknexs/public/uploads/subtitles/20-hi.vtt" >

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
            <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
<!--                <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >-->
                <source src="<?php if($video->type == "m3u8_url"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>" type='application/x-mpegURL' label='auto' > 

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
  <?php else: ?>

    <div id="subscribers_only">
      <h2>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered' ): ?>Registered Users<?php elseif($video->access == 'ppv' ): ?>PPV<?php endif; ?></h2>
      <div class="clear"></div>
      <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
        <form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
          <button id="button">Become a subscriber to watch this video</button>
        </form>
      <?php else: ?>
        <form method="get" action="<?= URL::to('signup') ?>">
        </form>
      <?php endif; ?>
    </div>
  
  <?php endif; ?>            
</div>
 <?php }  ?>
           

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
             
           </div>
       </div>
       <!-- Year, Running time, Age -->
         <div class="d-flex align-items-center text-white text-detail">
            <span class="badge badge-secondary p-3"><?php echo __($video->age_restrict).' '.'+';?></span>
            <!-- .' '.'+' -->
            <span class="ml-3"><?php echo __($video->categories->name);?></span>
            <span class="ml-3"><?php echo __($video->duration);?></span>
            <span class="trending-year"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
         </div>
           
       <?php if(!Auth::guest()) { ?>
       <div class="row">
           <div class="col-sm-6 col-md-6 col-xs-12">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists videoaction">
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
                       <?php //if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin" || ($user->role="subscriber" && $video->global_ppv == 1 ))  ) { ?>
                       <?php if ( $video->global_ppv != null && $user->role!="admin" || $video->ppv_price != null  && $user->role!="admin") { ?>

                         <!-- && ($video->global_ppv == 1 ) -->
                           <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                           <?php echo __('Purchase for').' '.$currency->symbol.' '.$video->ppv_price;?> </button>
                       <?php } ?>
                   </li>
                   <li>
                       <div class="btn btn-default views btn btn-primary">
                           <span class="view-count"><i class="fa fa-eye"></i> 
                               <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                           </span>
                       </div>
                   </li>
                   
                   <li>
                   <div class=" pull-right btn btn-default ">     
                       <?php if($video->trailer != ''){ ?>
                        <div id="videoplay" style="color:white;border: 1px solid #ddd;" class="watchlater btn btn-default watch_trailer"><i class="ri-film-line"></i>Watch Trailer</div>
                           <div style=" display: none;" class="skiptrailer btn btn-default skip">Skip</div>
                       <?php } ?>
                   </div>
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
                       <li>
                           <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                       </li>
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
                   </ul>

               </div>
           </div>
           <?php   } ?>
           <?php if(!empty($video->description) ) { ?>

           <h4>Description</h4>
              <div class="text-white">
                  <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
              </div>
    <?php  }?>

       <br>
<?php if(!empty($video->details) ) { ?>

                  <h4>Links & details</h4>
              <div class="text-white">
                  <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->details); ?></p>
              </div>
    <?php  }?>

       <br>
       <?php if(Auth::guest()){
$artists = [];
}else{

}
 if(count($artists) > 0 ) { ?>
 <h4>Cast & crew</h4>
         <?php
           foreach($artists as $key => $artist){
           foreach($artist as $key => $value){
         ?>
           <img src="<?= URL::to('/') . '/public/uploads/artists/'.$value->image ?>" alt=""width="50" height="60">
           <p class="trending-dec w-100 mb-0 text-white mt-2" >Directed by : <?php echo $value->artist_name ; ?> </p>&nbsp;&nbsp;
           <p class="trending-dec w-100 mb-0 text-white" >Description by  :  <?php echo $value->description ; ?></p>&nbsp;&nbsp;
           <!-- <p class="trending-dec w-100 mb-0 text-white" >Produced by  :<?php //echo $value->artist_name ; ?></p>&nbsp;&nbsp;
           <p class="trending-dec w-100 mb-0 text-white" >Music by  :<?php //echo $value->artist_name ; ?></p>&nbsp;&nbsp;
           <p class="trending-dec w-100 mb-0 text-white" >Description by  :<?php// echo $value->artist_name ; ?></p>&nbsp;&nbsp; -->
    <?php } }  }?>
    <br>
           
  <!-- Button trigger modal -->

   <!-- Modal -->
   <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
           <img src="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" alt=""width="50" height="60">
         </div>
         <div class="modal-body">
             <div class="row">
                 <div class="col-sm-2" style="width:52%;">
                   <span id="paypal-button"></span> 
                 </div>
                <?php $payment_type = App\PaymentSetting::get(); ?>
                 
                 <div class="col-sm-4">
                 <span class="badge badge-secondary p-2"><?php echo __($video->title);?></span>
                 <span class="badge badge-secondary p-2"><?php echo __($video->age_restrict).' '.'+';?></span>
                <span class="badge badge-secondary p-2"><?php echo __($video->categories->name);?></span>
                <span class="badge badge-secondary p-2"><?php echo __($video->languages->name);?></span>
                <span class="badge badge-secondary p-2"><?php echo __($video->duration);?></span>
                <span class="trending-year"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
               <button type="button" class="btn btn-primary"  data-dismiss="modal"><?php echo __($currency->symbol.' '.$video->ppv_price);?></button>
                 <label for="method"><h3>Payment Method</h3></label>

                <label class="radio-inline">
                    <?php  foreach($payment_type as $payment){
                          if($payment->live_mode == 1){ ?>
                <input type="radio" id="tres_important" name="payment_method" value="{{ $payment->payment_type }}">Stripe</label>
                <?php }elseif($payment->paypal_live_mode == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">PayPal</label>
                <?php }else{
                            } }?>

                 </div>
             </div>                    
         </div>
         <div class="modal-footer">
         <a onclick="pay(<?php echo $video->ppv_price ;?>)">
					<button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
                   </a>
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
           <div class="slider" >   
           <!-- data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}' -->
               <?php include('partials/video-loop.php');?>
           </div>
   </div>
   <div id="watch_trailer" class="fitvid" style="margin: 0 auto;">
   <video  id="videoPlayer" class=""  controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" src="<?php echo $video->trailer;?>">

  </div>

  <?php  if(Auth::guest()){ ?>
<?php }else{ ?>
  <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">
<?php } ?><script type="text/javascript">

    jQuery(document).ready(function($){


        // Add New Category
        $('#submit-new-cat').click(function(){
            $('#payment-form').submit();
        });
        $(".plans_name_choose").click(function(){
        // alert($(this).val());
        $("#modal_plan_name").val($(this).val());

    });
    });
  
</script>
                
   <script type="text/javascript"> 
       // videojs('videoPlayer').videoJsResolutionSwitcher(); 
   </script>
   <script src="https://checkout.stripe.com/checkout.js"></script>
   <div class="clear"></div>
       <script>


$(document).ready(function(){
  $("#videoaction li").on('click', function(){
    $(this).siblings().removeClass('active');
    $(this).addClass('active')
  })
})
function savesubcat(){
  return null
}







// $('#myVideo2').show();
// $(document).ready(function(){
// $('#playVid').click(function(){
// $('#myVideo1').hide();
// $('#myVideo2').show();
//   $('#playVid').play(); 
//   $('#mysVideo').pause(); 
// });
// });


         $(document).ready(function () { 

           /*Watch trailer*/
          //  $(".watch_trailer").click(function() {
          //    var videohtml = '<video id="videoPlayer" controls autoplay><source src="<?php echo $video->trailer;?>"></video>';
          //    $("#video_container").empty();
          //    $(".skip").css('display','inline-block');
          //    $("#video_container").html(videohtml);
          //  });
          var vid = document.getElementById("videoPlayer"); 
          $('#watch_trailer').hide();
          $('.watch_trailer').click(function(){
            $('#video_container').hide();
            $('#watch_trailer').show();
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

           var vid = document.getElementById("videoPlayer");
           vid.currentTime = $("#current_time").val();
           $(window).on("beforeunload", function() { 

             var vid = document.getElementById("videoPlayer");
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
             var publishable_key = $('#publishable_key').val();

             var video_id = $('#video_id').val();
            // alert(video_id);
             var handler = StripeCheckout.configure({

               key: publishable_key,
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
 data: {"_token": "<?= csrf_token(); ?>",tokenId:token.id, amount: amount , video_id: video_id },
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
     // $('.watchlater').click(function(){
     //   if($(this).data('authenticated')){
     //     $.post('<?// URL::to('watchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?// csrf_token(); ?>' }, function(data){});
     //     $(this).toggleClass('active');
     //     $(this).html("");
     //         if($(this).hasClass('active')){
     //           $(this).html('<i class="ri-add-circle-fill"></i>');
     //         }else{
     //           $(this).html('<i class="ri-add-circle-line"></i>');
     //         }
     //   } else {
     //     window.location = '<?= URL::to('login') ?>';
     //   }
     // });

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


     $('.watchlater').click(function(){
       if($(this).data('authenticated')){
         $.post('<?= URL::to('addwatchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' },
          function(data){});
         $(this).toggleClass('active');
         $(this).html("");
             if($(this).hasClass('active')){
               $(this).html('<i class="ri-add-circle-fill"></i>');
              //  alert();

             }else{
               $(this).html('<i class="ri-add-circle-line"></i>');

             }
             
       } else {
         window.location = '<?= URL::to('login') ?>';
       }
     });

    //  $(document).ready(function(){
    //     // $('#message').fadeOut(120);
    //     setTimeout(function() {
    //         $('#successMessage').fadeOut('fast');
    //     }, 3000);
    // })
    // $('#videoPlayer').play();

    var vid = document.getElementById("videoPlayer");
    vid.autoplay = true;
    vid.load();

       </script>
       
   </div>
   <style>

   </style>
<?php include('footer.blade.php');?>

