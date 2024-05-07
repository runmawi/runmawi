<?php
include public_path('themes/theme1/views/header.php');
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

    <!-- BREADCRUMBS -->
    <div class="row d-flex">
        <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('liveList') ?>"><?= ucwords( __('Live Stream')) ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('CategoryLive') ?>"><?= ucwords( __('Live Category')) ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($category_title) > 50 ? __(ucwords(substr($category_title, 0, 120) . '...')) : __(ucwords($category_title)); ?>
                        </a></li>
                </ol>
            </div>
        </div>
    </div>

    @if (isset($Live_Category) && count($Live_Category) > 0)
        <h3 class="vid-title text-center mt-4 mb-5">{{ __($category_title) }}</h3>
        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between"></div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">

                            @if (isset($Live_Category)) :
                                @foreach ($Live_Category as $LiveCategory)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('home') }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy"
                                                        data-src="{{ URL::to('public/uploads/images/' . $LiveCategory->image) }}"
                                                        class="img-fluid w-100" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="<?php echo URL::to('live') . '/' . $LiveCategory->slug; ?>">
                                                            <img class="ply" src="<?php echo URL::to('/') . '/assets/img/play.svg'; ?>">
                                                        </a>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>

                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if ($ThumbnailSetting->title == 1)
                                                        <h6><?php echo strlen($LiveCategory->title) > 17 ? substr($LiveCategory->title, 0, 18) . '...' : $LiveCategory->title; ?></h6>
                                                    @endif

                                                    @if ($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary"><?php echo $LiveCategory->age_restrict . ' ' . '+'; ?></div>
                                                    @endif
                                                </div>


                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($ThumbnailSetting->duration == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $LiveCategory->duration) ?>
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($ThumbnailSetting->rating == 1 && $LiveCategory->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($LiveCategory->rating); ?>
                                                        </span>
                                                    @endif

                                                    @if ($ThumbnailSetting->featured == 1 && $LiveCategory->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- published_year -->

                                                    @if ($ThumbnailSetting->published_year == 1 && $LiveCategory->year != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($LiveCategory->year); ?>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <p>
            <h3 class="text-center">{{ ('No Live Stream Available') }}</h3>
        </div>
    @endif

    <?php include public_path('themes/theme1/views/footer.blade.php'); ?>
