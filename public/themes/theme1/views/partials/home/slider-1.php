
<!-- Sliders -->

<?php if(isset($sliders)) :
    foreach($sliders as $key => $slider_video): ?>

   

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/videocategory/' .$slider_video->slider;?>') no-repeat;background-size:contain;background-position:right; ">
                <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                    <?php if (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'video_mp4')): ?> 
                        <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                    <?php elseif (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'm3u8')): 
                        $url = $slider_video->trailer;

                        // Get the path information of the URL
                        $pathInfo = pathinfo($url);
                        
                        // Replace the extension with 'mp4'
                        $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                        
                        ?>

                        <input type="hidden" class="trailer_type" value="<?= $slider_video->trailer_type  ?>" >
                            <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
    

                        <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                    <?php else: ?>
                        <!-- If trailer is not available, show the banner image -->
                        <img src="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                    <?php endif; ?>
                </div>
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                        <h1 class="text-white text-uppercase mb-3" style="color:#fff!important;">
                        <?php 
echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;
// echo __($slider_video->title); 
                        ?>
                    </h1>
                            <div class="mb-3">
                            <span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span></div>
                            <div class="p-0">
                     <a href="<?php echo $slider_video->link; ?>"
                        class="btn bd "><i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play Now')  ?></a>
                             <a href="<?php echo $slider_video->link; ?>"
                        class="btn bd ml-2"><i class="fa fa-play ml-2" aria-hidden="true"></i> <?= __('Watch Trailer')  ?></a></div>
                </div>
                        <div class="col-xl-2 col-lg-12 col-md-6 mt-5 pt-5 b2">
                        <div class="justify align-items-left r-mb-23 mt-5" >
                          
                               
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
    foreach($live_banner as $key => $slider_video):    ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:right;  ">
                <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                    <?php if (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'video_mp4')): ?> 
                        <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                    <?php elseif (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'm3u8')): 
                        $url = $slider_video->trailer;

                        // Get the path information of the URL
                        $pathInfo = pathinfo($url);
                        
                        // Replace the extension with 'mp4'
                        $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                        
                        ?>

                        <input type="hidden" class="trailer_type" value="<?= $slider_video->trailer_type  ?>" >
                            <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
    

                        <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                    <?php else: ?>
                        <!-- If trailer is not available, show the banner image -->
                        <img src="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                    <?php endif; ?>
                </div>
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-5 col-lg-12 col-md-12">
<!--<a href="javascript:void(0);">
<div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5" background-size:cover; background-position:center>
<img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
</div>
</a>-->
<h1 class="slider-text big-title title text-uppercase text-white" >
<?php
echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;
// echo __($slider_video->title); 
?>
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
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play')  ?></a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="btn bd ml-2" href="<?= URL::to('/') ?><?= '/live'.'/'. $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> <?= __('More details')  ?></a>
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
<!-- Video Sliders -->


                <!-- Live Event Banners -->
<?php $live_event_banners = App\LiveEventArtist::where('active',1)->where('banner',1)->get() ?>

