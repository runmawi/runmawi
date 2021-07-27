<?php include('videolayout/header.php');?>
 
 
<?php include('header.php');?>

 <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo URL::to('/') . '/public/uploads/settings/' . $playerui_settings['watermark'] ;?>">

   <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
   
<?php
    // print_r($watched_time);
   if(!Auth::guest()) {  
   if ( $ppv_exist > 0  || Auth::user()->subscribed() || Auth::user()->role == 'admin' || Auth::user()->role =="subscriber" || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered')) { ?>

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
              <?= $video->embed_code ?>
            </div>
          <?php  elseif($video->type == 'file'): ?>
            <div id="video_container" class="fitvid" style="margin: 0 auto;">
            <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer" controls autoplay style="height: 550px;width:1000px;">
           <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->mp4_url; ?>" type='video/mp4' label='auto' >
              <!-- <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->webm_url; ?>" type='video/webm' label='auto' >
              <source src="<?php echo URL::to('/storage/app/public/').'/'.$video->ogg_url; ?>" type='video/ogg' label='auto' > -->
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
 <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
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
            <div id="video_container" class="fitvid" style="z-index: 9999;margin:0 auto;">
<!-- Current time: <div id="current_time"></div> -->
<video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer"  controls autoplay  style="height: 550px;width:1000px;">
<source src="<?php echo URL::to('/storage/app/public/').'/'.$video->mp4_url; ?>" type='video/mp4' label='auto' >
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
  </div>

  <?php }  
    else { ?>       
    <div id="video_container" class="fitvid" style="margin: 0 auto;">

    <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer"  controls autoplay  style="height: 550px;width:1000px;">
    <source src="<?= $video->trailer; ?>" type='video/mp4' label='auto' >
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
       
      </div>
  <?php } } ?>
  <?php if(Auth::guest()) {  ?>
    <div id="video_container" class="fitvid" style="margin: 0 auto;">
    <video class="video-js vjs-big-play-centered" data-setup='{"seek_param": "time"}' id="videoPlayer"  controls autoplay style="height: 550px;width:1000px;">

    <source src="<?= $video->trailer; ?>" type='video/mp4' label='auto' >
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
        </div>
  <?php }  ?>
            

  <input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">
    <div class="container-fluid video-details">
      <div id="video_title">
        <h1><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
      </div>
        
   <?php if(!Auth::guest()) { ?>

    <div class="row">
      <div class="col-sm-6 col-md-6 col-xs-12 d-flex justify-content-around">     
      <!-- Watch Later -->
                <div>
      <div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div></div>
<div>
      <!-- Wish List -->            
      <div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>
</div>
      <!-- Share -->
      <div class="social_share p-1 d-flex justify-content-around align-items-center">
        <p><i class="fa fa-share-alt"></i> <?php echo __('Share');?>: </p>
        <div id="social_share">
        <?php include('partials/social-share.php'); ?>
        </div>
      </div>
        </div>
      <div class="col-sm-6 col-md-6 col-xs-12">
      <!-- Views -->
       <div class="btn btn-default views">
        <span class="view-count"><i class="fa fa-eye"></i> 
        <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> </span>
      </div> 
                <?php     
                    $user = Auth::user(); 
                    if (  ($user->role!="subscriber" && $user->role!="admin") ) { ?>
                        <div class="views" style="margin: 0 12px;">
                            <a href="<?php echo URL::to('/becomesubscriber');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                         </div>
                    <?php } ?>
                
                <?php if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin")  ) { ?>
                
                    <div class="views" style="margin: 0 12px;"> 
                      
                    <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                     <?php echo __('Rent');?> </button>
                   </div> 
<!--                  <div id="paypal-button"></div>-->
                <?php } ?>
                
              
    </div> 
       </div>
        <?php   }?> 
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
        
   <?php if(Auth::guest()) { ?>
  
    <div class="row">
      <div class="col-sm-8 col-md-8 col-xs-12">     
      <!-- Watch Later -->
      <div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>

      <!-- Wish List -->            
      <div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>

      <!-- Share -->
<!--      <div class="social_share">
        <p><i class="fa fa-share-alt"></i> <?/*php echo __('Share')*/;?>: </p>
        <div id="social_share">
        <?php /* include("partials/social-share.php");*/ ?>
        </div>
      </div>-->
        </div>
      <div class="col-sm-4 col-md-4 col-xs-12">
      <!-- Views -->
       <div class="btn btn-default views">
        <span class="view-count"><i class="fa fa-eye"></i> 
        <?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> </span>
      </div> 
                
                        <div class="btn views" style="margin: 0 12px; padding: 0;">
                            <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                         </div>
               
                    <div class="btn views" style="margin: 0 12px;padding: 0;">
                     <a class="view-count btn btn-primary rent-video" href="<?php echo URL::to('/login');?>">
                     <?php echo __('Rent');?> </a>
<!--                    <div id="paypal-button"></div>-->
                   </div> 
                
              
    </div> 
       </div>
        <?php   }?>
    <div class="row">
        <div class="vid-details col-sm-12 col-md-12 col-xs-12">
            <p class="cat-name">
                <span><?php echo __($video->title); ?></span> <span><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
            </p>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12 col-xs-12">
        <div class="video-details-container"><?php echo __($video->description); ?></div>
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

    <div class="clear"></div>
        <script>
            //$(".share a").hide();
            $(".share").on("mouseover", function() {
            $(".share a").show();
            }).on("mouseout", function() {
            $(".share a").hide();
            });
        </script>

    <!--<div class="clear"></div>

    <div id="comments">
      <div id="disqus_thread"></div>
    </div>-->
    
  </div>
  <?php 

// dd($this);

   ?>
    <noscript>Please enable JavaScript to view the comments</noscript> 


<?php include('footer.blade.php');?>

<?php include('videolayout/footer.php');?>