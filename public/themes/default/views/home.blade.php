<!-- Header Start Test MEssage -->
   @php 
      include (public_path('themes/default/views/header.php'));

      $slider_choosen = $home_settings->slider_choosen == 2 ? "slider-2" : "slider-1 ";
      
      $homepage_array_data = [ 
                            'order_settings_list'      => $order_settings_list, 
                            'multiple_compress_image'  => $multiple_compress_image, 
                            'videos_expiry_date_status' => $videos_expiry_date_status,
                            'default_vertical_image_url'   => $default_vertical_image_url,
                            'default_horizontal_image_url' => $default_horizontal_image_url,
                            'ThumbnailSetting' => $ThumbnailSetting,
                            'getfeching' => $getfeching,
                            'currency'   => $currency,
                            'settings'   => $settings,
                         ];
                                 
        $Slider_array_data = array(
            'sliders'               => $sliders, 
            'live_banner'           => $live_banner, 
            'video_banners'         => $video_banners, 
            'series_sliders'        => $series_sliders, 
            'live_event_banners'    => $live_event_banners, 
            'Episode_sliders'       => $Episode_sliders, 
            'VideoCategory_banner'  => $VideoCategory_banner, 
        );   

   @endphp

<!-- Slider Start -->

   <section id="home" class="iq-main-slider m-0 p-0">
      <div id="home-slider" class="slider m-0 p-0">
         {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/{$slider_choosen}", $Slider_array_data )->content() !!}
      </div>
   </section>

<!-- MainContent -->

      <div class="main-content" id="home_sections" next-page-url="{{ $order_settings->nextPageUrl() }} ">

               {{-- continue watching videos --}}
            @if( !Auth::guest() &&  $home_settings->continue_watching == 1 )
               {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/continue-watching", array_merge($homepage_array_data, ['data' => $cnt_watching]) )->content() !!}
            @endif

            @partial('home_sections')
      </div>

<script>
   document.addEventListener("DOMContentLoaded", function() {
   var lazyloadImages = document.querySelectorAll("img.lazy");    
   var lazyloadThrottleTimeout;
   
   function lazyload () {
   if(lazyloadThrottleTimeout) {
     clearTimeout(lazyloadThrottleTimeout);
   }    
   
   lazyloadThrottleTimeout = setTimeout(function() {
       var scrollTop = window.pageYOffset;
       lazyloadImages.forEach(function(img) {
           if(img.offsetTop < (window.innerHeight + scrollTop)) {
             img.src = img.dataset.src;
             img.classList.remove('lazy');
           }
       });
       if(lazyloadImages.length == 0) { 
         document.removeEventListener("scroll", lazyload);
         window.removeEventListener("resize", lazyload);
         window.removeEventListener("orientationChange", lazyload);
       }
   }, 20);
   }
   
   document.addEventListener("scroll", lazyload);
   window.addEventListener("resize", lazyload);
   window.addEventListener("orientationChange", lazyload);
   });
   
   //  family & Kids Mode Restriction   
   
   $( document ).ready(function() {
   $('.kids_mode').click(function () {
     var kids_mode = $(this).data("custom-value");
              $.ajax({
              url: "<?php echo URL::to('/kidsMode');?>",
              type: "get",
              data:{
                 kids_mode:kids_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   $('#kids_mode_off').click(function () {
     var kids_mode = $(this).data("custom-value");
              $.ajax({
              url: "<?php echo URL::to('/kidsModeOff');?>",
              type: "get",
              data:{
                 kids_mode:kids_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   });
   
   $(".main-content , .main-header , .container-fluid").click(function(){
     $(".home-search").hide();
   });
   
   function toggleReadMore(key) {
      const description = document.getElementById('description-' + key);
      const readMoreBtn = document.getElementById('read-more-btn-' + key);
      const readLessBtn = document.getElementById('read-less-btn-' + key);

      if (readMoreBtn.style.display === 'none') {
         readMoreBtn.style.display = 'inline';
         readLessBtn.style.display = 'none';
         description.style.maxHeight = '100px'; // Collapse description, adjust as needed
      } else {
         readMoreBtn.style.display = 'none';
         readLessBtn.style.display = 'inline';
         description.style.maxHeight = 'none'; // Expand description
      }
   }
</script>

<!-- Trailer -->
@php
   include(public_path('themes/default/views/partials/home/Trailer-script.php'));
   include(public_path('themes/default/views/partials/home/home_pop_up.php'));
   include(public_path('themes/default/views/footer.blade.php'))
@endphp

<!-- End Of MainContent -->

<script>
   var isFetching = false; 
   var scrollFetch; 

   $(window).scroll(function () {
      clearTimeout(scrollFetch);

      scrollFetch = setTimeout(function () {
         var page_url = $("#home_sections").attr('next-page-url');
         console.log("scrolled");

         if (page_url != null && !isFetching) {
               isFetching = true; 
               $.ajax({
                  url: page_url,
                  success: function (data) {
                     $("#home_sections").append(data.view);
                     $("#home_sections").attr('next-page-url', data.url);
                     
                     // Reinitialize the slider after appending new content
                     jQuery('.favorites-slider').not('.slick-initialized').slick({
                        dots: false,
                        arrows: true,
                        appendDots: '.slider-dots',
                        infinite: false,
                        slidesToScroll: 5,
                        slidesToShow: 7,
                        accessibility: true,
                        variableWidth: false,
                        focusOnSelect: false,
                        nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next"><i class="ri-arrow-right-s-line"></i></a>',
                        prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous"><i class="ri-arrow-left-s-line"></i></a>',
                        responsive: [
                           {
                              breakpoint: 1200,
                              settings: {
                                 slidesToShow: 5,
                                 slidesToScroll: 1,
                                 infinite: true,
                                 dots: true
                              }
                           },
                           {
                              breakpoint: 768,
                              settings: {
                                 slidesToShow: 2,
                                 slidesToScroll: 1
                              }
                           },
                           {
                              breakpoint: 480,
                              settings: {
                                 slidesToShow: 3,
                                 slidesToScroll: 1
                              }
                           }
                        ]
                     });
                     isFetching = false; // Reset fetching flag
                  },
                  error: function() {
                     isFetching = false; // Reset fetching flag in case of error
                  }
               });
         }
      }, 100);
   });

   var scheduler_content = '<?= Session::get('scheduler_content'); ?>';

   if(scheduler_content == 1){

      $("body").append(
         "<div class='remove_watch' style='z-index: 100; position: fixed; top: 15%; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;'>LiveStream Start's Form <?= Session::get('scheduler_time'); ?></div>"
      );
      setTimeout(function() {
            $('.remove_watch').slideUp('fast');
      }, 3000);

      var scheduler_content = '<?= Session::forget('scheduler_content'); ?>';
      var scheduler_time = '<?= Session::forget('scheduler_time'); ?>';
      
   }
</script>

<style>
   .desc {
       overflow: hidden;
       max-height: 100px; /* Initial max height, adjust as needed */
       transition: max-height 0.5s ease;
   }
   .des-more-less-btns{border: none;
       background: transparent;
       color: #ff0000;
       cursor: pointer;
       margin-bottom: 10px;}
       .video_title_images{width: 50%;}
 
   body{
      overflow-x:hidden;
      overflow-y:scroll;
   }
</style>