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

                                        <!-- PPV price -->
                                            <!-- <div class="corner-text-wrapper">
                                                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                                    <div class="corner-text">
                                                        <?php  if(!empty($channelwatchlater_videos->ppv_price)){?>
                                                            <p class="p-tag1"><?php echo $currency->symbol.' '.$channelwatchlater_videos->ppv_price; ?></p>
                                                        <?php }elseif( !empty($channelwatchlater_videos->global_ppv || !empty($channelwatchlater_videos->global_ppv) && $channelwatchlater_videos->ppv_price == null)){ ?>
                                                            <p class="p-tag1"><?php echo $channelwatchlater_videos->global_ppv.' '.$currency->symbol; ?></p>
                                                        <?php }elseif($channelwatchlater_videos->global_ppv == null && $channelwatchlater_videos->ppv_price == null ){ ?>
                                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div> -->
                                        </div>

                                        <div class="block-description">

                                            <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                                    <h6><?php  echo (strlen($channelwatchlater_videos->title) > 17) ? substr($channelwatchlater_videos->title,0,18).'...' : $channelwatchlater_videos->title; ?></h6>
                                                </a>
                                            <?php } ?>  

                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->age == 1) { ?>
                                                <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2"><?php echo $channelwatchlater_videos->age_restrict.' '.'+' ?></div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->duration == 1) { ?>
                                                <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $channelwatchlater_videos->duration); ?></span>
                                                <?php } ?>
                                            </div>
                                            
                                            
                                        
                                            <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?> <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($channelwatchlater_videos->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->published_year == 1) { ?>
                                                    <div class="badge badge-secondary p-1 mr-2">   <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($channelwatchlater_videos->year); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 &&  $channelwatchlater_videos->featured == 1) { ?>
                                                <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <!-- Category Thumbnail  setting -->
                                            <?php
                                            $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id',$channelwatchlater_videos->id)
                                                        ->pluck('video_categories.name');        
                                            ?>
                                            <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                            <span class="text-white">
                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                <?php
                                                    $Category_Thumbnail = array();
                                                        foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                        $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                        }
                                                    echo implode(','.' ', $Category_Thumbnail);
                                                ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                            
                                        <div class="hover-buttons">
                                            <a class="text-white d-flex align-items-center" href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>" >
                                                    <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                            </a>
                                            <div>
                                            <!-- <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $channelwatchlater_videos->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                        </div>
                                        </div>
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

                                        <div class="block-description">

                                            <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                <a  href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>">
                                                    <h6><?php  echo (strlen($episode_videos->title) > 17) ? substr($episode_videos->title,0,18).'...' : $episode_videos->title; ?></h6>
                                                </a>
                                            <?php } ?>  

                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->age == 1) { ?>
                                                <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2"><?php echo $episode_videos->age_restrict.' '.'+' ?></div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->duration == 1) { ?>
                                                <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $episode_videos->duration); ?></span>
                                                <?php } ?>
                                            </div>
                                            
                                            
                                        
                                            <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?> <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($episode_videos->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 &&  $episode_videos->featured == 1) { ?>
                                                <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                            <div class="hover-buttons">
                                                <a class="text-white d-flex align-items-center" href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>">
                                                    <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                                </a>
                                            <div>
                                        </div>
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