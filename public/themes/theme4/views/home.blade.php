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

?>
   
<div class="main">

   <div class="sidenav">

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

            <!-- Slider -->
   <section id="home" class="iq-main-slider p-0">
      <div id="home-slider" class="slider m-0 p-0">
         {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/slider-1', $Slider_array_data )->content() !!}
      </div>
   </section>

            <!-- MainContent -->
   <div class="main-content" id="home_sections" next-page-url="{{ $order_settings->nextPageUrl() }} ">
                              
                           {{-- continue watching videos --}}
      @if( !Auth::guest() &&  $home_settings->continue_watching == 1 )
         {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/continue-watching', ['data' => $cnt_watching, 'order_settings_list' => $order_settings_list , 'multiple_compress_image' => $multiple_compress_image ,'videos_expiry_date_status' => $videos_expiry_date_status ])->content() !!}
      @endif
      
      @partial('home_sections')

   </div>

   <div class="auto-load text-center" style="display: none" >
      <img src="{{ URL::to('public/Thumbnai_images/Loading_1.gif') }}" width="35px" height="35px">
   </div>

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
      const sidenav = document.querySelector('.sidenav');
      const rightnav = document.querySelector('.rightnav');
      const headerTopImg = document.querySelector('.header_top_position_img');
      const bottomNav = document.querySelector('.bottom-nav');
      const main = document.querySelector('.main');

      // Check if elements exist before modifying styles
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
                  beforeSend: function () {
                     $('.auto-load').show();
                  },
                  success: function (data) {
                     $("#home_sections").append(data.view);
                     $("#home_sections").attr('next-page-url', data.url);
                  },
                  complete: function () {
                     isFetching = false; 
                     $('.auto-load').hide();
                     $('.theme4-slider').hide();
                  }
               });
         }
      }, 2000);
   });

</script>