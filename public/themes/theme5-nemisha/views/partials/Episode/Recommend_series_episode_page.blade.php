<div class="iq-main-header  d-flex align-items-center justify-content-between">
    <h4 class="mb-3">Series</h4>
</div>

<div class=" overflow-hidden">
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php    $series_lists = App\Series::all(); foreach($series_lists as $key => $series_list): ?>
            <li class="slide-item p-2">
                <a class="block-thumbnail" href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                    <div class="block-images position-relative">
                        <div class="img-box">
                            <img class="w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" width="">
                            <?php if($series_list->access == 'guest'): ?>
                            <span class="label label-info p-tag1">Free</span>
                            <?php elseif($series_list->access == 'subscriber'): ?>
                            <span class="label label-success ">Subscribers Only</span>
                            <?php elseif($series_list->access == 'registered'): ?>
                            <span class="label label-warning">Registered Users</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="thumbnail-overlay"></div>

                    <div class="details">
                        <h4>
                            <?php echo strlen($series_list->title) > 15 ? substr($series_list->title, 0, 15) . '...' : $series_list->title; ?>
                        </h4>

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

                    </div>
                </a>

                <div class="block-contents">

                    <small class="date"
                        style="color:#fff;"><?= date('F jS, Y', strtotime($series_list->created_at)) ?>
                    </small>

                    <p class="desc">
                        <?php if (strlen($series_list->description) > 90) {
                            echo substr($series_list->description, 0, 90) . '...';
                        } else {
                            echo $series_list->description;
                        } ?>
                    </p>
            </li>
            <?php ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
