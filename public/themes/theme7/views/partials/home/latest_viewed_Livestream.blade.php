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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[16]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[16])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $livestream_videos)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}">
                                                <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </a>
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