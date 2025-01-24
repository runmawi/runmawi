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

                                                                        <nav>
                                                                            <button id="data-modal-based-network" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-Networks-based-categories-episode-Modal" data-episode-id="{{ $episode->id }}">
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
                                        <img id="episode_modal-img" src="https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp">
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


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.series-based-network-video').forEach(function(elem) {
    // Initialize Flickity for each carousel
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

    flkty.reloadCells();

    // Attach event listeners for items in the section
    elem.querySelectorAll('.item').forEach(function(item) {
        item.addEventListener('click', function() {
            var sectionIndex = this.getAttribute('data-section-index');
            var index = this.getAttribute('data-index');

            // Remove 'current' class from all items and add to the clicked one
            elem.querySelectorAll('.item').forEach(function(item) {
                item.classList.remove('current');
            });
            this.classList.add('current');

            // Hide all captions, thumbnails, and sliders in the section
            document.querySelectorAll(`#videoInfo-${sectionIndex} .caption`).forEach(caption => caption.style.display = 'none');
            document.querySelectorAll(`#videoInfo-${sectionIndex} .thumbnail`).forEach(thumbnail => thumbnail.style.display = 'none');
            document.querySelectorAll(`#videoInfo-${sectionIndex} .network-based-depends-slider`).forEach(slider => slider.style.display = 'none');

            // Show the selected slider and initialize it with Flickity
            var selectedSlider = document.querySelector(`#videoInfo-${sectionIndex} .network-based-depends-slider[data-index="${index}"]`);
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(function() {
                    new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: true,
                        pageDots: false,
                        draggable: true,
                        freeScroll: true,
                        imagesLoaded: true,
                        lazyLoad: true,
                    });
                },0);
            }

            // Show the caption and thumbnail for the selected item
            var selectedCaption = document.querySelector(`#videoInfo-${sectionIndex} .caption[data-index="${index}"]`);
            var selectedThumbnail = document.querySelector(`#videoInfo-${sectionIndex} .thumbnail[data-index="${index}"]`);
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
                $('.depend-episode-modal-demd').show();
            }

            // Ensure the video info section is visible
            document.getElementById(`videoInfo-${sectionIndex}`).style.display = 'flex';
        });
    });
});

// Close dropdown functionality
document.querySelectorAll('.drp-close').forEach(function(closeButton) {
    closeButton.addEventListener('click', function() {
        var dropdown = this.closest('.series-based-network-dropdown');
        dropdown.style.display = 'none';
    });
});
});

</script>

<script>
    $(document).on('click', '#top-slider-img', function () {
        const seriesId = $(this).data('series-id');
        const sectionKey = $(this).data('section-index');

        const isLoaded = $('#series_player_img-' + seriesId + '-' + sectionKey).data('loaded');
        
        if (isLoaded) {
            // console.log('Images already loaded, skipping AJAX call.');
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
                // console.log('series img: ' + response.series_image);
                // console.log('episode images: ', response.episode_images);
                // console.log('series id: ' + seriesId);
                // console.log('sectionKey id: ' + sectionKey);

                let maxHeight = 0;
                const heightdiv = '.height-' + seriesId + '-' + sectionKey + ' .flickity-viewport' ;
                const heightauto = '.height-' + seriesId + '-' + sectionKey + ' .depends-row' ;

                $('#series_player_img-' + seriesId + '-' + sectionKey).attr('src', response.series_image);
                $('#series_player_img-' + seriesId + '-' + sectionKey).data('loaded', true);
               
                response.episode_images.forEach((image, index) => {
                    const imgId = '#episode_player_img-' + seriesId + '-' + sectionKey + '-' + index;
                    $(imgId).attr('src', image);
                    // console.log("img height: " + image.height);
                    const img = new Image();
                    img.src = image;

                    img.onload = function() {
                        const imgHeight = $(imgId).height();
                        // console.log("img height: " + imgHeight);

                        if (imgHeight > maxHeight) {
                            maxHeight = imgHeight;
                        }
                        
                        // console.log("Current max height: " + maxHeight);
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


<script>
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
</style>

