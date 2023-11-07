<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>
<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/videocategory/' . $slider_video->slider; ?>" style="background-position: right;    ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="text-white">
                            <?php echo strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 80) . '...' : $slider_video->title; ?>
                        </h1>
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?php echo $slider_video->link; ?>" class="btn bd"><i class="fa fa-play mr-2"
                                    aria-hidden="true"></i> Play</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ?>
<?php endforeach; 
endif; ?>

<!-- Live Banners -->
<?php if(isset($live_banner)) :
    foreach($live_banner as $key => $slider_video): ?>

<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $slider_video->player_image; ?>" style="background-position: right;   ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">

                        <h1 class="text-white">
                            <?php echo strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 80) . '...' : $slider_video->title; ?>
                        </h1>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-secondary p-2">
                                <?php echo __($slider_video->year); ?>
                            </span>
                            <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
                        </div>
                        <div
                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                          -webkit-line-clamp: 3;
                          -webkit-box-orient: vertical;  
                          overflow: hidden;">
                            <?php echo __($slider_video->description); ?>
                        </div>
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?= URL::to('live/' . $slider_video->slug) ?>" class="btn bd"><i
                                    class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
                            <a class="btn bd ml-2" href="<?= URL::to('live/' . $slider_video->slug) ?>"><i
                                    class="fa fa-info" aria-hidden="true"></i> More details</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ?>
<?php endforeach; 
endif; ?>
<!-- Video Sliders -->


<!-- Live Event Banners -->

<?php $live_event_banners = App\LiveEventArtist::where('active', 1)
    ->where('banner', 1)
    ->get(); ?>
<?php if(isset($live_event_banners)) :

    foreach($live_event_banners as $key => $live_event_banner): ?>
<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $live_event_banner->player_image; ?>"
        style="background-position: right;   ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="text-white">
                            <?php echo strlen($live_event_banner->title) > 15 ? substr($live_event_banner->title, 0, 80) . '...' : $live_event_banner->title; ?>
                        </h1>

                        <div class="d-flex align-items-center">
                            <span class="badge badge-secondary p-2">
                                <?php echo __($live_event_banner->year); ?>
                            </span>
                        </div>

                        <div
                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                    -webkit-line-clamp: 3; -webkit-box-orient: vertical;  overflow: hidden;">
                            <?php echo __($live_event_banner->description); ?>
                        </div>

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?= route('live_event_play', $live_event_banner->slug) ?>" class="btn bd">
                                <i class="fa fa-play mr-2" aria-hidden="true"></i> Play
                            </a>
                            <a class="btn bd ml-2" href="<?= route('live_event_play', $live_event_banner->slug) ?>">
                                <i class="fa fa-info" aria-hidden="true"></i> More details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; endif; ?>
<!-- Live Event Banners -->

<?php if(isset($video_banners)) :
    foreach($video_banners as $key => $videos): ?>
<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide  slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $videos->player_image; ?>" style="background-position: right;">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12 bgc">

                        <!--  Video thumbnail image-->
                        <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                        <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>">
                            <img src="<?= URL::to('public/uploads/images/' . $videos->video_title_image) ?>"
                                class="c-logo" alt="<?= $videos->title ?>">
                        </a>
                        <!-- Video Title  -->
                        <?php }else{ ?>
                        <h1 class="text-white">
                            <?php echo strlen($videos->title) > 15 ? substr($videos->title, 0, 80) . '...' : $videos->title; ?>
                        </h1>
                        <?php } ?>

                        <p class="desc"
                            style="overflow: hidden !important;text-overflow: ellipsis !important; color:#fff;display: -webkit-box;
                                -webkit-line-clamp: 3;  -webkit-box-orient: vertical;     overflow: hidden;">
                            <?php echo __($videos->description); ?>
                        </p>

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>" class="btn bd">
                                <i class="fa fa-play mr-2" aria-hidden="true"></i> WATCH
                            </a>

                            <?php   include(public_path('themes/default/views/partials/home/Trailer-slider.php')); ?>       
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

<?php endforeach;endif; ?>

<!-- Catogery Slider -->
<?php

