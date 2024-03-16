@php
    include public_path('themes/theme3/views/header.php');
@endphp

<!-- Slider  -->
@if (!empty($video_banners) && $video_banners->isNotEmpty())
    <section id="home" class="iq-main-slider p-0">
        <div id="home-slider" class="slider m-0 p-0">
            @foreach ($video_banners as $item)
                <div class="slide slick-bg s-bg-1" style="background: url('{{ URL::to('public/uploads/images/' . $item->player_image) }}')" >
                    <div class="container-fluid position-relative h-100" style="padding:0 100px !important;">
                        <div class="slider-inner h-100">
                            <div class="row align-items-center  h-100">
                                <div class="col-xl-6 col-lg-12 col-md-12">
                                    <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft" data-delay-in="0.6">{{ strlen($item->title) > 13 ? substr($item->title, 0, 14) . '...' : $item->title }}</h1>

                                    
                                    <p data-animation-in="fadeInUp" data-delay-in="1.2"> {!! html_entity_decode( optional($item)->description) !!}  </p>
                                    
                                </div>
                            </div>

                            @if ( optional($item)->trailer)
                                {{-- <div class="trailor-video">
                                    <a href="video/trailer.mp4" class="video-open playbtn">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px"
                                            viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10"
                                                points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                                            <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8"
                                                r="103.3" />
                                        </svg>
                                        <span class="w-trailor">Watch Trailer</span>
                                    </a>
                                </div> --}}
                            @endif
                                
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </section>
@endif

<div class="main-content">
    @if (!empty($lang_videos) && $lang_videos->isNotEmpty())
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                        
                                    {{-- Section Header Title --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <div class="left-content">
                                <h4 class="main-title"> Popular Movies </h4>
                            </div>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                               @foreach ($lang_videos as $item)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                            <div class="block-images position-relative">

                                                <div class="img-box">
                                                    <img src="{{ URL::to('public/uploads/images/' . $item->image) }}" class="img-fluid" alt="">
                                                </div>
                                                <div class="block-description">
                                                

                                                    <div class="hover-buttons">
                                                        <a class="" href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                <span class="text pr-2"> {{ (__('Play')) }} </span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                               @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Top 10 Movies Today --}}

    @if (!empty($Most_watched_country) && $Most_watched_country->isNotEmpty())

        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">

                                    {{-- Section Header Title --}}
                    <div class="col-sm-12 overflow-hidden">
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <div class="left-content">
                                <h4 class="main-title">{{ 'Top 10 Movies in ' . country_name() .' Today'  }} </h4>
                            </div>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($Most_watched_country as $item)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="{{ URL::to('public/uploads/images/' . $item->image) }}" class="img-fluid" alt="">
                                                </div>
                                                <div class="block-description">
                                                

                                                    <div class="hover-buttons">
                                                        <a class="" href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                <span class="text pr-2"> {{ (__('Play')) }} </span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- <div class="upcoming-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                               @foreach ($Most_watched_country as $item)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                            <div class="block-images position-relative">

                                                <div class="img-box">
                                                    <img src="{{ URL::to('public/uploads/images/' . $item->image) }}" class="img-fluid" alt="">
                                                </div>

                                                <div class="img-description">
                                                    <img src="{{ URL::to('public/uploads/images/' . $item->image) }}" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="row">
                                                        <div class="movie-time d-flex align-items-center col-10">
                                                            <ul class=" p-0 m-0 music-play-lists"
                                                                style="display: inline-flex;">
                                                                <li><span><i class="fa fa-play" aria-hidden="true"></i></span></li>
                                                                <li><span><i class="ri-add-line"></i></span></li>
                                                                <li><span><i class="fa fa-thumbs-o-up"aria-hidden="true"></i></span></li>
                                                            </ul>
                                                        </div>

                                                        <div class="movie-time d-flex align-items-center col-2">
                                                            <ul class=" p-0 m-0 music-play-lists"
                                                                style="display: inline-flex;">
                                                                {{-- <li><span> <i class="fa fa-chevron-down" aria-hidden="true"></i></span></li> --}}
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center mt-2">

                                                        <div class=" p-1 mr-2" style="color: #E3FF74;">95% Match</div>
                                                            
                                                        @if (optional($item)->age_restrict )
                                                            <span class="text-white  mr-2" style="border: solid 1px; padding: 1px 10px 1px 10px;">
                                                                {{ 'U/A ' . optional($item)->age_restrict }} 
                                                            </span>
                                                        @endif
                                                        
                                                        <span class="text-white mr-2">
                                                            {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}
                                                        </span>

                                                        <div class="hdcir  mr-2">HD</div>
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center">
                                                        <span class="text-white p-1 mr-2">{!! ($item->categories) !!}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                               @endforeach
                            </ul>
                        </div> -->
                        
                    </div>
                </div>
            </div>
        </section>
        
    @endif

    {{-- Movies Recommended For You --}}

    @if (!empty($top_most_watched) && $top_most_watched->isNotEmpty())

        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">

                                    {{-- Section Header Title --}}
                    <div class="col-sm-12 overflow-hidden">
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <div class="left-content">
                                <h4 class="main-title">Movies Recommended For You</h4>
                            </div>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($top_most_watched as $item)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                            <div class="block-images position-relative">

                                                <div class="img-box">
                                                    <img src="{{ URL::to('public/uploads/images/' . $item->image) }}" class="img-fluid" alt="">
                                                </div>
                                                <div class="block-description">
                                                

                                                    <div class="hover-buttons">
                                                        <a class="" href="{{ URL::to('category/videos/'.$item->slug ) }}">
                                                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                <span class="text pr-2"> {{ (__('Play')) }} </span>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

@php
    include public_path('themes/theme3/views/footer.blade.php');
@endphp
