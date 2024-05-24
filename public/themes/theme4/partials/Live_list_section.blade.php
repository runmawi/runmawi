
<div class="trending-contens sub_dropdown_image mt-3" id="home-live-videos-container">
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
                                        <div class="col-lg-6">
                                            <img src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
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