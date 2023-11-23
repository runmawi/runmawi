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
                    <h4 class="movie-title">Live Category Video</h4>
                </div>

                <!-- BREADCRUMBS -->
                <div class="row d-flex">
                    <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('liveList') ?>"><?= ucwords('live Stream') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('CategoryLive') ?>"><?= ucwords(' Live Category') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a
                                        class="black-text"><?php echo strlen($category_title) > 50 ? ucwords(substr($category_title, 0, 120) . '...') : ucwords($category_title); ?>
                                    </a></li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        <?php if(isset($Live_Category)) {
                        foreach($Live_Category as $LiveCategory){ ?>
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href="<?php echo URL::to('live/'.$LiveCategory->slug ) ?>">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$LiveCategory->image;  ?>"
                                            class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                        <a href="<?php echo URL::to('live').'/'.$LiveCategory->slug  ?>">
                                            <p class="epi-name text-left m-0">
                                                <?php  echo (strlen(@$LiveCategory->title) > 17) ? substr(@$LiveCategory->title,0,18).'...' : @$LiveCategory->title; ?>
                                            </p>
                                        </a>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal"
                                                data-target="#myModal<?= @$LiveCategory->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/default/views/footer.blade.php'));
   ?>