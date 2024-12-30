@php
    $data = App\SeriesNetwork::where('in_home',1)->orderBy('order')->limit(15)->get()->map(function ($item) use ($default_vertical_image_url , $default_horizontal_image_url) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : $default_vertical_image_url ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : $default_horizontal_image_url;

                $Series = App\Series::select(
                                'id', 'title', 'slug', 'access', 'active', 'ppv_status', 'featured', 'duration', 'image',
                                'embed_code', 'mp4_url', 'webm_url', 'ogg_url', 'url', 'tv_image', 'player_image',
                                'details', 'description', 'network_id'
                            )
                            ->where('active', 1)
                            ->where('network_id', 'LIKE', '%"'.$item->id.'"%')
                            ->latest();

                            $series = $Series->take(15)->get()->map(function ($seriesItem) use ($default_vertical_image_url, $default_horizontal_image_url) {
                                $seriesItem['image_url'] = $seriesItem->image != null ? URL::to('public/uploads/images/' . $seriesItem->image) : $default_vertical_image_url;
                                $seriesItem['Player_image_url'] = $seriesItem->player_image != null ? URL::to('public/uploads/images/' . $seriesItem->player_image) : $default_horizontal_image_url;
                                $seriesItem['TV_image_url'] = $seriesItem->tv_image != null ? URL::to('public/uploads/images/' . $seriesItem->tv_image) : @$default_horizontal_image_url;

                                $seriesItem['season_count'] = App\SeriesSeason::where('series_id', $seriesItem->id)->count();
                                $seriesItem['episode_count'] = App\Episode::where('series_id', $seriesItem->id)->count();

                                return $seriesItem;
                            });

                            $item['has_more'] = $Series->count() > 15;

                            $item['series'] = $series;
                return $item;
            });

@endphp

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ optional($order_settings_list[30])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list series-network-video flickity-slider">
                                @foreach ($data as $key => $series_networks)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $series_networks->image_url }}" class="flickity-lazyloaded" alt="{{ ($series_networks)->name }}" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="series-network-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:block;">
                                @foreach ($data as $key => $series_networks )
                                    <div class="w-100">
                                        <div class="caption" data-index="{{ $key }}">
                                            <h2 class="caption-h2">{{ optional($series_networks)->name }}</h2>
                                            <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                    <a href="{{ route('Specific_Series_Networks',$series_networks->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="thumbnail" data-index="{{ $key }}">
                                            <img src="{{ $series_networks->banner_image_url}}" class="flickity-lazyloaded" alt="latest_series" >
                                        </div>

                                        <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}" >
                                            @foreach ($series_networks->series as $series_key  => $series_details )
                                                <div class="depends-row">
                                                    <div class="depend-items">
                                                    <a href="{{ route('network.play_series',$series_details->slug) }}">
                                                        <div class=" position-relative">
                                                            <img data-flickity-lazyload="{{ $series_details->image ?  URL::to('public/uploads/images/'.$series_details->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos">                                                                                <div class="controls">
                                                                
                                                                <a href="{{ route('network.play_series',$series_details->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>

                                                                <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                
                                                                <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                    <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $series_details->season_count ." Seasons ".$series_details->episode_count .' Episodes' }}</span> <br>
                                                                    {{ optional($series_details)->title   }}
                                                                </p>
                                                                
                                                            </div>
                                                        </div>
                                                    </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if ($series_networks->has_more)
                                                <div class="depends-row" style="height: 100%">
                                                    <div class="depend-items d-flex align-items-center justify-content-center" style="height: 100%;background-color:#000;">
                                                        <a href="{{ route('Specific_Series_Networks',$series_networks->slug) }}">
                                                            <div class=" position-relative">
                                                            <p class="text-white">{{ "View all" }}</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

          
        {{-- Series Modal --}}

        @foreach ($data as $key => $series_networks )

            @foreach ($series_networks->series as $series_key => $series_details )
                <div class="modal fade info_model" id="{{ 'Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <img class="lazy" src="{{ URL::to('public/uploads/images/'.$series_details->player_image) }}" alt="{{ $series_details->title }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($series_details)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="trending-dec mt-4" >
                                                    {{ $series_details->season_count ." Series ".$series_details->episode_count .' Episodes' }} 
                                                </div>

                                                @if (optional($series_details)->details)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($series_details)->details) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('play_series/'.$series_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

    </section>
@endif


<script>

    var elem = document.querySelector('.flickity-slider');
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: false,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad: 7,
        });


document.querySelectorAll('.series-network-video .item').forEach(function(item) {
    item.addEventListener('click', function() {
        document.querySelectorAll('.series-network-video .item').forEach(function(item) {
            item.classList.remove('current');
        });

        this.classList.add('current');

        var index = this.getAttribute('data-index');

        document.querySelectorAll('.series-network-dropdown .caption').forEach(function(caption) {
            caption.style.display = 'none';
        });
        document.querySelectorAll('.series-network-dropdown .thumbnail').forEach(function(thumbnail) {
            thumbnail.style.display = 'none';
        });

        // Hide all sliders
        document.querySelectorAll('.series-network-dropdown .network-depends-slider').forEach(function(slider) {
            slider.style.display = 'none';
        });

                
        var selectedSlider = document.querySelector('.series-network-dropdown .network-depends-slider[data-index="' + index + '"]');
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(function() { // Ensure the element is visible before initializing Flickity
                    var flkty = new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: false,
                        pageDots: false,
                        draggable: true,
                        freeScroll: true,
                        imagesLoaded: true,
                        lazyLoad: 7,
                    });
                }, 0);
            }

        var selectedCaption = document.querySelector('.series-network-dropdown .caption[data-index="' + index + '"]');
        var selectedThumbnail = document.querySelector('.series-network-dropdown .thumbnail[data-index="' + index + '"]');
        if (selectedCaption && selectedThumbnail) {
            selectedCaption.style.display = 'block';
            selectedThumbnail.style.display = 'block';
        }

        document.getElementsByClassName('series-network-dropdown')[0].style.display = 'flex';
    });
});



$('body').on('click', '.drp-close', function() {
    $('.series-network-dropdown').hide();
});

</script>

