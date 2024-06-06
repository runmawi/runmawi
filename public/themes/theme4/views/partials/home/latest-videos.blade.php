
@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[1])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ "view all" }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-video">
                                @foreach ($data as $key => $latest_video)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ($multiple_compress_image == 1)
                                                <img class="img-fluid position-relative" alt="{{ $latest_video->title }}" src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_image.' 420w') }}"  width="300" height="200">
                                            @else
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series"  width="300" height="200">
                                            @endif

                                            @if ($videos_expiry_date_status == 1 && optional($latest_video)->expiry_date)
                                                <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                            @endif 
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $latest_video )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($latest_video)->title }}</h2>

                                        @if ($videos_expiry_date_status == 1 && optional($latest_video)->expiry_date)
                                            <ul class="vod-info">
                                                <li>{{ "Expiry In ". Carbon\Carbon::parse($latest_video->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                            </ul>
                                        @endif

                                        @if (optional($latest_video)->description)
                                            <div class="trending-dec">{!! html_entity_decode( optional($latest_video)->description) !!}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-latest-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        <!-- <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider theme4-slider" style="display:none;">
                            @foreach ($data as $key => $latest_video )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show h-100">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <div class="caption pl-4">

                                                        <h2 class="caption-h2">{{ optional($latest_video)->title }}</h2>

                                                        @if ($videos_expiry_date_status == 1 && optional($latest_video)->expiry_date)
                                                            <ul class="vod-info">
                                                                <li>{{ "Expiry In ". Carbon\Carbon::parse($latest_video->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                                            </ul>
                                                        @endif

                                                        @if (optional($latest_video)->description)
                                                            <div class="trending-dec">{!! html_entity_decode( optional($latest_video)->description) !!}</div>
                                                        @endif

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-latest-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <div class="dropdown_thumbnail">
                                                            @if ( $multiple_compress_image == 1)
                                                                <img  alt="latest_series" src="{{$latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : $default_horizontal_image_url }}"
                                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_player_image.' 860w') }},
                                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_player_image.' 640w') }},
                                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_player_image.' 420w') }}" >
                                                            @else
                                                                <img  src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : $default_horizontal_image_url }}" alt="latest_series">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>   
                            @endforeach
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $latest_video )
            <div class="modal fade info_model" id="{{ "Home-latest-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if ( $multiple_compress_image == 1)
                                                <img  alt="latest_series" src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : $default_horizontal_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_player_image.' 420w') }}" alt="latest_series">

                                            @else
                                                <img  src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : $default_horizontal_image_url }}" alt="latest_series">
                                            @endif 
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($latest_video)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($latest_video)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($latest_video)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
    
    var elem = document.querySelector('.latest-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        adaptiveHeight: true,
        pageDots: false
    });

    document.querySelectorAll('#videoInfo .caption').forEach(function(caption) {
        caption.style.display = 'none';
    });
    document.querySelectorAll('#videoInfo .thumbnail').forEach(function(thumbnail) {
        thumbnail.style.display = 'none';
    });

    document.querySelectorAll('.latest-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.latest-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('#videoInfo .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('#videoInfo .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('#videoInfo .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('#videoInfo .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementById('videoInfo').style.display = 'flex';
        });
    });

    document.querySelector('.drp-close').addEventListener('click', function() {
        document.getElementById('videoInfo').style.display = 'none';
        document.querySelectorAll('.latest-video .item').forEach(function(item) {
            item.classList.remove('current');
        });
    });




    // $( window ).on("load", function() {
    //     $('#videoInfo').hide();

    //     $('.latest-videos-slider-nav').slick({
    //             slidesToShow: 6,
    //             slidesToScroll: 6,
    //             asNavFor: '.latest-videos-slider',
    //             dots: false,
    //             arrows: true,
    //             prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
    //             nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
    //             infinite: true,
    //             focusOnSelect: true,
    //             responsive: [
    //                 {
    //                     breakpoint: 1200,
    //                     settings: {
    //                         slidesToShow: 6,
    //                         slidesToScroll: 1,
    //                     },
    //                 },
    //                 {
    //                     breakpoint: 1024,
    //                     settings: {
    //                         slidesToShow: 5,
    //                         slidesToScroll: 1,
    //                     },
    //                 },
    //                 {
    //                     breakpoint: 600,
    //                     settings: {
    //                         slidesToShow: 2,
    //                         slidesToScroll: 1,
    //                     },
    //                 },
    //             ],
    //         });
    // });


    // $(document).ready(function() {

    //     $('.latest-videos-slider').slick({
    //         slidesToShow: 1,
    //         slidesToScroll: 1,
    //         arrows: false,
    //         fade: true,
    //         draggable: false,
    //         asNavFor: '.latest-videos-slider-nav',
    //     });


    //     $('.latest-videos-slider-nav').on('click', function() {
    //         $( ".drp-close" ).trigger( "click" );
    //         $('.latest-videos-slider').show();
    //     });

    //     $('body').on('click', '.slick-arrow', function() {
    //         $('.latest-videos-slider').hide();
    //     });

    //     $('body').on('click', '.drp-close', function() {
    //         $('.latest-videos-slider').hide();
    //     });
    // });
