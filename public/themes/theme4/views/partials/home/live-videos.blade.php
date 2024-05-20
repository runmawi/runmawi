@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0" id="home-live-videos-container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ optional($order_settings_list[3])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <div id="trending-slider-nav" class="livestream-videos-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $livestream_videos)
                                <div class="slick-slide">
                                    <a href="javascript:;">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid lazy w-100" alt="livestream_videos" width="300" height="200">
                                        </div>
                                    </a>
                                    @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                        <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <ul id="trending-slider" class="list-inline p-0 m-0  align-items-center livestream-videos-slider theme4-slider" style="display:none;">
                            @foreach ($data as $key => $livestream_videos )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image">
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show h-100">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">

                                                            <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                
                                                                <ul class="vod-info">
                                                                    <li><span></span> LIVE NOW</li>
                                                                </ul>

                                                            @elseif ($livestream_videos->publish_type == "publish_later")
                                                                <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::createFromFormat('Y-m-d\TH:i',$livestream_videos->publish_time)->format('j F Y g:ia') }} </span>
                                                            
                                                            @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program != "custom" )
                                                                        
                                                                @php
                                                                    switch ($livestream_videos->recurring_program_week_day) {

                                                                        case 0:
                                                                            $recurring_program_week_day = 'Sunday' ;
                                                                        break;

                                                                        case 1 :
                                                                            $recurring_program_week_day =  'Monday' ;
                                                                        break;

                                                                        case 2:
                                                                            $recurring_program_week_day =  'Tuesday' ;
                                                                        break;

                                                                        case 3 :
                                                                            $recurring_program_week_day = 'Wednesday' ;
                                                                        break;

                                                                        case 4:
                                                                            $recurring_program_week_day =  'Thrusday' ;
                                                                        break;

                                                                        case 5:
                                                                            $recurring_program_week_day =  'Friday' ;
                                                                        break;

                                                                        case 6:
                                                                            $recurring_program_week_days =  'Saturday' ;
                                                                        break;

                                                                        default:
                                                                            $recurring_program_week_day =  null ;
                                                                        break;
                                                                    }
                                                                @endphp

                                                                @if ( $livestream_videos->recurring_program == "daily")

                                                                    <span class="trending"> {{ 'Live Streaming Starts daily from '. Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                                    
                                                                @elseif( $livestream_videos->recurring_program == "weekly" )
                                                                    
                                                                    <span class="trending"> {{ 'Live Streaming Starts On Every '. $livestream_videos->recurring_program . " " . $recurring_program_week_day . $livestream_videos->recurring_program_month_day ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                                                @elseif( $livestream_videos->recurring_program == "monthly" )
                                                                    
                                                                    <span class="trending"> {{ 'Live Streaming Starts On Every '. $livestream_videos->recurring_program . " " . $livestream_videos->recurring_program_month_day ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                                                @endif


                                                            @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program == "custom" )
                                                                <span class="trending"> {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_videos->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                            @endif

                                                            <div class="d-flex align-items-center p-0 mt-3">
                                                                <img  src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" alt="livestream_videos" alt="livestream_videos" style="height: 30%; width:30%"> 
                                                            </div>

                                                            <div class="trending-dec">{!! html_entity_decode( $livestream_videos->description ) ??  $livestream_videos->description  !!}</div>
                                                        
                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-LiveStream-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if ( $livestream_videos->publish_type == "recurring_program")
                                                            <div class="dropdown_thumbnail">
                                                                <img  src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" alt="livestream_videos">
                                                            </div>
                                                        @endif
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


        @foreach ($data as $key => $livestream_videos )
            <div class="modal fade info_model" id="{{ "Home-LiveStream-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_horizontal_image_url }}" alt="modal">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($livestream_videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($livestream_videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
    
    $( window ).on("load", function() {
        $('.livestream-videos-slider').hide();
    });

    function reloadLiveVideos() {
        
        const container = document.getElementById('home-live-videos-container');

        fetch('{{ route('home.livestream.section.autorefresh') }}')
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
                initializeSlickSlider();
            })
            .catch(error => console.error('Error fetching live videos:', error));
    }

    setInterval(reloadLiveVideos, 90000);

    reloadLiveVideos();

    function initializeSlickSlider() {

        $('.livestream-videos-slider').hide();

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
            slidesToScroll: 6,
            asNavFor: '.livestream-videos-slider',
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

        $('.livestream-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.livestream-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.livestream-videos-slider').hide();
        });
    }
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