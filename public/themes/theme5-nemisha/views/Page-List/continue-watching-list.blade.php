@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp
<!-- MainContent -->

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular"> {{ __('Continue Watching List') }} </h4>
                </div>

                @if (count($Video_cnt) > 0 || count($episode_cnt) > 0)


                    <div class="favorites-contens">

                        <!-- Video Loop -->
                        <ul class="category-page list-inline row p-0 mb-0">
                            @foreach ($Video_cnt as $key => $watchlater_video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug; ?>" aria-label= "video">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug; ?>">
                                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->image; ?>"
                                                        class="img-fluid w-100 h-50 flickity-lazyloaded"
                                                        alt="<?php echo $watchlater_video->title; ?>">
                                                </a>

                                                <!-- PPV price -->
                                                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                                                <?php if(!empty($watchlater_video->ppv_price)): ?>
                                                <p class="p-tag1"><?php echo $currency->symbol . ' ' . $watchlater_video->ppv_price; ?></p>
                                                <?php elseif(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null): ?>
                                                <p class="p-tag1"><?php echo $watchlater_video->global_ppv . ' ' . $currency->symbol; ?></p>
                                                <?php elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null): ?>
                                                <p class="p-tag"><?php echo 'Free'; ?></p>
                                                <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if($ThumbnailSetting->published_on == 1): ?>
                                                <p class="published_on1"><?php echo $publish_time; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a class="" href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug; ?>" aria-label="Latest-Video">
                                                    <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" alt="play" />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                <?php if($ThumbnailSetting->title == 1): ?>
                                                <h6><?php echo strlen($watchlater_video->title) > 17 ? substr($watchlater_video->title, 0, 18) . '...' : $watchlater_video->title; ?></h6>
                                                <?php endif; ?>

                                                <?php if($ThumbnailSetting->age == 1): ?>
                                                <div class="badge badge-secondary"><?php echo $watchlater_video->age_restrict . '+'; ?></div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="movie-time my-2">
                                                <!-- Duration -->
                                                <?php if($ThumbnailSetting->duration == 1): ?>
                                                <span class="text-white">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php echo gmdate('H:i:s', $watchlater_video->duration); ?>
                                                </span>
                                                <?php endif; ?>

                                                <!-- Rating -->
                                                <?php if($ThumbnailSetting->rating == 1 && $watchlater_video->rating != null): ?>
                                                <span class="text-white">
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <?php echo __($watchlater_video->rating); ?>
                                                </span>
                                                <?php endif; ?>

                                                <!-- Featured -->
                                                <?php if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1): ?>
                                                <span class="text-white">
                                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                                </span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="movie-time my-2">
                                                <!-- published_year -->
                                                <?php if($ThumbnailSetting->published_year == 1 && $watchlater_video->year != null): ?>
                                                <span class="text-white">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo __($watchlater_video->year); ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="movie-time my-2">
                                                <!-- Category Thumbnail setting -->
                                                <?php
                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                    ->where('categoryvideos.video_id', $watchlater_video->id)
                                                    ->pluck('video_categories.name');
                                                ?>

                                                <?php if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0): ?>
                                                <span class="text-white">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    <?php echo implode(', ', $CategoryThumbnail_setting->toArray()); ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <!-- Episode Loop -->
                        @foreach ($episode_cnt as $episode_key => $latest_view_episode)
                            <div class="network-image">
                                <div class="movie-sdivck position-relative">
                                    <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/' . $latest_view_episode->image) : $default_vertical_image_url }}"
                                        class="img-fluid w-100" alt="Videos" width="300" height="200">

                                    <div class="controls">
                                        <a
                                            href="{{ URL::to('episode/' . $latest_view_episode->series->slug . '/' . $latest_view_episode->slug) }}">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                        <nav>
                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal"
                                                data-bs-target="#continue_watching_episodes-Modal-{{ $episode_key }}"><i
                                                    class="fas fa-info-circle"></i><span>More info</span></button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade info_model"
                                id="{{ 'continue_watching_episodes-Modal-' . $episode_key }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                    <div class="container">
                                        <div class="modal-content" style="border:none; background:transparent;">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <img src="{{ $latest_view_episode->player_image ? URL::to('public/uploads/images/' . $latest_view_episode->player_image) : $default_horizontal_image_url }}"
                                                                alt="latest_view_episode">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                                    <h2 class="caption-h2">
                                                                        {{ optional($latest_view_episode)->title }}</h2>

                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                                    <button type="button" class="btn-close-white"
                                                                        aria-label="Close" data-bs-dismiss="modal">
                                                                        <span aria-hidden="true"><i class="fas fa-times"
                                                                                aria-hidden="true"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>


                                                            @if (optional($latest_view_episode)->episode_description)
                                                                <div class="trending-dec mt-4">{!! html_entity_decode(optional($latest_view_episode)->episode_description) !!}
                                                                </div>
                                                            @endif

                                                            <a href="{{ URL::to('episode/' . $latest_view_episode->series->slug . '/' . $latest_view_episode->slug) }}"
                                                                class="btn btn-hover button-groups mr-2 mt-3"
                                                                tabindex="0"><i class="far fa-eye mr-2"
                                                                    aria-hidden="true"></i> View Content </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    div#trending-slider-nav {
        display: flex;
        flex-wrap: wrap;
    }

    .network-image {
        flex: 0 0 16.666%;
        max-width: 16.666%;
    }

    /* .network-image img{width: 100%; height:auto;} */
    .movie-sdivck {
        padding: 2px;
    }

    .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }

    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }

    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .blob {
        margin: 10px;
        height: 22px;
        width: 59px;
        border-radius: 25px;
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
        transform: scale(1);
        animation: pulse 2s infinite;
        position: absolute;
        top: 0;
    }

    @media (max-width:1024px) {
        .modal-body {
            padding: 0 !important;
        }
    }

    @media (max-width:768px) {
        .network-image {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }

    @media (max-width:500px) {
        .network-image {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
</style>
<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>
