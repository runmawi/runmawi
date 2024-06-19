{{-- latest viewed audios --}}
@php

   // latest viewed Videos

   if(Auth::guest() != true ){

        $data =  App\RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
            ->where('recent_views.user_id',Auth::user()->id)
            ->groupBy('recent_views.audio_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $data = $data  ->whereNotIn('audio.id',Block_audios());
            }
            $data = $data->limit(15)->get();
   }
   else
   {
        $data = array() ;
   }

@endphp

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[17]->header_name ? url('/' . $order_settings_list[17]->url) : '' }}">
                                {{ $order_settings_list[17]->header_name ? __($order_settings_list[17]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[17]->header_name ? url('/' . $order_settings_list[17]->url) : '' }}">
                                    {{ __('View All') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach($data as $latest_view_audio)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_audio->image ? URL::to('public/uploads/images/' . $latest_view_audio->image) : $default_vertical_image_url }}" alt="{{ $latest_view_audio->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_audio->player_image ? URL::to('public/uploads/images/' . $latest_view_audio->player_image) : $default_vertical_image_url }}" alt="{{ $latest_view_audio->title }}">
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">{{ strlen($latest_view_audio->title) > 17 ? substr($latest_view_audio->title, 0, 18) . '...' : $latest_view_audio->title }}</p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1)
                                                            <div class="badge badge-secondary p-1 mr-2">{{ $latest_view_audio->age_restrict . ' +' }}</div>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_view_audio->duration) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ __($latest_view_audio->rating) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->published_year == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ __($latest_view_audio->year) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->featured == 1 && $latest_view_audio->featured == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </a>
                                                <a class="epi-name mt-5 mb-0 btn" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Play Now') }}
                                                </a>
                                            </div>
                                        </div>
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
