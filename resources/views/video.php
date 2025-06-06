
<?php include('header.php'); ?>

<input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo  $playerui_settings->watermark_logo ;?>">

  <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
  <input type="hidden" id="videoslug" value="<?php if(isset($video->slug)) { echo $video->slug; } else{ echo "0";}?>">
  <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
  <input type="hidden" id="adsurl" value="<?php if(isset($ads->ads_id)){echo get_adurl($ads->ads_id);}?>">
  <style>
    .vjs-error .vjs-error-display .vjs-modal-dialog-content {
   font-size: 2.4em;
   text-align: center;
   padding-top: 20%; 
}
.vjs-seek-to-live-control {
           display: none !important;
       }
.intro_skips {
    position: absolute;
    margin-top: -14%;
    margin-bottom: 0;
    margin-left: 80%;
    margin-right: 0;
}
input.skips{
  background-color: #21252952;
    color: white;
    padding: 15px 32px;
    text-align: center;
    margin: 4px 2px;
}
#intro_skip{
	display: none;
}
#Auto_skip{
	display: none;
}
  </style>
<?php

// $ppv_video = \DB::table('ppv_purchases')->where('user_id',Auth::user()->id)->get();
// exit();
// echo "<pre>";
// print_r($ppv_video_play); exit();
// dd($recomended);

$package = App\User::where('id',1)->first();
$pack = $package->package;
if(!Auth::guest()) {
  // dd($video->access);
  // dd('test');
if( !empty($ppv_video_play) || Auth::user()->role == 'registered' ||  $video->global_ppv == null && $video->access == 'subscriber' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'registered' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'subscriber' && Auth::user()->role == 'subscriber' || $video->access == 'ppv' && Auth::user()->role == 'admin' || $video->access == 'subscriber' && Auth::user()->role == 'admin' || $video->access == 'registered' && Auth::user()->role == 'admin'|| $video->access == 'registered' && Auth::user()->role == 'subscriber'|| $video->access == 'registered' && Auth::user()->role == 'registered' || Auth::user()->role == 'admin'){

//  dd(Auth::user()->role); 

      
if ( $ppv_exist > 0  || Auth::user()->subscribed() && $video->type != "" || Auth::user()->role == 'admin' && $video->type != "" || Auth::user()->role =="subscriber" && $video->type != ""
|| (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $video->type != "")) { ?><?php //dd(Auth::user()->role); ?>

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
                   <source src="<?php if(!empty($video->mp4_url)){  echo $video->mp4_url; }else {  echo $video->trailer;} ?>"  type='video/mp4' label='auto' > 
                
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
       <input type="button" class="skips" value="Skip Intro" id="intro_skip">
       <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">

  </div>

  <?php }elseif( $ppv_exist > 0  || Auth::user()->subscribed() && $pack == "Business" || Auth::user()->role == 'admin' && $pack == "Business" || Auth::user()->role =="subscriber" && $pack == "Business"
   || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $pack == "Business")) {
 if(!empty($video->path)){  ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
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
               <div class="col-md-12">
            <!-- <div id="video_containers plyr__video" class="fitvid mfp-hide" atyle="z-index: 9999;"> -->
            <!-- <div id="video-trailer" class="mfp-hide"> -->
             <!-- <video id="videoPlayer"  poster="<?php echo URL::to('/').'/public/uploads/images/' .$video->image;?>"  class="" controls src="<?= $video->trailer; ?>"  type="application/x-mpegURL" ></video>
               </div>
               <div class="trailor-video">
                        <a href="#video_containers"
                            class="video-open playbtn">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                            viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                            stroke-linejoin="round" stroke-miterlimit="10"
                            points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                            stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                        </svg>
                        <span class="w-trailor">Watch Trailer</span>
                    </a>
                    </div> -->
               <div class="col-sm-3 col-md-3 col-xs-12">
                   <div class=" d-flex mt-4 pull-right">     
                       <?php if($video->trailer != ''){ ?>
                           <!-- <div id="videoplay" class="watchlater btn btn-default watch_trailer"><i class="ri-film-line"></i>Watch Trailer</div> -->
                           <div style=" display: none;" class="skiptrailer btn btn-default skip">Skip</div>
                       <?php } ?>
                   </div>
               </div>
           </div>
       </div>
       <!-- Year, Running time, Age --> 
         <div class="d-flex align-items-center text-white text-detail">
            <span class="badge badge-secondary p-3"><?php echo __($video->age_restrict).' '.'+';?></span>
            <span class="ml-3"><?php echo __(gmdate('H:i:s', $video->duration));?></span>
            <span class="trending-year"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
            <span class="trending-year"><?php
            foreach($category_name as $value){
              echo $value->categories_name. ',';  
            }
             ?></span>

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
                       <?php //if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin" || ($user->role="subscriber" && $video->global_ppv == 1 ))  ) { ?>
                       <?php if ( $video->global_ppv != null && $user->role!="admin" || $video->ppv_price != null  && $user->role!="admin") { ?>

                         <!-- && ($video->global_ppv == 1 ) -->
                           <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                           <?php echo __('Rents');?> </button>
                       <?php } ?>
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
          //  foreach($artist as $key => $value){
         ?>
           <img src="<?= URL::to('/') . '/public/uploads/artists/'.$artist->image ?>" alt=""width="50" height="60">
           <p class="trending-dec w-100 mb-0 text-white mt-2" ><?php echo $artist->artist_name ; ?> </p>&nbsp;&nbsp;
    <?php } }  ?>
           
       <!-- <div class="text-white">
           <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
       </div> -->
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
                 <span class="badge badge-secondary p-2"><?php echo __($video->title);?></span>
                 <span class="badge badge-secondary p-2"><?php echo __($video->age_restrict).' '.'+';?></span>
                <span class="badge badge-secondary p-2"><?php echo __(isset($video->categories->name));?></span>
                <span class="badge badge-secondary p-2"><?php echo __(isset($video->languages->name));?></span>
                <span class="badge badge-secondary p-2"><?php echo __($video->duration);?></span>
                <span class="trending-year"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
               <button type="button" class="btn btn-primary"  data-dismiss="modal"><?php echo __($currency->symbol.' '.$video->ppv_price);?></button>
                 <label for="method"><h3>Payment Method</h3></label>
                 
                 <?php $payment_type = App\PaymentSetting::get(); ?>

                <label class="radio-inline">
                <?php  foreach($payment_type as $payment){
                          if($payment->stripe_status == 1 || $payment->paypal_status == 1){ 
                          if($payment->live_mode == 1 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
		        <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
              </label>
                <?php }elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
			      	<?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
                <?php }elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
		        <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
              </label><br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
				<?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
              </label>
						<?php  } }else{
                            echo "Please Turn on Payment Mode to Purchase";
                            break;
                         }
                         }?>

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
   <div id="watch_trailer" class="fitvid" style="margin: 0 auto;">
       <video  id="videoPlayer" class=""  controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" src="<?php echo $video->trailer;?>"></video>
  </div>

  <?php  if(Auth::guest()){ ?>
<?php }else{ ?>
  <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">
<?php } ?>
<?php if(!empty($video->m3u8_url)){ ?>
  <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->m3u8_url ?>">
<?php }?>
<?php if(!empty($ads_path)){ ?>
  <input type="hidden" id="ads_path" name="ads_path" value="<?php echo $ads_path ?>">
<?php }?>


  </div>

<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">

   <script type="text/javascript"> 
       // videojs('videoPlayer').videoJsResolutionSwitcher(); 
   </script>
   <script src="https://checkout.stripe.com/checkout.js"></script>
   <div class="clear"></div>
       <script>
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
          //  $(document).on("click",".skip",function() {
          //    $("#video_container").empty();
          //    $(".skip").css('display','none');
          //    $(".page-height").load(location.href + " #video_container");
          //    setTimeout(function(){ 
          //    videojs('videoPlayer');
          //  }, 2000);
          //  });

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
   }); 
  });

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
              $(".add_data_test").empty();
              $(".add_data_test").append("<div>Remove from Wishlist</div> ");
               $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
             }else{
              $(this).html('<i class="ri-heart-line"></i>');
              $(".add_data_test").empty();
              //  $(this).html('<i class="ri-heart-line"></i>');
               $(".add_data_test").append("<div>Added to  Wishlist</div> ");
              $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
               setTimeout(function() {
                $('.remove_watch').slideUp('fast');
               }, 3000);

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
               $(".add_data_test").empty();
              $(".add_data_test").append("<div>Remove from Watchlater</div> ");
               $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to watchlater </div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
              //  alert();

             }else{
              //  $(this).html('<i class="ri-add-circle-line"></i>');
               $(this).html('<i class="ri-heart-line"></i>');
              $(".add_data_test").empty();
              //  $(this).html('<i class="ri-heart-line"></i>');
               $(".add_data_test").append("<div>Added to Watchlater</div> ");
              $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from watchlater</div>');
               setTimeout(function() {
                $('.remove_watch').slideUp('fast');
               }, 3000);
             }
             
       } else {
         window.location = '<?= URL::to('login') ?>';
       }
     });

       </script>

<!-- INTRO SKIP  -->

<?php
    $Auto_skip = App\HomeSetting::first();
    $Intro_skip = App\Video::where('id',$video->id)->first();
    $start_time = $Intro_skip->intro_start_time;
    $end_time = $Intro_skip->intro_end_time;

    $StartParse = date_parse($start_time);
    $startSec = $StartParse['hour'] * 60 + $StartParse['minute'] + $StartParse['second'];
    $EndParse = date_parse($end_time);
    $EndSec = $EndParse['hour'] * 60 + $EndParse['minute'] + $EndParse['second'];
?>

<script>

  var video = document.getElementById("videoPlayer");
  var button = document.getElementById("intro_skip");
  var Start = <?php echo json_encode($startSec); ?>;
  var End = <?php echo json_encode($EndSec); ?>;
  var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;

button.addEventListener("click", function(e) {
	video.currentTime = End;
  video.play();
})
if(AutoSkip != 1){
      this.video.addEventListener('timeupdate', (e) => {
        document.getElementById("intro_skip").style.display = "none";
        document.getElementById("Auto_skip").style.display = "none";

        if (Start <= e.target.currentTime && e.target.currentTime < End) {
                document.getElementById("intro_skip").style.display = "block"; // Manual skip
        } 
    });
}
else{
  this.video.addEventListener('timeupdate', (e) => {
        document.getElementById("intro_skip").style.display = "none";
        document.getElementById("Auto_skip").style.display = "none";

        var before_Start = Start - 5;
        var trigger = Start - 1;
        if (before_Start <= e.target.currentTime && e.target.currentTime < Start) {
            document.getElementById("Auto_skip").style.display = "block";
               if(trigger  <= e.target.currentTime){
                 document.getElementById("intro_skip").click();    // Auto skip
               }
        }
    });
}
</script>

   </div>
<?php include('footer.blade.php');?>

