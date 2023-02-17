<!-- Header -->
<?php 
$currency = App\CurrencySetting::first();

// include('header.php'); 
?><!-- Header End -->
    @php
    include(public_path('themes/default/views/header.php'));
@endphp

<!-- MainContent -->
<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; } ?>

      <div class="main-content">
         <section id="iq-favorites">
            <div class="container">
               <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header align-items-center">
                        <h2 class=""><?php echo __($parentCategories_name);?></h2>
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($live_videos) > 0) {          
                                    foreach($live_videos  as $category_video) { ?>
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt="" width="">
                                                
                                          <?php  if(!empty($category_video->ppv_price)){?>
                                          <p class="p-tag1" ><?php echo $currency->symbol.' '.$category_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$currency->symbol; ?></p>
                                                    <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                                    <?php } ?>
                                               
                                        </div>
                                                <!-- </div> -->

                                            <div class="block-description">
                                                    
                                                <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                    <a  href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                                             <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                                                    </a>
                                                <?php } ?>  
                                                    
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                        <?php if($ThumbnailSetting->age == 1) { ?>
                                                        <!-- Age -->
                                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                                        <?php } ?>
                
                                                        <?php if($ThumbnailSetting->duration == 1) { ?>
                                                        <!-- Duration -->
                                                            <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $category_video->duration); ?></span>
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
                    
                                                        <?php if($ThumbnailSetting->featured == 1 &&  $category_video->featured == 1) { ?>
                                                            <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                              <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                              </span>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="movie-time my-2">
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
                                                    

                                                    <div class="hover-buttons">
                                                        <a  class="text-white"  href="<?= URL::to('/') ?><?= '/live'.'/' . $category_video->slug ?>">
                                                            <span class=""><i class="fa fa-play mr-1" aria-hidden="true"></i>Watch Now</span>
                                                        </a>
                   
    
                                        </div>

                                                </div>

                                            </div>
                                        </a>
                                    </li>
                            
 <?php } } else { ?>
                                   
                                    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                               <p ><h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
                            </div>
      <?php } ?>
                    
                                                              
                           
                        </ul>
                         
                     </div>
                      
                  </div>
               </div>
            </div>
<?php ?>
            
</section>
</div>
    <!-- Modal Starts -->
<!-- MainContent End-->
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp
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