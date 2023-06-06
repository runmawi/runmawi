@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<div class="main-content">
    <section id="iq-favorites">
        <h2 class="text-center  mb-3"> {{ @$category_title }} </h2>
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">

                    <div class="data">
                        <div class="favorites-contens">
                            <ul class="category-page list-inline  row p-0 mb-4">

                                @if (count($Live_Category) > 0)

                                    @foreach ($Live_Category as $key => $LiveCategory)
                                        <li class="slide-item col-6 col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                            <a href="{{ URL::to('live/' . $LiveCategory->slug) }} ">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img loading="lazy"
                                                            data-src="{{ URL::to('public/uploads/images/' . $LiveCategory->image) }}"
                                                            class="img-fluid" alt="" width="">
                                                    </div>
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a class="text-white btn-cl"
                                                            href="{{ URL::to('live/' . $LiveCategory->slug) }}">
                                                            <img src="{{ URL::to('assets/img/play.png') }}"
                                                                class="ply">
                                                        </a>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div
                                                        class="movie-time d-flex align-items-center justify-content-between my-2">
                                                        @if ($ThumbnailSetting->title == 1)
                                                            <h6> {{ strlen($LiveCategory->title) > 17 ? substr($LiveCategory->title, 0, 18) . '...' : $LiveCategory->title }}
                                                            </h6>
                                                        @endif

                                                        @if ($ThumbnailSetting->age == 1)
                                                            <div class="badge badge-secondary">
                                                                {{ $LiveCategory->age_restrict . ' ' . '+' }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time my-2">

                                                        <!-- Duration -->

                                                        @if ($ThumbnailSetting->duration == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $LiveCategory->duration) }}
                                                            </span>
                                                        @endif

                                                        <!-- Rating -->

                                                        @if ($ThumbnailSetting->rating == 1 && $LiveCategory->rating != null)
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ $LiveCategory->rating }}
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
                                                                {{ $LiveCategory->year }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time my-2">
                                                        <!-- Category Thumbnail  setting -->
                                                        <?php
                                                        
                                                        $CategoryThumbnail_setting = App\CategoryLive::Join('live_categories', 'livecategories.category_id', '=', 'live_categories.id')
                                                            ->where('livecategories.live_id', $LiveCategory->id)
                                                            ->pluck('live_categories.name');
                                                        
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
                                    @endforeach
                                @elseif(count($Live_Category) == 0)
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                                        <p>
                                        <h2 style="position: absolute;top: 50%;left: 50%;color: white;">No Live Streams Available</h2>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

@php
    include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp