
<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazyload"
            data-bgset="<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>" style="background-position: right;    ">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="text-white mb-3" >
                        <?php
                        // $title = $slider_video->title;
                        // $slidertitle = substr($title, 0, 80);                        
                        // echo ($slidertitle.'...');
                        echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;
                       //  echo __($slider_video->title); 
                        ?>
                    </h1>
                    <div class="d-flex justify-content-evenly align-items-center r-mb-23" >
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
            <div class="slide slick-bg s-bg-1 lazyload"
            data-bgset="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>"  style="background-position: right;   ">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <!--<a href="javascript:void(0);">
                        <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
                        <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
                        </div>
                        </a>-->
                        <h1 class="text-white mb-3" >
                        <?php 
                        //  $title = $slider_video->title;
                        //  $slidertitle = substr($title, 0, 80);                        
                        //  echo ($slidertitle.'...');
                        echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;

                         // echo __($slider_video->title);
                         ?>
                        </h1>
                        <div class="d-flex align-items-center" >
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
                                    <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                            viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <style type="text/css">
                                                .gt{  height: 60px!important;  }
                                            </style>
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
                            <!-- Video Sliders -->

<?php if(isset($video_banners)) :
    foreach($video_banners as $key => $videos): ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazyload" data-bgset="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>" style="background-position: right;">
                <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12 bgc">
                                <h1 class="text-white mb-3" >
                                    <?php echo (strlen($videos->title) > 15) ? substr($videos->title,0,80).'...' : $videos->title; ?>
                                </h1>

                            <p class="desc" 
                                style="overflow: hidden !important;text-overflow: ellipsis !important; color:#fff;display: -webkit-box;
                                -webkit-line-clamp: 3;  -webkit-box-orient: vertical;     overflow: hidden;">
                                <?php echo __($videos->description); ?>
                            </p>

                            <div class="d-flex justify-content-evenly align-items-center r-mb-23" >
                                <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> WATCH
                                </a>
                              <!--  <a class="btn bd ml-2" href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                    <i class="fa fa-info" aria-hidden="true"></i> More details
                                </a>-->
                            </div>    
                        </div>
                    </div>

                    
                                <!-- watch Trailer -->
                    <?php if( $videos->trailer != null && $videos->trailer_type == 'm3u8' ){  ?>

                        <div class="trailor-video">
                            <a href="#video-trailer" class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>" data-trailer-url="<?= $videos->trailer ?>" data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)"  >
                            
                            <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                    viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <style type="text/css"> .gt{  height: 60px!important; } </style>
                                    <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                    <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                </svg>
                                <span class="w-trailor">Watch Trailer</span>
                            </a>
                        </div>

                    <?php }elseif($videos->trailer != null && $videos->trailer_type == 'm3u8_url' ){ ?>

                        <div class="trailor-video">
                            <a href="#M3U8_video-trailer" class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>"  data-trailer-url="<?= $videos->trailer ?>" data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)"  >
                            
                            <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                    viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <style type="text/css"> .gt{  height: 60px!important; } </style>
                                    <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                    <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                </svg>
                                <span class="w-trailor">Watch Trailer</span>
                            </a>
                        </div>

                    <?php  }elseif( $videos->trailer != null && $videos->trailer_type == 'mp4_url' || $videos->trailer_type == 'video_mp4' ){ ?>

                        <div class="trailor-video">
                            <a href="#MP4_videos-trailer" class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>"  data-trailer-url="<?= $videos->trailer ?>" data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)"  >
                            
                            <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                    viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <style type="text/css"> .gt{  height: 60px!important; } </style>
                                    <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                    <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                </svg>
                                <span class="w-trailor">Watch Trailer</span>
                            </a>
                        </div>

                    <?php } ?>

                        <div class="col-md-12">
                            <div id="video-trailer" class="mfp-hide">

                                <video  id="Trailer-videos" class=""  poster=""
                                    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                    <source  type="application/x-mpegURL"  src="<?php echo $videos->trailer;?>">
                                </video>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="M3U8_video-trailer" class="mfp-hide">
                                <video  id="M3U8_video-videos" class=""  poster=""
                                    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                    <source  type="application/x-mpegURL"  src="<?php echo $videos->trailer;?>">
                                </video>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="MP4_videos-trailer" class="mfp-hide">
                                <video  id="MP4_Trailer-videos" class=""  poster=""
                                    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                    <source  type="application/x-mpegURL"  src="<?php echo $videos->trailer;?>">
                                </video>
                            </div>
                        </div>
                </div>
            </div>
        </div>
</div>

<?php endforeach;endif; ?>

<!-- Catogery Slider -->
<?php

