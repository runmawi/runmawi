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


    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[16]->header_name ? url('/') . '/' . $order_settings_list[16]->url : '' }}">
                                {{ $order_settings_list[16]->header_name ? __($order_settings_list[16]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title view-all">
                                <a href="{{ $order_settings_list[16]->header_name ? url('/') . '/' . $order_settings_list[16]->url : '' }}">
                                    {{ __('View all') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="latest-viewed-livestream home-sec list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $latest_view_livestreams)
                                    @php
                                        if (!empty($latest_view_livestreams->publish_time)) {
                                            $currentdate = now()->setTimezone('Asia/Kolkata')->format('D h:i');
                                            $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));

                                            if ($latest_view_livestreams->publish_type == 'publish_later') {
                                                $publish_time = $currentdate < $publish_time ? $publish_time : 'Published';
                                            } elseif ($latest_view_livestreams->publish_type == 'publish_now') {
                                                $currentdate = now()->setTimezone('Asia/Kolkata')->format('y M D');
                                                $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));
                                                $publish_time = $currentdate == $publish_time ? date("D h:i", strtotime($latest_view_livestreams->publish_time)) : 'Published';
                                            } else {
                                                $publish_time = 'Published';
                                            }
                                        } else {
                                            $currentdate = now()->setTimezone('Asia/Kolkata')->format('y M D');
                                            $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));
                                            $publish_time = $currentdate == $publish_time ? date("D h:i", strtotime($latest_view_livestreams->publish_time)) : 'Published';
                                        }
                                    @endphp

                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('live/'. $latest_view_livestreams->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_livestreams->image ? URL::to('public/uploads/images/'.$latest_view_livestreams->image) : $default_vertical_image_url }}" src="{{ $latest_view_livestreams->image ? URL::to('public/uploads/images/'.$latest_view_livestreams->image) : $default_vertical_image_url }}" alt="{{ $latest_view_livestreams->title }}">
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($latest_view_livestreams->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @elseif($latest_view_livestreams->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @elseif(!empty($latest_view_livestreams->ppv_price))
                                                            <p class="p-tag1">{{ $currency->symbol . ' ' . $latest_view_livestreams->ppv_price }}</p>
                                                        @elseif(!empty($latest_view_livestreams->global_ppv) && $latest_view_livestreams->ppv_price == null)
                                                            <p class="p-tag1">{{ $latest_view_livestreams->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @elseif($latest_view_livestreams->global_ppv == null && $latest_view_livestreams->ppv_price == null)
                                                            <p class="p-tag">Free</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('live/'. $latest_view_livestreams->slug) }}">
                                                    
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($latest_view_livestreams->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @elseif($latest_view_livestreams->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @elseif(!empty($latest_view_livestreams->ppv_price))
                                                            <p class="p-tag1">{{ $currency->symbol . ' ' . $latest_view_livestreams->ppv_price }}</p>
                                                        @elseif(!empty($latest_view_livestreams->global_ppv) && $latest_view_livestreams->ppv_price == null)
                                                            <p class="p-tag1">{{ $latest_view_livestreams->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @elseif($latest_view_livestreams->global_ppv == null && $latest_view_livestreams->ppv_price == null)
                                                            <p class="p-tag">Free</p>
                                                        @endif
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('live/'. $latest_view_livestreams->slug) }}" aria-label="movie">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($latest_view_livestreams->title) > 17 ? substr($latest_view_livestreams->title, 0, 18) . '...' : $latest_view_livestreams->title }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1 && !($latest_view_livestreams->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $latest_view_livestreams->age_restrict }}</span>
                                                            @endif
                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($latest_view_livestreams->duration / 3600) > 0 ? floor($latest_view_livestreams->duration / 3600) . 'h ' : '') . floor(($latest_view_livestreams->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($latest_view_livestreams->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($latest_view_livestreams->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $latest_view_livestreams->featured == 1)
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>


                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @php
                                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id', $latest_view_livestreams->id)
                                                                    ->pluck('video_categories.name');
                                                            @endphp

                                                            @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                    {{ $CategoryThumbnail_setting->implode(', ') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>

                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('live/'. $latest_view_livestreams->slug) }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endif


<script>
    var elem = document.querySelector('.latest-viewed-livestream');
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