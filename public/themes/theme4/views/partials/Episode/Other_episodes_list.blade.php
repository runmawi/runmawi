<div class="iq-main-header ">
    <h4 class="main-title"><?= __('Episode') ?>  </h4>
</div>




            <div class="col-sm-12 overflow-hidden">
                <div class="favorites-contens ml-2">
                    <div class="trending-contens sub_dropdown_image mt-3">
                        <ul class="favorites-slider list-inline row mb-0">
                            <?php  
                            $ThumbnailSetting = App\ThumbnailSetting::first();
                            foreach($season as $key => $seasons):
                                foreach($seasons->episodes as $key => $episodes):
                                    if($episodes->id != $episode->id): ?>
                                        <li class="slide-item">
                                            <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                                <div class="position-relative">
                                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" class="w-100">
                                                    <div class="controls">
                                                        <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                        </a>

                                                        <nav>
                                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Other-episode-videos-Modal"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                        </nav>

                                                    </div>
                                                        <!-- <h6><?php echo strlen($episodes->title) > 15 ? substr($episodes->title, 0, 15) . '...' : $episodes->title; ?></h6>
                                                        <?php if($ThumbnailSetting->free_or_cost_label == 1): ?> 
                                                            <p class="date" style="color:#fff;font-size:14px;">
                                                                <?= date('F jS, Y', strtotime($episodes->created_at)) ?>
                                                                <?php if($episodes->access == 'guest'): ?>
                                                                <span class="label label-info">{{ __('Free') }}</span>
                                                                <?php elseif($episodes->access == 'subscriber'): ?>
                                                                <span class="label label-success">{{ __('Subscribers Only') }}</span>
                                                                <?php elseif($episodes->access == 'registered'): ?>
                                                                <span class="label label-warning">{{ __('Registered Users') }}</span>
                                                                <?php endif; ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <div class="hover-buttons">
                                                            <a
                                                                href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                                                <span class="text-white"> <i class="fa fa-play mr-1"
                                                                        aria-hidden="true"></i> {{ __('Play Now') }} </span>
                                                            </a>
                                                        </div> -->
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
            $ThumbnailSetting = App\ThumbnailSetting::first();
            foreach($season as $key => $seasons):
                foreach($seasons->episodes as $key => $episodes):
                    if($episodes->id != $episode->id): ?>
                        <div class="modal fade info_model" id="Other-episode-videos-Modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                <div class="container">
                                    <div class="modal-content" style="border:none; background-color:transparent;">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <img  src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->player_image; ?>" alt="" width="100%">
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
                                                        
                                                        <div class="trending-dec mt-4"> <?= $episodes->description ?> </div>

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