@php
    include(public_path('themes/theme3/views/header.php'));

@endphp

<section id="iq-favorites">
    <div class="container">

            {{-- Showing  videos--}}
        @if( count($all_videos) > 0 )
            <div class="row">

                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h3 class="vid-title"  > {{  __("Showing Videos for") }} "{{  $search_value }}"</h3>  
                            <h3 class="vid-title"> <a href="{{ route('searchResult_videos', $search_value) }}"> {{  __("view all") }} </a></h3> 
                        </div>                 
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($all_videos)) 
                                @foreach($all_videos as $video_search)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('category') . '/videos/' . $video_search->slug }}">
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
                                                                {{  __("Free")}} 
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
                                                                        {{ __("Watch Now") }}
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
                        </ul>
                    </div>
                </div>
            </div>
        @endif
                    {{-- Showing Episode  --}}
        @if( count($Search_Episode) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h3 class="vid-title"> {{  __("Showing  Episode for") }} "{{  $search_value }}"</h3>    
                            <h3 class="vid-title"> <a href="{{ route('searchResult_episode', $search_value) }}"> {{  __("view all") }} </a></h3> 
                        </div>                         
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                        
                        @if(isset($Search_Episode)) 
                            @foreach($Search_Episode as $episode_search)
                                @if( $episode_search->slug != null )
                                    @php
                                        $series_slug = App\Series::where('id',$episode_search->series_id)->pluck('slug')->first();
                                    @endphp
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}"> 
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
                                                                {{  __("Free")}} 
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
                                                                    {{ __("Watch Now") }}
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
                                @endif
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif

                    {{-- Showing Series  --}}
        @if( count($Search_Series) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h3 class="vid-title"> {{  __("Showing  Series for") }} "{{  $search_value }}"</h3>   
                            <h3 class="vid-title"> <a href="{{ route('searchResult_series', $search_value) }}">{{  __("view all") }}  </a></h3> 
                        </div>                     
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">

                        @if(isset($Search_Series)) 
                            @foreach($Search_Series as $Series_search)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a  href="{{  URL::to('play_series') .'/' .$Series_search->slug }} ">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Series_search->image;  ?>" class="img-fluid" alt="">
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
                                                                {{ __("Watch Now") }}
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

                        </ul>
                    </div>
                </div>
            </div>
        @endif

                    {{-- Showing Live Stream  --}}
        @if( count($Search_livestreams) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h3 class="vid-title"> {{  __("Showing  Live Stream for") }} "{{  $search_value }}"</h3>  
                            <h3 class="vid-title"> <a href="{{ route('searchResult_livestream', $search_value) }}"> {{  __("view all") }} </a></h3> 
                        </div>                       
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                        
                        @if(isset($Search_livestreams)) 
                            @foreach($Search_livestreams as $livestream_search)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{  URL::to('live') .'/' .$livestream_search->slug }} ">	
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
                                                            {{  __("Free")}} 
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
                                                                {{ __("Watch Now") }}
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
                        </ul>
                    </div>
                </div>
            </div>
        @endif

                    {{-- Showing Audio --}}
        @if( count($Search_audio) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h3 class="vid-title"> {{ __("Showing  Audios for") }} "{{  $search_value }}"</h3>    
                            <h3 class="vid-title"> <a href="{{ route('searchResult_audios', $search_value) }}"> {{ __("view all") }} </a></h3> 
                        </div>                     
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                        
                        @if(isset($Search_audio)) 
                        @foreach($Search_audio as $audio_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{  URL::to('audio') .'/'.$audio_search->slug  }} ">

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
                                                        {{  __("Free")}} 
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
                                                            {{ __("Watch Now") }}
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
        @endif

    </div>
</section>

@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp