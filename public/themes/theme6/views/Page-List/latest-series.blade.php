
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[4]->header_name ? __($order_settings_list[4]->header_name) : '' }}
                    </h4>  
                </div>

                @if (($latest_series_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline p-0 mb-0 category-page-slider">
                            @forelse($latest_series_pagelist as $key => $latest_series)
                                <li class="slide-item">
                                    <a href="{{ URL::to('play_series/'.$latest_series->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $latest_series->image ? URL::to('public/uploads/images/' . $latest_series->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ strlen($latest_series->title) > 17 ? substr($latest_series->title, 0, 18) . '...' : $latest_series->title }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                    <span class="text-white"> 
                                                        {{ App\SeriesSeason::where('series_id',$latest_series->id)->count() . " Seasons" }}  
                                                        {{ App\Episode::where('series_id',$latest_series->id)->count() . " Episodes" }}  
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Play Now')}}
                                                    </span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $latest_series_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
