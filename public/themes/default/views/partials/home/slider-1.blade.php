

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
                                {{ strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 50) . '...' : $slider_video->title }}
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
    <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $videos->player_image) }}')">
        <!-- <div class="s-bg-1 lazy-bg" data-bg="{{ URL::to('/public/uploads/images/' . $videos->player_image) }}"> -->
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-4 col-lg-12 col-md-12 bgc" >

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
                                <h2 class="text-white" style="color: var(--iq-white) !important;">
                                    {{ strlen($decode_title) > 15 ? substr($decode_title, 0, 50) . '...' : $decode_title }}
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

                            <div class="d-flex justify-content-evenly align-items-center r-mb-23 mt-3">
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

{{-- Series  --}}
@if (!empty($series_sliders) && $series_sliders->isNotEmpty())
    @foreach ($series_sliders as $key => $slider_video)
        <!-- <div class="s-bg-1 lazyloaded"  style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $slider_video->player_image) }}');"> -->
        <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $slider_video->player_image) }}')">    
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-5 col-lg-5 col-md-12">
                            <div style="width: 100%;" >
                            <h2 class="slider-text title text-uppercase" style="color: var(--iq-white) !important;">
                                {{ strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 50) . '...' : $slider_video->title }}
                            </h2>
                            </div>
                            <div class="descp" style="overflow-y: scroll; max-height: 250px; scrollbar-width: none; color:#fff !important;">
                                @php
                                    $details = __(strip_tags(html_entity_decode($slider_video->details)));
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

                            <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                                <a href="{{ url('play_series/'. $slider_video->slug) }}" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> {{ __('Watch Now') }}
                                </a>

                                {{-- <a class="btn bd ml-2" href="{{ url('play_series/'. $slider_video->slug) }}">
                                    <i class="fa fa-info" aria-hidden="true"></i> {{ __('More details') }}
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="trailor-video">
                        <a href="{{ url('episode/' . @$slider_video->series_title->slug . '/' . $slider_video->slug) }}" class="video-open playbtn">
                            <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                            </svg>
                            <span class="w-trailor">{{ __('Watch Trailer') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif


{{-- Tv-shows Episode Slider  --}}

@if (!empty($Episode_sliders) && $Episode_sliders->isNotEmpty())
    @foreach ($Episode_sliders as $Episode_slider)

    <?php
        $series_trailer = App\Series::Select('series.*', 'series_seasons.trailer', 'series_seasons.trailer_type')
        ->Join('series_seasons', 'series_seasons.series_id', '=', 'series.id')
        ->where('series.id', $Episode_slider->id)
        ->where('series_seasons.id', '=', $Episode_slider->season_trailer)
        ->where('series_trailer', '1')
        ->first();
    ?>

    <!-- <div class="s-bg-1 lazyloaded" style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $Episode_slider->player_image) }}');" id="image-container"> -->
    <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $Episode_slider->player_image) }}" id="image-container">    
        <div class="container-fluid position-relative h-100" style="padding:0px 100px">
            <div class="slider-inner h-100">
                <div class="row align-items-center bl h-100">
                    <div class="col-xl-6 col-lg-6 col-md-12">

                        <h2 class="text-white" style="color: var(--iq-white) !important;">
                            {{ strlen($Episode_slider->title) > 15 ? substr($Episode_slider->title, 0, 50) . '...' : $Episode_slider->title }}
                        </h2>

                        <div style="overflow: hidden !important; text-overflow: ellipsis !important; margin-bottom: 20px; color:#fff; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ __(strip_tags(html_entity_decode($Episode_slider->episode_description)))}}
                        </div>

                        <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                            <a href="{{ URL::to('episode/' . $Episode_slider->series_title->slug . '/' . $Episode_slider->slug) }}" class="btn bd">
                                <i class="fa fa-play mr-2" aria-hidden="true"></i>  {{ __('Watch Now') }}
                            </a>
                            {{-- <a class="btn bd ml-2" href="{{ URL::to('episode/'. $Episode_slider->series_title->slug.'/'.$Episode_slider->slug ) }}">
                                <i class="fa fa-info" aria-hidden="true"></i>  {{ __('More details') }}
                            </a> --}}
                        </div>
                    </div>
                </div>

                <!-- watch Trailer -->
                @if($series_trailer != null)
                    @php
                        $series_image = $series_trailer != null ? $series_trailer->season_image : ' ';
                    @endphp

                    @if($series_trailer->trailer != null && $series_trailer->trailer_type == 'm3u8_url')
                        <div class="trailor-video">
                            <a href="#video-trailer" class="video-open playbtn" data-poster-url="{{ url('/') . '/public/uploads/season_images/' . $series_image }}" data-trailer-url="{{ $series_trailer->trailer }}" onclick="trailer_slider_season(this)" data-trailer-type="{{ $series_trailer->trailer_type }}">
                                <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <style type="text/css">
                                        .gt {
                                            height: 60px !important;
                                        }
                                    </style>
                                    <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                    <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                </svg>
                                <span class="w-trailor">{{ __('Watch Trailer') }}</span>
                            </a>
                        </div>
                    @elseif($series_trailer->trailer != null && $series_trailer->trailer_type == 'mp4_url')
                        <div class="trailor-video">
                            <a href="#series_MP4_video-trailer" class="video-open playbtn" data-poster-url="{{ url('/') . '/public/uploads/season_images/' . $series_image }}" data-trailer-url="{{ $series_trailer->trailer }}" onclick="trailer_slider_season(this)" data-trailer-type="{{ $series_trailer->trailer_type }}">
                                <svg class="gt" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <style type="text/css">
                                        .gt {
                                            height: 60px !important;
                                        }
                                    </style>
                                    <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                    <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                                </svg>
                                <span class="w-trailor">{{ __('Watch Trailer') }}</span>
                            </a>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <div id="video-trailer" class="mfp-hide">
                            <video id="Trailer-videos" class="" poster="" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                                <source type="application/x-mpegURL" src="{{ $series_trailer->trailer }}">
                            </video>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="series_MP4_video-trailer" class="mfp-hide">
                            @php
                                $series_image = $series_trailer != null ? $series_trailer->season_image : ' ';
                            @endphp
                            <video id="Series_MP4_Trailer-videos" class="" poster="" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="{{ $series_trailer->trailer }}" type="video/mp4">
                                <source src="{{ $series_trailer->trailer }}" type='video/mp4' label='Auto' res='auto' />
                            </video>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @endforeach
