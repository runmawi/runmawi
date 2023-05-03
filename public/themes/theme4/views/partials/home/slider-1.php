
<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>') no-repeat;background-size:cover;background-position:right; ">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="text-white text-uppercase mb-3" style="color:#fff!important;">
                        <?php echo __($slider_video->title); ?>
                    </h1>
                            <div class="mb-3">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span></div>
                            <div class="p-0">
                     <a href="<?php echo $slider_video->link; ?>"
                        class="btn bd "><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now</a>
                             <a href="<?php echo $slider_video->link; ?>"
                        class="btn bd ml-2"><i class="fa fa-play ml-2" aria-hidden="true"></i> Watch Trailer</a></div>
                </div>
                        <div class="col-xl-2 col-lg-12 col-md-6 mt-5 pt-5 b2">
                        <div class="justify align-items-left r-mb-23 mt-5" data-animation-in="fadeInUp"
                            data-delay-in="1.2">
                          
                               
                            </div></div>
                        <div class="col-xl-4 col-lg-12 col-md-12 text-center">
                        <!--<div class="">
                             <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo w-100" alt="<?php echo $settings->website_name ; ?>"> </a>
                            <h2 class="sp"></h2>
                        </div>--></div>
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
            style="background:linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:right;  ">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-5 col-lg-12 col-md-12">
<!--<a href="javascript:void(0);">
<div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
<img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
</div>
</a>-->
<h1 class="slider-text big-title title text-uppercase text-white" data-animation-in="fadeInLeft"
data-delay-in="0.6">
<?php echo __($slider_video->title); ?>
</h1>
                            <div class="mb-3">
                            <span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span></div>
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
    <a class="btn bd ml-2" href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
</div>
</div>
</div>

    <!-- <div class="trailor-video">
        <a href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>" class="video-open playbtn">
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
    </div> -->

</div>
</div>
</div>
</div>
<?php  ?>
<?php endforeach; 
endif; ?>

                            <!-- Live Event Banners -->

<?php $live_event_banners = App\LiveEventArtist::where('active',1)->where('banner',1)->get() ?>

<?php if(isset($live_event_banners)) :
    foreach($live_event_banners as $key => $live_event_banner): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                style="background:linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url('<?php echo URL::to('/').'/public/uploads/images/' .$live_event_banner->player_image;?>') no-repeat;background-size:cover;background-position:right;  ">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <h1 class="slider-text big-title title text-uppercase text-white" data-animation-in="fadeInLeft" data-delay-in="0.6">
                                    <?php echo __($live_event_banner->title); ?>
                                </h1>

                                <div class="mb-3">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>

                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="badge badge-secondary p-2">
                                        <?php echo __($live_event_banner->year); ?>
                                    </span>
                                </div>

                                <div data-animation-in="fadeInUp" data-delay-in="1.2"
                                    style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3; -webkit-box-orient: vertical;   overflow: hidden;">
                                    <?php echo __($live_event_banner->description); ?>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                                    data-delay-in="1.2">
                                    <a href="<?= route('live_event_play',$live_event_banner->slug)  ?>"
                                        class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
                                    <a class="btn bd ml-2" href="<?= route('live_event_play',$live_event_banner->slug)  ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
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

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background: url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>'); background-repeat:no-repeat;background-size:100% 100%;background-postion:top ;">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-slider mt-3">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <img src="" alt="" class="img-fluid">
                                               <!--  Video thumbnail image-->
                            
                  
                            <div class="row justify r-mb-23  p-0 mb-4 text-center" >
                                </div>
                            <div class="justify r-mb-23  p-0" >
                                
                           
                            </div>
                            
                </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2">
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 text-center">
                      <!--  <div class="">
                             <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo w-100" alt="<?php echo $settings->website_name ; ?>"> </a>
                            <h2 class="sp"></h2>
                        </div>--></div>
                </div>
              <!--  <div class="trailor-video">
                        <a href="#vide
                                 o-trailer"
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
                    </div>-->
                    <div class="col-md-12">
            <div id="video-trailer" class="mfp-hide">
             <video id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>"  class="" controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" ></video>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>

    
