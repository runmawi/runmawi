
<?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::get(); 
      $ModeratorsUsers = App\ModeratorsUser::get(); 

      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h5 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_settings_list[14]->header_name) { echo URL::to('/').'/'.$order_settings_list[14]->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($order_settings_list[14]->header_name) 
      {
        echo $order_settings_list[14]->header_name ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h5>  
</div>
<div class="favorites-contens">
  <div class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($ModeratorsUsers)) :
      foreach($ModeratorsUsers as $content_user): ?>
        <div class="slide-item">
          <a href="<?php echo URL::to('/contentpartner'.'/'.$content_user->slug) ?>" aria-label="videos">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/public/uploads/moderator_albums'.'/'.$content_user->picture);  ?>" class="img-fluid w-100 h-50" alt="<?php echo $content_user->username; ?>">                 
              </div> </div>

              <div class="block-description"> </div>
                <a href="<?php echo URL::to('/contentpartner'.'/'.$content_user->slug) ?> " aria-label="ContentPartner">

              <h6><?php echo __($content_user->username); ?></h6>
                               <!-- </div> -->
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/contentpartner'.'/'.$content_user->slug) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Visit Content Partner
                  </a>
                </div>
                     </a>
            
           
          </a>
      </div>
      <?php endforeach; 
    endif; ?>
  </div>
</div>
<?php endif; ?>
