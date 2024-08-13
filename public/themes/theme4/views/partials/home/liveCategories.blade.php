@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ optional($order_settings_list[12])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list live-cate-video" data-flickity>
                                @foreach ($data as $key => $livecategories)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $livecategories->image ?  URL::to('public/uploads/livecategory/'.$livecategories->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{$livecategories->name}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
        
                        <div id="videoInfo" class="live-cate-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:block;">
                                @foreach ($data as $key => $livecategories)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($livecategories)->name }}</h2>
                                        @if (optional($livecategories)->description)
                                            <div class="trending-dec">{!! html_entity_decode(optional($livecategories)->description) !!}</div>
                                        @endif
                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('LiveCategory/'.$livecategories->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $livecategories->banner_image ?  URL::to('public/uploads/videocategory/'.$livecategories->banner_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>

                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'series-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}">
                                        <?php
                                            $liveCategory = App\CategoryLive::where('category_id', $livecategories->id)->groupBy('live_id')->pluck('live_id');

                                            $live_stream_videos = App\LiveStream::select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type',
                                                'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image',
                                                'live_streams.description', 'live_streams.recurring_program', 'live_streams.program_start_time', 'live_streams.program_end_time', 'live_streams.recurring_timezone',
                                                'live_streams.custom_start_program_time', 'live_streams.recurring_timezone')
                                                ->limit(15)->where('active', 1)->where('status', 1)->whereIn('id', $liveCategory)->latest()->limit(15)
                                                ->get();
                                        ?>
                                        @foreach($live_stream_videos as $live_key => $livestream_details)
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('live/'.$livestream_details->slug) }}">
                                                        <div class="position-relative">
                                                            <img src="{{ $livestream_details->image ?  URL::to('public/uploads/images/'.$livestream_details->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos">
                                                            <div class="controls">
                                                                <a href="{{ URL::to('live/'.$livestream_details->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>
                                                                <nav>
                                                                    <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-live-cats-Modal-'.$key.'-'.$live_key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                </nav>
                                                                <p class="trending-dec" style="position: absolute; bottom: 2px;">
                                                                    @if ($livestream_details->publish_type == "publish_later")
                                                                        {{ 'Live Start On '. Carbon\Carbon::parse($livestream_details->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }} <br>
                                                                    @elseif ($livestream_details->publish_type == "recurring_program" && $livestream_details->recurring_program != "custom")
                                                                        {{ 'Live Streaming '. $livestream_details->recurring_program .' from '. Carbon\Carbon::parse($livestream_details->program_start_time)->isoFormat('h:mm A') .' to '. Carbon\Carbon::parse($livestream_details->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_details->recurring_timezone)->pluck('time_zone')->first() }}
                                                                    @elseif ($livestream_details->publish_type == "recurring_program" && $livestream_details->recurring_program == "custom")
                                                                        {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_details->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_details->recurring_timezone)->pluck('time_zone')->first() }}
                                                                    @endif
                                                                    {{ optional($livestream_details)->title }}
                                                                    {!! strip_tags(substr(optional($livestream_details)->description, 0, 50)) !!}
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





        @foreach ($data as $key => $livecategories)

        <?php
            $liveCategory = App\CategoryLive::where('category_id', $livecategories->id)->groupBy('live_id')->pluck('live_id');

            $live_stream_videos = App\LiveStream::select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type',
                'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image',
                'live_streams.description', 'live_streams.recurring_program', 'live_streams.program_start_time', 'live_streams.program_end_time', 'live_streams.recurring_timezone',
                'live_streams.custom_start_program_time', 'live_streams.recurring_timezone')
                ->limit(15)->where('active', 1)->where('status', 1)->whereIn('id', $liveCategory)->latest()->limit(15)
                ->get();
        ?>

            @foreach ($live_stream_videos as $live_key => $livestream_details)
                <div class="modal fade info_model" id="{{ 'Home-live-cats-Modal-'.$key.'-'.$live_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <img  src="{{ $livestream_details->player_image ?  URL::to('public/uploads/images/'.$livestream_details->player_image) : $default_horizontal_image_url }}" alt="{{$livestream_details->title}}" >
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($livestream_details)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (optional($livestream_details)->description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($livestream_details)->description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('live/'.$livestream_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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
    var elem = document.querySelector('.live-cate-video');
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

    document.querySelectorAll('.live-cate-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.live-cate-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            this.classList.add('current');

            var index = this.getAttribute('data-index');

            document.querySelectorAll('.live-cate-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.live-cate-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            document.querySelectorAll('.live-cate-dropdown .series-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });

            var selectedSlider = document.querySelector('.live-cate-dropdown .series-depends-slider[data-index="' + index + '"]');
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

            var selectedCaption = document.querySelector('.live-cate-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.live-cate-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.querySelector('.live-cate-dropdown').style.display = 'flex';
        });
    });

    document.querySelector('.drp-close').addEventListener('click', function() {
        document.querySelector('.live-cate-dropdown').style.display = 'none';
    });
</script>
