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

    @if ( $Livestream_details->users_video_visibility_status)

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
                                    <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @else

        <div class="video" style="background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $Livestream_details->player_Thumbnail  }}');background-size: cover; height:100vh;">
            <div class="row container" style="padding-top:4em;">

                                    {{-- Back Button --}}
                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                </button>

                <div class="col-2"></div>

                <div class="col-lg-3 col-6 mt-5">
                    <img class="posterImg w-100"  src="{{ $Livestream_details->Thumbnail }}" >
                </div>

                <div class="col-lg-6 col-6 mt-5">
                    <h2 class="title">{{ optional($Livestream_details)->title }} </h2><br>
                    <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>

                    <a class="btn" id="{{ $Livestream_details->users_video_visibility_redirect_url }}" href="{{ $Livestream_details->users_video_visibility_redirect_url != 'live-purchase-now-button' ? $Livestream_details->users_video_visibility_redirect_url : '#' }}">
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
                                <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

@elseif( $recurring_program_Status == true )

    <div id="" style="background: linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url({{ URL::to('/') }}/public/uploads/images/{{ $Livestream_details->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 100px 10px;">

        <h2 class="banner-live-details">{{ ucwords($Livestream_details->title) }}</h2><br>

        @if ($Livestream_details->publish_type == "recurring_program")

            @php
                $timezone = App\TimeZone::where('id',$Livestream_details->recurring_timezone)->pluck('time_zone')->first();
                $startTime = Carbon\Carbon::parse($Livestream_details->program_start_time)->isoFormat('h:mm A');
                $endTime = Carbon\Carbon::parse($Livestream_details->program_end_time)->isoFormat('h:mm A');
            @endphp

            @if ($Livestream_details->recurring_program == "daily")

                <h2 class="banner-live-details">Live Streaming On {{ $Livestream_details->recurring_program }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>

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

                <h2>Live Streaming On Every Week {{ $recurring_program_week_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>

            @elseif ($Livestream_details->recurring_program == "monthly")

                <h2>Live Streaming On Every Month on Day {{ $Livestream_details->recurring_program_month_day }} from {{ $startTime }} to {{ $endTime }} - {{ $timezone }}</h2>

            @elseif ($Livestream_details->recurring_program == "custom")

                @php
                    $customStartTime = Carbon\Carbon::parse($Livestream_details->custom_start_program_time)->format('j F Y g:ia');
                    $customEndTime = Carbon\Carbon::parse($Livestream_details->custom_end_program_time)->format('j F Y g:ia');
                @endphp

                <h3>Live Streaming On {{ $customStartTime }} - {{ $customEndTime }}</h3>
                <h3>({{ $timezone }})</h3>
            @endif
        @endif

        <div class="container-fluid video-details">
            <div class="row">

                            {{-- BREADCRUMBS --}}

                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bc-icons-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text"  href="{{ route('liveList') }}"> {{ucwords(__('Livestreams')) }}</a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>


                                    <li class="breadcrumb-item"><a class="black-text">{{ strlen($Livestream_details->title) > 50 ? ucwords(substr($Livestream_details->title, 0, 120) . '...') : ucwords($Livestream_details->title) }}</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 col-md-9 col-xs-12">
                    <h1 class="trending-text big-title text-uppercase mt-3">
                        {!!  optional($Livestream_details)->title !!}
                    </h1>
                </div>

                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right">
                        <div class="views">
                            <span class="view-count"><i class="fa fa-eye"></i>
                                {{ isset($view_increment) && $view_increment ? $Livestream_details->views + 1 : $Livestream_details->views }} {{  __('Views')  }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- languages, categories time, public_current_time ,age_restrict -->
            <div class=" align-items-center text-white text-detail p-0">
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->languages->name) }}</span>
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->categories->name) }}</span>
                <span class="badge badge-secondary p-2">{{ __('Published On :'. $Livestream_details->public_current_time ) }} </span>
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->age_restrict) }}</span>
            </div>

                    <!-- Social Share, Like Dislike -->
            <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <ul class="list-inline p-0 mt-4 share-icons music-play-lists">

                        {!! Theme::uses("default")->load("public/themes/default/views/video-js-Player/Livestream/live-socail-share", ['Livestream_details' => $Livestream_details, 'play_btn_svg' => $play_btn_svg])->content() !!}
                    </ul>
                </div>
            </div>
        </div>

                {{-- Description --}}
        <div class="container-fluid">
            <div class="text-white col-md-6 p-0">
                <p class="trending-dec w-100 mb-0 text-white"> {!! html_entity_decode(__($Livestream_details->description)) !!}</p>
                <p class="trending-dec w-100 mb-3 text-white">{!! html_entity_decode(__($Livestream_details->details)) !!}</p>
            </div>
        </div>

            {{-- Subscribe & PPV --}}
        @if($Livestream_details->users_video_visibility_status == false)
            <div class="video" >
                <div class="row container">

                                        {{-- Back Button --}}
                    <!-- <button class="staticback-btn" onclick="history.back()" title="Back Button">
                        <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                    </button> -->

                    <!-- <div class="col-2"></div> -->

                    <!-- <div class="col-lg-3 col-6 mt-5">
                        <img class="posterImg w-100"  src="{{ $Livestream_details->Thumbnail }}" >
                    </div> -->

                    <div class="col-lg-6 col-6 mt-5" style="padding: 0 40px;">
                        <!-- <h2 class="title">{{ optional($Livestream_details)->title }} </h2><br> -->
                        <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>

                        <a class="btn" id="{{ $Livestream_details->users_video_visibility_redirect_url }}" href="{{ $Livestream_details->users_video_visibility_redirect_url != 'live-purchase-now-button' ? $Livestream_details->users_video_visibility_redirect_url : '#' }}">
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
                                    <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>

