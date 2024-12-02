<?php

// latest viewed Videos

if (Auth::guest() != true) {
    $data = App\RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
        ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
        ->join('series', 'series.id', '=', 'episodes.series_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.episode_id')
        ->limit(15)
        ->get();
} else {
    $data = [];
}

?>

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[18]->url ? URL::to($order_settings_list[18]->url) : null }} ">{{ optional($order_settings_list[18])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[18]->url ? URL::to($order_settings_list[18]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-viewed-episode-video">
                                @foreach ($data as $key => $latest_view_episode)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $latest_view_episode->title }}" src="{{ $latest_view_episode->image ?  URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_view_episode->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_view_episode->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_view_episode->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_view_episode">
                                            @endif 
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <div id="videoInfo" class="viewed-episode-dropdown" style="display:none;">
                                <button class="drp-close">×</button>
                                <div class="vib" style="display:flex;">
                                    @foreach ($data as $key => $latest_view_episode)
                                        <div class="caption" data-index="{{ $key }}">
                                            <h2 class="caption-h2">{{ optional($latest_view_episode)->title }}</h2>

                                            <div class="d-flex align-items-center text-white text-detail">
                                                {{ App\SeriesSeason::where('id',$latest_view_episode->season_id)->pluck('series_seasons_name')->first() . " - Season" }}  
                                            </div>

                                            @if (optional($latest_view_episode)->description)
                                                <div class="trending-dec">{!! html_entity_decode( optional($latest_view_episode)->description) !!}</div>
                                            @endif

                                            <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                    <a href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                    <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-viewed_episode-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumbnail" data-index="{{ $key }}">
                                            <img src="{{ $latest_view_episode->player_image ?  URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                        </div>
                                    @endforeach
                                </div>
                            </div>




                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $latest_view_episode )
            <div class="modal fade info_model" id="{{ "Home-Latest-viewed_episode-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $latest_view_episode->player_image ?  URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_horizontal_image_url }}" alt="latest_view_episode">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($latest_view_episode)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($latest_view_episode)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($latest_view_episode)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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


<script>
    
    var elem = document.querySelector('.latest-viewed-episode-video');
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
    document.querySelectorAll('.latest-viewed-episode-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.latest-viewed-episode-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.viewed-episode-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.viewed-episode-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.viewed-episode-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.viewed-episode-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('viewed-episode-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.viewed-episode-dropdown').hide();
    });
</script>
