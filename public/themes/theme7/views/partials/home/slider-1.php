



<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>
<div class="item <?php if ($key == 0) {
    echo 'active';
} ?> header-image">
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/videocategory/' . $slider_video->slider; ?>" style="background-size: cover;    ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?php echo $slider_video->link; ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2"  aria-hidden="true"></i> Learn More
                                </button>
                            </a>
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
    <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $slider_video->player_image; ?>" style="background-size: cover;   ">
        
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?= URL::to('live/' . $slider_video->slug) ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
                            </a>
                            
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
        style="background-size: cover;   ">
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?= route('live_event_play', $live_event_banner->slug) ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
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
    <div class="slide  slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/') . '/public/uploads/images/' . $videos->player_image; ?>" style="background-size: cover;">
        
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12 bgc">

                       

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
                            </a>

                            <?php   include(public_path('themes/theme7/views/partials/home/Trailer-slider.php')); ?>       
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


            $parentCategories = App\VideoCategory::where('in_home',1)->where('banner',1)->get();

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
        style="background-size: cover;">
        
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">

                       
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?php echo URL::to('/'); ?><?= '/category/videos/' . $videos->slug ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
                            </a>

                            <?php   include(public_path('themes/theme7/views/partials/home/Trailer-slider.php')); ?>       
                           
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
        style="background-size: cover;  ">
        
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23"
                            data-animation-in="fadeInUp" data-delay-in="1.2">
                            <a href="<?php echo URL::to('episode'); ?><?= '/' . @$slider_video->series_title->slug . '/' . $slider_video->slug ?>"  class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
                            </a>

                            
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
    style="background-size: cover;"
    id="image-container"
> 


        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-12 col-md-12">

                        

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="<?= URL::to('/play_series' . '/' . $series_slider->slug)  ?>" class="learn-mr-bt">
                                <button class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> Learn More
                                </button>
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

<!-- <script>
        $(document).ready(function () {
            const imageContainer = document.getElementById("image-container");
            const video = document.querySelector(".myvideos");
            video.style.opacity = 0;

            // Function to play the video after 5 seconds
            function playVideoAfterDelay() {
                setTimeout(function () {
                    video.play();
                    video.style.opacity = 1;
                }, 5000); // 5000 milliseconds (5 seconds)
            }

            // Call the function to play the video after a delay
            playVideoAfterDelay();
        });
    </script> -->