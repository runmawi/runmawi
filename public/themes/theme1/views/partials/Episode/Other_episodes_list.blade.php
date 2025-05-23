<div class="iq-main-header container-fluid d-flex align-items-center justify-content-between">
    <h6 class="main-title">
    <?= __('Episode') ?>
    </h6>
</div>

<div class="favorites-contens container-fluid">
    <ul class="favorites-slider list-inline  row p-0 m-0">
        <?php  
        foreach($season as $key => $seasons):
                foreach($seasons->episodes as $key => $episodes):
                    if($episodes->id != $episode->id): ?>

        <li class="slide-item">
            <a href="<?php echo URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug; ?>">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" class="img-fluid w-100" alt="">
                    </div>
                    <div class="block-description">

                        <div class="hover-buttons d-flex">
                            <a class="text-white " href="<?php echo URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ; ?> ">
                                <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" />
                            </a>
                        </div>
                    </div>
                </div>
                

                <div class="mt-2">

                    <div class="movie-time d-flex align-items-center justify-content-between my-2">
                        <a href="<?php echo URL::to('/play_series' . '/' . $episodes->slug); ?> ">
                            <h6><?php echo strlen($episodes->title) > 15 ? substr($episodes->title, 0, 15) . '...' : $episodes->title; ?></h6>
                        </a>
                        <div class="badge badge-secondary p-1 mr-2">
                            <?php echo $episodes->age_restrict . ' ' . '+'; ?>
                        </div>
                    </div>
                    <span class="text-white"><i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $episodes->duration) ?></span>
                </div>

                <div>
                    <small class="date" style="color:#fff;"><?php
                      $originalDate = $episodes->created_at;
                        $publishdate = explode(' ', date('F jS, Y', strtotime($originalDate)));
                        $translatedMonth = __($publishdate[0]);
                        $publishdate = implode(' ', [ $translatedMonth,$publishdate[1], $publishdate[2]]);
                        echo $publishdate ; ?>
                    </small>
                </div>
            </a>
        </li>
        <?php endif; endforeach; ?>
        <?php endforeach; ?>

    </ul>
</div>
