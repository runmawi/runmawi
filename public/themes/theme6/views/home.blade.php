<?php  include(public_path('themes/theme6/views/header.php')) ; ?>
   
<?php
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
      $order_settings_list = App\OrderHomeSetting::get();  
      $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
?>

   <!-- loader Start -->
   {{-- <div id="loading">
      <div id="loading-center">
      </div>
   </div> --}}

      <!-- Slider Start -->
      <section id="home" class="iq-main-slider p-0">
         <div id="home-slider" class="slider m-0 p-0">
            <div class="slide slick-bg s-bg-1">
               <div class="container-fluid position-relative h-100">
                  <div class="slider-inner h-100">
                     <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                           <a href="javascript:void(0);">
                              <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                 <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/logo.png" class="c-logo" alt="streamit">
                              </div>
                           </a>
                           <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                              data-delay-in="0.6">bushland</h1>
                           <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                              <span class="badge badge-secondary p-2">18+</span>
                              <span class="ml-3">2 Seasons</span>
                           </div>
                           <p data-animation-in="fadeInUp" data-delay-in="1.2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                              dummy text ever since the 1500s.
                           </p>
                           <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                              <a href="show-details.html" class="btn btn-hover"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                              <a href="show-details.html" class="btn btn-link">More details</a>
                           </div>
                        </div>
                     </div>
                     <div class="trailor-video">
                        <a href="video/trailer.mp4" class="video-open playbtn">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7"
                              enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                              <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10"
                                 points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                              <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                           </svg>
                           <span class="w-trailor">Watch Trailer</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>

            <div class="slide slick-bg s-bg-2">
               <div class="container-fluid position-relative h-100">
                  <div class="slider-inner h-100">
                     <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                           <a href="javascript:void(0);">
                              <div class="channel-logo" data-animation-in="fadeInLeft">
                                 <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/logo.png" class="c-logo" alt="streamit">
                              </div>
                           </a>
                           <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft">sail coaster</h1>
                           <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="0.5">
                              <span class="badge badge-secondary p-2">16+</span>
                              <span class="ml-3">2h 40m</span>
                           </div>
                           <p data-animation-in="fadeInUp" data-delay-in="0.7">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                              dummy text ever since the 1500s.
                           </p>
                           <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1">
                              <a href="movie-details.html" class="btn btn-hover"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                              <a href="movie-details.html" class="btn btn-link">More details</a>
                           </div>
                        </div>
                     </div>
                     <div class="trailor-video">
                        <a href="video/trailer.mp4" class="video-open playbtn">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7"
                              enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                              <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10"
                                 points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                              <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                           </svg>
                           <span class="w-trailor">Watch Trailer</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
         <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
               fill="none" stroke="currentColor">
               <circle r="20" cy="22" cx="22" id="test"></circle>
            </symbol>
         </svg>
      </section>
      <!-- Slider End -->
      
               <!-- MainContent -->

                                 {{-- Series Full setup --}}
      {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/series_episode_overview', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}


      <div class="main-content">
                                             {{-- continue watching videos --}}
         {{-- @if( !Auth::guest() && !is_null($continue_watching_setting) &&  $continue_watching_setting == 1 )
            {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/continue-watching', ['data' => $cnt_watching, 'order_settings_list' => $order_settings_list ])->content() !!}
         @endif --}}
         
         @forelse ($order_settings as $key => $item) 
         
            @if( $item == 'latest_videos' && $home_settings->latest_videos == 1 )         {{-- latest videos --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/latest-videos', ['data' => $latest_video, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/trending-videoloop', ['data' => $featured_videos, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/live-videos', ['data' => $livetream, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}}
                  <?php $parentCategories =   App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/videoCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}}
                  <?php $parentCategories = App\LiveCategory::orderBy('order','ASC')->get(); ?>
                  {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/liveCategories', ['data' => $parentCategories, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
                  {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/artist-videos', ['data' => $artist, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/latest-albums', ['data' => $albums, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/latest-audios', ['data' => $latest_audios, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'series' && $home_settings->series == 1 )        {{-- series  --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/latest-series', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            @if( $item == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/videos-based-categories', ['data' => $data, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            
            @if( $item == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/livestreams-based-categories', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

            
            @if( $item == 'SeriesGenre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/series-based-categories', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif

                  
            @if( $item == 'AudioGenre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/Audios-based-categories', ['data' => $latest_series, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            

            @if( $item == 'Recommendation')  {{-- Recommendation --}}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/Top_videos', ['data' => $top_most_watched, 'order_settings_list' => $order_settings_list ])->content() !!}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/most_watched_country', ['data' => $Most_watched_country, 'order_settings_list' => $order_settings_list ])->content() !!}
               {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/most_watched_user', ['data' => $most_watch_user, 'order_settings_list' => $order_settings_list ])->content() !!}
            @endif
            
         @empty
             
         @endforelse


     
        

         <section id="parallex" class="parallax-window">
            <div class="container-fluid h-100">
               <div class="row align-items-center justify-content-center h-100 parallaxt-details">
                  <div class="col-lg-4 r-mb-23">
                     <div class="text-left">
                        <a href="javascript:void(0);">
                        <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/parallax/parallax-logo.png" class="img-fluid" alt="bailey">
                        </a>
                        <div class="parallax-ratting d-flex align-items-center mt-3 mb-3">
                           <ul
                              class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                              <li><a href="javascript:void(0);" class="text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star-half-o"
                                 aria-hidden="true"></i></a></li>
                           </ul>
                           <span class="text-white ml-3">9.2 (lmdb)</span>
                        </div>
                        <div class="movie-time d-flex align-items-center mb-3">
                           <div class="badge badge-secondary mr-3">13+</div>
                           <h6 class="text-white">2h 30m</h6>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                        <div class="parallax-buttons">
                           <a href="movie-details.html" class="btn btn-hover">Play Now</a>
                           <a href="movie-details.html" class="btn btn-link">More details</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-8">
                     <div class="parallax-img">
                        <a href="movie-details.html">
                        	<img src="https://localhost/flicknexs/public/themes/theme6/assets/images/parallax/p1.jpg" class="img-fluid w-100" alt="bailey">
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>

      </div>

      <footer class="mb-0">
         <div class="container-fluid">
            <div class="block-space">
               <div class="row">
                  <div class="col-lg-3 col-md-4">
                     <ul class="f-link list-unstyled mb-0">
                        <li><a href="#">About Us</a></li>
                        <li><a href="movie-category.html">Movies</a></li>
                        <li><a href="show-category.html">Tv Shows</a></li>
                        <li><a href="#">Coporate Information</a></li>
                     </ul>
                  </div>
                  <div class="col-lg-3 col-md-4">
                     <ul class="f-link list-unstyled mb-0">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Help</a></li>
                     </ul>
                  </div>
                  <div class="col-lg-3 col-md-4">
                     <ul class="f-link list-unstyled mb-0">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Cotact Us</a></li>
                        <li><a href="#">Legal Notice</a></li>
                     </ul>
                  </div>
                  <div class="col-lg-3 col-md-12 r-mt-15">
                     <div class="d-flex">
                        <a href="#" class="s-icon">
                        <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="s-icon">
                        <i class="ri-skype-fill"></i>
                        </a>
                        <a href="#" class="s-icon">
                        <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="s-icon">
                        <i class="ri-whatsapp-fill"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright py-2">
            <div class="container-fluid">
               <p class="mb-0 text-center font-size-14 text-body">STREAMIT - 2020 All Rights Reserved</p>
            </div>
         </div>
      </footer>
      <!-- MainContent End-->

      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>
      
      <!-- jQuery, Popper JS -->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/jquery-3.4.1.min.js"></script>
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/popper.min.js"></script>

      <!-- Bootstrap JS -->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/bootstrap.min.js"></script>
      
      <!-- Slick JS -->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/slick.min.js"></script>
      
      <!-- owl carousel Js -->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/owl.carousel.min.js"></script>
      
      <!-- select2 Js -->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/select2.min.js"></script>
      
      <!-- Magnific Popup-->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/jquery.magnific-popup.min.js"></script>
      
      <!-- Slick Animation-->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/slick-animation.min.js"></script>
      
      <!-- Custom JS-->
         <script src="https://localhost/flicknexs/public/themes/theme6/assets/js/custom.js"></script>
   </body>
</html>