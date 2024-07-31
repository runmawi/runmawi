<?php
   include(public_path('themes/theme5-nemisha/views/header.php'));
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
                    <h4 class="movie-title"> <?php echo @$CategoryAudio->name ?></h4>
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
                    <div class="audio-category home-sec list-inline row p-0 mb-0">
                        <?php if(isset($AudioCategory)) {
                        foreach($AudioCategory as $Audio_Category){ ?>
                        <div class="items col-sm-2 col-md-2 col-xs-12">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Audio_Category->image;  ?>"
                                            class="img-fluid w-100 h-50 flickity-lazyloaded" 
                                            alt="<?php echo $Audio_Category->title; ?>">
                                    </div>

                                    <div class="block-description">
                                        <a href="<?php echo URL::to('/audio/').'/'.$Audio_Category->slug  ?>">
                                            <h6><?php  echo (strlen(@$Audio_Category->title) > 17) ? substr(@$Audio_Category->title,0,18).'...' : @$Audio_Category->title; ?>
                                            </h6>
                                        </a>
                                        <div class="hover-buttons">
                                            <div>
                                            </div>
                                        </div>
                                        <div>
                                            <a class="text-white"
                                                href="<?php echo URL::to('/audio'.'/'.$Audio_Category->slug  ) ?> ">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                Visit Audio Player
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
?>

<script>
    var elem = document.querySelector('.audio-category');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
</script>