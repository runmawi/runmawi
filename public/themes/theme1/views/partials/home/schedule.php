<?php   
if(count($VideoSchedules) > 0) : ?>
  <?php  if(!empty($data['password_hash'])) { 
$id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
                     <h4 class="main-title"><a href="<?php if ($order_settings_list[10]->header_name) { echo URL::to('/').'/'.$order_settings_list[10]->url ;} else { echo "" ; } ?>">
                    <?php if ($order_settings_list[10]->header_name) { echo __($order_settings_list[10]->header_name) ;} else { echo "" ; } ?></a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($VideoSchedules)) :
                         foreach($VideoSchedules as $Schedule): 
                          ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to("/schedule/videos/embed") ?><?= '/' . $Schedule->name ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to("/schedule/videos/embed") ?><?= '/' . $Schedule->name ?>">
                                   <img loading="lazy" data-src="<?php echo $Schedule->image;  ?>" class="img-fluid loading w-100" alt=""></a>  
                                </div>
                                <div class="block-description">
                                     <a  href="<?php echo URL::to("/schedule/videos/embed") ?><?= '/' . $Schedule->name ?>">
                                <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                     <h6><?php  echo (strlen($Schedule->name) > 17) ? substr($Schedule->name,0,18).'...' : $Schedule->name; ?></h6>
                                 
                                <?php } ?>                                                         
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white d-flex align-items-center" href="<?php echo URL::to("/schedule/videos/embed") ?><?= '/' . $Schedule->name ?>" >
                                         <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> <?= __('Watch Now')  ?>
                                       </a>
                                       <div class="hover-buttons d-flex">
                                    </div>
                              
                             </div>
                                          </a>
                                 </div>
                              </div>
                              
                          </a>
                       </li>
                       <?php                     
                        endforeach; 
                                   endif; ?>
                    </ul>
                 </div>
                 <?php endif; ?>