if(Route::current()->getName() == "home" || Route::current()->getName() == null  ){


            $parentCategories = App\VideoCategory::where('banner',1)->get();

                foreach($parentCategories as $category) {
                
                    $videos_category = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                    ->where('category_id','=',$category->id)
                    ->where('videos.active', '=', '1')
                    ->where('videos.status', '=', '1')
                    ->where('videos.draft', '=', '1')
                    ->where('videos.banner','=','0');

                    if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                        $videos_category = $videos_category  ->whereNotIn('videos.id',Block_videos());
                    }

                    $videos_category = $videos_category->orderBy('videos.created_at','desc')->get();
?>

<?php if(isset($videos_category)) :
        foreach($videos_category as $key => $videos): ?>
<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $videos->player_image; ?>"
        style="background-position: right;">

        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">

                        <!--  Video thumbnail image-->
                        <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                        <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>">
                            <img src="<?= URL::to('public/uploads/images/' . $videos->video_title_image) ?>"
                                class="c-logo" alt="<?= $videos->title ?>">
                        </a>
                        <!-- Video Title  -->
                        <?php }else{ ?>
                        <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in="0.6">
                            <?php echo strlen($videos->title) > 15 ? substr($videos->title, 0, 80) . '...' : $videos->title; ?>
                        </h1>
                        <?php } ?>

                        <p class="desc" data-animation-in="fadeInUp" data-delay-in="1.2"
                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;
                                        display: -webkit-box;   -webkit-line-clamp: 3; -webkit-box-orient: vertical;     overflow: hidden;">
                            <?php echo __($videos->description); ?>
                        </p>

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>"
                                class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> WATCH
                            </a>

                            <?php   include(public_path('themes/default/views/partials/home/Trailer-slider.php')); ?>       
                           
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php endforeach;endif; ?>

<?php } }?>


<!-- Tv show Banners -->
<?php
 if(isset($banner)) : 
    foreach($banner as $key => $slider_video): 
            ?>

<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $slider_video->player_image; ?>"
        style="background-position: right;  ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                            data-delay-in="0.6">
                            <?php
                            
                            echo strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 80) . '...' : $slider_video->title;
                            ?>
                        </h1>
                        <!--<div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                    <span class="badge badge-secondary p-2">
                            <?php echo __($slider_video->age_restrict); ?>
                        </span>
                        <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>
                    </div>
                    <br>
                    <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                        <!--<span class="badge badge-secondary p-2">
                            <?php echo __($slider_video->year); ?>
                        </span>
                        <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>
                    </div>-->
                        <div data-animation-in="fadeInUp" data-delay-in="1.2"
                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                      -webkit-line-clamp: 3;
                      -webkit-box-orient: vertical;  
                      overflow: hidden;">
                            <?php echo __($slider_video->description); ?>
                        </div>
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?php echo URL::to('episode'); ?><?= '/' . @$slider_video->series_title->slug . '/' . $slider_video->slug ?>"
                                class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>

                            <a class="btn bd ml-2"
                                href="<?php echo URL::to('episode'); ?><?= '/' . @$slider_video->series_title->slug . '/' . $slider_video->slug ?>"><i
                                    class="fa fa-info" aria-hidden="true"></i> More details</a>
                        </div>
                    </div>
                </div>
                <div class="trailor-video">
                    <a href="<?php echo URL::to('episode'); ?><?= '/' . @$slider_video->series_title->slug . '/' . $slider_video->slug ?>"
                        class="video-open playbtn">
                        <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                            height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                            xml:space="preserve">

                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8"
                                r="103.3" />
                        </svg>
                        <span class="w-trailor">Watch Trailer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ?>
<?php endforeach; 
                    endif; ?>

<!-- Series Slider -->


<?php if(isset($series_sliders)) :
    foreach($series_sliders as $key => $series_slider): ?>

<?php
$series_trailer = App\Series::Select('series.*', 'series_seasons.trailer', 'series_seasons.trailer_type')
    ->Join('series_seasons', 'series_seasons.series_id', '=', 'series.id')
    ->where('series.id', $series_slider->id)
    ->where('series_seasons.id', '=', $series_slider->season_trailer)
    ->where('series_trailer', '1')
    ->first();
?>

<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
   <div class="slide slick-bg s-bg-1 lazyload"
     data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $series_slider->player_image; ?>"
     style="background-position: right;"
     id="image-container" 
>
<div class="our-video" style="position: absolute; bottom: 0; left: 20%; left:34%; height: 100%;">
    <video class="myvideos" controls loop muted  src="http://vjs.zencdn.net/v/oceans.mp4" width="100%" height="100%" alt=""></video>
  </div>
  <script>
  $(document).ready(function() {
    const imageContainer = document.getElementById("image-container");
    const video = document.querySelector(".myvideos");

    imageContainer.addEventListener("mouseover", function(event) {
      video.play();
      video.style.opacity = 1;
    });

    imageContainer.addEventListener("mouseout", function(event) {
      video.pause();
      video.style.opacity = 0; // Set opacity to 0 when cursor is away
    });

  });
