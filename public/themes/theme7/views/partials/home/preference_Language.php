<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Preference By language </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_Language)) :
                    foreach($preference_Language as $preference_Languages): 
                ?>

                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>" class="img-fluid loading w-100" alt="p-img"> 
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; endif; ?>
        </ul>
    </div>