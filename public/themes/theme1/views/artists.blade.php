@php
    include(public_path('themes/theme1/views/header.php'));
@endphp

<div class="main-content">
    <section id="iq-favorites">

        <h2 class="text-center  mb-3">{{ ucwords("artist videos ".$artist_name) }}</h2>

        <div class="container-fluid" style="background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);padding:0px 30px!important;">
           
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header align-items-center">      
                </div>

                <div class="favorites-contens">
                    <ul class="category-page list-inline  row p-0 mb-4">
                        @if(isset($artist_videos))  
                            @foreach($artist_videos  as $artist_video) 
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $artist_video->slug ?>">

                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_video->image;  ?>" class="img-fluid" alt="" width="">
                                            </div>
                                        </div>

                                        <div class="block-description" >
                                            <div class="hover-buttons">
                                                <a class="text-white btn-cl"  href="<?php echo URL::to('category') ?><?= '/videos/' . $artist_video->slug ?>">
                                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png';  ?>">                                        
                                                </a>
                                            </div>
                                            </div>
                                        <div>
                                          
                                        <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <h6>
                                                    <?php  echo (strlen($artist_video->title) > 17) ? substr($artist_video->title,0,18).'...' : $artist_video->title; ?>
                                                </h6>
                                            @endif
                    
                                            @if($ThumbnailSetting->age == 1)   <!-- Age -->
                                                <div class="badge badge-secondary"><?php echo $artist_video->age_restrict.' '.'+' ?></div>
                                            @endif
                                        </div>

                                        <div class="movie-time my-2">
                                                        <!-- Duration -->
                                            @if($ThumbnailSetting->duration == 1)   <!-- Duration -->
                                                <span class="text-white">
                                                    <i class="fa fa-clock-o"></i>
                                                    {{ gmdate('H:i:s', $artist_video->duration) }}
                                                </span>
                                            @endif
                                   
                                                        <!-- Rating -->
                                            @if($ThumbnailSetting->rating == 1 && $artist_video->rating != null) 
                                                <span class="text-white">
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    {{ ($artist_video->rating) }}
                                                </span>
                                            @endif  

                                                        <!-- Featured -->
                                            @if($ThumbnailSetting->featured == 1 && $artist_video->featured == 1) 
                                                <span class="text-white">
                                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="movie-time my-2">
                                                        <!-- published_year -->
                                            @if( ($ThumbnailSetting->published_year == 1) && ( $artist_video->year != null ) ) 
                                                <span class="text-white">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ $artist_video->year }}
                                                    </span>
                                            @endif
                                        </div>

                                        <div class="movie-time my-2">
                                            <!-- Category Thumbnail  setting -->
                                            @php
                                                $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id',$artist_video->video_id)
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
                        @else
                                       
                            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                               <p>
                                    <h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
                               </p>
                            </div>
                        @endif
                    
                                    
                    </ul>   
                </div>        
            </div>
        </div>
        </div>      
    </section>
</div>


@php
    include(public_path('themes/theme1/views/footer.blade.php'));
@endphp
    

