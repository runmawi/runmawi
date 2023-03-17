
<?php
    include(public_path('themes/theme2/views/header.php'));
?>

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
  $ads_path = $default_ads; 
  } 
   
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
  <input type="hidden" id="video_video" value="video">
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

input.skips,input#Recaps_Skip{
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
div#url_linkdetails {
    position: absolute;
    top: 22%;
    left: 83%;
    font-size: x-large;
    display: none;
}
     .intro_skips,.Recap_skip {
   position: absolute;
       z-index: 5;
       top: 70%;
       right: 70px;
       display: flex;
       justify-content: flex-end;
   
        
}
      .skips{
          position: absolute;
          top:-20%;
      }
 .end_card_video {
    position: absolute;
    top: -19%;
    left: 79%;
     
} 
      .plyr__poster{
          background-size: cover!important;
      }
.countdown {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
  color:red;
}
h2{
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
      #video_container{
          padding: 20px;
          background: #202933;
border-radius: 20px;

      }

      #end_card_video{
  /* end_card_video */
	display: none;
}
       .modal-header {
          padding: 10px!important;
          
      }.modal-title{
          color: #000;
          font-weight: 700;
font-size: 24px!important;
line-height: 33px;
          
      }
      label{
          font-size: 18px;
line-height: 21px;
          padding-left: 5px;
          color: #000;
      }
      .modal-body{
           border-top: 1px solid rgba(0, 0, 0, 0.2)!important;
          border:none;
      }
       .modal-footer {
       
           border-top: 1px solid rgba(0, 0, 0, 0.2)!important;
            border:none;
      }
      .badge-secondary{
          color: #000;
       background: #F1F1F1;
          border-radius: 5px;
          font-weight: 700;
font-size: 18px;
line-height: 21px;
      }
      .modal-body a{
          font-weight: 400;
font-size: 20px;
line-height:30px;
          color: #000!important;
      }
      .movie{
          font-weight: 700;
font-size: 30px!important;
line-height: 38px;
      }
#intro_skip{
	display: none;
}
      .button.close{
          color: red;
      }
#Auto_skip{
	display: none;
}
      .modal-content{
          background-color: #fff;
          border: 1px solid #F1F1F1;
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
border-radius: 20px;
          padding: 20px;

      }
      .modal-dialog{
          max-width:695px!important;
      }
      .modal {
          top:2%;
      }
      .btn2{
          padding: 13px 45px!important;
          font-weight: 400;
    
  border: 1px solid;
   
   
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
if(empty($new_date)){

if(!Auth::guest()) {
  // dd($video->access);
  // dd('test');
if( !empty($ppv_video_play) || $video_access == 'free' || Auth::user()->role == 'registered' || 
 $video->global_ppv == null && $video->access == 'subscriber' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'registered' ||  $video->global_ppv == null && $video->ppv_price == null && $video->access == 'subscriber' && Auth::user()->role == 'subscriber' || $video->access == 'ppv' && Auth::user()->role == 'admin' || $video->access == 'subscriber' && Auth::user()->role == 'admin' || $video->access == 'registered' && Auth::user()->role == 'admin'|| $video->access == 'registered' && Auth::user()->role == 'subscriber'|| $video->access == 'registered' && Auth::user()->role == 'registered' || Auth::user()->role == 'admin'){


      
if ( $ppv_exist > 0 || $video_access == 'free' || Auth::user()->subscribed() && $video->type != "" || 
Auth::user()->role == 'admin' && $video->type != "" || Auth::user()->role =="subscriber" && $video->type != ""
|| (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $video->type != "")) { ?>
<?php //dd(Auth::user()->role); ?>

 <div id="video_bg">
      <div class="col-sm-12 intro_skips">
       <input type="button" class="skips" value="Skip Intro" id="intro_skip">
       <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
  </div>
   <div class="container-fluid page-height mt-3">
     <?php 
           $paypal_id = Auth::user()->paypal_id;
           if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
           $paypal_subscription = PaypalSubscriptionStatus();
           } else {
             $paypal_subscription = "";  
           }
           if($ppv_exist > 0 || $video_access == 'free' || Auth::user()->subscribed() || $paypal_subscription =='CANCE' || $video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() ) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
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
           <?php  elseif($video->type == 'aws_m3u8'):  ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">

          <video  autoplay id="video"  allow="autoplay" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo $video->m3u8_url; ?>"  type='application/x-mpegURL' label='auto' > 
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
           <?php  elseif($video->type == ''): ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">



          <video  autoplay id="video"  allow="autoplay" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"  type='application/x-mpegURL' label='auto' > 
  <?php if($playerui_settings['subtitle'] == 1 ){ foreach($subtitles as $key => $value){ if($value['sub_language'] == "English"){ ?>
           <track label="English" kind="subtitles" srclang="en" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "German"){ ?>
           <track label="German" kind="subtitles" srclang="de" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "Spanish"){ ?>
           <track label="Spanish" kind="subtitles" srclang="es" src="<?= $value['url'] ?>" >
           <?php } if($value['sub_language'] == "Hindi"){ ?>
           <track label="Hindi" kind="subtitles" srclang="hi" src="<?= $value['url'] ?>" >
           <?php } } } else { }  ?>  

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
  <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">

</div>
  
           </div>
           <?php  elseif($video->type == 'mp4_url'):  ?>
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <!-- Current time: <div id="current_time"></div> -->
               <video id="videoPlayer"  class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
        
        <video  id="video" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
               <video  id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
       <h4 class="text-center"><?php echo $video->title ; ?></h4>
  <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo ($video->description) ; ?></p>
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
 
  <?php }elseif( $ppv_exist > 0  || $video_access == 'free' || Auth::user()->subscribed() && $pack == "Business" || Auth::user()->role == 'admin' && $pack == "Business" || Auth::user()->role =="subscriber" && $pack == "Business"
   || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered' && $pack == "Business")) {
 if(!empty($video->path)){  ?>
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
  <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
<?php } }
/* For Registered User */       
   else {  ?>    
    <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
  <div id="subscribers_only">
  <div class="clear"></div>
  <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
  <h4 class="text-center"><?php echo $video->title ; ?></h4>
  <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo ($video->description) ; ?></p>
  <h2 ><p style ="margin-left:14%">Sorry, this video is only available to</p> <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
    <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'ppv'|| !Auth::guest() && $video->access == 'guest' && !empty($video->ppv_price) ){ ?>
    <form method="get" action="<?= route('payment_becomeSubscriber')  ?>">
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
       <!-- <div id="video" class="fitvid" style="margin: 0 auto;"> -->
       
       <!-- <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" > -->
       <!-- <video   id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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

       </div> -->
 <?php } } 
 else { ?>
 <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
  <div id="subscribers_only">
  <div class="clear"></div>
  <div style="position: absolute;top: 20%;left: 20%;width: 100%;">
  <h4 class="text-center"><?php echo $video->title ; ?></h4>
  <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo ($video->description) ; ?></p>
  <h2 ><p style ="margin-left:14%">Sorry, this video is only available to</p> <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
    <?php if(!Auth::guest() && $video->access == 'subscriber' || !Auth::guest() && $video->access == 'ppv'|| !Auth::guest() && $video->access == 'guest' && !empty($video->ppv_price) ){ ?>
    <form method="get" action="<?= route('payment_becomeSubscriber')  ?>">
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
<div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">

 <div id="subscribers_only">
 <h4 class="text-center"><?php echo $video->title ; ?></h4>
  <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo ($video->description) ; ?></p>
 <h2 style ="margin-left:14%">Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
 <div class="clear"></div>
 <?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
   <form method="get" action="<?= route('payment_becomeSubscriber')  ?>">
     <button style="margin-left: 27%;" id="button">Become a subscriber to watch this video</button>
   </form>
 <?php else: ?>
   <form method="get" action="<?= URL::to('signup') ?>">
     <button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
   </form>
 <?php endif; ?>
</div>
<?php }
}elseif(!empty($new_date)){ ?>
  <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
      <h2> COMING SOON </h2>
      <p class="countdown" id="demo"></p>
      </div>
     <?php } ?> 
<!-- For Guest users -->      
 <?php if(Auth::guest()) {  ?>
   <div id="video" class="fitvid" style="margin: 0 auto;">
       
       <video id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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

        
          <video id="videoPlayer"  class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
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
        
        <?php  elseif($video->type == 'aws_m3u8'):  ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">

          <video  autoplay id="video"  allow="autoplay" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo $video->m3u8_url; ?>"  type='application/x-mpegURL' label='auto' > 
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

        <?php  elseif($video->type == 'mp4_url'):   ?>
        
          
              <div id="video_container" class="fitvid" atyle="z-index: 9999;">
            <!-- Current time: <div id="current_time"></div> -->
            <video id="videoPlayer"  class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
        <?php  elseif($video->type == 'm3u8_url'):  ?>
        
        <video  id="video" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
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
            <video  id="videoPlayer" class="adstime_url" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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
    <h4 class="text-center"><?php echo $video->title ; ?></h4>
  <p class="text-center text-white col-lg-8" style="margin:0 auto";><?php echo ($video->description) ; ?></p>
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

                      <video  id="videos" class=""  poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                          controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                          type="application/x-mpegURL">
                          <source  type="application/x-mpegURL"   src="<?php echo $video->trailer;?>"  >
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

<?php if(!empty($video->url_link) ) { ?>
<div class="text-white" id="url_linkdetails" >
    <p class="trending-dec w-100 mb-0 text-white"><a href="<?php echo __($video->url_link); ?>" target="_blank" data-toggle="tooltip" data-placement="left" title=<?php echo __($video->url_link); ?> class="fa fa-info-circle" >
  </a></p>
</div>
<?php  }?>


 <input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">
   <div class="container-fluid video-details" >
       <div class="trending-info g-border p-0">
           <div class="row">
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
               <div class="col-md-12">
            <!-- <div id="video_containers plyr__video" class="fitvid mfp-hide" atyle="z-index: 9999;"> -->
            <!-- <div id="video-trailer" class="mfp-hide"> -->
             <!-- <video id="videoPlayer"  poster="<?php echo URL::to('/').'/public/uploads/images/' .$video->player_image;?>"  class="" controls src="<?= $video->trailer; ?>"  type="application/x-mpegURL" ></video>
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
               
           </div>
       </div>
       <!-- Year, Running time, Age --> 
         <div class="row align-items- text-white text-detail justify-content-between">
             <div class="col-sm-6 col-md-6 col-xs-12">
            <span class="badge badge-secondary p-3"><?php echo __($video->age_restrict).' '.'+';?></span>
            <span class="ml-3"><?php echo __(gmdate('H:i:s', $video->duration));?></span>
            <span class="trending-year">,<?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
            <span class="trending-year" style="display:none;"><?php
            foreach($category_name as $value){
              echo $value->categories_name. ',';  
            }
             ?></span>

             <!-- Trailer Description -->
              <?php if(!empty($video->trailer_description) ) { ?>
                <div class="col-sm-12 mt-4 p-0 trailer_description">
                  <h5>Trailer Description:</h5>
                      <div class="text-white">
                          <p class="trending-dec w-100 mb-0 text-white mt-3"><?php echo __($video->trailer_description); ?></p>
                      </div>
                  </div>
              <?php  }?>

              <div class="col-sm-4 p-0">
                    
                </div>

              <div class="col-sm-12 mt-4 p-0" style="margin-top: 2%;">
                 <?php if(!empty($video->description) ) { ?>

                    <h5>Description:</h5>
                    <div class="text-white">
                        <p class="trending-dec w-100 mb-0 text-white mt-3"><?php echo __($video->description); ?></p>
                    </div>
                    <?php  }?>
              </div>


              </div>

             <div class="col-sm-1 col-md-1 col-xs-12">
                 <div class="btn btn-default views text-white">
                           <!-- <span class="view-count"><i class="fa fa-eye"></i>  -->
                               <!-- <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?>  -->
                           </span>
                       </div>
             </div>
             <div class="col-sm-5 col-md-5 col-xs-12 text-right mt-4">
                 <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    <li><span class="watchlater <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($watchlatered->id)): ?> class="ri-add-circle-fill" <?php else: ?> class="ri-add-circle-line" <?php endif; ?>></i></span></li>
                     <!-- Wishlist 
                    <li><span class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line" <?php endif; ?> ></i></span></li>
                     <!-- Social Share, Like Dislike-->
                      <?php include('partials/social-share.php'); ?>   
                                           
                 </ul>
                 <div class="row justify-content-end">
           <div class="col-sm-8 col-md-8 col-xs-4 text-right p-0">
                   <div class=" d-flex justify-content-end">     
                       <?php if($video->trailer != '' && $ThumbnailSetting->trailer == 1 ){ ?>
                           <div id="videoplay" class="btn1 btn-secondary btn-lg btn-block watch_trailer" style="border-radius:none!important;"><i class="ri-film-line"></i> Watch Trailer</div>
                           <div id="close_trailer" class="btn1 btn-primary btn-lg btn-block  close_trailer"><i class="ri-film-line"></i> Close Trailer</div>
                           <div style=" display: none;" class="skiptrailer btn btn-default skip"> Skip</div>
                       <?php } ?>
                        <div id="videoplay" class="btn1 btn-secondary btn-lg btn-block watch_trailer mt-3 mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" style="border-radius:none!important;"><?php if(isset($mywishlisted->id)): ?> <i class="fa fa-minus-circle" aria-hidden="true"></i> Remove Whislist  <?php else: ?> + Add to Wishlist <?php endif; ?>
                        </div>

                        <?php
                           $user = Auth::user(); 

                         if ( $video->global_ppv != null && $user->role!="admin" || $video->ppv_price != null  && $user->role!="admin") { ?>
                              <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn-secondary btn-lg btn-block  mt-3 rent-video ">
                              <?php echo __('Rents');?> </button>
                            <?php } ?>

                   </div> 
               
               </div></div>
           </div>
         </div>
           
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

           
<!-- Intro Skip and Recap Skip -->

   

  <div class="col-sm-12 end_card_video" id="end_card_video" style="position: absolute; top: -244%; width: 500%; height: 500%;" >
  <?php foreach($endcardvideo as $val) { ?>
      <a href="<?php  echo URL::to('category') ?><?= '/videos/' . $val->slug ?>">
   <img id="endcard" src="<?php echo URL::to('/').'/public/uploads/images/' .$val->image ;?>" alt="">
      </a>
      <?php  } ?>
  </div>

      <style>
        #endcard{
          width: 20%;
          height: 20%;
        }
      </style>

  <div class="col-sm-12 Recap_skip">
      <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip" style="display:none;">
  </div>

<!--End Intro Skip and Recap Skip 

<?php if(!empty($video->description) ) { ?>

<h4>Description</h4>
<div class="text-white">
    <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
</div>
<?php  }?>
<br>-->

<?php if(!empty($video->details) ) { ?>
<div class="col-sm-6 p-0">
<h4>Links & details</h4>
<div class="text-white ">
    <p class="trending-dec  mb-0 text-white"><?php echo __($video->details); ?></p>
</div></div>
<?php  }?>


<?php if(!empty($video->pdf_files) ) { ?>
<h4>E-Paper</h4>
<p class="p1">Download the E-Paper</p> 
<div class="text-white">
    <a  href="<?php echo __(URL::to('/') . '/public/uploads/videoPdf/' . $video->pdf_files); ?>" style="font-size:48px; color: #a51212 !important;" class="fa fa-file-pdf-o video_pdf" width="" height="" download></a>
</div>
<?php  }?>
<br>


           <?php if(Auth::guest()){
$artists = [];
}else{

}
 if(count($artists) > 0 ) { ?>
 <h4>Cast & crew</h4>

            <div class="row">
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0 m-3">
                       <?php foreach($artists as $key => $artist){  ?>
                          <li class="slide-item ">
                            <a  href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_slug); ?>"  >
                                <div class="block-images position-relative">
                                    <!-- block-images -->
                                    <div class="img-box">
                                        <img src="<?= URL::to('/') . '/public/uploads/artists/'.$artist->image ?>" alt="" width="100">
                                    
                                        <div class="p-tag2">
                                              <p class="trending-dec w-100 mb-0 text-white mt-2" ><?php echo $artist->artist_name ; ?> </p>
                                        </div>
                                    </div>
                                  
                                    <div class="">
                                      <a  href="<?php echo __(URL::to('/') . '/artist/' . $artist->artist_slug); ?>"  ></a>   
                                    </div>
                                </div>
                              </a>
                          </li>
                         <?php } }  ?>
                    </ul>
                 </div>
              </div>
           
       <!-- <div class="text-white">
           <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
       </div> -->
  <!-- Button trigger modal -->

   <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="">Rent Now</h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>

          <div class="modal-body">
              <div class="row justify-content-between">
                  <div class="col-sm-4 p-0" style="">
                      <img class="img__img w-100" src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid" alt="" >
                  </div>
                  
                    <div class="col-sm-8">
                    <h4 class=" text-black movie mb-3"><?php echo __($video->title);?> ,   <span class="trending-year mt-2"><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span></h4>
                    <span class="badge badge-secondary   mb-2"><?php echo __($video->age_restrict).' '.'+';?></span>
                    <span class="badge badge-secondary  mb-2"><?php echo __(isset($video->categories->name));?></span>
                    <span class="badge badge-secondary  mb-2"><?php echo __(isset($video->languages->name));?></span>
                    <span class="badge badge-secondary  mb-2 ml-1"><?php echo __($video->duration);?></span><br>
                
                    <a type="button" class="mb-3 mt-3"  data-dismiss="modal" style="font-weight:400;">Amount:   <span class="pl-2" style="font-size:20px;font-weight:700;"> <?php echo __($currency->symbol.' '.$video->ppv_price);?></span></a><br>
                    <label class="mb-0 mt-3 p-0" for="method"><h5 style="font-size:20px;line-height: 23px;" class="font-weight-bold text-black mb-2">Payment Method : </h5></label>
                  
                  <?php $payment_type = App\PaymentSetting::get(); ?>

                                <!-- RENT PAYMENT Stripe,Paypal,Paystack,Razorpay -->
                  
                      <?php  foreach($payment_type as $payment){

                          if( $payment->payment_type == "Razorpay"  || $payment->stripe_status == 1 || $payment->paypal_status == 1 || $payment->payment_type == "Paystack" ){ 

                              if($payment->live_mode == 1 && $payment->stripe_status == 1){ ?>  <!-- Stripe -Live Mode -->

                                  <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="tres_important" checked name="payment_method" value= <?= $payment->payment_type ?>  data-value="stripe">
                                    <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                                  </label> <?php }

                              elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>  <!-- Stripe - Test Mode -->

                                  <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="tres_important" checked name="payment_method" value="<?= $payment->payment_type ?>"  data-value="stripe" >  <!--<img class="" height="20" width="40" src="<?php echo  URL::to('/assets/img/stripe.png')?>" style="margin-top:-5px" >-->
                                    <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                                  </label>  <?php }
                  
                              elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?> <!-- paypal - Live Mode -->

                                <label class="radio-inline mb-0 mt-3 d-flex align-items-center" >
                                  <input type="radio" class="payment_btn"  id="important" name="payment_method" value="<?= $payment->payment_type ?>"  data-value="paypal" >
                                    <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                                </label> <?php }

                              elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?> <!-- paypal - Test Mode -->

                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                  <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?= $payment->payment_type ?>"  data-value="paypal" >
                                  <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                                </label> <?php  }
                            
                              if( $payment->payment_type == "Razorpay"  ){ ?> <!-- Razorpay -->

                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?= $payment->payment_type ?>"  data-value="Razorpay" >
                                    <?php  echo $payment->payment_type ;  ?>
                                </label>  <?php }
                                                                              // <!-- Paystack -->
                              if ( $Paystack_payment_settings != null && $Paystack_payment_settings->payment_type == 'Paystack'  && $Paystack_payment_settings->status == 1 ){  ?>

                                  <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                    <input type="radio" class="payment_btn" id="" name="payment_method" value="<?= $Paystack_payment_settings->payment_type ?>"  data-value="Paystack" >
                                    <?php  echo $Paystack_payment_settings->payment_type ;  ?>
                                  </label>
                                <?php } }
                          else{
                                echo "<small>Please Turn on Payment Mode to Purchase</small>";
                                break;
                          }
                      }?>
                    </div>
                </div>                    
            </div>

            <div class="modal-footer">
              <div class="Stripe_button">  <!-- Stripe Button -->
                <a onclick="pay(<?php echo $video->ppv_price;?>)">
                  <button type="button" class="btn2  btn-outline-primary" >Continue</button>
                </a>
              </div>
                        
              <?php if( $video->ppv_price !=null &&  $video->ppv_price != " "  ){ ?>
                <div class="Razorpay_button">   <!-- Razorpay Button -->
                  <button onclick="location.href ='<?= URL::to('RazorpayVideoRent/'.$video->id.'/'.$video->ppv_price) ?>' ;" id="" class="btn2  btn-outline-primary" > Continue</button>
                </div>
              <?php }?>

                
              <?php if( $video->ppv_price !=null &&  $video->ppv_price != " "  ){ ?>
                <div class="paystack_button">  <!-- Paystack Button -->
                  <button onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => $video->id , 'amount' => $video->ppv_price] ) ?>' ;" id="" class="btn2  btn-outline-primary" > Continue</button>
                </div>
              <?php }?>

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
       

