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
                <div class="row d-flex">
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

                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        <?php if(isset($SeriesGenre)) {
                        foreach($SeriesGenre as $Series_Genre){ ?>

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <div class="block-images position-relative">
                                <!-- block-images -->
                                <div class="border-bg">
                                    <div class="img-box">
                                        <a class="playTrailer" href="<?php echo URL::to('/play_series/'.$Series_Genre->slug ) ?>">
                                            <img class="img-fluid w-100" loading="lazy" src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Genre->image;  ?>" alt="genre">
                                        </a>
                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                            @switch(true)
                                                @case($Series_Genre->access == 'subscriber')
                                                    <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                @break

                                                @case($Series_Genre->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @break

                                                @case(!empty($Series_Genre->ppv_price))
                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $Series_Genre->ppv_price }}</p>
                                                @break

                                                @case(!empty($Series_Genre->global_ppv) || (!empty($Series_Genre->global_ppv) && $Series_Genre->ppv_price == null))
                                                    <p class="p-tag">{{ $Series_Genre->global_ppv . ' ' . $currency->symbol }}</p>
                                                @break

                                                @case($Series_Genre->global_ppv == null && $Series_Genre->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @break
                                            @endswitch
                                        @endif
                                    </div>
                                </div>
                                <div class="block-description">
                                    <a class="playTrailer" href="{{ url('play_series/' . $Series_Genre->slug) }}">
                                        {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $Series_Genre->image ? URL::to('public/uploads/images/' . $Series_Genre->player_image) : $default_vertical_image_url }}" src="{{ $Series_Genre->image ? URL::to('public/uploads/images/' . $Series_Genre->player_image) : $default_vertical_image_url }}" alt="{{ $Series_Genre->title }}"> --}}
                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                            @switch(true)
                                                @case($Series_Genre->access == 'subscriber')
                                                    <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                @break

                                                @case($Series_Genre->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @break

                                                @case(!empty($Series_Genre->ppv_price))
                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $Series_Genre->ppv_price }}</p>
                                                @break

                                                @case(!empty($Series_Genre->global_ppv) || (!empty($Series_Genre->global_ppv) && $Series_Genre->ppv_price == null))
                                                    <p class="p-tag">{{ $Series_Genre->global_ppv . ' ' . $currency->symbol }}</p>
                                                @break

                                                @case($Series_Genre->global_ppv == null && $Series_Genre->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @break
                                            @endswitch
                                        @endif
                                    </a>

                                    <div class="hover-buttons text-white">
                                        <a href="{{ url('play_series/' . $Series_Genre->slug) }}">
                                            @if($ThumbnailSetting->title == 1)
                                                <!-- Title -->
                                                <p class="epi-name text-left mt-2 m-0">
                                                    {{ strlen($Series_Genre->title) > 17 ? substr($Series_Genre->title, 0, 18) . '...' : $Series_Genre->title }}
                                                </p>
                                            @endif

                                            @if($ThumbnailSetting->enable_description == 1)
                                                <p class="desc-name text-left m-0 mt-1">
                                                    {{ strlen($Series_Genre->description) > 75 ? substr(html_entity_decode(strip_tags($Series_Genre->description)), 0, 75) . '...' : strip_tags($Series_Genre->description) }}
                                                </p>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-2">
                                                @if($ThumbnailSetting->age == 1 && !($Series_Genre->age_restrict == 0))
                                                    <span class="position-relative badge p-1 mr-2">{{ $Series_Genre->age_restrict }}</span>
                                                @endif

                                                @if($ThumbnailSetting->duration == 1 && is_null($ThumbnailSetting->duration))
                                                    <span class="position-relative text-white mr-2">
                                                        {{ (floor($Series_Genre->duration / 3600) > 0 ? floor($Series_Genre->duration / 3600) . 'h ' : '') . floor(($Series_Genre->duration % 3600) / 60) . 'm' }}
                                                    </span>
                                                @endif
                                                @if($ThumbnailSetting->published_year == 1 && !($Series_Genre->year == 0))
                                                    <span class="position-relative badge p-1 mr-2">
                                                        {{ __($Series_Genre->year) }}
                                                    </span>
                                                @endif
                                                @if($ThumbnailSetting->featured == 1 && $Series_Genre->featured == 1)
                                                    <span class="position-relative text-white">
                                                       {{ __('Featured') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>

                                        <a class="epi-name mt-2 mb-0 btn" type="button" href="{{ URL::to('play_series/'.$Series_Genre->slug) }}">
                                            <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                        </a>
                                    </div>
                                </div>

                                    
                            </div>
                        </li>

                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/default/views/footer.blade.php'));
   ?>