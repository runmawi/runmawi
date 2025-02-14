
<?php 
    $play_button_svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1" />
        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
    </svg>';
?>

                {{-- Admin Slider  --}}
@if (!empty($sliders) && $sliders->isNotEmpty())
    @foreach ($sliders as $item)
        <div class="slide slick-bg s-bg-2" style="background: url('{{ URL::to('public/uploads/videocategory/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <a href="{{ $item->link }}" class="btn bd">
                <div class="container-fluid position-relative h-100" style="padding:0 100px !important;">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center  h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">

                                <a href="#">
                                    <div class="channel-logo" data-animation-in="fadeInLeft">
                                        <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                    </div>
                                </a>

                                <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                            </div>
                        </div>

                        {{-- Trailer --}}
                        @if ( optional($item)->trailer_link)
                            <div class="trailor-video">
                                <a href="{{ $item->trailer_link }}" class="playbtn">
                                    {!! html_entity_decode( $play_button_svg ) !!}
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif

@php 
    $video_banners = $video_banners->take(5);
@endphp
        {{-- Video Banner --}}
@if (!empty($video_banners) && $video_banners->isNotEmpty())
    @foreach ($video_banners as $key => $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;">
            <a href="{{ url('/category/videos/' . $item->slug) }}">
                <div class="container-fluid position-relative h-100" style="padding:0 100px;">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center  h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <h1 class="slider-text big-title title text-uppercase" style="color:#fff !important;">{{ \Illuminate\Support\Str::limit($item->title,50) }} </h1>
                                
                                                {{-- Description --}}
                                <div class="descp" style="overflow-y: scroll;max-height: 250px;scrollbar-width: none; color:#fff !important;">

                                    @if (optional($item)->description)

                                        @if (strlen($item->description) < 354 )
                                            <p>{!! html_entity_decode($item->description) !!}</p>
                                        @else
                                            <p style="color:#fff !important;" class="m-0"> {!!  substr(html_entity_decode($item->description), 0, 354 ) !!} </p>
                                            <p class="{{ 'm-0 videos-read-more-content-'.$key }}" style="display: none;color:#fff !important;">{!!  substr(html_entity_decode($item->description), 355, 2000 ) !!} </p>
                                            <a href="#" data-read-more-id= "{{ 'videos-read-more-content-'.$key }}" onclick="read_more_details(this)">Read more</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                            {{-- Trailer --}}
                        {{-- @if ( optional($item)->trailer)
                            <div class="trailor-video">
                                <a href="{{ $item->trailer_link }}" class="playbtn">
                                    {!! html_entity_decode( $play_button_svg ) !!}
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>

                        @endif --}}
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif


                {{-- Series  --}}
@if (!empty($series_sliders) && $series_sliders->isNotEmpty())
    @foreach ($series_sliders as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <a href="{{ url('play_series/'. $item->slug) }}" class="btn bd">
                <div class="container-fluid position-relative h-100" style="padding:0 100px !important;">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center  h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <h1 class="slider-text big-title title text-uppercase">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                                <div class="descp">
                                    <p  data-delay-in="1.2"> {!! html_entity_decode( optional($item)->details) !!} </p>
                                </div>
                                
                            </div>
                        </div>

                            {{-- Trailer --}}
                        {{-- @if ( optional($item)->trailer)
                            <div class="trailor-video">
                                <a href="{{ $item->trailer_link }}" class="playbtn">
                                    {!! html_entity_decode( $play_button_svg ) !!}
                                    <span class="w-trailor">Watch Trailer</span>
                                </a>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif

                    {{-- Live Stream --}}
@if (!empty($live_banner) && $live_banner->isNotEmpty())
    @foreach ($live_banner as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <a href="{{ url('live/' . $item->slug) }}" class="btn bd">
                <div class="container-fluid position-relative h-100" style="padding:0 100px !important;">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center  h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <h1 class="slider-text big-title title text-uppercase">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                                </div>
                                <div class="descp">
                                    <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif

                    {{-- Live Event --}}
@if (!empty($live_event_banners) && $live_event_banners->isNotEmpty())
    @foreach ($live_event_banners as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <a href="{{ route('live_event_play', $item->slug) }}" class="btn bd">
                <div class="container-fluid position-relative h-100" style="padding:0 100px !important;">
                    <div class="slider-inner h-100">
                        <div class="row align-items-center  h-100">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <a href="javascript:void(0);">
                                    <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                        <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                    </div>
                                </a>
                                <h1 class="slider-text big-title title text-uppercase">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                                </div>
                                        
                                <div class="descp">
                                    <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p>
                                </div>
                                <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    <a href="{{ URL::to('category/videos/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                    aria-hidden="true"></i>Play Now</a>
                                    {{-- <a href="show-details.html" class="btn btn-link">More details</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif



         

