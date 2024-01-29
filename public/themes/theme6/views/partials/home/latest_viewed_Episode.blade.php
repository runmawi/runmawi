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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[18]->url ? URL::to($order_settings_list[18]->url) : null }} ">{{ optional($order_settings_list[18])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $latest_view_episode)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('episode/'. $latest_view_episode->series_slug.'/'.$latest_view_episode->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                
                                            <div class="block-description">
                                                <p> {{ strlen($latest_view_episode->title) > 17 ? substr($latest_view_episode->title, 0, 18) . '...' : $latest_view_episode->title }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($latest_view_episode)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $latest_view_episode->duration != null ? gmdate('H:i:s', $latest_view_episode->duration) : null }}
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                            {{-- WatchLater & wishlist --}}

                                        @php
                                            $inputs = [
                                                'source_id'     => $latest_view_episode->id ,
                                                'type'          => null,  
                                                'wishlist_where_column'   => 'episode_id',
                                                'watchlater_where_column' => 'episode_id',
                                            ];
                                        @endphp

                                        {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!}
                    
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif