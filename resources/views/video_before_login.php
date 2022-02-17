<?php include('videolayout/header.php');?>
 
<?php include('header.php');?>

 <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo  $playerui_settings->watermark_logo ;?>">

   <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
   <input type="hidden" id="videoslug" value="<?php if(isset($video->slug)) { echo $video->slug; } else{ echo "0";}?>">
   <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
   <input type="hidden" id="adsurl" value="<?php if(isset($ads->ads_id)){echo get_adurl($ads->ads_id);}?>">
   
<?php

    // print_r(URL::to('/storage/app/public/').'/'.'xCuTlBRxoqAKcINB');
    // exit();
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

            <div id="video sda" class="fitvid" style="margin: 0 auto;">


              <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
            
            <source src="<?= $video->trailer; ?>" type='video/mp4' label='Auto' res='auto' />



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
          <?php  else: ?>
            <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                <!-- Current time: <div id="current_time"></div> -->
                <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
            <source src="<?= $video->trailer; ?>" type='video/mp4' label='Auto' res='auto' />
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
  

  <?php }
/* For Registered User */       
    else { ?>       
        <div id="video" class="fitvid" style="margin: 0 auto;">
        
        <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
            
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
  <?php } } ?>
<!-- For Guest users -->      
  <?php if(Auth::guest()) {  ?>
    <div id="video" class="fitvid" style="margin: 0 auto;">
        
        <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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
                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right">     
                        <?php if($video->trailer != ''){ ?>
                            <div class="watchlater btn btn-default watch_trailer"><i class="ri-film-line"></i>Watch Trailer</div>
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
            <?php   }?>
        
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
           <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
               <?php include('partials/home/Reels-video.blade.php');?>
           </div>
   </div>
        
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
    
  </div>

<?php include('footer.blade.php');?>

<?php include('videolayout/footer.php');?>