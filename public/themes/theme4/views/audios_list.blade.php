@php
    include public_path('themes/theme4/views/header.php');
@endphp

<div class="main-content">
    <section id="iq-favorites">
        <h2 class="text-center  mb-3"> {{ __('Audios') }} </h2>
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">

                    <div class="data">

                        <div class="favorites-contens data">
                            <ul class="category-page list-inline  row p-0 mb-4">
                                @if (count($audios) > 0)
                                    @forelse($audios as $key => $audios_data)
                                        <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                            <a href="{{ URL::to('audio/' . $audios_data->slug) }}">

                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img src="{{ URL::to('public/uploads/images/' . $audios_data->image) }}"
                                                            class="img-fluid w-100">
                                                    </div>

                                                    <div class="block-description">

                                                        @if ($ThumbnailSetting->title == 1)
                                                            <!-- Title -->
                                                            <a href="{{ URL::to('audio/' . $audios_data->slug) }}">
                                                                <h6>{{ strlen($audios_data->title) > 17 ? substr($audios_data->title, 0, 18) . '...' : $audios_data->title }}
                                                                </h6>
                                                            </a>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if ($ThumbnailSetting->age == 1)
                                                                <!-- Age -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    {{ $audios_data->age_restrict . ' ' . '+' }}
                                                                </div>
                                                            @endif

                                                            @if ($ThumbnailSetting->duration == 1)
                                                                <!-- Duration -->
                                                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                                                    <?= gmdate('H:i:s', $audios_data->duration) ?></span>
                                                            @endif
                                                        </div>


                                                        @if ($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if ($ThumbnailSetting->rating == 1)
                                                                    <!--Rating  -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o"
                                                                                aria-hidden="true"></i>
                                                                            {{ $audios_data->rating }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if ($ThumbnailSetting->published_year == 1)
                                                                    <!-- published_year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i aria-hidden="true"
                                                                                class="fa fa-calendar"></i>
                                                                            {{ $audios_data->year }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if ($ThumbnailSetting->featured == 1 && $audios_data->featured == 1)
                                                                    <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o"
                                                                                aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

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

                                                        <div class="hover-buttons">
                                                            <a class="text-white"
                                                                href="{{ URL::to('audio/' . $audios_data->slug) }}">
                                                                <span><i class="fa fa-play mr-1"
                                                                        aria-hidden="true"></i>{{ __('Watch Now') }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                @elseif(count($audios) == 0)
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat:
                                    no-repeat;background-size:contain;height: 500px!important;">
                                        <p>
                                        <h3 class="text-center">{{ __('No Audios Available') }}</h3>
                                    </div>
                                @endif
                            </ul>
                        </div>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! count($audios) != 0 ? $audios->links() : ' ' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp
