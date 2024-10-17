<?php
   include(public_path('themes/default/views/header.php'));
   $ThumbnailSetting = App\ThumbnailSetting::first();
   $currency = App\CurrencySetting::first();
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
@media (max-width:728px){.row{margin-right: 0 !important;margin-left: 0 !important;}}
</style>

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title"><?php echo __(@$CategorySeries->name) ?></h4>
                </div>

                <!-- BREADCRUMBS -->
                <div class="d-flex">
                    <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('series.tv-shows') ?>"><?= ucwords('Series') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('SeriescategoryList') ?>"><?= ucwords('category') ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a
                                        class="black-text"><?php echo strlen($CategorySeries->name) > 50 ? ucwords(substr($CategorySeries->name, 0, 120) . '...') : ucwords($CategorySeries->name); ?>
                                    </a></li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if(count($SeriesGenre) > 0)

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 m-0">
                            <?php if(isset($SeriesGenre)) {
                            foreach($SeriesGenre as $latest_serie){ ?>

                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <div class="block-images position-relative">
                                    <!-- block-images -->
                                    <div class="border-bg">
                                        <div class="img-box">
                                            <a class="playTrailer" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $latest_serie->image ? URL::to('/public/uploads/images/' . $latest_serie->image) : $default_vertical_image_url }}"  alt="{{ $latest_serie->title }}">
                                            </a>
                                            @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($latest_serie->access == 'subscriber')
                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                @elseif($latest_serie->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @elseif(!empty($latest_serie->ppv_status))
                                                    <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_price }}</p>
                                                @elseif(!empty($latest_serie->ppv_status) || (!empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null))
                                                    <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_status }}</p>
                                                @elseif($latest_serie->ppv_status == null && $latest_serie->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="block-description">
                                        <a class="playTrailer" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                            @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($latest_serie->access == 'subscriber')
                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                @elseif($latest_serie->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @elseif(!empty($latest_serie->ppv_status))
                                                    <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_price }}</p>
                                                @elseif(!empty($latest_serie->ppv_status) || (!empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null))
                                                    <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_status }}</p>
                                                @elseif($latest_serie->ppv_status == null && $latest_serie->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                            @endif
                                        </a>
                                        <div class="hover-buttons text-white">
                                            <a class="text-white" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                <p class="epi-name text-left m-0 mt-2">{{ __($latest_serie->title) }}</p>
                                                  
                                                  @if($ThumbnailSetting->enable_description == 1)
                                                      <p class="desc-name text-left m-0 mt-1">
                                                          {{ strlen($latest_serie->description) > 75 ? substr(html_entity_decode(strip_tags($latest_serie->description)), 0, 75) . '...' : strip_tags($latest_serie->description) }}
                                                      </p>
                                                  @endif
                                                  
                                                  <div class="movie-time d-flex align-items-center my-2">

                                                      @if($ThumbnailSetting->age == 1 && !($latest_serie->age_restrict == 0))
                                                          <span class="position-relative p-1 mr-2">{{ $latest_serie->age_restrict}}</span>
                                                      @endif

                                                      @if($ThumbnailSetting->published_year == 1 && !($latest_serie->year == 0))
                                                          <span class="position-relative p-1 mr-2">
                                                              {{ __($latest_serie->year) }}
                                                          </span>
                                                      @endif
                                                      @if($ThumbnailSetting->featured == 1 && $latest_serie->featured == 1)
                                                          <span class="position-relative text-white">
                                                              {{ __('Featured') }}
                                                          </span>
                                                      @endif
                                                  </div>

                                                  <div class="movie-time d-flex align-items-center my-2">
                                                      <span class="position-relative  p-1 mr-2">
                                                          @php
                                                              $SeriesSeason = App\SeriesSeason::where('series_id', $latest_serie->id)->count();
                                                              echo $SeriesSeason . ' Season';
                                                          @endphp
                                                      </span>
                                                      <span class="position-relative  p-1 mr-2">

                                                          @php
                                                              $Episode = App\Episode::where('series_id', $latest_serie->id)->count();
                                                              echo $Episode . ' Episodes';
                                                          @endphp
                                                      </span>
                                                    <!--<span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $latest_serie->duration) }}</span>-->
                                                </div>
                                            </a>
                                            <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <?php } } ?>
                        </ul>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <h3 class="text-center no-more-cont">{{ __('There is no content available in this category.') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/default/views/footer.blade.php'));
   ?>