</script>


        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">

                        <h1 class="text-white ">
                            <?php echo strlen($series_slider->title) > 15 ? substr($series_slider->title, 0, 80) . '...' : $series_slider->title; ?>
                        </h1>

                        <div class="d-flex align-items-center">
                            <span class="badge badge-secondary p-2">
                                <?php echo __($series_slider->year); ?>
                            </span>
                        </div>

                        <div data-animation-in="fadeInUp"
                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3;
                                        -webkit-box-orient: vertical;  
                                        overflow: hidden;">
                            <?php echo __($series_slider->description); ?>
                        </div>

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?=  route('play_series', $series_slider->slug ) ?>" class="btn bd"><i
                                    class="fa fa-play mr-2" aria-hidden="true"></i> Play
                            </a>

                            <a class="btn bd ml-2" href="<?= route('play_series', $series_slider->slug )  ?>">
                                <i class="fa fa-info" aria-hidden="true"></i> More details
                            </a>
                        </div>
                    </div>
                </div>


                <!-- watch Trailer -->
                <?php if( $series_trailer != null ) { ?>
                <?php
                $series_image = $series_trailer != null ? $series_trailer->season_image : ' ';
                ?>

                <?php if( $series_trailer->trailer != null && $series_trailer->trailer_type == 'm3u8_url' ){  ?>

                <div class="trailor-video">
                    <a href="#video-trailer" class="video-open playbtn"
                        data-poster-url="<?= URL::to('/') . '/public/uploads/season_images/' . $series_image ?>"
                        data-trailer-url="<?php if ($series_trailer != null) {
                            echo $series_trailer->trailer;
                        } ?>" onclick="trailer_slider_season(this)"
                        data-trailer-type="<?php echo $series_trailer->trailer_type; ?>">

                        <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                            height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                            xml:space="preserve">
                            <style type="text/css">
                                .gt {
                                    height: 60px !important;
                                }
                            </style>
                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8"
                                r="103.3" />
                        </svg>
                        <span class="w-trailor">Watch Trailer</span>
                    </a>
                </div>

                <?php  }elseif( $series_trailer->trailer != null && $series_trailer->trailer_type == 'mp4_url' ){ ?>

                <div class="trailor-video">
                    <a href="#series_MP4_video-trailer" class="video-open playbtn"
                        data-poster-url="<?= URL::to('/') . '/public/uploads/season_images/' . $series_image ?>"
                        data-trailer-url="<?php if ($series_trailer != null) {
                            echo $series_trailer->trailer;
                        } ?>" onclick="trailer_slider_season(this)"
                        data-trailer-type="<?php echo $series_trailer->trailer_type; ?>">

                        <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                            height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                            xml:space="preserve">
                            <style type="text/css">
                                .gt {
                                    height: 60px !important;
                                }
                            </style>
                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8"
                                r="103.3" />
                        </svg>
                        <span class="w-trailor">Watch Trailer</span>
                    </a>
                </div>

                <?php } ?>


                <div class="col-md-12">
                    <div id="video-trailer" class="mfp-hide">
                        <video id="Trailer-videos" class="" poster="" controls
                            data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                            type="application/x-mpegURL">
                            <source type="application/x-mpegURL" src="<?php if ($series_trailer != null) {
                                echo $series_trailer->trailer;
                            } ?>">
                        </video>
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="series_MP4_video-trailer" class="mfp-hide">
                        <?php
                        $series_image = $series_trailer != null ? $series_trailer->season_image : ' ';
                        ?>
                        <video id="Series_MP4_Trailer-videos" class="" poster="" controls
                            data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                            src="<?php if ($series_trailer != null) {
                                echo $series_trailer->trailer;
                            } ?>" type="video/mp4">
                            <source src="<?php if ($series_trailer != null) {
                                echo $series_trailer->trailer;
                            } ?>" type='video/mp4' label='Auto' res='auto' />
                        </video>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?php endforeach;  endif; ?>


<style>
     video::-webkit-media-controls {
    display: none !important;
  }
  .myvideos{
    height: 420px !important;
  }
  </style>