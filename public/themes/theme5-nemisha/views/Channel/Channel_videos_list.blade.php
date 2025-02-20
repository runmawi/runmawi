<?php include public_path('themes/theme5-nemisha/views/header.php'); ?>

<!-- MainContent -->

<section id="iq-favorites">
    @if (isset($respond_data['videos']) && count($respond_data['videos']) > 0)

        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">

                <div class="col-sm-12 page-height">

                    <div class="iq-main-header align-items-center justify-content-between">
                        <h4 class="main-title mt-3">                  
                            <b>Channel Latest Videos in:</b> {{{ $respond_data['channel_slug'] }}} 
                        </h4>                   
                    </div>

                @if ($respond_data['videos']->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="list-inline row p-0 mb-0">
                            @if (isset($respond_data['videos']))

                                @forelse ($respond_data['videos'] as $key => $video)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">

                                        <a href="{{ $video->redirect_url }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="{{ $video->image ? URL::to('/public/uploads/images/'.$video->image) : $default_vertical_image_url }}" class="img-fluid" alt="Channel-Video-Image">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{ $video->redirect_url }}">
                                                            <img class="ply" src="{{ URL::to('assets/img/play.svg') }} ">
                                                        </a>
                                                    <div>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if ($respond_data['ThumbnailSetting']->title == 1)
                                                        <h6>{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}</h6>
                                                    @endif

                                                    @if ($respond_data['ThumbnailSetting']->age == 1 && $video->age_restrict != null )
                                                        <div class="badge badge-secondary">
                                                            {{ $video->age_restrict . ' ' . '+' }}
                                                        </div>
                                                    @endif
                                                </div>


                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($respond_data['ThumbnailSetting']->duration == 1 && $video->duration != null )
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $video->duration) }}
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($respond_data['ThumbnailSetting']->rating == 1 && $video->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                             {{ $video->rating }}
                                                        </span>
                                                    @endif

                                                    <!-- Featured -->
                                                    @if ($respond_data['ThumbnailSetting']->featured == 1 && $video->featured != null && $video->featured == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                    {{-- Source --}}
                                                <div class="movie-time my-2">
                                                    <span class="text-white">
                                                        {{ $video->source }}
                                                    </span>
                                                </div>

                                                    <!-- published_year -->
                                                @if ($respond_data['ThumbnailSetting']->published_year == 1 && $video->year != null)
                                                    <div class="movie-time my-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ $video->year }}
                                                        </span>
                                                    </div>
                                                @endif
    
                                                @if ( $video->source_data == "videos" )
                                                    <div class="movie-time my-2">
                                                        <!-- Category Thumbnail  setting -->
                                                        <?php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $video->id)
                                                                ->pluck('video_categories.name');
                                                        ?>

                                                        @if ($respond_data['ThumbnailSetting']->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                <?php
                                                                    $Category_Thumbnail = [];
                                                                    foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                        $Category_Thumbnail[] = $CategoryThumbnail;
                                                                        $CategoryThumbnail_link = URL::to('category/'.$CategoryThumbnail);
                                                                    }

                                                                    echo  implode(',' . ' ', $Category_Thumbnail)

                                                                    // echo '<a href="' . $CategoryThumbnail_link . '">' . implode(',' . ' ', $Category_Thumbnail) . '</a>';
                                                                ?>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif ( $video->source_data == "series" )
                                                    <div class="movie-time my-2">
                                                        <!-- Category Thumbnail  setting -->
                                                        <?php
                                                            $CategoryThumbnail_setting = App\SeriesCategory::join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
                                                                ->where('series_categories.series_id', $video->id)
                                                                ->pluck('series_genre.name');
                                                        ?>

                                                        @if ($respond_data['ThumbnailSetting']->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                <?php
                                                                    $Category_Thumbnail = [];
                                                                    foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                        $Category_Thumbnail[] = $CategoryThumbnail;
                                                                    }
                                                                    echo  implode(',' . ' ', $Category_Thumbnail)
                                                                ?>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                        <p>
                                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                    </div>
                                @endforelse
                            @endif
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $respond_data['videos']->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <h3 class="text-center">{{ __('No Video Available') }}</h3>
        </div>
    @endif
</section>

<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>