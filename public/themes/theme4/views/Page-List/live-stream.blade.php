@php
    include public_path("themes/{$current_theme}/views/header.php");

    $Current_time = App\Setting::pluck('default_time_zone')->first(); 
@endphp

<section id="iq-favorites">
    <div class="container-fluid pl-0">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class=" fira-sans-condensed-regular main-title mar-left">
                            {{ $order_settings_list[3]->header_name ? __($order_settings_list[3]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($live_list_pagelist)->isNotEmpty())

                    <div class="trending-contens sub_dropdown_image mt-3" id="home-live-videos-container">
                        <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left">
                       
                            @forelse($live_list_pagelist as $key => $livestream_videos)
                                <div class="network-image">
                                    <div class="movie-sdivck position-relative">
                                        <img src="{{ $livestream_videos->image ?  $BaseURL.('/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $livestream_videos->title }}" width="300" height="200">
                    
                                        @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && $livestream_videos->publish_time <=  Carbon\Carbon::now($Current_time)->format('Y-m-d\TH:i'))) 
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
                                            <div class="modal-content" style="border:none;background:transparent;">
                                                <div class="res-view-hide position-absolute mb-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-3">
                                                                <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_vertical_image_url }}" alt="modal">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                                        <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>
                                                                    </div>
                                                                    <div class="res-view-show col-lg-2 col-md-2 col-sm-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && $livestream_videos->publish_time <=  Carbon\Carbon::now($Current_time)->format('Y-m-d\TH:i'))) 
                                                                
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
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </div>
                        <div class="col-md-12 pagination justify-content-end">
                            {!! $live_list_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        /* .network-image img{width: 100%; height:auto;} */
        .movie-sdivck{padding:2px;}
        .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }

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

    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
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

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>