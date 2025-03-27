@php
    $data = App\Series::
                where('active', 1)
                ->get()
                ->map(function ($series) use ($default_horizontal_image_url,$BaseURL,$default_vertical_image_url) {
                    
                    $series->id = $series->id;
                    $series['image_url'] = (!is_null($series->image) && $series->image != 'default_image.jpg')
                        ? $BaseURL.'/images/' . $series->image
                        : $default_vertical_image;

                    $series['Player_image_url'] = (!is_null($series->player_image) && $series->player_image != 'default_image.jpg')
                        ? $BaseURL.'/images/' . $series->player_image
                        : $default_horizontal_image_url;

                    $series['upload_on'] = Carbon\Carbon::parse($series->created_at)->isoFormat('MMMM Do YYYY');
                    $series['duration_format'] = !is_null($series->duration)
                        ? Carbon\Carbon::parse($series->duration)->format('G\H i\M')
                        : null;

                    // Get season IDs sorted by `order`
                    $season_ids = App\SeriesSeason::where('series_id', $series->id)
                        ->orderBy('order', 'desc')
                        ->pluck('id');

                    if ($season_ids->isNotEmpty()) {
                        $first_season_id = $season_ids->first();
                        $season_epi_count = App\Episode::where('season_id', $first_season_id)
                            ->where('active', 1)
                            ->count();

                        $series['Series_depends_episodes'] = App\Episode::where('series_id', $series->id)
                            ->whereIn('season_id', $season_ids)
                            ->where('active', 1)
                            ->orderByRaw("FIELD(season_id, " . implode(',', $season_ids->toArray()) . ")")
                            ->orderBy('episode_order', 'desc')
                            ->take(15)
                            ->get()
                            ->map(function ($episode) use ($default_horizontal_image_url,$BaseURL,$default_vertical_image_url) {
                                $episode['image_url'] = (!is_null($episode->image) && $episode->image != 'default_image.jpg')
                                    ? $BaseURL.'/images/' . $episode->image
                                    : $default_vertical_image;

                                $episode['player_image_url'] = (!is_null($episode->player_image) && $episode->player_image != 'default_horizontal_image.jpg')
                                    ? $BaseURL.'/images/' . $episode->player_image
                                    : $default_horizontal_image_url;

                                $episode['season_name'] = App\SeriesSeason::where('id', $episode->season_id)->value('series_seasons_name');

                                return $episode;
                            });
                    } else {
                        $series['Series_depends_episodes'] = collect(); // Return empty collection if no seasons found
                    }

                    $totalEpisodes = App\Episode::where('series_id', $series->id)->where('active', 1)->count();
                    $series['has_more'] = $totalEpisodes > 14;
                    $series['source'] = 'Series';

                    return $series;
                });
@endphp


