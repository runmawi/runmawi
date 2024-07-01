@php

// latest viewed Videos

$check_Kidmode = 0 ;

if(Auth::guest() != true ){

     $data =  App\RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
         ->where('recent_views.user_id',Auth::user()->id)
         ->groupBy('recent_views.video_id');

         if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
             $data = $data  ->whereNotIn('videos.id',Block_videos());
         }
         
         if( $videos_expiry_date_status == 1 ){
             $data = $data->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
         }

         if( !Auth::guest() && $check_Kidmode == 1 )
         {
             $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
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
                        <h2 class="main-title">
                            <a href="{{ $order_settings_list[15]->header_name ? URL::to('/') . '/' . $order_settings_list[15]->url : '' }}">
                                {{ $order_settings_list[15]->header_name ? __($order_settings_list[15]->header_name) : '' }}
                            </a>
                        </h2>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h2 class="main-title">
                                <a href="{{ $order_settings_list[15]->header_name ? URL::to('/') . '/' . $order_settings_list[15]->url : '' }}">
                                    {{ __('View All') }}
                                </a>
                            </h2>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="favorites-slider list-inline row p-0 mb-0">
                            @foreach($data as $latest_view_video)
                                @php
                                    $publish_time = 'Published';
                                    if (!empty($latest_view_video->publish_time)) {
                                        date_default_timezone_set('Asia/Kolkata');
                                        $current_date = date("M d, y H:i:s");
                                        $date = date_create($current_date);
                                        $currentdate = date_format($date, "D h:i");
                                        $publish_time_formatted = date("D h:i", strtotime($latest_view_video->publish_time));

                                        if ($latest_view_video->publish_type == 'publish_later' && $currentdate < $publish_time_formatted) {
                                            $publish_time = $publish_time_formatted;
                                        }
                                    }
                                @endphp

                                <div class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/' . $latest_view_video->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_video->image ? URL::to('/public/uploads/images/' . $latest_view_video->image) : $default_vertical_image_url }}" src="{{ $latest_view_video->image ? URL::to('/public/uploads/images/' . $latest_view_video->image) : $default_vertical_image_url }}" alt="{{ $latest_view_video->title }}">
                                                </a>
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($latest_view_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break

                                                        @case($latest_view_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break

                                                        @case(!empty($latest_view_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $latest_view_video->ppv_price }}</p>
                                                        @break

                                                        @case(!empty($latest_view_video->global_ppv) && $latest_view_video->ppv_price == null)
                                                            <p class="p-tag">{{ $latest_view_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break

                                                        @case($latest_view_video->global_ppv == null && $latest_view_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category/videos/' . $latest_view_video->slug) }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $latest_view_video->player_image ? URL::to('/public/uploads/images/' . $latest_view_video->player_image) : $default_vertical_image_url }}" src="{{ $latest_view_video->player_image ? URL::to('/public/uploads/images/' . $latest_view_video->player_image) : $default_vertical_image_url }}" alt="{{ $latest_view_video->title }}">
                                            </a>
                                            @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @switch(true)
                                                    @case($latest_view_video->access == 'subscriber')
                                                        <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                    @break
                                                    @case($latest_view_video->access == 'registered')
                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                    @break
                                                    @case(!empty($latest_view_video->ppv_price))
                                                        <p class="p-tag">{{ $currency->symbol . ' ' . $latest_view_video->ppv_price }}</p>
                                                    @break
                                                    @case(!empty($latest_view_video->global_ppv) && $latest_view_video->ppv_price == null)
                                                        <p class="p-tag">{{ $latest_view_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                    @break
                                                    @case($latest_view_video->global_ppv == null && $latest_view_video->ppv_price == null)
                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                    @break
                                                @endswitch
                                            @endif

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category/videos/' . $latest_view_video->slug) }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">{{ strlen($latest_view_video->title) > 17 ? substr($latest_view_video->title, 0, 18) . '...' : $latest_view_video->title }}</p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1 && !is_null($latest_view_video->age_restrict))
                                                            <div class="badge badge-secondary p-1 mr-2">{{ $latest_view_video->age_restrict . ' +' }}</div>
                                                        @endif
                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $latest_view_video->duration) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ __($latest_view_video->rating) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ __($latest_view_video->year) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $latest_view_video->featured == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $latest_view_video->id)
                                                                ->pluck('video_categories.name');
                                                        @endphp
                                                        @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('category/videos/' . $latest_view_video->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/') . '/assets/img/default_play_buttons.svg' }}" width="10%" height="10%"/>  {{ __('Watch Now') }}
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
