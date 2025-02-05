<?php include 'header.php';

   // $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
   $order_settings_list = App\OrderHomeSetting::get();
   $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
   $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();

?>

<!-- Slider Start -->

<section id="home" class="iq-main-slider p-0">
      <div class="overflow-hidden ">
            <div id="home-slider" class="slider m-0 p-0">
                  <?php
                     if ($slider_choosen == 2) {
                        include 'partials/home/slider-2.php';
                     }
                     else {
                        include 'partials/home/slider-1.php';
                     }
                  ?>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
                     fill="none" stroke="currentColor">
                     <circle r="20" cy="22" cx="22" id="test"></circle>
                  </symbol>
            </svg>
      </div>
</section>


<div class="main-content" id="home_sections">

   <?php if( !Auth::guest() && $continue_watching_setting != null &&  $continue_watching_setting == 1 ){ ?>
      <section id="iq-continue overflow-hidden">
         <div class="container-fluid ">
               <div class="row">
                  <div class="col-sm-12 ">
                     <?php include 'partials/home/continue-watching.php'; ?>
                  </div>
               </div>
         </div>
      </section>
   <?php  } ?>

   <?php if($home_settings->shorts_minis == '1' ): ?>
      <?php include 'partials/home/ugc-shorts-minis.blade.php'; ?>
   <?php endif; ?>

   <?php foreach($order_settings as $key => $item): ?>
      <?php if( $item->video_name == 'latest_videos' && $home_settings->latest_videos == '1' ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/latest-videos.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'user_generated_content' && $home_settings->user_generated_content == '1' ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                     <?php include 'partials/home/ugc-videos.blade.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'artist' && $home_settings->artist == 1  ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/artist-videos.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>



    <!-- Preference By Genres -->
      <?php if( $item->video_name == 'live_videos' && $home_settings->live_videos == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/live-videos.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'featured_videos' && $home_settings->featured_videos == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/trending-videoloop.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'videoCategories' && $home_settings->videoCategories == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/videoCategories.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'albums' && $home_settings->albums == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/latest-albums.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'category_videos' && $home_settings->category_videos == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/category-videoloop.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'ContentPartner' && $home_settings->content_partner == 1): ?>
        <?php $ModeratorsUser = App\ModeratorsUser::where('status', 1)->limit(15)->get(); ?>
        <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/ContentPartners.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'latest_viewed_Livestream' && $home_settings->latest_viewed_Livestream == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                     <?php include 'partials/home/latest_viewed_Livestream.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'latest_viewed_Episode' && $home_settings->latest_viewed_Episode == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/latest_viewed_Episode.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1): ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <?php
                  $DataFreeseriesCategories = App\SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->first();
                  $countDataFreeseriesCategories = App\SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->count();
                  if ($countDataFreeseriesCategories > 0 ) {

                        $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                    ->where('category_id','=',@$DataFreeseriesCategories->id)->where('active', '=', '1')
                                    ->where('active', '=', '1');
                        $series = $series->latest('series.created_at')->get();

                  }else{
                     $series = [];
                  }
               ?>
               <div class="row">
                  <div class="col-sm-12">
                     <?php if (count($series) > 0 ) {  include 'partials/home/datafree-series.php'; } ?>
                  </div>
               </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1): ?>
         <section id="iq-favorites">
            <div class="row">

               <?php
                  $parentCategories = App\AudioCategory::all();
                  foreach($parentCategories as $category) {

                     $audios = App\Audio::join('category_audios', 'category_audios.audio_id', '=', 'audio.id')
                                       ->where('category_id','=',$category->id)->where('active', '=', '1')
                                       ->where('active', '=', '1');
                     $audios = $audios->latest('audio.created_at')->get();
                     //  dd($audios);
                     ?>

                     <div class="col-sm-12 ">
                        <?php if (count($audios) > 0) {
                           include('partials/home/audiocategoryloop.php');
                        }
                        else {?>
                           <p class="no_audio"></p>
                        <?php }
                  }?>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'live_category' && $home_settings->live_category == 1): ?>
         <?php if ( GetCategoryLiveStatus() == 1 ) {  ?>
            <div class="">
               <?php

               $Multiuser=Session('subuser_id');
               $Multiprofile= App\Multiprofile::where('id',$Multiuser)->first();

               $parentCategories = App\LiveCategory::orderBy('order','ASC')->groupBy('name')->get();
               foreach($parentCategories as $category) {

                              $live_streams = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                                 ->where('category_id','=',$category->id)->where('live_streams.active', '=', '1')
                                 ->where('live_streams.status', '=', '1');

                              if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                 $live_streams = $live_streams  ->whereNotIn('live_streams.id',Block_videos());
                              }

                              $live_streams = $live_streams->orderBy('live_streams.created_at','desc')->get(); ?>
                              <?php if (count($live_streams) > 0 ) {
                                          include('partials/home/live-category.php');
                              } else { ?>
                                 <p class="no_video">
                                       <!--<?php echo __('No Video Found'); ?>-->
                                 </p>
                              <?php } ?>
                           <?php }?>
            </div>
         <?php }  ?>
      <?php endif; ?>

      <?php if ($item->video_name == 'liveCategories' && $home_settings->liveCategories == 1): ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <?php
                  $DataFreeliveCategories = App\LiveCategory::where('slug','datafree')->first();
                  $countDataFreeliveCategories = App\LiveCategory::where('slug','datafree')->count();
                  if ($countDataFreeliveCategories > 0 ) {

                        $live_streams = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                                    ->where('category_id','=',@$DataFreeliveCategories->id)->where('active', '=', '1')
                                    ->where('status', '=', '1');
                        $live_streams = $live_streams->latest('live_streams.created_at')->get();

                  }else{
                     $live_streams = [];
                  }
               ?>
               <div class="row">
                  <div class="col-sm-12">
                     <?php if (count($live_streams) > 0 ) {  include 'partials/home/datafree-liveVideos.php'; } ?>
                  </div>
               </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'audios' && $home_settings->audios == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                     <?php include 'partials/home/latest-audios.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'series' && $home_settings->series == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                     <?php include 'partials/home/latest-series.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'ChannelPartner' && $home_settings->channel_partner == 1): ?>
         <?php $channels = App\Channel::where('status', 1)->limit(15)->get(); ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/ChannelPartners.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'latest_viewed_Videos' && $home_settings->latest_viewed_Videos == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/latest_viewed_Videos.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'latest_viewed_Audios' && $home_settings->latest_viewed_Audios == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/latest_viewed_Audios.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'Series_Genre' && $home_settings->SeriesGenre == 1): ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <?php
                  $DataFreeseriesCategories = App\SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->first();
                  $countDataFreeseriesCategories = App\SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->count();
                  if ($countDataFreeseriesCategories > 0 ) {

                        $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                    ->where('category_id','=',@$DataFreeseriesCategories->id)->where('active', '=', '1')
                                    ->where('active', '=', '1');
                        $series = $series->latest('series.created_at')->get();

                  }else{
                     $series = [];
                  }
               ?>
               <div class="row">
                  <div class="col-sm-12">
                     <?php if (count($series) > 0 ) {
                        include 'partials/home/datafree-series.php';
                     } ?>
                  </div>
               </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if ($item->video_name == 'Audio_Genre' && $home_settings->AudioGenre == 1): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/AudioGenre.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <?php if( $item->video_name == 'radio_station' && $home_settings->radio_station == 1 ): ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/radio-station.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>


      <?php if (!Auth::guest() && $item->video_name == 'my_play_list' && $home_settings->my_playlist == 1): ?>
         <?php $MyPlaylist = !Auth::guest() ? App\MyPlaylist::where('user_id', Auth::user()->id)->limit(15)->get() : []; ?>
         <section id="iq-continue overflow-hidden">
            <div class="container-fluid ">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <?php include 'partials/home/playlist-videos.php'; ?>
                     </div>
                  </div>
            </div>
         </section>
      <?php endif; ?>

      <!-- <?php if ($item->video_name == 'Today-Top-videos' && $home_settings->Today_Top_videos == 1): ?>
      <?php endif; ?> -->

      <!-- <?php if ($item->video_name == 'watchlater_videos' && $home_settings->watchlater_videos == 1): ?>
      <?php endif; ?> -->

      <!-- <?php if ($item->video_name == 'wishlist_videos' && $home_settings->wishlist_videos == 1): ?>
      <?php endif; ?> -->

      <!-- <?php if ($Series_Networks_Status == 1 && $item->video_name == 'Series_Networks' && $home_settings->Series_Networks == 1): ?>
      <?php endif; ?>

      <?php if ($item->video_name == 'Leaving_soon_videos' && $home_settings->Leaving_soon_videos == 1): ?>
      <?php endif; ?>

      <?php if ($item->video_name == 'series_episode_overview' && $home_settings->series_episode_overview == 1): ?>
      <?php endif; ?>

      <?php if ($Series_Networks_Status == 1 && $item->video_name == 'Series_based_on_Networks' && $home_settings->Series_based_on_Networks == 1): ?>
      <?php endif; ?> -->

      <!-- <?php if ($item->video_name == 'EPG' && $home_settings->epg == 1): ?>
      <?php endif; ?> -->

      <?php if ($item->video_name == 'Recommendation'): ?>
         <!-- Top Videos -->
         <?php if(count($top_most_watched) > 0){ ?>
            <section id="iq-continue overflow-hidden">
               <div class="container-fluid ">
                     <div class="row">
                        <div class="col-sm-12 ">
                           <?php include 'partials/home/Top_videos.blade.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
         <?php } ?>

         <!-- Most Watched Videos User -->
         <?php if(count($most_watch_user) > 0){ ?>
            <section id="iq-continue overflow-hidden">
               <div class="container-fluid ">
                     <div class="row">
                        <div class="col-sm-12 ">
                           <?php include 'partials/home/most_watched_user.blade.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
         <?php } ?>

         <!-- Most Watched Videos Country -->
         <?php if(count($Most_watched_country) > 0){ ?>
            <section id="iq-continue overflow-hidden">
               <div class="container-fluid ">
                     <div class="row">
                        <div class="col-sm-12 ">
                           <?php include 'partials/home/most_watched_country.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
         <?php } ?>

         <!-- Preference By Genres -->
         <?php if(($preference_genres) != null && count($preference_genres) > 0){ ?>
            <section id="iq-continue overflow-hidden">
               <div class="container-fluid ">
                     <div class="row">
                        <div class="col-sm-12 ">
                           <?php include 'partials/home/preference_genres.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
         <?php } ?>

         <!-- Preference By Language -->
         <?php if(($preference_Language) != null && count($preference_Language) > 0){ ?>
            <section id="iq-continue overflow-hidden">
               <div class="container-fluid ">
                     <div class="row">
                        <div class="col-sm-12 ">
                           <?php include 'partials/home/preference_Language.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
         <?php } ?>

      <?php endif; ?>

   <?php endforeach; ?>

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
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function(img) {
                    if (img.offsetTop < (window.innerHeight + scrollTop)) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if (lazyloadImages.length == 0) {
                  //   document.removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }

      //   document.addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
    });

    //  family & Kids Mode Restriction

    $(document).ready(function() {
        $('.kids_mode').click(function() {
            var kids_mode = $(this).data("custom-value");
            $.ajax({
                url: "<?php echo URL::to('/kidsMode'); ?>",
                type: "get",
                data: {
                    kids_mode: kids_mode,
                },
                success: function(response) {
                    location.reload();
                },
            });
        });

        $('.family_mode').click(function() {
            var family_mode = $(this).data("custom-value");

            $.ajax({
                url: "<?php echo URL::to('/FamilyMode'); ?>",
                type: "get",
                data: {
                    family_mode: family_mode,
                },
                success: function(response) {
                    location.reload();
                },
            });
        });

        $('.family_mode_off').click(function() {
            var family_mode = $(this).data("custom-value");

            $.ajax({
                url: "<?php echo URL::to('/FamilyModeOff'); ?>",
                type: "get",
                data: {
                    family_mode: family_mode,
                },
                success: function(response) {
                    location.reload();
                },
            });
        });

        $('#kids_mode_off').click(function() {
            var kids_mode = $(this).data("custom-value");
            $.ajax({
                url: "<?php echo URL::to('/kidsModeOff'); ?>",
                type: "get",
                data: {
                    kids_mode: kids_mode,
                },
                success: function(response) {
                    location.reload();
                },
            });
        });

    });

    $(".main-content , .main-header , .container-fluid").click(function() {
        $(".home-search").hide();
    });

</script>


<?php
   include public_path('themes/default/views/partials/home/home_pop_up.php');
   include public_path('themes/theme5-nemisha/views/footer.blade.php')
?>
<!-- End Of MainContent -->
</div>
</div>
