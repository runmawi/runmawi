@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a
                                href="{{ $order_settings_list[14]->url ? URL::to($order_settings_list[14]->url) : null }} ">{{ optional($order_settings_list[14])->header_name }}</a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[14]->url ? URL::to($order_settings_list[14]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>
                    </div>


                    <div class="tvthrillers-contens">
                        <ul id="trending-slider-nav" class="cpp-portal-nav list-inline p-0 mar-left row align-items-center">
                                @foreach ($data as $CPP_details)
                                    <li class="slick-slide">
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                @if ( compress_responsive_image_enable() == 1)
                                                    <img class="img-fluid position-relative" alt="{{ $CPP_details->title }}" src="{{ $CPP_details->image ?  URL::to('public/uploads/images/'.$CPP_details->image) : default_vertical_image_url() }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$CPP_details->responsive_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$CPP_details->responsive_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$CPP_details->responsive_image.' 420w') }}" >
                                                @else
                                                    <img src="{{ $CPP_details->picture ? URL::to('public/uploads/moderator_albums/'.$CPP_details->picture ) : default_vertical_image_url() }}" class="img-fluid" alt="content">
                                                @endif 
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider cpp-portal" class="list-inline p-0 m-0 align-items-center cpp-portal">
                                @foreach ($data as $CPP_details)
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ ucwords(optional($CPP_details)->username)  }}</h2>

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('contentpartner/' . $CPP_details->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                @if ( compress_responsive_image_enable() == 1)
                                                                    <img  alt="latest_series" src="{{$CPP_details->player_image ?  URL::to('public/uploads/images/'.$CPP_details->player_image) : default_horizontal_image_url() }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$CPP_details->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$CPP_details->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$CPP_details->responsive_player_image.' 420w') }}" >
                                                                @else
                                                                    <img  src="{{ $CPP_details->picture ? URL::to('public/uploads/moderator_albums/'.$CPP_details->picture ) : default_vertical_image_url() }}" alt="cpp">
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
        $('.cpp-portal').hide();
    });

    $(document).ready(function() {

        $('.cpp-portal').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.cpp-portal-nav',
        });

        $('.cpp-portal-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.cpp-portal',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
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

        $('.cpp-portal-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.cpp-portal').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.cpp-portal').hide();
        });
    });
</script>