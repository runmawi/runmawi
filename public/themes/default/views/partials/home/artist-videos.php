<?php if(count($artist) > 0 ) {?>

    <div class="iq-main-header d-flex align-items-center justify-content-between">
            <h4 class="main-title"><a href="<?php echo URL::to('artist-list') ?>"> Artist </a></h4>                      
    </div>

    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($artist)) :
                    foreach($artist as $artist_details):  ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('artist-list') ?>">
                            <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->artist_slug ?>">
                                       <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist_details->image;  ?>" class="img-fluid loading" alt=""> 
                                    </a>

                                    <div class="block-description">
                                        <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                            <a  href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->artist_slug ?>">
                                                <h6><?php  echo (strlen($artist_details->artist_name) > 17) ? substr($artist_details->artist_name,0,18).'...' : $artist_details->artist_name; ?></h6>
                                            </a>
                                        <?php } ?>  

                                        <div class="hover-buttons">
                                            <a class="text-white d-flex align-items-center" href="<?php echo URL::to('artist') ?><?= '/' . $artist_details->artist_slug ?>" >
                                                <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                            </a>
                                        <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <?php endforeach; endif; ?>
        </ul>
    </div>

<?php } ?>