@elseif( $live_publish_later_status == true )
    <div id="" style="background: linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url({{ URL::to('/') }}/public/uploads/images/{{ $Livestream_details->player_image }}); background-repeat: no-repeat; background-size: cover; padding: 100px 10px;">

        <h2 class="banner-live-details">{{ ucwords($Livestream_details->title) }}</h2><br>

        <h2 class="banner-live-details">{{ "Live Streaming Coming Soon On ". Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $Livestream_details->publish_time)->format('l, jS F Y g:ia') }}</h2>

        <div class="container-fluid video-details">
            <div class="row">

                            {{-- BREADCRUMBS --}}

                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bc-icons-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text"  href="{{ route('liveList') }}"> {{ucwords(__('Livestreams')) }}</a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>


                                    <li class="breadcrumb-item"><a class="black-text">{{ strlen($Livestream_details->title) > 50 ? ucwords(substr($Livestream_details->title, 0, 120) . '...') : ucwords($Livestream_details->title) }}</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 col-md-9 col-xs-12">
                    <h1 class="trending-text big-title text-uppercase mt-3">
                        {!!  optional($Livestream_details)->title !!}
                    </h1>
                </div>

                <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class=" d-flex mt-4 pull-right">
                        <div class="views">
                            <span class="view-count"><i class="fa fa-eye"></i>
                                {{ isset($view_increment) && $view_increment ? $Livestream_details->views + 1 : $Livestream_details->views }} {{  __('Views')  }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- languages, categories time, public_current_time ,age_restrict -->
            <div class=" align-items-center text-white text-detail p-0">
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->languages->name) }}</span>
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->categories->name) }}</span>
                <span class="badge badge-secondary p-2">{{ __('Published On :'. $Livestream_details->public_current_time ) }} </span>
                <span class="badge badge-secondary p-2">{{ __(@$Livestream_details->age_restrict) }}</span>
            </div>

                    <!-- Social Share, Like Dislike -->
            <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <ul class="list-inline p-0 mt-4 share-icons music-play-lists">

                        {!! Theme::uses("default")->load("public/themes/default/views/video-js-Player/Livestream/live-socail-share", ['Livestream_details' => $Livestream_details, 'play_btn_svg' => $play_btn_svg])->content() !!}
                    </ul>
                </div>
            </div>
        </div>

                {{-- Description --}}
        <div class="container-fluid">
            <div class="text-white col-md-6 p-0">
                <p class="trending-dec w-100 mb-0 text-white"> {!! html_entity_decode(__($Livestream_details->description)) !!}</p>
                <p class="trending-dec w-100 mb-3 text-white">{!! html_entity_decode(__($Livestream_details->details)) !!}</p>
            </div>
        </div>

            {{-- Subscribe & PPV --}}
        @if($Livestream_details->users_video_visibility_status == false)
            <div class="video" >
                <div class="row container">

                                        {{-- Back Button --}}
                    <!-- <button class="staticback-btn" onclick="history.back()" title="Back Button">
                        <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                    </button> -->

                    <!-- <div class="col-2"></div> -->

                    <!-- <div class="col-lg-3 col-6 mt-5">
                        <img class="posterImg w-100"  src="{{ $Livestream_details->Thumbnail }}" >
                    </div> -->

                    <div class="col-lg-6 col-6 mt-5" style="padding: 0 40px;">
                        <!-- <h2 class="title">{{ optional($Livestream_details)->title }} </h2><br> -->
                        <h5 class="title"> {{ $Livestream_details->users_video_visibility_status_message }}</h5><br>

                        <a class="btn" id="{{ $Livestream_details->users_video_visibility_redirect_url }}" href="{{ $Livestream_details->users_video_visibility_redirect_url != 'live-purchase-now-button' ? $Livestream_details->users_video_visibility_redirect_url : '#' }}">
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
                                    <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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
        text-transform: capitalize;
        font-size: 20px !important;
        font-weight: 500;
    }
    .banner-live-details{
        text-align: left !important;
        padding: 0 40px;
    }
</style>
