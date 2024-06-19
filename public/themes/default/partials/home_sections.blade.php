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
                         ];
    $order_settings = App\OrderHomeSetting::select('id','order_id','url','video_name','header_name')->orderBy('order_id', 'asc')->get();  
    $order_settings_list = App\OrderHomeSetting::get();
@endphp

@forelse ($order_settings as $key => $item)

    @if( $item->video_name == 'latest_videos' && $home_settings->latest_videos == '1') {{-- latest videos --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-videos', array_merge($homepage_array_data, ['data' => $latest_video]) )->content() !!}
    @endif

    @if(  $item->video_name == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/artist-videos',  array_merge($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
          {!! Theme::uses('default')->load('public/themes/default/views/partials/home/live-videos', array_merge($homepage_array_data, ['data' => $livetream]) )->content() !!}
     @endif

     @if(  $item->video_name == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
          {!! Theme::uses('default')->load('public/themes/default/views/partials/home/trending-videoloop', array_merge($homepage_array_data, ['data' => $featured_videos]) )->content() !!}
     @endif

    @if(  $item->video_name == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}} 
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/videoCategories',  array_merge($homepage_array_data, ['data' => $video_categories]) )->content() !!}
    @endif

    @if(  $item->video_name == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-albums', array_merge($homepage_array_data, ['data' => $albums]) )->content() !!}
    @endif

    @if( $item->video_name == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/videos-based-categories', array_merge($homepage_array_data,['order_settings_list' => $order_settings_list ]) )->content() !!}
    @endif

    @if(  $item->video_name == 'ContentPartner' && $home_settings->content_partner == 1 )        {{-- content partner  --}}
        <?php $ModeratorsUser = App\ModeratorsUser::where('status',1)->limit(15)->get(); ?>
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/ContentPartners', array_merge($homepage_array_data, ['data' => $ModeratorsUser]) )->content() !!}
    @endif

    @if(  $item->video_name == 'latest_viewed_Livestream' && $home_settings->latest_viewed_Livestream == 1 ) {{-- Latest Viewed Livestream    --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest_viewed_Livestream', ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'latest_viewed_Episode' && $home_settings->latest_viewed_Episode == 1 ) {{-- Latest Viewed Episode   --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest_viewed_Episode', ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/series-based-categories', array_merge($homepage_array_data , ['data' => $Series_based_on_category ]) )->content() !!}
    @endif

    @if(  $item->video_name == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Audios-based-categories',  ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/livestreams-based-categories', ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}} 
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/liveCategories', array_merge($homepage_array_data, ['data' => $LiveCategory]) )->content() !!}
    @endif

    @if(  $item->video_name == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-audios', array_merge($homepage_array_data, ['data' => $latest_audios]) )->content() !!}
    @endif

    @if(  $item->video_name == 'series' && $home_settings->series == 1 )        {{-- series  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-series', array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!}
    @endif

    @if(  $item->video_name == 'ChannelPartner' && $home_settings->channel_partner == 1 )        {{-- channel partner  --}}
     
        <?php $channels = App\Channel::where('status',1)->limit(15)->get(); ?>
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/ChannelPartners', array_merge($homepage_array_data, ['data' => $channels]) )->content() !!}
    @endif

    @if(  $item->video_name == 'latest_viewed_Videos' && $home_settings->latest_viewed_Videos == 1 ) {{-- Latest Viewed Videos --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest_viewed_Videos', ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'latest_viewed_Audios' && $home_settings->latest_viewed_Audios == 1 ) {{-- Latest Viewed Audios    --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest_viewed_Audios', ($homepage_array_data) )->content() !!}
    @endif

    @if(  $item->video_name == 'Series_Genre' && $home_settings->SeriesGenre == 1 )        {{-- Series Genre  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/SeriesGenre', array_merge($homepage_array_data, ['data' => $SeriesGenre]) )->content() !!}
    @endif

    @if(  $item->video_name == 'Audio_Genre' && $home_settings->AudioGenre == 1 )        {{-- Audio Genre  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/AudioGenre', array_merge($homepage_array_data, ['data' => $SeriesGenre]) )->content() !!}
    @endif

    @if( !Auth::guest() &&  $item->video_name == 'my_play_list' && $home_settings->my_playlist == 1 ) {{-- MY PlayList --}}
        @php $MyPlaylist = !Auth::guest() ? App\MyPlaylist::where('user_id',Auth::user()->id)->limit(15)->get() : []; @endphp
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/my-playlist', array_merge($homepage_array_data , ['data' => $MyPlaylist ]))->content() !!}
    @endif

    @if(  $item->video_name == 'Today-Top-videos' && $home_settings->Today_Top_videos == 1 )      {{-- Today Top video --}} 
        <?php $video_details = App\Video::latest()->first(); ?>
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Today-Top-videos', array_merge($homepage_array_data , ['data' => $video_details ]))->content() !!}
    @endif

    @if(  $item->video_name == 'watchlater_videos' && $home_settings->watchlater_videos == 1 )        {{-- watchlater_videos  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/watchlater_videos', array_merge($homepage_array_data, ['data' => $SeriesGenre]) )->content() !!}
    @endif

    @if(  $item->video_name == 'wishlist_videos' && $home_settings->wishlist_videos == 1 )        {{-- wishlist_videos  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/wishlist_videos', array_merge($homepage_array_data, ['data' => $SeriesGenre]) )->content() !!}
    @endif

    @if( $Series_Networks_Status == 1 &&  $item->video_name == 'Series_Networks' && $home_settings->Series_Networks == 1 )      {{-- Series Networks --}} 
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Series-Networks', $homepage_array_data )->content() !!}
    @endif

    @if(   $item->video_name == 'Leaving_soon_videos' && $home_settings->Leaving_soon_videos == 1 )     
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Going-to-expiry-videos', $homepage_array_data )->content() !!}
    @endif

    @if(  $item->video_name == 'series_episode_overview' && $home_settings->series_episode_overview == 1 )    {{--  series_episode_overview  --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/series_episode_overview', array_merge($homepage_array_data , ['data' => $latest_video ]))->content() !!}
    @endif

    @if(  $Series_Networks_Status == 1 &&   $item->video_name == 'Series_based_on_Networks' && $home_settings->Series_based_on_Networks == 1 )      {{-- Series based on Networks--}} 
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Series-based-on-Networks', array_merge($homepage_array_data , ['data' => $Series_based_on_Networks ]) )->content() !!}
    @endif

    @if(   $item->video_name == 'EPG' && $home_settings->epg == 1 )     
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/channel-epg', $homepage_array_data)->content() !!}
    @endif

    @if(  $item->video_name == 'Recommendation')  {{-- Recommendation --}}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/Top_videos', array_merge($homepage_array_data , ['data' => $top_most_watched ]))->content() !!}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/most_watched_country', array_merge($homepage_array_data , ['data' => $Most_watched_country ]))->content() !!}
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/most_watched_user', array_merge($homepage_array_data , ['data' => $most_watch_user ]))->content() !!}
    @endif
@empty

@endforelse