<?php include(public_path('themes/theme4/views/header.php')); ?>

@if (!empty($livestreams_data) && $livestreams_data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0" id="home-live-videos-container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"> {{ _("Today's Livestreams") }} </a></h4>
                        <button class="btn-primary btn" tabindex="0" data-bs-toggle="modal" data-bs-target="#live-lists">View schedule</button>
                    </div>

                        <div class="modal fade info_model" id="live-lists" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                <div class="container">
                                    <div class="modal-content" style="border:none; background:transparent;">
                                        <div class="modal-body" style="padding: 0 14rem;">
                                            <div class="col-lg-12">
                                                <div class="row mb-3">
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-9">
                                                        <h4>{{ "Live Streams List"}}</h4>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2 d-flex justify-content-end">
                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                    @foreach ($livestreams_data as $key => $livestream_videos)
                                                        <div class="row modal-live-details">
                                                            <div class="col-lg-3 col-3">
                                                                <a href="{{ URL::to('live/'.$livestream_videos->slug) }}">
                                                                    <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos" style="width:100px;">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-9 col-9 pl-0">
                                                                <span>
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}"><h4 class="livestream-name">{{ optional($livestream_videos)->title }}</h4> </a>                                                  
                                                                </span>
                                                                <span>
                                                                    @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                    
                                                                        <ul class="vod-info m-0 pt-1">
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
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   

                    <div class="trending-contens sub_dropdown_image mt-3 mar-left">
                        <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($livestreams_data as $key => $livestream_videos)
                                <div class="network-image">
                                    <div class="movie-sdivck position-relative">
                                        <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                        
                                        @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                            <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                        @elseif( $livestream_videos->recurring_program_live_animation  == true )
                                            <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                        @endif
                                        
                                        <div class="controls">        
                                            <a href="{{ URL::to('live/'.$livestream_videos->slug) }}">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>
                                            <nav>
                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#live-list-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade info_model" id="live-list-{{ $key }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                        <div class="container">
                                            <div class="modal-content" style="border:none; background:transparent;">
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-6">
                                                                <img src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                            </div>
                                                            <div class="col-lg-6 col-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-9 col-sm-9 col-9">
                                                                        <div class="d-flex">
                                                                            <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>
                                                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                                <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" style="height:22px;width:59px;"></div>
                                                                            @elseif( $livestream_videos->recurring_program_live_animation  == true )
                                                                                <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" style="height:22px;width:59px;"></div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if($livestream_videos->publish_type == "recurring_program")
                                                                    <p>{{ 'Live Start On '. Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') }}</p>
                                                                @endif
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

                                                            <div class="trending-dec">{!! html_entity_decode( $livestream_videos->description ) ??  $livestream_videos->description  !!}</div>
                                                        
                                                                <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                                    <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        /* .network-image img{width: 100%; height:auto;} */
        .movie-sdivck{padding:2px;}
        #trending-slider-nav div.slick-slide{padding:2px;}
        div#trending-slider-nav .slick-slide.slick-current .movie-sdivck.position-relative{border:2px solid red}
        .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }
    .row.modal-live-details:hover{background-color:#eee;color:#000;}
    .row.modal-live-details:hover .livestream-name{color:#000 !important;}
    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
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
    .row.modal-live-details {border: 1px solid;padding: 10px 0;background-color: rgba(0, 0, 0, 0.75);}
    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .blob{display: none;}
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
    }
</style>

@php include public_path('themes/theme4/views/footer.blade.php'); @endphp