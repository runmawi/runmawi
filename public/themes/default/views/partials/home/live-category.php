
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col-sm-12 ">
            
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/live/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if(!empty($category->home_genre)){ echo __('Live').' '.__($category->home_genre) ; }else{ echo __('Live').' '.__($category->name) ; }  
                        //   echo __($category->name);
                          ?>
                    </h4>
                </a>
            </div>

            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>

                    <?php  if(isset($live_streams)) :
                       foreach($live_streams as $livestream):
                        if (!empty($livestream->publish_time))
                        {
                          $currentdate = date("M d , y H:i:s");
                          date_default_timezone_set('Asia/Kolkata');
                          $current_date = Date("M d , y H:i:s");
                          $date = date_create($current_date);
                          $currentdate = date_format($date, "D h:i");
                          $publish_time = date("D h:i", strtotime($livestream->publish_time));
                          if ($livestream->publish_type == 'publish_later')
                          {
                              if ($currentdate < $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->publish_time));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';
                              }
                          }
                          elseif ($livestream->publish_type == 'publish_now')
                          {
                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($livestream->created_at));

                              if ($currentdate == $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->created_at));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
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

                            $publish_time = date("y M D", strtotime($livestream->created_at));

                              if ($currentdate == $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->created_at));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';
                              }
                          }
                           ?>
                        <li class="slide-item">
                            <div class="block-images position-relative">
                           
                                       <!-- block-images -->
                            <div class="border-bg">
                                    <div class="img-box">
                                    <a class="playTrailer" href="<?php echo URL::to('live') ?><?= '/' . $livestream->slug ?>">   
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream->image;  ?>" class="img-fluid w-100" alt="live-c">
                                    </a>

                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                            <p class="p-tag1">
                                                <?php if($livestream->access == 'subscriber' ){ ?>
                                                    <i class="fas fa-crown" style='color:gold'></i> 
                                                    <?php }elseif($livestream->access == 'registered'){?>
                                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                                    <?php } elseif(!empty($livestream->ppv_price)) {
                                                    echo $currency->symbol.' '.$livestream->ppv_price ; 
                                                    } elseif(!empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo $currency->symbol .' '.$livestream->global_ppv;
                                                    } elseif(empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo "Free"; 
                                                    }
                                                ?>
                                            </p>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->published_on == 1) { ?>                                            
                                            <p class="published_on1"><?php echo $publish_day; ?> <span><?php echo $publish_time; ?></span></p>
                                        <?php  } ?>
                                    </div>
                                    </div>

                                    <div class="block-description">
                                      <a class="playTrailer" href="<?php echo URL::to('live') ?><?= '/' . $livestream->slug ?>">   
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream->player_image;  ?>" class="img-fluid w-100" alt="live-c">
                                    

                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                            <p class="p-tag1">
                                                <?php if($livestream->access == 'subscriber' ){ ?>
                                                    <i class="fas fa-crown" style='color:gold'></i> 
                                                    <?php }elseif($livestream->access == 'registered'){?>
                                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                                    <?php } elseif(!empty($livestream->ppv_price)) {
                                                    echo $currency->symbol.' '.$livestream->ppv_price ; 
                                                    } elseif(!empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo $currency->symbol .' '.$livestream->global_ppv;
                                                    } elseif(empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo "Free"; 
                                                    }
                                                ?>
                                            </p>
                                        <?php } ?>
                                        </a>
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                            <p class="p-tag1">
                                                <?php if($livestream->access == 'subscriber' ){ ?>
                                                    <i class="fas fa-crown" style='color:gold'></i> 
                                                    <?php }elseif($livestream->access == 'registered'){?>
                                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                                    <?php } elseif(!empty($livestream->ppv_price)) {
                                                    echo $currency->symbol.' '.$livestream->ppv_price ; 
                                                    } elseif(!empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo $currency->symbol .' '.$livestream->global_ppv;
                                                    } elseif(empty($livestream->global_ppv) && $livestream->ppv_price == null) {
                                                        echo "Free"; 
                                                    }
                                                ?>
                                            </p>
                                        <?php } ?>

                                    <div class="hover-buttons text-white">
                                    <a href="<?php echo URL::to('live') ?><?= '/' . $livestream->slug ?>"> 
                                            <?php if($ThumbnailSetting->title == 1) { ?>  
                                                          <!-- Title -->
                                                          <p class="epi-name text-left m-0">
                                                        <?php  echo (strlen($livestream->title) > 17) ? substr($livestream->title,0,18).'...' : $livestream->title; ?>
                                            </p>
                                            <?php } ?>  

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>  <!-- Age -->
                                                <!-- <div class="badge badge-secondary p-1 mr-2"><?php //echo $livestream->status.' '.'+' ?></div> -->
                                            <?php } ?>

                                        <?php if($ThumbnailSetting->duration == 1) { ?>  <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $livestream->duration); ?>
                                            </span>
                                        <?php } ?>
                                        </div>
                                    
                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?>    <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($livestream->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->published_year == 1) { ?>  <!-- published_year -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($livestream->year); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 && $livestream->featured == 1) { ?>  <!-- Featured -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">  <!-- Category Thumbnail  setting -->
                                        <?php
                                            $CategoryThumbnail_setting =  App\CategoryLive::join('live_categories','live_categories.id','=','livecategories.category_id')
                                                        ->where('livecategories.live_id',$livestream->id)
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

                                        
                                            <a class="epi-name mt-3 mb-0 btn" type="button" class="text-white d-flex align-items-center"
                                                href="<?php echo URL::to('/') ?><?= '/live'.'/' . $livestream->slug ?>">
                                                <img class="d-inline-block ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%" alt="ply" /> Watch Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </li>
                    <?php   endforeach;  endif; ?>


            </div>
        </div>
    </div>
</div>
