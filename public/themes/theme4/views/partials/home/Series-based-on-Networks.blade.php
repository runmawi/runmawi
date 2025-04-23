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
                                        <div id="top-slider-img" class="item" data-index="{{ $key }}" data-section-index="{{ $section_key }}" data-series-id="{{ $series->id }}">
                                            <div>
                                                <img data-flickity-lazyload="{{ $series->image_url }}" class="flickity-lazyloaded" alt="{{ $series->title }}" width="300" height="200">
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
                                                <h2 id="series_title-{{ $series->id }}-{{$section_key}}" class="caption-h2"></h2>

                                                <div id="series_description-{{ $series->id }}-{{$section_key}}" class="trending-dec"></div>

                                                <div class="p-btns">
                                                    <div class="d-flex align-items-center p-0">
                                                        <a href="" id="series_slug-{{ $series->id }}-{{$section_key}}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                        {{-- <a href="{{ route('network.play_series', $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="thumbnail" data-index="{{ $Series_depends_Networks_key }}" data-section-index="{{ $section_key }}">
                                                <img id="series_player_img-{{ $series->id }}-{{$section_key}}" class="flickity-lazyloaded" alt="{{ $series->title }}" width="300" height="200">
                                            </div>

                                            <div id="network-slider-{{ $section_key }}-{{ $Series_depends_Networks_key }}" class="network-based-depends-slider networks-depends-series-slider-{{ $section_key }}-{{ $Series_depends_Networks_key }} content-list height-{{ $series->id }}-{{$section_key}}" data-index="{{ $Series_depends_Networks_key }}" data-section-index="{{ $section_key }}">
                                                @foreach ($series->Series_depends_episodes as $episode_key => $episode)
                                                    <div class="depends-row">
                                                        <div class="depend-items">
                                                            <a href="{{ URL::to('networks/episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                <div class="position-relative">
                                                                    <img id="episode_player_img-{{ $series->id }}-{{$section_key}}-{{ $episode_key }}" class="flickity-lazyloaded drop-slider-img" width="300" height="200" alt="{{ $episode->title}}">
                                                                    <div class="controls">
                                                                        <a href="{{ URL::to('networks/episode/'.$series->slug.'/'.$episode->slug ) }}" class="playBTN">
                                                                            <i class="fas fa-play"></i>
                                                                        </a>

                                                                            <button id="data-modal-based-network" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-Networks-based-categories-episode-Modal" data-episode-id="{{ $episode->id }}">
                                                                                <i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                        
                                                                        @php
                                                                            $series_seasons_name = App\SeriesSeason::where('id',$episode->season_id)->pluck('series_seasons_name')->first();
                                                                        @endphp

                                                                        <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                            {{-- <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $episode->season_name ." - Episode ".$episode->episode_order  }}</span> <br> --}}
                                                                            {!! (strip_tags(substr(optional($episode)->title, 0, 150))) !!}
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if ($series->has_more)
                                                    <div class="depends-row last-elmnt" style="height: 100% !important;">
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

    <div class="depend-episode-modal-demd">
        <div class="modal fade info_model" id="Home-Networks-based-categories-episode-Modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                <div class="container">
                    <div class="modal-content" style="border:none; background:transparent;">
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <img id="episode_modal-img" src="https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp" width="460" height="259">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                <h2 class="modal-title caption-h2"></h2>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                        </div>

                                            <div class="modal-desc trending-dec mt-4"></div>

                                        <a href="" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0"><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div id="network-sections-container"></div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let offset = 2;
    const limit = 2;
    let isLoading = false;
    const sectionKey = 2;

    $(window).scroll(function() {
        
        if ((($(window).scrollTop() + $(window).height()) > ($(document).height() - 1500)) && !isLoading)  {
            isLoading = true;
            $.ajax({
                url: '{{ route("loadMoreNetworksSections") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    offset: offset,
                    limit: limit,
                    section_key: sectionKey,
                },
                success: function(response) {
                    if (response.data.length > 0) {
                        response.data.forEach(function(newSection, index) {
                            const newSectionKey = offset + index;
                            
                            const sectionHtml = `
                                <section id="iq-trending-${newSectionKey}" class="s-margin">
                                    <div class="container-fluid pl-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="iq-main-header d-flex align-items-center justify-content-between">
                                                    <h4 class="main-title mar-left"><a href="{{ route('Specific_Series_Networks', ['']) }}/${newSection.slug}">${newSection.name}</a></h4>
                                                    <h4 class="main-title"><a href="{{ route('Specific_Series_Networks', ['']) }}/${newSection.slug}">View all</a></h4>
                                                </div>

                                                <div class="channels-list">
                                                    <div class="channel-row">
                                                        <div id="trending-slider-nav-${newSectionKey}" class="video-list series-based-network-video flickity-slider new-networks-sections" data-new-sectionkey="${newSectionKey}">
                                                            ${newSection.Series_depends_Networks.map((series, seriesIndex) => `
                                                                <div class="item" id="top-slider-img" data-index="${seriesIndex}" data-section-index="${newSectionKey}" data-series-id="${series.id}">
                                                                    <div>
                                                                        <img data-flickity-lazyload="${series.image_url}" class="flickity-lazyloaded" alt="${series.title}" width="300" height="200">
                                                                    </div>
                                                                </div>
                                                            `).join('')}
                                                        </div>
                                                    </div>

                                                    <div id="videoInfo-${newSectionKey}" class="series-based-network-dropdown" style="display:none;">
                                                        <button class="drp-close">×</button>
                                                        <div class="vib" style="display:block;">
                                                            ${newSection.Series_depends_Networks.map((series, seriesIndex) => `
                                                                <div class="w-100" data-index="${seriesIndex}">
                                                                    <div class="caption" data-index="${seriesIndex}" data-section-index="${newSectionKey}">
                                                                        <h2 id="series_title-${series.id}-${newSectionKey}" class="caption-h2"></h2>

                                                                        <div id="series_description-${series.id}-${newSectionKey}" class="trending-dec"></div>
                                                                       
                                                                        <div class="p-btns">
                                                                            <div class="d-flex align-items-center p-0">
                                                                                <a href="" id="series_slug-${series.id}-${newSectionKey}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="thumbnail" data-index="${seriesIndex}" data-section-index="${newSectionKey}">
                                                                        <img id="series_player_img-${series.id}-${newSectionKey}" class="flickity-lazyloaded" alt="" width="300" height="200">
                                                                    </div>

                                                                    <div id="network-slider-${newSectionKey}-${seriesIndex}" class="network-based-depends-slider networks-depends-series-slider-${newSectionKey}-${seriesIndex} content-list height-${series.id}-${newSectionKey}" data-index="${seriesIndex}" data-section-index="${newSectionKey}">
                                                                        ${Array.isArray(series.Series_depends_episodes) ? series.Series_depends_episodes.map((episode, episode_key) => `
                                                                            <div class="depends-row">
                                                                                <div class="depend-items">
                                                                                    <a href="{{ URL::to('networks/episode/') }}/${series.slug}/${episode.slug}">
                                                                                        <div class="position-relative">
                                                                                            <img id="episode_player_img-${series.id}-${newSectionKey}-${episode_key}" class="flickity-lazyloaded drop-slider-img" width="300" height="200" alt="${episode.title}">
                                                                                            <div class="controls">
                                                                                                <a href="{{ URL::to('networks/episode/') }}/${series.slug}/${episode.slug}" class="playBTN">
                                                                                                    <i class="fas fa-play"></i>
                                                                                                </a>
                                                                                                <button id="data-modal-based-network" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-Networks-based-categories-episode-Modal" data-episode-id="${episode.id}">
                                                                                                    <i class="fas fa-info-circle"></i><span>More info</span>
                                                                                                </button>
                                                                                                <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                                                    ${episode.title}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        `).join('') : ''}
                                                                        ${series.has_more ? `
                                                                            <div class="depends-row last-elmnt" style="height: 100% !important;">
                                                                                <a href="${window.location.origin}/network/play-series/${series.slug}">
                                                                                    <div class="depend-items d-flex align-items-center justify-content-center" style="height: 100%;background-color:#000;">
                                                                                        <div class="position-relative">
                                                                                            <p class="text-white">View all</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        ` : ''}
                                                                    </div>


                                                                </div>
                                                            `).join('')}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>`;
                            
                            $('#network-sections-container').append(sectionHtml);

                            // Initialize Flickity for this new section
                            initializeFlickityForSection(newSectionKey);

                            setupSectionClickHandlers(newSectionKey);
                            
                        });
                        
                        offset += response.data.length;
                    }
                    isLoading = false;
                },
                error: function() {
                    console.log('Failed to load sections. Please try again.');
                    isLoading = false;
                }
            });
        }
    });

    function initializeFlickityForSection(sectionKey) {
        const slider = document.getElementById(`trending-slider-nav-${sectionKey}`);
        if (slider) {
            new Flickity(slider, {
                cellAlign: 'left',
                contain: true,
                groupCells: false,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyLoad: 7
            });
        }
        
    }

    function setupSectionClickHandlers(sectionKey) {
        // Handle clicks on slider items
        $(`#trending-slider-nav-${sectionKey} .item`).on('click', function() {
            const index = $(this).data('index');
            const seriesId = $(this).data('series-id');
            const sectionIndex = $(this).data('section-index');
            const dropdown = $(`#videoInfo-${sectionKey}`);
            
            dropdown.find('.w-100').hide();
            
            const contentDiv = dropdown.find(`.w-100[data-index="${index}"]`);
            contentDiv.show();
            
            dropdown.show();
            
            contentDiv.find('a.button-groups').attr('href', '{{ route("network.play_series", "") }}/' + $(this).data('series-slug'));
        
            var selectedSlider = document.querySelector(`#videoInfo-${sectionIndex} .network-based-depends-slider[data-index="${index}"]`);
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(() => {
                    new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: true,
                        pageDots: false,
                        draggable: true,
                        freeScroll: true,
                        imagesLoaded: true,
                        lazyLoad: true,
                    }).resize();
                }, 0);
            }
        
        });
        
        $(`#videoInfo-${sectionKey} .drp-close`).on('click', function() {
            $(this).closest('.series-based-network-dropdown').hide();
        });

    }

    
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    function initializeFlickity() {
        document.querySelectorAll('.series-based-network-video').forEach(function (elem) {
            // Hide carousel initially to prevent vertical stacking
            elem.style.visibility = 'hidden';
            elem.style.opacity = '0';

            imagesLoaded(elem, function () {
                console.log("All images loaded, initializing Flickity...");

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

                // Ensure Flickity resizes properly in Safari
                flkty.on('ready', function () {
                    flkty.resize();
                    flkty.reloadCells();
                });

                // Force reflow before displaying (fixes vertical stacking)
                elem.getBoundingClientRect();

                // Show carousel only after initialization
                requestAnimationFrame(() => {
                    elem.style.visibility = 'visible';
                    elem.style.opacity = '1';
                    flkty.resize();
                });

                // Reinitialize Flickity on window resize (Fixes Mobile Safari Issues)
                window.addEventListener('resize', function () {
                    setTimeout(() => {
                        flkty.resize();
                        flkty.reloadCells();
                    }, 200);
                });

                // Click event for selecting items
                elem.querySelectorAll('.item').forEach(function (item) {
                    item.addEventListener('click', function () {
                        var sectionIndex = this.getAttribute('data-section-index');
                        var index = this.getAttribute('data-index');
                        
                        // Remove "current" class from all items
                        elem.querySelectorAll('.item').forEach(i => i.classList.remove('current'));
                        this.classList.add('current');

                        // Hide all captions, thumbnails, and sliders
                        document.querySelectorAll(`#videoInfo-${sectionIndex} .caption, 
                                                   #videoInfo-${sectionIndex} .thumbnail, 
                                                   #videoInfo-${sectionIndex} .network-based-depends-slider`)
                            .forEach(el => el.style.display = 'none');

                        // Show the selected slider
                        var selectedSlider = document.querySelector(`#videoInfo-${sectionIndex} .network-based-depends-slider[data-index="${index}"]`);
                        if (selectedSlider) {
                            selectedSlider.style.display = 'block';
                            setTimeout(() => {
                                new Flickity(selectedSlider, {
                                    cellAlign: 'left',
                                    contain: true,
                                    groupCells: true,
                                    pageDots: false,
                                    draggable: true,
                                    freeScroll: true,
                                    imagesLoaded: true,
                                    lazyLoad: true,
                                }).resize();
                            }, 0);
                        }

                        var selectedCaption = document.querySelector(`#videoInfo-${sectionIndex} .caption[data-index="${index}"]`);
                        var selectedThumbnail = document.querySelector(`#videoInfo-${sectionIndex} .thumbnail[data-index="${index}"]`);
                        if (selectedCaption && selectedThumbnail) {
                            selectedCaption.style.display = 'block';
                            selectedThumbnail.style.display = 'block';
                            document.querySelector('.depend-episode-modal-demd').style.display = 'block';
                        }

                        document.getElementById(`videoInfo-${sectionIndex}`).style.display = 'flex';
                    });
                });
            });
        });
    }

    // Ensure Flickity initializes only after all images are loaded
    window.addEventListener('load', initializeFlickity);

    // Close dropdown on click
    document.querySelectorAll('.drp-close').forEach(closeButton => {
        closeButton.addEventListener('click', function () {
            var dropdown = this.closest('.series-based-network-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        });
    });
});

    $(document).on('click', '#top-slider-img', function () {

        const seriesId = $(this).data('series-id');
        const sectionKey = $(this).data('section-index');

        const isLoaded = $('#series_player_img-' + seriesId + '-' + sectionKey).data('loaded');
        
        if (isLoaded) {
            return;
        }

        $.ajax({
            url: '{{ route("getSeriesEpisodeImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                series_id: seriesId
            },
            success: function (response) {
                // console.log('series img: ' + response.episode_images);
                // console.log('series_title: ', response.series_title);
                // console.log('series_description: ' + response.series_description);
                console.log('series_slug: ' + response.series_slug);

                let maxHeight = 0;
                const heightdiv = '.height-' + seriesId + '-' + sectionKey + ' .flickity-viewport' ;
                const heightauto = '.height-' + seriesId + '-' + sectionKey + ' .depends-row' ;

                $('#series_player_img-' + seriesId + '-' + sectionKey).attr('src', response.series_image);
                $('#series_title-' + seriesId + '-' + sectionKey).text(response.series_title);
                $('#series_description-' + seriesId + '-' + sectionKey).text(response.series_description);
                $('#series_slug-' + seriesId + '-' + sectionKey).attr('href', response.series_slug);
                $('#series_player_img-' + seriesId + '-' + sectionKey).data('loaded', true);
               
                response.episode_images.forEach((image, index) => {
                    const imgId = '#episode_player_img-' + seriesId + '-' + sectionKey + '-' + index;
                    $(imgId).attr('src', image);
                   
                    const img = new Image();
                    img.src = image;

                    img.onload = function() {
                        const imgHeight = $(imgId).height();

                        if (imgHeight > maxHeight) {
                            maxHeight = imgHeight;
                        }
                        
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

    $(document).on('click', '#data-modal-based-network', function() {
        const episodeId = $(this).data('episode-id');
        // console.log("modal opened.");
        $.ajax({
            url: '{{ route("getModalEpisodeImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                episode_id : episodeId
            },
            success: function (response) {
                // console.log("image: " + response.image);
                // console.log("title: " + response.title);
                // console.log("description: " + response.description);
                // const slug = 'live/' + response.slug;
                console.log("slug: " + response.slug);
                $('#episode_modal-img').attr('src', response.image);
                $('#episode_modal-img').attr('alt', response.title);
                $('.modal-title').text(response.title);
                $('.modal-desc').text(response.description);
                $('.btn.btn-hover').attr('href', response.slug);
                

            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });

        $('.btn-close-white').on('click', function () {
            $('#episode_modal-img').attr('src', 'https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp');
            $('.modal-title').text('');
            $('.modal-desc').text('');
            $('.btn.btn-hover').attr('href', '');
        });


    });
</script>

<style>
    .network-based-depends-slider .flickity-viewport{height: 100px;}
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
    .moreBTN{
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
    }
</style>