<?php if(isset($live_event_banners)) :
    foreach($live_event_banners as $key => $live_event_banner):    ?>
        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$live_event_banner->player_image;?>') no-repeat;background-size:cover;background-position:right;  ">
                    <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                        <?php if (!empty($live_event_banner->trailer) && ($live_event_banner->trailer_type == 'video_mp4')): ?> 
                            <video class="myvideos" controls loop autoplay muted src="<?php echo $live_event_banner->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                        <?php elseif (!empty($live_event_banner->trailer) && ($live_event_banner->trailer_type == 'm3u8')): 
                            $url = $live_event_banner->trailer;

                            // Get the path information of the URL
                            $pathInfo = pathinfo($url);
                            
                            // Replace the extension with 'mp4'
                            $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                            
                            ?>

                            <input type="hidden" class="trailer_type" value="<?= $live_event_banner->trailer_type  ?>" >
                                <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
        

                            <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                        <?php else: ?>
                            <!-- If trailer is not available, show the banner image -->
                            <img src="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                        <?php endif; ?>
                    </div>
                <div class="container position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <h1 class="slider-text big-title title text-uppercase text-white" >
                                    <?php echo (strlen($live_event_banner->title) > 15) ? substr($live_event_banner->title,0,80).'...' : $live_event_banner->title; ?>
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

                                <div 
                                    style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3; -webkit-box-orient: vertical;   overflow: hidden;">
                                    <?php echo __($live_event_banner->description); ?>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp"
                                    data-delay-in="1.2">
                                    <a href="<?= route('live_event_play',$live_event_banner->slug)  ?>"
                                        class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play')  ?>
                                    </a>
                                    <a class="btn bd ml-2" href="<?= route('live_event_play',$live_event_banner->slug)  ?>"><i class="fa fa-info" aria-hidden="true"></i> <?= __('More details')  ?></a>
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
    foreach($video_banners as $key => $videos):  ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>') no-repeat;background-size:contain;background-position:right; ">
            <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                <?php if (!empty($videos->trailer) && ($videos->trailer_type == 'video_mp4')): ?> 
                    <video class="myvideos" controls loop autoplay muted src="<?php echo $videos->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                <?php elseif (!empty($videos->trailer) && ($videos->trailer_type == 'm3u8')): 
                    $url = $videos->trailer;

                    // Get the path information of the URL
                    $pathInfo = pathinfo($url);
                    
                    // Replace the extension with 'mp4'
                    $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                    
                    ?>

                    <input type="hidden" class="trailer_type" value="<?= $videos->trailer_type  ?>" >
                        <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
 

                    <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $videos->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                <?php else: ?>
                    <!-- If trailer is not available, show the banner image -->
                    <img src="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                <?php endif; ?>
            </div>
                <!-- <div class="our-video" style="position: absolute; bottom: 0; left:0; right:0; width:100%; height: 100%;">
                    <video class="myvideos" controls loop autoplay muted src="http://vjs.zencdn.net/v/oceans.mp4" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                </div>    -->
            <div class="container-fluid position-relative h-100" style="padding:0px 100px;">
                <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-5 col-lg-12 col-md-12 mt-3">
                                                        <!--  Video thumbnail image-->
                            <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                                    <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                        <img src="<?= URL::to('public/uploads/images/'.$videos->video_title_image )?>" class="c-logo" alt="<?= $videos->title ?>">
                                    </a>
                                                        <!-- Video Title  -->
                            <?php }else{ ?>
                                    <h1 class="text-white title text-uppercase mb-3" >
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

                            <div class="slider-desc" style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff !important;display: -webkit-box;
                                -webkit-line-clamp: 3;   -webkit-box-orient: vertical;  overflow: hidden;">
                                <?php echo __($videos->description); ?>
                            </div>

                                              <!-- Trailer  -->
                            <div class="justify r-mb-23  p-0" >
                                <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"  class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play Now')  ?></a>
                                    <a href="#theme1-trailer"  class="theme1-trailer btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>" data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_video(this)" >
                                        <i class="fa fa-info" aria-hidden="true"></i> <?= __('Watch Trailer')  ?>
                                    </a>
                            </div>
                            
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2"></div>
                        <div class="col-xl-4 col-lg-12 col-md-12 text-center"></div>
                    </div>
            
                        <div class="col-md-12">
                            <div id="theme1-trailer" class="mfp-hide">

                                <video  id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>"  
                                    controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" >
                                </video>
                            </div>
                        </div>
                </div>
            </div>
        </div>
</div>

    
<?php  ?>
<?php endforeach; 
endif; ?>

<!-- VideoCategory -->
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
    foreach($videos_category as $key => $videos):  ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                     style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>') no-repeat;background-size:inherit;background-position:right 10%; ">
                        <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                            <?php if (!empty($videos->trailer) && ($videos->trailer_type == 'video_mp4')): ?> 
                                <video class="myvideos" controls loop autoplay muted src="<?php echo $videos->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                            <?php elseif (!empty($videos->trailer) && ($videos->trailer_type == 'm3u8')): 
                                $url = $videos->trailer;

                                // Get the path information of the URL
                                $pathInfo = pathinfo($url);
                                
                                // Replace the extension with 'mp4'
                                $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                                
                                ?>

                                <input type="hidden" class="trailer_type" value="<?= $videos->trailer_type  ?>" >
                                    <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
            

                                <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $videos->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                            <?php else: ?>
                                <!-- If trailer is not available, show the banner image -->
                                <img src="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                            <?php endif; ?>
                        </div>
                     <div class="container position-relative h-100">
                    <div class="slider-inner h-100">

                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-4 col-lg-12 col-md-12">

                            <?php if( $videos->enable_video_title_image == 1  &&  $videos->video_title_image != null){ ?>
                                <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>">
                                    <img src="<?= URL::to('public/uploads/images/'.$videos->video_title_image )?>" class="c-logo" alt="<?= $videos->title ?>">
                                </a>
                                                            <!-- Video Title  -->
                            <?php }else{ ?>
                                <h1 class=" text-white title text-uppercase mb-3" data-animation-in="fadeInLeft" data-delay-in="0.6">
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

                            <div data-animation-in="fadeInUp" data-delay-in="1.2" style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                -webkit-line-clamp: 3;   -webkit-box-orient: vertical;  overflow: hidden;">
                                <?php echo __($videos->description); ?>
                            </div>

                                              <!-- Trailer  -->
                            <div class="justify r-mb-23  p-0" data-animation-in="fadeInUp"  data-delay-in="1.2">
                                <a href="<?php echo URL::to('/') ?><?= '/category/videos/' . $videos->slug ?>"  class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i><?= __('Play Now')  ?> </a>
                                    <a href="#theme1-trailer"  class="theme1-trailer btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>" data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_video(this)" >
                                        <i class="fa fa-info" aria-hidden="true"></i><?= __('Watch Trailer')  ?> 
                                    </a>
                            </div>
                            
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2"></div>
                        <div class="col-xl-4 col-lg-12 col-md-12 text-center"></div>
                    </div>
            
                        <div class="col-md-12">
                            <div id="theme1-trailer" class="mfp-hide">

                                <video  id="videoPlayer" poster="<?php echo URL::to('/').'/public/uploads/images/' .$videos->player_image;?>"  
                                    controls src="<?= $videos->trailer; ?>"  type="application/x-mpegURL" >
                                </video>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; endif; ?>

<?php } }?>



<!-- Banners -->
<?php if(isset($banner)) : 
    foreach($banner as $key => $slider_video): 
              ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
            style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>') no-repeat;background-size:cover;background-position:center center; ">
            
                    <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                        <?php if (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'video_mp4')): ?> 
                            <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                        <?php elseif (!empty($slider_video->trailer) && ($slider_video->trailer_type == 'm3u8')): 
                            $url = $slider_video->trailer;

                            // Get the path information of the URL
                            $pathInfo = pathinfo($url);
                            
                            // Replace the extension with 'mp4'
                            $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                            
                            ?>

                            <input type="hidden" class="trailer_type" value="<?= $slider_video->trailer_type  ?>" >
                                <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
        

                            <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $slider_video->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                        <?php else: ?>
                            <!-- If trailer is not available, show the banner image -->
                            <img src="<?php echo URL::to('/').'/public/uploads/images/' .$slider_video->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                        <?php endif; ?>
                    </div>
            <div class="container position-relative h-100">
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
<?php 
echo (strlen($slider_video->title) > 15) ? substr($slider_video->title,0,80).'...' : $slider_video->title;
// echo __($slider_video->title);
 ?>
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
<div class="justify r-mb-23" data-animation-in="fadeInUp"
data-delay-in="1.2">
<a href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"
    class="btn bd"><i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play')  ?></a>
    <!-- <a class=" btn black" href="https://flicknexui.webnexs.org/" ><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>-->
    <a class="btn bd" href="<?php echo URL::to('episode') ?><?= '/'.@$slider_video->series_title->slug.'/' . $slider_video->slug ?>"><i class="fa fa-info" aria-hidden="true"></i> <?= __('More details')  ?></a>
</div>
</div>
</div>
<div class="trailor-video">
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
    <span class="w-trailor"><?= __('Watch Trailer')  ?></span>
</a>
</div>
</div>
</div>
</div>
</div>
<?php  ?>
<?php endforeach; 
endif; ?>


<!-- Series Banner -->

<?php if(isset($series_sliders)) :
    foreach($series_sliders as $key => $series_slider):    ?>

        <div class="item <?php if($key == 0){echo 'active';}?> header-image">
            <div class="slide slick-bg s-bg-1 lazy"
                 style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$series_slider->player_image;?>') no-repeat;background-size:cover;background-position:right;  ">
                
                    <div class="our-video" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                        <?php if (!empty($series_slider->trailer) && ($series_slider->trailer_type == 'video_mp4')): ?> 
                            <video class="myvideos" controls loop autoplay muted src="<?php echo $series_slider->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
                        <?php elseif (!empty($series_slider->trailer) && ($series_slider->trailer_type == 'm3u8')): 
                            $url = $series_slider->trailer;

                            // Get the path information of the URL
                            $pathInfo = pathinfo($url);
                            
                            // Replace the extension with 'mp4'
                            $newUrl = str_replace($pathInfo['extension'], 'mp4', $url);
                            
                            ?>

                            <input type="hidden" class="trailer_type" value="<?= $series_slider->trailer_type  ?>" >
                                <video class="myvideos" controls loop autoplay muted src="<?php echo $newUrl;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video>
        

                            <!-- <video class="myvideos" controls loop autoplay muted src="<?php echo $series_slider->trailer;?>" width="100%" height="auto" alt="" style="transform: scale(1.42);"></video> -->
                        <?php else: ?>
                            <!-- If trailer is not available, show the banner image -->
                            <img src="<?php echo URL::to('/').'/public/uploads/images/' .$series_slider->player_image;?>" alt="Banner Image" style="width: 100%; height: auto;">
                        <?php endif; ?>
                    </div>
                 <div class="container position-relative h-100">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center bl h-100">
                            <div class="col-xl-5 col-lg-12 col-md-12">

                                <h1 class="slider-text big-title title text-uppercase text-white" >
                                    <?php echo __($series_slider->title); ?>
                                </h1>

                                <div class="mb-3">
                                    <span class="fa fa-star  checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>

                                <div class="d-flex align-items-center" >
                                    <span class="badge badge-secondary p-2">
                                        <?php echo __($series_slider->year); ?>
                                    </span>
                                </div>

                                <div 
                                    style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                        -webkit-line-clamp: 3;   -webkit-box-orient: vertical;      overflow: hidden;">
                                    <?php echo __($series_slider->description); ?>
                                </div>

                                <div class="d-flex justify-content-evenly align-items-center r-mb-23" >
                        
                                    <a href="<?= URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>"  class="btn bd">
                                        <i class="fa fa-play mr-2" aria-hidden="true"></i> <?= __('Play')  ?>
                                    </a>

                                    <a class="btn bd ml-2" href="<?= URL::to('/') ?><?= '/play_series'.'/'. $series_slider->slug ?>">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                        <?= __('More details')  ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php endforeach; endif; ?>

