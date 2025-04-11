@php
    $check_Kidmode = 0 ;

    $data =  App\Artist::limit(15)->get()->map(function($item) use($check_Kidmode,$videos_expiry_date_status,$getfeching){

        // Videos 

        // $Videoartist = App\Videoartist::where('artist_id',$item->id)->groupBy('video_id')->pluck('video_id'); 

        // $item['artist_depends_videos'] = App\Video::select('id','title','description','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','player_image')

        //                                     ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$Videoartist);

        //                                     if( $getfeching !=null && $getfeching->geofencing == 'ON')
        //                                     {
        //                                         $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNotIn('videos.id',Block_videos());
        //                                     }
                                            
        //                                     if ($check_Kidmode == 1) {
        //                                         $item['artist_depends_videos']->whereBetween('videos.age_restrict', [0, 12]);
        //                                     }

        //                                     if ($videos_expiry_date_status == 1 ) {
        //                                         $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        //                                     }

        // $item['artist_depends_videos'] = $item['artist_depends_videos']->latest()->limit(15)->get()->map(function ($item) {
        //                                 $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
        //                                 $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
        //                                 $item['source']           = 'series';
        //                                 return $item;
        //                             });

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
        
        // $Audioartist = App\Audioartist::where('artist_id',$item->id)->groupBy('audio_id')->pluck('audio_id'); 

        // $item['artist_depends_audios'] = App\Audio::select('id','title','slug','year','rating','access','ppv_price','duration','rating','image',
        //                                 'featured','player_image','details','description')

        //                 ->where('active',1)->where('status', 1)->where('draft',1)->WhereIn('id',$Audioartist);

        //         if( $getfeching !=null && $getfeching->geofencing == 'ON')
        //         {
        //             $item['artist_depends_audios'] = $item['artist_depends_audios']->whereNotIn('id',Block_audios());
        //         }

        //     $item['artist_depends_audios'] = $item['artist_depends_audios']->limit(15)->latest()->get()->map(function ($item) {
        //                     $item['image_url'] = $item->image != null ? URL::to('/public/uploads/audios/'.$item->image) : $default_vertical_image_url ;
        //                     $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/audios/'.$item->player_image) : $default_horizontal_image_url ; 
        //                     return $item;
        //                 });

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
                        <h4 class="main-title"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list artist-video">
                                @foreach ($data as $key => $artist_details)
                                    <div id="artist-slider-img" class="item" data-index="{{ $key }}" data-artist-id="{{ $artist_details->id }}">
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
                                                {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-continue-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img id="artist-bg-img-{{ $artist_details->id }}" class="flickity-lazyloaded" alt="{{ $artist_details->artist_name }}">
                                    </div>

                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list height-'. $artist_details->id}}" data-index="{{ $key }}" >
                                        @foreach  ($artist_details->artist_depends_series as $series_key => $artist_series_content )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                        <div class=" position-relative">
                                                            <img id="series_player_img-{{ $artist_details->id }}-{{ $series_key }}" class="flickity-lazyloaded drop-slider-img" alt="{{ $artist_series_content->title }}">                                                                                
                                                            <div class="controls">
                                                                
                                                                <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>
                                                                <button id="data-modal-artist-series" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-SeriesArtist-series-Modal" data-series-id="{{ $artist_series_content->id }}">
                                                                    <i class="fas fa-info-circle"></i><span>More info</span>
                                                                </button>

                                                               
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

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

      

        {{-- series modal --}}
                <div class="modal fade info_model" id="Home-SeriesArtist-series-Modal" tabindex="-1" aria-hidden="true">
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


<script>
    $(document).on('click', '#artist-slider-img', function () {
        const artistId = $(this).data('artist-id');

        $.ajax({
            url: '{{ route("getartistSeriesImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                artist_id: artistId
            },
            success: function (response) {
                let maxHeight = 0;
                const heightdiv = '.height-' + artistId + ' .flickity-viewport' ;
                const heightauto = '.height-' + artistId + ' .depends-row' ;

                console.log('heightdiv: ' + heightdiv);
                

                $('#artist-bg-img-' + artistId).attr('src', response.artist_image);
               
                response.series_images.forEach((image, index) => {
                    const imgId = '#series_player_img-' + artistId + '-' + index;
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
    $(document).on('click', '#data-modal-artist-series', function() {
        const SeriesId = $(this).data('series-id');
        // console.log("modal opened.");
        $.ajax({
            url: '{{ route("getSeriesArtistModalImg") }}',
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