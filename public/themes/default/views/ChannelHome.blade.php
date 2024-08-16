<!-- Header Start -->
@php include public_path("themes/{$current_theme}/views/header.php"); @endphp

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
        /* position:absolute !important;
        bottom:35px !important; */
        left: 3%;
    }
</style>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::to('/public/uploads/settings/' . $settings->favicon) }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

{{-- Channel Banner --}}
<div id="home-slider">
    <section id="home-slider" class="channel-header h-100" style="position:relative;background:url('{{ !empty($channel_partner->channel_banner) && ($channel_partner->channel_banner != null) ? $channel_partner->channel_banner : URL::to('public/uploads/images/' . $settings->default_horizontal_image) }}');height:calc(100vh - 130px);background-color: rgba(0, 0, 0, 0.45);background-blend-mode: multiply;background-repeat:no-repeat;background-size:cover;">

        <!-- Add black overlays using ::before and ::after pseudo-elements -->
        <div style="position:absolute; left:0; top:0; width:100%; height:100%; pointer-events:none;">
            <div style="position:absolute; top:0; left:0; width:3%; height:100%; background-color:black;"></div>
            <div style="position:absolute; top:0; right:0; width:3%; height:100%; background-color:black;"></div>
        </div>
        
        <div class="container-fluid" style="position:absolute;bottom: -4%;">

            {{-- Channel Logo --}}
            <div class="">
            <div class="mt-3 container-fluid">
                    <div class="col-12 p-0">
                        @if(!empty($channel_partner->channel_about) && $channel_partner->channel_about != null)
                            <h6 style="line-height:1.5"> {{ $channel_partner->channel_about }} </h6> 
                        @endif
                    </div>
                <div class="row align-items-center">

                    <div class="pl-3">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                            @php include(public_path("themes/{$current_theme}/views/partials/channel-social-share.php")); @endphp
                        </ul>
                    </div>
                    
                    @if(!empty(@$channel_partner) && $channel_partner->intro_video != null)
                        <div class="" style="max-width:20% !important;">
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
                                            <video id="channel-intro-video-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls >
                                                <source src="{{ @$channel_partner->intro_video }}" type="video/mp4" >
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="channel-imgs  container-fluid">
                <img src="{{ !empty($channel_partner->channel_logo) && $channel_partner->channel_logo != null ? $channel_partner->channel_logo : URL::to('/public/uploads/images/' . $settings->default_video_image) }}"  width="150" alt="user" style="border-radius:25px;">
            </div>

            </div>
        </div>
    </section>
</div>


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
                                'channel_partner_slug' => isset($channel_partner) ? $channel_partner->channel_slug : null,
                            ];
@endphp
<div class='channel_home mt-5' >
     
    @forelse ($order_settings as $key => $item)
        
        @if( $item->video_name == 'latest_videos' && $home_settings->latest_videos == '1') {{-- latest videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-videos", array_merge($homepage_array_data, ['data' => $latest_video]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/trending-videoloop", array_merge($homepage_array_data, ['data' => $featured_videos]) )->content() !!} </div>
        @endif     

        @if(  $item->video_name == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}} 
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/videoCategories",  array_merge($homepage_array_data, ['data' => $genre_video_display]) )->content() !!}</div>
        @endif

        @if(  $item->video_name == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/artist-videos",  array_merge($homepage_array_data) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'series' && $home_settings->series == 1 )        {{-- series  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-series", array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!} </div>
        @endif

        @if ( $item->video_name == 'series' && $home_settings->series == 1) {{-- latest-series  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/featured-episodes", array_merge($homepage_array_data, ['data' => $featured_episodes]) )->content() !!} </div>
        @endif

        @if ( $item->video_name == 'series' && $home_settings->series == 1 ) {{-- featured-episodes  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/Latest-episodes", array_merge($homepage_array_data, ['data' => $latest_episode]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/live-videos", array_merge($homepage_array_data, ['data' => $livetream]) )->content() !!}</div>
        @endif
        
        @if(  $item->video_name == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live Artist videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/live-videos", array_merge($homepage_array_data, ['data' => $artist_live_event]) )->content() !!}</div>
        @endif
        
        @if(  $item->video_name == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}} 
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/liveCategories", array_merge($homepage_array_data, ['data' => $LiveCategory]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-audios", array_merge($homepage_array_data, ['data' => $latest_audios]) )->content() !!}</div>
        @endif

        @if(  $item->video_name == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-albums", array_merge($homepage_array_data, ['data' => $albums]) )->content() !!}</div>
        @endif

        @if( $item->video_name == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-videos-based-categories", array_merge($homepage_array_data,['data' => $VideoCategory]) )->content() !!}
        @endif

        @if(  $item->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-series-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-Audios-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-livestreams-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

    @empty
    
        <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
            <h4 class="main-title mb-4 ">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
            <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
        </div>
    @endforelse
</div>

<!-- video-js Style  -->

<link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet">

<!-- video-js Script  -->
<script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var player = videojs('channel-intro-video-player', { 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            controlBar: {
                volumePanel: { inline: false },
                children: [
                    'playToggle',
                    'flexibleWidthSpacer',
                    'progressControl',
                    'remainingTimeDisplay',
                    'playbackRateMenuButton',
                    'fullscreenToggle'
                ],
                pictureInPictureToggle: true,
            }
        });

        $('#videoModal').on('hidden.bs.modal', function () {
            player.pause();
            player.currentTime(0);
        });
    });
</script>

@php include public_path("themes/{$current_theme}/views/footer.blade.php"); @endphp