@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-4">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ optional($order_settings_list[4])->header_name }}</a>
                        </h4>                   
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>                   
                     </div>

                     <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-series-video" data-flickity>
                                @foreach ($data as $key => $latest_series)
                                    <div id="latest-series-slider-img" class="item" data-index="{{ $key }}" data-series-id="{{ $latest_series->id }}">
                                        <div>
                                            <img data-flickity-lazyload="{{ $latest_series->image_url }}"  class="flickity-lazyloaded" alt="{{ $latest_series->title }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="series-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:block;">
                                @foreach ($data as $key => $latest_series )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($latest_series)->title }}</h2>
                                        @if (optional($latest_series)->description)
                                            <div class="trending-dec">{!! html_entity_decode( optional($latest_series)->description) !!}</div>
                                        @endif
                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('play_series/'.$latest_series->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img  id="series-bg-img-{{ $latest_series->id }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>

                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'series-depends-slider networks-depends-series-slider-'.$key .' content-list height-'.$latest_series->id}}" data-index="{{ $key }}" >
                                        @foreach ($latest_series->Series_depends_episodes as $episode_key => $episode_details )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode_details->slug ) }}">
                                                    <div class=" position-relative">
                                                            <img id="episodes_player_img-{{ $latest_series->id }}-{{$episode_key}}" class="flickity-lazyloaded drop-slider-img" width="300" height="200" alt="episodes">
                                                        <div class="controls">
                                                            
                                                            <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode_details->slug ) }}">
                                                                <i class="playBTN fas fa-play"></i>

                                                            <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-latest-series-Modal-'.$key.'-'.$episode_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                            
                                                            <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                {{-- <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $episode_details->season_name ." - Episode ".$episode_details->episode_order  }}</span> <br> --}}
                                                                {!! (strip_tags(substr(optional($episode_details)->title, 0, 150))) !!}
                                                            </p>

                                                            
                                                        </div>
                                                    </div>
                                                </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($latest_series->has_more)
                                            <div class="depends-row last-elmnt" style="height: 100%">
                                                <div class="depend-items d-flex align-items-center justify-content-center" style="height: 100%;background-color:#000;">
                                                    <a href="{{ URL::to('play_series/'.$latest_series->slug) }}">
                                                        <div class=" position-relative">
                                                           <p class="text-white">{{ "View all" }}</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Series Modal --}}

        @foreach ($data as $key => $latest_series )

            @foreach ($latest_series->Series_depends_episodes as $episode_key => $episode_details )
                <div class="modal fade info_model" id="{{ 'Home-latest-series-Modal-'.$key.'-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if ($multiple_compress_image == 1)
                                                    <img class="flickity-lazyloaded" alt="{{ $episode_details->title }}" src="{{ $episode_details->player_image_url }}"
                                                        srcset="{{ $episode_details->responsive_image ? (URL::to('public/uploads/PCimages/'.$episode_details->responsive_image.' 860w')) : $episode_details->player_image_url }},
                                                        {{ $episode_details->responsive_image ? URL::to('public/uploads/Tabletimages/'.$episode_details->responsive_image.' 640w') : $episode_details->player_image_url }},
                                                        {{ $episode_details->responsive_image ? URL::to('public/uploads/mobileimages/'.$episode_details->responsive_image.' 420w') : $episode_details->player_image_url }}" >
                                                @else
                                                    <img src="{{ $episode_details->player_image_url }}" alt="{{ $episode_details->title }}">
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($episode_details)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (optional($episode_details)->episode_description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($episode_details)->episode_description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode_details->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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

    var elem = document.querySelector('.latest-series-video');
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: false,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad: 6,
            setGallerySize: true,
            resize: true,   
        });

        

        document.querySelectorAll('.latest-series-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.latest-series-video .item').forEach(function(item) {
                item.classList.remove('current');
            });
    
            this.classList.add('current');
    
            var index = this.getAttribute('data-index');
    
            document.querySelectorAll('.series-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.series-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });
    
            // Hide all sliders
            document.querySelectorAll('.series-dropdown .series-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });
    
                    
            var selectedSlider = document.querySelector('.series-dropdown .series-depends-slider[data-index="' + index + '"]');
                if (selectedSlider) {
                    selectedSlider.style.display = 'block';
                    setTimeout(function() { // Ensure the element is visible before initializing Flickity
                        var flkty = new Flickity(selectedSlider, {
                            cellAlign: 'left',
                            contain: true,
                            groupCells: true,
                            pageDots: false,
                            draggable: true,
                            freeScroll: true,
                            imagesLoaded: true,
                            lazyLoad: true,
                        });
                    }, 0);
                }
    
            var selectedCaption = document.querySelector('.series-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.series-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }
    
            document.getElementsByClassName('series-dropdown')[0].style.display = 'flex';
        });
    });

    $('body').on('click', '.drp-close', function() {
        $('.series-dropdown').hide();
    });
    </script>


<script>
    $(document).on('click', '#latest-series-slider-img', function () {
        const SeriesId = $(this).data('series-id');

        $.ajax({
            url: '{{ route("getLatestSeriesImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                series_id: SeriesId
            },
            success: function (response) {
                let maxHeight = 0;
                const heightdiv = '.height-' + SeriesId + ' .flickity-viewport' ;
                const heightauto = '.height-' + SeriesId + ' .depends-row' ;

                console.log('heightdiv: ' + heightdiv);
                

                $('#series-bg-img-' + SeriesId).attr('src', response.series_image);
               
                response.episode_images.forEach((image, index) => {
                    const imgId = '#episodes_player_img-' + SeriesId + '-' + index;
                    $(imgId).attr('src', image);
                    // console.log("imgId : " + JSON.stringify($(imgId)));
                    const img = new Image();
                    img.src = image;

                    img.onload = function() {
                        const imgHeight = $(imgId).height();
                        // console.log("img imgId: " + JSON.stringify($(imgId)));

                        if (imgHeight > maxHeight) {
                            maxHeight = imgHeight;
                        }
                        
                        console.log("Current max height: " + maxHeight);
                        $(heightdiv).attr('style', 'height:' + maxHeight + 'px !important;');
                        $(imgId).attr('style', 'opacity:' + '1 !important;');
                    };
                });
                $(heightauto).css("height", "auto");
            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });
    });
</script>

<style>
    .series-depends-slider .flickity-viewport{height: 100px;}
    .drop-slider-img{opacity: 0 !important;}
    .content-list .depends-row div.depend-items, .content-list .depends-row{height: 100%;}
    .last-elmnt{height: 100% !important;}
    .depend-items:before{
        content: '';
        display: block;
        position: absolute;
        background-color: #555;
        background-image: url(https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp);
        background-size: cover;
        background-position: center;
        top: 2px;
        bottom: 2px;
        left: 2px;
        right: 2px;
        z-index: 0;
        border-radius: 10px;
    }
</style>