<?php  if(count($livetream) > 0) : ?>

<div class="iq-main-header d-flex align-items-center justify-content-between">

  <?php if( Route::currentRouteName() == "ChannelHome"){?>
    
    <h5 class="main-title">
        <a href="<?php echo route('Channel_livevideos_list',Request::segment(2)); ?>">
          <?php if ($order_settings_list[3]->header_name) { echo $order_settings_list[3]->header_name ;} else { echo "" ; } ?></a>
    </h5>

    <a class="see" href="<?php echo route('Channel_livevideos_list',Request::segment(2)); ?>">See All </a>

  <?php }else{ ?>

    <h5 class="main-title">
        <a href="<?php if ($order_settings_list[3]->header_name) { echo URL::to('/').'/'.$order_settings_list[3]->url ;} else { echo "" ; } ?>">
          <?php if ($order_settings_list[3]->header_name) { echo $order_settings_list[3]->header_name ;} else { echo "" ; } ?></a>
    </h5>

    <a class="see" href="<?php if ($order_settings_list[3]->header_name) { echo URL::to('/').'/'.$order_settings_list[3]->url ;} else { echo "" ; } ?>">See All </a>

  <?php } ?>

</div>

<div class="favorites-contens"> 
  <div class="live-video home-sec list-inline row p-0 mb-0">
        <?php  if(isset($livetream)) :
                         foreach($livetream as $video): 
                            if (!empty($video->publish_time))
                            {
                              $currentdate = date("M d , y H:i:s");
                              date_default_timezone_set('Asia/Kolkata');
                              $current_date = Date("M d , y H:i:s");
                              $date = date_create($current_date);
                              $currentdate = date_format($date, "D h:i");
                              $publish_time = date("D h:i", strtotime($video->publish_time));
                              if ($video->publish_type == 'publish_later')
                              {
                                  if ($currentdate < $publish_time)
                                  {
                                    $publish_time = date("D h:i", strtotime($video->publish_time));
                                $publish_time  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('l');

                                  }else{
                                    $publish_time = 'Published';
                                    $publish_day = '';
                                  }
                              }
                              elseif ($video->publish_type == 'publish_now')
                              {
                                $currentdate = date_format($date, "y M D");
  
                                $publish_time = date("y M D", strtotime($video->created_at));
  
                                  if ($currentdate == $publish_time)
                                  {
                                    $publish_time = date("D h:i", strtotime($video->created_at));
                                $publish_time  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('l');

                                  }else{
                                    $publish_time = 'Published';
                                    $publish_day = '';

                                  }
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';

                              }
                            }else{
                              date_default_timezone_set('Asia/Kolkata');
                              $current_date = Date("M d , y H:i:s");
                              $date = date_create($current_date);
                                $currentdate = date_format($date, "y M D");
  
                                $publish_time = date("y M D", strtotime($video->created_at));
  
                                  if ($currentdate == $publish_time)
                                  {
                                    $publish_time = date("D h:i", strtotime($video->created_at));
                                $publish_day  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('l');

                                $publish_time  = Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('h:i');

                                  }else{
                                    $publish_time = 'Published';
                                    $publish_day = '';

                                  }
                              }
                            ?>
        <!-- .@$video->categories->name. -->
        <div class="items">
            <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>" aria-label="videos">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>" aria-label="videos">
                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid w-100 h-50" alt="<?php echo $video->title; ?>" />
                        </a>
                        
                      <!-- PPV price -->
                       
                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                            
                                <?php  if(!empty($video->ppv_price)){?>
                                <p class="p-tag1"><?php echo $currency->symbol.' '.$video->ppv_price; ?></p>
                                <?php }elseif($video->ppv_price == null ){ ?>
                                <p class="p-tag"><?php echo "Free"; ?></p>
                                <?php } ?>
                        
                         <?php } ?>   
                         <?php if($ThumbnailSetting->published_on == 1) { ?>                                            
                          <p class="published_on1"><?php echo $publish_day; ?> <span><?php echo $publish_time; ?></span></p>
                        <?php  } ?>
                            </div>
                        
                </div>
                <div class="block-description"> </div>
               <!--<div class="hover-buttons">
                        <a class="text-white d-flex justify-content-center align-items-center" href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                            <img class="ply mr-2" style="width: 13%; height: 13%;" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                Live Now
                        </a>
                    </div>-->
               
                <div class="">
                  
<div class="d-flex align-items-center justify-content-between">

                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                            <span class="text-white"><?= (strlen($video->title) > 17) ? substr($video->title,0,18).'...' : $video->title; ?></span>
                        </a>
                    <?php } ?>

                     
                    </div>
                    <div class="movie-time my-2">
                        <!-- Duration -->
    
                        <?php if($ThumbnailSetting->duration == 1) { ?>
                        <span class="text-white">
                            <i class="fa fa-clock-o"></i>
                            <?= gmdate('H:i:s', $video->duration); ?>
                        </span>
                        <?php } ?>
    
                        <!-- Rating -->
    
                        <?php if($ThumbnailSetting->rating == 1 && $video->rating != null) { ?>
                        <span class="text-white">
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                            <?php echo __($video->rating); ?>
                        </span>
                        <?php } ?>
    
                        <?php if($ThumbnailSetting->featured == 1 && $video->featured == 1) { ?>
                            <!-- Featured -->
                            <span class="text-white">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                        <?php }?>
                    </div>
    
                    <div class="movie-time my-2">
                        <!-- published_year -->
    
                        <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $video->year != null ) ) { ?>
                        <span class="text-white">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo __($video->year); ?>
                        </span>
                        <?php } ?>
                    </div>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                     $CategoryThumbnail_setting =  App\LiveCategory::join('livecategories','livecategories.category_id','=','live_categories.id')
                                    ->where('livecategories.live_id',$video->id)
                                    ->pluck('live_categories.name');         
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
        </div>
        <?php endforeach; 
      endif; ?>
    </div>
</div>
<?php endif; ?>



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

<style>
  .flickity-prev-next-button{
    top: 28%;
  }
</style>

<!-- Flickity Slider -->
<script>
    var elem = document.querySelector('.live-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
 </script>