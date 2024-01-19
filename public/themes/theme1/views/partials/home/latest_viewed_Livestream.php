<?php

   // latest viewed Livestream

   if(Auth::guest() != true ){

    $latest_view_livestream =  App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id',Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->get();
   }
   else
   {
        $latest_view_livestream = array() ;
   }

    if(count($latest_view_livestream) > 0) :  
?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
        <a href="<?php if ($order_settings_list[16]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[16]->url;
        } else {
            echo '';
        } ?>">

            <?php if ($order_settings_list[16]->header_name) {
                echo (__($order_settings_list[16]->header_name));
            } else {
                echo '';
            } ?></a>
    </h4>
</div>


<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_livestream)) :
        
            foreach($latest_view_livestream as $key =>  $latest_view_livestreams): 

                if (!empty($latest_view_livestreams->publish_time) && !empty($latest_view_livestreams->publish_time))
                    {
                        $currentdate = date("M d , y H:i:s");
                        date_default_timezone_set('Asia/Kolkata');
                        $current_date = Date("M d , y H:i:s");
                        $date = date_create($current_date);
                        $currentdate = date_format($date, "D h:i");
                        $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));

                        if ($latest_view_livestreams->publish_type == 'publish_later')
                        {
                            if ($currentdate < $publish_time)
                            {
                              $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));
                            }else{
                              $publish_time = 'Published';
                            }
                        }
                        elseif ($latest_view_livestreams->publish_type == 'publish_now')
                        {
                          $currentdate = date_format($date, "y M D");
  
                          $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));
  
                            if ($currentdate == $publish_time)
                            {
                              $publish_time = 'Today'.' '.date("h:i", strtotime($latest_view_livestreams->publish_time));
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
      
                              $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));
      
                                if ($currentdate == $publish_time)
                                {
                                  $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));
                                }else{
                                  $publish_time = 'Published';
                                }
                            }
                          ?>

        <li class="slide-item">
            <a href="<?php echo URL::to('live/'.$latest_view_livestreams->slug ); ?>">

                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('live/'.$latest_view_livestreams->slug ); ?>">
                            <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_livestreams->image; ?>" class="img-fluid w-100" alt="">
                        </a>
                    </div>
                    <div class="block-description">
                        <div class="hover-buttons">
                            <a class="" href="<?php echo URL::to('live/'.$latest_view_livestreams->slug ); ?>"> <img
                            class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" /> </a>
                            <div class="hover-buttons d-flex">

                            </div>
                        </div>
                    </div>

                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                              <?php if($latest_view_livestreams->access == 'subscriber' ){ ?>
                                  <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                  <?php }elseif(!empty($latest_view_livestreams->ppv_price)){?>
                                <p class="p-tag1"><?php echo $currency->symbol.' '.$latest_view_livestreams->ppv_price; ?></p>
                                <?php }elseif($latest_view_livestreams->ppv_price == null ){ ?>
                                <p class="p-tag"><?php echo __("Free"); ?></p>
                                <?php } ?>
                        <?php } ?>

                        <?php if($ThumbnailSetting->published_on == 1) { ?>
                            <p class="published_on1"><?php echo $publish_time; ?></p>
                        <?php  } ?>
                    
                </div>

                

                <div class="p-0">
                    <div class="mt-2 d-flex justify-content-between p-0">
                        <?php if($ThumbnailSetting->title == 1) { ?>
                            <h6><?php echo strlen($latest_view_livestreams->title) > 17 ? substr($latest_view_livestreams->title, 0, 18) . '...' : $latest_view_livestreams->title; ?></h6>
                        <?php } ?>

                        <?php if($ThumbnailSetting->age == 1) { ?>
                            <div class="badge badge-secondary"><?php echo $latest_view_livestreams->age_restrict . ' ' . '+'; ?></div>
                        <?php } ?>
                    </div>

                    <div class="movie-time my-2">
                        <!-- Duration -->

                        <?php if($ThumbnailSetting->duration == 1) { ?>
                            <span class="text-white">
                                <i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $latest_view_livestreams->duration) ?>
                            </span>
                        <?php } ?>

                        <!-- Rating -->

                        <?php if($ThumbnailSetting->rating == 1 && $latest_view_livestreams->rating != null) { ?>
                            <span class="text-white">
                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                <?php echo __($latest_view_livestreams->rating); ?>
                            </span>
                        <?php } ?>

                        <?php if($ThumbnailSetting->featured == 1 && $latest_view_livestreams->featured == 1) { ?>
                        <!-- Featured -->
                            <span class="text-white">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                        <?php }?>
                    </div>

                    <div class="movie-time my-2">
                        <!-- published_year -->
                        <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $latest_view_livestreams->year != null ) ) { ?>
                            <span class="text-white">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo __($latest_view_livestreams->year); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                     $CategoryThumbnail_setting =  App\LiveCategory::join('livecategories','livecategories.category_id','=','live_categories.id')
                                    ->where('livecategories.live_id',$latest_view_livestreams->id)
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
                    
                    <div class=""></div>
                </div>
            </a>
        </li>
        <?php                     
            endforeach; 
                endif; ?>
    </ul>
</div>

<?php endif; ?>