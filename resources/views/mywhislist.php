<?php include('header.php');?>

 <!-- loader Start -->
 <!--<div id="loading">
    <div id="loading-center">
    </div>
 </div>-->
 <!-- loader END -->

 <!-- MainContent -->
 <div class="main-content">
     <div class="container-fluid">
          <div class="row">
     <div class="col-sm-12 overflow-hidden">
        <div class="iq-main-header d-flex align-items-center justify-content-between">
            <h4 class="Continue Watching">Media in My WishLists</h4>
        </div>
     </div>
     <section class="movie-detail ">
         <div class="row">
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
                   
<!--
                    <div class="corner-text-wrapper">
                        <div class="corner-text">
                            <p class="p-tag1">
                                <?php /*if(!empty($video->ppv_price)) {
                                    echo $video->ppv_price.' '.$currency->symbol ; 
                                    } elseif(!empty($video->global_ppv) && $video->ppv_price == null) {
                                    echo $video->global_ppv .' '.$currency->symbol;
                                    } elseif(empty($video->global_ppv) && $video->ppv_price == null) {
                                    echo "Free"; 
                                }*/
                                ?>
                            </p>
                        </div>
                    </div>
-->
                        <div class="block-description">
                            <h3><?php echo __($video->title); ?></h3>
                            <div class="movie-time d-flex align-items-center my-2">
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $video->duration); ?>
                                </span>
                            </div>
                            <div class="hover-buttons">
                                <a type="button" class="text-white"
                                href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                Watch Now
                                </a>
                                <div>
                                    <a style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>">
                                        <i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i>
                                    <div style="color:white;" id="<?= $video->id ?>">
                                        <?php if(@$video->mywishlisted->user_id == Auth::user()->id && @$video->mywishlisted->video_id == $video->id  ) { echo "Remove From Wishlist"; } 
                                        else { echo "Add To Wishlist" ; } ?>
                                    </div> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                </a>
            </div>
    <?php endforeach; 
        endif; ?>
         </div>
      </section>
         </div>
     </div>
 </div>

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