if(Route::current()->getName() == "home" || Route::current()->getName() == null ){


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
        foreach($videos_category as $key => $videos_categorys): ?>
            <div class="item <?php if($key == 0){echo 'active';}?> header-image">
                <div class="slide slick-bg s-bg-1 lazyload"
                        data-bgset="<?php echo URL::to('/').'/public/uploads/images/' .$videos_categorys->player_image;?>" style="background-position: right;">

                    <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                        <div class="slider-inner h-100">
                            <div class="row align-items-center bl h-100">
                                <div class="col-xl-6 col-lg-12 col-md-12">

                                    <h1 class="text-white mb-3" data-animation-in="fadeInLeft"   data-delay-in="0.6">
                                        <?php 
                                        // $title = $videos_categorys->title;
                                        // $slidertitle = substr($title, 0, 80);                
                                                echo (strlen($videos_categorys->title) > 15) ? substr($videos_categorys->title,0,80).'...' : $videos_categorys->title;
                                        // echo ($slidertitle.'...');
                                        ?>
                                    </h1>

                                    <p class="desc" data-animation-in="fadeInUp" data-delay-in="1.2"   style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;
                                        display: -webkit-box;   -webkit-line-clamp: 3; -webkit-box-orient: vertical;     overflow: hidden;">
                                        <?php echo __($videos_categorys->description); ?>
                                    </p>

                                    <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"  data-delay-in="1.2">
                                        <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos_categorys->slug ?>"
                                            class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> WATCH
                                        </a>
                                        <a class="btn bd ml-2" href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos_categorys->slug ?>">
                                            <i class="fa fa-info" aria-hidden="true"></i> More details
                                        </a>
                                    </div>    
                                </div>
                            </div>

                                        <!-- watch Trailer -->
                         <?php if( $videos_categorys->trailer != null && $videos_categorys->trailer_type == 'm3u8'  ){  ?>

                            <div class="trailor-video">
                                <a href="#video-trailer"    class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos_categorys->player_image ?>" data-trailer-url="<?= $videos_categorys->trailer ?>" data-trailer-type="<?= $videos_categorys->trailer_type ?>" onclick="trailer_slider_videos(this)" >
                                       
                                    <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                         viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <style type="text/css">  .gt{     height: 60px!important;    }     </style>
                                        <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"    stroke-linejoin="round" stroke-miterlimit="10"
                                            points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                        <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                    </svg>
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>

                        <?php }elseif( $videos_categorys->trailer != null && $videos_categorys->trailer_type == 'm3u8_url' ){ ?>

                            <div class="trailor-video">
                                <a href="#M3U8_video-trailer"    class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos_categorys->player_image ?>" data-trailer-url="<?= $videos_categorys->trailer ?>" data-trailer-type="<?= $videos_categorys->trailer_type ?>" onclick="trailer_slider_videos(this)" >
                                       
                                    <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                         viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <style type="text/css">  .gt{     height: 60px!important;    }     </style>
                                        <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"    stroke-linejoin="round" stroke-miterlimit="10"
                                            points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                        <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                    </svg>
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>


                        <?php  }elseif( $videos_categorys->trailer != null && $videos_categorys->trailer_type == 'mp4_url' || $videos_categorys->trailer_type == "video_mp4" ){ ?>

                                <div class="trailor-video">
                                    <a href="#MP4_videos-trailer"    class="video-open playbtn" data-poster-url="<?= URL::to('/') . '/public/uploads/images/' . $videos_categorys->player_image ?>"  data-trailer-url="<?= $videos_categorys->trailer ?>" data-trailer-type="<?= $videos_categorys->trailer_type ?>" onclick="trailer_slider_videos(this)" >
                                        
                                        <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                            viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <style type="text/css">  .gt{     height: 60px!important;    }     </style>
                                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"    stroke-linejoin="round" stroke-miterlimit="10"
                                                points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                        </svg>
                                        <span class="w-trailor">Watch Trailer</span>
                                    </a>
                                </div>

                        <?php } ?>

                            <div class="col-md-12">
                                <div id="video-trailer" class="mfp-hide">
                                    <video  id="Trailer-videos" class=""  poster=""
                                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                            <source  type="application/x-mpegURL"  src="<?php echo $videos_categorys->trailer;?>">
                                    </video>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="M3U8_video-trailer" class="mfp-hide">
                                    <video  id="M3U8_video-videos" class=""  poster=""
                                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                        <source  type="application/x-mpegURL"  src="<?php echo $videos_categorys->trailer;?>">
                                    </video>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="MP4_videos-trailer" class="mfp-hide">
                                    <video  id="MP4_Trailer-videos" class=""  poster=""
                                        controls data-setup='{"controls": true, "aspectRatio":"4:6", "fluid": true}' type="video/mp4">
                                        <source  type="video/mp4"  src="<?php echo $videos_categorys->trailer;?>">
                                    </video>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    <?php endforeach;endif; ?>

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


<!-- Tv show Banners -->
<?php
 if(isset($banner)) : 
    foreach($banner as $key => $slider_video): 
            ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazyload"
             data-bgset="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>" style="background-position: right;  ">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-8 col-lg-12 col-md-12">
                    <!--<a href="javascript:void(0);">
                    <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
                    <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
                    </div>
                    </a>-->
                    <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                    data-delay-in="0.6">
                    <?php 
                        //   $title = $slider_video->title;
                        //   $slidertitle = substr($title, 0, 80);                        
                        //   echo ($slidertitle.'...');
                    echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;
                          // echo __($slider_video->title);

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
                    <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                    data-delay-in="1.2">
                    <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"
                        class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play</a>
                        <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
                        <a class="btn bd ml-2" href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
                    </div>
                    </div>
                    </div>
                    <div class="trailor-video">
                        <a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->title.'/' . $slider_video->title ?>"
                            class="video-open playbtn">
                            <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"
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

<!-- Series Slider -->


<?php if(isset($series_sliders)) :
    foreach($series_sliders as $key => $series_slider): ?>

    <?php 
            $series_trailer =  App\Series::Select('series.*','series_seasons.trailer','series_seasons.trailer_type')
                                        ->Join('series_seasons','series_seasons.series_id','=','series.id')
                                        ->where('series.id',$series_slider->id)
                                        ->where('series_seasons.id','=',$series_slider->season_trailer)
                                        ->where('series_trailer','1')
										->first();
    ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazyload"
                     data-bgset="<?php echo URL::to('/').'/public/uploads/images/' .$series_slider->player_image;?>"  style="background-position: right;">
                <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                        
                                <h1 class="text-white mb-3" data-animation-in="fadeInLeft"    data-delay-in="0.6">
                                    <?php  echo (strlen($series_slider->title) > 15) ? substr($series_slider->title,0,80).'...' : $series_slider->title;    ?>
                                </h1>

                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="badge badge-secondary p-2">
                                        <?php echo __($series_slider->year); ?>
                                    </span>
                                </div>

                                <div data-animation-in="fadeInUp" data-delay-in="1.2"
                                        style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3;
                                        -webkit-box-orient: vertical;  
                                        overflow: hidden;">
                                    <?php echo __($series_slider->description); ?>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                        <a href="<?= URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>"
                                            class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play
                                        </a>

                                        <a class="btn bd ml-2" href="<?= URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>">
                                                <i class="fa fa-info" aria-hidden="true"></i> More details
                                        </a>
                                </div>
                            </div>
                        </div>


                    <!-- watch Trailer -->
                    <?php if( $series_trailer != null ) { ?>
                        <?php
                            $series_image =  $series_trailer != null ? $series_trailer->season_image   :  ' ';
                        ?>

                        <?php if( $series_trailer->trailer != null && $series_trailer->trailer_type == 'm3u8_url' ){  ?>

                            <div class="trailor-video">
                                <a href="#video-trailer" class="video-open playbtn" data-poster-url ="<?= URL::to('/') . '/public/uploads/season_images/' . $series_image ?>" data-trailer-url="<?php if( $series_trailer != null) { echo $series_trailer->trailer; }   ?>"  onclick="trailer_slider_season(this)" data-trailer-type = "<?php  echo $series_trailer->trailer_type ;?>"  >
                                
                                <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                        viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <style type="text/css"> .gt{  height: 60px!important; } </style>
                                        <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                        points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                        <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                    </svg>
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>

                        <?php  }elseif( $series_trailer->trailer != null && $series_trailer->trailer_type == 'mp4_url' ){ ?>

                            <div class="trailor-video">
                                <a href="#series_MP4_video-trailer" class="video-open playbtn" data-poster-url ="<?= URL::to('/') . '/public/uploads/season_images/' . $series_image ?>" data-trailer-url="<?php if( $series_trailer != null) { echo $series_trailer->trailer; }   ?>"  onclick="trailer_slider_season(this)" data-trailer-type = "<?php  echo $series_trailer->trailer_type ;?>"  >
                                
                                <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                        viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <style type="text/css"> .gt{  height: 60px!important; } </style>
                                        <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                        points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                        <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                    </svg>
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>

                        <?php } ?>


                        <div class="col-md-12">
                            <div id="video-trailer" class="mfp-hide">
                                

                                    <video  id="Trailer-videos" class=""  poster=""
                                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                        <source  type="application/x-mpegURL"  src="<?php if( $series_trailer != null) { echo  $series_trailer->trailer ;} ?>">
                                    </video>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="series_MP4_video-trailer" class="mfp-hide">
                                <?php
                                    $series_image =  $series_trailer != null ? $series_trailer->season_image   :  ' ';
                                ?>
                                <video   id="Series_MP4_Trailer-videos" class="" poster="" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php if( $series_trailer != null) { echo  $series_trailer->trailer ;} ?>"  type="video/mp4" >
                                    <source src="<?php if( $series_trailer != null) { echo  $series_trailer->trailer ;} ?>" type='video/mp4' label='Auto' res='auto' />
                                </video> 
                            </div>
                        </div>

                    <?php } ?>

                    </div>
                </div>
            </div>
        </div>
<?php endforeach;  endif; ?>

