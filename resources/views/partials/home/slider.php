<!-- Sliders -->
<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1"
            style="background:url('<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>') no-repeat;background-size:100;background-position:right center; ">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                        data-delay-in="0.6">
                        <?php echo __($slider_video->title); ?>
                    </h1>
                    <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                    data-delay-in="1.2">
                    <a href="<?php echo $slider_video->link; ?>"
                        class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php  ?>
<?php endforeach; 
endif; ?>
<!-- Banners -->
<?php if(isset($banner)) :
    foreach($banner as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->image;?>') no-repeat;background-size:100;background-position:right center; ">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
<!--<a href="javascript:void(0);">
<div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
<img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
</div>
</a>-->
<h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
data-delay-in="0.6">
<?php echo __($slider_video->title); ?>
</h1>
<div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
    <span class="badge badge-secondary p-2">
        <?php echo __($slider_video->year); ?>
    </span>
    <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
</div>
<div data-animation-in="fadeInUp" data-delay-in="1.2"
style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;">
<?php echo __($slider_video->description); ?>
</div>
<div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
data-delay-in="1.2">
<a href="<?php echo URL::to('category') ?><?= '/videos/' . $slider_video->slug ?>"
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="black bl" href="<?php echo URL::to('category') ?><?= '/videos/' . $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
</div>
</div>
</div>
<div class="trailor-video">
    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $slider_video->slug ?>"
        class="video-open playbtn">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
        viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
        <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
        stroke-linejoin="round" stroke-miterlimit="10"
        points="73.5,62.5 148.5,105.8 73.5,149.1 " />
        <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
        stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
    </svg>
    <span class="w-trailor">Watch Trailer</span>
</a>
</div>
</div>
</div>
</div>
</div>
<?php  ?>
<?php endforeach; 
endif; ?>
