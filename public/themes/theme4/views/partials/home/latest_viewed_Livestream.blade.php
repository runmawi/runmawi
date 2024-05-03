<?php

   // latest viewed Livestream

   if(Auth::guest() != true ){

    $data =  App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id',Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->limit(15)
        ->get();
   }
   else
   {
        $data = array() ;
   }

?>

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-upcoming-movie">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[16]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[16])->header_name }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $key => $livestream_videos)
                                <li class="slick-slide">
                                    <a href="javascript:;">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="latest_view_episode">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider theme4-slider">
                            @foreach ($data as $key => $livestream_videos)
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <div class="caption pl-4">

                                                        <h2 class="caption-h2"> {{ strlen($livestream_videos->title) > 17 ? substr($livestream_videos->title, 0, 18) . '...' : $livestream_videos->title }}</h2>

                                                        
                                                        @if (optional($livestream_videos)->description)
                                                            <div class="trending-dec">{!! html_entity_decode( optional($livestream_videos)->description) !!}</div>
                                                        @endif

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                <!-- <a href="{{ URL::to('category/videos/'.$latest_view_video->slug ) }}" class="btn btn-hover button-groups mr-2" tabindex="0" ><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> -->
                                                                <!-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-viewed_videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> -->
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->player_image) : default_vertical_image_url() }}" class="img-fluid" alt="latest_view_episode">
                                                        </div>
                                                    </div>
                                                </div>
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