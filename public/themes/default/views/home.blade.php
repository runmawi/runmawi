<!-- Header Start Test MEssage -->
   @php 
      include (public_path('themes/default/views/header.php'));

      $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
      $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();
   @endphp
<!-- Header End -->

<!-- Slider Start -->

   @php

         $check_Kidmode = 0;

         $video_banner = App\Video::where('banner', 1)->where('active', 1)->where('status', 1)->where('draft', 1);

            if ($getfeching != null && $getfeching->geofencing == 'ON') {
               $video_banner = $video_banner->whereNotIn('videos.id', Block_videos());
            }

            if ($check_Kidmode == 1) {
               $video_banner = $video_banner->whereBetween('videos.age_restrict', [0, 12]);
            }

            if ($videos_expiry_date_status == 1) {
               $video_banner = $video_banner->where(function ($query) {
                  $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now()->format('Y-m-d\TH:i'));
               });
            }

         $video_banner = $video_banner->latest()->limit(15)->get();

                  // Video Category Banner

         $VideoCategory_id = App\VideoCategory::where('in_home',1)->where('banner', 1)->pluck('id')->toArray();

         $VideoCategory_banner = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                    ->whereIn('category_id', $VideoCategory_id)->where('videos.active', 1)->where('videos.status', 1)
                                    ->where('videos.draft', 1)->where('videos.banner', 0);   

                                 if ($getfeching != null && $getfeching->geofencing == 'ON') {
                                    $VideoCategory_banner = $VideoCategory_banner->whereNotIn('videos.id', Block_videos());
                                 }

                                 if ($check_Kidmode == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->whereBetween('videos.age_restrict', [0, 12]);
                                 }

                                 if ($videos_expiry_date_status == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->where(function ($query) {
                                       $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', now()->format('Y-m-d\TH:i'));
                                    });
                                 }

         $VideoCategory_banner = $VideoCategory_banner->latest('videos.created_at')->limit(15)->get();

         $Slider_array_data = array(
            'sliders'            => $sliders, 
            'live_banner'        => $live_banner , 
            'video_banners'      => $video_banner ,
            'series_sliders'     => $series_sliders ,
            'live_event_banners' => App\LiveEventArtist::where('active', 1)->where('status',1)->where('banner', 1)->latest()->limit(15)->get(),
            'Episode_sliders'    => App\Episode::where('active', '1')->where('status', '1')->where('banner', '1')->latest()->limit(15)->get(),
            'VideoCategory_banner' => $VideoCategory_banner ,
         );    

   @endphp

   <section id="home" class="iq-main-slider m-0 p-0">

      <div id="home-slider" class="slider m-0 p-0">
         @if($slider_choosen == 2)
            {!! Theme::uses('default')->load('public/themes/default/views/partials/home/slider-2', $Slider_array_data )->content() !!}
         @else
            {!! Theme::uses('default')->load('public/themes/default/views/partials/home/slider-1', $Slider_array_data )->content() !!}
         @endif
      </div>

   </section>
<!-- Slider End -->

<!-- MainContent -->
      <div class="main-content">
            {{-- continue watching videos --}}

            @if( !Auth::guest() &&  $home_settings->continue_watching == 1 )
               {!! Theme::uses('default')->load('public/themes/default/views/partials/home/continue-watching', [
                  'data' => $cnt_watching, 'order_settings_list' => $order_settings_list ,
                  'multiple_compress_image' => $multiple_compress_image ,'videos_expiry_date_status' => $videos_expiry_date_status ,
                  'default_horizontal_image_url' => $default_horizontal_image_url , 'default_vertical_image_url' => $default_vertical_image_url,
                  'settings' => $settings,'ThumbnailSetting' => $ThumbnailSetting,'currency' => $currency
                  ])->content() !!}
            @endif


            

            @partial('home_sections')
      </div>

<!-- MainContent End -->



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
   
   $('.family_mode').click(function () {
        var family_mode = $(this).data("custom-value");
   
              $.ajax({
              url: "<?php echo URL::to('/FamilyMode');?>",
              type: "get",
              data:{
                 family_mode:family_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   $('.family_mode_off').click(function () {
        var family_mode = $(this).data("custom-value");
   
              $.ajax({
              url: "<?php echo URL::to('/FamilyModeOff');?>",
              type: "get",
              data:{
                 family_mode:family_mode, 
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
   
</script>


<script>
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
</style>

<!-- Trailer -->
<?php
   include(public_path('themes/default/views/partials/home/Trailer-script.php'));
   include(public_path('themes/default/views/partials/home/home_pop_up.php'));
   ?>
   @php 
      include(public_path('themes/default/views/footer.blade.php'))
   @endphp
<!-- End Of MainContent -->

<style>
   body{
      overflow-x:hidden;
      overflow-y:scroll;
   }
</style>

<script>
   $('.mywishlist').click(function(){
        var video_id = $(this).data('videoid');
           if($(this).data('authenticated')){
               $(this).toggleClass('active');
               if($(this).hasClass('active')){
                       $.ajax({
                           url: "<?php echo URL::to('/mywishlist');?>",
                           type: "POST",
                           data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                           dataType: "html",
                           success: function(data) {
                             if(data == "Added To Wishlist"){
                               
                               $('#'+video_id).text('') ;
                               $('#'+video_id).text('Remove From Wishlist');
                               $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                             setTimeout(function() {
                               $('.add_watch').slideUp('fast');
                             }, 3000);
                             }else{
                               
                               $('#'+video_id).text('') ;
                               $('#'+video_id).text('Add To Wishlist');
                               $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                             setTimeout(function() {
                             $('.remove_watch').slideUp('fast');
                             }, 3000);
                             }               
                       }
                   });
               }                
           } else {
             window.location = '<?= URL::to('login') ?>';
         }
     });
   
</script>


<script>
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