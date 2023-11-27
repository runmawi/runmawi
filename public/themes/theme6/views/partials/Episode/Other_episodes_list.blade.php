<div class="iq-main-header ">
    <h4 class="main-title"> <?= __('Episode') </h4>
</div>

<div class="col-sm-12 overflow-hidden">
    <div class="favorites-contens ml-2">
        <ul class="favorites-slider list-inline row mb-0">
            <?php  
            $ThumbnailSetting = App\ThumbnailSetting::first();
      foreach($season as $key => $seasons):
         foreach($seasons->episodes as $key => $episodes):
             if($episodes->id != $episode->id): ?>
            <li class="slide-item">
                
                <a
                    href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                    <div class="block-images position-relative">
                        <div class="img-box">
                            <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" class="w-100">
                        </div>
                        <div class="block-description">
                            <h6><?php echo strlen($episodes->title) > 15 ? substr($episodes->title, 0, 15) . '...' : $episodes->title; ?></h6>
                            <?php if($ThumbnailSetting->free_or_cost_label == 1): ?> 
                                <p class="date" style="color:#fff;font-size:14px;">
                                    <?= date('F jS, Y', strtotime($episodes->created_at)) ?>
                                    <?php if($episodes->access == 'guest'): ?>
                                    <span class="label label-info">Free</span>
                                    <?php elseif($episodes->access == 'subscriber'): ?>
                                    <span class="label label-success">Subscribers Only</span>
                                    <?php elseif($episodes->access == 'registered'): ?>
                                    <span class="label label-warning">Registered Users</span>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <div class="hover-buttons">
                                <a
                                    href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                    <span class="text-white"> <i class="fa fa-play mr-1"
                                            aria-hidden="true"></i> Play Now </span>
                                </a>
                            </div>
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