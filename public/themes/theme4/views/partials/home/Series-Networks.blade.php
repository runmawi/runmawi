@php
    $data = App\SeriesNetwork::where('in_home',1)->orderBy('order')->limit(15)->get()->map(function ($item) use ($default_vertical_image_url , $default_horizontal_image_url,$BaseURL) {
                $item['image_url'] = $item->image != null ? $BaseURL.('/seriesNetwork/'.$item->image ) : $default_vertical_image_url ;
                $item['banner_image_url'] = $item->banner_image != null ?  $BaseURL.('/seriesNetwork/'.$item->banner_image ) : $default_horizontal_image_url;

                $Series = App\Series::select(
                                'id', 'title', 'slug', 'access', 'active', 'ppv_status', 'featured', 'duration', 'image',
                                'embed_code', 'mp4_url', 'webm_url', 'ogg_url', 'url', 'tv_image', 'player_image',
                                'details', 'description', 'network_id'
                            )
                            ->where('active', 1)
                            ->where('network_id', 'LIKE', '%"'.$item->id.'"%')
                            ->latest();

                            $series = $Series->take(15)->get()->map(function ($seriesItem) use ($default_vertical_image_url, $default_horizontal_image_url,$BaseURL) {
                                $seriesItem['image_url'] = $seriesItem->image != null ? $BaseURL.('/images/' . $seriesItem->image) : $default_vertical_image_url;
                                $seriesItem['Player_image_url'] = $seriesItem->player_image != null ? $BaseURL.('/images/' . $seriesItem->player_image) : $default_horizontal_image_url;
                                $seriesItem['TV_image_url'] = $seriesItem->tv_image != null ? $BaseURL.('/images/' . $seriesItem->tv_image) : @$default_horizontal_image_url;

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
                <div class="col-sm-12">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ optional($order_settings_list[30])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list series-network-video flickity-slider">
                                @foreach ($data as $key => $series_networks)
                                    <div id="network-slider-img" class="item" data-index="{{ $key }}" data-network-id="{{ $series_networks->id }}">
                                        <div>
                                            <img data-flickity-lazyload="{{ $series_networks->image_url }}" class="flickity-lazyloaded" alt="{{ ($series_networks)->name }}" >
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
                                            <img id="network-bg-img-{{ $series_networks->id }}" class="flickity-lazyloaded" alt="{{ $series_networks->name }}" >
                                        </div>

                                        <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list height-'. $series_networks->id}}" data-index="{{ $key }}" >
                                            @foreach ($series_networks->series as $series_key  => $series_details )
                                                <div class="depends-row">
                                                    <div class="depend-items">
                                                    <a href="{{ route('network.play_series',$series_details->slug) }}">
                                                        <div class=" position-relative">
                                                            <img id="series_player_img-{{ $series_networks->id }}-{{ $series_key }}" class="flickity-lazyloaded drop-slider-img" alt="{{ $series_details->title }}" width="300" height="200">

                                                            <div class="controls">
                                                                <a href="{{ route('network.play_series', $series_details->slug) }}">
                                                                        <i class="playBTN fas fa-play"></i>
                                                                </a>
                                                                <button id="data-modal-network-series" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-SeriesNetwork-series-Modal" data-series-id="{{ $series_details->id }}">
                                                                    <i class="fas fa-info-circle"></i><span>More info</span></button>

                                                                
                                                                <p class="trending-dec">
                                                                    {{-- <span class="season_episode_numbers">{{ $series_details->season_count . " Seasons " . $series_details->episode_count . ' Episodes' }}</span><br> --}}
                                                                    {{ optional($series_details)->title }}
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

                <div class="modal fade info_model" id="Home-SeriesNetwork-series-Modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img id="series_modal-img" src="https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp" width="460" height="259">
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

    </section>
@endif


<script>

    var elem = document.querySelector('.series-network-video');
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


<script>
    $(document).on('click', '#network-slider-img', function () {
        const networkId = $(this).data('network-id');

        $.ajax({
            url: '{{ route("getnetworkSeriesImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                network_id: networkId
            },
            success: function (response) {
                let maxHeight = 0;
                const heightdiv = '.height-' + networkId + ' .flickity-viewport' ;
                const heightauto = '.height-' + networkId + ' .depends-row' ;

                console.log('heightdiv: ' + heightdiv);
                

                $('#network-bg-img-' + networkId).attr('src', response.network_image);
               
                response.series_images.forEach((image, index) => {
                    const imgId = '#series_player_img-' + networkId + '-' + index;
                    $(imgId).attr('src', image);
                    console.log("imgId : " + imgId);
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
    $(document).on('click', '#data-modal-network-series', function() {
        const SeriesId = $(this).data('series-id');
        // console.log("modal opened.");
        $.ajax({
            url: '{{ route("getSeriesNetworkModalImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                Series_id : SeriesId
            },
            success: function (response) {
                // console.log("image: " + response.image);
                // console.log("title: " + response.title);
                // console.log("description: " + response.description);
                // const slug = 'live/' + response.slug;
                console.log("slug: " + response.slug);
                $('#series_modal-img').attr('src', response.image);
                $('#series_modal-img').attr('alt', response.title);
                $('.modal-title').text(response.title);
                $('.modal-desc').text(response.description);
                $('.btn.btn-hover').attr('href', response.slug);
                

            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });

        $('.btn-close-white').on('click', function () {
            $('#series_modal-img').attr('src', 'https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp');
            $('.modal-title').text('');
            $('.modal-desc').text('');
            $('.btn.btn-hover').attr('href', '');
        });


    });
</script>


<style>

.network-depends-slider .flickity-viewport{height: 100px;}
.drop-slider-img{opacity: 0 !important;}
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
    .controls {
    position: absolute;
    padding: 4px;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 3;
    opacity: 0;
    transition: all .15s ease;
    display: flex;
}

.playBTN {
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    border: none;
    background-color: rgba(51, 51, 51, 0.4);
    transition: background-color .15s ease;
    cursor: pointer;
    outline: none;
    padding: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 50px;
    height: 50px;
    transform: translate(-50%, -50%);
}

.playBTN i {
    position: relative;
    left: 2px;
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