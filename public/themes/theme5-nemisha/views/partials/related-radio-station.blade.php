<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline row p-0 mb-0">
                        <?php 
                        if (isset($Related_radiostation)) :
                            foreach ($Related_radiostation as $radiostation) : ?>
                                <li class="slide-item">
                                    <a href="<?php echo URL::to('radio-station/' . $radiostation->slug); ?>">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $radiostation->image; ?>" class="img-fluid" alt="">
                                            </div>
                                        </div>                
                                        <div class="mt-2">
                                            <h6><?php echo __($radiostation->title); ?></h6>
                                        </div>
                                    </a>
                                </li>
                            <?php 
                            endforeach; 
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
