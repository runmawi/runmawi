
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[3]->header_name ? __($order_settings_list[3]->header_name) : '' }}
                    </h4>  
                </div>

                @if (($live_list_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline p-0 mb-0 category-page-slider">
                            @forelse($live_list_pagelist as $key => $livestream_videos)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($livestream_videos->title) > 17 ? substr($livestream_videos->title, 0, 18) . '...' : $livestream_videos->title }}</p>
                                                
                                                <div class="movie-time d-flex align-items-center my-2">
                                                    {{-- <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($livestream_videos)->age_restrict.'+' }}
                                                    </div> --}}

                                                    <span class="text-white">
                                                        @if($livestream_videos->duration != null)
                                                            @php
                                                                $duration = Carbon\CarbonInterval::seconds($livestream_videos->duration)->cascade();
                                                                $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                $minutes = $duration->format('%imin');
                                                            @endphp
                                                            {{ $hours }}{{ $minutes }}
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Play Now')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                            {{-- WatchLater & wishlist --}}

                                            {{-- @php
                                                $inputs = [
                                                    'source_id'     => $livestream_videos->id ,
                                                    'type'          => null ,
                                                    'wishlist_where_column' =>'livestream_id',
                                                    'watchlater_where_column'=>'live_id',
                                                ];
                                            @endphp

                                            {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}

                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $live_list_pagelist->links() !!}
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
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
