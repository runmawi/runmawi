@php  include public_path('themes/theme3/views/header.php'); @endphp

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme3/assets/css/video-js/video-details.css') }}">

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    {{-- <link href="{{ asset('public/themes/theme3/assets/css/video-js/videos-player.css') }}" rel="stylesheet" > --}}

{{-- video-js Script --}}

    <script src="{{ asset('public/themes/theme3/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

    <style>
        .vpageSection .backdrop-img {
            height: calc(100vh - 148px);
            overflow: hidden;
        }
        .col-lg-6.col-sm-6.col-12.vpageContent {
            padding: 2rem 0 0;
        }
        .share-icons.music-play-lists li{
            background:transparent;
        }
        .desc {
            font-size: 16px;
            line-height: 30px;
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

{{-- Section content --}}

<section>
    <div class="vpageSection">
        <div class="backdrop-img" style="background-image: linear-gradient(90deg, rgba(20, 20, 20, 1) 0%, rgba(36, 36, 36, 1) 35%, rgba(83, 100, 141, 0) 100%),
        url('{{ optional($videodetail)->player_image_url }}');background-size:cover;background-repeat:no-repeat;">  {{-- Background image --}}
            <div class="col-lg-6 col-sm-6 col-12 vpageContent">
                <div class="container-fluid">
                    <h2 style="color:#fff !important;">
                        {{ strlen($videodetail->title) > 40 ? substr($videodetail->title, 0, 40) . '...' : $videodetail->title }}
                    </h2>
                    <div class="like-dislike">
                        <ul class="list-inline p-0 share-icons music-play-lists align-items-center">
                            <li>
                                <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                                    <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                                </span>
                            </li>

                            <!-- Dislike -->
                            <li>
                                <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                                    <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                                </span>
                            </li>
                            <li>
                                <span class="d-flex">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </span>
                            </li>
                            <span class="m-0">
                            {{ $videodetail->duration != null ? gmdate('H:i:s', $videodetail->duration)  : null  }} 
                            </span>
                        </ul>
                        <div class="desc">
                        <?php
                            $description = $videodetail->description;

                            if (strlen($description) > 300) {
                                $shortDescription = htmlspecialchars(substr($description, 0, 200), ENT_QUOTES, 'UTF-8');
                                $fullDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

                                echo "<p id='artistDescription'  style='color:#fff !important;'>$shortDescription... <a href='javascript:void(0);' class='text-primary' onclick='toggleDescription()'>See More</a></p>";
                                echo "<div id='fullDescription' style='display:none;'>$fullDescription <a href='javascript:void(0);' class='text-primary' onclick='toggleDescription()'>See Less</a></div>";
                            } else {
                                echo "<p id='artistDescription'>$description</p>";
                            }
                        ?>
                        </div>
                    </div>
                    <div class="left mb-4">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                            <img class="posterImg" src="{{ $videodetail->image_url }}" style="width:70%;">
                        </span>
                    </div>
                    <div class="d-flex" style="gap:20px;">
                        <a class="btn play-btn pl-inf" href="{{ route('video-js-fullplayer',[ optional($videodetail)->slug ])}}">
                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                            <span class="text pr-2"> Play </span>
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                </svg>
                            </div>
                        </a>
                        <a class="btn play-btn pl-inf" id="moreInfoBtn">
                            <span>More information</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rec-video col mt-5">
        {{-- Recommended videos Section --}}

        @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

            <div class=" container-fluid video-list  overflow-hidden pl-0">

                <h4 class="Continue Watching" style="color:#fffff;">{{ ucwords('recommended videos') }}</h4> 

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
        // Hide the "left" class on window load
        $(".left").hide();

        // Handle click on "More information" button
        $("#moreInfoBtn").click(function() {
            // Toggle the visibility of the "left" class
            $(".left").toggle();

            // Change the text of the button based on visibility
            var buttonText = $(".left").is(":visible") ? "Less information" : "More information";
            $("#moreInfoBtn span").text(buttonText);
        });
    });
</script>


    

@php 
    include public_path('themes/theme3/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/theme3/views/footer.blade.php'); 
@endphp