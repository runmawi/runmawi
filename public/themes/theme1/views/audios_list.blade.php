<?php
include public_path('themes/theme1/views/header.php');
?>

<section id="iq-favorites">
    @if (isset($audios) && count($audios) > 0)
        <h3 class="vid-title text-center mt-4 mb-5"> {{ __('Audios') }} </h3>
        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between"></div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">

                            @if (isset($audios)) :
                                @foreach ($audios as $audios_data)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="<?php echo URL::to('audio/' . $audios_data->slug); ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $audios_data->image; ?>"
                                                        class="img-fluid w-100" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{ URL::to('audio/' . $audios_data->slug) }}">
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
                                                        <h6><?php echo strlen($audios_data->title) > 17 ? substr($audios_data->title, 0, 18) . '...' : $audios_data->title; ?></h6>
                                                    @endif

                                                    @if ($ThumbnailSetting->age == 1)
                                                        <div class="badge badge-secondary"><?php echo $audios_data->age_restrict . ' ' . '+'; ?></div>
                                                    @endif
                                                </div>


                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($ThumbnailSetting->duration == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $audios_data->duration) ?>
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($ThumbnailSetting->rating == 1 && $audios_data->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($audios_data->rating); ?>
                                                        </span>
                                                    @endif

                                                    @if ($ThumbnailSetting->featured == 1 && $audios_data->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- published_year -->

                                                    @if ($ThumbnailSetting->published_year == 1 && $audios_data->year != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($audios_data->year); ?>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- Category Thumbnail  setting -->
                                                    <?php
                                                    $CategoryThumbnail_setting = App\CategoryAudio::Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
                                                        ->where('category_audios.audio_id', $audios_data->id)
                                                        ->pluck('audio_categories.name');
                                                    ?>
                                                    @if ($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                        <span class="text-white">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            <?php
                                                            $Category_Thumbnail = [];
                                                            foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                $Category_Thumbnail[] = $CategoryThumbnail;
                                                            }
                                                            echo implode(',' . ' ', $Category_Thumbnail);
                                                            ?>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </a>
                                    </li>
                                @endforeach;
                            @endif
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            <?php echo $audios->links(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <p>
            <h3 class="text-center">{{ __('No Live stream Video Available') }}</h3>
        </div>
    @endif

    <?php include public_path('themes/theme1/views/footer.blade.php'); ?>
