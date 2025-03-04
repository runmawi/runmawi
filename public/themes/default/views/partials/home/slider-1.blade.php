

<?php
    $play_button_svg = '
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1" />
            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
        </svg>';

    $front_end_logo = front_end_logo();
?>

{{-- Admin Slider  --}}
@if (!empty($sliders) && $sliders->isNotEmpty())
    @foreach ($sliders as $slider_video)
        <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/videocategory/' . $slider_video->slider) }}')">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px;">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <h2 class="text-white" style="color: var(--iq-white) !important;">
                                {{ $slider_video->title }}
                            </h2>
                            <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                                <a href="{{ $slider_video->link }}" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> {{ __('Play') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif



{{-- Video Banner --}}
@if (!empty($video_banners) && $video_banners->isNotEmpty())
    @foreach ($video_banners as $key => $videos)
        <div class="s-bg-1">test
            <div class="_banner_img">
                <img class="flickity-lazyloaded" data-flickity-lazyload="{{ URL::to('/public/uploads/images/' . $videos->player_image) }}" alt="{{ $videos->title }}" loading="eager" fetchpriority="high" >

                @if($settings->slider_trailer == 1 && !empty($videos->trailer))
                    <?php if (!empty($videos->trailer) && ($videos->trailer_type == 'video_mp4')): ?>
                        <video class="myvideos" loop autoplay muted onclick="window.location.href='{{ url('/category/videos/' . $videos->slug) }}'" src="<?php echo $videos->trailer; ?>" width="100%"
                            height="auto" alt="" style="transform: scale(1.27);object-fit:cover;cursor: pointer;"></video>
                        <div class="volume-icon-container">
                            <i class="fa fa-volume-off volume-icon" aria-hidden="true"></i>
                        </div>
                    <?php elseif (!empty($videos->trailer) && ($videos->trailer_type == 'm3u8')): ?>
                        <input type="hidden" class="trailer_type" value="<?= $videos->trailer_type ?>">
                        <video id="video-js-trailer-player-{{ $key }}" class="video-js myvideos" loop autoplay muted
                            onclick="window.location.href='{{ url('/category/videos/' . $videos->slug) }}'"
                            width="100%" height="auto" style="transform: scale(1.27);object-fit:cover;cursor: pointer;">
                            <source src="<?php echo $videos->trailer; ?>" type="application/x-mpegURL">
                        </video>
                        <div class="volume-icon-container">
                            <i class="fa fa-volume-off volume-icon" aria-hidden="true"></i>
                        </div>
                        <?php elseif (!empty($videos->trailer) && ($videos->trailer_type == 'm3u8_url')): ?>
                            <input type="hidden" class="trailer_type" value="<?= $videos->trailer_type ?>">
                            <video id="video-js-trailer-player-{{ $key }}" class="video-js myvideos" loop autoplay muted
                                onclick="window.location.href='{{ url('/category/videos/' . $videos->slug) }}'"
                                width="100%" height="auto" style="transform: scale(1.27);object-fit:cover;cursor: pointer;">
                                <source src="<?php echo $videos->trailer; ?>" type="application/x-mpegURL">
                            </video>
                            <div class="volume-icon-container">
                                <i class="fa fa-volume-off volume-icon" aria-hidden="true"></i>
                            </div>
                    <?php endif; ?>
                @endif
            </div>
            <div class="position-absolute _meta_desc_data_">
                <div class="bgc">
                    @if($videos->enable_video_title_image == 1 && $videos->video_title_image != null)
                        <!-- Video thumbnail image -->
                        <a href="{{ url('/category/videos/' . $videos->slug) }}">
                            <img class="flickity-lazyloaded" src="{{ url('public/uploads/images/' . $videos->video_title_image) }}" class="video_title_images" alt="{{ $videos->title }}" loading="lazy">
                        </a>
                    @else
                        <!-- Video Title -->
                        @php
                            $title = str_replace('<br>',' ',$videos->title);
                            $decode_title = strip_tags(html_entity_decode($title));
                        @endphp
                        <h2>
                            {{ $decode_title }}
                        </h2>
                    @endif
        
                    <div class="descp">
                        @php
                            $description = __(strip_tags(html_entity_decode($videos->description)));
                        @endphp
        
                        <p class="desc" id="description-{{ $key }}" class="description-text">
                            {{ $description }}
                        </p>
        
                        @if(strlen($description) > 300)
                            <button class="des-more-less-btns" id="read-more-btn-{{ $key }}" onclick="toggleReadMore({{ $key }})">{{ __('Read More') }}</button>
                            <button class="des-more-less-btns" id="read-less-btn-{{ $key }}" onclick="toggleReadMore({{ $key }})" style="display: none;">{{ __('Read Less') }}</button>
                        @endif
                    </div>
        
                    <div class="d-flex justify-content-evenly align-items-center mt-3">
                        <a href="{{ url('/category/videos/' . $videos->slug) }}" class="btn bd">
                            <i class="fa fa-play" aria-hidden="true"></i> {{ __('Play Now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

{{-- Series  --}}
@if (!empty($series_sliders) && $series_sliders->isNotEmpty())
    @foreach ($series_sliders as $key => $series)
        <div class="s-bg-1">
            <div class="_banner_img">
                <img class="flickity-lazyloaded" src="{{ URL::to('/public/uploads/images/' . $series->player_image) }}" alt="{{ $series->title }}" loading="lazy" >
            </div>
            <div class="position-absolute _meta_desc_data_">
                <div class="bgc">
                    <h2>
                        {{ $series->title }}
                    </h2>
        
                    <div class="descp" style="overflow-y: scroll; max-height: 250px; scrollbar-width: none; color:#fff !important;">
                        @php
                            $details = __(strip_tags(html_entity_decode($series->details)));
                        @endphp

                        <div class="video-banner">
                            <p class="desc" id="details-{{ $key }}" style="max-height: 100px; overflow: hidden;">
                                {{ $details }}
                            </p>

                            @if(strlen($details) > 300)
                                <button class="des-more-less-btns text-primary p-0" id="read-more-details-{{ $key }}" onclick="detailsReadMore({{ $key }})">{{ __('Read More') }}</button>
                                <button class="des-more-less-btns text-primary p-0" id="read-less-details-{{ $key }}" onclick="detailsReadMore({{ $key }})" style="display: none;">{{ __('Read Less') }}</button>
                            @endif
                        </div>
                    </div>
        
                    <div class="d-flex justify-content-evenly align-items-center mt-3">
                        <a href="{{ url('play_series/'. $series->slug) }}" class="btn bd">
                            <i class="fa fa-play" aria-hidden="true"></i> {{ __('Play Now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


{{-- Tv-shows Episode Slider  --}}

@if (!empty($Episode_sliders) && $Episode_sliders->isNotEmpty())
    @foreach ($Episode_sliders as $key => $Episode_slider)
        <?php
            $series_trailer = App\Series::Select('series.*', 'series_seasons.trailer', 'series_seasons.trailer_type')
            ->Join('series_seasons', 'series_seasons.series_id', '=', 'series.id')
            ->where('series.id', $Episode_slider->id)
            ->where('series_seasons.id', '=', $Episode_slider->season_trailer)
            ->where('series_trailer', '1')
            ->first();
        ?>
        <div class="s-bg-1">
            <div class="_banner_img">
                <img class="flickity-lazyloaded" src="{{ URL::to('/public/uploads/images/' . $Episode_slider->player_image) }}" alt="{{ $Episode_slider->title }}" loading="lazy" >
            </div>
            <div class="position-absolute _meta_desc_data_">
                <div class="bgc">
                    <h2>
                        {{ $Episode_slider->title }}
                    </h2>
        
                    <div class="descp" style="overflow-y: scroll; max-height: 250px; scrollbar-width: none; color:#fff !important;">
                        @php
                            $details = __(strip_tags(html_entity_decode($Episode_slider->episode_description)));
                        @endphp

                        <div class="video-banner">
                            <p class="desc" id="epidetails-{{ $key }}" style="max-height: 100px; overflow: hidden;">
                                {{ $details }}
                            </p>

                            @if(strlen($details) > 300)
                                <button class="des-more-less-btns text-primary p-0" id="read-more-episode-{{ $key }}" onclick="episodeReadMore({{ $key }})">{{ __('Read More') }}</button>
                                <button class="des-more-less-btns text-primary p-0" id="read-less-episode-{{ $key }}" onclick="episodeReadMore({{ $key }})" style="display: none;">{{ __('Read Less') }}</button>
                            @endif
                        </div>
                    </div>
        
                    <div class="d-flex justify-content-evenly align-items-center mt-3">
                        <a href="{{ URL::to('episode/' . $Episode_slider->series_title->slug . '/' . $Episode_slider->slug) }}" class="btn bd">
                            <i class="fa fa-play" aria-hidden="true"></i> {{ __('Play Now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


{{-- Live Stream --}}

@if (!empty($live_banner) && $live_banner->isNotEmpty())
    @foreach ($live_banner as $key => $slider_live)
        <div class="s-bg-1">
            <div class="_banner_img">
                <img class="flickity-lazyloaded" src="{{ URL::to('/public/uploads/images/' . $slider_live->player_image) }}" alt="{{ $slider_live->title }}" loading="lazy">
            </div>
            <div class="position-absolute _meta_desc_data_">
                <div class="bgc">
                    <h2>
                        {{ $slider_live->title }}
                    </h2>
        
                    <div class="descp" style="overflow-y: scroll; max-height: 250px; scrollbar-width: none; color:#fff !important;">
                        @php
                            $details = __(strip_tags(html_entity_decode($slider_live->description)));
                        @endphp

                        <div class="video-banner">
                            <p class="desc" id="live-details-{{ $key }}" style="max-height: 100px; overflow: hidden;">
                                {{ $details }}
                            </p>

                            @if(strlen($details) > 300)
                                <button class="des-more-less-btns text-primary p-0" id="read-more-live-{{ $key }}" onclick="liveReadMore({{ $key }})">{{ __('Read More') }}</button>
                                <button class="des-more-less-btns text-primary p-0" id="read-less-live-{{ $key }}" onclick="liveReadMore({{ $key }})" style="display: none;">{{ __('Read Less') }}</button>
                            @endif
                        </div>
                    </div>
        
                    <div class="d-flex justify-content-evenly align-items-center mt-3">
                        <a href="{{ url('live/' . $slider_live->slug) }}" class="btn bd">
                            <i class="fa fa-play" aria-hidden="true"></i> {{ __('Play Now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

{{-- Live Event --}}
@if (!empty($live_event_banners) && $live_event_banners->isNotEmpty())
    @foreach ($live_event_banners as $live_event_banner)
        <!-- <div class="s-bg-1 lazyloaded" style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%),url('{{ URL::to('/public/uploads/images/' . $live_event_banner->player_image) }}');"> -->
        <div class="s-bg-1 lazyloaded" style=" background: url('{{ URL::to('/public/uploads/images/' . $live_event_banner->player_image) }}')">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <h2 class="text-white">
                                {{ $live_event_banner->title }}
                            </h2>

                            <div class="d-flex align-items-center">
                                <span class="badge badge-secondary p-2">
                                    {{ __($live_event_banner->year) }}
                                </span>
                            </div>

                            <div style="overflow: hidden !important; text-overflow: ellipsis !important; margin-bottom: 20px; color: #fff; display: -webkit-box;
                                    -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ __($live_event_banner->description) }}
                            </div>

                            <div class="d-flex justify-content-evenly align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ route('live_event_play', $live_event_banner->slug) }}" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> {{ __('Play') }}
                                </a>
                                <a class="btn bd ml-2" href="{{ route('live_event_play', $live_event_banner->slug) }}">
                                    <i class="fa fa-info" aria-hidden="true"></i> {{ __('More details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif

{{-- Video Category Banner --}}

@if (!empty($VideoCategory_banner) && $VideoCategory_banner->isNotEmpty())
    @forelse ($VideoCategory_banner as $key => $videos)
        <!-- <div class="s-bg-1 lazyloaded" style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%),url('{{ URL::to('/public/uploads/images/' . $videos->player_image) }}');"> -->
        <div class="s-bg-1 lazyloaded" style=" background: url('{{ URL::to('/public/uploads/images/' . $videos->player_image)}}')">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12 bgc" >

                            @if($videos->enable_video_title_image == 1 && $videos->video_title_image != null)
                                <!-- Video thumbnail image -->
                                <a href="{{ url('/category/videos/' . $videos->slug) }}">
                                    <img src="{{ url('public/uploads/images/' . $videos->video_title_image) }}" class="video_title_images" alt="{{ $videos->title }}">
                                </a>
                            @else
                                <!-- Video Title -->
                                @php
                                    $title = str_replace('<br>',' ',$videos->title);
                                    $decode_title = strip_tags(html_entity_decode($title));
                                @endphp
                                <h2 class="">
                                    {{ $decode_title }}
                                </h2>
                            @endif

                            <div class="descp" style="overflow-y: scroll; max-height: 180px; scrollbar-width: none; color:#fff !important;">
                                @php
                                    $description = __(strip_tags(html_entity_decode($videos->description)));
                                @endphp

                                <div class="video-banner">
                                    <p class="desc" id="description-{{ $key }}" class="description-text">
                                        {{ $description }}
                                    </p>

                                    @if(strlen($description) > 300)
                                        <button class="des-more-less-btns text-primary p-0" id="read-more-btn-{{ $key }}" onclick="toggleReadMore({{ $key }})">{{ __('Read More') }}</button>
                                        <button class="des-more-less-btns text-primary p-0" id="read-less-btn-{{ $key }}" onclick="toggleReadMore({{ $key }})" style="display: none;">{{ __('Read Less') }}</button>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                                <a href="{{ url('/category/videos/' . $videos->slug) }}" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> {{ __('Play Now') }}
                                </a>

                                @php
                                    include(public_path('themes/default/views/partials/home/Trailer-slider.blade.php'))
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


<!-- For Lazyloading the slider bg image -->
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-bg"));

        if ("IntersectionObserver" in window) {
            let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let bg = entry.target.style.backgroundImage;

                        if (!bg || bg === 'none') {
                            let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
                            
                            if (isSafari) {
                                bg = entry.target.style.backgroundImage;
                            } else {
                                try {
                                    bg = entry.target.currentStyle 
                                        ? entry.target.currentStyle.backgroundImage 
                                        : entry.target.style.backgroundImage;
                                } catch (e) {
                                    console.log("Could not get computed style in Safari: ", e);
                                }
                            }
                        }

                        if (bg && bg !== 'none') {
                            entry.target.style.backgroundImage = bg;
                        }

                        entry.target.classList.remove('lazy-bg');
                        lazyBackgroundObserver.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 1.0
            });

            lazyBackgrounds.forEach(function(lazyBackground) {
                lazyBackgroundObserver.observe(lazyBackground);
            });
        }
    });
</script> --}}


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lazyImages = document.querySelectorAll("img[data-src]");
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
        });
    });
</script>

<style>
    .s-bg-1::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;    
        width: 100%;
        height: 100%;
        background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), 
                    linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%);
        z-index: 0;
    }