<?php  ?>
<?php endforeach; 
endif; ?>


<!--VideoCategory  -->
<?php

if(Route::current()->getName() == "home"){

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
?>

<?php if(isset($videos_category)) :
    foreach($videos_category as $key => $videos): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                 style="background:linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-postion:top ;">
                <div class="container-fluid position-relative h-100">
                    <div class="slider-inner h-100">

                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">

                            <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                                <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                    <img src="<?= URL::to('public/uploads/images/'.$videos->video_title_image )?>" class="c-logo" alt="<?= $videos->title ?>">
                                </a>
                                                            <!-- Video Title  -->
                            <?php }else{ ?>
                                <h1 class=" text-white title text-uppercase mb-3" data-animation-in="fadeInLeft"   data-delay-in="0.6">
                                     <?php echo (strlen($videos->title) > 15) ? substr($videos->title,0,80).'...' : $videos->title; ?>
                                </h1>
                            <?php } ?>
                            
                                <div class="mb-3">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>

                                <div data-animation-in="fadeInUp" data-delay-in="1.2"
                                        style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                            -webkit-line-clamp: 3;   -webkit-box-orient: vertical;  overflow: hidden;">
                                            <?php echo __($videos->description); ?>
                                </div>

                                <div class="row justify r-mb-23  p-0 mb-4 text-center" data-animation-in="fadeInUp"  data-delay-in="1.2">
                                    <div class="col-md-3">
                                    <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>" class="text-white">
                                        <div class="" style="font-size:25px;">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </div>  Add Whislist
                                    </a>
                                    </div>

                                    <div class="col-md-3">
                                        <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>" class="text-white ">
                                            <div class="" style="font-size:25px;">
                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            </div> Share
                                        </a>
                                    </div>
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

<?php endforeach;  endif; ?>

<?php } }?>



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
            style="background:linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:center center; ">
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
<span class=" p-2">
        <?php echo __($slider_video->age_restrict); ?>
    </span>
    <!--                      <span class="ml-3"><?php echo __($slider_video->language); ?></span>-->
</div>
<br>
<div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
    <span class=" p-2">
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
   <div class="row justify r-mb-23  p-0 mb-4 text-center" data-animation-in="fadeInUp"
                            data-delay-in="1.2">
                                <div class="col-md-3">
                                  <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"
                                class="text-white">
                                <div class="" style="font-size:25px;">
                             <i class="fa fa-plus" aria-hidden="true"></i>

                                      </div>
                                Add Whislist</a></div>
                                <div class="col-md-3">
                                 <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"
                                class="text-white ">
                                <div class="" style="font-size:25px;">
                              <i class="fa fa-share-alt" aria-hidden="true"></i>
                                      </div>
                                Share</a>
                            </div></div>                         
<div class="justify r-mb-23" data-animation-in="fadeInUp"
data-delay-in="1.2">
<a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="btn bd ml-3" href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
</div>
</div>
</div>
<!--<div class="trailor-video">
    <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"
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
</div>-->
</div>
</div>
</div>
</div>
<?php  ?>
<?php endforeach; 
endif; ?>


<!-- Series silder -->

<?php if(isset($series_sliders)) :
    foreach($series_sliders as $key => $series_slider): ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                    style="background:linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?php echo URL::to('/').'/public/uploads/images/' .$series_slider->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-postion:top ;">
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-5 col-lg-12 col-md-12">
                            <h1 class=" text-white title text-uppercase mb-3" data-animation-in="fadeInLeft" data-delay-in="0.6">
                                <?php echo __($series_slider->title); ?>
                            </h1>

                            <div class="mb-3">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>

                            <div data-animation-in="fadeInUp" data-delay-in="1.2"
                                style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3;  -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo __($series_slider->description); ?>
                            </div>


                            <div class="justify r-mb-23  p-0" data-animation-in="fadeInUp"   data-delay-in="1.2">    
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
    
<?php endforeach;  endif; ?>
