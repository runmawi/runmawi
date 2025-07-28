@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[28]->url ? URL::to($order_settings_list[28]->url) : null }} ">{{ optional($order_settings_list[28])->header_name }}</a></h4>
                        <h4 class="main-title view-all text-primary"><a href="{{ $order_settings_list[28]->url ? URL::to($order_settings_list[28]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $key => $latest_video)
                                <li class="slide-item">
                                    <div class="block-images position-relative movie-slide" style="background-image: url('{{ ('assets/img/overlay-' . ($key+1) . '.webp') }}');">
                                        
                                        <a href="{{ URL::to('category/videos/'.$latest_video->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <span> {{ strlen($latest_video->title) > 17 ? substr($latest_video->title, 0, 18) . '...' : $latest_video->title }}
                                                </span>
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <span class="text-white">
                                                        @if($latest_video->duration != null)
                                                            @php
                                                                $duration = Carbon\CarbonInterval::seconds($latest_video->duration)->cascade();
                                                                $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                $minutes = $duration->format('%imin');
                                                            @endphp
                                                            {{ $hours }}{{ $minutes }}
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Play Now')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    .movie-slide {
        background-position: left;
        background-repeat: no-repeat;
        background-size: contain;
        position: relative;
        padding: 0 20px;
    }

    .movie-slide .img-box img {
        z-index: 2;
        position: relative;
    }

    .movie-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        opacity: 0.3;
    }

    li.slide-item.slick-slide:hover .movie-slide{padding: 0;}

</style>