  
<?php    

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

?>

     
<style>
    .time{
        width: 28%;
        font-size: 18px;
        height: 100%;
        background-color: rgba(129, 128, 128, 0.1);

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
    body.light-theme a, body.light-theme h6{color: <?php echo $GetLightText; ?> !important;cursor: pointer;}

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


        <div class="iq-main-header d-flex align-items-center justify-content-between">
            <h4 class="main-title">
                <a href="<?php if ($order_settings_list[33]->header_name) { echo URL::to('/').'/'.$order_settings_list[33]->url ;} else { echo "" ; } ?>">
                    <?php if ($order_settings_list[33]->header_name) { echo (__($order_settings_list[33]->header_name)) ; } else { echo "" ; } ?>
                </a>
            </h4>  
        </div>


        <div class="favorites-contens">
            <ul class="favorites-slider list-inline row p-0 mb-0">
                <?php 
                    if(isset($data)):
                        foreach($data as $key => $epg_channel_data): ?>
                            <li class="slide-item">
                                <a href="<?= route('Front-End.Channel-video-scheduler',$epg_channel_data->slug ) ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <a href="<?= route('Front-End.Channel-video-scheduler',$epg_channel_data->slug ) ?>">
                                                <img loading="lazy" data-src="<?= $epg_channel_data->image_url; ?>" class="img-fluid w-100" alt="<?= $epg_channel_data->name ?>">
                                            </a>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a class="" href="<?= route('Front-End.Channel-video-scheduler',$epg_channel_data->slug ) ?>">
                                                    <img class="ply" src="<?= URL::to('/assets/img/default_play_buttons.svg'); ?>" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-0">
                                        <div class="mt-2 p-0">
                                            <?php if($ThumbnailSetting->title == 1): ?>
                                                <h6><?php echo (strlen($epg_channel_data->name) > 17) ? substr($epg_channel_data->name, 0, 18) . '...' : $epg_channel_data->name; ?></h6>
                                            <?php endif ?>
                                            <!-- Event modal -->
                                            <a type="button" class="events-click" tabindex="0" data-toggle="modal" data-target="<?= '#Home-epg-events-Modal-'.$key ?>" data-choosed-date="<?= $carbon_now->format('n-j-Y') ?>" data-channel-id="<?= $epg_channel_data->id ?>"  onclick="EPG_date_filter(this)">
                                                <?= __('Click Events') ?>
                                            </a>
                                            <!-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="<?= '#Home-epg-events-Modal-'.$key ?>" ><i class="fa fa-list-alt mr-2" aria-hidden="true" ></i> <?= __('Event') ?> </a> -->
                                        </div>
                                    </div>
                                </a>
                            </li>

                        <?php endforeach;
                    endif; 
                ?>
            </ul>

            <!-- Events Modal -->
            <?php foreach($data as $key => $epg_channel_data ) : ?>
                <div class="modal fade info_model" id="<?= 'Home-epg-events-Modal-' . $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
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
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:1;">
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

             
            
        </div>

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