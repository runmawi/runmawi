<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Preference By Genres </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_genres)) :
                    foreach($preference_genres as $preference_genre): 
                ?>

                <li class="slide-item">
                    <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>" class="img-fluid loading w-100" alt="p-img"> 
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>