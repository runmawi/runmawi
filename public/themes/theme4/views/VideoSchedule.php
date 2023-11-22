<?php 
   include(public_path('themes/theme4/views/header.php'));
   ?>
<!-- MainContent -->
<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">
         <div class="iq-main-header align-items-center justify-content-between">
            <h3 class="vid-title"><?= __('Scheduled Videos') ?></h3>
         </div>
         <div class="favorites-contens">
            <ul class="category-page list-inline row p-0 mb-0">
               <?php if(isset($Video_Schedules)) :
                  foreach($Video_Schedules as $Schedule): ?>
               <li class="slide-item col-sm-2 col-md-2 col-xs-12">
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
                                         <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> <?= __('Watch Now') ?>
                                       </a>
                                       <div class="hover-buttons d-flex">
                                    </div>
                              
                             </div>
                                          </a>
                                 </div>
                              </div>
                              
                          </a>
                       </li>
               <?php endforeach; 
                  endif; ?>
            </ul>
         </div>
      </div>
   </div>
</div>
<?php include(public_path('themes/theme4/views/footer.blade.php'));  ?>