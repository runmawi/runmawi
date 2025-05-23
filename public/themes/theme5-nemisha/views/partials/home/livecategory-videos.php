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




<?php 

$setting= \App\HomeSetting::first();
// dd($live_videos);
$currency = App\CurrencySetting::first();

 ?>
<?php  if(count($live_videos) > 0) : ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading"
                    style="text-decoration:none;color:#fff">
                    <h5 class="movie-title">
                        <?php 
                          echo __($category->name);?>
                    </h5>
                </a>
            </div>
        <div class="favorites-contens"> 
            <div class="live-category-video home-sec list-inline row p-0 mb-0">
                <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                    <?php  if(isset($videos)) :
                       foreach($live_videos as $category_video):
                        
                        ?>
                    <div class="items">
                          <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                            <div class="block-images position-relative">
                            <!-- block-images -->
                          
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"
                                        class="img-fluid w-100 h-50" alt="<?php echo $category_video->title; ?>">
                                        <!-- <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4">
                                            </video> -->
                                  

                            <!-- PPV price -->
                                
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                        <p class="p-tag1">
                                            <?php if(!empty($category_video->ppv_price)) {
                                                   echo $category_video->ppv_price.' '.$currency->symbol ; 
                                                } elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo $category_video->global_ppv .' '.$currency->symbol;
                                                } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo "Free"; 
                                                }
                                            ?>
                                        </p>
                                        <?php } ?>
                                   
                                </div>
                        <div class="block-description"></div>

                                    <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                            <h6>
                                            <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                            </h6>
                                        </a>
                                    <?php } ?>  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                      <?php if($ThumbnailSetting->age == 1) { ?>
                                      <!-- Age -->
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                      <?php } ?>

                                      <?php if($ThumbnailSetting->duration == 1) { ?>
                                      <!-- Duration -->
                                      <span class="text-white">
                                          <i class="fa fa-clock-o"></i>
                                          <?= gmdate('H:i:s', $category_video->duration); ?>
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
                                                    <?php echo __($category_video->rating); ?>
                                                </span>
                                            </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->published_year == 1) { ?>
                                            <!-- published_year -->
                                            <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo __($category_video->year); ?>
                                            </span>
                                            </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
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
                                      $CategoryThumbnail_setting =  App\CategoryLive::join('live_categories','live_categories.id','=','livecategories.category_id')
                                                  ->where('livecategories.live_id',$category_video->id)
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
                    <?php           
                          endforeach; 
                     endif; ?>
                </div>
            </div>
        </div>
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

  var elem = document.querySelector('.live-category-video');
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