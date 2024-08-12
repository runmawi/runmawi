<?php

   // latest viewed Videos

   if(Auth::guest() != true ){

        $data =  App\RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
            ->where('recent_views.user_id',Auth::user()->id)
            ->groupBy('recent_views.audio_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $data = $data  ->whereNotIn('audio.id',Block_audios());
            }
            $data = $data->get();
   }
   else
   {
        $data = array() ;
   }

?>

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[17]->url ? URL::to($order_settings_list[17]->url) : null }} ">{{ optional($order_settings_list[17])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $key => $audios_details)
                                <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <a href="{{ URL::to('audio/'.$audios_details->slug ) }}">

                                                <div class="img-box">
                                                    <img src="{{  $audios_details->image ? URL::to('public/uploads/images/'.$audios_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <p> {{ strlen($audios_details->title) > 17 ? substr($audios_details->title, 0, 18) . '...' : $audios_details->title }}</p>
                                                    
                                                    <div class="movie-time d-flex align-items-center my-2">

                                                        {{-- <div class="badge badge-secondary p-1 mr-2">
                                                            {{ optional($audios_details)->age_restrict.'+' }}
                                                        </div> --}}

                                                        <span class="text-white">
                                                            @if($audios_details->duration != null)
                                                                @php
                                                                    $duration = Carbon\CarbonInterval::seconds($audios_details->duration)->cascade();
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
                                                            Play Now
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>

                                                {{-- WatchLater & wishlist --}}

                                            {{-- @php
                                                $inputs = [
                                                    'source_id'     => $audios_details->id ,
                                                    'type'          => null ,  
                                                    'wishlist_where_column'    => 'audio_id',
                                                    'watchlater_where_column'  => 'audio_id',
                                                ];
                                            @endphp

                                            {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}
                                            
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif