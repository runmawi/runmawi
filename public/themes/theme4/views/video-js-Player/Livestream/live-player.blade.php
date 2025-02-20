@php
    $recurring_program_Status  = false ;
    $live_publish_later_status = false;

    if ( $Livestream_details->publish_type == "recurring_program" ) {

        $recurring_program_Status = true ;

        $recurring_timezone = App\TimeZone::where('id', $Livestream_details->recurring_timezone)->pluck('time_zone')->first();

        $Current_time = Carbon\Carbon::now(current_timezone());
        $convert_time = $Current_time->copy()->timezone($recurring_timezone);

        switch ($Livestream_details->recurring_program) {

            case 'custom':

                if ( $Livestream_details->custom_start_program_time <= $convert_time->format('Y-m-d\TH:i:s') &&  $Livestream_details->custom_end_program_time >= $convert_time->format('Y-m-d\TH:i:s') ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'daily':

                if ( $Livestream_details->program_start_time <= $convert_time->format('H:i') &&  $Livestream_details->program_end_time >= $convert_time->format('H:i')  ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'weekly':

                if ( $Livestream_details->recurring_program_week_day == $convert_time->format('N') && $Livestream_details->program_start_time <= $convert_time->format('H:i') &&  $Livestream_details->program_end_time >= $convert_time->format('H:i')  ) {
                    $recurring_program_Status = false ;
                }
                break;

            case 'monthly':

                if ( $Livestream_details->recurring_program_month_day == $convert_time->format('d') && $Livestream_details->program_start_time <= $convert_time->format('H:i') &&  $Livestream_details->program_end_time >= $convert_time->format('H:i')   ) {
                    $recurring_program_Status = false ;
                }
                break;

            default:
                break;
        }
    }
    elseif ( $Livestream_details->publish_type == "publish_later"  ) {

        $live_publish_later_status = true ;

        $Current_time = Carbon\Carbon::now(current_timezone());

        if ( Carbon\Carbon::parse($Livestream_details->publish_time)->format('Y-m-d\TH:i')  <=  $Current_time->format('Y-m-d\TH:i')) {
            $live_publish_later_status =  false ;
        }
    }
@endphp

@if( $recurring_program_Status == false && $live_publish_later_status ==  false )

    @if ( $Livestream_details->users_video_visibility_status || ( Auth::check() && Auth::user()->role == "subscriber" && $Livestream_details->access == "ppv" && $enable_ppv_rent_live == 1))

        <div id="video sda" class="fitvid" style="margin: 0 auto;">
            @if ( $Livestream_details->url_type == "embed" )

                <iframe class="responsive-iframe" src="{{ $Livestream_details->livestream_URL }}" poster="{{ $Livestream_details->Player_thumbnail }}"
                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" width="200" height="200"
                    allowfullscreen>
                </iframe>

            @else

                                {{-- Back Button --}}
                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>

                <video id="live-stream-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                    width="auto" height="auto" poster="{{ $Livestream_details->Player_thumbnail }}" playsinline="playsinline"
                    autoplay>
                    <source src="{{ $Livestream_details->livestream_URL }}" type="{{ $Livestream_details->livestream_player_type }}">
                </video>
            @endif

                                    {{-- Free duration --}}
            <div class="video" id="visibilityMessage" style="color: white; display: none; background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $Livestream_details->player_image_url  }}');background-size: cover; height:100vh;">
                <div class="row container" style="padding-top:4em;">
                    <div class="col-2"></div>

                    <div class="col-lg-3 col-6 mt-5">
                        <img class="posterImg w-100"  src="{{ $Livestream_details->image_url }}" >
                    </div>

                    <div class="col-lg-6 col-6 mt-5">

                        <h2 class="title">{{ optional($Livestream_details)->title }} </h2><br>
                        <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>
                        <a class="btn" href="{{ $Livestream_details->users_video_visibility_redirect_url }}">

                            <div class="playbtn" style="gap:5px">
                                {!! $play_btn_svg !!}
                                <span class="text pr-2"> {{ __( $Livestream_details->users_video_visibility_status_button ) }} </span>
                            </div>
                        </a>

                        {{-- subscriber & PPV  --}}

                        @if ( $Livestream_details->access == "subscriber" && !is_null($Livestream_details->ppv_price) )
                            <a class="btn" href="{{ $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $Livestream_details->id,PPV_CurrencyConvert($Livestream_details->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $Livestream_details->id, $Livestream_details->ppv_price ]) }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @else
    
        <div id="" style="background: linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url({{ URL::to('/') }}/public/uploads/images/{{ $Livestream_details->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 100px 10px;">
            <div class="container-fluid video-details">
                <div class="col-8">
                    <h2 class="banner-details text-left">{{ ucwords($Livestream_details->title) }}</h2><br>
                    <p class="trending-dec w-100 mb-0 text-white mb-4"> {{ __(html_entity_decode(strip_tags($Livestream_details->description))) }}</p>
                    <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>
                    @if ( $Livestream_details->users_video_visibility_Rent_button || $Livestream_details->users_video_visibility_becomesubscriber_button || $Livestream_details->users_video_visibility_register_button )
                        <a class="btn mr-3" {{ $Livestream_details->users_video_visibility_Rent_button ? 'data-toggle=modal data-target=#live-purchase-now-modal' : 'href=' . $Livestream_details->users_video_visibility_redirect_url }} >
                            <div class="playbtn text-white" style="gap:5px">
                                {!! $play_btn_svg !!}
                                <span class="text pr-2"> {{ __( $Livestream_details->users_video_visibility_status_button ) }} </span>
                            </div>
                        </a>

                        @if( ($Livestream_details->access == "ppv" && Auth::guest() && $subscribe_btn == 1) || ($Livestream_details->access == "ppv" && Auth::check() && Auth::user()->role !== "subscriber" && $subscribe_btn == 1))
                            <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                <div class="playbtn text-white" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( !empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now' ) }}  </span>
                                </div>
                            </a>
                        @endif

                    @endif

                    {{-- subscriber & PPV  --}}

                    @if ( $Livestream_details->access == "subscriber" && !is_null($Livestream_details->ppv_price) )
                        <a class="btn" href="{{ $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $Livestream_details->id,PPV_CurrencyConvert($Livestream_details->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $Livestream_details->id, $Livestream_details->ppv_price ]) }}">
                            <div class="playbtn" style="gap:5px">
                                {!! $play_btn_svg !!}
                                <span class="text pr-2"> {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                            </div>
                        </a>
                    @endif
                
                </div>    
            </div>
        </div>
    @endif

@elseif( $recurring_program_Status == true )

    <div id="" style="background: linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url({{ URL::to('/') }}/public/uploads/images/{{ $Livestream_details->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 100px 10px;">

        <div class="container-fluid video-details">
            <div class="col-8">
                <h2 class="banner-details text-left">{{ ucwords($Livestream_details->title) }}</h2><br>
                <p class="trending-dec w-100 mb-0 text-white mb-4"> {{ __(html_entity_decode(strip_tags($Livestream_details->description))) }}</p>


                @if ($Livestream_details->publish_type == "recurring_program")

                    @php
                        $timezone = App\TimeZone::where('id',$Livestream_details->recurring_timezone)->pluck('time_zone')->first();
                        $startTime = Carbon\Carbon::parse($Livestream_details->program_start_time)->isoFormat('h:mm A');
                        $endTime = Carbon\Carbon::parse($Livestream_details->program_end_time)->isoFormat('h:mm A');
                    @endphp

                    @if ($Livestream_details->recurring_program == "daily")

                        <h3 class="banner-details text-left">Live Streaming On {{ $Livestream_details->recurring_program }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h3>

                    @elseif ($Livestream_details->recurring_program == "weekly")

                        @switch($Livestream_details->recurring_program_week_day)
                            @case(0)
                                @php $recurring_program_week_day = "Sunday"; @endphp
                                @break
                            @case(1)
                                @php $recurring_program_week_day = "Monday"; @endphp
                                @break
                            @case(2)
                                @php $recurring_program_week_day = "Tuesday"; @endphp
                                @break
                            @case(3)
                                @php $recurring_program_week_day = "Wednesday"; @endphp
                                @break
                            @case(4)
                                @php $recurring_program_week_day = "Thursday"; @endphp
                                @break
                            @case(5)
                                @php $recurring_program_week_day = "Friday"; @endphp
                                @break
                            @case(6)
                                @php $recurring_program_week_day = "Saturday"; @endphp
                                @break
                            @default
                                @php $recurring_program_week_day = "Unknown"; @endphp
                        @endswitch

                        <h3>Live Streaming On Every Week {{ $recurring_program_week_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h3>

                    @elseif ($Livestream_details->recurring_program == "monthly")

                        <h3>Live Streaming On Every Month on Day {{ $Livestream_details->recurring_program_month_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h3>

                    @elseif ($Livestream_details->recurring_program == "custom")

                        @php
                            $customStartTime = Carbon\Carbon::parse($Livestream_details->custom_start_program_time)->format('j F Y g:ia');
                            $customEndTime = Carbon\Carbon::parse($Livestream_details->custom_end_program_time)->format('j F Y g:ia');
                        @endphp

                        <h3>Live Streaming On {{ $customStartTime }} - {{ $customEndTime }}</h3>
                        <h3>({{ $timezone }})</h3>
                    @endif
                @endif

                    {{-- Subscribe & PPV --}}
                    @if (Auth::check() && Auth::user()->role == "subscriber" && $Livestream_details->access == "ppv" &&  $enable_ppv_rent_live == 1)
                                        
                                    
                    @elseif ( $Livestream_details->users_video_visibility_status == false )
                        <h5 class="title mt-5"> {{ ( !empty($button_text->live_visible_text) ? $button_text->live_visible_text : $Livestream_details->users_video_visibility_status_message ) }}</h5><br>
                        <div class="d-flex">
                            @if ( $Livestream_details->users_video_visibility_Rent_button || $Livestream_details->users_video_visibility_becomesubscriber_button || $Livestream_details->users_video_visibility_register_button )
                                <a class="btn mr-3" {{ $Livestream_details->users_video_visibility_Rent_button ? 'data-toggle=modal data-target=#live-purchase-now-modal' : 'href=' . $Livestream_details->users_video_visibility_redirect_url }} >
                                    <div class="playbtn text-white" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( $Livestream_details->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>

                                @if( ($Livestream_details->access == "ppv" && Auth::guest() && $subscribe_btn == 1) || ($Livestream_details->access == "ppv" && Auth::check() && Auth::user()->role !== "subscriber" && $subscribe_btn == 1))
                                    <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                        <div class="playbtn text-white" style="gap:5px">
                                            {!! $play_btn_svg !!}
                                            <span class="text pr-2"> {{ __( !empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now' ) }}  </span>
                                        </div>
                                    </a>
                                @endif

                            @endif

                            {{-- subscriber & PPV  --}}

                            @if ( $Livestream_details->access == "subscriber" && !is_null($Livestream_details->ppv_price) )
                                <a class="btn 3" data-toggle="modal" data-target="#live-purchase-now-modal">
                                    <div class="playbtn mr-3" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endif
            </div>
        </div>



    </div>

@elseif( $live_publish_later_status == true )
    <div id="" style="background: linear-gradient(220deg, rgba(4, 21, 45, 0) 0%, #050505 79.17%), url({{ URL::to('/') }}/public/uploads/images/{{ $Livestream_details->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 10px 10px;">

        <div class="container-fluid video-details" >
            <div class="col-8">
                <h2 class="banner-details text-left">{{ ucwords($Livestream_details->title) }}</h2><br>
                <p class="trending-dec w-100 mb-3 text-white"> {{ __(html_entity_decode(strip_tags($Livestream_details->description))) }}</p>


                <h3 class="banner-details text-left">{{ "Live Streaming Coming Soon On ". Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $Livestream_details->publish_time)->format('l, jS F Y g:ia') }}</h3>

                    {{-- Subscribe & PPV --}}
                @if($Livestream_details->users_video_visibility_status == false)
                    <div class="video" >
                        <div class="row container p-0">

                                                {{-- Back Button --}}
                            <!-- <button class="staticback-btn" onclick="history.back()" title="Back Button">
                                <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                            </button> -->

                            <!-- <div class="col-2"></div> -->

                            <!-- <div class="col-lg-3 col-6 mt-5">
                                <img class="posterImg w-100"  src="{{ $Livestream_details->Thumbnail }}" >
                            </div> -->

                            <div class="col-lg-12 col-12 mt-5">
                                <!-- <h2 class="title">{{ optional($Livestream_details)->title }} </h2><br> -->
                                


                                
                                    @if ($Livestream_details->users_video_visibility_status == false && Auth::check() && Auth::user()->role == "subscriber" && $Livestream_details->access == "ppv" &&  $enable_ppv_rent_live == 1)
                                        
                                    
                                    @elseif ( $Livestream_details->users_video_visibility_status == false )
                                        <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>
                                        <div class="d-flex">
                                            @if ( $Livestream_details->users_video_visibility_Rent_button || $Livestream_details->users_video_visibility_becomesubscriber_button || $Livestream_details->users_video_visibility_register_button )
                                                <a class="btn mr-3" {{ $Livestream_details->users_video_visibility_Rent_button ? 'data-toggle=modal data-target=#live-purchase-now-modal' : 'href=' . $Livestream_details->users_video_visibility_redirect_url }} >
                                                    <div class="playbtn text-white" style="gap:5px">
                                                        {!! $play_btn_svg !!}
                                                        <span class="text pr-2"> {{ __( $Livestream_details->users_video_visibility_status_button ) }} </span>
                                                    </div>
                                                </a>

                                                @if( ($Livestream_details->access == "ppv" && Auth::guest() && $subscribe_btn == 1) || ($Livestream_details->access == "ppv" && Auth::check() && Auth::user()->role !== "subscriber" && $subscribe_btn == 1))
                                                    <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                                        <div class="playbtn text-white" style="gap:5px">
                                                            {!! $play_btn_svg !!}
                                                            <span class="text pr-2"> {{ __( !empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now' ) }} </span>
                                                        </div>
                                                    </a>
                                                @endif

                                            @endif

                                            {{-- subscriber & PPV  --}}

                                            @if ( $Livestream_details->access == "subscriber" && !is_null($Livestream_details->ppv_price) )
                                                <a class="btn" data-toggle="modal" data-target="#live-purchase-now-modal">
                                                    <div class="playbtn mr-3" style="gap:5px">
                                                        {!! $play_btn_svg !!}
                                                        <span class="text pr-2">  {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                                                    </div>
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <a class="btn" href="{{ $Livestream_details->users_video_visibility_redirect_url }}">
                                            <div class="playbtn" style="gap:5px">
                                                {!! $play_btn_svg !!}
                                                <span class="text pr-2"> {{ __( $Livestream_details->users_video_visibility_status_button ) }} </span>
                                            </div>
                                        </a>
                                    @endif
                                
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endif

<script>
    $(document).ready(function () {

        let recurring_program_check_exist = "{{ json_encode($recurring_program_Status) }}";
        let live_publish_later_status_exist  = "{{ json_encode($live_publish_later_status) }}";

        if (recurring_program_check_exist == "true") {

            let reloadInterval = setInterval(function() {

                recurring_program_check_exist = "{{ json_encode($recurring_program_Status) }}";

                if (recurring_program_check_exist == "true") {
                    location.reload();
                } else {
                    clearInterval(reloadInterval);
                }
            }, 60000);

        }else if( live_publish_later_status_exist == 'true' ){

            let reloadInterval = setInterval(function() {

                live_publish_later_status_exist = "{{ json_encode($live_publish_later_status) }}";

                if (live_publish_later_status_exist == "true") {
                    location.reload();
                } else {
                    clearInterval(reloadInterval);
                }
            }, 60000);
        }
    });
</script>

<style>
    .text{
        /* text-transform: uppercase; */
        font-size: 20px !important;
        font-weight: 500;
    }
    .banner-live-details{
        text-align: left !important;
        padding: 0 40px;
    }
    svg{width: 30px;height: auto;}
</style>
