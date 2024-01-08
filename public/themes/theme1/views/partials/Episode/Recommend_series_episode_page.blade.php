<div class="iq-main-header container-fluid d-flex align-items-center justify-content-between">
    <h4 class="main-title"> <?= __('Series') ?></h4>
</div>

<div class="favorites-contens container-fluid">
    <ul class="favorites-slider list-inline  row p-0 m-0">
        <?php  
      foreach($series_lists as $series_list): ?>
        <li class="slide-item">
            <a href="<?php echo URL::to('/play_series' . '/' . $series_list->slug); ?>">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" class="img-fluid w-100" alt="">
                    </div>
                    <div class="block-description">
                        <div class="hover-buttons d-flex">
                            <a class="text-white " href="<?php echo URL::to('/play_series' . '/' . $series_list->slug); ?> ">
                                <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" />

                            </a>
                        </div>
                    </div>
                </div>
               

                <div class="mt-2">

                    <div class="movie-time d-flex align-items-center justify-content-between my-2">
                        <a href="<?php echo URL::to('/play_series' . '/' . $series_list->slug); ?> ">
                            <h6><?php echo strlen($series_list->title) > 15 ? substr($series_list->title, 0, 15) . '...' : $series_list->title; ?></h6>
                        </a>

                        <div class="badge badge-secondary p-1 mr-2">
                            <?php echo $series_list->age_restrict . ' ' . '+'; ?>
                        </div>

                        <div class="badge badge-secondary p-1 mr-2">
                            <?php
                                $SeriesSeason = App\SeriesSeason::where('series_id', $series_list->id)->count();
                                echo $SeriesSeason . ' ' . 'Season';
                            ?></div>
                        <div class="badge badge-secondary p-1 mr-2">
                            <?php
                                $Episode = App\Episode::where('series_id', $series_list->id)->count();
                                echo $Episode . ' ' . 'Episodes';
                            ?>
                        </div>
                    </div>
                    <span class="text-white"><i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $series_list->duration) ?></span>
                </div>

                <div>
                    <small class="date" style="color:#fff;"><?= date('F jS, Y', strtotime($series_list->created_at)) ?>
                    </small>
                </div>
            </a>
        </li>
        <?php endforeach; ?>

    </ul>
</div>
