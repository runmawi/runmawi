
<?php 
    $play_button_svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1" />
        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
    </svg>';

    $front_end_logo = front_end_logo();

?>

                {{-- Admin Slider  --}}
@if (!empty($sliders) && $sliders->isNotEmpty())
    @foreach ($sliders as $item)
        <div class="slide slick-bg s-bg-2" style="background: url('{{ URL::to('public/uploads/videocategory/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">

                            <a href="#">
                                <div class="channel-logo" data-animation-in="fadeInLeft">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>

                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1">
                                <a href="{{ $item->link }}" class="btn btn-hover"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                            </div>
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
    @endforeach
@endif

        {{-- Video Banner --}}
@if (!empty($video_banners) && $video_banners->isNotEmpty())
    @foreach ($video_banners as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;">
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 25 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="badge badge-secondary p-2"> {{ optional($item)->age_restrict.'+' }} </span>
                                <span class="ml-3">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>

                            {{-- Description with "See more" option --}}
                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>
                            <!-- <p data-animation-in="fadeInUp" data-delay-in="1.2" > {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 205)) . '...'. "  See more" : html_entity_decode($item->description) !!} </p> -->

                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('category/videos/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>Play Now</a>
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
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-3"> {{ App\SeriesSeason::where('series_id', $item->id)->count() }} Seasons</span>
                                <span class="ml-3"> {{ App\Episode::where('series_id', $item->id)->count() }} Episodes </span>
                            </div>

                            {{-- Description with "See more" option --}}
                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>
                            <!-- <p data-animation-in="fadeInUp" data-delay-in="1.2">
                                {!! strlen($item->details) > 200 ? html_entity_decode(substr($item->details, 0, 205)) . '...'. "  See more" : html_entity_decode($item->details) !!}
                            </p> -->

                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('play_series/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>Play Now</a>
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
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>

                            {{-- Description with "See more" option --}}
                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>
                            <!-- <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p> -->

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

                    {{-- Live Event --}}
@if (!empty($live_event_banners) && $live_event_banners->isNotEmpty())
    @foreach ($live_event_banners as $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-1">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>

                            {{-- Description with "See more" option --}}
                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>
                            <!-- <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p> -->

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

{{-- Tv-shows Episode Slider  --}}

<!-- @if (!empty($Episode_sliders) && $Episode_sliders->isNotEmpty())
    @foreach ($Episode_sliders as $item)

        <div class="slide slick-bg s-bg-1" style="background: url('{{ $item->image ? URL::to('public/uploads/images/'.$item->player_image) : $default_vertical_image_url }}'); background-repeat: no-repeat;background-size: cover;" >
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 17 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="ml-3"> {{ 'S '.$item->season_id   }}  </span>
                                <span class="ml-3"> {{ 'E '.$item->episode_order }}  </span>
                            </div>

                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>

                            <div class="p-btns">
                                <div class="d-flex align-items-center p-0">
                                    <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                        <a href="{{ URL::to('episode/'. $item->series_title->slug.'/'.$item->slug ) }}" class="btn btn-hover"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif -->

        {{-- Video Category Banner --}}

@if (!empty($VideoCategory_banner) && $VideoCategory_banner->isNotEmpty())
    @forelse ($VideoCategory_banner as $key => $item)
        <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}'); background-repeat: no-repeat;background-size: cover;">
            <div class="container-fluid position-relative h-100 pl-4">
                <div class="slider-inner h-100">
                    <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <a href="javascript:;">
                                <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="{{ $front_end_logo }}" class="c-logo" alt="streamit">
                                </div>
                            </a>
                            <p class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">{{ strlen($item->title) > 25 ? substr($item->title, 0, 18) . '...' : $item->title }} </p>

                            <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                                <span class="badge badge-secondary p-2"> {{ optional($item)->age_restrict.'+' }} </span>
                                <span class="ml-3">  {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}</span>
                            </div>

                            {{-- Description with "See more" option --}}
                            <div class="description-container">
                                <p class="description-text" data-animation-in="fadeInUp" data-delay-in="1.2">
                                    {!! strlen($item->description) > 200 ? html_entity_decode(substr($item->description, 0, 200)) . '... <a href="#" class="see-more">See more</a>' : html_entity_decode($item->description) !!}
                                </p>
                            </div>
                            <!-- <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!} </p> -->

                            <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                                <a href="{{ URL::to('category/videos/'.$item->slug) }}" class="btn btn-hover"><i class="fa fa-play mr-2"
                                aria-hidden="true"></i>Play Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
@endif
