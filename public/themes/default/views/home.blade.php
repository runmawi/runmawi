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
                      'button_text'   => $button_text,
                   ];

   $Slider_array_data = array(
         'sliders'               => $sliders,
         'live_banner'           => $live_banner,
         'video_banners'         => $video_banners,
         'series_sliders'        => $series_sliders,
         'live_event_banners'    => $live_event_banners,
         'Episode_sliders'       => $Episode_sliders,
         'VideoCategory_banner'  => $VideoCategory_banner,
         'settings'              => $settings,
   );

   $continue_watching = array(
                              'Video_cnt'    => $VideoJsContinueWatching,
                              'episode_cnt'  => $VideoJsEpisodeContinueWatching,
                           );

@endphp

<!-- Slider Start -->

@php
    if (!empty($video_banners) && count($video_banners) > 0) {
        $lcpImageUrl = asset('public/uploads/images/' . $video_banners[0]->player_image);
        echo '<link rel="preload" as="image" href="' . $lcpImageUrl . '" type="image/webp">';
    }
@endphp
<section id="home" class="iq-main-slider m-0 p-0">

    <!-- Skeleton Loader -->
    <div id="slider-loader" class="slider-skeleton">
         <div class="skeleton-box"></div>
   </div>


   <div id="home-slider" class="home-sliders slider m-0 p-0" style="opacity: 0; visibility: hidden;">
       {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/{$slider_choosen}", $Slider_array_data )->content() !!}
   </div>
</section>

<!-- MainContent -->

<div class="main-content" id="home_sections" next-page-url="{{ $order_settings->nextPageUrl() }} ">

         {{-- continue watching videos --}}
      @if( !Auth::guest() &&  $home_settings->continue_watching == 1 )
         {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/continue-watching", array_merge($homepage_array_data, $continue_watching) )->content() !!}
      @endif

      @partial('home_sections')
</div>
   <!-- Loader -->
   <div id="loader" class="auto-load text-center d-flex align-items-center justify-content-center hidden-loader pt-5">
      <div class="ring-spinner">Loading
         <span></span>
       </div>
   </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
   var lazyloadImages = document.querySelectorAll("img.lazy");
   var lazyloadThrottleTimeout;

   function lazyload() {
      if (lazyloadThrottleTimeout) {
         clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function() {
         var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
         lazyloadImages.forEach(function(img) {
               if (img.offsetTop < (document.documentElement.clientHeight + scrollTop)) {
                  img.src = img.dataset.src;
                  img.classList.remove('lazy');
               }
         });
         if (lazyloadImages.length == 0) {
               document.removeEventListener("scroll", lazyload);
               document.body.removeEventListener("resize", lazyload);
               globalThis.matchMedia("(orientation: portrait)").removeListener(lazyload);
         }
      }, 20);
   }

   document.addEventListener("scroll", lazyload);
   document.body.addEventListener("resize", lazyload);
   globalThis.matchMedia("(orientation: portrait)").addListener(lazyload);
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
         description.style.maxHeight = '100px';
         var width = globalThis.innerWidth || document.documentElement.clientWidth;
         if (width <= 500) {
            description.style.maxHeight = '65px';
         }
      } else {
        readMoreBtn.style.display = 'none';
        readLessBtn.style.display = 'inline';
        description.style.maxHeight = 'none';
      }
   }

   // series slider read more option
   function detailsReadMore(key) {
      const description = document.getElementById('details-' + key);
      const readMoreBtn = document.getElementById('read-more-details-' + key);
      const readLessBtn = document.getElementById('read-less-details-' + key);

      if (readMoreBtn.style.display === 'none') {
         readMoreBtn.style.display = 'inline';
         readLessBtn.style.display = 'none';
         description.style.maxHeight = '100px';
      } else {
         readMoreBtn.style.display = 'none';
         readLessBtn.style.display = 'inline';
         description.style.maxHeight = 'none';
      }
   }

   // episode slider read more option
   function episodeReadMore(key) {
      const description = document.getElementById('epidetails-' + key);
      const readMoreBtn = document.getElementById('read-more-episode-' + key);
      const readLessBtn = document.getElementById('read-less-episode-' + key);

      if (readMoreBtn.style.display === 'none') {
         readMoreBtn.style.display = 'inline';
         readLessBtn.style.display = 'none';
         description.style.maxHeight = '100px';
      } else {
         readMoreBtn.style.display = 'none';
         readLessBtn.style.display = 'inline';
         description.style.maxHeight = 'none';
      }
   }

   // live slider read more option
   function liveReadMore(key) {
      const description = document.getElementById('live-details-' + key);
      const readMoreBtn = document.getElementById('read-more-live-' + key);
      const readLessBtn = document.getElementById('read-less-live-' + key);

      if (readMoreBtn.style.display === 'none') {
         readMoreBtn.style.display = 'inline';
         readLessBtn.style.display = 'none';
         description.style.maxHeight = '100px';
      } else {
         readMoreBtn.style.display = 'none';
         readLessBtn.style.display = 'inline';
         description.style.maxHeight = 'none';
      }
   }

   // var isFetching = false;
   // var scrollFetch;

   // $(document).scroll(function () {
   //    clearTimeout(scrollFetch);

   //    scrollFetch = setTimeout(function () {
   //       var page_url = $("#home_sections").attr('next-page-url');
   //       console.log("scrolled");
   //       <?php if( ($order_settings->total()) != ($order_settings->perPage()) ){?>
   //          if (page_url != null && !isFetching) {
   //             isFetching = true;
   //             $.ajax({
   //                url: page_url,
   //                success: function (data) {
   //                      $("#home_sections").append(data.view);
   //                      $("#home_sections").attr('next-page-url', data.url);
   //                },
   //             });
   //          }
   //       <?php } ?>
   //    }, 100);
   // });
