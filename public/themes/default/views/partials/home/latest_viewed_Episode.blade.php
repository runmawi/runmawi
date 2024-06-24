<?php

// latest viewed Videos

if (Auth::guest() != true) {
    $data = App\RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
        ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
        ->join('series', 'series.id', '=', 'episodes.series_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.episode_id')
        ->get();
} else {
    $data = [];
}

?>

@if (!empty($data) && $data->isNotEmpty())


    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[18]->header_name ? url('/') . '/' . $order_settings_list[18]->url : '' }}">
                                {{ $order_settings_list[18]->header_name ? __($order_settings_list[18]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[18]->header_name ? url('/') . '/' . $order_settings_list[18]->url : '' }}">
                                    {{ __('View All') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $latest_view_episode)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}">
                                                        <img class="img-fluid w-100" loading="lazy" src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}" data-src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}" alt="{{ $latest_view_episode->title }}">
                                                    </a>
                                                </div>
                                            </div>
                                                    
                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}">
                                                    <img class="img-fluid w-100" loading="lazy" src="{{ $latest_view_episode->player_image ? URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_vertical_image_url }}" data-src="{{ $latest_view_episode->player_image ? URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_vertical_image_url }}" alt="{{ $latest_view_episode->title }}">
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($latest_view_episode->title) > 17 ? substr($latest_view_episode->title, 0, 18) . '...' : $latest_view_episode->title }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">{{ $latest_view_episode->age_restrict . ' +' }}</div>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $latest_view_episode->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($latest_view_episode->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($latest_view_episode->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $latest_view_episode->featured == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </a>
                                                
                                                    <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ url('assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> Watch Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

@endif