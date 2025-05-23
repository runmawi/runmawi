<?php   
if(count($latest_video) > 0) : ?>
<?php if (!Auth::guest() && !empty($data['password_hash'])) {
    $id = Auth::user()->id;
} else {
    $id = 0;
} ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h5 class="main-title"><a href="<?php if ($order_settings_list[11]->header_name) {
        echo URL::to('/') . '/' . $order_settings_list[11]->url;
    } else {
        echo '';
    } ?>">
            <?php if ($order_settings_list[11]->header_name) {
                echo $order_settings_list[11]->header_name;
            } else {
                echo '';
            } ?>
        </a></h5>
        <a class="see" href="<?php echo !empty($order_settings_list[11]->header_name) ? URL::to('/') . '/' . $order_settings_list[11]->url : ""; ?>"> See All </a>
</div>
<div class="favorites-contens"> 
    <div class="video-category home-sec list-inline row p-0 mb-0">
        <?php  
                        $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();
                         if(isset($parentCategories)) :
                         foreach($parentCategories as $Categories): ?>
        <div class="items">
            <a href="<?php echo URL::to('/category/') . '/' . $Categories->slug; ?>" aria-label="videos">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('/category/') . '/' . $Categories->slug; ?>" aria-label="videos">
                            <img src="<?php echo URL::to('/') . '/public/uploads/videocategory/' . $Categories->image; ?>" class="img-fluid loading w-100 h-50"
                            alt="<?php echo $Categories->title; ?>">
                        </a>
                    </div>
                </div>

                <div class="block-description">
                    <a class="text-white d-flex align-items-center" href="<?php echo URL::to('/category/') . '/' . $Categories->slug; ?>" aria-label="VideoCategory">
                        <img class="ply mr-1" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" width="10%" height="10%" />
                    </a>
                </div>

                <a href="<?php echo  URL::to('category/' . $Categories->slug) ?> ">
                    <?php if($ThumbnailSetting->title == 1):  ?>
                            <!-- Title -->
                    <h5 style="font-size:1.0em; font-weight:500;"> <?php echo strlen($Categories->name) > 17 ? substr($Categories->name, 0, 18) . '...' : $Categories->name; ?>
                    </h5>

                    <?php endif; ?>

                    <div class="hover-buttons">

                        <div class="hover-buttons d-flex">

                        </div>

                    </div>
                </a>
            </a>
        </div>
        <?php                     
                        endforeach; 
                                   endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Flickity Slider -->
<script>
    var elem = document.querySelector('.video-category');
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