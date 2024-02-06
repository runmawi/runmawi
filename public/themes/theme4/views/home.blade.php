<?php
      include(public_path('themes/theme4/views/header.php')) ; 

      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
      $order_settings_list = App\OrderHomeSetting::get();  
      $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first(); 
      $admin_advertistment_banners = App\AdminAdvertistmentBanners::first(); 
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

         <!-- <div class="sidenav">
                     {{-- Left Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->left_banner_status == 1 )

               @if (optional($admin_advertistment_banners)->left_image_url )
                  
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->left_image_url }}" /> 
                  
               @endif

               @if (optional($admin_advertistment_banners)->left_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->left_script_url }}"></script>
               @endif
            @endif

            

            {{-- Top Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->top_banner_status == 1 )
               @if (optional($admin_advertistment_banners)->top_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->top_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->top_script_url )
                     <script src="{{ optional($admin_advertistment_banners)->top_script_url }}"></script>
               @endif
            @endif
         </div> -->

         <div class="rightnav">
                     {{-- Right Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->right_banner_status == 1 )
               @if (optional($admin_advertistment_banners)->right_image_url )
                  
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->right_image_url }}" /> 
                  
               @endif

               @if (optional($admin_advertistment_banners)->right_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->right_script_url }}"></script>
               @endif
            @endif
            

         </div>
      <div class="main">
            <div class="bottom-nav">

               @if ( optional($admin_advertistment_banners)->bottom_banner_status == 1 )

                  @if (optional($admin_advertistment_banners)->bottom_image_url )
                     <div class="col-sm-9 mx-auto ">
                        <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->bottom_image_url }}" /> 
                     </div>
                  @endif

                  @if (optional($admin_advertistment_banners)->bottom_script_url )
                     <script src="{{ optional($admin_advertistment_banners)->bottom_script_url }}"></script>
                  @endif
                  
               @endif
            </div>

         <div class="sidenav">
                     {{-- Left Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->left_banner_status == 1 )

               @if (optional($admin_advertistment_banners)->left_image_url )
                  
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->left_image_url }}" /> 
                  
               @endif

               @if (optional($admin_advertistment_banners)->left_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->left_script_url }}"></script>
               @endif
            @endif

            

            {{-- Top Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->top_banner_status == 1 )
               @if (optional($admin_advertistment_banners)->top_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->top_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->top_script_url )
                     <script src="{{ optional($admin_advertistment_banners)->top_script_url }}"></script>
               @endif
            @endif
         </div>




         <section id="home" class="iq-main-slider p-0">
            <div id="home-slider" class="slider m-0 p-0">
               {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/slider-1', $Slider_array_data )->content() !!}
            </div>
         </section>

                  <!-- MainContent -->

         <div class="main-content">
            
            <!-- {{-- Left Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->left_banner_status == 1 )

               @if (optional($admin_advertistment_banners)->left_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->left_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->left_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->left_script_url }}"></script>
               @endif
            @endif

            {{-- Right Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->right_banner_status == 1 )
               @if (optional($admin_advertistment_banners)->right_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->right_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->right_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->right_script_url }}"></script>
               @endif
            @endif
            
            {{-- Top Ads Banners --}}

            @if ( optional($admin_advertistment_banners)->top_banner_status == 1 )
               @if (optional($admin_advertistment_banners)->top_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->top_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->top_script_url )
                     <script src="{{ optional($admin_advertistment_banners)->top_script_url }}"></script>
               @endif
            @endif -->

                                          {{-- continue watching videos --}}
            @if( !Auth::guest() && !is_null($continue_watching_setting) &&  $continue_watching_setting == 1 )
               {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/continue-watching', ['data' => $cnt_watching, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
            @forelse ($order_settings as $key => $item) 
            
               @if( $item == 'latest_videos' && $home_settings->latest_videos == 1 )         {{-- latest videos --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest-videos', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/trending-videoloop', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/live-videos', ['data' => $livetream, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}}
                     <?php $parentCategories =   App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get(); ?>
                     {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/videoCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}}
                     <?php $parentCategories = App\LiveCategory::orderBy('order','ASC')->get(); ?>
                     {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/liveCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
                     {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/artist-videos', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest-albums', ['data' => $albums, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest-audios', ['data' => $latest_audios, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'series' && $home_settings->series == 1 )        {{-- series  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest-series', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'ContentPartner' && $home_settings->content_partner == 1 )        {{-- content partner  --}}
                  <?php $ModeratorsUser = App\ModeratorsUser::where('status',1)->get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/ContentPartners', ['data' => $ModeratorsUser , 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'ChannelPartner' && $home_settings->channel_partner == 1 )        {{-- channel partner  --}}
                  <?php $channels = App\Channel::where('status',1)->get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/ChannelPartners', ['data' => $channels, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'Series_Genre' && $home_settings->SeriesGenre == 1 )        {{-- Series Genre  --}}
                  <?php $parentCategories = App\SeriesGenre::orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/SeriesGenre', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/series-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( $item == 'Audio_Genre' && $home_settings->AudioGenre == 1 )        {{-- Audios Genre  --}}
                  <?php $parentCategories = App\AudioCategory::orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/AudioGenre', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/videos-based-categories', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( $item == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/livestreams-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
                  {{-- {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/series-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!} --}}
               @endif
                     
               @if( $item == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Audios-based-categories', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'latest_viewed_Videos' && $home_settings->latest_viewed_Videos == 1 ) {{-- Latest Viewed Videos --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest_viewed_Videos', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( $item == 'latest_viewed_Livestream' && $home_settings->latest_viewed_Livestream == 1 ) {{-- Latest Viewed Livestream    --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest_viewed_Livestream', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( $item == 'latest_viewed_Audios' && $home_settings->latest_viewed_Audios == 1 ) {{-- Latest Viewed Audios    --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest_viewed_Audios', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( $item == 'latest_viewed_Episode' && $home_settings->latest_viewed_Episode == 1 ) {{-- Latest Viewed Episode   --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest_viewed_Episode', [ 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( !Auth::guest() && $item == 'my_play_list' && $home_settings->my_playlist == 1 ) {{-- MY PlayList --}}
                  <?php $MyPlaylist = App\MyPlaylist::where('user_id',Auth::user()->id)->get() ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/my-playlist', [ 'data' => $MyPlaylist ,'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'video_play_list' && $home_settings->video_playlist == 1 ) {{-- Video PlayList  --}}
                  <?php $AdminVideoPlaylist = App\AdminVideoPlaylist::get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/playlist-videos', [ 'data' => $AdminVideoPlaylist ,'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               
               @if( $item == 'video_schedule' && $home_settings->video_schedule == 1 ) {{-- schedule  --}}
                  <?php $AdminVideoPlaylist = App\AdminVideoPlaylist::get(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/schedule', [ 'data' => $VideoSchedules ,'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'Recommendation')  {{-- Recommendation --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Top_videos', ['data' => $top_most_watched, 'order_settings_list' => $order_settings_list ])->content() !!}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/most_watched_country', ['data' => $Most_watched_country, 'order_settings_list' => $order_settings_list ])->content() !!}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/most_watched_user', ['data' => $most_watch_user, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'series_episode_overview' && $home_settings->series_episode_overview == 1 )    {{--  series_episode_overview  --}}
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/series_episode_overview', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if( $item == 'Today-Top-videos' && $home_settings->Today_Top_videos == 1 )      {{-- Today Top video --}} 
                  <?php $video_details = App\Video::first(); ?>
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Today-Top-videos', ['data' => $video_details, 'order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if( Series_Networks_Status() == 1 && $item == 'Series_Networks' && $home_settings->Series_Networks == 1 )      {{-- Series Networks --}} 
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Series-Networks', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if(  Series_Networks_Status() == 1 &&  $item == 'Series_based_on_Networks' && $home_settings->Series_based_on_Networks == 1 )      {{-- Series based on Networks--}} 
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Series-based-on-Networks', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif
               
               @if(  $item == 'Leaving_soon_videos' && $home_settings->Leaving_soon_videos == 1 )     
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Going-to-expiry-videos', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif

               @if(  $item == 'EPG' && $home_settings->epg == 1 )     
                  {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/channel-epg', ['order_settings_list' => $order_settings_list ])->content() !!}
               @endif

            @empty
               
            @endforelse

                  {{-- End Ads banners --}}

            @if ( optional($admin_advertistment_banners)->bottom_banner_status == 1 )

               @if (optional($admin_advertistment_banners)->bottom_image_url )
                  <div class="col-sm-9 mx-auto ">
                     <img class="img-fluid logo" src="{{ optional($admin_advertistment_banners)->bottom_image_url }}" /> 
                  </div>
               @endif

               @if (optional($admin_advertistment_banners)->bottom_script_url )
                  <script src="{{ optional($admin_advertistment_banners)->bottom_script_url }}"></script>
               @endif
               
            @endif

         </div>
      </div>
      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>

<?php
   include(public_path('themes/theme4/views/partials/home/home_pop_up.php'));
   include(public_path('themes/theme4/views/footer.blade.php')) ;
?> 

<style>

   .info_model.modal-dialog{
      width:auto;
      max-width:1000px !important;
   }

   .modal-dialog-centered .modal-content{
      background:transparent;
   }

   .modal-dialog-centered .col-lg-6{
      width:100%;
      overflow: hidden;
   }

   .model_close-button{
      border: 2px solid;
      width: 30px;
      height: 30px;
      font-size: 27px;
   }

   .model_close-button:hover{
      background:white;
      color:black;

   }

   .drp-close.model_close-button:hover {
      transform: none;
   }

   .modal-body.trending-dec {
      margin-top:4%;
      line-height: 1.5;
      font-size: calc(14px + 0.5vmin);
   }
   .sidenav {
       height: 100%; 
      width: 37px;
      position: fixed;
      z-index: 99;
      left: 0;
   }
   .rightnav {
       height: 100%; 
      width: 37px;
      position: fixed;
      z-index: 1;
      right: 0;
   }

   .main {
     position:relative;
   }
   .bottom-nav {
      position: fixed;
      bottom: 0;
      z-index: 99;
   }

   @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
   }
</style>
<script>
   window.onload = function() {
      // Show sidenav, rightnav, and main initially
      document.querySelector('.sidenav').style.display = 'block';
      document.querySelector('.rightnav').style.display = 'block';
      // document.querySelector('.main').style.marginLeft = '37px';
      // document.querySelector('.main').style.marginRight = '37px';

      // Hide sidenav, rightnav, and main after 5 seconds
      setTimeout(function() {
         document.querySelector('.sidenav').style.display = 'none';
         document.querySelector('.rightnav').style.display = 'none';
         document.querySelector('.header_top_position_img').style.display = 'none';
         document.querySelector('.bottom-nav').style.display = 'none';
         document.querySelector('.main').style.marginLeft = '0px';
         document.querySelector('.main').style.marginRight = '0px';
      }, 5000);
   };
</script>


