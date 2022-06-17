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