<?php include('header.php');?>

 <!-- loader Start -->
 <!--<div id="loading">
    <div id="loading-center">
    </div>
 </div>-->
 <!-- loader END -->

 <!-- MainContent -->
 <div class="main-content" style="background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%); padding: 15px 60px 40px;!important;">
     <div class="container-fluid">
          <div class="row">
     <div class="col-sm-12 overflow-hidden">
        <div class="iq-main-header d-flex align-items-center justify-content-between"> </div>
     </div>
     <section class="movie-detail ">
        <?php if((count($channelwatchlater) > 0) ): ?>
            <h4 class="main-title">My Videos</h4>       
        <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
             <?php if(count($channelwatchlater) > 0):
                   foreach($channelwatchlater as $video): ?>
            <div class="col-1-5 col-md-6 iq-mb-30 wishlist-block">
                <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                <li class="slide-item position-relative">
                <!-- block-images -->
                   <div class="block-images position-relative">
                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image; ?>"  data-play="hover" >
                            <source src="<?php echo $video->trailer;  ?>" type="video/mp4">
                        </video>
                    </div>

                        <div class="block-description">
                            <div class="hover-buttons d-flex">
                                <a type="button" class="text-white"
                                href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                  <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"> 
                                </a>
                                <div >
                                </div>
                            </div>
                        </div>
                       <div>
                           
                            <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                 <h6><?php  echo (strlen($video->title) > 15) ? substr($video->title,0,16).'...' : $video->title; ?></h6>
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                               
                            </div>
                            <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $video->duration); ?>
                                </span>
                       </div>
                </li>
                </a>
            </div>
                              <?php endforeach; 
            endif; ?>
            </ul>
         </div>

         <div class="favorites-contens">
              <h4 class="main-title">My UGC Videos</h4>    
                        <ul class="category-page list-inline  row p-0 mb-4">
                      
                        <?php if(count($user_generated_content) > 0):
                        
                   foreach($user_generated_content as $user_generated_video): ?>
            <div class="col-1-5 col-md-6 iq-mb-30 wishlist-block">
                <a href="<?php echo URL::to('ugc') ?><?= '/video-player/' . $user_generated_video->slug ?>">
                <li class="slide-item position-relative">
                <!-- block-images -->
                   <div class="block-images position-relative">
                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$user_generated_video->image; ?>"  data-play="hover" >
                        </video>
                    </div>

                        <div class="block-description">
                            <div class="hover-buttons d-flex">
                                <a type="button" class="text-white"
                                href="<?php echo URL::to('ugc') ?><?= '/video-player/' . $user_generated_video->slug ?>">
                                  <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"> 
                                </a>
                                <div >
                                </div>
                            </div>
                        </div>
                       <div>
                           
                            <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                 <h6><?php  echo (strlen($user_generated_video->title) > 15) ? substr($user_generated_video->title,0,16).'...' : $user_generated_video->title; ?></h6>                               
                            </div>
                            <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $user_generated_video->duration); ?>
                            </span>
                       </div>
                </li>
                </a>
            </div>
                              <?php endforeach; 
            endif; ?>
            </ul>
         </div>

         <?php if((count($episode_videos) > 0) ): ?>
            <h4 class="main-title">My Episodes</h4>       
        <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
             <?php if(count($episode_videos) > 0):
                   foreach($episode_videos as $video): ?>
                    <?php 
                $series_slug = App\Series::where('id',$video->series_id)->pluck('slug')->first();
                ?>
            <div class="col-1-5 col-md-6 iq-mb-30 wishlist-block">
                <a href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $video->slug ?>">
                <li class="slide-item position-relative">
                <!-- block-images -->
                   <div class="block-images position-relative">
                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image; ?>"  data-play="hover" >
                            <source src="<?php echo @$video->trailer;  ?>" type="video/mp4">
                        </video>
                    </div>

                        <div class="block-description">
                            <div class="hover-buttons d-flex">
                                <a type="button" class="text-white"
                                href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $video->slug ?>">
                                  <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"> 
                                </a>
                                <div >
                                </div>
                            </div>
                        </div>
                       <div>
                           
                            <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                 <h6><?php  echo (strlen($video->title) > 15) ? substr($video->title,0,16).'...' : $video->title; ?></h6>
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                               
                            </div>
                            <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $video->duration); ?>
                                </span>
                       </div>
                </li>
                </a>
            </div>
                              <?php endforeach; 
            endif; ?>
            </ul>
            <?php   endif; ?>

         </div>

        <!-- <h4 class="main-title">Live Videos</h4>-->
         <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
            <?php if(count($livevideos) < 0): ?>

            <?php
                   foreach($livevideos as $video): ?>
                             
            <div class="col-1-5 col-md-6 iq-mb-30 wishlist-block">
                <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                <li class="slide-item position-relative">
                <!-- block-images -->
                   <div class="block-images position-relative">
                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image; ?>"  data-play="hover" >
                            <source src="<?php echo $video->trailer;  ?>" type="video/mp4">
                        </video>
                    </div>

                        <div class="block-description">
                            <div class="hover-buttons d-flex">
                                <a type="button" class="text-white"
                                href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                                  <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"> 
                                </a>
                                <div >
                                </div>
                            </div>
                        </div>
                       <div>
                            
                            <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                <h6><?php  echo (strlen($video->title) > 15) ? substr($video->title,0,16).'...' : $video->title; ?></h6>
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                                
                            </div>
                           <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $video->duration); ?>
                                </span>
                       </div>
                </li>
                </a>
            </div>
                            <?php endforeach; 
                        endif; ?>
             </ul>
         </div>
                
         
         
            <?php else: ?>
           
                <div class="col-md-12 text-center mt-4" style="margin-left:30%;">
            <img class=""  src="<?php echo  URL::to('/assets/img/sub.png')?>" >
                      <p class="med">No Media in My WishLists</p>
                     <a class="mb-5 text-white pag">Please refresh your page to retry</a>
        </div>
        <?php endif; ?>
        
        
      </section>
         </div>
     </div>
 </div>
 <script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });
</script>

<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
$('.dropdown-menu a').click(function(e){
 e.preventDefault();
 if($(this).next('.submenu').length){
   $(this).next('.submenu').toggle();
 }
 $('.dropdown').on('hide.bs.dropdown', function () {
   $(this).find('.submenu').hide();
 }
                  )
}
                          );
}
</script>
   
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
if (window.pageYOffset > sticky) {
header.classList.add("sticky");
} else {
header.classList.remove("sticky");
}
}
</script>
<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

<script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
<script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>

<?php include('footer.blade.php');?>