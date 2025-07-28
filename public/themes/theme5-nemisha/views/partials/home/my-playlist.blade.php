
<?php 
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $my_play_list_settings_list = App\OrderHomeSetting::where('video_name', 'my_play_list')->first(); 
      $MyPlaylist = Auth::check() ? App\MyPlaylist::where('user_id', Auth::user()->id)->get(): collect();
    // dd($MyPlaylist);
?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <a href="<?php echo !empty($my_play_list_settings_list->header_name) ? URL::to('/').'/'.$my_play_list_settings_list->url : ''; ?>">
      <?php echo !empty($my_play_list_settings_list->header_name) ? $my_play_list_settings_list->header_name : ''; ?>
    </a>
  </h4>  
</div>

<div class="favorites-contens"> 
  <div class="my-playlist home-sec list-inline row p-0 mb-0">
    <?php if (isset($MyPlaylist)) : 
        foreach($MyPlaylist as $VideoPlaylist): ?>
        <div class="items">
          <a href="<?php echo URL::to('/playlist/play/'.$VideoPlaylist->slug  ); ?>">
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo !empty($VideoPlaylist->image) ? URL::to('/').'/public/uploads/images/'.$VideoPlaylist->image : $default_vertical_image_url; ?>" 
                     class="img-fluid w-100 h-50" 
                     alt="<?php echo $VideoPlaylist->name; ?>">
              </div>

              <div class="block-description">
                <a href="<?php echo URL::to('/playlist/play/'.$VideoPlaylist->slug  ); ?>">
                  <h6><?php echo __($VideoPlaylist->name); ?></h6>
                  <div class="hover-buttons d-flex">
                    <a class="text-white" href="<?php echo URL::to('/playlist/play/'.$VideoPlaylist->slug  ); ?>">
                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                      Visit Video PlayList
                    </a>
                  </div>
                </a>
              </div>
            </div>
          </a>
        </div>
    <?php endforeach; 
    endif; ?>
  </div>
</div>

<script>
    var elem = document.querySelector('.my-playlist');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
    });
 </script>