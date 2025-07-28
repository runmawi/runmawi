<?php if(count($artist) > 0 ) {?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h5 class="main-title"><a href="<?php 
            if ($order_settings_list[8]->header_name) { echo URL::to('/').'/'.$order_settings_list[8]->url ;} else { echo "" ; } ?>">
                 <?php if ($order_settings_list[1]->header_name) { echo $order_settings_list[8]->header_name ;} else { echo "" ; } ?>
            </a>
        </h5>  
<a href="<?php if ($order_settings_list[8]->header_name) { echo URL::to('/').'/'.$order_settings_list[8]->url ;} else { echo "" ; } ?>" class="see" >See All</a>

</div>
<div class="favorites-contens"> 
    <div class="artist-video home-sec list-inline row p-0 mb-0">
        <?php  if(isset($artist)) :
                    foreach($artist as $artist_details): 
                ?>

        <div class="items">
            <a href="<?php echo URL::to('artist-list') ?>">
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->artist_slug ?>">
                            <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist_details->image;  ?>" class="img-fluid w-100 h-50" alt="<?php echo $artist_details->artist_name; ?>"> 
                        </a>
                    </div>
                </div>
                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="text-white btn-cl" href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->artist_slug ?>">
                             <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" alt="play"/>
                        </a>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <h6><?php  echo (strlen($artist_details->artist_name) > 17) ? substr($artist_details->artist_name,0,18).'...' : $artist_details->artist_name; ?></h6>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<?php } ?>

<script>
    var elem = document.querySelector('.artist-video');
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