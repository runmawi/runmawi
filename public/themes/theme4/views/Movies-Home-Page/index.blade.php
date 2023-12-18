<?php
       include(public_path('themes/theme4/views/header.php')) ; 

      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
      $order_settings_list = App\OrderHomeSetting::get();  
      $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first(); 

?>


               <!-- Slider  -->

      <section id="home" class="iq-main-slider p-0">
         <div id="home-slider" class="slider m-0 p-0">
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/slider-1', $Slider_array_data )->content() !!}
         </div>
      </section>

               <!-- MainContent -->

      <div class="main-content">
        
                {{-- latest videos --}}
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest-videos', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}

            
                {{-- featured videos --}}
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/trending-videoloop', ['data' => $featured_videos, 'order_settings_list' => $order_settings_list ])->content() !!}

        
                {{-- video Categories --}}
            <?php $parentCategories =   App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get(); ?>
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/videoCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}

    
                {{-- Videos Based on Category  --}}
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/videos-based-categories', ['order_settings_list' => $order_settings_list ])->content() !!}
        
                {{-- Latest Viewed Videos --}}
            {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/latest_viewed_Videos', [ 'order_settings_list' => $order_settings_list ])->content() !!}

      </div>

      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>

<?php
   include(public_path('themes/theme4/views/partials/home/home_pop_up.php'));
   include(public_path('themes/theme4/views/footer.blade.php')) ;
?>