@endif


{{-- Live Stream --}}
@if (!empty($live_banner) && $live_banner->isNotEmpty())
    @foreach ($live_banner as $key => $slider_video)
        <!-- <div class="s-bg-1 lazyloaded" style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%),url('{{ URL::to('/public/uploads/images/' . $slider_video->player_image) }}');"> -->
        <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $slider_video->player_image) }}')">    
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">

                            <h2 class="text-white mb-2" style="color: var(--iq-white) !important;">
                                {{ strlen($slider_video->title) > 15 ? substr($slider_video->title, 0, 50) . '...' : $slider_video->title }}
                            </h2>
                            <div class="descp" style="overflow-y: scroll; max-height: 250px; scrollbar-width: none; color:#fff !important;">
                                @php
                                    $details = __(strip_tags(html_entity_decode($slider_video->description)));
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
                            <div class="d-flex justify-content-evenly align-items-center r-mb-23">
                                <a href="{{ url('live/' . $slider_video->slug) }}" class="btn bd">
                                    <i class="fa fa-play mr-2" aria-hidden="true"></i> {{ __('Play') }}
                                </a>
                                <a class="btn bd ml-2" href="{{ url('live/' . $slider_video->slug) }}">
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

{{-- Live Event --}}
@if (!empty($live_event_banners) && $live_event_banners->isNotEmpty())
    @foreach ($live_event_banners as $live_event_banner)
        <!-- <div class="s-bg-1 lazyloaded" style="background:linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24, 24, 24) 25%, transparent 50%),url('{{ URL::to('/public/uploads/images/' . $live_event_banner->player_image) }}');"> -->
        <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $live_event_banner->player_image) }}')">
            <div class="container-fluid position-relative h-100" style="padding:0px 100px">
                <div class="slider-inner h-100">
                    <div class="row align-items-center bl h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <h2 class="text-white" style="color: var(--iq-white) !important;">
                                {{ strlen($live_event_banner->title) > 15 ? substr($live_event_banner->title, 0, 50) . '...' : $live_event_banner->title }}
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
        <div class="s-bg-1 lazyloaded" style=" background: linear-gradient(1deg, rgb(0, 0, 0) 0%, transparent 0%), linear-gradient(90deg, rgb(24 24 24 / 52%) 46%, transparent 50%), url('{{ URL::to('/public/uploads/images/' . $videos->player_image)}}')">
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
                                <h2 class="text-white" style="color: var(--iq-white) !important;">
                                    {{ strlen($decode_title) > 15 ? substr($decode_title, 0, 50) . '...' : $decode_title }}
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-bg"));

        if ("IntersectionObserver" in window) {
            let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let computedStyle = window.getComputedStyle(entry.target);
                        let bg = computedStyle.getPropertyValue('background-image');

                        if (!bg || bg === 'none') {
                            let newBg = entry.target.style.backgroundImage;
                            entry.target.style.backgroundImage = newBg;
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
</style>