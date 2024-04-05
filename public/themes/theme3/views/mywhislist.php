<?php include('header.php'); ?>

<!-- MainContent -->
<div class="main-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="Continue Watching">Media in My Wishlist</h2>
                </div>
            </div>
        </div>

        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php  if(isset($channelwatchlater)) {
                        foreach($channelwatchlater as $channelwatchlater_videos){  ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                <div class="block-images position-relative">
                                        <div class="img-box">
                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$channelwatchlater_videos->image;  ?>" class="img-fluid loading" alt=""> 
                                            </a>
                                        </div>

                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a class="" href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                                    <div class="playbtn" style="gap:5px">  
                                                        <span class="text pr-2"> <?php echo (__('Play')) ?> </span>
                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                        </svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php } }elseif((count($channelwatchlater) == 0) || (count($episode_videos) == 0)) {  ;?>

                        <p><h2>No Media in My WishLists</h2></p>
                        <div class="col-md-12 text-center mt-4">
                            <img class="w-50" style="width: 50%!important;" src="<?php echo  URL::to('/assets/img/sub.png')?>">
                        </div>

                    <?php }?>

                    <!-- Episode -->

                    <?php  if(isset($episode_videos)) :
                        foreach($episode_videos as $episode_videos):  ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('home') ?>">

                                <?php 
                                    $series_slug = App\Series::where('id',$episode_videos->series_id)->pluck('slug')->first();
                                 ?>
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <a  href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>">
                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$episode_videos->image;  ?>" class="img-fluid loading" alt=""> 
                                        </a>
                                    </div>

                                    <div class="block-description">
                                        <div class="hover-buttons">
                                            <a class="" href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>">
                                                <div class="playbtn" style="gap:5px">  
                                                    <span class="text pr-2"> <?php echo (__('Play')) ?> </span>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; endif; ?>
            </ul>
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