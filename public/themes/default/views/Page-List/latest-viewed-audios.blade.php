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
                    </div>
                    @if (($latestViewed_audio_pagelist)->isNotEmpty())
                    <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                            @foreach($data as $latest_view_audio)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_audio->image ? URL::to('public/uploads/images/' . $latest_view_audio->image) : $default_vertical_image_url }}" src="{{ $latest_view_audio->image ? URL::to('public/uploads/images/' . $latest_view_audio->image) : $default_vertical_image_url }}" alt="{{ $latest_view_audio->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_audio->player_image ? URL::to('public/uploads/images/' . $latest_view_audio->player_image) : $default_vertical_image_url }}" src="{{ $latest_view_audio->player_image ? URL::to('public/uploads/images/' . $latest_view_audio->player_image) : $default_vertical_image_url }}" alt="{{ $latest_view_audio->title }}">
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">{{ strlen($latest_view_audio->title) > 17 ? substr($latest_view_audio->title, 0, 18) . '...' : $latest_view_audio->title }}</p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1 && !($latest_view_audio->age_restrict == 0))
                                                        <span class="position-relative badge p-1 mr-2">{{ $latest_view_audio->age_restrict }}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                        <span class="position-relative text-white mr-2">
                                                            {{ (floor($latest_view_audio->duration / 3600) > 0 ? floor($latest_view_audio->duration / 3600) . 'h ' : '') . floor(($latest_view_audio->duration % 3600) / 60) . 'm' }}
                                                        </span>
                                                        @endif

                                                        @if($ThumbnailSetting->published_year == 1 && !($latest_view_audio->year == 0))
                                                        <span class="position-relative badge p-1 mr-2">
                                                            {{ __($latest_view_audio->year) }}
                                                        </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $latest_view_audio->featured == 1)
                                                        <span class="position-relative text-white">
                                                           {{ __('Featured') }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                
                                                </a>
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ url('audio/' . $latest_view_audio->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Play Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                        <p>
                                        <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                                    </div>
                            @endforeach
                            </ul>
                            <div class="col-md-12 pagination justify-content-end">
                                {!! $latestViewed_audio_pagelist->links() !!}
                            </div>
                    </div>
                    @else
                        <div class="col-md-12 text-center mt-4"
                            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                            <p>
                            <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endif

<!-- 
<script>
    var elem = document.querySelector('.last-viewed-audio');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
 </script> -->