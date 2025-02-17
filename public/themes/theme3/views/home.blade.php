<?php
       include(public_path('themes/theme3/views/header.php')) ; 

      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
      $order_settings_list = App\OrderHomeSetting::get();  
      $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first(); 

?>

   <!-- loader Start -->
   {{-- <div id="loading">
      <div id="loading-center">
      </div>
   </div> --}}


               <!-- Slider  -->
      <?php 
         
         $check_Kidmode = 0;

      $video_banner = App\Video::where('banner', 1)->where('active', 1)->where('status', 1)->where('draft', 1);

         if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $video_banner = $video_banner->whereNotIn('videos.id', Block_videos());
         }

         if ($check_Kidmode == 1) {
            $video_banner = $video_banner->whereBetween('videos.age_restrict', [0, 12]);
         }

         if (videos_expiry_date_status() == 1) {
            $video_banner = $video_banner->where(function ($query) {
               $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now()->format('Y-m-d\TH:i'));
            });
         }

      $video_banner = $video_banner->latest()->limit(30)->get();

         // Video Category Banner

      $VideoCategory_id = App\VideoCategory::where('in_home',1)->where('banner', 1)->pluck('id')->toArray();

      $VideoCategory_banner = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                 ->whereIn('category_id', $VideoCategory_id)->where('videos.active', 1)->where('videos.status', 1)
                                 ->where('videos.draft', 1)->where('videos.banner', 0);   

                              if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                                 $VideoCategory_banner = $VideoCategory_banner->whereNotIn('videos.id', Block_videos());
                              }

                              if ($check_Kidmode == 1) {
                                 $VideoCategory_banner = $VideoCategory_banner->whereBetween('videos.age_restrict', [0, 12]);
                              }

                              if (videos_expiry_date_status() == 1) {
                                 $VideoCategory_banner = $VideoCategory_banner->where(function ($query) {
                                    $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', now()->format('Y-m-d\TH:i'));
                                 });
                              }

      $VideoCategory_banner = $VideoCategory_banner->latest('videos.created_at')->limit(30)->get();


         $Slider_array_data = array(
            'sliders'            => $sliders, 
            'live_banner'        => App\LiveStream::where('active', 1)->where('status',1)->where('banner', 1)->get() , 
            'video_banners'      => $video_banner ,
            'series_sliders'     => $series_sliders ,
            'live_event_banners' => App\LiveEventArtist::where('active', 1)->where('status',1)->where('banner', 1)->get(),
            'Episode_sliders'    => App\Episode::where('active', '1')->where('status', '1')->where('banner', '1')->latest()->get(),
            'VideoCategory_banner' => $VideoCategory_banner ,
         );    
      ?>

      <section id="home" class="iq-main-slider p-0">
         
         {{-- Message Note  --}}
               <div id="message-note" ></div>

         <div id="home-slider" class="slider m-0 p-0">
            {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/slider-1', $Slider_array_data )->content() !!}
         </div>

      </section>

               <!-- MainContent -->
               

      <div class="main-content">
                                        {{-- continue watching videos --}}
         @if( !Auth::guest() && !is_null($continue_watching_setting) &&  $continue_watching_setting == 1 )
            {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/continue-watching', ['data' => $cnt_watching, 'order_settings_list' => $order_settings_list ])->content() !!}
         @endif
         
         @forelse ($order_settings as $key => $item) 
         
            @if( $item == 'latest_videos' && $home_settings->latest_videos == 1 )         {{-- latest videos --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest-videos', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/trending-videoloop', ['data' => $featured_videos, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/live-videos', ['data' => $livetream, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}}
                  <?php $parentCategories =   App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/videoCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}}
                  <?php $parentCategories = App\LiveCategory::orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/liveCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
                  {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/artist-videos', ['data' => $artist, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest-albums', ['data' => $albums, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest-audios', ['data' => $latest_audios, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'series' && $home_settings->series == 1 )        {{-- series  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest-series', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'ContentPartner' && $home_settings->content_partner == 1 )        {{-- content partner  --}}
                <?php $ModeratorsUser = App\ModeratorsUser::where('status',1)->get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/ContentPartners', ['data' => $ModeratorsUser , 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'ChannelPartner' && $home_settings->channel_partner == 1 )        {{-- channel partner  --}}
               <?php $channels = App\Channel::where('status',1)->get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/ChannelPartners', ['data' => $channels, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'Series_Genre' && $home_settings->SeriesGenre == 1 )        {{-- Series Genre  --}}
               <?php $parentCategories = App\SeriesGenre::orderBy('order','ASC')->get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/SeriesGenre', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'Audio_Genre' && $home_settings->AudioGenre == 1 )        {{-- Audios Genre  --}}
               <?php $parentCategories = App\AudioCategory::orderBy('order','ASC')->get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/AudioGenre', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/videos-based-categories', ['order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @if( $item == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/livestreams-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/series-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
                  
            @if( $item == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/Audios-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'latest_viewed_Videos' && $home_settings->latest_viewed_Videos == 1 ) {{-- Latest Viewed Videos --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest_viewed_Videos', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @if( $item == 'latest_viewed_Livestream' && $home_settings->latest_viewed_Livestream == 1 ) {{-- Latest Viewed Livestream    --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest_viewed_Livestream', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @if( $item == 'latest_viewed_Audios' && $home_settings->latest_viewed_Audios == 1 ) {{-- Latest Viewed Audios    --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest_viewed_Audios', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @if( $item == 'latest_viewed_Episode' && $home_settings->latest_viewed_Episode == 1 ) {{-- Latest Viewed Episode   --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/latest_viewed_Episode', [ 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( !Auth::guest() && $item == 'my_play_list' && $home_settings->my_playlist == 1 ) {{-- MY PlayList --}}
               <?php $MyPlaylist = App\MyPlaylist::where('user_id',Auth::user()->id)->get() ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/my-playlist', [ 'data' => $MyPlaylist ,'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'video_play_list' && $home_settings->video_playlist == 1 ) {{-- Video PlayList  --}}
               <?php $AdminVideoPlaylist = App\AdminVideoPlaylist::get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/playlist-videos', [ 'data' => $AdminVideoPlaylist ,'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            
            @if( $item == 'video_schedule' && $home_settings->video_schedule == 1 ) {{-- schedule  --}}
               <?php $AdminVideoPlaylist = App\AdminVideoPlaylist::get(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/schedule', [ 'data' => $VideoSchedules ,'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'Recommendation')  {{-- Recommendation --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/Top_videos', ['data' => $top_most_watched, 'order_settings_list' => $order_settings_list ])->content() !!}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/most_watched_country', ['data' => $Most_watched_country, 'order_settings_list' => $order_settings_list ])->content() !!}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/most_watched_user', ['data' => $most_watch_user, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'series_episode_overview' && $home_settings->series_episode_overview == 1 )    {{--  series_episode_overview  --}}
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/series_episode_overview', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'Today-Top-videos' && $home_settings->Today_Top_videos == 1 )      {{-- Today Top video --}} 
               <?php $video_details = App\Video::where('active',1)->where('status',1)->where('draft',1)->where('today_top_video',1)->first(); ?>
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/Today-Top-videos', ['data' => $video_details, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @if(  $item == 'Leaving_soon_videos' && $home_settings->Leaving_soon_videos == 1 )     
               {!! Theme::uses('theme3')->load('public/themes/theme3/views/partials/home/Going-to-expiry-videos', ['order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
         @empty
             
         @endforelse
      </div>

      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>

   <script>

      function read_more_details(ele) {
         let read_more_content = '.' + $(ele).attr('data-read-more-id');
         
         $(read_more_content).slideToggle();

         if ($(ele).text() === "Read more") {
            $(ele).text("Read less");
         } else {
            $(ele).text("Read more");
         }
      }
   </script>

   <style>
      #home-slider .descp p{margin-bottom:.2rem;}
   </style>

<?php
   include(public_path('themes/theme3/views/partials/home/home_pop_up.php'));
   include(public_path('themes/theme3/views/footer.blade.php')) ;
   include(public_path('themes/theme3/views/partials/home/HomePage-wishlist-watchlater-script.blade.php')) ; 
?>