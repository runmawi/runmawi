
<?php 
    $play_button_svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1" />
        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
    </svg>';
?>

                {{-- Admin Slider  --}}
@if (!empty($sliders) && $sliders->isNotEmpty())
    @foreach ($sliders as $item)
    <div id="admin-slid">
        <div class="slide slick-bg s-bg-2 admin-slide1" style="background: url('{{ URL::to('public/uploads/videocategory/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">

                            <!-- <a href="#">
                                <div class="channel-logo">
                                    <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                </div>
                            </a> -->

                            <!-- <h1 class="slider-text big-title title text-uppercase">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1> -->

                            <!-- <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1">
                                <a href="{{ $item->link }}" class="btn btn-hover"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                            </div> -->
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
        </div>
    </div>
    @endforeach
@endif

        {{-- Video Banner --}}
@if (!empty($video_banners) && $video_banners->isNotEmpty())
    @foreach ($video_banners as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;">
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-9 col-lg-12 col-md-12">
                                <div class="channel-logo" data-delay-in="0.5">
                                    <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                </div>
                            <h1 class="slider-text title">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                            <div class="d-flex align-items-center mb-2" data-animation-in="fadeInUp" data-delay-in="1">
                                <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                    <span class="">
                                        <ul class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                                            @php $rating = ($item->rating / 2) ; @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($rating >= $i)
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                @elseif ($rating + 0.5 == $i)
                                                    <li><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                                                @else
                                                    <li><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </span>
                                    <span class="ml-2 mr-5"> {{ $item->rating ? ( $item->rating / 2 ) : " "  }} </span>
                                </div>
                                @if(!($item->age_restrict == 0))
                                    <span class="badge badge-secondary p-2"> {{ optional($item)->age_restrict }} </span>
                                @endif
                                <span class="ml-3">
                                    @if($item->duration != null)
                                        @php
                                            $duration = Carbon\CarbonInterval::seconds($item->duration)->cascade();
                                            $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                            $minutes = $duration->format('%imin');
                                        @endphp
                                        {{ $hours }}{{ $minutes }}
                                    @else
                                        null
                                    @endif
                                </span>
                            </div>
                            <div class="descript">
                                {!! html_entity_decode( optional($item)->description) !!}
                            </div>
                            <div class="cate-sections mb-3">
                                @if(!empty($item->artists) && ($item->artists)->isNotEmpty())
                                    <div class="d-flex">
                                        <span class="text-primary pr-2">{{ "Staring:"}}</span>
                                        @foreach ( $item->artists as $cast)
                                            <span class="pr-1">{{ $cast->artist_name}},</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if (!empty($item->categories) && ($item->categories)->isNotEmpty() )
                                    <div class="d-flex">
                                        <span class="text-primary pr-2">{{ "Tag:"}}</span>
                                        @foreach ( $item->categories as $cate)
                                            <span class="pr-1">{{ $cate->name}},</span>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('category/videos/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>{{ __('Play Now')}}</a>
                                {{-- <a href="show-details.html" class="btn btn-link">More details</a> --}}
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
        </div>
    @endforeach
@endif


                {{-- Series  --}}
@if (!empty($series_sliders) && $series_sliders->isNotEmpty())
    @foreach ($series_sliders as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-9 col-lg-12 col-md-12">
                                <div class="channel-logo" data-delay-in="0.5">
                                    <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                </div>
                            <h1 class="slider-text title">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class=""> {{ App\SeriesSeason::where('series_id', $item->id)->count() }} Seasons</span>
                                <span class="ml-3"> {{ App\Episode::where('series_id', $item->id)->count() }} Episodes </span>
                            </div>
                            <div class="descript">
                                <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->details) !!} </p>
                            </div>
                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('play_series/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>{{ __('Play Now')}}</a>
                                {{-- <a href="show-details.html" class="btn btn-link">More details</a> --}}
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
        </div>
    @endforeach
@endif

                    {{-- Live Stream --}}
@if (!empty($live_banner) && $live_banner->isNotEmpty())
    @foreach ($live_banner as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-9 col-lg-12 col-md-12">
                                <div class="channel-logo" data-delay-in="0.5">
                                    <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                </div>
                            <h1 class="slider-text title">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>
                            <div class="descript">
                                <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p>
                            </div>

                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('live'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>Play Now</a>
                                {{-- <a href="show-details.html" class="btn btn-link">More details</a> --}}
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
    @foreach ($live_event_banners as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}');  background-repeat: no-repeat;background-size: cover;" >
            <div class="container position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-9 col-lg-12 col-md-12">
                                <div class="channel-logo" data-delay-in="0.5">
                                    <img src="{{ front_end_logo() }}" class="c-logo" alt="streamit">
                                </div>
                            <h1 class="slider-text title">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </h1>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>
                                      
                            <div class="descript">
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
        </div>
    @endforeach
@endif