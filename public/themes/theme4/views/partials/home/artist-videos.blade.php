@php
    $check_Kidmode = 0 ;

    $data =  App\Artist::limit(15)->get()->map(function($item) use($check_Kidmode,$videos_expiry_date_status,$getfeching){

        // Videos

        $Videoartist = App\Videoartist::where('artist_id',$item->id)->groupBy('video_id')->pluck('video_id');

        $item['artist_depends_videos'] = App\Video::select('id','title','description','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','player_image')

                                            ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$Videoartist);

                                            if( $getfeching !=null && $getfeching->geofencing == 'ON')
                                            {
                                                $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNotIn('videos.id',Block_videos());
                                            }

                                            if ($check_Kidmode == 1) {
                                                $item['artist_depends_videos']->whereBetween('videos.age_restrict', [0, 12]);
                                            }

                                            if ($videos_expiry_date_status == 1 ) {
                                                $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                                            }

        $item['artist_depends_videos'] = $item['artist_depends_videos']->latest()->limit(15)->get()->map(function ($item) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
                                        $item['source']           = 'series';
                                        return $item;
                                    });

        // Series

        $Seriesartist = App\Seriesartist::where('artist_id',$item->id)->groupBy('series_id')->pluck('series_id');

        $item['artist_depends_series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                                    ->where('active', '1')->whereIn('id',$Seriesartist)->latest()->limit(15)->get()
                                    ->map(function ($item) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
                                        $item['season_count']     =  App\SeriesSeason::where('series_id',$item->id)->count();
                                        $item['episode_count']    =  App\Episode::where('series_id',$item->id)->count();
                                        $item['source']           = 'series';
                                        return $item;
                                    });


        // Series

        $Seriesartist = App\Seriesartist::where('artist_id',$item->id)->groupBy('series_id')->pluck('series_id');

        $item['artist_depends_series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                            'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                            ->where('active', '1')->whereIn('id',$Seriesartist)->latest()->limit(15)->get()
                            ->map(function ($item) {
                                $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
                                $item['season_count']     =  App\SeriesSeason::where('series_id',$item->id)->count();
                                $item['episode_count']    =  App\Episode::where('series_id',$item->id)->count();
                                $item['source']           = 'series';
                                return $item;
                            });

        // Audio

        $Audioartist = App\Audioartist::where('artist_id',$item->id)->groupBy('audio_id')->pluck('audio_id');

        $item['artist_depends_audios'] = App\Audio::select('id','title','slug','year','rating','access','ppv_price','duration','rating','image',
                                        'featured','player_image','details','description')

                        ->where('active',1)->where('status', 1)->where('draft',1)->WhereIn('id',$Audioartist);

                if( $getfeching !=null && $getfeching->geofencing == 'ON')
                {
                    $item['artist_depends_audios'] = $item['artist_depends_audios']->whereNotIn('id',Block_audios());
                }

            $item['artist_depends_audios'] = $item['artist_depends_audios']->limit(15)->latest()->get()->map(function ($item) {
                            $item['image_url'] = $item->image != null ? URL::to('/public/uploads/audios/'.$item->image) : $default_vertical_image_url ;
                            $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/audios/'.$item->player_image) : $default_horizontal_image_url ;
                            return $item;
                        });

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
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ optional($order_settings_list[8])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list artist-video">
                                @foreach ($data as $key => $artist_details)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $artist_details->image ? URL::to('public/uploads/artists/'.$artist_details->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{$artist_details->artist_name}}" width="300" height="200">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="artist-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $artist_details)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($artist_details)->artist_name }}</h2>

                                        @if (optional($artist_details)->description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($artist_details)->description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('artist/'.$artist_details->artist_slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-continue-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $artist_details->player_image ?  URL::to('public/uploads/images/'.$artist_details->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>

                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}" >
                                        @foreach ($artist_details->artist_depends_videos as $video_key => $artist_content )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('category/videos/'.$artist_content->slug) }}">
                                                        <div class=" position-relative">
                                                            <img src="{{ $artist_content->image_url }}" class="img-fluid" alt="Videos">                                                                                <div class="controls">

                                                                <a href="{{ URL::to('category/videos/'.$artist_content->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>

                                                                <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-videos-Modal-'.$key.'-'.$video_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

                                                                <p class="trending-dec" >
                                                                    {{ optional($artist_content)->title   }}
                                                                    {!! (strip_tags(substr(optional($artist_content)->description, 0, 50))) !!}
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach  ($artist_details->artist_depends_series as $series_key => $artist_series_content )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                        <div class=" position-relative">
                                                            <img src="{{ $artist_series_content->image_url }}" class="img-fluid" alt="Videos">                                                                                <div class="controls">

                                                                <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>

                                                                <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

                                                                <p class="trending-dec" >
                                                                    {{ optional($artist_series_content)->title}}
                                                                    {!! (strip_tags(substr(optional($artist_series_content)->description, 0, 50))) !!}
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach  ($artist_details->artist_depends_audios as $artist_audios_content )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('audio/'.$artist_audios_content->slug) }}">
                                                        <div class=" position-relative">
                                                            <img src="{{ $artist_audios_content->image_url }}" class="img-fluid" alt="{{$artist_audios_content->title}}">                                                                                <div class="controls">

                                                                <a href="{{ URL::to('audio/'.$artist_audios_content->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>

                                                                <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target=""><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

                                                                <p class="trending-dec" >
                                                                    {{ optional($artist_audios_content)->title   }}
                                                                    {!! (strip_tags(substr(optional($artist_audios_content)->description, 0, 50))) !!}
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

        {{-- video modal --}}
        @foreach ($data as $key => $artist_details)
            @foreach ($artist_details->artist_depends_videos as $video_key => $artist_content )
                <div class="modal fade info_model" id="{{ 'Home-videos-Modal-'.$key.'-'.$video_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <img class="lazy" src="{{ URL::to('public/uploads/images/'.$artist_content->player_image) }}" alt="{{ $artist_content->title }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($artist_content)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (optional($artist_content)->description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($artist_content)->description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('category/videos/'.$artist_content->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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

        {{-- series modal --}}
        @foreach ($data as $key => $artist_details)
            @foreach  ($artist_details->artist_depends_series as $series_key => $artist_series_content )
                <div class="modal fade info_model" id="{{ 'Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <img class="lazy" src="{{ URL::to('public/uploads/images/'.$artist_series_content->player_image) }}" alt="{{ $artist_series_content->title }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($artist_series_content)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="trending-dec mt-4" >
                                                    {{ $artist_series_content->season_count ." Series ".$artist_series_content->episode_count .' Episodes' }}
                                                </div>

                                                @if (optional($artist_series_content)->description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($artist_series_content)->description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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

    var elem = document.querySelector('.artist-video');
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: true,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyload:true,
        });
        document.querySelectorAll('.artist-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.artist-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            this.classList.add('current');

            var index = this.getAttribute('data-index');

            document.querySelectorAll('.artist-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.artist-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            // Hide all sliders
            document.querySelectorAll('.artist-dropdown .network-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });


            var selectedSlider = document.querySelector('.artist-dropdown .network-depends-slider[data-index="' + index + '"]');
                if (selectedSlider) {
                    selectedSlider.style.display = 'block';
                    setTimeout(function() { // Ensure the element is visible before initializing Flickity
                        var flkty = new Flickity(selectedSlider, {
                            cellAlign: 'left',
                            contain: true,
                            groupCells: true,
                            adaptiveHeight: true,
                            pageDots: false,
                        });
                    }, 0);
                }

            var selectedCaption = document.querySelector('.artist-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.artist-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('artist-dropdown')[0].style.display = 'flex';
        });
    });

    $('body').on('click', '.drp-close', function() {
        $('.artist-dropdown').hide();
    });
    </script>
