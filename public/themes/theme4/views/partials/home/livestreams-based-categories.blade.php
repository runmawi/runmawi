<?php

$data = App\LiveCategory::query()->limit(15)
    ->whereHas('category_livestream', function ($query) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1);
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 'live_streams.description')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->latest('live_streams.created_at')
                ->limit(15);
        },
    ])
    ->select('live_categories.id', 'live_categories.name', 'live_categories.slug', 'live_categories.order')
    ->orderBy('live_categories.order')
    ->get();

$data->each(function ($category) {
    $category->category_livestream->transform(function ($item) {
        $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
        $item['description'] = $item->description;
        $item['source'] = 'Livestream';
        return $item;
    });
    $category->source = 'live_category';
    return $category;
});

?>


@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $section_key => $live_Category )
        @if (!empty($live_Category->category_livestream) && $live_Category->category_livestream->isNotEmpty())
            <section id="iq-trending-{{ $section_key }}" class="s-margin">
                <div class="container-fluid pl-0">
                    <div class="row">
                        <div class="col-sm-12 overflow-hidden">

                                            {{-- Header --}}
                            <div class="iq-main-header d-flex align-items-center justify-content-between">
                                <h4 class="main-title mar-left"><a
                                    href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ optional($live_Category)->name }}</a>
                                </h4>
                                <h4 class="main-title"><a
                                    href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ 'view all' }}</a>
                                </h4>
                            </div>

                            <div id="based-videos" class="channels-list">
                                <div class="channel-row">
                                    <div id="trending-slider-nav-{{ $section_key }}" class="video-list live-based-cate-video" data-flickity>
                                        @foreach ($live_Category->category_livestream as $key => $livestream_videos )
                                            <div class="item" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                                <div>
                                                    <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="livestream_videos" width="300" height="200">
                                                    @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time)))
                                                        <div ><img class="blob" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="liveCate-{{ $section_key }}" class="videos-based-network-dropdown" style="display:none;">
                                    <button class="drp-close">×</button>
                                    <div class="vib" style="display:block;">
                                        @foreach ($live_Category->category_livestream as $key => $livestream_videos )
                                            <div class="caption" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                                <h2 class="caption-h2">{{ $livestream_videos->title }}</h2>

                                                @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time)))
                                                    <ul class="vod-info">
                                                        <li><span></span> LIVE NOW</li>
                                                    </ul>
                                                @elseif ($livestream_videos->publish_type == "publish_later")
                                                    <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($livestream_videos->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }} </span>

                                                @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program != "custom" )
                                                    <span class="trending"> {{ 'Live Streaming '. $livestream_videos->recurring_program ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                                @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program == "custom" )
                                                    <span class="trending"> {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_videos->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                @endif

                                                @if ( $livestream_videos->year != null && $livestream_videos->year != 0 )
                                                    <div class="d-flex align-items-center text-white text-detail">
                                                        <span class="trending">{{ ($livestream_videos->year != null && $livestream_videos->year != 0) ? $livestream_videos->year : null   }}</span>
                                                    </div>
                                                @endif

                                                @if ( optional($livestream_videos)->description )
                                                    <p class="trending-dec">{!! html_entity_decode( optional($livestream_videos)->description) !!}</p>
                                                @endif

                                                <div class="p-btns">
                                                    <div class="d-flex align-items-center p-0">
                                                        <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                        <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Livestream-basedcategory-Modal-'.$section_key.'-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="thumbnail" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                                @if ($multiple_compress_image == 1)
                                                    <img class="flickity-lazyloaded" alt="{{ $livestream_videos->title }}" width="300" height="200" src="{{ $livestream_videos->player_image ? URL::to('public/uploads/images/' . $livestream_videos->player_image) : $default_horizontal_image_url }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/' . $livestream_videos->responsive_player_image . ' 860w') }},
                                                                {{ URL::to('public/uploads/Tabletimages/' . $livestream_videos->responsive_player_image . ' 640w') }},
                                                                {{ URL::to('public/uploads/mobileimages/' . $livestream_videos->responsive_player_image . ' 420w') }}">
                                                @else
                                                    <img src="{{ $livestream_videos->Player_image_url }}" class="flickity-lazyloaded" alt="{{ $livestream_videos->title }}" width="300" height="200">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @foreach ($live_Category->category_livestream as $key => $livestream_videos )
                    <div class="modal fade info_model" id="{{ 'Home-Livestream-basedcategory-Modal-'.$section_key.'-'.$key }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                            <div class="container">
                                <div class="modal-content" style="border:none; background:transparent;">
                                    <div class="modal-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_horizontal_image_url }}" alt="modal">
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                                            <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                                            <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                                <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                            </button>
                                                        </div>
                                                    </div>


                                                    @if (optional($livestream_videos)->description)
                                                        <div class="trending-dec mt-4">{!! html_entity_decode( optional($livestream_videos)->description) !!}</div>
                                                    @endif

                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </section>
        @endif
    @endforeach
@endif


<script>
    document.querySelectorAll('.live-based-cate-video').forEach(function(elem) {
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

        elem.querySelectorAll('.item').forEach(function(item) {
            item.addEventListener('click', function() {
                var sectionIndex = this.getAttribute('data-section-index');
                var index = this.getAttribute('data-index');

                elem.querySelectorAll('.item').forEach(function(item) {
                    item.classList.remove('current');
                });
                this.classList.add('current');

                document.querySelectorAll('#liveCate-' + sectionIndex + ' .caption').forEach(function(caption) {
                    caption.style.display = 'none';
                });
                document.querySelectorAll('#liveCate-' + sectionIndex + ' .thumbnail').forEach(function(thumbnail) {
                    thumbnail.style.display = 'none';
                });

                var selectedCaption = document.querySelector('#liveCate-' + sectionIndex + ' .caption[data-index="' + index + '"]');
                var selectedThumbnail = document.querySelector('#liveCate-' + sectionIndex + ' .thumbnail[data-index="' + index + '"]');
                if (selectedCaption && selectedThumbnail) {
                    selectedCaption.style.display = 'block';
                    selectedThumbnail.style.display = 'block';
                }

                document.getElementById('liveCate-' + sectionIndex).style.display = 'flex';
            });
        });
    });

    document.querySelectorAll('.drp-close').forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            var dropdown = this.closest('.videos-based-network-dropdown');
            dropdown.style.display = 'none';
        });
    });
    </script>


<style>

    .blob {
        margin: 10px;
        height: 22px;
        width: 59px;
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
        transform: scale(1);
        animation: pulse 2s infinite;
        position:absolute;
        top:0;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
    </style>
