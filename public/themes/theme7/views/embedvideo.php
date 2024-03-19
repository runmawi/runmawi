<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<link rel="stylesheet" href="<?= style_sheet_link();?>" />
<?php

$package = App\User::where('id',1)->first();
$pack = $package->package;
if(!Auth::guest()) {
  // dd($video->access);
  // dd('test');
if( !empty($ppv_video_play) || Auth::user()->role == 'registered' || 
 $video->global_ppv == null && $video->access == 'subscriber' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'registered' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'subscriber' && Auth::user()->role == 'subscriber' || $video->access == 'ppv' && Auth::user()->role == 'admin' || $video->access == 'subscriber' && Auth::user()->role == 'admin' || $video->access == 'registered' && Auth::user()->role == 'admin'|| $video->access == 'registered' && Auth::user()->role == 'subscriber'|| $video->access == 'registered' && Auth::user()->role == 'registered' || Auth::user()->role == 'admin'){


      
if ( $ppv_exist > 0  || Auth::user()->subscribed() && $video->type != "" || 
Auth::user()->role == 'admin' && $video->type != "" || Auth::user()->role =="subscriber" && $video->type != ""
|| (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $video->type != "")) { ?>
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
         <?php  elseif($video->type == 'file'): ?>

           <div id="video sda" class="fitvid" style="margin: 0 auto;">

           
             <video id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>"
             controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"  type="application/x-mpegURL" >
              <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
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
           <?php  elseif($video->type == 'mp4_url'):  ?>
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
               <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
         <h2>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
         <div class="clear"></div>
         <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
           <form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
             <button id="button">Become a subscriber to watch this video</button>
           </form>
         <?php else: ?>
           <form method="get" action="<?= URL::to('signup') ?>">
             <button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
           </form>
         <?php endif; ?>
       </div>
     
     <?php endif; ?>            
   </div>
 

   <div class="col-sm-12 intro_skips">
       <!-- <input type="button" class="skips" value="Skip Intro" id="intro_skip">
       <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip"> -->

  </div>

  <?php } elseif( $ppv_exist > 0  || Auth::user()->subscribed() && $pack == "Business" || Auth::user()->role == 'admin' && $pack == "Business" || Auth::user()->role =="subscriber" && $pack == "Business"
   || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $pack == "Business")) {
 if(!empty($video->path)){  ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
      <source 
        type="application/x-mpegURL" 
        src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"
      >
    </video>
               <!-- <video id="video"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   > -->
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
<?php } }
/* For Registered User */       
   else {  ?>      
       <div id="video" class="fitvid" style="margin: 0 auto;">
       
       <!-- <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" > -->
       <video   id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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
 else { ?>
 <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
  <div id="subscribers_only">
  <div class="clear"></div>
  <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
  <h2 ><p style ="margin-left:14%">Sorry, this video is only available to</p> <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
  <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'ppv'){ ?>
    <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
      <button style="margin-left: 27%;margin-top: 0%;" class="btn btn-primary"id="button">Purchase to watch this video</button>
    </form>
  <?php }else{ ?>
    <form method="get" action="<?= URL::to('signup') ?>">
      <button id="button" style="margin-top: 0%;">Signup Now <?php if($video->access == 'subscriber'): ?>to Purchase this video <?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
    </form>
  <?php } ?>
  </div>
</div>
</div>
 <?php }
}elseif($video->access == 'subscriber' && Auth::user()->role == 'registered' || $video->access == 'ppv' && Auth::user()->role == 'registered'){  ?>
<div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">

 <div id="subscribers_only">
 <h2 style ="margin-left:14%">Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
 <div class="clear"></div>
 <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
   <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
     <button style="margin-left: 27%;" id="button">Become a subscriber to watch this video</button>
   </form>
 <?php else: ?>
   <form method="get" action="<?= URL::to('signup') ?>">
     <button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
   </form>
 <?php endif; ?>
</div>
<?php } ?>
<!-- For Guest users -->      
 <?php if(Auth::guest()) {  ?>
   <div id="video" class="fitvid" style="margin: 0 auto;">
       
       <video id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
           <source src="<?= $video->trailer; ?>" type='video/mp4' label='Auto' res='auto' />
<!--
   <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" >

   <source src="<? //= $video->trailer; ?>" type='video/mp4' label='auto' > 
-->
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
            <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
                <source src="<?php if($video->type == "m3u8_url"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>" type="application/x-mpegURL" label='auto' > 
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
 <script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
 <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
          

 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
 <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
 <script>
    var type = '<?= $video->type ?>';

   if(type != ""){
        const player = new Plyr('#videoPlayer',{
          controls: [

      'play-large',
			'restart',
			'rewind',
			'play',
			'fast-forward',
			'progress',
			'current-time',
			'mute',
			'volume',
			'captions',
			'settings',
			'pip',
			'airplay',
			'fullscreen',
			'capture'
		],
    i18n:{
    // your other i18n
    capture: 'capture'
}

        });
   }
else{
          document.addEventListener("DOMContentLoaded", () => {
  const video = document.querySelector("video");
  const source = video.getElementsByTagName("source")[0].src;
  
  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const defaultOptions = {};

  if (Hls.isSupported()) {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);

    // From the m3u8 playlist, hls parses the manifest and returns
    // all available video qualities. This is important, in this approach,
    // we will have one source on the Plyr player.
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      // Transform available levels into an array of integers (height values).
      const availableQualities = hls.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(video, defaultOptions);
    });
    hls.attachMedia(video);
    window.hls = hls;
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
  }

  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});

}
         
      </script>
</body>
</html>
