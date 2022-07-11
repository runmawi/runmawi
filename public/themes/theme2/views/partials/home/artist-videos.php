<?php if(count($artist) > 0 ) {?>


<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href="<?php echo URL::to('Artist-list') ?>"> Artist </a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($artist)) :
                    foreach($artist as $artist_details): 
                ?>

        <li class="slide-item">
            <a href="<?php echo URL::to('Artist-list') ?>">
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->id ?>">
                             <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_details->image;  ?>" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>

                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="text-white btn-cl" href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->id ?>">
                         <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> 
                        </a>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <h6><?php  echo (strlen($artist_details->artist_name) > 17) ? substr($artist_details->artist_name,0,18).'...' : $artist_details->artist_name; ?></h6>
                    <?php } ?>
                </div>

            </a>
        </li>
        <?php endforeach; endif; ?>
    </ul>
</div>

<?php } ?>
