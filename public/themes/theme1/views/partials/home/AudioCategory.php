<?php
   include(public_path('themes/theme1/views/header.php'));
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
                    <h4 class="movie-title"><?= __('Audio Genre')  ?> <?php echo @$CategoryAudio->name ?></h4>
                </div>

                <!-- BREADCRUMBS -->
                <div class="row d-flex">
                    <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('Audios_list') ?>"><?= ucwords('Audio') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('AudiocategoryList') ?>"><?= ucwords('Audio Category') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a
                                        class="black-text"><?php echo strlen($CategoryAudio->name) > 50 ? ucwords(substr($CategoryAudio->name, 0, 120) . '...') : ucwords($CategoryAudio->name); ?>
                                    </a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        <?php if(isset($AudioCategory)) {
                        foreach($AudioCategory as $Audio_Category){ ?>
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href="<?php echo URL::to('/audio/'.$Audio_Category->slug ) ?>">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Audio_Category->image;  ?>"
                                            class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                        <div>
                                            <a class="text-white" href="<?php echo URL::to('/audio'.'/'.$Audio_Category->slug  ) ?> ">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                <?= __('Visit Audio Player')  ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="<?php echo URL::to('/audio/').'/'.$Audio_Category->slug  ?>">
                                <h6><?php  echo (strlen(@$Audio_Category->title) > 17) ? substr(@$Audio_Category->title,0,18).'...' : @$Audio_Category->title; ?>
                                </h6>
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
   include(public_path('themes/theme1/views/footer.blade.php'));
   ?>