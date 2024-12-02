<?php
    include public_path("themes/{$current_theme}/views/header.php");

    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
    $order_settings_list = App\OrderHomeSetting::get();
?>


<style>
    hr{ border-top:none!important; height: 1px; background-image: linear-gradient(90deg, white, transparent);}
    .lkn{ cursor: pointer;}
    .nav-tabs {border: 0;margin-top: 20px;text-align: center;}
    .channel_nav .nav-tabs>li {padding: 5px !important;}
    .Live_Categorynav {display: flex;}
    .nav-tabs .nav-item { margin-bottom: -2px;font-family: 'Roboto', sans-serif;}
    .channel_nav .nav-link.active { border-bottom: none !important; background-color: red !important; color: #fff !important; }
    .channel_nav .nav-link { padding: 5px 15px; background-color: #fff; border-bottom: none !important; border-radius: 5px; color: #000 !important; text-transform: capitalize; }
    .tab-pane .nav-link { margin: 5px; max-width: 175px; padding: 6px 15px; text-align: center; }
</style>


<section class="channel-header"
    style="background: url('{{ !empty($channel_partner->channel_banner) && $channel_partner->channel_banner != null  ? $channel_partner->channel_banner  : default_vertical_image_url() }}') no-repeat center center; 
           background-size: cover; height: 350px; background-color: rgba(0, 0, 0, 0.45); background-blend-mode: multiply;">
</section>

<div class="container">
    <div class="position-relative">
        <div class="channel-img">
            <img src="{{ !empty($channel_partner->channel_logo) && $channel_partner->channel_logo != null ? $channel_partner->channel_logo : default_vertical_image_url() }}"  class=" " width="150" alt="user">
        </div>
    </div>
</div>


<section class="mt-5 mb-5">
    <div class="container">
        <div class="row ">

            <div class="col-2 col-lg-2">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    @php include(public_path('themes/theme6/views/partials/channel-social-share.php')); @endphp
                </ul>
            </div>


            @if(!empty(@$channel_partner) && $channel_partner->intro_video != null)

                <div class="col-2 col-lg-2">
                    <a class="lkn" data-video="{{ @$channel_partner->intro_video }}" data-toggle="modal" data-target="#videoModal" data-backdrop="static" data-keyboard="false"  style="cursor: pointer;">	
                        <span class="text-white">
                            <i class="fa fa-play mr-1" aria-hidden="true"></i> About Channel Partner
                        </span>
                    </a>

                    <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog"  style='max-width: 800px;'>
                            <div class="modal-content" style="background-color: transparent;border:none;">
                                <button type="button" class="close" style='color:red;' data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="modal-body">
                                    <video id="videoPlayer1" 
                                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" src="{{ @$channel_partner->intro_video }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @php

                $UserChannelSubscription = true ;

                if ( $settings->user_channel_plans_page_status == 1 ) {

                    $UserChannelSubscription = false ;

                    if (!Auth::guest() ) {

                        $UserChannelSubscription = App\UserChannelSubscription::where('user_id',auth()->user()->id)
                                                        ->where('channel_id',$channel_partner->id)->where('status','active')
                                                        ->where('subscription_start', '<=', Carbon\Carbon::now())
                                                        ->where('subscription_ends_at', '>=', Carbon\Carbon::now())
                                                        ->latest()->exists();

                        if (Auth::user()->role == "admin") {
                            $UserChannelSubscription = true ;
                        }
                    }
                }
            @endphp
    
            @if ( $UserChannelSubscription == false)
                <div class="col-4 col-lg-4" >
                    <p> {{"Subscribe {$channel_partner->channel_name} Channel to Watch content"}} </p>
                    <a class="btn" href="{{ route('channel.payment',$channel_partner->id) }}"   style="cursor: pointer;">
                        <span class="text-white">
                            <i class="fa fa-play mr-1" aria-hidden="true"></i>  {{ __('Subscribe Now' ) }}
                        </span>
                    </a>
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
                                'channel_partner_slug' => isset($channel_partner) ? $channel_partner->channel_slug : null,
                            ];
@endphp

<div class='channel_home' >
     
    @forelse ($order_settings as $key => $item)
        
        @if( $item->video_name == 'latest_videos' && $home_settings->latest_videos == 1) {{-- latest videos --}}
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

        @if ( $item->video_name == 'series' && $home_settings->series == 1 ) {{-- Series --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-episodes", array_merge($homepage_array_data, ['data' => $latest_episode]) )->content() !!} </div>
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
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-videos-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
            {{-- {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-series-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!} --}}
        @endif

        @if(  $item->video_name == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
            {{-- {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-Audios-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!} --}}
        @endif

        @if(  $item->video_name == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/theme6/views/partials/home/channel-livestreams-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

    @empty
    
        <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
            <h4 class="main-title mb-4 ">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
            <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
        </div>
    @endforelse
</div>

<script  src="{{ URL::to('assets/js/plyr.polyfilled.js') }}"></script>
<script  src="{{ URL::to('assets/js/hls.js') }}"></script>

<script>
    const player = new Plyr('#videoPlayer1'); 

    $(document).ready(function(){
        $(".close").click(function(){
            $('#videoPlayer1')[0].pause();
        });
    });
</script>

<?php include public_path("themes/{$current_theme}/views/footer.blade.php");?>