@php 
     include public_path('themes/theme3/views/header.php'); 
@endphp

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme3/assets/css/video-js/video-details.css') }}">


    {{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>


    <style>
        #my-video_ima-ad-container div{ overflow:hidden;}
        #my-video{ position:relative; }
        .staticback-btn{display:none;}
        .container-fluid:hover .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 32%; left:1%; color: white; border: none; cursor: pointer; }
        .vpageSection .backdrop-img {
            height: calc(100vh - 148px);
            overflow: hidden;
        }
        .col-lg-6.col-sm-6.col-12.vpageContent {
            padding: 2rem 0 0;
        }
        .desc {
            font-size: 16px;
            line-height: 30px;
            overflow-y: scroll;
            scrollbar-width: none;
            max-height: 230px;
        }
        a.btn.play-btn {
            border-radius: 35px !important;
            padding: 6px 27px;
            font-weight: bold;
            align-items: center;
            display: flex;
        }
        .btn.focus, .btn:focus{
            box-shadow:none;
        }
        a:hover {
            color: #fff;
        }
        a.btn.play-btn.pl-inf {
            background: transparent !important;
            border: 1px solid #fff !important;
        }
        a.btn.play-btn.pl-inf:hover{
            background-color: #d30abe !important;
            border: 1px solid #d30abe !important;
        }
        .text-white{
            color:#fff !important;
        }
        @media (max-width:660px){
            .desc{
                font-size: 15px;
                line-height: 27px;
            }
        }
        @media (max-width:470px){
            .desc{
                font-size: 14px;
                line-height: 25px;
            }
        }
        @media (max-width:320px){
            .desc{
                font-size: 13px;
                line-height: 23px;
            }
            a.btn.play-btn{
                padding: 6px 17px;
            }
        }

    </style>


{{-- Message Note --}}

<div id="message-note" ></div>

{{-- Section content --}}




    <div class="container-fluid p-0">

        @if ( $videodetail->type == "embed" )

            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>

            <video id="my-video" class="video-js vjs-theme-fantasy vjs-icon-hd vjs-layout-x-large" controls 
                    preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    muted="muted" preload="yes" autoplay="autoplay"  >
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
            </video>
        @endif
    </div>



<section class="contents-section">

<div class="container-fluid g-border">
    <div class="row align-items-center">
        <div class="col-sm-8 col-md-8 col-xs-12">
            <h1 class="text-white mb-3">{{ \Illuminate\Support\Str::limit($videodetail->title,45) }}</h1>

            <!-- Year, Running time, Age -->
            <?php
                if (!empty($video->duration)) {
                    $seconds = $video->duration;
                    $H = floor($seconds / 3600);
                    $i = ($seconds / 60) % 60;
                    $s = $seconds % 60;
                    $time = sprintf('%02dh %02dm', $H, $i);
                } else {
                    $time = 'Not Defined';
                }
                //  dd($time);
            ?>
            <div class="d-flex align-items-center text-white text-detail">
                <?php if (!empty($video->age_restrict)) { ?><span
                        class="badge  p-3"><?php echo __($video->age_restrict) . ' ' . '+'; ?></span><?php } ?>
                <?php if (!empty($time)) { ?><span class=""><?php echo $time; ?></span><?php } ?>
                <?php if (!empty($video->year)) { ?><span class="trending-year"><?php if ($video->year == 0) {
                        echo '';
                    } else {
                        echo $video->year;
                    } ?></span><?php } ?>

            </div>

            <?php if (!Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                            <!-- Watchlater -->
                            <li><span
                                    class="watchlater <?php if (isset($watchlatered->id)): ?>active<?php endif; ?>"
                                    data-authenticated="<?= !Auth::guest() ?>"
                                    data-videoid="<?= $video->id ?>"><i <?php if (isset($watchlatered->id)): ?> class="ri-add-circle-fill"
                                        <?php else: ?> class="ri-add-circle-line" <?php endif; ?>></i></span></li>
                            <!-- Wishlist -->
                            <li><span
                                    class="mywishlist <?php if (isset($mywishlisted->id)): ?>active<?php endif; ?>"
                                    data-authenticated="<?= !Auth::guest() ?>"
                                    data-videoid="<?= $video->id ?>"><i <?php if (isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line" <?php endif; ?>></i></span>
                            </li>
                            <!-- Social Share, Like Dislike -->
                          
                            @php
                                //include public_path('themes\theme3\views\partials/social-share.php'); 
                            @endphp
                        </ul>
                    </div>

                    <div class="col-sm-6 col-md-6 col-xs-12 p-0">
                        <ul class="list-inline p-0 mt-4 rental-lists ">
                            <!-- Subscribe -->
                            <li>
                                <?php
                                $user = Auth::user();
                                if (($user->role != "subscriber" && $video->access != 'guest' && $user->role != "admin")) { ?>
                                    <a href="<?php echo URL::to('/becomesubscriber'); ?>"><span
                                            class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?>
                                        </span></a>
                                <?php } ?>
                            </li>
                            <!-- PPV button -->
                            <li>
                                <?php //if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin" || ($user->role="subscriber" && $video->global_ppv == 1 ))  ) {
                                    ?>
                                <?php if (@$ppv_exist == 0 && $video->global_ppv != null && $user->role != "admin" || @$ppv_exist == 0 && $video->ppv_price != null && $user->role != "admin") { ?>

                                    <!-- && ($video->global_ppv == 1 ) -->
                                    <button data-toggle="modal" data-target="#exampleModalCenter"
                                        class="view-count btn btn-primary rent-video">
                                        <?php echo __('Purchase Now'); ?> </button>
                                <?php } ?>
                            </li>
                            <li>
                            </li>
                        </ul>
                    </div>
                </div>

            <?php } ?>


            <!-- Trailer  -->

            <div class="col-sm-4 col-12 p-0 mt-5">
                <div>
                    <?php if ($video->trailer != '' && $ThumbnailSetting->trailer == 1) { ?>

                        <div class="img__wrap">
                            <img class="img__img "
                                src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->player_image; ?>"
                                class="img-fluid" alt="" height="200" width="300">
                            <div class="img__description_layer">
                                <a data-video="<?php echo $video->trailer; ?>" data-toggle="modal"
                                    data-target="#videoModal" data-backdrop="static"
                                    data-keyboard="false">
                                    <p class="img__description">
                                        <h6 class="text-center">
                                            <?php echo strlen($video->title) > 50 ? substr($video->title, 0, 51) . '...' : $video->title; ?>
                                        </h6>

                                        <div class="movie-time  align-items-center my-2">
                                            <p class="text-center">
                                                <?php echo strlen($video->trailer_description) > 60 ? substr($video->trailer_description, 0, 61) . '...' : $video->trailer_description; ?>
                                            </p>
                                        </div>

                                        <div class="hover-buttons text-center">
                                            <a data-video="<?php echo $video->trailer; ?>"
                                                data-toggle="modal" data-target="#videoModal"
                                                data-backdrop="static" data-keyboard="false">
                                                <span class="text-white">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    Play Now
                                                </span>
                                            </a>
                                        </div>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //dd($video->trailer_type);
                    ?>
                <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background-color: transparent;border:none;">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div class="modal-body">

                                <?php if ($video->trailer_type != null && $video->trailer_type == "video_mp4" || $video->trailer_type == "mp4_url") { ?>

                                    <video id="videoPlayer1" class=""
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                        controls
                                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                        type="video/mp4" src="<?php echo $video->trailer; ?>">
                                    </video>
                                <?php } elseif ($video->trailer_type != null && $video->trailer_type == "m3u8") { ?>

                                    <video id="videos" class=""
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                        controls
                                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                        type="application/x-mpegURL">
                                        <source type="application/x-mpegURL"
                                            src="<?php echo $video->trailer; ?>">
                                    </video>

                                <?php } elseif ($video->trailer_type != null && $video->trailer_type == "m3u8_url") { ?>

                                    <video id="videoPlayer1" class=""
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>"
                                        controls
                                        data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'
                                        type="application/x-mpegURL">
                                    </video>

                                <?php } elseif ($video->trailer_type != null && $video->trailer_type == "embed_url") { ?>

                                    <div id="videoPlayer1" class=""
                                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>">
                                        <iframe src="<?php echo $video->trailer; ?>" allowfullscreen
                                            allowtransparency allow="<?= $autoplay ?>">
                                        </iframe>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <!-- Trailer End  -->

            @if (!empty($videodetail->description))
                <h4 class="mt-3">Description</h4>
                <p class="trending-dec w-100 mb-0 text-white mt-2 text-justify">
                @php
                    $description = $videodetail->description;

                    if (strlen($description) > 990) {
                        $shortDescriptionFirst = htmlspecialchars_decode(substr($description, 0, 990), ENT_QUOTES);
                        $shortDescription = htmlspecialchars(strip_tags($shortDescriptionFirst), ENT_QUOTES, 'UTF-8');
                        $fullDescription = htmlspecialchars_decode($description, ENT_QUOTES);
                    }
                @endphp

                @if (strlen($description) > 990)
                    <p id="artistDescription" style="color:#fff !important;">{{ $shortDescription }}... <a href="javascript:void(0);" class="text-primary" onclick="toggleDescription()">See More</a></p>
                    <div id="fullDescription" style="display:none;">{!! $fullDescription !!} <a href="javascript:void(0);" class="text-primary" onclick="toggleDescription()">See Less</a></div>
                @else
                    <p id="artistDescription">{{ $description }}</p>
                @endif

                </p>
            @endif

            <!-- Artists -->
                @if (!empty($artists))
                    <p class="trending-dec w-100 mb-0 text-white mt-2">Starring :
                        <?php
                        $numartists = count($artists);
                        $k = 0;

                        foreach ($artists as $key => $artist) { ?>
                            <a
                                href="<?php echo __(URL::to('/artist') . '/' . $artist->artist_slug); ?>">
                                <span class="sta">
                                    <?php echo $artist->artist_slug;
                                    if (++$k === $numartists) {
                                        echo '';
                                    } else {
                                        echo ',';
                                    }
                                    ?>
                                </span>
                            </a>
                        <?php } ?>
                    </p>
                @endif

                <!-- Genres -->
                <?php if ($settings->show_genre == 1): ?>
                    <p class="trending-dec w-100 mb-0 text-white mt-2">Genres :
                        <?php
                        $numItems = count(@$category_name);
                        $i = 0;

                        foreach (@$category_name as $key => $cat_name) { ?>
                            <a
                                href="<?php echo URL::to('/category' . '/' . $cat_name->categories_slug); ?>">
                                <span class="sta">
                                    <?php echo $cat_name->categories_name;
                                    if (++$i === $numItems) {
                                        echo '';
                                    } else {
                                        echo ',';
                                    } ?>
                                </span>
                            </a>
                        <?php } ?>
                    </p>
                <?php endif; ?>

                <!-- Languages -->
                <?php if ($settings->show_languages == 1): ?>
                    <p class="trending-dec w-100 mb-0 text-white mt-2">This Movie is :
                        <?php
                        $numItems = count($Movie_name);
                        $i = 0;

                        foreach ($Movie_name as $key => $Movie) { ?>
                            <a
                                href="<?php echo URL::to('/language' . '/' . $Movie->id . '/' . $Movie->movie_name); ?>">
                                <span class="sta">
                                    <?php echo $Movie->movie_name;
                                    if (++$i === $numItems) {
                                        echo '';
                                    } else {
                                        echo ',';
                                    } ?>
                                </span>
                            </a>
                        <?php } ?>
                    </p>
                <?php endif; ?>

                <!-- subtitles -->
                <?php if ($settings->show_subtitle == 1): ?>
                    <p class="trending-dec w-100 mb-0 text-white mt-2">Subtitles :
                        <?php echo $subtitles_name; ?>
                    </p>
                <?php endif; ?>

        </div>
            

    </div>

</div>



    <div class="vpageSection">
        

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

        <!-- Broadcast  -->

        <div class="container-fluid sectionArtists broadcast">   

            @if( optional($videodetail)->trailer_videos_url )
                <div class="artistHeading">
                    {{ ucwords('Promos & Resources ') }}
                </div>
            @endif
                    
            <div class="listItems">

                @if( optional($videodetail)->trailer_videos_url )
                    <a>
                        <div class="listItem" data-toggle="modal" data-target="#video-js-trailer-modal" >
                            <div class="profileImg">
                                <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                    <img src="{{ optional($videodetail)->image_url }}">
                                </span>

                                @php include public_path('themes/theme6/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                            </div>
                            
                            <div class="name titleoverflow"> {{ strlen($videodetail->title) > 20 ? substr($videodetail->title, 0, 21) . '...' : $videodetail->title }}  <span class="traileroverflow"> Trailer</span></div>
                        </div>
                    </a>
                @endif

                @if(  $videodetail->Reels_videos->isNotEmpty() )            {{-- E-Paper --}}
                                                        
                    @php  include public_path('themes/theme6/views/video-js-Player/video/Reels-videos.blade.php'); @endphp
                
                @endif

                @if( optional($videodetail)->pdf_files )            {{-- E-Paper --}}
                    <div class="listItem">
                        <div class="profileImg">
                            <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                <a href="{{ $videodetail->pdf_files_url }}" style="font-size:93px; color: #a51212 !important;" class="fa fa-file-pdf-o " download></a>
                            </span>
                        </div>
                        <div class="name">Document</div>
                    </div>
                @endif
                    
            </div>
                
        </div>

        {{-- comment Section --}}

        @if( $CommentSection != null && $CommentSection->videos == 1 )
            <div class="sectionArtists container-fluid">   
                <div class="artistHeading"> Comments </div>
                    <div class="overflow-hidden">
                        @php include public_path('themes/theme3/views/comments/index.blade.php') @endphp
                    </div>
            </div>
        @endif

        <div class="rec-video col mt-5 p-0">
            {{-- Recommended videos Section --}}

            @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                <div class=" container-fluid video-list  overflow-hidden">

                    <h4 class="iq-main-header d-flex align-items-center justify-content-between" style="color:#fffff;">{{ ucwords('recommended videos') }}</h4> 

                    <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>

                        <div class="favorites-contens">

                            <ul class="favorites-slider list-inline  row p-0 mb-0">

                                @foreach ( $videodetail->recommended_videos as $recommended_video)
                                
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <!-- block-images -->
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                        <img loading="lazy" class="img-fluid loading w-100" data-src="{{ URL::to('/public/uploads/images/' . $recommended_video->image) }}">
                                                    </a>
                                                </div>
                                            </div>
                                                    
                                            <div class="block-description">
                                                
                                            <div class="hover-buttons">
                                                        <a class="" href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                <span class="text pr-2"> Play </span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </div>
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
    </div>
</section>

<script>
    function toggleDescription() {

        var shortDesc = document.getElementById('artistDescription');
        var fullDesc = document.getElementById('fullDescription');

        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'block';
            fullDesc.style.display = 'none';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
        }
    }
</script>

<script>
    

    $(document).ready(function() {
      
        $(".left").hide();

        $("#moreInfoBtn").click(function() {
          
            $(".left").toggle();
           
            var buttonText = $(".left").is(":visible") ? "Less information" : "More information";
            
            $("#moreInfoBtn span").text(buttonText);
        });
    });
</script>

@php 
    //include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-file.blade.php');
    //include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-stripe.blade.php');
    //include public_path('themes/theme3/views/footer.blade.php'); 
@endphp
@php 

    include public_path('themes/theme3/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/theme3/views/footer.blade.php'); 

@endphp