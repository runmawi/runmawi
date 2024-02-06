@php
    
    $data =  App\AdminEPGChannel::where('status',1)->get()->map(function ($item) {
                    
                    $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/'.$item->image ) : default_vertical_image_url() ;
                    
                    $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EPG-Channel/'.$item->player_image ) : default_horizontal_image_url();
                    
                    $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EPG-Channel/'.$item->logo ) : default_vertical_image_url();
                    
                    $item['ChannelVideoScheduler']  =  App\ChannelVideoScheduler::where('channe_id',$item->id)->where('choosed_date', '>=' ,Carbon\Carbon::today()->format('n-d-Y'))->orderBy('start_time')->get()->map(function ($item) {
                                                            $item['ChannelVideoScheduler_Choosen_date'] = Carbon\Carbon::createFromFormat('n-d-Y', $item->choosed_date)->format('d-m-Y');
                                                            return $item;
                                                        });

                                                        
                    $item['ChannelVideoScheduler_top_date']  =  App\ChannelVideoScheduler::where('channe_id',$item->id)->where('choosed_date', '>=' ,Carbon\Carbon::today()->format('n-d-Y'))->orderBy('start_time')->groupBy('choosed_date')->get()->map(function ($item) {
                                                                    $item['ChannelVideoScheduler_Choosen_date'] = Carbon\Carbon::createFromFormat('n-d-Y', $item->choosed_date)->format('d-m-Y');
                                                                    return $item;
                                                                });
                    return $item;
                });

@endphp    
              
<style>
    .time{
        width: 28%;
        font-size: 18px;
        height: 100%;
        background-color: rgba(129, 128, 128, 0.1);

    }
    table.table tr{
        border-bottom: 1px solid rgba(255,255,255,0.5);
        border-left: 1px solid rgba(255,255,255,0.5);
        border-right: 1px solid rgba(255,255,255,0.5);

    }
    .table td, .table th{
        border-top:none;
    }
    .nav-tabs{
        border-right: 1px solid;
        border-top: 1px solid;
        border-left: 1px solid;
    }
    ul.nav.nav-tabs li{
        white-space: nowrap;
        background-color: rgba(0, 0, 0, 0.75);
        border: 1px solid rgba(255,255,255,0.5);
        padding: 8px 12px;
        color: #fff;
        outline: none;
        line-height: 1;
        font-weight: bold;
        font-size: calc(12px + 0.5vmin);
        cursor: pointer;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        height: 48px;
        display:flex;
        align-items:center;
    }
    .scroller {
        text-align:center;
        cursor:pointer;
        display:none;
        padding:7px;
        padding-top:11px;
        white-space:no-wrap;
        vertical-align:middle;
        background-color:#fff;
    }

    .scroller-right{
        float:right;
    }

    .scroller-left {
        float:left;
    }
    ul.nav.nav-tabs.m-0 li a{
        color: white;
    }
    .tabs__scroller {
        background: #0195e7;
        border: 0 none;
        color: #fff;
        font-size: 1em;
        padding: 0 0.75em;
        .fa {
            position: relative;
        }
        &--left .fa {
            left: -1px;
        }
        &--right .fa {
            right: -2px;
        }
        &[disabled] {
            opacity: 0.5;
        }
        &:focus {
            outline: none;
        }
    }
    button.tabs__scroller.tabs__scroller--right.js-action--scroll-right{
        position: absolute;
        right: 0;
        height: 100%;
    }
    .panel-heading.panel-heading-nav.d-flex {
        border: 1px solid;
    }
    .fade:not(.show){
        opacity:1;
    }
</style>

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ optional($order_settings_list[33])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ "view all" }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="epg-channel-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $epg_channel_data)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $epg_channel_data->image_url }}" class="img-fluid position-relative" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider epg-channel-slider" class="list-inline p-0 m-0 align-items-center epg-channel-slider">
                            @foreach ($data as $key => $epg_channel_data )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <div class="caption pl-4">

                                                        <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2>
                                                    {{-- 
                                                        @if ( Carbon\Carbon::now()->greaterThanOrEqualTo( $epg_channel_data->EPG->epg_start_date )) 
                                                            <ul class="vod-info">
                                                                <li><span></span> LIVE NOW</li>
                                                            </ul>
                                                        @else
                                                            <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($epg_channel_data->EPG->epg_start_date)->isoFormat('YYYY-MM-DD') }} </span>
                                                        @endif --}}

                                                        @if (optional($epg_channel_data)->description)
                                                            <div class="trending-dec">{!! html_entity_decode( optional($epg_channel_data)->description) !!}</div>
                                                        @endif

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-epg-events-Modal-'.$key }}"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i> Event </a>
                                                                <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-epg-channel-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $epg_channel_data->Player_image_url }}" alt="">
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

        {{-- More Info Modal --}}

        @foreach ($data as $key => $epg_channel_data )
            <div class="modal fade info_model" id="{{ "Home-epg-channel-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $epg_channel_data->Player_image_url }}" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">

                                                    <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2>

                                                    {{-- @if ( Carbon\Carbon::now()->greaterThanOrEqualTo( $epg_channel_data->EPG->epg_start_date )) 
                                                        <ul class="vod-info">
                                                            <li><span></span> LIVE NOW</li>
                                                        </ul>
                                                    @else
                                                        <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($epg_channel_data->EPG->epg_start_date)->isoFormat('YYYY-MM-DD') }} </span>
                                                    @endif --}}

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>

                                            @if (optional($epg_channel_data)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($epg_channel_data)->description) !!}</div>
                                            @endif

                                            <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Events Modal --}}

        @foreach ($data as $key => $epg_channel_data)
            <div class="modal fade info_model" id="{{ 'Home-epg-events-Modal-' . $key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none;">
                            <div class="modal-body" style="padding: 0 14rem;">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="container m-0">

                                            <div class="row" style="margin-bottom:4%;">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2"  style="display:flex;align-items:center;justify-content:end;">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading panel-heading-nav d-flex position-relative">
                                                    <button class="tabs__scroller tabs__scroller--left js-action--scroll-left"><i class="fa fa-chevron-left"></i></button>
                                                    
                                                    <ul class="nav nav-tabs m-0">
                                                        @foreach ( $epg_channel_data->ChannelVideoScheduler_top_date as $ChannelVideoScheduler_key => $item)
                                                            <li role="presentation" class="active" data-choosed-date={{ $item->choosed_date }} data-channel-id={{ $item->channe_id }}  onclick="EPG_date_filter(this)">
                                                                <a href="#" aria-controls="one" role="tab" data-toggle="tab">{{ $item->ChannelVideoScheduler_Choosen_date }}
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <button class="tabs__scroller tabs__scroller--right js-action--scroll-right "><i class="fa fa-chevron-right"></i></button>
                                                </div>

                                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/channel-epg-partial', ['order_settings_list' => $order_settings_list ,'epg_channel_data' => $epg_channel_data ])->content() !!}

                                            </div>
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
        $('.epg-channel-slider').hide();
    });

    $(document).ready(function() {

        $('.epg-channel-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.epg-channel-slider-nav',
        });

        $('.epg-channel-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.epg-channel-slider',
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

        $('.epg-channel-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.epg-channel-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.epg-channel-slider').hide();
        });
    });


    function EPG_date_filter(ele) {

        const channel_id = $(ele).attr('data-channel-id');
        const date       = $(ele).attr('data-choosed-date');

        $.ajax({
            type: "get",
            url: "{{ route('front-end.EPG_date_filter') }}",
            data: {
                _token: "{{ csrf_token() }}",
                channel_id: channel_id,
                date: date,
            },
            success: function(data) {
                $(".data").html(data);
            },
        });

    }
</script>