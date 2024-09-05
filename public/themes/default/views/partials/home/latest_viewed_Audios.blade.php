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
                            <h4 class="main-title view-all">
                                <a href="{{ $order_settings_list[17]->header_name ? url('/' . $order_settings_list[17]->url) : '' }}">
                                    {{ __('View all') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="last-viewed-audio home-sec list-inline row p-0 mb-0">
                            @foreach($data as $latest_view_audio)
                                <div class="items">
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
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Play Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

@endif


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
 </script>