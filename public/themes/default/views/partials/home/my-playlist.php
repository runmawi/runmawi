
<?php 
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $my_play_list_settings_list = App\OrderHomeSetting::where('video_name','my_play_list')->first(); 
      $MyPlaylist = App\MyPlaylist::where('user_id',Auth::user()->id)->get();

      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($my_play_list_settings_list->header_name) { echo URL::to('/').'/'.$my_play_list_settings_list->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($my_play_list_settings_list->header_name) 
      {
        echo __($my_play_list_settings_list->header_name) ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h4>  
  <h4 class="main-title"><a href="<?php if ($my_play_list_settings_list->header_name) { echo URL::to('/').'/'.$my_play_list_settings_list->url ;} else { echo "" ; } ?>"><?php echo (__('View All')); ?></a></h4>
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($MyPlaylist)) :
      foreach($MyPlaylist as $My_Playlist): ?>
        <li class="slide-item">
          <div class="block-images position-relative">
             <!-- block-images -->
             <div class="border-bg">
                <div class="img-box">
                    <a class="playTrailer" href="<?php echo URL::to('/playlist'.'/'.$My_Playlist->slug  ) ?>">
                    <img class="img-fluid w-100" loading="lazy" src="<?php echo @$My_Playlist->image;  ?>" class="img-fluid w-100" alt="play">
                    </a>
              </div>
              </div>

              <div class="block-description">
              <a class="playTrailer" href="<?php echo URL::to('/playlist'.'/'.$My_Playlist->slug  ) ?>">
                    <img class="img-fluid w-100" loading="lazy" src="<?php echo @$My_Playlist->player_image;  ?>"  alt="playlist">
                    </a>
                    <div class="hover-buttons text-white">
                <a href="<?php echo URL::to('/playlist'.'/'.$My_Playlist->slug  ) ?> ">

                <p class="epi-name text-left m-0"><?php echo $My_Playlist->title; ?></p>
                               <!-- </div> -->
                  </a>

                  <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('/playlist'.'/'.$My_Playlist->slug  ) ?> " >
                    <i class="fa fa-play mr-1" alt="ply" aria-hidden="true"></i>
                   Visit Audio PlayList
                  </a>
                </div>
              </div>
            </div>
        </li>
      <?php endforeach; 
    endif; ?>
  </ul>
</div>
