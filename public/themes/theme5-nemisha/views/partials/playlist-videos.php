
<?php 
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $my_video_play_list_settings_list = App\OrderHomeSetting::where('video_name','video_play_list')->first(); 
      $AdminVideoPlaylist = App\AdminVideoPlaylist::get();
    // dd($AdminVideoPlaylist);
      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($my_video_play_list_settings_list->header_name) { echo URL::to('/').'/'.$my_video_play_list_settings_list->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($my_video_play_list_settings_list->header_name) 
      {
        echo $my_video_play_list_settings_list->header_name ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h4>  
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($AdminVideoPlaylist)) :
      foreach($AdminVideoPlaylist as $VideoPlaylist): ?>
        <li class="slide-item">
          <a href="<?php echo URL::to('/video-playlist'.'/'.$VideoPlaylist->slug  ) ?>">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
              <img src="<?php  echo URL::to('/').'/public/uploads/images/'.$VideoPlaylist->image;  ?>" class="img-fluid w-100" alt="">

              </div>

              <div class="block-description">
                <a href="<?php echo URL::to('/video-playlist'.'/'.$VideoPlaylist->slug  ) ?> ">

              <h6><?php echo __($VideoPlaylist->name); ?></h6>
                               <!-- </div> -->
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/video-playlist'.'/'.$VideoPlaylist->slug  ) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Visit Video PlayList
                  </a>
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
