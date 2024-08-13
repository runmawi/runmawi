   
<section id="iq-favorites">
    <div class="iq-main-header ">
        <h4 class="main-title"> <?= __('Series') ?> </h4>
    </div>

    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  
                $ThumbnailSetting = App\ThumbnailSetting::first();
                foreach($series_lists as $key => $series_list):
            ?>
                <li class="slide-item">
                    <a href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                        <div class="block-images position-relative">
                            <div class="img-box">
                                <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" class="img-fluid" alt="">
                            </div>
                            <div class="block-description">
                                <p> <?php echo strlen($series_list->title) > 15 ? substr($series_list->title, 0, 15) . '...' : $series_list->title; ?> </p>
                                

                                <div class="hover-buttons">
                                        <span class="btn btn-hover">
                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                        <?= ('Play Now') ?>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>




    <!-- <div class="col-sm-12 overflow-hidden">
        <div class="favorites-contens ml-2">
            <ul class="favorites-slider list-inline row mb-0">
                <?php  
                    $ThumbnailSetting = App\ThumbnailSetting::first();
                    foreach($series_lists as $key => $series_list):
                ?>
                <li class="slide-item">
                    <a href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                        <div class="block-images position-relative">
                            <div class="img-box">
                                <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" class="w-100">
                            </div>
                            <div class="block-description">
                                <h6><?php echo strlen($series_list->title) > 15 ? substr($series_list->title, 0, 15) . '...' : $series_list->title; ?></h6>
                                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?> 
                                    <p class="date" style="color:#fff;font-size:14px;">
                                        <?= date('F jS, Y', strtotime($series_list->created_at)) ?>
                                        <?php if($series_list->access == 'guest'): ?>
                                        <span class="label label-info">Free</span>
                                        <?php elseif($series_list->access == 'subscriber'): ?>
                                        <span class="label label-success">Subscribers Only</span>
                                        <?php elseif($series_list->access == 'registered'): ?>
                                        <span class="label label-warning">Registered Users</span>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                <div class="movie-time d-flex align-items-center my-2">
                                    <div class="badge badge-secondary p-1 mr-2">
                                        <?php
                                            $SeriesSeason = App\SeriesSeason::where('series_id', $series_list->id)->count();
                                            echo $SeriesSeason . ' ' . 'Season';
                                        ?>
                                    </div>
                                    <div class="badge badge-secondary p-1 mr-2">
                                        <?php
                                            $Episode = App\Episode::where('series_id', $series_list->id)->count();
                                            echo $Episode . ' ' . 'Episodes';
                                        ?>
                                    </div>

                                    <div class="hover-buttons">
                                        <a href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                                            <span class="text-white">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Series 
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div> -->
</section>