#home-slider .flickity-viewport{height: calc(100vw / 2.5) !important;}

    ._banner_img {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    /* ._banner_img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(70%);
    } */

    ._meta_desc_data_ {
        position: absolute;
        top: 50%;
        left: 5%;
        transform: translateY(-50%);
        z-index: 2;
        color: #fff;
        max-width: 45%;
        min-width: 25%;
    }

    .bgc {
        background: rgba(0, 0, 0, 0.6); /* Adds a semi-transparent background to the metadata */
        padding: 20px;
        border-radius: 10px;
    }

    .video_title_images {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
    }

    h2 {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .descp {
        font-size: 1rem;
        line-height: 1.5;
        scrollbar-width: thin;
        scrollbar-color: #888 #222;
        max-height: 180px;
        overflow-y: auto;
    }

    .descp::-webkit-scrollbar {
        width: 6px;
    }

    .descp::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 3px;
    }

    .descp::-webkit-scrollbar-track {
        background: #222;
    }

    .btn.bd {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn.bd i {
        margin-right: 5px;
    }

    .btn.bd:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .des-more-less-btns {
        background: none;
        border: none;
        color: #00aaff;
        font-weight: bold;
        cursor: pointer;
    }

    .des-more-less-btns:hover {
        text-decoration: underline;
    }



    /* video */

    ._banner_img video {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }

    ._banner_img:hover video {
        display: block;
        opacity: 1;
    }

    @media(max-width:768px){
        ._meta_desc_data_{display:none;}
    }
</style>

 <!--  video-js Script  -->
 <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet">
 <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
 
 <!-- Video.js HTTP Streaming for HLS -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-http-streaming/2.10.2/videojs-http-streaming.min.js"></script>
 