@if (!empty($data) )

    @foreach($data as $section_key => $series_networks)
        @if (!empty($series_networks->Series_depends_Networks) && ($series_networks->Series_depends_Networks)->isNotEmpty())
        <section id="iq-trending-{{ $section_key }}" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12">
                                        
                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ optional($series_networks)->name }}</a></h4>
                            <h4 class="main-title"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ "View all" }}</a></h4>
                        </div>

                        <div id="based-networks" class="channels-list">
                            <div class="channel-row">
                                <div id="trending-slider-nav-{{ $section_key }}" class="video-list series-based-network-video flickity-slider">
                                    @foreach ($series_networks->Series_depends_Networks as $key => $series)
                                        <div class="item" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                            <div>
                                                <img src="{{ $series->image_url }}" class="flickity-lazyloaded" alt="{{ $series->title }}" width="300" height="200">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="videoInfo-{{ $section_key }}" class="series-based-network-dropdown" style="display:none;">
                                <button class="drp-close">×</button>
                                <div class="vib" style="display:block;">
                                    @foreach ($series_networks->Series_depends_Networks as $Series_depends_Networks_key => $series)
                                        <div class="w-100">
                                            <div class="caption" data-index="{{ $Series_depends_Networks_key }}" data-section-index="{{ $section_key }}">
                                                <h2 class="caption-h2">{{ optional($series)->title }}</h2>

                                                @if (optional($series)->description)
                                                    <div class="trending-dec">{!! html_entity_decode(substr(optional($series)->description, 0, 50)) !!}</div>
                                                @endif

                                                <div class="p-btns">
                                                    <div class="d-flex align-items-center p-0">
                                                        <a href="{{ route('network.play_series', $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                        {{-- <a href="{{ route('network.play_series', $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="thumbnail" data-index="{{ $Series_depends_Networks_key }}" data-section-index="{{ $section_key }}">
                                                <img src="{{ $series->Player_image_url }}" class="flickity-lazyloaded" alt="{{ $series->title }}" width="300" height="200">
                                            </div>

                                            <div id="network-slider-{{ $section_key }}-{{ $Series_depends_Networks_key }}" class="network-based-depends-slider networks-depends-series-slider-{{ $section_key }}-{{ $Series_depends_Networks_key }} content-list" data-index="{{ $Series_depends_Networks_key }}" data-section-index="{{ $section_key }}">
                                                @foreach ($series->Series_depends_episodes as $episode_key => $episode)
                                                    <div class="depends-row">
                                                        <div class="depend-items">
                                                            <a href="{{ URL::to('networks/episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                <div class="position-relative">
                                                                    @if ($multiple_compress_image == 1)
                                                                        <img class="flickity-lazyloaded" alt="{{ $episode->title }}" src="{{ $episode->player_image_url }}"
                                                                            srcset="{{ $episode->responsive_image ? (URL::to('public/uploads/PCimages/'.$episode->responsive_image.' 860w')) : $episode->player_image_url }},
                                                                            {{ $episode->responsive_image ? URL::to('public/uploads/Tabletimages/'.$episode->responsive_image.' 640w') : $episode->player_image_url }},
                                                                            {{ $episode->responsive_image ? URL::to('public/uploads/mobileimages/'.$episode->responsive_image.' 420w') : $episode->player_image_url }}" >
                                                                    @else
                                                                        <img src="{{ $episode->player_image_url }}" alt="{{ $episode->title }}">
                                                                    @endif
                                                                    <div class="controls">
                                                                        <a href="{{ URL::to('networks/episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                            <i class="playBTN fas fa-play"></i>
                                                                        </a>

                                                                        <nav>
                                                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Networks-based-categories-episode-Modal-'.$section_key.'-'.$Series_depends_Networks_key.'-'.$episode_key }}">
                                                                                <i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                        </nav>

                                                                        @php
                                                                            $series_seasons_name = App\SeriesSeason::where('id',$episode->season_id)->pluck('series_seasons_name')->first();
                                                                        @endphp

                                                                        <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                            <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $episode->season_name ." - Episode ".$episode->episode_order  }}</span> <br>
                                                                            {!! (strip_tags(substr(optional($episode)->title, 0, 150))) !!}
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if ($series->has_more)
                                                    <div class="depends-row" style="height: 100%">
                                                            <a href="{{ route('network.play_series', $series->slug) }}">
                                                            <div class="depend-items d-flex align-items-center justify-content-center" style="height: 100%;background-color:#000;">
                                                                <div class=" position-relative">
                                                                    <p class="text-white">{{ "View all" }}</p>
                                                                </div>
                                                            </div>
                                                        </a>
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
        </section>
        @endif
    @endforeach

    <div class="depend-episode-modal-demd" style="display: none;">
        {{-- Networks depends Episode Modal --}}
        @foreach($data as $section_key => $series_networks)
            @if (!empty($series_networks->Series_depends_Networks) && ($series_networks->Series_depends_Networks)->isNotEmpty())
                @foreach ($series_networks->Series_depends_Networks as $Series_depends_Networks_key => $series)
                    @foreach ($series->Series_depends_episodes as $episode_key => $episode)
                        <div class="modal fade info_model" id="{{ "Home-Networks-based-categories-episode-Modal-".$section_key.'-'.$Series_depends_Networks_key.'-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                <div class="container">
                                    <div class="modal-content" style="border:none; background:transparent;">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        @if ($multiple_compress_image == 1)
                                                            <img class="flickity-lazyloaded" alt="{{ $episode->title }}" src="{{ $episode->player_image_url }}"
                                                                srcset="{{ $episode->responsive_image ? (URL::to('public/uploads/PCimages/'.$episode->responsive_image.' 860w')) : $episode->player_image_url }},
                                                                {{ $episode->responsive_image ? URL::to('public/uploads/Tabletimages/'.$episode->responsive_image.' 640w') : $episode->player_image_url }},
                                                                {{ $episode->responsive_image ? URL::to('public/uploads/mobileimages/'.$episode->responsive_image.' 420w') : $episode->player_image_url }}" >
                                                        @else
                                                            <img src="{{ $episode->player_image_url }}" alt="{{ $episode->title }}">
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                                <h2 class="caption-h2">{{ optional($episode)->title }}</h2>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if (optional($episode)->episode_description)
                                                            <div class="trending-dec mt-4">{!! html_entity_decode(optional($episode)->episode_description) !!}</div>
                                                        @endif

                                                        <a href="{{ URL::to('networks/episode/'.$series->slug.'/'.$episode->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0"><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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
            @endif
        @endforeach
    </div>
@endif


<script>
    document.querySelectorAll('.series-based-network-video').forEach(function(elem) {
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: false,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad: 7,
            setGallerySize: true,
            resize: true, 
        });
    });

    flkty.reloadCells();
    document.querySelectorAll('.series-based-network-video').forEach(function(elem) {


    elem.querySelectorAll('.item').forEach(function(item) {
        item.addEventListener('click', function() {
            var sectionIndex = this.getAttribute('data-section-index');
            var index = this.getAttribute('data-index');

            // Remove current class from all items in this section
            elem.querySelectorAll('.item').forEach(function(item) {
                item.classList.remove('current');
            });
            this.classList.add('current');

            // Hide all captions and thumbnails in this section
            document.querySelectorAll('#videoInfo-' + sectionIndex + ' .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('#videoInfo-' + sectionIndex + ' .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            // Hide all sliders in this section
            document.querySelectorAll('#videoInfo-' + sectionIndex + ' .network-based-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });

            
            // Show the slider for the selected series
            var selectedSlider = document.querySelector('#videoInfo-' + sectionIndex + ' .network-based-depends-slider[data-index="' + index + '"]');
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(function() {
                    new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: false,
                        pageDots: false,
                        draggable: true,
                        freeScroll: true,
                        imagesLoaded: true,
                        lazyLoad: 7,
                    });
                },0);
            }

            var selectedCaption = document.querySelector('#videoInfo-' + sectionIndex + ' .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('#videoInfo-' + sectionIndex + ' .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
                $('.depend-episode-modal-demd').show();
            }

            document.getElementById('videoInfo-' + sectionIndex).style.display = 'flex';
        });
    });
});
document.querySelectorAll('.drp-close').forEach(function(closeButton) {
    closeButton.addEventListener('click', function() {
        var dropdown = this.closest('.series-based-network-dropdown');
        dropdown.style.display = 'none';
    });
});

</script>

