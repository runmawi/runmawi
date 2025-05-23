<?php

   // latest viewed Videos

   if(Auth::guest() != true ){

        $data =  App\RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
            ->where('recent_views.user_id',Auth::user()->id)
            ->groupBy('recent_views.video_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $data = $data  ->whereNotIn('videos.id',Block_videos());
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
                        <h4 class="main-title"><a href="{{ $order_settings_list[15]->url ? URL::to($order_settings_list[15]->url) : null }} ">{{ optional($order_settings_list[15])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $key => $latest_view_video)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('category/videos/'.$latest_view_video->slug ) }}">
                                            <div class="img-box">
                                                <img src="{{ $latest_view_video->image ? URL::to('public/uploads/images/'.$latest_view_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($latest_view_video->title) > 17 ? substr($latest_view_video->title, 0, 18) . '...' : $latest_view_video->title }}</p>
                                                
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    {{-- <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($latest_view_video)->age_restrict.'+' }}
                                                    </div> --}}

                                                    <span class="text-white">
                                                        @if($latest_view_video->duration != null)
                                                            @php
                                                                $duration = Carbon\CarbonInterval::seconds($latest_view_video->duration)->cascade();
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
                                                'source_id'     => $latest_view_video->id ,
                                                'type'          => 'channel',  // for videos - channel
                                                'wishlist_where_column'    => 'video_id',
                                                'watchlater_where_column'  => 'video_id',
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
