<?php include(public_path('themes/theme4/views/header.php')) ; ?>

         <!-- Slider  -->
<?php 

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

  

   $continue_watching = array(
                              'Video_cnt'    => $VideoJsContinueWatching,
                              'episode_cnt'  => $VideoJsEpisodeContinueWatching,
                           );

?>

<div class="main">

   <div class="sidenav">

      {{-- Top Ads Banners --}}

      @if ( optional($admin_advertistment_banners)->top_banner_status == 1 )
         @if (optional($admin_advertistment_banners)->top_image_url )
            {{-- <div class="col-sm-9 mx-auto ">
               <img class="img-fluid logo" alt="ad" src="{{ optional($admin_advertistment_banners)->top_image_url }}" /> 
            </div> --}}
         @endif

         @if (optional($admin_advertistment_banners)->top_script_url )
               <script src="{{ optional($admin_advertistment_banners)->top_script_url }}"></script>
         @endif
      @endif
   </div>

           

            <!-- MainContent -->
   <div class="main-content" id="home_sections" next-page-url="{{ $order_settings->nextPageUrl() }} ">
                              
                           {{-- continue watching videos --}}
      @if( !Auth::guest() &&  $home_settings->continue_watching == 1 )
         {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/continue-watching', array_merge($continue_watching, [
            'order_settings_list' => $order_settings_list ,
            'multiple_compress_image' => $multiple_compress_image ,'videos_expiry_date_status' => $videos_expiry_date_status ,
            'default_horizontal_image_url' => $default_horizontal_image_url , 'default_vertical_image_url' => $default_vertical_image_url 
             ]))->content() !!}
      @endif
      
      @partial('home_sections')

   </div>

   <div class="auto-load text-center d-flex align-items-center justify-content-center" style="display: none; width:35px; height:35px;margin-right:auto;margin-left:auto;" >

      <!-- <video autoplay loop muted playsinline>
         <source src="{{ URL::to('public/Thumbnai_images/Loading_1.webm') }}" type="video/webm" />
      </video> -->
   </div>

   
   <!-- Loader -->
   <div id="loader" class="auto-load text-center d-flex align-items-center justify-content-center hidden-loader">
      <img src="{{ URL::to('assets/images/Spinner_loader.gif') }}" data-src="{{ URL::to('assets/images/Spinner_loader.gif') }}" alt="Loading..." style="width: 50px; height: 50px;" loading="lazy">
   </div>

   {{-- End Ads banners --}}
   @if ( optional($admin_advertistment_banners)->bottom_banner_status == 1 )

      @if (optional($admin_advertistment_banners)->bottom_image_url )
         <div class="col-sm-9 mx-auto ">
            <img class="img-fluid logo" alt="ad" src="{{ optional($admin_advertistment_banners)->bottom_image_url }}" data-src="{{ optional($admin_advertistment_banners)->bottom_image_url }}" width="857" height="32" loading="lazy" /> 
         </div>
      @endif

      @if (optional($admin_advertistment_banners)->bottom_script_url )
         <script src="{{ optional($admin_advertistment_banners)->bottom_script_url }}"></script>
      @endif
         
   @endif
</div>

<!-- back-to-top -->
<div id="back-to-top">
   <a class="top" href="#top" id="top" aria-label="Back to Top">
      <i class="fa fa-angle-up" aria-hidden="true"></i>
   </a>
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
      z-index: 9;
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
   .hidden-loader {
      display: none !important;
   }
</style>

<script>
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
</script>


<script>
   window.onload = function() {
      const sidenav = document.querySelector('.sidenav');
      const rightnav = document.querySelector('.rightnav');
      const headerTopImg = document.querySelector('.header_top_position_img');
      const bottomNav = document.querySelector('.bottom-nav');
      const main = document.querySelector('.main');

      if (sidenav) {
         sidenav.style.display = 'block';
      }
      if (rightnav) {
         rightnav.style.display = 'block';
      }
      if (headerTopImg) {
         headerTopImg.style.display = 'none';
      }
      if (bottomNav) {
         bottomNav.style.display = 'none';
      }
      if (main) {
         main.style.marginLeft = '0px';
         main.style.marginRight = '0px';
      }
   };

   

   // width and height set dynamically
   document.addEventListener('DOMContentLoaded', function() {
      var images = document.querySelectorAll('.flickity-lazyloaded');
      
      images.forEach(function(image) {
         var renderedWidth = image.clientWidth;
         var renderedHeight = image.clientHeight;

         image.setAttribute('width', renderedWidth);
         image.setAttribute('height', renderedHeight);
      });
   });

</script>