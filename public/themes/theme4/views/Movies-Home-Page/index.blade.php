

@php
    
    include(public_path('themes/theme4/views/header.php'));

     $homepage_array_data = [ 'order_settings_list' => $order_settings_list, 
                              'multiple_compress_image' => $multiple_compress_image, 
                              'videos_expiry_date_status' => $videos_expiry_date_status,
                              'getfeching' => $getfeching,
                              'default_vertical_image_url' => $default_vertical_image_url,
                              'default_horizontal_image_url' => $default_horizontal_image_url,
                         ];
@endphp


      

               <!-- MainContent -->

      <div class="main-content">
        @forelse ($order_settings as $key => $item) 

                

                {{-- latest videos --}}
                @if(isset($item->video_name) && $item->video_name == 'latest_videos' && $home_settings->latest_videos == '1')
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-videos", array_merge($homepage_array_data, ['data' => $latest_video]) )->content() !!}
                @endif

                {{-- featured videos --}}
                @if(isset($item->video_name) && $item->video_name == 'featured_videos' && $home_settings->featured_videos == '1')
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/trending-videoloop", array_merge($homepage_array_data, ['data' => $featured_videos]) )->content() !!}
                @endif

                {{-- video Categories --}} 
                @if(isset($item->video_name) && $item->video_name == 'videoCategories' && $home_settings->videoCategories == '1')
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/videoCategories", array_merge($homepage_array_data, ['data' => $video_categories]) )->content() !!}
                @endif

                {{-- Videos Based on Category  --}}
                @if(isset($item->video_name) && $item->video_name == 'category_videos' && $home_settings->category_videos == '1')
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/videos-based-categories",array_merge($homepage_array_data, ['data' => $video_based_category]) )->content() !!}
                @endif

                {{-- Latest Viewed Videos --}}
                @if(isset($item->video_name) && $item->video_name == 'latest_viewed_Videos' && $home_settings->latest_viewed_Videos == '1')
                    {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest_viewed_Videos",array_merge($homepage_array_data, ['data' => $latestViewedVideos]) )->content() !!}
                @endif

        @empty

        @endforelse
      </div>

      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>

<?php
   include(public_path('themes/theme4/views/partials/home/home_pop_up.php'));
   include(public_path('themes/theme4/views/footer.blade.php')) ;
?>
