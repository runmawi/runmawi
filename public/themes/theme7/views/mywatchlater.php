 <?php include('header.php');?>

  
<!-- MainContent -->
 <div class="main-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="Continue Watching">Media in My Watchlater</h2>
                </div>
            </div>
        </div>

        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php  if(isset($channelwatchlater)) :
                        foreach($channelwatchlater as $channelwatchlater_videos):  ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('home') ?>">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$channelwatchlater_videos->image;  ?>" class="img-fluid loading" alt=""> 
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; endif; ?>

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
                                </div>
                            </a>
                        </li>
                    <?php endforeach; endif; ?>
            </ul>
        </div>

    </div>
 </div>

 <!-- watchlater -->
 <script>
$('.watchlater').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/addwatchlater');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Watchlater"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Watchlater');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to Watchlater</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Watchlater');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from Watchlater</div>');
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