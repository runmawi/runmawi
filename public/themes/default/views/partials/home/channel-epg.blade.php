   
<style>
    .time {
        width: 28%;
        font-size: 18px;
        height: 100%;
        background-color: rgba(129, 128, 128, 0.1);
        color: #fff;
    }
    table.table tr {
        border-bottom: 1px solid rgba(255,255,255,0.5);
        border-left: 1px solid rgba(255,255,255,0.5);
        border-right: 1px solid rgba(255,255,255,0.5);

    }
    .panel-heading.panel-heading-nav.d-flex {
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        border-top: 1px solid rgba(255, 255, 255, 0.5);
    }
    .table td, .table th{
        border-top:none;
    }
    .nav-tabs{
        border-right: 1px solid;
        border-top: 1px solid;
        border-left: 1px solid;
        border-bottom: 1px solid;
    }
    ul.nav.nav-tabs li{
        white-space: nowrap;
        background-color: rgba(0, 0, 0, 0.75);
        border-right: 1px solid rgba(255,255,255,0.5);
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
    .fade:not(.show){
        opacity:1;
    }
    .info_model {
        display: none;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        background-color: var(--background-opacity);
        padding: 0 4%;
    }
    .info_model .container {
        position: relative;
        margin-top: 7vmin;
        max-width: 100%;
    }
    .info_model .container {
        position: relative;
        margin-top: 7vmin;
        max-width: 100%;
    }
    .modal-dialog-centered .modal-content {
        background: transparent;
    }
    .events-click{color:#fff;cursor: pointer;text-decoration:underline;}
    .tab-pane{height:100%;}

    nav {
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
    .moreBTN {
        color: #fff;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: rgba(51, 51, 51, 0.4);
        border: none;
        padding: 8px;
        border-radius: 4px;
        -webkit-box-shadow: none;
        box-shadow: none;
        font-size: calc(12px + 0.25vmin);
        font-weight: 700;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
        cursor: pointer;
        outline: none;
        line-height: 14px;
    }
    .moreBTN span {
        width: 0;
        margin-left: 0;
        overflow: hidden;
        white-space: nowrap;
        display: inline-block;
    }
    .moreBTN:hover {
        background-color: #fff;
        color: #000;
    }
    .moreBTN:hover span {
        width: auto;
        margin-left: 4px;
    }

    @media (max-width:720px){
        .modal-body{padding:0 !important;}
        button.tabs__scroller.tabs__scroller--left.js-action--scroll-left{height:49px;}
        .panel-heading-nav {
            display: flex;
            align-items: center;
            overflow: hidden;
            white-space: nowrap;
        }

        .nav-tabs {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: hidden; /* Changed from auto to hidden */
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth; /* Add smooth scrolling */
        }

        .nav-tabs li {
            flex: 0 0 auto;
        }

        .tabs__scroller {
            font-size: 0.2em;
        }

        .tabs__scroller--left {
            order: -1;
        }
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
                        <h4 class="main-title view-all"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ "View all" }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <div class="channel-epgslider home-sec list-inline row p-0 mb-0">
                            @foreach ($data as $key => $epg_channel_data)
                                <div class="items">
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
                                                        <img src="{{ $epg_channel_data->image_url }}" data-src="{{ $epg_channel_data->image_url }}" class="img-fluid w-100" alt="{{ $epg_channel_data->title }}"  width="300" height="200">
                                                    @endif

                                                    @if (videos_expiry_date_status() == 1 && optional($epg_channel_data)->expiry_date)
                                                        <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                                    @endif
                                              </a>
                                          </div>
                                      </div>
                                      <div class="block-description">
                                        <nav ><button class="moreBTN" tabindex="0" data-toggle="modal" data-target="<?= '#Home-epg-events-Modal-'.$key ?>" data-choosed-date="<?= $carbon_now->format('n-j-Y') ?>" data-channel-id="<?= $epg_channel_data->id ?>"  onclick="EPG_date_filter(this)"><i class="fas fa-info-circle"></i><span><?= __("View Events") ?></span></button></nav>
                                          <a class="playTrailer" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                            <img src="{{ $epg_channel_data->image_url }}" data-src="{{ $epg_channel_data->image_url }}" class="img-fluid w-100" alt="{{ $epg_channel_data->title }}"  width="300" height="200">
                                          </a>
                                          <div class="hover-buttons text-white">
                                              <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                  <p class="epi-name text-left mt-2 m-0">{{ __($epg_channel_data->name) }}</p>
                                              </a>

                                              <a class="epi-name mt-2 mb-0 btn" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                  {{ __('Visit Now') }}
                                              </a>
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

        {{-- Events Modal --}}

        <?php foreach($data as $key => $epg_channel_data ) : ?>
            <div class="modal fade info_model" id="<?= 'Home-epg-events-Modal-' . $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container m-0">
                        <div class="modal-content" style="border:none;">
                            <div class="modal-body" style="padding: 0 14rem;">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="container m-0">

                                            <div class="row" style="margin-bottom:4%;">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2"><?= optional($epg_channel_data)->name ?></h2>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2"  style="display:flex;align-items:center;justify-content:end;">
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:1;margin-top:0 !important; margin-right:0 !important;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                            <div class="panel-heading panel-heading-nav d-flex position-relative">
                                                <button class="tabs__scroller tabs__scroller--left js-action--scroll-left"><i class="fa fa-chevron-left"></i></button>
                                                
                                                <ul class="nav nav-tabs m-0" role="tablist">
                                                    <?php for ($i = 0; $i < 7; $i++): ?>
                                                        <?php $epg_top_date = $carbon_now->copy()->addDays($i); ?>
                                                        <li role="presentation" data-choosed-date="<?= $epg_top_date->format('n-j-Y') ?>" data-channel-id="<?= $epg_channel_data->id ?>" onclick="EPG_date_filter(this)">
                                                            <a href="#" aria-controls="tab" aria-label="date" role="tab" data-toggle="tab"><?= $epg_top_date->format('d-m-y') ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>

                                                <button class="tabs__scroller tabs__scroller--right js-action--scroll-right"><i class="fa fa-chevron-right"></i></button>
                                            </div>

                                        
                                            <?php
                                                echo Theme::uses('theme1')
                                                    ->load('public/themes/theme1/views/partials/home/channel-epg-partial', [
                                                        'order_settings_list' => $order_settings_list,
                                                        'epg_channel_data' => $epg_channel_data,
                                                        'EPG_date_filter_status' => 0
                                                    ])->content();
                                            ?>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
       

    </section>
@endif

<script>
    function EPG_date_filter(ele) {

        const channel_id = $(ele).attr('data-channel-id');
        const date       = $(ele).attr('data-choosed-date');

        $(".data").html('<table class="table table-striped"><tr><td><h6>Loading....</h6></td></tr></table>');

        $.ajax({
            type: "get",
            url: "<?php echo route('front-end.EPG_date_filter') ?>",
            data: {
                _token: "<?php echo csrf_token() ?>",
                channel_id: channel_id,
                date: date,
            },
            success: function(data) {
                $(".data").html(data);
            },
            error: function(xhr, status, error) {
                console.log(error);
                $(".data").html('<table class="table table-striped"><tr><td><h6>Error loading data. Please try again.</h6></td></tr></table>');
            }

        });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const scrollerLeft = document.querySelector('.js-action--scroll-left');
            const scrollerRight = document.querySelector('.js-action--scroll-right');
            const navTabs = document.querySelector('.nav-tabs');

            scrollerLeft.addEventListener('click', function() {
                navTabs.scrollBy({
                    left: -200, // Adjust scrolling distance as needed
                    behavior: 'smooth'
                });
            });

            scrollerRight.addEventListener('click', function() {
                navTabs.scrollBy({
                    left: 200, // Adjust scrolling distance as needed
                    behavior: 'smooth'
                });
            });
        });
</script>

<script>
    var elem = document.querySelector('.channel-epgslider');
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
 </script>