</script>

<style>
    @media screen and (min-width: 601px) {
    #videoInfo .vib .thumbnail {
        width: 74%;
        mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        mask-image: linear-gradient(to right, transparent 0%, black 50%);
        -webkit-mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 50%);
    }
}

@media screen and (min-width: 1400px) {
    #videoInfo {
        max-height: 500px;
        height: 32vw;
    }
}

@media screen and (max-width: 4440px) {
    .channels-list .channel-row .video-list .item {
        width: 14.3%;
    }
}

@media screen and (min-width: 801px) {
    #videoInfo .vib .caption {
        padding-right: 30px;
        max-width: 630px;
    }
}

@media screen and (max-width: 799px) {
    .channels-list .channel-row .flickity-viewport {
        min-height: calc(100vw / 5.8);
    }
    .channels-list .channel-row .video-list .item {
        width: 33.33333%;
    }
    #videoInfo {
        max-height: 500px;
        height: 32vw;
    }
}

@media screen and (max-width: 512px) {
    .channels-list .channel-row .video-list .item {
        width: 50%;
    }
}

@media screen and (max-width: 1399px) and (min-width: 1100px) {
    .channels-list .channel-row .flickity-viewport {
        min-height: calc(100vw / 9.5);
    }
    .channels-list .channel-row .video-list .item {
        width: 16.666%;
    }
}

    .channels-list .channel-row .video-list {
        padding: 10px 0 0 1%;
        list-style: none;
        margin: 0;
        position: relative;
        z-index: 12;
    }
.channels-list .channel-row .video-list .item {
    padding: 2px;
    position: relative;
}
.channels-list .channel-row .video-list .item:before {
    content: '';
    display: block;
    position: absolute;
    background-color: #555;
    background-image: url(https://watch.e360tv.com/img/placeholder.jpg);
    background-size: cover;
    background-position: center;
    top: 2px;
    bottom: 2px;
    left: 2px;
    right: 2px;
    z-index: 0;
}
.channels-list .channel-row .video-list .item > div {
    display: block;
    position: relative;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
    opacity: 0.8;
    cursor: pointer;
}
.channels-list .channel-row .video-list .item > div:before {
    content: '';
    display: block;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
.channels-list .channel-row .video-list .item img {
    width: 100%;
    height: auto;
    position: absolute;
    top: 0;
    left: 0;
    -o-object-fit: cover;
    object-fit: cover;
    z-index: 0;
    opacity: 0;
    -webkit-transition: opacity 0.4s;
    transition: opacity 0.4s;
}
.flickity-lazyloaded, .flickity-lazyerror {
    opacity: 1 !important;
}
.channels-list .channel-row .video-list .item.current img{border:2px solid var(--iq-primary)}
.channels-list .channel-row .video-list .item.current img:after {
    content: '';
    position: absolute;
    z-index: 2;
    left: 50%;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
    width: 0;
    height: 0;
    bottom: calc(-1px - 1vw);
    border-style: solid;
    border-width: calc(7px + 1vw) calc(13px + 1vw) 0 calc(13px + 1vw);
    border-color: var(--iq-primary) transparent transparent transparent;
}
/* dropdown */

#videoInfo .vib {
    padding: 18px 4% 12px;
    width: 100%;
    position: relative;
    display: none;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
}
#videoInfo .vib .caption {
    position: relative;
    z-index: 2;
    color: var(--text-color);
    width: 100%;
}
#videoInfo .vib .thumbnail {
    position: absolute;
    pointer-events: none;
    z-index: 0;
    height: 100%;
    top: 0;
    right: 0;
}
#videoInfo .vib .thumbnail img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}
#videoInfo {
    display: none;
    background-color: rgba(0, 0, 0, 0.15);
    z-index: 1;
    position: relative;
    top: -29px;
}

/* arrow */
.flickity-button{background:transparent;color:#fff;}
.flickity-button:hover{background:transparent;}
</style>