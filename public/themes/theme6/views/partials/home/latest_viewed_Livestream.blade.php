<?php

   // latest viewed Livestream

   if(Auth::guest() != true ){

    $data =  App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id',Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->get();
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
                        <h4 class="main-title"><a href="{{ $order_settings_list[16]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[16])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $key => $livestream_videos)
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
                                                'type'          => null,  
                                                'wishlist_where_column' =>'livestream_id',
                                                'watchlater_where_column'=>'live_id',
                                            ];
                                        @endphp

                                        {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}
                        
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