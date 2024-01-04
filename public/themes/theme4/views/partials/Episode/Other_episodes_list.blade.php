<?php 
    $ThumbnailSetting = App\ThumbnailSetting::first();
?>

<div class="iq-main-header ">
    <h4 class="main-title"><?= __('Episode') ?>  </h4>
</div>

<div class="col-sm-12 overflow-hidden pl-0">
    <div class="favorites-contens ml-2">
        <div class="trending-contens sub_dropdown_image mt-3">
            <ul class="favorites-slider list-inline row mb-0">
                <?php  
                foreach($season as $key => $seasons):
                    foreach($seasons->episodes as $episode_key => $episodes):
                        if($episodes->id != $episode->id): ?>
                            <li class="slide-item">
                                <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                    <div class="position-relative">
                                        <img src="<?= URL::to('public/uploads/images/'.$episodes->image) ?>" class="w-100">
                                        <div class="controls">
                                            <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>

                                            <nav>
                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target=<?= "#Other-episode-videos-Modal-".$episode_key ?> ><i class="fas fa-info-circle"></i><span>More info</span></button>
                                            </nav>

                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Model -->
<?php  
foreach($season as $key => $seasons):
    foreach($seasons->episodes as $episode_key => $episodes):
        if($episodes->id != $episode->id): ?>
            <div class="modal fade info_model" id=<?= "Other-episode-videos-Modal-".$episode_key ?> tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background-color:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="<?= URL::to('public/uploads/images/'.$episodes->image) ?>" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2"> <?= $episodes->title ?></h2>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <?php if (optional($episodes)->episode_description): ?>
                                                <div class="trending-dec mt-4"><?php echo html_entity_decode( optional($episodes)->episode_description) ?> </div>
                                            <?php endif; ?>

                                            <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>