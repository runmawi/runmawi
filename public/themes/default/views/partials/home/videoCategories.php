<?php   
if(count($latest_video) > 0) : ?>
  <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="<?php if ($order_settings_list[11]->header_name) { echo URL::to('/').'/'.$order_settings_list[11]->url ;} else { echo "" ; } ?>">
                    <?php if ($order_settings_list[11]->header_name) { echo __($order_settings_list[11]->header_name) ;} else { echo "" ; } ?>
                    </a></h4> 
                    <?php if( $settings->homepage_views_all_button_status == 1 ):?> 
                    <h4 class="main-title"><a href="<?php if ($order_settings_list[11]->header_name) { echo URL::to('/').'/'.$order_settings_list[11]->url ;} else { echo "" ; } ?>"><?php echo (__('View All')); ?></a></h4>  
                    <?php endif; ?>                          
                                     
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  
                        $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();
                         if(isset($parentCategories)) :
                         foreach($parentCategories as $Categories): ?>
                      
                      
                      <li class="slide-item">
                         <div class="block-images position-relative">
                            <!-- block-images -->
                              <div class="border-bg">
                                 <div class="img-box">
                                    <a class="playTrailer" aria-label="<?php echo $Categories->name ?>" href="<?php echo URL::to('/category/').'/'.$Categories->slug ?>">
                                       <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$Categories->image;  ?>"  alt="l-img">
                                    </a>  
                                 </div>
                              </div>


                                <div class="block-description">
                                <a class="playTrailer" aria-label="<?php echo $Categories->name ?>" href="<?php echo URL::to('/category/').'/'.$Categories->slug ?>">
                                   <!-- <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$Categories->player_image;  ?>" class="img-fluid loading w-100" alt="l-img"> -->
                                    </a>

                                    <div class="hover-buttons text-white">
                                     <a aria-label="<?php echo $Categories->name ?>" href="<?php URL::to('/category/').'/'.$Categories->slug ?>">
                                <?php if($ThumbnailSetting->title == 1) { ?>  
                                           <!-- Title -->
                                           <p class="epi-name text-left m-0">
                                             <?php  echo (strlen($Categories->name) > 17) ? substr($Categories->name,0,18).'...' : $Categories->name; ?></p>
                                 
                                <?php } ?>
                                </a> 

                                    
                                  
                                       <a class="epi-name mt-5 mb-0 btn" aria-label="<?php echo $Categories->name ?>" href="<?php echo URL::to('/category/').'/'.$Categories->slug ?>" >
                                         <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
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


</script>