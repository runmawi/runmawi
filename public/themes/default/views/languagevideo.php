<?php include('header.php'); ?>
<!-- MainContent -->
<section id="iq-favorites">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12 page-height">
            <div class="iq-main-header align-items-center justify-content-between">
               <h4 class="vid-title">
                  <?php echo __('Movies'); ?>
               </h4>
            </div>
            <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                  <?php if (isset($lang_videos)):
                     foreach ($lang_videos as $video): ?>
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->image; ?>"
                                       class="img-fluid w-100" alt="">
                                      
                                       <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                          <?php if (!empty($video->ppv_price)) { ?>
                                             <p class="p-tag1">
                                                <?php echo $currency->symbol . ' ' . $video->ppv_price; ?>
                                             </p>
                                          <?php } elseif (!empty($video->global_ppv || !empty($video->global_ppv) && $video->ppv_price == null)) { ?>
                                             <p class="p-tag1">
                                                <?php echo $video->global_ppv . ' ' . $currency->symbol; ?>
                                             </p>
                                          <?php } elseif ($video->global_ppv == null && $video->ppv_price == null) { ?>
                                             <p class="p-tag">
                                                <?php echo "Free"; ?>
                                             </p>
                                          <?php } ?>
                                       <?php } ?>
                                 </div>
                                 <div class="block-description">
                                    <?php if ($ThumbnailSetting->title == 1) { ?> <!-- Title -->
                                       <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                          <p class="epi-name text-center m-0">
                                             <?php echo (strlen($video->title) > 17) ? substr($video->title, 0, 18) . '...' : $video->title; ?>
                                          </p>
                                       </a>
                                    <?php } ?>
                                    <div class="movie-time d-flex align-items-center pt-1">
                                       <?php if ($ThumbnailSetting->age == 1) { ?>
                                          <!-- Age -->
                                          <div class="badge badge-secondary p-1 mr-2">
                                             <?php echo $video->age_restrict . ' ' . '+' ?>
                                          </div>
                                       <?php } ?>
                                       <?php if ($ThumbnailSetting->duration == 1) { ?>
                                          <!-- Duration -->
                                          <span class="text-white"><i class="fa fa-clock-o"></i>
                                             <?= gmdate('H:i:s', $video->duration); ?>
                                          </span>
                                       <?php } ?>
                                    </div>
                                    <?php if (($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) { ?>
                                       <div class="movie-time d-flex align-items-center pt-1">
                                          <?php if ($ThumbnailSetting->rating == 1) { ?>
                                             <!--Rating  -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                   <?php echo __($video->rating); ?>
                                                </span>
                                             </div>
                                          <?php } ?>
                                          <?php if ($ThumbnailSetting->published_year == 1) { ?>
                                             <!-- published_year -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-calendar" aria-hidden="true"></i>
                                                   <?php echo __($video->year); ?>
                                                </span>
                                             </div>
                                          <?php } ?>
                                          <?php if ($ThumbnailSetting->featured == 1 && $video->featured == 1) { ?>
                                             <!-- Featured -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                </span>
                                             </div>
                                          <?php } ?>
                                       </div>
                                    <?php } ?>
                                    <div class="hover-buttons">
                                    <a class="epi-name mt-3 mb-0 btn text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>" >
                                       <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/>  Watch Now
                                    </a>
                                       <div>
                                          <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                       </div>
                                    </div>
                                    <div>
                                       <button type="button" class="show-details-button" data-toggle="modal"
                                          data-target="#myModal<?= $video->id; ?>">
                                          <span class="text-center thumbarrow-sec">
                                             <!-- <img src="<?php echo URL::to('/') . '/assets/img/arrow-red.png'; ?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                          </span>
                                       </button>
                                    </div>
                                 </div>
                                 <!-- <div class="block-social-info">
                     <ul class="list-inline p-0 m-0 music-play-lists">
                        <li><span><i class="ri-volume-mute-fill"></i></span></li>
                        <li><span><i class="ri-heart-fill"></i></span></li>
                        <li><span><i class="ri-add-line"></i></span></li>
                     </ul>
                     </div>-->
                              </div>
                           </a>
                        </li>
                     <?php endforeach;
                  endif; ?>
               </ul>
            </div>
         </div>
      </div>
   </div>

   <style>
     .block-description {
         display: flex;
         flex-direction: column;
         justify-content: space-around;
      }
   </style>
   <script>
      $('.mywishlist').click(function () {
         var video_id = $(this).data('videoid');
         if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
               $.ajax({
                  url: "<?php echo URL::to('/mywishlist'); ?>",
                  type: "POST",
                  data: { video_id: $(this).data('videoid'), _token: '<?= csrf_token(); ?>' },
                  dataType: "html",
                  success: function (data) {
                     if (data == "Added To Wishlist") {

                        $('#' + video_id).text('');
                        $('#' + video_id).text('Remove From Wishlist');
                        $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                        setTimeout(function () {
                           $('.add_watch').slideUp('fast');
                        }, 3000);
                     } else {

                        $('#' + video_id).text('');
                        $('#' + video_id).text('Add To Wishlist');
                        $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                        setTimeout(function () {
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
      // Prevent closing from click inside dropdown
      $(document).on('click', '.dropdown-menu', function (e) {
         e.stopPropagation();
      });

      // make it as accordion for smaller screens
      if ($(window).width() < 992) {
         $('.dropdown-menu a').click(function (e) {
            e.preventDefault();
            if ($(this).next('.submenu').length) {
               $(this).next('.submenu').toggle();
            }
            $('.dropdown').on('hide.bs.dropdown', function () {
               $(this).find('.submenu').hide();
            }
            )
         }
         );
      }
   </script>
   <!--<script>
   window.onscroll = function() {myFunction()};
   
   var header = document.getElementById("myHeader");
   var sticky = header.offsetTop;
   
   function myFunction() {
   if (window.pageYOffset > sticky) {
   header.classList.add("sticky");
   } else {
   header.classList.remove("sticky");
   }
   }
   </script>-->
   <?php include('footer.blade.php'); ?>