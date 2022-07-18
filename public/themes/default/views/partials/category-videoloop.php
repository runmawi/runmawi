<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;

    }
    

</style>


<div class="">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if(!empty($category->home_genre)){ echo $category->home_genre ; }else{ echo $category->name ; }  
                        //   echo __($category->name);
                          ?>
                    </h4>
                </a>
            </div>

            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(!empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>

                    <?php  if(isset($videos)) :
                       foreach($videos as $category_video): ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                <div class="block-images position-relative">
                                                                
                                    <div class="img-box">    <!-- block-images -->
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid w-100" alt="">
                                    
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                            <p class="p-tag1">
                                                <?php if(!empty($category_video->ppv_price)) {
                                                    echo $currency->symbol.' '.$category_video->ppv_price ; 
                                                    } elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                        echo $currency->symbol .' '.$category_video->global_ppv;
                                                    } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                        echo "Free"; 
                                                    }
                                                ?>
                                            </p>
                                        <?php } ?>
                                    </div>

                                    <div class="block-description">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                    <h6>
                                                        <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                                    </h6>
                                            <?php } ?>  

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>  <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                            <?php } ?>

                                        <?php if($ThumbnailSetting->duration == 1) { ?>  <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $category_video->duration); ?>
                                            </span>
                                        <?php } ?>
                                        </div>
                                    
                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?>    <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($category_video->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->published_year == 1) { ?>  <!-- published_year -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($category_video->year); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>  <!-- Featured -->
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
                                            $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id',$category_video->video_id)
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

                                        <div class="hover-buttons">
                                            <a type="button" class="text-white d-flex align-items-center"
                                                href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                            </a>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php   endforeach;  endif; ?>


                    <!-- Episode -->

                    <?php  if(isset($Episode_videos)) :
                       foreach($Episode_videos as $key => $Episode_video): ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('episode') ?><?= '/'.$Episode_video->series_name .'/'. $Episode_video->slug ?>">
                                <div class="block-images position-relative">
                                                                
                                    <div class="img-box">    <!-- block-images -->
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Episode_video->image;  ?>" class="img-fluid" alt="">
                                    
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                            <!-- <p class="p-tag1"> -->
                                                <?php 
                                                    // if(!empty($Episode_video->ppv_price)) {
                                                    // echo $currency->symbol.' '.$Episode_video->ppv_price ; 
                                                    // } elseif(!empty($Episode_video->global_ppv) && $Episode_video->ppv_price == null) {
                                                    //     echo $currency->symbol .' '.$Episode_video->global_ppv;
                                                    // } elseif(empty($Episode_video->global_ppv) && $Episode_video->ppv_price == null) {
                                                    //     echo "Free"; 
                                                    // }
                                                ?>
                                            <!-- </p> -->
                                        <?php } ?>
                                    </div>

                                    <div class="block-description">
                                        <a href="<?php  echo URL::to('episode') ?><?= '/'.$Episode_video->series_name .'/'. $Episode_video->slug ?>">
                                            <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                    <h6>
                                                        <?php  echo (strlen($Episode_video->title) > 17) ? substr($Episode_video->title,0,18).'...' : $Episode_video->title; ?>
                                                    </h6>
                                            <?php } ?>  

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>  <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $Episode_video->age_restrict.' '.'+' ?></div>
                                            <?php } ?>

                                        <?php if($ThumbnailSetting->duration == 1) { ?>  <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $Episode_video->duration); ?>
                                            </span>
                                        <?php } ?>
                                        </div>
                                    
                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?>    <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($Episode_video->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 && $Episode_video->featured == 1) { ?>  <!-- Featured -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        <?php } ?>
                                     
                                        <div class="hover-buttons">
                                            <a type="button" class="text-white d-flex align-items-center"
                                                href="<?php echo URL::to('episode') ?><?= '/'.$Episode_video->series_name .'/'. $Episode_video->slug ?>">
                                                <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                            </a>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php   endforeach;  endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

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