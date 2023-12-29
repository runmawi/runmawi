
@php

$check_Kidmode = 0;
    
$data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image',
                                'player_image','expiry_date')

                        ->where('active',1)->where('status', 1)->where('draft',1)->where('featured',1);

                        if( Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                            $data = $data->whereNotIn('videos.id',Block_videos());
                        }

                        if (videos_expiry_date_status() == 1 ) {
                            $data = $data->where('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                        }
                        
                        if ($check_Kidmode == 1) {
                            $data = $data->whereBetween('videos.age_restrict', [0, 12]);
                        }

$data = $data->latest()->limit(30)->get();
                                                                    
@endphp


@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[0]->url) : null }} ">{{ optional($order_settings_list[0])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[0]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="featured-videos-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $featured_videos)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $featured_videos->image ?  URL::to('public/uploads/images/'.$featured_videos->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        
                                            @if (videos_expiry_date_status() == 1 && optional($featured_videos)->expiry_date)
                                                <p style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit;">{{ 'Leaving Soon' }}</p>
                                            @endif

                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider featured-videos-slider" class="list-inline p-0 m-0 align-items-center featured-videos-slider">
                            @foreach ($data as $key => $featured_videos )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">

                                                            <h2 class="caption-h2">{{ optional($featured_videos)->title }}</h2>
                                                                
                                                            @if (videos_expiry_date_status() == 1 && optional($featured_videos)->expiry_date)
                                                                <ul class="vod-info">
                                                                    <li>{{ "Expiry In ". Carbon\Carbon::parse($featured_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                                                </ul>
                                                            @endif

                                                            @if (optional($featured_videos)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($featured_videos)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('category/videos/'.$featured_videos->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Trending-videoloop-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : default_horizontal_image_url() }}" alt="">
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

        @foreach ($data as $key => $featured_videos )
            <div class="modal fade info_model" id="{{ "Home-Trending-videoloop-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : default_horizontal_image_url() }}" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($featured_videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($featured_videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($featured_videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$featured_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
        $('.featured-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.featured-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.featured-videos-slider-nav',
        });

        $('.featured-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.featured-videos-slider',
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

        $('.featured-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.featured-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.featured-videos-slider').hide();
        });
    });
</script>