@php
    include(public_path('themes/theme2/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">Search Result of "{{  $search_value }}" Videos</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">

              {{-- Latest - Videos,Episode,livestream,audio --}}
        <div class="row">
            <div class="col-sm-12 page-height">
        
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Showing Recent Videos for "{{  $search_value }}"</h3>                     
                </div>
        
                <div class="iq-main-header align-items-center justify-content-between"> </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($latest_videos)) 
                                @foreach($latest_videos as $latest_video_search)
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video_search->slug ?>">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_video_search->title) > 17) ? substr($latest_video_search->title,0,18).'...' : $latest_video_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_video_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_video_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $latest_video_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_video_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $latest_video_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_video_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_video_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
        
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
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
        
                            {{-- Live stream --}}
                            @if(isset($latest_livestreams)) 
                                @foreach($latest_livestreams as $latest_live_search)
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_live_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('live') .'/' .$latest_live_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_live_search->title) > 17) ? substr($latest_live_search->title,0,18).'...' : $latest_live_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_live_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_live_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $latest_live_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_live_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $latest_live_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_live_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_live_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
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
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $latest_episode_search->slug }}">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_episode_search->title) > 17) ? substr($latest_episode_search->title,0,18).'...' : $latest_episode_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_episode_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_episode_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $latest_episode_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_episode_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $latest_episode_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_episode_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_episode_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif


                            {{-- Series --}}
                            @if(isset($latest_Series)) 
                                @foreach($latest_Series as $latest_Series_search)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_Series_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('play_series') .'/' .$latest_Series_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>

                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_Series_search->title) > 17) ? substr($latest_Series_search->title,0,18).'...' : $latest_Series_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_Series_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_Series_search->duration)}}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->rating == 1 && $latest_Series_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_Series_search->rating }}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 && $latest_Series_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_Series_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_Series_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
        
                            {{-- Audios --}}
                            @if(isset($latest_audio)) 
                                @foreach($latest_audio as $latest_audio_search)
                                    @php
                                        $series_slug = App\Series::where('id',$latest_audio_search->series_id)->pluck('slug')->first();
                                    @endphp
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('audio') ?><?= '/' . $latest_audio_search->slug ?>" >
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($latest_audio_search->title) > 17) ? substr($latest_audio_search->title,0,18).'...' : $latest_audio_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $latest_audio_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_audio_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $latest_audio_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $latest_audio_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $latest_audio_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_audio_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $latest_audio_search->year }}
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

                {{-- Highlight - Videos,Episode,livestream,audio --}}
        <div class="row">
            <div class="col-sm-12 page-height">
        
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Showing Trending videos for "{{  $search_value }}"</h3>                     
                </div>
        
                <div class="iq-main-header align-items-center justify-content-between"> </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($Most_view_videos)) 
                                @foreach($Most_view_videos as $MV_video_search)
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_video_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $MV_video_search->slug ?>">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($MV_video_search->title) > 17) ? substr($MV_video_search->title,0,18).'...' : $MV_video_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $MV_video_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $MV_video_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $MV_video_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $MV_video_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $MV_video_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $MV_video_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $MV_video_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
        
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
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
        
                            {{-- Live stream --}}
                            @if(isset($Most_view_live)) 
                                @foreach($Most_view_live as $MV_live_search)
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_live_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('live') .'/' .$MV_live_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($MV_live_search->title) > 17) ? substr($MV_live_search->title,0,18).'...' : $MV_live_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $MV_live_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $MV_live_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $MV_live_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $MV_live_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $MV_live_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $MV_live_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $MV_live_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
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
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_episode_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $MV_episode_search->slug }}">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($MV_episode_search->title) > 17) ? substr($MV_episode_search->title,0,18).'...' : $MV_episode_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $MV_episode_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $MV_episode_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $MV_episode_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $MV_episode_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $MV_episode_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $MV_episode_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $MV_episode_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            {{-- Series --}}
                            
                            @if(isset($Most_view_Series)) 
                                @foreach($Most_view_Series as $Mv_series_search)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$Mv_series_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('play_series') .'/' .$Mv_series_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>

                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($Mv_series_search->title) > 17) ? substr($Mv_series_search->title,0,18).'...' : $Mv_series_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $Mv_series_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $Mv_series_search->duration)}}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->rating == 1 && $Mv_series_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $Mv_series_search->rating }}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 && $Mv_series_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $Mv_series_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $Mv_series_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
        
                            {{-- Audios --}}
                            @if(isset($Most_view_audios)) 
                                @foreach($Most_view_audios as $MV_audio_search)
                                    @php
                                        $series_slug = App\Series::where('id',$MV_audio_search->series_id)->pluck('slug')->first();
                                    @endphp
        
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$MV_audio_search->image;  ?>" class="img-fluid" alt="">
                                                </div>
        
                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('audio') ?><?= '/' . $MV_audio_search->slug ?>" >
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($MV_audio_search->title) > 17) ? substr($MV_audio_search->title,0,18).'...' : $MV_audio_search->title; ?></h6>
                                                    @endif
        
                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $MV_audio_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>
        
                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $MV_audio_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $MV_audio_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $MV_audio_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $MV_audio_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $MV_audio_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $MV_audio_search->year }}
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

            {{-- All Highlighted --}}
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title"> Showing Highlighted videos for "{{  $search_value }}"</h3>                     
                </div>

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

                            {{-- Live stream --}}
                            @if(isset($livestreams)) 
                                @foreach($livestreams as $livestream_search)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('live') .'/' .$livestream_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($livestream_search->title) > 17) ? substr($livestream_search->title,0,18).'...' : $livestream_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $livestream_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $livestream_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $livestream_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $livestream_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $livestream_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $livestream_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $livestream_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
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
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$episode_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($episode_search->title) > 17) ? substr($episode_search->title,0,18).'...' : $episode_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $episode_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $episode_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $episode_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $episode_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $episode_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $episode_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $episode_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            {{-- Series --}}

                            @if(isset($Series)) 
                                @foreach($Series as $Series_search)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$Series_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="{{  URL::to('play_series') .'/' .$Series_search->slug }} ">	
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>

                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($Series_search->title) > 17) ? substr($Series_search->title,0,18).'...' : $Series_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $Series_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $Series_search->duration)}}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->rating == 1 && $Series_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $Series_search->rating }}
                                                        </span>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 && $Series_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $Series_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $Series_search->year }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            {{-- Audios --}}
                            @if(isset($audio)) 
                                @foreach($audio as $audio_search)
                                    @php
                                        $series_slug = App\Series::where('id',$audio_search->series_id)->pluck('slug')->first();
                                    @endphp

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('home') ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$audio_search->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a  href="<?php echo URL::to('audio') ?><?= '/' . $audio_search->slug ?>" >
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if($ThumbnailSetting->title == 1) 
                                                        <h6><?php  echo (strlen($audio_search->title) > 17) ? substr($audio_search->title,0,18).'...' : $audio_search->title; ?></h6>
                                                    @endif

                                                    @if($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $audio_search->age_restrict.' '.'+' }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2"> 
                                                    @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                        <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $audio_search->duration)}}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->rating == 1 && $audio_search->rating != null)  <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $audio_search->rating }}
                                                        </span>
                                                    @endif
                            
                                                    @if($ThumbnailSetting->featured == 1 && $audio_search->featured == 1)  <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            
                                                <div class="movie-time my-2">                   
                                                    @if ( ($ThumbnailSetting->published_year == 1) && ( $audio_search->year != null ) )  <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $audio_search->year }}
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