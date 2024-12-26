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
  
  <div class="scroller-status">
      <div class="infinite-scroll-request">Loading...</div>
      <div class="infinite-scroll-error">No more items to load</div>
      <div class="infinite-scroll-last">You've reached the end!</div>
  </div>
  <div class="pagination">
      <a class="pagination__next" href="#">Next</a>
  </div>

   <div class="auto-load text-center d-flex align-items-center justify-content-center" style="display: none; width:35px; height:35px;margin-right:auto;margin-left:auto;" >

      <!-- <video autoplay loop muted playsinline>
         <source src="{{ URL::to('public/Thumbnai_images/Loading_1.webm') }}" type="video/webm" />
      </video> -->
   </div>

   
   <!-- Loader -->
   <div id="loader" class="auto-load text-center d-flex align-items-center justify-content-center hidden-loader">
      <img src="{{ URL::to('assets/images/Spinner_loader.gif') }}" alt="Loading..." style="width: 50px; height: 50px;">
   </div>

   {{-- End Ads banners --}}
   @if ( optional($admin_advertistment_banners)->bottom_banner_status == 1 )

      @if (optional($admin_advertistment_banners)->bottom_image_url )
         <div class="col-sm-9 mx-auto ">
            <img class="img-fluid logo" alt="ad" src="{{ optional($admin_advertistment_banners)->bottom_image_url }}" /> 
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
   .scroller-status {
      display: none;
   }
   .pagination {
      display: none;
   }
   .s-margin{display:none;}


   @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
   }
   .hidden-loader {
      display: none !important;
   }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        const $sMargins = $('.s-margin');
        let currentIndex = 0;
        const batchSize = 1;
        

        function loadNextDivs() {
            const batchEnd = currentIndex + batchSize;
            $sMargins.slice(currentIndex, batchEnd).css('display', 'block');
            currentIndex = batchEnd;


            if (currentIndex >= $sMargins.length) {
                $(window).off('scroll');
            }
        }

        loadNextDivs();

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
               console.log("page scrolling...");
                loadNextDivs();
            }
        });
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