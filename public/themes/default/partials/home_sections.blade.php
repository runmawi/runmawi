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
        {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/artist-videos',  array_merge($homepage_array_data) )->content() !!}
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

@empty

@endforelse