<?php include('header.php');?>

 <!-- loader Start -->
 <!--<div id="loading">
    <div id="loading-center">
    </div>
 </div>-->
 <!-- loader END -->

 <!-- MainContent -->
 <div class="main-content" style="background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);
    padding: 15px 60px 40px;!important;">
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
                    </div>
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
                           
                            <div class="hover-buttons d-flex">
                                <a type="button" class="text-white"
                                href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                  <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>"> 
                                </a>
                                <div >
                                    <!--<a style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>">
                                        <i style="" <?php if(isset($video->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i>
                                    <div style="color:white;" id="<?= $video->id ?>">
                                        <?php if(@$video->mywishlisted->user_id == Auth::user()->id && @$video->mywishlisted->video_id == $video->id  ) { echo "Remove From Wishlist"; } 
                                        else { echo "Add To Wishlist" ; } ?>
                                    </div> 
                                    </a>-->
                                </div>
                            </div>
                        </div>
                       <div>
                            <h3><?php echo __($video->title); ?></h3>
                            <div class="movie-time d-flex align-items-center my-2">
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $video->duration); ?>
                                </span>
                            </div>
                       </div>
                    </div>
                </li>
                </a>
            </div>
    <?php endforeach; 
            else:
            ?>
            <h2>No Media in My WishLists</h2>
                <div class="col-md-12 text-center mt-4">
            <img class=""  src="<?php echo  URL::to('/assets/img/sub.png')?>" height="400" width="400">
                     <p class="text-white text-center">We are having a temporary playback issue,we are working on it and <br>will be back very soon!</p>
                     <a class="mb-5 text-white">Please refresh your page to retry</a>
        </div>
        <?php endif; ?>
         </div>
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