<?php if(count($Reels_videos) > 0 && $ThumbnailSetting->reels_videos == 1){ ?>
    <div class="video-list you-may-like">
           <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
               <?php include('partials/home/Reels-video.php');?>
           </div>
   </div>
<?php } ?>

        <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('videos')->first() == 1 ): ?>
            <div class="row">
                <div class=" container-fluid video-list you-may-like overflow-hidden">
                    <h4 class="" style="color:#fffff;"><?php echo __('Comments');?></h4>
                    <?php include('comments/index.blade.php');?>
                </div>
            </div>
        <?php endif; ?>

   <div class="container-fluid video-list you-may-like overflow-hidden">
       <h4 class="Continue Watching" style="color:#fffff;"><?php echo __('Recomended Videos');?></h4>
           <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
               <?php include('partials/video-loop.php');?>
           </div>
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
           
          $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
       });
   
    $(document).ready(function(){

      var vid = document.getElementById("videoPlayer");
      var url= '<?= URL::to("purchase-videocount") ?>';
      var _token= '<?=  csrf_token() ?>';
      var videoid = $('#video_id').val();

       $(vid).click(function(){
        // alert(url);
        $.post('<?= URL::to('purchase-videocount') ?>', { video_id : videoid,_token: '<?= csrf_token(); ?>' },
         function(data){
                     //    toastr.success(data.success);
                   });

       })

    });
           /*Watch trailer*/
          //  $(".watch_trailer").click(function() {
          //    var videohtml = '<video id="videoPlayer" controls autoplay><source src="<?php echo $video->trailer;?>"></video>';
          //    $("#video_container").empty();
          //    $(".skip").css('display','inline-block');
          //    $("#video_container").html(videohtml);
          //  });
          var vid = document.getElementById("videoPlayer"); 
          $('#watch_trailer').hide();
          $('#close_trailer').hide();
          $('.trailer_description').hide();

          // Play Trailer
          $('#videoplay').click(function(){
            // alert('test');
            $('#video_container').hide();
            const player = new Plyr('.videoPlayers');
            $('#watch_trailer').show();
            $('#videoplay').hide();
            $('#close_trailer').show();
            $('.trailer_description').show();

          });
          // Close Trailer
          $('#close_trailer').click(function(){
            // alert('test');
            $('#watch_trailer').hide();
            const player = new Plyr('.videoPlayers');
            $('#video_container').show();
            $('#videoplay').show();            
            $('#close_trailer').hide();
            $('.trailer_description').hide();

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
              $(this).html('<i class="fa fa-minus-circle" aria-hidden="true" ></i> Remove wishlist');
            
              $(".add_data_test").empty();
              $(".add_data_test").append("<div>Remove from Wishlist</div> ");
               $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
             }else{
              $(this).html('+ Add to Whislist');
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
    $ContinueWatching = App\ContinueWatching::where('user_id', '=', Auth::User()->id)->where('videoid', '=', $video->id)->orderby('created_at', 'desc')->first();
      if(!empty($ContinueWatching)){
        $Currenttime = ($ContinueWatching['currentTime']);
      }else{
        $Currenttime =  0 ;
      }

?>

<script>


  // Continue Watching Video start's at watched time

  var video_type_Ids = <?php echo json_encode($video_type_id); ?>;
  var Currenttime = <?php echo json_encode($Currenttime); ?>;
  var video = document.getElementById(video_type_Ids);
  if(Currenttime > 0){
    var watch_percentage = Currenttime ;
    this.video.currentTime = Currenttime;
    this.video.play();
  }
// Continue Watching End



            // Strat video end card
var videotype_Ids = <?php echo json_encode($video_type_id); ?>;
// alert(videotype_Ids);
  var video = document.getElementById(videotype_Ids);
// alert(video);
  this.video.addEventListener('timeupdate', (e) => {
    var duration = video.duration;
    var endtime = duration - 5;
    // alert(duration);
  document.getElementById("end_card_video").style.display = "none";
    if (e.target.currentTime >= endtime) {
            // document.getElementById("end_card_video").style.display = "block"; // Manual show
  document.getElementById("end_card_video").style.display = "none";
    } 
      
});
        // End video end card
        

  var SkipIntroPermissions = <?php echo json_encode($SkipIntroPermission); ?>;
  var videotype_Id = <?php echo json_encode($video_type_id); ?>;
  var video = document.getElementById(videotype_Id);
  var button = document.getElementById("intro_skip");
  var Start = <?php echo json_encode($startSec); ?>;
  var End = <?php echo json_encode($EndSec); ?>;
  var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;
  var IntroskipEnd = <?php echo json_encode($skipIntroTime); ?>;




if( SkipIntroPermissions == 1 ){
  button.addEventListener("click", function(e) {
    video.currentTime = IntroskipEnd;
       $("#intro_skip").remove();  // Button Shows only one tym
    video.play();
  })
    if(AutoSkip != 1){
          this.video.addEventListener('timeupdate', (e) => {
            document.getElementById("intro_skip").style.display = "none";
            document.getElementById("Auto_skip").style.display = "none";
            var RemoveSkipbutton = End + 1;

            if (Start <= e.target.currentTime && e.target.currentTime < End) {
                    document.getElementById("intro_skip").style.display = "block"; // Manual skip
            } 
            if(RemoveSkipbutton  <= e.target.currentTime){
                  $("#intro_skip").remove();   // Button Shows only one tym
            }
        });
    }
    else{
      this.video.addEventListener('timeupdate', (e) => {
            document.getElementById("Auto_skip").style.display = "none";
            document.getElementById("intro_skip").style.display = "none";

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
}
</script>

<!-- Recap video skip -->

<?php
    $Recap_skip = App\Video::where('id',$video->id)->first();
    $RecapStart_time = $Recap_skip->recap_start_time;
    $RecapEnd_time = $Recap_skip->recap_end_time;

    $RecapStartParse = date_parse($RecapStart_time);
    $RecapstartSec = $RecapStartParse['hour']  * 60 *  60  + $RecapStartParse['minute']  * 60  + $RecapStartParse['second'];
    
    $SkipRecapParse = date_parse($Recap_skip['skip_recap']);
    $skipRecapTime =  $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];

    $RecapEndParse = date_parse($RecapEnd_time);
    $RecapEndSec = $RecapEndParse['hour'] * 60 * 60 + $RecapEndParse['minute'] * 60 + $RecapEndParse['second'];
?>

<script>
  var videotypeId = <?php echo json_encode($video_type_id); ?>;
  var videoId = document.getElementById(videotypeId);
  var button = document.getElementById("Recaps_Skip");
  var RecapStart = <?php echo json_encode($RecapstartSec); ?>;
  var RecapEnd = <?php echo json_encode($RecapEndSec); ?>;
  var RecapskipEnd = <?php echo json_encode($skipRecapTime); ?>;
  var RecapValue  = $("#Recaps_Skip").val();

  button.addEventListener("click", function(e) {
    videoId.currentTime = RecapskipEnd;
    $("#Recaps_Skip").remove();   // Button Shows only one tym
    videoId.play();
  })
      this.videoId.addEventListener('timeupdate', (e) => {
        document.getElementById("Recaps_Skip").style.display = "none";

        var RemoveRecapsbutton = RecapEnd + 1;
              if (RecapStart <= e.target.currentTime && e.target.currentTime < RecapEnd) {
                  document.getElementById("Recaps_Skip").style.display = "block"; 
              }
               
              if(RemoveRecapsbutton  <= e.target.currentTime){
                  $("#Recaps_Skip").remove();   // Button Shows only one tym
              }
    });
</script>

<!-- Link on Player -->

<script>
    document.getElementById("url_linkdetails").style.display = "none"; 
    var video_player  =  document.getElementById(videotypeId);
    var start_urltime =  <?php echo json_encode($video->url_linksec); ?>;
    var End_urltime   =  <?php echo json_encode($video->urlEnd_linksec); ?>;

      this.video_player.addEventListener('timeupdate', (e) => {
        document.getElementById("url_linkdetails").style.display = "none"; 
        
        if (start_urltime <= e.target.currentTime && e.target.currentTime < End_urltime) {
                document.getElementById("url_linkdetails").style.display = "block"; 
          } 
        });
// Tool Tip
    $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
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

<!-- Ads -->

<?php 

  if(  plans_ads_enable() == 1 ){

    include('AdsvideoPre.php'); 
    include('AdsvideoPost.php');
    include('AdsvideoMid.php');
    
  }
  
?>

<!-- End Ads -->

<script>


$(window).on("beforeunload", function() { 

var videotype= '<?= $video->type ?>';

var vid = document.getElementById("videoPlayer");

 var currentTime = vid.currentTime;
 var duration = vid.duration;
var bufferedTimeRanges = vid.buffered;
var bufferedTimeRangesLength = bufferedTimeRanges.length;
var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
 var videotype= '<?= $video->type ?>';
 var videoid = $('#video_id').val();
 $.post('<?= URL::to('player_analytics_create') ?>', { video_id : videoid,duration : duration,currentTime:currentTime,seekableEnd : seekableEnd,bufferedTimeRanges : bufferedTimeRangesLength,_token: '<?= csrf_token(); ?>' }, function(data){
});
return;
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
            height: 100px;
            width: 10%;
            background: url(<?php echo URL::to($logo_url) ; ?>) no-repeat;
            background-size: 100px auto, auto;
            }
        </style>
<?php } ?>

   </div>
      
<script>
// Set the date we're counting down to
var date = "<?= $new_date ?>";
var countDownDate = new Date(date).getTime();
// alert(date)
// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    // document.getElementById("demo").innerHTML = "EXPIRED";
location.reload();
  }
}, 1000);
</script>


<script>
  window.onload = function(){ 
       $('.Razorpay_button,.paystack_button').hide();
    }

     $(document).ready(function(){

      $(".payment_btn").click(function(){

        $('.Razorpay_button,.Stripe_button,.paystack_button').hide();

        let payment_gateway =  $('input[name="payment_method"]:checked').val();

            if( payment_gateway  == "Stripe" ){

                $('.Stripe_button').show();
                $('.Razorpay_button,.paystack_button').hide();

            }else if( payment_gateway == "Razorpay" ){

                $('.paystack_button,.Stripe_button').hide();
                $('.Razorpay_button').show();

            }else if( payment_gateway == "Paystack" ){

                $('.Stripe_button,.Razorpay_button').hide();
                $('.paystack_button').show();
            }
      });
    });
</script>

<?php     include(public_path('themes/theme2/views/footer.blade.php')); ?>

<!-- Trailer m3u8 -->

<script>

  var trailer_video_m3u8 = <?php echo json_encode($video->trailer) ; ?> ;
  var trailer_video_type =  <?php echo json_encode($video->trailer_type) ; ?> ;

  if(trailer_video_type == "m3u8_url"){
    (function () {
      var video = document.querySelector('.videoPlayers');

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

      // From the m3u8 playlist, hls parses the manifest and returns
                  // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
                hlstwo.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hlstwo.levels.map((l) => l.height)
            availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
          defaultOptions.quality = {
            default: 0, //Default - AUTO
              options: availableQualities,
              forced: true,        
              onChange: (e) => updateQuality(e),
          }
          // Add Auto Label 
          defaultOptions.i18n = {
            qualityLabel: {
              0: 'Auto',
            },
          }

          hlstwo.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
              var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
              if (hlstwo.autoLevelEnabled) {
                span.innerHTML = `AUTO (${hlstwo.levels[data.level].height}p)`
              } else {
                span.innerHTML = `AUTO`
              }
            })
      
              // Initialize new Plyr player with quality options
          var player = new Plyr(videos, defaultOptions);
          });	

          hlstwo.attachMedia(videos);
        window.hlstwo = hlstwo;		 
      }

      function updateQuality(newQuality) {
        if (newQuality === 0) {
          window.hlstwo.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
          window.hlstwo.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
              console.log("Found quality match with " + newQuality);
              window.hlstwo.currentLevel = levelIndex;
            }
          });
        }
      }
});

  }

</script>


