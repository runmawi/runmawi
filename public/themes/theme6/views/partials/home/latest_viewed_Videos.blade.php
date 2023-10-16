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

@if (!empty($data))

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[15]->url ? URL::to($order_settings_list[15]->url) : null }} ">{{ optional($order_settings_list[15])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $latest_view_video)
                                <li class="slide-item">
                                    <a href="{{ URL::to('category/videos/'.$latest_view_video->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{  URL::to('public/uploads/images/'.$latest_view_video->image) }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($latest_view_video->title) > 17 ? substr($latest_view_video->title, 0, 18) . '...' : $latest_view_video->title }}
                                                </h6>
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($latest_view_video)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $latest_view_video->duration != null ? gmdate('H:i:s', $latest_view_video->duration) : null }}
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
                                                    <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li>
                                                </ul>
                                            </div>
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
