@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<section id="iq-tvthrillers" class="s-margin">
    <div class="container-fluid">

        @if (count($live) > 0)
            <div class="">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <a href="{{ URL::to('/Live-list') }}" class="category-heading" style="text-decoration: none; color: #fff;">
                                <h4 class="movie-title">  <b>Channel Live in:</b> {{{ $channel_slug }}}  </h4>
                            </a>
                        </div>

                        @if ($live->isNotEmpty())
                            <div class="favorites-contens">
                                <ul class="list-inline row p-0 mb-0">

                                    @if (isset($live))
                                        @forelse($live as $category_video)
                                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                                <div class="block-images position-relative">
                                                    <!-- block-images -->
                                                    <a href="{{ URL::to('live/' . $category_video->slug) }}">
                                                        <img src="{{ URL::to('public/uploads/images/'. $category_video->image)  }}" class="img-fluid" alt="Channel-Live-Image">
                                                    </a>

                                                    @if ($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if (!empty($category_video->ppv_price))
                                                            <!-- PPV price -->
                                                            <p class="p-tag1">
                                                                {{ $currency->symbol . ' ' . $category_video->ppv_price }}
                                                            </p>
                                                        @elseif(!empty($category_video->global_ppv || (!empty($category_video->global_ppv) && $category_video->ppv_price == null)))
                                                            <p class="p-tag1">
                                                                {{ $category_video->global_ppv . ' ' . $currency->symbol }}
                                                            </p>
                                                        @elseif($category_video->global_ppv == null && $category_video->ppv_price == null)
                                                            <p class="p-tag">
                                                                {{ 'Free' }}
                                                            </p>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a type="button" class="text-white btn-cl"
                                                            href="{{ URL::to('live/'.$category_video->slug ) }}">
                                                            <img class="ply" src="{{ URL::to('assets/img/default_play_buttons.svg') }}" />
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if ($ThumbnailSetting->title == 1)
                                                        <!-- Title -->
                                                        <h6>
                                                            {{ strlen($category_video->title) > 17 ? substr($category_video->title, 0, 18) . '...' : $category_video->title }}
                                                        </h6>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    @if ($ThumbnailSetting->duration == 1)
                                                        <!-- Duration -->
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $category_video->duration) ?>
                                                        </span>
                                                    @endif

                                                    @if ($ThumbnailSetting->rating == 1 && $category_video->rating != null)
                                                        <!-- Rating -->
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $category_video->rating }}
                                                        </span>
                                                    @endif

                                                    @if ($ThumbnailSetting->featured == 1 && $category_video->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    @if ($ThumbnailSetting->published_year == 1 && $category_video->year != null)
                                                        <!-- published_year -->
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ $category_video->year }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- Category Thumbnail  setting -->
                                                    <?php     
                                                        $CategoryThumbnail_setting = App\CategoryLive::join('live_categories', 'live_categories.id', '=', 'livecategories.category_id')
                                                            ->where('livecategories.live_id', $category_video->id)
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

                                            </li>
                                        @empty
                                        <div class="col-md-12 text-center mt-4"
                                            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                            <p>
                                            <h3 class="text-center">{{ __('No Data Available') }}</h3>
                                        </div>
                                        @endforelse
                                    @endif
                                </ul>

                                <div class="col-md-12 pagination justify-content-end">
                                    {!! $live->links() !!}
                                </div>
                            </div>
                        @else
                            <div class="col-md-12 text-center mt-4"
                                style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                <p>
                                <h3 class="text-center">{{ __('No Data Available') }}</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12 text-center mt-4">
                <h1 class="text-white text-center med">{{ __("No Data Available") }}</h1>
                <img class="no-data-img text-center w-100" src="{{ URL::to('/assets/img/watch.png') }}">
            </div>

        @endif
    </div>
</section>

<style>
    .no-data-img{width:45% !important;}
</style>
@php
    include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp
