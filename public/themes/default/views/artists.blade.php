@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites">
    <div class="container-fluid">

        <div class="iq-main-header align-items-center">
            <h2 class="">{{ ucwords("artist videos ".$artist_name) }}</h2>
        </div>

        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        @if(isset($artist_videos)) 
                            @foreach($artist_videos as $key => $artists_videos)
                                <li class="slide-item">
                                        <a href="{{ URL::to('home') }} ">
                                            <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $artists_videos->slug ?>">
                                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artists_videos->image;  ?>" class="img-fluid loading w-100" alt=""> 
                                                        </a>
                    
                                                        <!-- PPV price -->   
                                                      
                                                            @if($ThumbnailSetting->free_or_cost_label == 1) 
                                                                
                                                                    @if(!empty($artists_videos->ppv_price))
                                                                        <p class="p-tag1">
                                                                            {{  $currency->symbol.' '.$artists_videos->ppv_price }}
                                                                        </p>
                                                                    @elseif( !empty($artists_videos->global_ppv || !empty($artists_videos->global_ppv) && $artists_videos->ppv_price == null))
                                                                        <p class="p-tag1">
                                                                            {{  $artists_videos->global_ppv.' '.$currency->symbol }}
                                                                        </p>
                                                                    @elseif($artists_videos->global_ppv == null && $artists_videos->ppv_price == null )
                                                                        <p class="p-tag">
                                                                        {{  "Free" }}
                                                                        </p>
                                                                @endif
                                                              
                                                            @endif
                                                       
                                                    </div>
                    
                                                    <div class="block-description">
                                                        @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $artists_videos->slug ?>">
                                                                <h6><?php  echo (strlen($artists_videos->title) > 17) ? substr($artists_videos->title,0,18).'...' : $artists_videos->title; ?></h6>
                                                            </a>
                                                        @endif
                    
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1)   <!-- Age -->
                                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $artists_videos->age_restrict.' '.'+' ?></div>
                                                            @endif
                        
                                                            @if($ThumbnailSetting->duration == 1)   <!-- Duration -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    <?= gmdate('H:i:s', $artists_videos->duration); ?>
                                                                </span>
                                                            @endif
                                                        </div>
                    
                                                        @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1))
                                                            <div class="movie-time d-flex align-items-center pt-1">

                                                                @if($ThumbnailSetting->rating == 1) <!--Rating  -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            <?php echo __($artists_videos->rating); ?>
                                                                        </span>
                                                                    </div>
                                                                @endif
                        
                                                                @if($ThumbnailSetting->published_year == 1) <!-- published_year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ $artists_videos->year  }}
                                                                    </span>
                                                                    </div>
                                                                @endif
                        
                                                                @if($ThumbnailSetting->featured == 1 && $artists_videos->featured == 1) <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif   
                    
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            <!-- Category Thumbnail  setting -->
                                                            @php
                                                            $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                        ->where('categoryvideos.video_id',$artists_videos->pre_video_id)
                                                                        ->pluck('video_categories.name');        
                                                            @endphp

                                                            @if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) 
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
                                                        
                                                        <div class="hover-buttons">
                                                            <a class="text-white d-flex align-items-center" href="<?php echo URL::to('category') ?><?= '/videos/' . $artists_videos->slug ?>" >
                                                                <img class="ply mr-1 " src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                                            </a>
                                                        </div>
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp