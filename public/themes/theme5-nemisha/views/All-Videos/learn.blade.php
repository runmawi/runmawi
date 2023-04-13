<?php
include public_path('themes/theme5-nemisha/views/header.php');
?>

<!-- MainContent -->
<section id="iq-favorites">
    @if (isset($respond_data['videos']) && count($respond_data['videos']) > 0)

        {{-- <h3 class="vid-title text-center mt-4 mb-5">Latest Videos</h3> --}}

        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">

                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">

                    </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if (isset($respond_data['videos']))

                                @foreach ($respond_data['videos'] as $key => $video)
                             
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{  URL::to('episode/'.$video->series_slug.'/'.$video->slug ) }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy"
                                                        data-src="{{ URL::to('public/uploads/images/' . $video->image) }}"
                                                        class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{  URL::to('episode/'.$video->series_slug.'/'.$video->slug ) }}">
                                                            <img class="ply"
                                                                src="{{ URL::to('assets/img/play.svg') }} ">
                                                        </a>
                                                        <div>
                                                            <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>

                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if ($respond_data['ThumbnailSetting']->title == 1)
                                                        <h6>{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}
                                                        </h6>
                                                    @endif

                                                    @if ($respond_data['ThumbnailSetting']->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $video->age_restrict . ' ' . '+' }}
                                                        </div>
                                                    @endif
                                                </div>


                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($respond_data['ThumbnailSetting']->duration == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $video->duration) ?>
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($respond_data['ThumbnailSetting']->rating == 1 && $video->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($video->rating); ?>
                                                        </span>
                                                    @endif

                                                    @if ($respond_data['ThumbnailSetting']->featured == 1 && $video->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- published_year -->
                                                    @if ($respond_data['ThumbnailSetting']->published_year == 1 && $video->year != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($video->year); ?>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $respond_data['videos']->links() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <p>
            <h3 class="text-center">No Video Available</h3>
        </div>
    @endif

    <?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>