</script>

<style>
   .myvideos{position: absolute;opacity: 1; }
   .s-bg-1.is-selected:hover .myvideos{display: block;}
   .s-bg-1:hover .video-js{display: block;width: 100%;height: 100%;}
   .myvideos{display: none;}
   .s-bg-1 .video-js{display: none;}
   .des-more-less-btns{border: none;
                     background: transparent;
                     cursor: pointer;
                     margin-bottom: 10px;}
   .video_title_images{width: 50%;}
   @media (min-width:2400px){
      .descp{max-height: 320px !important;}
   }
   .hidden-loader {display: none !important;}

   .button-groups:before{
      margin-bottom: 0;
      margin-right: 0;
   }

   .ring-spinner
   {
      /* position:absolute;
      top:50%;
      left:50%; */
      transform:translate(-50%,-50%);
      width:70px;
      height:70px;
      background:transparent;
      border:3px solid #3c3c3c;
      border-radius:50%;
      text-align:center;
      line-height:70px;
      font-family:sans-serif;
      font-size:10px;
      color:#ffff;
      letter-spacing:1.5px;
      text-transform:uppercase;
      text-shadow:0 0 10px #e8080b;
      box-shadow:0 0 20px rgba(0,0,0,.5);
   }
   .ring-spinner:before
   {
   content:'';
   position:absolute;
   top:-3px;
   left:-3px;
   width:110%;
   height:110%;
   border:3px solid transparent;
   border-top:3px solid #e8080b;
   border-right:3px solid #e8080b;
   border-radius:50%;
   animation:animateC 2s linear infinite;
   }
   .ring-spinner span
   {
   display:block;
   position:absolute;
   top:calc(50% - 2px);
   left:50%;
   width:50%;
   height:4px;
   background:transparent;
   transform-origin:left;
   animation:animate 2s linear infinite;
   }
   .ring-spinner span:before
   {
   content:'';
   position:absolute;
   width:16px;
   height:16px;
   border-radius:50%;
   background:#e8080b;
   top:-6px;
   right:-8px;
   box-shadow:0 0 20px #e8080b;
   }
   @keyframes animateC
   {
   0%
   {
      transform:rotate(0deg);
   }
   100%
   {
      transform:rotate(360deg);
   }
   }
   @keyframes animate
   {
   0%
   {
      transform:rotate(45deg);
   }
   100%
   {
      transform:rotate(405deg);
   }
   }

</style>

<!-- flickity -->
{{-- <link rel="preload" href="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js" as="script"> --}}
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js" defer></script>
<!-- Trailer -->
@php
include(public_path('themes/default/views/partials/home/Trailer-script.php'));
include(public_path('themes/default/views/partials/home/home_pop_up.php'));
include(public_path('themes/default/views/footer.blade.php'))
@endphp

<!-- End Of MainContent -->



<style>
body{
overflow-x:hidden;
overflow-y:scroll;
}

.home-sliders {
    width: 100%; 
    height: auto; 
}

.home-sliders .flickity-viewport {
    width: 100%;
    height: auto; 
}

.home-sliders .flickity-slider {
    display: flex;
}

.home-sliders .slide {
    width: 100%; 
    height: auto;
}

.home-sliders img {
    width: 100%; 
    height: auto;
    object-fit: contain;
}


</style>

<script>
       var elem = document.querySelector('.home-sliders');
       var loader = document.getElementById("slider-loader");

       imagesLoaded(elem, function () {
           // Initialize Flickity after images are loaded
           new Flickity(elem, {
               cellAlign: 'left',
               contain: true,
               groupCells: false,
               pageDots: false,
               draggable: true,
               freeScroll: true,
               imagesLoaded: true,
               lazyLoad: 2,
               autoPlay: 5000,
           });

           // Hide the skeleton loader and show the slider
           loader.style.display = "none";
           elem.style.opacity = "1";
           elem.style.visibility = "visible";
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

};

document.addEventListener("DOMContentLoaded", function () {
   

    // Video trailer slider
    $('.myvideos').each(function () {
      const video = $(this).get(0);
      const trailerType = $(this).siblings('.trailer_type').val();
      let hasPlayedOnce = false;

      if (trailerType === 'm3u8' || trailerType === 'm3u8_url') {
         var player = videojs(video.id, {
               autoplay: false,
               muted: true,
               loop: true,
               controlBar: false,
         });

         player.pause();

         $(this).hover(
            function () {
                if (!hasPlayedOnce) {
                    player.currentTime(0);
                    hasPlayedOnce = true;
                }
                player.play();
                $('._meta_desc_data_').css('pointer-events','none');
            },
            function () {
                player.pause();
            }
        );

         $(this).closest('.s-bg-1').find('.volume-icon').on('click', function () {
               if (player.muted()) {
                  player.muted(false);
                  $(this).removeClass('fa-volume-off').addClass('fa-volume-up');
               } else {
                  player.muted(true);
                  $(this).removeClass('fa-volume-up').addClass('fa-volume-off');
               }
         });

      } else {
         $(this).hover(
               function () {
                  video.play();
                  $('._meta_desc_data_').css('pointer-events','none');
               },
               function () {
                  video.pause();
               }
         );

         $(this).closest('.s-bg-1').find('.volume-icon').on('click', function () {
               if (video.muted) {
                  video.muted = false;
                  $(this).removeClass('fa-volume-off').addClass('fa-volume-up');
               } else {
                  video.muted = true;
                  $(this).removeClass('fa-volume-up').addClass('fa-volume-off');
               }
         });
      }
   });

   let isFetching = false; 
   let scrollFetch;

   $(window).scroll(function () {
      clearTimeout(scrollFetch);

      scrollFetch = setTimeout(function () {
         let page_url = $("#home_sections").attr('next-page-url');

         if (page_url != null && !isFetching) {
            isFetching = true;
            $("#loader").removeClass("hidden-loader");
            console.log("second loader...");
            

            $.ajax({
               url: page_url,
               success: function (data) {
                  if (data.view) {
                     // Append the data from the second script
                     $("#home_sections").append(data.view);
                     $("#home_sections").attr('next-page-url', data.url);
                  } else {
                     // If no more pages, remove the URL to stop further requests
                     $("#home_sections").removeAttr('next-page-url');
                  }
               },
               complete: function () {
                  isFetching = false; // Allow second script to trigger again
                  if ($("#home_sections").attr('next-page-url') == null) {
                     $("#loader").addClass("hidden-loader");
                  }
               }
            });
         }
      }, 10);
   });
   
   //  width and height set dynamically
   var images = document.querySelectorAll('.flickity-lazyloaded');
   images.forEach(function(image) {
      var renderedWidth = image.clientWidth;
      var renderedHeight = image.clientHeight;

      image.setAttribute('width', renderedWidth);
      image.setAttribute('height', renderedHeight);
   });
});

</script>

<style>

   .volume-icon-container {display:none;}
   .s-bg-1:hover .volume-icon-container {
      position: absolute;
      top: 15px;
      left: 15px;
      z-index: 10;
      pointer-events: none;
      display: block;
   }

   .volume-icon {
      pointer-events: auto;
      font-size: 24px;
      color: white;
      cursor: pointer;
      padding: 5px;
      border-radius: 50%;
      transition: color 0.3s;
   }

   .volume-icon:hover {
      color: #ffcc00;
   }


</style>

<style>
  .slider-skeleton {
    width: 100vw;  
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #f0f0f0;
    z-index: 1000; 
}

.skeleton-box {
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite linear;
}

@keyframes loading {
    0% { background-position: 100% 0; }
    100% { background-position: -100% 0; }
}

.home-sliders {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease-in-out;
}

</style>
