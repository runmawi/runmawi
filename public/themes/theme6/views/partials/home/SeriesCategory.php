<?php
   include(public_path('themes/default/views/header.php'));
?>

<style>
/* <!-- BREADCRUMBS  */
.bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
    content: none;
}

ol.breadcrumb {
    color: white;
    background-color: transparent !important;
    font-size: revert;
}

.nav-div.container-fluid {
    padding: 0;
}
</style>

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title"><?php echo @$CategorySeries->name ?></h4>
                </div>

                <!-- BREADCRUMBS -->
                <div class="row d-flex">
                    <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('series.tv-shows') ?>"><?= ucwords('Series') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('SeriescategoryList') ?>"><?= ucwords('category') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a
                                        class="black-text"><?php echo strlen($CategorySeries->name) > 50 ? ucwords(substr($CategorySeries->name, 0, 120) . '...') : ucwords($CategorySeries->name); ?>
                                    </a></li>
                            </ol>
                        </div>
                    </div>
                </div>


                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        <?php if(isset($SeriesGenre)) {
                            foreach($SeriesGenre as $Series_Genre){ ?>
                                <li class="slide-item">
                                    <a href="<?php echo URL::to('/play_series/'.$Series_Genre->slug ) ?>">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Genre->image;  ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <p> <?php  echo (strlen(@$Series_Genre->title) > 17) ? substr(@$Series_Genre->title,0,18).'...' : @$Series_Genre->title; ?> </p>
                                                

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit Series
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php } } ?>
                    </ul>
                </div>

                <!-- <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        <?php if(isset($SeriesGenre)) {
                        foreach($SeriesGenre as $Series_Genre){ ?>
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href="<?php echo URL::to('/play_series/'.$Series_Genre->slug ) ?>">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Genre->image;  ?>"
                                            class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                        <a href="<?php echo URL::to('/play_series/').'/'.$Series_Genre->slug  ?>">
                                            <p><?php  echo (strlen(@$Series_Genre->title) > 17) ? substr(@$Series_Genre->title,0,18).'...' : @$Series_Genre->title; ?>
                                            </p>
                                        </a>
                                        <div class="hover-buttons">
                                            <div>
                                            </div>
                                        </div>
                                        <div>
                                            <a class="text-white"
                                                href="<?php echo URL::to('/play_series'.'/'.$Series_Genre->slug  ) ?> ">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                Visit Series
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php } } ?>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/default/views/footer.blade.php'));
   ?>