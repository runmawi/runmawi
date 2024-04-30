<?php  
    if (!Auth::guest()) {

        $Wishlist = App\Wishlist::where('user_id', Auth::user()->id)->where('type', 'channel')->pluck('video_id');

        $check_Kidmode = 0 ;

        $data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description',
                                        'expiry_date','active','status','draft')

        ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$Wishlist);

        if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
        {
            $data = $data->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $check_Kidmode == 1 )
        {
            $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $data = $data->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  default_vertical_image_url() ;
            $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  default_horizontal_image_url() ;
            $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  default_horizontal_image_url() ;
            $item['source_type']        = "Videos" ;
            return $item;
        });
    }
    else{
        $data = [];
    }
?>

<?php  if(count($data) > 0) : ?>
  
  <div class="iq-main-header d-flex align-items-center justify-content-between">
      <h4 class="main-title">
        <a href="<?php if ($order_settings_list[37]->header_name) { echo URL::to('/').'/'.$order_settings_list[37]->url ;} else { echo "" ; } ?>">
              <?php if ($order_settings_list[37]->header_name) { echo __($order_settings_list[37]->header_name) ;} else { echo "" ; } ?>
          </a>
      </h4>

      <h4 class="main-title">
        <a href="<?php if ($order_settings_list[37]->header_name) { echo URL::to('/').'/'.$order_settings_list[37]->url ;} else { echo "" ; } ?>"><?php echo (__('View All')); ?>
        </a>
      </h4>
  </div>
  <div class="favorites-contens">
      <ul class="favorites-slider list-inline  row p-0 mb-0">
          <?php  if(isset($data)) :
                      foreach($data as $Wishlist_videos): 

                      if (!empty($Wishlist_videos->publish_time) && !empty($Wishlist_videos->publish_time))
                      {
                          $currentdate = date("M d , y H:i:s");
                          date_default_timezone_set('Asia/Kolkata');
                          $current_date = Date("M d , y H:i:s");
                          $date = date_create($current_date);
                          $currentdate = date_format($date, "D h:i");
                          $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                          if ($Wishlist_videos->publish_type == 'publish_later')
                          {
                              if ($currentdate < $publish_time)
                              {
                              $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                              }else{
                              $publish_time = 'Published';
                              }
                          }
                          elseif ($Wishlist_videos->publish_type == 'publish_now')
                          {
                          $currentdate = date_format($date, "y M D");

                          $publish_time = date("y M D", strtotime($Wishlist_videos->publish_time));

                              if ($currentdate == $publish_time)
                              {
                              $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                              }else{
                              $publish_time = 'Published';
                              }
                          }else{
                              $publish_time = 'Published';
                          }
                      }else{
                          date_default_timezone_set('Asia/Kolkata');
                          $current_date = Date("M d , y H:i:s");
                          $date = date_create($current_date);
                              $currentdate = date_format($date, "y M D");

                              $publish_time = date("y M D", strtotime($Wishlist_videos->publish_time));

                              if ($currentdate == $publish_time)
                              {
                                  $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                              }else{
                                  $publish_time = 'Published';
                              }
                      }
                      ?>
                      <li class="slide-item">
                          <div class="block-images position-relative">
                              <!-- block-images -->
                              <div class="border-bg">
                                  <div class="img-box">
                                      <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $Wishlist_videos->slug ?>">
                                          <?php $imageUrl = $Wishlist_videos->image ? URL::to('/').'/public/uploads/images/'.$Wishlist_videos->image : $settings->default_video_image; ?>
                                          <img class="img-fluid w-100" loading="lazy" data-src="<?php echo $imageUrl; ?>"
                                              class="img-fluid w-100" alt="l-img">
                                      </a>

                                      <!-- PPV price -->

                                      <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                      <?php  if($Wishlist_videos->access == 'subscriber' ){ ?>
                                          <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                      <?php }elseif($Wishlist_videos->access == 'registered'){?>
                                          <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                      <?php }elseif(!empty($Wishlist_videos->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$Wishlist_videos->ppv_price; ?></p>
                                      <?php }elseif( !empty($Wishlist_videos->global_ppv || !empty($Wishlist_videos->global_ppv) && $Wishlist_videos->ppv_price == null)){ ?>
                                          <p class="p-tag1"><?php echo $Wishlist_videos->global_ppv.' '.$currency->symbol; ?></p>
                                      <?php }elseif($Wishlist_videos->global_ppv == null && $Wishlist_videos->ppv_price == null ){ ?>
                                          <p class="p-tag"><?php echo (__('Free')); ?></p>
                                      <?php } ?>
                                      <?php } ?>
                                  </div>
                              </div>

                              <div class="block-description">
                                  <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $Wishlist_videos->slug ?>">
                                      
                                      <?php if(!empty($Wishlist_videos->player_image)) { ?>
                                      <img class="img-fluid w-100" loading="lazy"
                                          src="<?php echo URL::to('/') . '/public/uploads/images/' . $Wishlist_videos->player_image; ?>"
                                          alt="playerimage">
                                      <?php } else { ?>
                                      <img class="img-fluid w-100" loading="lazy"
                                          src="<?php echo URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>"
                                          alt="l-img">
                                      <?php } ?>

                                      <!-- PPV price -->

                                      <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                      <?php  if($Wishlist_videos->access == 'subscriber' ){ ?>
                                          <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                      <?php }elseif($Wishlist_videos->access == 'registered'){?>
                                          <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                      <?php }elseif(!empty($Wishlist_videos->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$Wishlist_videos->ppv_price; ?></p>
                                      <?php }elseif( !empty($Wishlist_videos->global_ppv || !empty($Wishlist_videos->global_ppv) && $Wishlist_videos->ppv_price == null)){ ?>
                                          <p class="p-tag1"><?php echo $Wishlist_videos->global_ppv.' '.$currency->symbol; ?></p>
                                      <?php }elseif($Wishlist_videos->global_ppv == null && $Wishlist_videos->ppv_price == null ){ ?>
                                          <p class="p-tag"><?php echo (__('Free')); ?></p>
                                      <?php } ?>
                                      <?php } ?>
                                  </a>

                                  <!-- PPV price -->

                                  <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                  <?php  if($Wishlist_videos->access == 'subscriber' ){ ?>
                                      <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                  <?php }elseif($Wishlist_videos->access == 'registered'){?>
                                      <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                  <?php }elseif(!empty($Wishlist_videos->ppv_price)){?>
                                      <p class="p-tag1"><?php echo $currency->symbol.' '.$Wishlist_videos->ppv_price; ?></p>
                                  <?php }elseif( !empty($Wishlist_videos->global_ppv || !empty($Wishlist_videos->global_ppv) && $Wishlist_videos->ppv_price == null)){ ?>
                                      <p class="p-tag1"><?php echo $Wishlist_videos->global_ppv.' '.$currency->symbol; ?></p>
                                  <?php }elseif($Wishlist_videos->global_ppv == null && $Wishlist_videos->ppv_price == null ){ ?>
                                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                                  <?php } ?>
                                  <?php } ?>

                                  <div class="hover-buttons text-white">
                                  <a href="<?php echo URL::to('category') ?><?= '/videos/' . $Wishlist_videos->slug ?>" aria-label="movie">
                                      <?php if($ThumbnailSetting->title == 1) { ?>

                                          <!-- Title -->

                                          <p class="epi-name text-left m-0">
                                              <?php  echo (strlen($Wishlist_videos->title) > 17) ? substr($Wishlist_videos->title,0,18).'...' : $Wishlist_videos->title; ?>
                                          </p>

                                      <?php } ?>

                                      <div class="movie-time d-flex align-items-center pt-1">
                                          <?php if($ThumbnailSetting->age == 1) { ?>
                                                  <!-- Age -->
                                              <div class="badge badge-secondary p-1 mr-2">
                                                  <?php echo $Wishlist_videos->age_restrict.' '.'+' ?></div>
                                          <?php } ?>

                                          <?php if($ThumbnailSetting->duration == 1) { ?>
                                              <!-- Duration -->
                                              <span class="text-white">
                                                  <i class="fa fa-clock-o"></i>
                                                  <?= gmdate('H:i:s', $Wishlist_videos->duration); ?>
                                              </span>
                                          <?php } ?>
                                      </div>

                                      <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                          <div class="movie-time d-flex align-items-center pt-1">
                                              <?php if($ThumbnailSetting->rating == 1) { ?>
                                              <!--Rating  -->
                                                  <div class="badge badge-secondary p-1 mr-2">
                                                      <span class="text-white">
                                                          <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                          <?php echo __($Wishlist_videos->rating); ?>
                                                      </span>
                                                  </div>
                                              <?php } ?>

                                              <?php if($ThumbnailSetting->published_year == 1) { ?>
                                              <!-- published_year -->
                                                  <div class="badge badge-secondary p-1 mr-2">
                                                      <span class="text-white">
                                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                                          <?php echo __($Wishlist_videos->year); ?>
                                                      </span>
                                                  </div>
                                              <?php } ?>

                                              <?php if($ThumbnailSetting->featured == 1 && $Wishlist_videos->featured == 1) { ?>
                                              <!-- Featured -->
                                                  <div class="badge badge-secondary p-1 mr-2">
                                                      <span class="text-white">
                                                          <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                      </span>
                                                  </div>
                                              <?php }?>
                                          </div>
                                      <?php } ?>

                                      <div class="movie-time d-flex align-items-center pt-1">
                                          <!-- Category Thumbnail  setting -->
                                          <?php
                                              $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                          ->where('categoryvideos.video_id',$Wishlist_videos->id)
                                                          ->pluck('video_categories.name');        
                                              ?>
                                          <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                          <span class="text-white">
                                              <i class="fa fa-list-alt" aria-hidden="true"></i>
                                              <?php
                                                      $Category_Thumbnail = array();
                                                          foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                          $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                          }
                                                      echo implode(','.' ', $Category_Thumbnail);
                                                  ?>
                                          </span>
                                          <?php } ?>
                                      </div>
                                  </a>

                                  <a class="epi-name mt-3 mb-0 btn"
                                      href="<?php echo URL::to('category') ?><?= '/videos/' . $Wishlist_videos->slug ?>">
                                      <img class="d-inline-block ply" alt="ply"
                                          src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" width="10%"
                                          height="10%" /> Watch Now
                                  </a>
                              </div>
                              </div>
                          </div>
                      </li>
                      <?php  
                      endforeach; 
                  endif; ?>
      </ul>
  </div>
<?php endif; ?>

<style>
.i {
  text-decoration: none;
  text-decoration-line: none;
  text-decoration-style: initial;
  text-decoration-color: initial;
  outline-color: initial;
  outline-style: none;
  outline-width: medium;
  outline: medium none;
}
</style>

<script>
  $('.mywishlist').click(function() {
      var video_id = $(this).data('videoid');
      if ($(this).data('authenticated')) {
          $(this).toggleClass('active');
          if ($(this).hasClass('active')) {
              $.ajax({
                  url: "<?php echo URL::to('/mywishlist');?>",
                  type: "POST",
                  data: {
                      video_id: $(this).data('videoid'),
                      _token: '<?= csrf_token(); ?>'
                  },
                  dataType: "html",
                  success: function(data) {
                      if (data == "Added To Wishlist") {

                          $('#' + video_id).text('');
                          $('#' + video_id).text('Remove From Wishlist');
                          $("body").append(
                              '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #37742f; color: white;">Media added to wishlist</div>'
                              );
                          setTimeout(function() {
                              $('.add_watch').slideUp('fast');
                          }, 3000);
                      } else {

                          $('#' + video_id).text('');
                          $('#' + video_id).text('Add To Wishlist');
                          $("body").append(
                              '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>'
                              );
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