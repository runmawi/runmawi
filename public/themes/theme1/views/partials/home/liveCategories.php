<?php   
if(count($latest_video) > 0) : ?>
  <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="<?php if ($order_settings_list[12]->header_name) { echo URL::to('/').'/'.$order_settings_list[12]->url ;} else { echo "" ; } ?>">
                    <?php if ($order_settings_list[12]->header_name) { echo $order_settings_list[12]->header_name ;} else { echo "" ; } ?>
                    </a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  
                        $parentCategories = App\LiveCategory::orderBy('order','ASC')->get();
                         if(isset($parentCategories)) :
                         foreach($parentCategories as $Categories): ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('/live/category/').'/'.$Categories->slug ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to('/live/category/').'/'.$Categories->slug ?>">
                                   <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/livecategory/'.$Categories->image;  ?>" class="img-fluid loading w-100" alt="l-img">
                                    </a>  
                                </div>
                                <div class="block-description">
                                    <div class="hover-buttons">
                                       <a class="text-white d-flex align-items-center" href="<?php echo URL::to('/live/category/').'/'.$Categories->slug ?>" >
                                         <img class="ply mr-1" alt="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> 
                                       </a> 
                                    </div>
                                 </div>
                              </div>
                              <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                 <a  href="<?php echo URL::to('/live/category/').'/'.$Categories->slug ?>">
                                    <h6><?php  echo (strlen($Categories->name) > 17) ? substr($Categories->name,0,18).'...' : $Categories->name; ?></h6>
                                 </a>
                              <?php } ?> 
                          </a>
                       </li>
                       <?php                     
                        endforeach; 
                                   endif; ?>
                    </ul>
                 </div>
                 <?php endif; ?>


</script>