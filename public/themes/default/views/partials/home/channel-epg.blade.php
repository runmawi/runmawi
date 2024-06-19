      
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

    $data =  App\AdminEPGChannel::where('status',1)->limit(15)->get()->map(function ($item) use ($default_vertical_image_url ,$default_horizontal_image_url , $carbon_now , $carbon_today , $current_timezone) {
                
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/'.$item->image ) : $default_vertical_image_url ;
                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EPG-Channel/'.$item->player_image ) : $default_horizontal_image_url;
                $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EPG-Channel/'.$item->logo ) : $default_vertical_image_url;
                                                    
                $item['ChannelVideoScheduler_current_video_details']  =  App\ChannelVideoScheduler::where('channe_id',$item->id)->where('choosed_date' , $carbon_today )
                                                                            ->limit(15)->get()->map(function ($item) use ($carbon_now , $current_timezone) {

                                                                                $TimeZone   = App\TimeZone::where('id',$item->time_zone)->first();

                                                                                $converted_start_time = Carbon\Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->start_time, $TimeZone->time_zone )
                                                                                                                                ->copy()->tz( $current_timezone );

                                                                                $converted_end_time = Carbon\Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->end_time, $TimeZone->time_zone )
                                                                                                                                ->copy()->tz( $current_timezone );

                                                                                if ($carbon_now->between($converted_start_time, $converted_end_time)) {
                                                                                    $item['video_image_url'] = URL::to('public/uploads/images/'.$item->image ) ;
                                                                                    $item['converted_start_time'] = $converted_start_time->format('h:i A');
                                                                                    $item['converted_end_time']   =   $converted_end_time->format('h:i A');
                                                                                    return $item ;
                                                                                }

                                                                            })->filter()->first();


                return $item;
    });

@endphp 
        
@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ optional($order_settings_list[33])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ "view all" }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <div class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $key => $epg_channel_data)
                                <li class="slide-item">
                                  <div class="block-images position-relative">
                                      <div class="border-bg">
                                          <div class="img-box">
                                              <a class="playTrailer" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                    @if ($multiple_compress_image == 1)
                                                        <img class="img-fluid w-100" alt="{{ $epg_channel_data->title }}" src="{{ $epg_channel_data->image ?  URL::to('public/uploads/images/'.$epg_channel_data->image) : $default_vertical_image_url }}"
                                                            srcset="{{ URL::to('public/uploads/PCimages/'.$epg_channel_data->responsive_image.' 860w') }},
                                                            {{ URL::to('public/uploads/Tabletimages/'.$epg_channel_data->responsive_image.' 640w') }},
                                                            {{ URL::to('public/uploads/mobileimages/'.$epg_channel_data->responsive_image.' 420w') }}" >
                                                    @else
                                                        <img src="{{ $epg_channel_data->image_url }}" class="img-fluid w-100" alt="{{ $epg_channel_data->title }}"  width="300" height="200">
                                                    @endif

                                                    @if (videos_expiry_date_status() == 1 && optional($epg_channel_data)->expiry_date)
                                                        <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                                    @endif
                                              </a>
                                          </div>
                                      </div>
                                      <div class="block-description">
                                          <a class="playTrailer" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                            <img src="{{ $epg_channel_data->image_url }}" class="img-fluid w-100" alt="{{ $epg_channel_data->title }}"  width="300" height="200">
                                          </a>
                                          <div class="hover-buttons text-white">
                                              <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                  <p class="epi-name text-left m-0">{{ __($epg_channel_data->name) }}</p>
                                              </a>

                                              <!-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="#epg-e" data-choosed-date="{{ $carbon_now->format('n-j-Y') }}" data-channel-id="{{ $epg_channel_data->id }}"  onclick="EPG_date_filter(this)"><i class="fa fa-list-alt mr-2" aria-hidden="true" ></i> Event </a> -->

                                              <a class="epi-name mt-1 mb-0 btn" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                  {{ __('Visit Audio Category') }}
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Events Modal --}}

        @foreach ($data as $key => $epg_channel_data)
            <div class="modal fade info_model" id="{{ 'Home-epg-events-Modal-' .$key }}" tabindex="-1" aria-hidden="true">
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

                                                {!! Theme::uses('default')->load('public/themes/default/views/partials/home/channel-epg-partial', ['order_settings_list' => $order_settings_list ,'epg_channel_data' => $epg_channel_data , 'EPG_date_filter_status' => 0 ])->content() !!}

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