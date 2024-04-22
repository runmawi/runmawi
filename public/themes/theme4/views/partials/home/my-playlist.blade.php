@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a
                                href="{{ $order_settings_list[26]->url ? URL::to($order_settings_list[26]->url) : null }} ">{{ optional($order_settings_list[26])->header_name }}</a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[26]->url ? URL::to($order_settings_list[26]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                            <ul id="trending-slider-nav" class="my-playlist-nav list-inline p-0 mar-left row align-items-center">
                                @foreach ($data as $My_Playlist)
                                    <li class="slick-slide">
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                @if ( compress_responsive_image_enable() == 1)
                                                    <img class="img-fluid position-relative" alt="{{ $My_Playlist->title }}" src="{{ $My_Playlist->image ?  URL::to('public/uploads/images/'.$My_Playlist->image) : default_vertical_image_url() }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$My_Playlist->responsive_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$My_Playlist->responsive_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$My_Playlist->responsive_image.' 420w') }}" >
                                                @else
                                                    <img src="{{ $My_Playlist->image != null ? URL::to('public/uploads/images/'. $My_Playlist->image ) : default_vertical_image_url() }}" class="img-fluid" alt="Videos">
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider my-playlist" class="list-inline p-0 m-0 align-items-center my-playlist">
                                @foreach ($data as $My_Playlist)
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ strlen($My_Playlist->title) > 17 ? substr($My_Playlist->title, 0, 18) . '...' : $My_Playlist->title }}</h2>

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('playlist/' . $My_Playlist->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit My PlayList </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                @if ( compress_responsive_image_enable() == 1)
                                                                    <img  alt="latest_series" src="{{$My_Playlist->player_image ?  URL::to('public/uploads/images/'.$My_Playlist->player_image) : default_horizontal_image_url() }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$My_Playlist->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$My_Playlist->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$My_Playlist->responsive_player_image.' 420w') }}" >
                                                                @else
                                                                    <img  src="{{ $My_Playlist->image != null ? URL::to('public/uploads/images/'. $My_Playlist->image ) : default_vertical_image_url() }}" alt="Videos">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>




                       
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif



<script>
    
    $( window ).on("load", function() {
        $('.my-playlist').hide();
    });

    $(document).ready(function() {

        $('.my-playlist').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.my-playlist-nav',
        });

        $('.my-playlist-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 4,
            asNavFor: '.my-playlist',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.my-playlist-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.my-playlist').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.my-playlist').hide();
        });
    });
</script>