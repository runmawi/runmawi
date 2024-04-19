@php

$check_Kidmode = 0;
    
$data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image')

                        ->where('active',1)->where('status', 1)->where('draft',1);

                        if( Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                            $data = $data->whereNotIn('videos.id',Block_videos());
                        }

                        if (videos_expiry_date_status() == 1 ) {
                            $data = $data->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                        }
                        
                        if ($check_Kidmode == 1) {
                            $data = $data->whereBetween('videos.age_restrict', [0, 12]);
                        }

$data = $data->latest()->limit(15)->get();
                                                                    
@endphp
                                                                    

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

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $latest_video)
                                <li class="slick-slide">
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            @if ( compress_responsive_image_enable() == 1)
                                                <img class="img-fluid position-relative" alt="{{ $latest_video->title }}" src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid position-relative" alt="latest_series">
                                            @endif 

                                            @if (videos_expiry_date_status() == 1 && optional($latest_video)->expiry_date)
                                                <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                            @endif 
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider">
                            @foreach ($data as $key => $latest_video )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <div class="caption pl-4">

                                                        <h2 class="caption-h2">{{ optional($latest_video)->title }}</h2>

                                                        @if (videos_expiry_date_status() == 1 && optional($latest_video)->expiry_date)
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
                                                                <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-latest-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            @if ( compress_responsive_image_enable() == 1)
                                                                <img  alt="latest_series" src="{{$latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}"
                                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_player_image.' 860w') }},
                                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_player_image.' 640w') }},
                                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_player_image.' 420w') }}" >
                                                            @else
                                                                <img  src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}" alt="latest_series">
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

        @foreach ($data as $key => $latest_video )
            <div class="modal fade info_model" id="{{ "Home-latest-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if ( compress_responsive_image_enable() == 1)
                                                <img  alt="" width="100%" src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_video->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_video->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_video->responsive_player_image.' 420w') }}" >

                                            @else
                                                <img  src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}" alt="latest_series">
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
    
    $( window ).on("load", function() {
        $('.latest-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.latest-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.latest-videos-slider-nav',
        });

        $('.latest-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 4,
            asNavFor: '.latest-videos-slider',
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

        $('.latest-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.latest-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.latest-videos-slider').hide();
        });
    });
</script>