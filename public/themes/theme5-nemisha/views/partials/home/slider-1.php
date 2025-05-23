
<!-- Sliders -->
<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?php echo $slider_video->link; ?>';" class="slide slick-bg s-bg-1 lazy-bg" 
                    style="background: url('<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>') no-repeat;background-size:cover;background-position:right;cursor: pointer; ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <h2 class="text-white text-uppercase mb-3" style="color:#fff!important;">
                                    <?php  echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title; ?>
                                </h1>
                                <div class="mb-3" style="display: flex; gap: 5px;width:30px; height:15px;" >
                                    <?php $count = $slider_video->rating;
                                        for ($i = 0; $i < $count; $i++) { 
                                            echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                    } ?>
                                </div>
                                <div class="p-0">
                                    <a href="<?php echo $slider_video->link; ?>" class="btn bd "><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now</a>
                                    <a href="<?php echo $slider_video->link; ?>" class="btn bd ml-2"><i class="fa fa-play ml-2" aria-hidden="true"></i> Watch Trailer</a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-12 col-md-6 mt-5 pt-5 b2">
                                <div class="justify align-items-left r-mb-23 mt-5" data-animation-in="fadeInUp" data-delay-in="1.2">                               
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 text-center">
                                <!--<div class="">
                                    <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo w-100" alt="<?php echo $settings->website_name ; ?>"> </a>
                                    <h2 class="sp"></h2>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; 
endif; ?>

<!-- Live Banners -->
<?php if(isset($live_banner)) :
    foreach($live_banner as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>';" class="slide slick-bg s-bg-1 lazy-bg" 
                    style="background: url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:right;cursor: pointer;  ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <h2 class="slider-text big-title title text-uppercase text-white" data-animation-in="fadeInLeft" data-delay-in="0.6">
                                    <?php echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title; ?>
                                </h1>
                                <div class="mb-3" style="display: flex; gap: 5px;width:30px; height:15px;" >
                                    <!-- <img class="" src="<?php echo  URL::to('/assets/img/star.webp')?>" alt="Star-Image"/>  -->
                                    <?php 
                                        $count = $slider_video->rating;
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                        }
                                    ?>
                                </div>
                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="badge badge-secondary p-2">
                                        <?php echo __($slider_video->year); ?>
                                    </span>
                                </div>
                                <div style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <p><?php echo __($slider_video->description); ?></p>
                                </div>
                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    <a href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>" class="btn bd">
                                        <i class="fa fa-play mr-2" aria-hidden="true"></i> Play
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; 
endif; ?>

<!-- Video Sliders -->

<!-- Live Event Banners -->
<?php $live_event_banners = App\LiveEventArtist::where('active',1)->where('banner',1)->get() ?>

<?php if(isset($live_event_banners)) :
    foreach($live_event_banners as $key => $live_event_banner): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?= route('live_event_play',$live_event_banner->slug)  ?>';" class="slide slick-bg s-bg-1 lazy-bg" 
                style="background: url('<?php echo URL::to('/').'/public/uploads/images/' .$live_event_banner->player_image;?>') no-repeat;background-size:cover;background-position:right;cursor: pointer;   ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <h2 class="slider-text big-title title text-uppercase text-white" >
                                    <?php echo (strlen($live_event_banner->title) > 15) ? substr($live_event_banner->title,0,80).'...' : $live_event_banner->title; ?>
                                </h1>

                                <div class="mb-3" style="display: flex; gap: 5px;width:30px; height:15px;" >
                                    <!-- <img class="" src="<?php echo  URL::to('/assets/img/star.webp')?>" alt="Star-Image"/> -->
                                    <?php 
                                        $count = $live_event_banner->rating; 
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                        }
                                    ?>
                                </div>

                                <div class="d-flex align-items-center" >
                                    <span class="badge badge-secondary p-2">
                                        <?php echo __($live_event_banner->year); ?>
                                    </span>
                                </div>

                                <div 
                                    style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                    -webkit-line-clamp: 3; -webkit-box-orient: vertical;  overflow: hidden;">
                                    <p><?php echo __($live_event_banner->description); ?></p>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                                    data-delay-in="1.2">
                                    <a href="<?= route('live_event_play',$live_event_banner->slug)  ?>"
                                        class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
                                   <!-- <a class="btn bd ml-2" href="<?= route('live_event_play',$live_event_banner->slug)  ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; 
endif; ?>

<!-- Live Event Banners -->
<?php if(isset($video_banners)) :
    foreach($video_banners as $key => $videos): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>';" class="slide slick-bg s-bg-1 lazy-bg" 
                style="background: url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-position: right;cursor: pointer;">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner ">

                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">

                                                        <!--  Video thumbnail image-->
                                <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                                        <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                            <img src="<?= URL::to('public/uploads/images/'.$videos->video_title_image )?>" class="c-logo image" alt="<?= $videos->title ?>">
                                        </a>
                                                            <!-- Video Title  -->
                                <?php }else{ ?>
                                        <h2 class="text-white slider-text title text-uppercase mb-3" data-animation-in="fadeInLeft" data-delay-in="0.6" >
                                            <?php echo (strlen($videos->title) > 15) ? substr($videos->title,0,50).'...' : $videos->title; ?>
                                        </h2>
                                <?php } ?>

                                <div class="mb-3" style="display: flex; gap: 5px;width:30px; height:15px;" >
                                <!-- <img class="" src="<?php echo  URL::to('/assets/img/star.webp')?>" alt="Star-Image"/> -->
                                <?php 
                                    $count = $videos->rating;
                                    for ($i = 0; $i < $count; $i++) {
                                        echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                    }
                                ?>
                                </div>

                                
                                <?php if( $videos->year != null ):?>
                                    <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                        <span class="badge badge-secondary p-2">
                                            <?php echo __($videos->year); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            
                                <div style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                            -webkit-line-clamp: 3;  -webkit-box-orient: vertical; overflow: hidden;">
                                    <p><?php echo html_entity_decode($videos->description); ?></p>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                                        data-delay-in="1.2" >                                
                                    <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"
                                    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play </a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2"></div>
                            <div class="col-xl-4 col-lg-12 col-md-12 text-center">
                                <!--  <div class="">
                                    <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo w-100" alt="<?php echo $settings->website_name ; ?>"> </a>
                                    <h2 class="sp"></h2>
                                </div>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="video-trailer" class="mfp-hide">
                                <video id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>"  class="" controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" ></video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; 
endif; ?>


<!--VideoCategory  -->
<?php if(Route::current()->getName() == "home"){
    $parentCategories = App\VideoCategory::where('banner',1)->get();
    foreach($parentCategories as $category) {
                
        $videos_category = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
        ->where('category_id','=',$category->id)
        ->where('active', '=', '1')
        ->where('status', '=', '1')
        ->where('draft', '=', '1')
        ->where('videos.banner','=','0');

        if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
            $videos_category = $videos_category  ->whereNotIn('videos.id',Block_videos());
        }

        $videos_category = $videos_category->orderBy('videos.created_at','desc')->get();

        if(isset($videos_category)) :
            foreach($videos_category as $key => $videos): ?>

                <div class="item <?php if($key == 0){echo 'active';}?> header-image">
                    <div onclick="window.location.href='<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>';" class="slide slick-bg s-bg-1 lazy-bg"
                        style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-position:right; cursor: pointer;">
                        <div class="container-fluid position-relative h-100">
                            <div class="slider-inner h-100">
                                <div class="row align-items-center bl h-100">
                                    <div class="col-xl-5 col-lg-12 col-md-12">
                                    
                                        <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                                            <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                                <img src="<?= URL::to('public/uploads/images/'.$videos->video_title_image )?>" class="c-logo image" alt="<?= $videos->title ?>">
                                            </a>
                                                                        <!-- Video Title  -->
                                        <?php }else{ ?>
                                            <h2 class="slider-text text-white title text-uppercase mb-3" >
                                                <?php echo (strlen($videos->title) > 15) ? substr($videos->title,0,80).'...' : $videos->title; ?>
                                            </h1>
                                        <?php } ?>

                                        <div class="mb-3" style="display: flex; gap: 5px; width:30px; height:15px;" >
                                        <!-- <img class="" src="<?php echo  URL::to('/assets/img/star.webp')?>" alt="Star-Image"/> -->
                                        <?php 
                                                $count = $videos->rating;
                                                for ($i = 0; $i < $count; $i++) { 
                                                    echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                                }
                                            ?>
                                        </div>

                                        <div style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                                -webkit-line-clamp: 3;   -webkit-box-orient: vertical;  overflow: hidden;">
                                            <p> <?php echo __($videos->description); ?></p>
                                        </div>

                                        <div class="justify r-mb-23  p-0" data-animation-in="fadeInUp"  data-delay-in="1.2">
                                            <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"
                                                class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Start Watching</a>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2">  </div>
                                    <div class="col-xl-4 col-lg-12 col-md-12 text-center"> </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="video-trailer" class="mfp-hide">
                                        <video id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>"  class="" controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" ></video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach;  
        endif; ?>
    <?php } 
} ?>

