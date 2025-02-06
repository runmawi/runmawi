<?php if(count($ugc_videos) > 0): ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h5 class="main-title">Shorts & Minis</a></h5>
    <a class="see" href="<?php if ($order_settings_list[41]->header_name) { echo URL::to('/').'/'.$order_settings_list[41]->url ;} else { echo "" ; } ?>"> See All  </a>
</div>
<div class="favorites-contens">
    <div class="ugc-video home-sec list-inline row p-0 mb-0">
        <?php  if(isset($ugc_videos)) :
                    foreach($ugc_videos as $ugc_video): 
        ?>
        <div class="items">
            <a href="<?php echo URL::to('home') ?>" aria-label="videos">
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a  href="<?php echo URL::to('ugc') . '/video-player/' . $ugc_video->slug ?>" aria-label="videos">
                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$ugc_video->image; ?>" class="img-fluid w-100 h-50" alt="<?php echo $ugc_video->title; ?>">
                        </a>
                    </div>
                </div>
                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="text-white btn-cl"  href="<?php echo URL::to('ugc') ?><?= '/video-player/' . $ugc_video->slug ?>"  aria-label="UGC-Videos"> 
                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" alt="play"/> 
                        </a>
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($ugc_video->title) > 17) ? substr($ugc_video->title,0,18).'...' : $ugc_video->title; ?></h6>
                    <?php } ?>
                </div>
                <div class="py-1">
                    <h6><?php  echo (strlen($ugc_video->user->username) > 17) ? substr($ugc_video->user->username,0,18).'...' : $ugc_video->user->username; ?></h6>
                </div>
                <div class="movie-time my-1">
                    <!-- Duration -->
                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $ugc_video->duration); ?>
                    </span>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>
<?php endif; ?>
<!-- Flickity Slider -->
<script>
var elem = document.querySelector('.ugc-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
});
 </script>