@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-4"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ optional($order_settings_list[3])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="livestream-videos-slider-nav list-inline p-0 ml-4 row align-items-center">
                            @foreach ($data as $livestream_videos)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                    @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                        <div ><img class="blob" src="public\themes\theme4\views\img\Live-Icon.png" alt="" width="100%"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider" class="list-inline p-0 m-0  align-items-center livestream-videos-slider">
                            @foreach ($data as $key => $livestream_videos )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image"                                        >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                <ul class="vod-info">
                                                                    <li><span></span> LIVE NOW</li>
                                                                </ul>
                                                            @elseif ($livestream_videos->publish_type == "publish_later")
                                                                <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($livestream_videos->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }} </span>
                                                            @endif

                                                            <div class="trending-dec">{!! html_entity_decode( $livestream_videos->description ) ?  $livestream_videos->description : " No description Available" !!}</div>
                                                        
                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : default_horizontal_image_url() }}" alt="">
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
        $('.livestream-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.livestream-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.livestream-videos-slider-nav',
        });

        $('.livestream-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.livestream-videos-slider',
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

        $('.livestream-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.livestream-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.livestream-videos-slider').hide();
        });
    });
</script>


<!-- /* pulsing animation */ -->
<style>

.blob {
	margin: 10px;
	height: 22px;
	width: 59px;
    border-radius:25px;
	box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
	transform: scale(1);
	animation: pulse 2s infinite;
    position:absolute;
    top:0;
}

@keyframes pulse {
	0% {
		transform: scale(0.95);
		box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
	}

	70% {
		transform: scale(1);
		box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
	}

	100% {
		transform: scale(0.95);
		box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
	}
}
</style>