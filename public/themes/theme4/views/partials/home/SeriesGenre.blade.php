@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ optional($order_settings_list[19])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-series-video" data-flickity>
                                @foreach ($data as $key => $seriesGenre)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $seriesGenre->image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="Videos">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    
                        <div id="videoInfo" class="series-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:block;">
                                @foreach ($data as $key => $seriesGenre)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($seriesGenre)->name }}</h2>
                                        @if (optional($seriesGenre)->description)
                                            <div class="trending-dec">{!! html_entity_decode(optional($seriesGenre)->description) !!}</div>
                                        @endif
                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('series/category/'. $seriesGenre->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $seriesGenre->banner_image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->banner_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                    
                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'series-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}">
                                        <?php
                                            $SeriesCategory = App\SeriesCategory::where('category_id', $seriesGenre->id)->groupBy('series_id')->pluck('series_id');
                    
                                            $series = App\Series::select('id', 'title', 'slug', 'access', 'active', 'ppv_status', 'featured', 'duration', 'image', 'embed_code',
                                                'mp4_url', 'webm_url', 'ogg_url', 'url', 'tv_image', 'player_image', 'details', 'description')
                                                ->where('active', '1')->whereIn('id', $SeriesCategory);
                    
                                            $series = $series->latest()->limit(15)->get()->map(function ($item) {
                                                $item['image_url'] = $item->image != null ? URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url;
                                                $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url();
                                                $item['TV_image_url'] = $item->tv_image != null ? URL::to('public/uploads/images/'.$item->tv_image) : default_horizontal_image_url();
                                                $item['season_count'] = App\SeriesSeason::where('series_id', $item->id)->count();
                                                $item['episode_count'] = App\Episode::where('series_id', $item->id)->count();
                                                return $item;
                                            });
                                        ?>
                                        @foreach ($series as $series_key => $series_details)
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('series/category/'. $seriesGenre->slug) }}">
                                                        <div class="position-relative">
                                                            <img src="{{ $series_details->image ? URL::to('public/uploads/images/'.$series_details->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos">
                                                            <div class="controls">
                                                                <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>
                                                                <nav>
                                                                    <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-SeriesGenre-series-Modal-'.$key.'-'.$series_key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                </nav>
                                                                <p class="trending-dec">
                                                                    {{ $series_details->season_count ." S ".$series_details->episode_count .' E' }} <br>
                                                                    {{ optional($series_details)->title }} <br>
                                                                    {!! strip_tags(substr(optional($series_details)->description, 0, 50)) !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        {{-- Series Modal --}}

        @foreach ($data as  $key => $seriesGenre )

            <?php

                $SeriesCategory = App\SeriesCategory::where('category_id',$seriesGenre->id)->groupBy('series_id')->pluck('series_id'); 

                $series = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                                'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                                                ->where('active', '1')->whereIn('id',$SeriesCategory);

                $series = $series->latest()->limit(15)->get()->map(function ($item) {
                            $item['image_url'] = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                            $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                            $item['TV_image_url'] = $item->tv_image != null ?  URL::to('public/uploads/images/'.$item->tv_image) : default_horizontal_image_url() ;       
                            $item['season_count'] =  App\SeriesSeason::where('series_id',$item->id)->count();
                            $item['episode_count'] =  App\Episode::where('series_id',$item->id)->count();
                            return $item;
                        });  
                
            ?>

            @foreach ($series as $series_key => $series_details )
                <div class="modal fade info_model" id="{{ 'Home-SeriesGenre-series-Modal-'.$key.'-'.$series_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img  src="{{ $series_details->player_image ?  URL::to('public/uploads/images/'.$series_details->player_image) : default_horizontal_image_url() }}" alt="" width="100%">
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
    var elem = document.querySelector('.latest-series-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
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

            document.querySelectorAll('.series-dropdown .series-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });

            var selectedSlider = document.querySelector('.series-dropdown .series-depends-slider[data-index="' + index + '"]');
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(function() {
                    var flkty = new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: true,
                        adaptiveHeight: true,
                        pageDots: false,
                    });
                }, 0);
            }

            var selectedCaption = document.querySelector('.series-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.series-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.querySelector('.series-dropdown').style.display = 'flex';
        });
    });

    $('body').on('click', '.drp-close', function() {
        $('.series-dropdown').hide();
    });
</script>