<?php

   // latest viewed Livestream

   if(Auth::guest() != true ){

    $data =  App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id',Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->limit(15)
        ->get();
   }
   else
   {
        $data = array() ;
   }

?>

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-upcoming-movie">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[16]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[16])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[16]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ "View all" }}</a></h4>
                    </div>


                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="latest-view-livestream-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $key => $livestream_videos)
                                <li class="slick-slide">
                                    <a href="javascript:;">
                                        <div  class="movie-slick position-relative">
                                            <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="latest_view_live">
                                        </div>
                                    </a>
                                    @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                        <div ><img class="blob" src="public\themes\theme4\views\img\Live-Icon.png" alt="livestream_videos" width="100%"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>


                        <ul id="trending-slider latest-view-livestream-slider" class="list-inline p-0 m-0 align-items-center latest-view-livestream-slider theme4-slider" style="display:none;">
                            @foreach ($data as $key => $livestream_videos)
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
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
                                                                <span class="trending"> {{ 'Live Streaming '. $livestream_videos->recurring_program ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                                            @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program == "custom" )
                                                                <span class="trending"> {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_videos->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                            @endif

                                                            <div class="trending-dec">{!! html_entity_decode( $livestream_videos->description ) ?  $livestream_videos->description : " No description Available" !!}</div>
                                                            
                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-viewed_livestream-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_vertical_image_url }}" class="img-fluid" alt="latest_view_live">
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

        @foreach ($data as $key => $livestream_videos )
            <div class="modal fade info_model" id="{{ "Home-Latest-viewed_livestream-Modal-".$key }}" tabindex="-1" aria-hidden="true">
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

                                            <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
        $('.latest-view-livestream-slider').hide();
    });

    $(document).ready(function() {

        $('.latest-view-livestream-slider').slick({
            slidesToShow: 1,
            initialSlide:0,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.latest-view-livestream-slider-nav',
        });

        $('.latest-view-livestream-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 6,
            asNavFor: '.latest-view-livestream-slider',
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

        $('.latest-view-livestream-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.latest-view-livestream-slider').show();
            $('')
        });

        $('body').on('click', '.drp-close', function() {
            $('.latest-view-livestream-slider').hide();
        });
    });
</script>