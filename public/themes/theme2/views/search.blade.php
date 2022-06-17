@php
    include(public_path('themes/theme2/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">Search Result of "{{  $search_value }}" Videos</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between"> </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($videos)) 
                                @foreach($videos as $latest_video)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_video->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

<<<<<<< HEAD
<div class="container-fluid movlistt mt-5" id="home-content">
    
    <div class="new-art">
        <h4 class="Continue Watching  padding-top-40" >Search Result of "<?php echo $search_value;?>" Channel Videos</h4>
	    <div class="border-line" style="margin-bottom:15px;margin-top:20px;"></div>
    </div>
    
    <div class="">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php if(isset($videos) && !empty($videos)) { 
            foreach($videos as $watchlater_video): ?>
   <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                   <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt=""> -->
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  data-play="hover" >
                                    <source src="<?php echo $watchlater_video->trailer;  ?>" type="video/mp4">
                                      </video>
                                     </a>
                                   
                                          <?php  if(!empty($watchlater_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                     
                                </div>
                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                   <h6><?php echo __($watchlater_video->title); ?></h6>
                                    </a>
                                   <div class="movie-time d-flex align-items-center my-2">
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict ?></div>
                                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                   </div>
                                    
                                    
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >
                                    
                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                      Watch Now
                                      
                                       </a>
                                       <div class="hover-buttons">
                                       <!-- <a   href="<?php // echo URL::to('category') ?><?// '/wishlist/' . $watchlater_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                       <!-- </a> -->
                          <span style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $watchlater_video->id ?>"><i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i><span id="addwatchlist"> Add to Watchlist </span> </span>
                              </div>
=======
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_video->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $latest_video->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_video->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $latest_video->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_video->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_video->year }}
                                                        </span>
                                                    @endif
                                                </div>
>>>>>>> f2a36f70e83e7db09ebfe4532d2bc450c57605a8

                                                <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                    @php
                                                        $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id',$latest_video->id)
                                                                    ->pluck('video_categories.name');        
                                                    @endphp

                                                    @if( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) 
                                                        <span class="text-white">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                @php
                                                                    $Category_Thumbnail = array();
                                                                        foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                                        $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                                        }
                                                                    echo implode(','.' ', $Category_Thumbnail);
                                                                @endphp
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</section>
@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp