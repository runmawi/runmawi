@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ optional($order_settings_list[13])->header_name }}</a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                            <ul id="trending-slider-nav" class="content-portal-nav list-inline p-0 mar-left row align-items-center">
                                @foreach ($data as $channel)
                                    <li class="slick-slide">
                                        <a href="javascript:;">
                                            <div class="movie-slick position-relative">
                                                @if ( $multiple_compress_image == 1)
                                                    <img class="img-fluid position-relative" alt="{{ $channel->title }}" src="{{ $channel->image ?  URL::to('public/uploads/images/'.$channel->image) : $default_vertical_image_url }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$channel->responsive_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$channel->responsive_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$channel->responsive_image.' 420w') }}" >
                                                @else
                                                    <img src="{{ $channel->channel_image ? $channel->channel_image : $default_vertical_image_url }}" class="img-fluid w-100" alt="channel">
                                                @endif
                                                <img src="{{ $channel->channel_image ? $channel->channel_image : $default_vertical_image_url }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider content-portal" class="list-inline p-0 m-0 align-items-center content-portal theme4-slider" style="display:none;">
                                @foreach ($data as $channel)
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show h-100">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ ucwords(optional($channel)->channel_name) }}</h2>

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('channel/' . $channel->channel_slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                @if ( $multiple_compress_image == 1)
                                                                    <img  alt="latest_series" src="{{$channel->player_image ?  URL::to('public/uploads/images/'.$channel->player_image) : $default_horizontal_image_url }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$channel->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$channel->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$channel->responsive_player_image.' 420w') }}" >
                                                                @else
                                                                    <img  src="{{ $channel->channel_image ? $channel->channel_image : $default_vertical_image_url }}" alt="channel">
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
        $('.content-portal').hide();
    });

    $(document).ready(function() {

        $('.content-portal').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.content-portal-nav',
        });

        $('.content-portal-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 6,
            asNavFor: '.content-portal',
            dots: false,
            arrows: true,
            prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
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

        $('.content-portal-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.content-portal').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.content-portal').hide();
        });
    });
</script>