<!-- Banners -->
<?php  if(isset($banner)) : 
    foreach($banner as $key => $slider_video): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?php echo URL::to('episode/'.@$slider_video->series_title->slug.'/'.$slider_video->slug ) ?>';" class="slide slick-bg s-bg-1 lazy-bg" 
                    style="background: url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:right; cursor: pointer; ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <!--<a href="javascript:void(0);">
                                    <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
                                        <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
                                    </div>
                                </a>-->
                                <h2 class="slider-text big-title title text-uppercase" >
                                    <?php echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title; ?>
                                </h1>
                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class=" p-2">
                                        <?php echo __($slider_video->age_restrict); ?>
                                    </span>
                                    <!-- <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
                                </div>
                                <br>
                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class=" p-2">
                                        <?php echo __($slider_video->year); ?>
                                    </span>
                                    <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
                                </div>
                                <div style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <p><?php echo __($slider_video->description); ?></p>
                                </div>
                                <div class="row justify r-mb-23  p-0 mb-4 text-center" data-animation-in="fadeInUp" data-delay-in="1.2"></div>
                            </div>                         
                            <div class="justify r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="<?php echo URL::to('episode/'.@$slider_video->series_title->slug.'/'.$slider_video->slug ) ?>" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Play
                                </a>
                                <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>
                                <a class="btn bd ml-3" href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; 
endif; ?>


<!-- Series silder -->
<?php if(isset($series_sliders)) :
    foreach($series_sliders as $key => $series_slider): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div onclick="window.location.href='<?php echo URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>';" class="slide slick-bg s-bg-1 lazy-bg"
                    style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$series_slider->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-position:right;cursor: pointer; ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <h2 class="slider-text text-white title text-uppercase mb-3" data-animation-in="fadeInLeft" data-delay-in="0.6">
                                    <?php echo (strlen($series_slider->title) > 15) ? substr($series_slider->title,0,80).'...' : $series_slider->title; ?>
                                </h1>

                                <div class="mb-3" style="display: flex; gap: 5px;width:30px; height:15px;" >
                                    <!-- <img class="" src="<?php echo  URL::to('/assets/img/star.webp')?>" alt="Star-Image"/> -->
                                    <?php 
                                        $count = $series_slider->rating;
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<img class="star_rating image" src="' . URL::to('/assets/img/star-svgrepo-com.webp') . '" alt="Star-Image"/>';
                                        }
                                    ?>
                                </div>

                                <?php if( $series_slider->year != null ):?>
                                    <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                        <span class="badge badge-secondary p-2">
                                            <?php echo __($series_slider->year); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                            -webkit-line-clamp: 3;  -webkit-box-orient: vertical; overflow: hidden;">
                                    <p><?php echo html_entity_decode($series_slider->details); ?></p>
                                </div>


                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                                        data-delay-in="1.2" >    
                                    <a href="<?php echo URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>" class="btn bd">
                                        <i class="fa fa-play mr-2" aria-hidden="true"></i> Start Watching
                                    </a>
                                </div>

                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2">  </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 text-center">   </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;  
endif; ?>


<!-- For Lazyloading the slider bg image -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-bg"));

        if ("IntersectionObserver" in window) {
            let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let bg = entry.target.style.backgroundImage;                        

                        if (!bg || bg === 'none') {
                            let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
                            
                            if (isSafari) {
                                bg = entry.target.style.backgroundImage;
                            } else {
                                try {
                                    bg = entry.target.currentStyle 
                                        ? entry.target.currentStyle.backgroundImage 
                                        : entry.target.style.backgroundImage;
                                } catch (e) {
                                    console.log("Could not get computed style in Safari: ", e);
                                }
                            }
                        }

                        if (bg && bg !== 'none') {
                            entry.target.style.backgroundImage = bg;
                        }

                        entry.target.classList.remove('lazy-bg');
                        lazyBackgroundObserver.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 1.0
            });

            lazyBackgrounds.forEach(function(lazyBackground) {
                lazyBackgroundObserver.observe(lazyBackground);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var images = document.querySelectorAll('.image');
        images.forEach(function(image) {
            console.log("img",image.complete);
            
            // Wait for the image to fully load before setting dimensions
            if (image.complete) {
                setImageDimensions(image);
            } else {
                image.addEventListener('load', function() {
                    setImageDimensions(image);
                });
            }
        });

        function setImageDimensions(image) {
            var renderedWidth = image.clientWidth;
            var renderedHeight = image.clientHeight;

            if (renderedWidth > 0 && renderedHeight > 0) {
                image.setAttribute('width', renderedWidth);
                image.setAttribute('height', renderedHeight);
            }
        }
    });

</script>
