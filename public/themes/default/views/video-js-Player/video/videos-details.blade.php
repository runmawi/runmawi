import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css';

@php  include public_path('themes/default/views/header.php'); @endphp

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/default/assets/css/video-js/video-details.css') }}">

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    {{-- <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" > --}}

{{-- video-js Script --}}

    <script src="{{ asset('public/themes/default/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/default/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

{{-- Section content --}}

    <div class="vpageBanner">
        <div class="backdrop-img">    {{-- Background image --}}
            <span class=" lazy-load-image-background blur lazy-load-image-loaded"  style="color: transparent; display: inline-block;">
                <img src="{{ optional($videodetail)->player_image_url }}">
            </span>
        </div>

        <div class="opacity-layer"></div>

                {{-- Message Note --}}
        <div id="message-note" ></div>

        <div class="pageWrapper">
                
                            {{-- Breadcrumbs  --}}
            <div class="scp-breadcrumb">
                <ul class="breadcrumb">
                
                    <li><a href="{{ route('latest-videos') }}">{{ ucwords('videos') }}</a> <i class="fa fa-angle-right mx-2" aria-hidden="true"></i> </li>
                
                    @foreach( $videodetail->categories as $key => $category )

                        <li class="breadcrumb-item"> <a href="{{ route('video_categories',[ $category->slug ]) }}">{{ $category->name }}</a> </li>

                    @endforeach
                    
                    <li> <i class="fa fa-angle-right mx-2" aria-hidden="true"></i> </li>
                
                    <li class="active">{{ (strlen($videodetail->title) > 50) ? ucwords(substr($videodetail->title,0,120).'...') : ucwords($videodetail->title) }}</li>
                
                </ul>
            </div>

            <div class="content">
                <div class="left">
                    <span class=" lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                        <img class="posterImg"  src="{{ $videodetail->image_url }}" >
                    </span>
                </div>

                <div class="right">
                    <div class="title">    {{--  Title & Year--}}
                        {{ optional($videodetail)->title }} 
                    </div>

                    <div class="utilities d-flex align-items-center">  
                        {{ optional($videodetail)->year }} 
                        <i class="fas fa-circle"></i>

                        {{ $videodetail->duration != null ? gmdate('H:i:s', $videodetail->duration)  : null  }} 
                        <i class="fas fa-circle"></i> 

                        {{ optional($videodetail)->age_restrict }}
                        <i class="fas fa-circle"></i> 
                        
                        <?php if(isset($view_increment) && $view_increment == true ): ?>
                            <?= $movie->views + 1 ?>
                        <?php else: ?>
                            <?= $videodetail->views ?>
                        <?php endif; ?>
                        <?php echo __('Views'); ?>
                    </div>
                   
                    @if ( $setting->show_Links_and_details == 1 &&  optional($videodetail)->details )  {{-- Details --}}
                        <div class="subtitle">  
                            {!! html_entity_decode(optional($videodetail)->details) !!}
                        </div>
                    @endif

                    @if ($setting->show_genre == 1 && !$videodetail->categories->isEmpty() )        {{-- categories --}}
                        <div class="genres">  
                            @foreach ( $videodetail->categories as $item )
                                <div class="genre">
                                    <a href="{{ route('video_categories',[ $item->slug ]) }}"> {{ $item->name }} </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <ul class="list-inline p-0 share-icons music-play-lists">
                                        <!-- Watchlater -->
                                <li>
                                    <span data-video-id={{ $videodetail->id }} onclick="video_watchlater(this)" >
                                        <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
                                    </span>
                                </li>

                                        <!-- Wishlist -->
                                <li>
                                    <span data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                                        <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'fa fa-heart' : 'fa fa-heart-o'  }}"></i>
                                    </span>
                                </li>

                                <!-- Like -->
                                <li>
                                    <span><i  <?php if((isset($like_dislike[0]) && $like_dislike[0]->liked == 1 )): ?> class="ri-thumb-up-fill" <?php else: ?> class="ri-thumb-up-line" <?php endif; ?> <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'active';}?> aria-hidden="true" style="cursor:pointer;" data-like-val="1" like="1" id="like"  ></i></span>
                                </li>

                                <!-- Dislike -->
                                <li>
                                    <span><i <?php if((isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 )): ?> class="ri-thumb-down-fill" <?php else: ?> class="ri-thumb-down-line" <?php endif; ?>  class="ri-thumb-down-line <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" dislike="1"  id="dislike"></i></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">  
                    <a class="btn" href="{{ route('video-js-fullplayer',[ optional($videodetail)->slug ])}}">
                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                </svg>
                                <span class="text pr-2"> Watch Now </span>
                            </div>
                        </a>

                        @php include public_path('themes/default/views/partials/social-share.php'); @endphp  
                        
                       
                        @if( optional($videodetail)->trailer_videos_url )
                        <ul class="list-inline p-0 m-0 share-icons music-play-lists">
                                <li class="share">
                                    <span  data-toggle="modal" data-target="#video-js-trailer-modal">   {{-- Trailer --}}
                                        <i class="fal fa-play"></i></span>
                                    <div class="share-box box-watchtrailer">
                                    <div class="playbtn"  data-toggle="modal" data-target="#video-js-trailer-modal">     {{-- Trailer --}}
                               
                                        <span class="text" style="background-color: transparent; font-size: 14px; width:84px">Watch Trailer</span>
                                    </div>
                                    </div>
                                </li>

                        </ul>
                         @php include public_path('themes/default/views/video-js-Player/video/videos-trailer.blade.php'); @endphp    
                        @endif
                        
                        
                        <div class="circleRating">  {{-- Rating --}}
                            <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar" style="width:63px">
                                <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                                <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                                <text class="CircularProgressbar-text" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                            </svg>
                        </div>

                        @if( optional($videodetail)->trailer_videos_url )
                            <div class="playbtn"  data-toggle="modal" data-target="#video-js-trailer-modal">     {{-- Trailer --}}
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
                                </svg>
                                <span class="text">Watch Trailer</span>
                            </div>

                            @php include public_path('themes/default/views/video-js-Player/video/videos-trailer.blade.php'); @endphp    
                        @endif
                        
                        

                        {{-- <?php   $user = Auth::user(); 
                                if (  ($user->role!="subscriber" && $videodetail->access != 'guest' && $user->role!="admin") ) { ?>
                                <a href="<?php echo URL::to('/becomesubscriber'); ?>">
                                    <span class="view-count btn btn-primary subsc-video">
                                        <?php echo __('Subscribe'); ?>
                                    </span>
                                </a>
                        <?php } ?>

                        <?php if (  $videodetail->global_ppv != null && $user->role!="admin" && $videodetail->ppv_price != null  && $user->role!="admin") { ?>
                            <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                                <?php echo __('Purchase Now'); ?> 
                            </button>
                        <?php } else { ?>
                            <a class="view-count btn btn-primary rent-video text-white" href="<?php echo URL::to('/login'); ?>">
                                <?php echo __('Rent'); ?>
                            </a>
                        <?php } ?> --}}
                    </div>

                    @if( $setting->show_description == 1 && optional($videodetail)->description )   {{-- Description --}}
                        <div class="overview">
                            <div class="heading">Description</div>
                            <div class="description">
                                {!!  html_entity_decode( optional($videodetail)->description ) !!}
                            </div>
                        </div>
                    @endif

                    <div class="info">       {{-- publish_status --}}
                        <div classname="infoItem">
                            <span classname="text bold">Status: </span>
                            <span class="text">{{ $videodetail->video_publish_status }}</span>
                        </div>
                    </div>


                    @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                        <div class="info">      
                            <span classname="text bold"> Languages:&nbsp;</span> 
                            @foreach( $videodetail->Language as $item )
                                <span class="text">
                                    <span><a href="{{ URL::to('language/'. $item->language_id . '/' . $item->name ) }} "> {{ $item->name }} </a>   </span>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    @if( optional($videodetail)->pdf_files )            {{-- E-Paper --}}
                        <div class="info">      
                            <span classname="text bold"> E-Paper : </span>
                            <span class="text">
                                <a href="{{ $videodetail->pdf_files_url }}" style="font-size:45px; color: #a51212 !important;" class="fa fa-file-pdf-o " download></a>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
    
            @if ($setting->show_artist == 1 && !$videodetail->artists->isEmpty() ) {{-- Artists --}}
                <div class="sectionArtists">   
                    <div class="artistHeading">Top Cast</div>
                    <div class="listItems">
                        @foreach ( $videodetail->artists as $item )
                            <a href="{{ route('artist',[ $item->artist_slug ])}}">
                                <div class="listItem">
                                    <div class="profileImg">
                                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                            <img  src="{{ URL::to('public/uploads/artists/'. $item->image ) }}" />
                                        </span>
                                    </div>
                                    <div class="name">{{ $item->artist_name }}</div>
                                    <div class="character">{{ str_replace('_', ' ', $item->artist_type) }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            

            {{-- comment Section --}}

            @if( $CommentSection != null && $CommentSection->videos == 1 )
                <div class="sectionArtists">   
                    <div class="artistHeading"> Comments </div>
                        <div class="overflow-hidden">
                            @php include public_path('themes/default/views/comments/index.blade.php') @endphp
                        </div>
                </div>
            @endif

                        {{-- Recommended videos Section --}}

            @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                <div class=" container-fluid video-list  overflow-hidden p-0">

                    <h4 class="Continue Watching" style="color:#fffff;">{{ ucwords('recommended videos') }}</h4> 

                    <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>

                        <div class="favorites-contens">

                            <ul class="favorites-slider list-inline  row p-0 mb-0">

                                @foreach ( $videodetail->recommended_videos as $recommended_video)
                                
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <a href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                <div class="img-box">
                                                    <img loading="lazy" class="img-fluid loading w-100" data-src="{{ URL::to('/public/uploads/images/' . $recommended_video->image) }}">
                                                    
                                                    @if ($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if ($recommended_video->access == 'subscriber')
                                                            <p class="p-tag"> <i style='color:gold' class="fas fa-crown"></i> </p>
                                                        @elseif($recommended_video->access == 'registered')
                                                            <p class="p-tag"> {{ 'Register Now' }} </p>
                                                        @elseif(!empty($recommended_video->ppv_price))
                                                            <p class="p-tag1"> {{ $currency->symbol . ' ' . $recommended_video->ppv_price }}  </p>
                                                        @elseif(!empty($recommended_video->global_ppv || (!empty($recommended_video->global_ppv) && $recommended_video->ppv_price == null)))
                                                            <p class="p-tag1"> {{ $recommended_video->global_ppv . ' ' . $currency->symbol }} </p>
                                                        @elseif($recommended_video->global_ppv == null && $recommended_video->ppv_price == null)
                                                            <p class="p-tag">{{ 'Free' }} </p>
                                                        @endif
                                                    @endif
        
                                                    @if ($ThumbnailSetting->published_on == 1)
                                                        <p class="published_on1">{{ $recommended_video->video_publish_status }} </p>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="block-description">
                                                <div class="hover-buttons">
                                                    <a href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                                                
                                                        @if ($ThumbnailSetting->title == 1)         <!-- Title -->
                                                            <p class="epi-name text-left m-0"> {{ strlen($recommended_video->title) > 20 ? substr($recommended_video->title, 0, 21) . '...' : $recommended_video->title }} </p>
                                                        @endif
        
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if ($ThumbnailSetting->rating == 1)         <!--Rating  -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white"> <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ $recommended_video->rating }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            <!-- Category Thumbnail  setting -->
                                                            <?php
                                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id', $recommended_video->id)
                                                                    ->pluck('video_categories.name');
                                                                ?>
                                                                <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                                                <span class="text-white">
                                                                    <?php
                                                                    $Category_Thumbnail = [];
                                                                    foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                        $Category_Thumbnail[] = $CategoryThumbnail;
                                                                    }
                                                                    echo implode(',' . ' ', $Category_Thumbnail);
                                                                    ?>
                                                                </span>
                                                                <?php } ?>
                                                        </div>
        
                                                        @if ($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->duration == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1 mb-3">

                                                                @if ($ThumbnailSetting->duration == 1)  <!-- Duration -->
                                                                    <span class="text-white">
                                                                        {{ gmdate('H:i:s', $recommended_video->duration) }}
                                                                    </span>
                                                                @endif 

                                                                @if ($ThumbnailSetting->age == 1)     <!-- Age -->
                                                                    <div class="badge badge-secondary p-1 mr-2"> {{ optional($recommended_video)->age_restrict . ' ' . '+' }}</div>
                                                                @endif

                                                                @if ($ThumbnailSetting->published_year == 1)   <!-- published_year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white"> <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ $recommended_video->year }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if ($ThumbnailSetting->featured == 1 && $recommended_video->featured == 1)  <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white"> <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <a class="epi-name text-white mb-0 btn btn-primary">Watch Now</a>

                                                        </div>
                                                    </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="videoPopup ">
            <div class="opacityLayer"></div>
            <div class="videoPlayer">
                <span class="closeBtn">Close</span>
                <div style="width: 100%; height: 100%;">
                    <!-- Placeholder for video player -->
                </div>
            </div>
        </div>
    </div>

@php 
    include public_path('themes/default/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/default/views/footer.blade.php'); 
@endphp