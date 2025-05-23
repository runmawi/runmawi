      
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
   
@php    

    $current_timezone = current_timezone();
    $carbon_now = Carbon\Carbon::now( $current_timezone ); 
    $carbon_current_time =  $carbon_now->format('H:i:s');
    $carbon_today =  $carbon_now->format('n-j-Y');

@endphp 
        
@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ optional($order_settings_list[33])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ "View all" }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list channel-epg-video">
                                @foreach ($data as $key => $epg_channel_data)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $epg_channel_data->image_url }}" class="flickity-lazyloaded" alt="{{ ($epg_channel_data)->name }}" width="233" height="133">
                                            @if (videos_expiry_date_status() == 1 && optional($epg_channel_data)->expiry_date)
                                                <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="channel-epg-video-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $epg_channel_data )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2><br>

                                        @if (optional($epg_channel_data)->description)
                                            <div class="trending-dec">{!! html_entity_decode( optional($epg_channel_data)->description) !!}</div><br>
                                        @endif

                                        @if ( !is_null($epg_channel_data->ChannelVideoScheduler_current_video_details) )
                                            <div class="d-flex align-items-center p-0">
                                                <img src="{{ $epg_channel_data->ChannelVideoScheduler_current_video_details->video_image_url }}" alt="epg_channel_data" ><br>
                                                
                                                <ul>
                                                    <p> {{ $epg_channel_data->ChannelVideoScheduler_current_video_details->socure_title }}  </p> 
                                                    <p> {{ $current_timezone ." - ". $epg_channel_data->ChannelVideoScheduler_current_video_details->converted_start_time ." to ". $epg_channel_data->ChannelVideoScheduler_current_video_details->converted_end_time   }} </p> 
                                                    <p><img class="blob" src="public\themes\theme4\views\img\Live-Icon.webp" alt="epg_channel_data" width="70px" style="position: static !important ; margin:0% !important"></p>
                                                </ul>

                                            </div>
                                        @endif

                                        <div class="p-btns">

                                            <div class="d-flex align-items-center p-0">

                                                @if ( !is_null($epg_channel_data->ChannelVideoScheduler_current_video_details) )
                                                    <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                @endif

                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-epg-events-Modal-'.$key }}" data-choosed-date="{{ $carbon_now->format('n-j-Y') }}" data-channel-id="{{ $epg_channel_data->id }}"  onclick="EPG_date_filter(this)"><i class="fa fa-list-alt mr-2" aria-hidden="true" ></i> Event </a>

                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-epg-channel-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        @if ( $multiple_compress_image == 1)
                                            <img  alt="latest_series" src="{{$epg_channel_data->player_image ?  URL::to('public/uploads/images/'.$epg_channel_data->player_image) : $default_horizontal_image_url }}"
                                                srcset="{{ URL::to('public/uploads/PCimages/'.$epg_channel_data->responsive_player_image.' 860w') }},
                                                {{ URL::to('public/uploads/Tabletimages/'.$epg_channel_data->responsive_player_image.' 640w') }},
                                                {{ URL::to('public/uploads/mobileimages/'.$epg_channel_data->responsive_player_image.' 420w') }}" >
                                        @else
                                            <img  src="{{ $epg_channel_data->Player_image_url }}" alt="epg_channel_data">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
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
                                            <img  src="{{ $epg_channel_data->Player_image_url }}" alt="modal">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">

                                                    <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2>

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
                                                
                                                    {{-- ChannelVideoScheduler_top_date --}}

                                                <ul class="nav nav-tabs m-0" role="tablist">
                                                    @for ($i = 0; $i < 7; $i++) 
                                                        @php $epg_top_date = $carbon_now->copy()->addDays($i); @endphp
                                                        <li role="presentation" data-choosed-date="{{ $epg_top_date->format('n-j-Y') }}" data-channel-id="{{ $epg_channel_data->id }}" onclick="EPG_date_filter(this)">
                                                            <a href="#" aria-controls="tab" aria-label="date" role="tab" data-toggle="tab">{{ $epg_top_date->format('d-m-y') }}</a>
                                                        </li>
                                                    @endfor
                                                </ul>

                                                <button class="tabs__scroller tabs__scroller--right js-action--scroll-right"><i class="fa fa-chevron-right"></i></button>
                                            </div>

                                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/channel-epg-partial', ['order_settings_list' => $order_settings_list ,'epg_channel_data' => $epg_channel_data , 'EPG_date_filter_status' => 0 ])->content() !!}

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

var elem = document.querySelector('.channel-epg-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
    document.querySelectorAll('.channel-epg-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.channel-epg-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.channel-epg-video-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.channel-epg-video-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.channel-epg-video-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.channel-epg-video-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('channel-epg-video-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.channel-epg-video-dropdown').hide();
    });
    function EPG_date_filter(ele) {

        const channel_id = $(ele).attr('data-channel-id');
        const date       = $(ele).attr('data-choosed-date');

        $(".data").html('<table class="table table-striped"><tr><td><h6>Loading....</h6></td></tr></table>');

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
            error: function(xhr, status, error) {
                $(".data").html('<p>Error loading data. Please try again.</p>');
            }

        });
    }
</script>