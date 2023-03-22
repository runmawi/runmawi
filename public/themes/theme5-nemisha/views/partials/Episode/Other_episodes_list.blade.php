<div class="iq-main-header  d-flex align-items-center justify-content-between">
    <h4 class="mb-3">Episode</h4>
</div>

<div class=" overflow-hidden">
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  
            foreach($season as $key => $seasons):
                foreach($seasons->episodes as $key => $episodes):
                    if($episodes->id != $episode->id): ?>
            <li class="slide-item p-2">
                <a class="block-thumbnail"
                    href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                    <div class="block-images position-relative">
                        <div class="img-box">
                            <img class="w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" width="">
                            <?php if($episodes->access == 'guest'): ?>
                            <span class="label label-info p-tag1">Free</span>
                            <?php elseif($episodes->access == 'subscriber'): ?>
                            <span class="label label-success ">Subscribers Only</span>
                            <?php elseif($episodes->access == 'registered'): ?>
                            <span class="label label-warning">Registered Users</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="thumbnail-overlay"></div>

                    <div class="details">
                        <h6><?php echo strlen($episodes->title) > 15 ? substr($episodes->title, 0, 15) . '...' : $episodes->title; ?>
                            <span><br><?= gmdate('H:i:s', $episodes->duration) ?></span>
                        </h6>
                    </div>
                </a>

                <div class="block-contents">

                    <small class="date"
                        style="color:#fff;"><?= date('F jS, Y', strtotime($episodes->created_at)) ?>
                    </small>

                    <p class="desc">
                        <?php if (strlen($episodes->description) > 90) {
                            echo substr($episodes->description, 0, 90) . '...';
                        } else {
                            echo $episodes->description;
                        } ?>
                    </p>
            </li>
            <?php endif; endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>