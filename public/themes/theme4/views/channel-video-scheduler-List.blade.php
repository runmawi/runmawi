<?php include(public_path('themes/theme4/views/header.php')) ; ?>

@if (!empty($ChannelVideoScheduler) && $ChannelVideoScheduler->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header align-items-center justify-content-between">
                        <h4 class="main-title mar-left">{{ "channel video scheduler" }}</h4>
                    </div>

                    <div class="trending-contens sub_dropdown_image mt-3">
                        <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($ChannelVideoScheduler as $key => $Channel_videoScheduler_data)
                                <div class="network-image">
                                    <div class="movie-sdivck position-relative">
                                        <img src="{{ $Channel_videoScheduler_data->image ?  URL::to('public/uploads/images/'.$Channel_videoScheduler_data->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                        
                                        <div class="controls">        
                                            <a href="{{ URL::to('category/videos/'.$Channel_videoScheduler_data->slug) }}">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>
                                            <nav>
                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#channel-video-scheduler-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade info_model" id="channel-video-scheduler-{{ $key }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                        <div class="container">
                                            <div class="modal-content" style="border:none; background:transparent;">
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <img src="{{ $Channel_videoScheduler_data->image ?  URL::to('public/uploads/images/'.$Channel_videoScheduler_data->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                                        <h2 class="caption-h2">{{ optional($Channel_videoScheduler_data)->name }}</h2>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>  
                                                                </div>
                                                                @if (optional($Channel_videoScheduler_data)->description)
                                                                    <div class="trending-dec">{!! html_entity_decode( optional($Channel_videoScheduler_data)->description) !!}</div>
                                                                @endif
                                                                    
                                                                @if ( !is_null($Channel_videoScheduler_data->ChannelVideoScheduler_current_video_details) )
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <img src="{{ $Channel_videoScheduler_data->ChannelVideoScheduler_current_video_details->video_image_url }}" alt="Channel_videoScheduler_data" style="height: 30%; width:30%"><br>
                                                                        
                                                                        <ul>
                                                                            <p> {{ $Channel_videoScheduler_data->ChannelVideoScheduler_current_video_details->socure_title }}  </p> 
                                                                            <p> {{ $current_timezone ." - ". $Channel_videoScheduler_data->ChannelVideoScheduler_current_video_details->converted_start_time ." to ". $Channel_videoScheduler_data->ChannelVideoScheduler_current_video_details->converted_end_time   }} </p> 
                                                                            <p><img class="blob" src="public\themes\theme4\views\img\Live-Icon.webp" alt="Channel_videoScheduler_data" style="position: static !important ; margin:0% !important; width:70px"></p>
                                                                        </ul> 
                                                                    </div>
                                                                @endif

                                                                {{-- <a href="#" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-epg-events-Modal-'.$key }}" data-choosed-date="{{ $carbon_now->format('n-j-Y') }}" data-channel-id="{{ $Channel_videoScheduler_data->id }}"  onclick="EPG_date_filter(this)"><i class="fa fa-list-alt mr-2" aria-hidden="true" ></i> Event </a> --}}
                                                                <a href="{{ URL::to('category/videos/'.$Channel_videoScheduler_data->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
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
        
        
        {{-- Events Modal --}}

        @foreach ($ChannelVideoScheduler as $key => $epg_channel_data)
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

                                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/channel-epg-partial', ['order_settings_list' => $order_settings_list ,'epg_channel_data' => $ChannelVideoScheduler , 'EPG_date_filter_status' => 0 ])->content() !!}

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
@else
   <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
        <p ><h3 class="text-center">No Channel Schedular Available</h3>
    </div>
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

<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        .network-image img{width: 100%; height:auto;}
        .movie-sdivck{padding:2px;}
        #trending-slider-nav div.slick-slide{padding:2px;}
        div#trending-slider-nav .slick-slide.slick-current .movie-sdivck.position-relative{border:2px solid red}
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
    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
    }
</style>

<?php include(public_path('themes/theme4/views/footer.blade.php')) ;?>