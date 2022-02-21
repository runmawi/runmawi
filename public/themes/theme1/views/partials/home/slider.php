
<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>') no-repeat;background-size:cover;background-position:center center; ">
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
<!-- Live Banners -->
<?php if(isset($live_banner)) :
    foreach($live_banner as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->image;?>') no-repeat;background-size:cover;background-position:center center; ">
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
style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;  
  overflow: hidden;">
<?php echo __($slider_video->description); ?>
</div>
<div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
data-delay-in="1.2">
<a href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>"
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="black bl" href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
</div>
</div>
</div>
<div class="trailor-video">
    <a href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>"
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
<!-- Video Sliders -->

<?php if(isset($video_banners)) :
    foreach($video_banners as $key => $videos): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->image;?>') no-repeat;background-size:cover;background-position:center center; ">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                        data-delay-in="0.6">
                        <?php echo __($videos->title); ?>
                    </h1>
                    <div data-animation-in="fadeInUp" data-delay-in="1.2"
                        style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;  
                        overflow: hidden;">
                        <?php echo __($videos->description); ?>
                        </div>
                        <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                            data-delay-in="1.2">
                            <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"
                                class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Watch Now</a>
                                <a href="#vide
                                 o-trailer"
                            class="video-open playbtn btn bd ml-2"  href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> Watch Trailer</a>
                            </div></div>
                        <div class="col-xl-4 col-lg-12 col-md-12 text-center">
                        <div class="">
                             <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo w-100" alt="<?php echo $settings->website_name ; ?>"> </a>
                            <h2 class="sp">Specials !</h2>
                        </div></div>
                </div>
                </div>
                <div class="trailor-video">
                        <a href="#video-trailer"
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
                    <div class="col-md-12">
            <div id="video-trailer" class="mfp-hide">
                <?php if($videos->type == "embed"){ ?>
                    <div class="plyr__video-embed" id="player">
            <iframe
              src="<?php if(!empty($videos->embed_code)){ echo $videos->embed_code; }else { echo $videos->trailer;} ?>"
              allowfullscreen
              allowtransparency
              allow="autoplay"
            ></iframe>
          </div>
                       <?php }elseif($videos->type == "mp4_url"){ ?>
             <video id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->image;?>"  class="" controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" ></video>
             <?php }elseif($videos->type == "m3u8_url"){ ?>
                <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $videos->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                   <source src="<?php if(!empty($videos->m3u8_url)){ echo $videos->m3u8_url; }else { echo $videos->trailer;} ?>"  type='application/x-mpegURL' label='auto' > 
        </video>
             <?php }elseif($videos->type == ""){ ?>
                <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $videos->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
      <source 
        type="application/x-mpegURL" 
        src="<?php echo URL::to('/storage/app/public/').'/'.$videos->path . '.m3u8'; ?>"
      >
    </video>             <?php } ?>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>

    
<?php  ?>
<?php endforeach; 
endif; ?>

	<!-- Add New Modal -->



<!--
        <div class="modal fade" id="addnew">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" id="Close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div> 
                    <div id="popUpForm" class="modal-body">
                        <video id="videoPlayer" autoplay class="" controls src="<?//$videos->trailer;  ?>"  type="application/x-mpegURL" > </video>
                    </div>    
                </div>
            </div>
        </div>
-->




<!--
<script>

        $(document).ready(function(){
        $('#videopopup').click(function(){
        $('.container-fluid.position-relative.h-100').css('display','none');

        $('#addnew').modal({
        backdrop: 'static',
        keyboard: false
        });
        });
        $('#Close').click(function() {
        var videoPlayer = document.getElementById('videoPlayer');
        player.pause();
        $('.container-fluid.position-relative.h-100').css('display','block');

        });
        });

   
// if (!$(this.target).is('#popUpForm')) {
//     $(".modalDialog").hide();
// $('.container-fluid.position-relative.h-100').css('display','block');

//   }

</script>
-->
<!-- Banners -->
<?php if(isset($banner)) : 
    foreach($banner as $key => $slider_video): 
            ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->image;?>') no-repeat;background-size:cover;background-position:center center; ">
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
        <?php echo __($slider_video->age_restrict); ?>
    </span>
    <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
</div>
<br>
<div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
    <span class="badge badge-secondary p-2">
        <?php echo __($slider_video->year); ?>
    </span>
    <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
</div>
<div data-animation-in="fadeInUp" data-delay-in="1.2"
style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;  
  overflow: hidden;">
<?php echo __($slider_video->description); ?>
</div>
<div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
data-delay-in="1.2">
<a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="black bl" href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
</div>
</div>
</div>
<div class="trailor-video">
    <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"
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
