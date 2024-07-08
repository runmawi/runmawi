<!-- Header Start -->
<?php
    include public_path("themes/{$current_theme}/views/header.php");
?>

<style>
    hr{
        border-top:none!important;
        height: 1px;
         background-image: linear-gradient(90deg, white, transparent);
    }
    .lkn{
        cursor: pointer;
    }
    
    .channel-img img{
        position:absolute !important;
        bottom:35px !important;
        left: 3%;
    }
</style>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::to('/public/uploads/settings/' . $settings->favicon) }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<section class="channel-header" style="position:relative;background-color: rgba(0, 0, 0, 0.45);background-blend-mode: multiply;">
    <img src="{{ !empty($channel_partner->channel_banner) && ($channel_partner->channel_banner != null) ? $channel_partner->channel_banner : URL::to('public/uploads/images/' . $settings->default_horizontal_image) }}" alt="channel-banner" style="height:75vh;
    width:93%;opacity:0.8;position:relative;left:3%;filter: brightness(0.8) contrast(0.8) saturate(0.6);border-radius:20px;" class="channel-banner">

    <div class="container-fluid" style="position:absolute;bottom: 50px;">
        <div class="channels-img container-fluid">
            <img src="{{ !empty($channel_partner->channel_logo) && $channel_partner->channel_logo != null ? $channel_partner->channel_logo : URL::to('/public/uploads/images/' . $settings->default_video_image) }}"  width="150" alt="user">
        </div>

        <div class="mt-3 container-fluid">
            <div class="channel-about">
                @if(!empty($channel_partner->channel_about) && $channel_partner->channel_about != null)
                    <h6>{{ __('About Channel') }} : {{ $channel_partner->channel_about }} </h6> 
                @endif
            </div>
            <div class="row">
                <div class="col-1 col-lg-1">
                    <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                        @php include(public_path("themes/{$current_theme}/views/partials/channel-social-share.php")); @endphp
                    </ul>
                </div>
                @if(!empty(@$channel_partner) && $channel_partner->intro_video != null)
                    <div class="col-4 col-lg-4 d-flex align-items-center" style="max-width:20% !important;">
                        <a class="lkn" data-video="{{ @$channel_partner->intro_video }}" data-toggle="modal" data-target="#videoModal" data-backdrop="static" data-keyboard="false"  style="cursor: pointer;">	
                            <span class="text-white">
                                <i class="fa fa-play mr-1" aria-hidden="true"></i> {{  __('About Channel Partner')  }}
                            </span>
                        </a>

                        <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog"  style='max-width: 800px;'>
                                <div class="modal-content" style="background-color: transparent;border:none;">
                                    <button type="button" class="close" style='color:red;' data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="modal-body">
                                        <video id="videoPlayer1" 
                                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                                            type="video/mp4" src="{{ @$channel_partner->intro_video }}">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                @endif
            </div>
        </div>

</section>
    


@php 

    $homepage_array_data = [ 'order_settings_list' => $order_settings_list, 
                                'multiple_compress_image' => $multiple_compress_image, 
                                'videos_expiry_date_status' => $videos_expiry_date_status,
                                'getfeching' => $getfeching,
                                'settings' => $settings,
                                'ThumbnailSetting' => $ThumbnailSetting,
                                'currency' => App\CurrencySetting::first(),
                                'default_vertical_image_url' => $default_vertical_image_url,
                                'default_horizontal_image_url' => $default_horizontal_image_url,
                                'continue_watching_setting' => $HomeSetting->continue_watching,  
                            ];
@endphp

<div class='channel_home mt-4'>
     
    @if(count($latest_video) > 0 || count($livetream) > 0 || count($latest_series) > 0 || count($audios) > 0)
        
        <div>
            {!! Theme::uses('default')->load("public/themes/default/views/partials/home/latest-videos", array_merge($homepage_array_data, ['data' => $latest_video]) )->content() !!}
        </div>
       
        <div>
            {!! Theme::uses('default')->load("public/themes/default/views/partials/home/live-videos", array_merge($homepage_array_data, ['data' => $livetream]) )->content() !!}
        </div>

        <div>
            {!! Theme::uses('default')->load("public/themes/default/views/partials/home/latest-series", array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!}
        </div>

        <div>
            {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-audios', array_merge($homepage_array_data, ['data' => $latest_audios]) )->content() !!}
        </div>
    @else
        <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
            <h4 class="main-title mb-4 ">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
            <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
    // const player = new Plyr('#videoPlayer1'); 

    //   $(document).ready(function(){
    //     $(".close").click(function(){
    //         $('#videoPlayer1')[0].pause();
    //     });
    // });
</script>

@php include public_path("themes/{$current_theme}/views/footer.blade.php"); @endphp