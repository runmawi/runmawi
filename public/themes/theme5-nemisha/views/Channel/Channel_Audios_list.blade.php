<?php include public_path('themes/theme5-nemisha/views/header.php'); ?>

<!-- MainContent -->
<section id="iq-favorites">

        <div class="container-fluid" >
            <div class="row">

                <div class="col-sm-12 page-height">

                    <div class="iq-main-header align-items-center justify-content-between">
                        <h4 class="main-title mt-3">                  
                            <b>Channel Latest Audios</b>
                        </h4>                   
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="list-inline  row p-0 mb-4">

                            @if (count($audios) > 0)

                                @forelse ($audios as $key => $audio)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">

                                        <a href="{{ URL::to('audio/' . $audio->slug) }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="{{ $audio->image ? URL::to('/public/uploads/images/'.$audio->image) : $default_vertical_image_url }}" class="img-fluid" alt="Channel-Audio-Image">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{ URL::to('audio/' . $audio->slug) }}">
                                                            <img class="ply" src="{{ URL::to('assets/img/play.svg') }} ">
                                                        </a>
                                                    <div>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div
                                                    class="movie-time d-flex align-items-center justify-content-between my-2">
                                                    @if ($ThumbnailSetting->title == 1)
                                                        <h6> {{ strlen($audio->title) > 17 ? substr($audio->title, 0, 18) . '...' : $audio->title }}
                                                        </h6>
                                                    @endif

                                                </div>

                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($ThumbnailSetting->duration == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $audio->duration) }}
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($ThumbnailSetting->rating == 1 && $audio->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $audio->rating }}
                                                        </span>
                                                    @endif

                                                    @if ($ThumbnailSetting->featured == 1 && $audio->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- published_year -->
                                                    @if ($ThumbnailSetting->published_year == 1 && $audio->year != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $audio->year }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- Category Thumbnail  setting -->
                                                    <?php
                                                    
                                                    $CategoryThumbnail_setting = App\CategoryAudio::Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
                                                        ->where('category_audios.audio_id', $audio->id)
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
                                @empty
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                        <h3 class="text-center">No Audio Available</h3>
                                    </div>
                                @endforelse
                            @else
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <h3 class="text-center">No Audio Available</h3>
                                </div>
                            @endif
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $audios->links() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
</section>

<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>