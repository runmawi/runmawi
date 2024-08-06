
@php
    include public_path("themes/theme6/views/header.php");
@endphp

<section id="iq-favorites">
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[1]->header_name ? __($order_settings_list[1]->header_name) : '' }}
                    </h4>  
                </div>

                @if (($latest_videos_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($latest_videos_pagelist as $key => $latest_video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        
                                        <a href="{{ URL::to('category/videos/'.$latest_video->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <span> {{ strlen($latest_video->title) > 17 ? substr($latest_video->title, 0, 18) . '...' : $latest_video->title }}
                                                </span>
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <!-- <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($latest_video)->age_restrict.'+' }}
                                                    </div> -->

                                                    <span class="text-white">
                                                        @if($latest_video->duration != null)
                                                            @php
                                                                $duration = Carbon\CarbonInterval::seconds($latest_video->duration)->cascade();
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
                                                'source_id'     => $latest_video->id ,
                                                'type'          => 'channel',  // for videos - channel
                                                'wishlist_where_column'    => 'video_id',
                                                'watchlater_where_column'  => 'video_id',
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
                            {!! $latest_videos_pagelist->links() !!}
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
<?php include public_path("themes/theme6/views/footer.blade.php"); ?>
