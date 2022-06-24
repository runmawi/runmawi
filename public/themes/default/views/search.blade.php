@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites">
    <div class="container">

            {{-- Latest - Videos,Episode,livestream,audio --}}

        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Latest Search Result of "{{  $search_value }}"</h3>                     
                </div>
                
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($latest_videos)) 
                        @foreach($latest_videos as $latest_video_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($latest_video_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$latest_video_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($latest_video_search->global_ppv || !empty($latest_video_search->global_ppv) && $latest_video_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $latest_video_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($latest_video_search->global_ppv == null && $latest_video_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            
        
                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video_search->slug ?>">
                                                    <h6><?php  echo (strlen($latest_video_search->title) > 17) ? substr($latest_video_search->title,0,18).'...' : $latest_video_search->title; ?></h6>
                                                </a>
                                            @endif
        
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $latest_video_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif
        
                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $latest_video_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>
        
        
                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($latest_video_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($latest_video_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->featured == 1 &&  $latest_video_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
        
                                            <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                @php
                                                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id',$latest_video_search->id)
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
        
                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video_search->slug ?>">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                     @endif
        
                    {{-- Live stream --}}
                    @if(isset($latest_livestreams)) 
                        @foreach($latest_livestreams as $latest_live_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_live_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($latest_live_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$latest_live_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($latest_live_search->global_ppv || !empty($latest_live_search->global_ppv) && $latest_live_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $latest_live_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($latest_live_search->global_ppv == null && $latest_live_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            
        
                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{  URL::to('live') .'/' .$latest_live_search->slug }} ">
                                                    <h6><?php  echo (strlen($latest_live_search->title) > 17) ? substr($latest_live_search->title,0,18).'...' : $latest_live_search->title; ?></h6>
                                                </a>
                                            @endif
        
                                            <div class="movie-time d-flex align-items-center pt-1">
        
                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $latest_live_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>
        
        
                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($latest_live_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($latest_live_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->featured == 1 &&  $latest_live_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
        
                                            <div class="hover-buttons">
                                                <a  href="{{  URL::to('live') .'/' .$latest_live_search->slug }} ">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_live_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
        
                    {{-- Episode --}}
                    @if(isset($latest_Episode)) 
                        @foreach($latest_Episode as $latest_episode_search)
                            @php
                                $series_slug = App\Series::where('id',$latest_episode_search->series_id)->pluck('slug')->first();
                            @endphp
        
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($latest_episode_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$latest_episode_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($latest_episode_search->global_ppv || !empty($latest_episode_search->global_ppv) && $latest_episode_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $latest_episode_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($latest_episode_search->global_ppv == null && $latest_episode_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            
        
                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $latest_episode_search->slug }}">
                                                    <h6><?php  echo (strlen($latest_episode_search->title) > 17) ? substr($latest_episode_search->title,0,18).'...' : $latest_episode_search->title; ?></h6>
                                                </a>
                                            @endif
        
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $latest_episode_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif
        
                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $latest_episode_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>
        
        
                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($latest_episode_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($latest_episode_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif
        
                                                    @if($ThumbnailSetting->featured == 1 &&  $latest_episode_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
        
                                            <div class="hover-buttons">
                                                <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $latest_episode_search->slug }}" >	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_episode_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif

                    {{-- Series --}}

                    @if(isset($latest_Series)) 
                        @foreach($latest_Series as $latest_Series_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_Series_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                {{-- @if(!empty($latest_Series_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$latest_Series_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($latest_Series_search->global_ppv || !empty($latest_Series_search->global_ppv) && $latest_Series_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $latest_Series_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($latest_Series_search->global_ppv == null && $latest_Series_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif --}}
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{  URL::to('play_series') .'/' .$latest_Series_search->slug }} ">
                                                    <h6><?php  echo (strlen($latest_Series_search->title) > 17) ? substr($latest_Series_search->title,0,18).'...' : $latest_Series_search->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $latest_Series_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($latest_Series_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($latest_Series_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $latest_Series_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="{{  URL::to('play_series') .'/' .$latest_Series_search->slug }} ">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_Series_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
        
                    {{-- Audio --}}
                    @if(isset($latest_audio)) 
                    @foreach($latest_audio as $latest_audio_search)
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href=" {{ URL::to('home') }} ">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio_search->image;  ?>" class="img-fluid" alt="">
                                        
                                            @if(!empty($latest_audio_search->ppv_price))
                                                <p class="p-tag1" >
                                                    {{  $currency->symbol.' '.$latest_audio_search->ppv_price}}
                                                </p>
                                            @elseif( !empty($latest_audio_search->global_ppv || !empty($latest_audio_search->global_ppv) && $latest_audio_search->ppv_price == null))
                                                <p class="p-tag1">
                                                    {{ $latest_audio_search->global_ppv.' '.$currency->symbol }}
                                                </p>
                                            @elseif($latest_audio_search->global_ppv == null && $latest_audio_search->ppv_price == null )
                                                <p class="p-tag" > 
                                                    {{  "Free"}} 
                                                </p>
                                            @endif
                                    </div>
                        
        
                                    <div class="block-description" style="bottom:-38px!important;">
                                       
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                {{  $latest_audio_search->age_restrict.' '.'+' }}
                                                </div>
                                            @endif
        
                                            @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                                    {{ gmdate('H:i:s', $latest_audio_search->duration)}}
                                                </span>
                                            @endif
                                        </div>
        
        
                                        @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ ($latest_audio_search->rating)}}
                                                        </span>
                                                    </div>
                                                @endif
        
                                                @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ ($latest_audio_search->year) }}
                                                        </span>
                                                    </div>
                                                @endif
        
                                                @if($ThumbnailSetting->featured == 1 &&  $latest_audio_search->featured == 1)   <!-- Featured -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
        
                                        <div class="hover-buttons">
                                            <a  href="<?php echo URL::to('audio') ?><?= '/' . $latest_audio_search->slug ?>">		
                                                <span class="text-white">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ "Watch Now" }}
                                                </span>
                                            </a>
                                        <div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_audio_search->id;?>">
                                        <span class="text-center thumbarrow-sec"></span>
                                    </button>
                                </div> </div>   </div>
                            </a>
                        </li>
                    @endforeach
                @endif
        
                    </ul>
                </div>
            </div>
        </div>

            {{-- Highlighted  --}}

            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <h3 class="vid-title">Search Result of "{{  $search_value }}"</h3>                     
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                          @if(isset($Most_view_videos)) 
                            @foreach($Most_view_videos as $MV_video_search)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href=" {{ URL::to('home') }} ">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_video_search->image;  ?>" class="img-fluid" alt="">
                                                
                                                    @if(!empty($MV_video_search->ppv_price))
                                                        <p class="p-tag1" >
                                                            {{  $currency->symbol.' '.$MV_video_search->ppv_price}}
                                                        </p>
                                                    @elseif( !empty($MV_video_search->global_ppv || !empty($MV_video_search->global_ppv) && $MV_video_search->ppv_price == null))
                                                        <p class="p-tag1">
                                                            {{ $MV_video_search->global_ppv.' '.$currency->symbol }}
                                                        </p>
                                                    @elseif($MV_video_search->global_ppv == null && $MV_video_search->ppv_price == null )
                                                        <p class="p-tag" > 
                                                            {{  "Free"}} 
                                                        </p>
                                                    @endif
                                            </div>
                                
            
                                            <div class="block-description" style="bottom:-38px!important;">
                                                @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $MV_video_search->slug ?>">
                                                        <h6><?php  echo (strlen($MV_video_search->title) > 17) ? substr($MV_video_search->title,0,18).'...' : $MV_video_search->title; ?></h6>
                                                    </a>
                                                @endif
            
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                        {{  $MV_video_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
            
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $MV_video_search->duration)}}
                                                        </span>
                                                    @endif
                                                </div>
            
            
                                                @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ ($MV_video_search->rating)}}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ ($MV_video_search->year) }}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->featured == 1 &&  $MV_video_search->featured == 1)   <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
            
                                                <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                    @php
                                                        $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id',$MV_video_search->id)
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
            
                                                <div class="hover-buttons">
                                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $MV_video_search->slug ?>">	
                                                        <span class="text-white">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ "Watch Now" }}
                                                        </span>
                                                    </a>
                                                <div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $MV_video_search->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div> </div>   </div>
                                    </a>
                                </li>
                            @endforeach
                         @endif
            
                        {{-- Live stream --}}
                        @if(isset($Most_view_live)) 
                            @foreach($Most_view_live as $MV_live_search)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href=" {{ URL::to('home') }} ">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_live_search->image;  ?>" class="img-fluid" alt="">
                                                
                                                    @if(!empty($MV_live_search->ppv_price))
                                                        <p class="p-tag1" >
                                                            {{  $currency->symbol.' '.$MV_live_search->ppv_price}}
                                                        </p>
                                                    @elseif( !empty($MV_live_search->global_ppv || !empty($MV_live_search->global_ppv) && $MV_live_search->ppv_price == null))
                                                        <p class="p-tag1">
                                                            {{ $MV_live_search->global_ppv.' '.$currency->symbol }}
                                                        </p>
                                                    @elseif($MV_live_search->global_ppv == null && $MV_live_search->ppv_price == null )
                                                        <p class="p-tag" > 
                                                            {{  "Free"}} 
                                                        </p>
                                                    @endif
                                            </div>
                                
            
                                            <div class="block-description" style="bottom:-38px!important;">
                                                @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                    <a  href="{{  URL::to('live') .'/' .$MV_live_search->slug }} ">
                                                        <h6><?php  echo (strlen($MV_live_search->title) > 17) ? substr($MV_live_search->title,0,18).'...' : $MV_live_search->title; ?></h6>
                                                    </a>
                                                @endif
            
                                                <div class="movie-time d-flex align-items-center pt-1">
            
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $MV_live_search->duration)}}
                                                        </span>
                                                    @endif
                                                </div>
            
            
                                                @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ ($MV_live_search->rating)}}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ ($MV_live_search->year) }}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->featured == 1 &&  $MV_live_search->featured == 1)   <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
            
                                                <div class="hover-buttons">
                                                    <a  href="{{  URL::to('live') .'/' .$MV_live_search->slug }} ">	
                                                        <span class="text-white">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ "Watch Now" }}
                                                        </span>
                                                    </a>
                                                <div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $MV_live_search->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div> </div>   </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
            
                        {{-- Episode --}}
                        @if(isset($Most_view_episode)) 
                            @foreach($Most_view_episode as $MV_episode_search)
                                @php
                                    $series_slug = App\Series::where('id',$MV_episode_search->series_id)->pluck('slug')->first();
                                @endphp
            
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href=" {{ URL::to('home') }} ">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_episode_search->image;  ?>" class="img-fluid" alt="">
                                                
                                                    @if(!empty($MV_episode_search->ppv_price))
                                                        <p class="p-tag1" >
                                                            {{  $currency->symbol.' '.$MV_episode_search->ppv_price}}
                                                        </p>
                                                    @elseif( !empty($MV_episode_search->global_ppv || !empty($MV_episode_search->global_ppv) && $MV_episode_search->ppv_price == null))
                                                        <p class="p-tag1">
                                                            {{ $MV_episode_search->global_ppv.' '.$currency->symbol }}
                                                        </p>
                                                    @elseif($MV_episode_search->global_ppv == null && $MV_episode_search->ppv_price == null )
                                                        <p class="p-tag" > 
                                                            {{  "Free"}} 
                                                        </p>
                                                    @endif
                                            </div>
                                
            
                                            <div class="block-description" style="bottom:-38px!important;">
                                                @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                    <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $MV_episode_search->slug }}">
                                                        <h6><?php  echo (strlen($MV_episode_search->title) > 17) ? substr($MV_episode_search->title,0,18).'...' : $MV_episode_search->title; ?></h6>
                                                    </a>
                                                @endif
            
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                        {{  $MV_episode_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
            
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $MV_episode_search->duration)}}
                                                        </span>
                                                    @endif
                                                </div>
            
            
                                                @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ ($MV_episode_search->rating)}}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ ($MV_episode_search->year) }}
                                                                </span>
                                                            </div>
                                                        @endif
            
                                                        @if($ThumbnailSetting->featured == 1 &&  $MV_episode_search->featured == 1)   <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
            
                                                <div class="hover-buttons">
                                                    <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $MV_episode_search->slug }}" >	
                                                        <span class="text-white">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ "Watch Now" }}
                                                        </span>
                                                    </a>
                                                <div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $MV_episode_search->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div> </div>   </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif

                        {{-- Series--}}
                        @if(isset($Most_view_Series)) 
                            @foreach($Most_view_Series as $Mv_series_search)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href=" {{ URL::to('home') }} ">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Mv_series_search->image;  ?>" class="img-fluid" alt="">
                                                
                                                    {{-- @if(!empty($Mv_series_search->ppv_price))
                                                        <p class="p-tag1" >
                                                            {{  $currency->symbol.' '.$Mv_series_search->ppv_price}}
                                                        </p>
                                                    @elseif( !empty($Mv_series_search->global_ppv || !empty($Mv_series_search->global_ppv) && $Mv_series_search->ppv_price == null))
                                                        <p class="p-tag1">
                                                            {{ $Mv_series_search->global_ppv.' '.$currency->symbol }}
                                                        </p>
                                                    @elseif($Mv_series_search->global_ppv == null && $Mv_series_search->ppv_price == null )
                                                        <p class="p-tag" > 
                                                            {{  "Free"}} 
                                                        </p>
                                                    @endif --}}
                                            </div>
                                

                                            <div class="block-description" style="bottom:-38px!important;">
                                                @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                    <a  href="{{  URL::to('play_series') .'/' .$Mv_series_search->slug }} ">
                                                        <h6><?php  echo (strlen($Mv_series_search->title) > 17) ? substr($Mv_series_search->title,0,18).'...' : $Mv_series_search->title; ?></h6>
                                                    </a>
                                                @endif

                                                <div class="movie-time d-flex align-items-center pt-1">

                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $Mv_series_search->duration)}}
                                                        </span>
                                                    @endif
                                                </div>


                                                @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ ($Mv_series_search->rating)}}
                                                                </span>
                                                            </div>
                                                        @endif

                                                        @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ ($Mv_series_search->year) }}
                                                                </span>
                                                            </div>
                                                        @endif

                                                        @if($ThumbnailSetting->featured == 1 &&  $Mv_series_search->featured == 1)   <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="hover-buttons">
                                                    <a  href="{{  URL::to('play_series') .'/' .$Mv_series_search->slug }} ">	
                                                        <span class="text-white">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ "Watch Now" }}
                                                        </span>
                                                    </a>
                                                <div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $Mv_series_search->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div> </div>   </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif  
            
                        {{-- Audio --}}
                        @if(isset($Most_view_audios)) 
                        @foreach($Most_view_audios as $MV_audio_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_audio_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($MV_audio_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$MV_audio_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($MV_audio_search->global_ppv || !empty($MV_audio_search->global_ppv) && $MV_audio_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $MV_audio_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($MV_audio_search->global_ppv == null && $MV_audio_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            
            
                                        <div class="block-description" style="bottom:-38px!important;">
                                           
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $MV_audio_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif
            
                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $MV_audio_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>
            
            
                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($MV_audio_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif
            
                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($MV_audio_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif
            
                                                    @if($ThumbnailSetting->featured == 1 &&  $MV_audio_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
            
                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('audio') ?><?= '/' . $MV_audio_search->slug ?>">		
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $MV_audio_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
            
                        </ul>
                    </div>
                </div>
            </div>

            {{-- All videos - Videos,Episode,livestream,audio --}}
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Highlight Search Result of "{{  $search_value }}"</h3>                     
                </div>
                
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($videos)) 
                        @foreach($videos as $video_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($video_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$video_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($video_search->global_ppv || !empty($video_search->global_ppv) && $video_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $video_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($video_search->global_ppv == null && $video_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video_search->slug ?>">
                                                    <h6><?php  echo (strlen($video_search->title) > 17) ? substr($video_search->title,0,18).'...' : $video_search->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $video_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $video_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($video_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($video_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $video_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                @php
                                                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id',$video_search->id)
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

                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video_search->slug ?>">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $video_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                     @endif

                    {{-- Live stream --}}
                    @if(isset($livestreams)) 
                        @foreach($livestreams as $livestream_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($livestream_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$livestream_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($livestream_search->global_ppv || !empty($livestream_search->global_ppv) && $livestream_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $livestream_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($livestream_search->global_ppv == null && $livestream_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{  URL::to('live') .'/' .$livestream_search->slug }} ">
                                                    <h6><?php  echo (strlen($livestream_search->title) > 17) ? substr($livestream_search->title,0,18).'...' : $livestream_search->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $livestream_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($livestream_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($livestream_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $livestream_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="{{  URL::to('live') .'/' .$livestream_search->slug }} ">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $livestream_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif

                    {{-- Episode --}}
                    @if(isset($Episode)) 
                        @foreach($Episode as $episode_search)
                            @php
                                $series_slug = App\Series::where('id',$episode_search->series_id)->pluck('slug')->first();
                            @endphp

                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episode_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($episode_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$episode_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($episode_search->global_ppv || !empty($episode_search->global_ppv) && $episode_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $episode_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($episode_search->global_ppv == null && $episode_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}">
                                                    <h6><?php  echo (strlen($episode_search->title) > 17) ? substr($episode_search->title,0,18).'...' : $episode_search->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $episode_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $episode_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($episode_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($episode_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $episode_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}" >	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $episode_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif

                    {{-- Series --}}

                    @if(isset($Series)) 
                        @foreach($Series as $Series_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Series_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                {{-- @if(!empty($Series_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$Series_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($Series_search->global_ppv || !empty($Series_search->global_ppv) && $Series_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $Series_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($Series_search->global_ppv == null && $Series_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif --}}
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="{{  URL::to('play_series') .'/' .$Series_search->slug }} ">
                                                    <h6><?php  echo (strlen($Series_search->title) > 17) ? substr($Series_search->title,0,18).'...' : $Series_search->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $Series_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($Series_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($Series_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $Series_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="{{  URL::to('play_series') .'/' .$Series_search->slug }} ">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $Series_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
                                </a>
                            </li>
                        @endforeach
                    @endif

                    {{-- Audio --}}
                    @if(isset($audio)) 
                    @foreach($audio as $audio_search)
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href=" {{ URL::to('home') }} ">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio_search->image;  ?>" class="img-fluid" alt="">
                                        
                                            @if(!empty($audio_search->ppv_price))
                                                <p class="p-tag1" >
                                                    {{  $currency->symbol.' '.$audio_search->ppv_price}}
                                                </p>
                                            @elseif( !empty($audio_search->global_ppv || !empty($audio_search->global_ppv) && $audio_search->ppv_price == null))
                                                <p class="p-tag1">
                                                    {{ $audio_search->global_ppv.' '.$currency->symbol }}
                                                </p>
                                            @elseif($audio_search->global_ppv == null && $audio_search->ppv_price == null )
                                                <p class="p-tag" > 
                                                    {{  "Free"}} 
                                                </p>
                                            @endif
                                    </div>
                        

                                    <div class="block-description" style="bottom:-38px!important;">
                                       
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                {{  $audio_search->age_restrict.' '.'+' }}
                                                </div>
                                            @endif

                                            @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                                    {{ gmdate('H:i:s', $audio_search->duration)}}
                                                </span>
                                            @endif
                                        </div>


                                        @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ ($audio_search->rating)}}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ ($audio_search->year) }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->featured == 1 &&  $audio_search->featured == 1)   <!-- Featured -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="hover-buttons">
                                            <a  href="<?php echo URL::to('audio') ?><?= '/' . $audio_search->slug ?>">		
                                                <span class="text-white">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ "Watch Now" }}
                                                </span>
                                            </a>
                                        <div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $audio_search->id;?>">
                                        <span class="text-center thumbarrow-sec"></span>
                                    </button>
                                </div> </div>   </div>
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