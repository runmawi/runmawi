<?php if(count($audios) > 0) : ?>

      <div class="iq-main-header d-flex align-items-center justify-content-between">

      <?php if( Route::currentRouteName() == "ChannelHome"){?>

         <h5 class="main-title"><a href="<?php echo route('Channel_Audios_list',Request::segment(2)); ?>">
            <?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>
            </a>
         </h5>             
         
         <a class="see" href="<?php echo route('Channel_Audios_list',Request::segment(2)); ?>">See All </a>

      <?php }else{ ?>

         <h5 class="main-title"><a href="<?php if ($order_settings_list[5]->header_name) { echo URL::to('/').'/'.$order_settings_list[5]->url ;} else { echo "" ; } ?>">
            <?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>
            </a>
         </h5>             
         
         <a class="see" href="<?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>">See All </a>

      <?php } ?>

      </div>
      <div class="favorites-contens"> 
         <div class="latest-audios home-sec list-inline row p-0 mb-0">
                         <?php  if(isset($audios)) :
                         foreach($audios as $audio): ?>
                       <div class="items">
                          <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid flickity-lazyloaded" alt="<?php echo $audio->title; ?>">
                                </div> </div>
                                <div class="block-description" > </div>
                                           
                                   <div class="hover-buttons">
                                   <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>" alt="<?php echo $audio->title; ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>
               <!-- <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>-->
                                   </div>
                                
                                   
                              
                            
                          </a>
                       </div>

                        <?php endforeach; 
                                   endif; ?>
                    </div>
                 </div>

                 <?php       endif; ?>
      

<script>
    var elem = document.querySelector('.latest-audios');
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