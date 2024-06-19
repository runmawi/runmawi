<?php  

if (!Auth::guest()) {
   
    $Watchlater = App\Watchlater::where('user_id', Auth::user()->id)->where('type', 'channel')->pluck('video_id');

    $check_Kidmode = 0 ;

    $data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                    'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description',
                                    'expiry_date','active','status','draft')

    ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$Watchlater);

    if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
    {
        $data = $data->whereNotIn('videos.id',Block_videos());
    }

    if( !Auth::guest() && $check_Kidmode == 1 )
    {
        $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
    }

    $data = $data->latest()->limit(30)->get()->map(function ($item) {
        $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  default_vertical_image_url() ;
        $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  default_horizontal_image_url() ;
        $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  default_horizontal_image_url() ;
        $item['source_type']        = "Videos" ;
        return $item;
    });
}else{
    $data = [];
}

?>
@if(count($data) > 0)

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[36]->header_name ? url('/' . $order_settings_list[36]->url) : '' }}">
                                {{ $order_settings_list[36]->header_name ? __($order_settings_list[36]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[36]->header_name ? url('/' . $order_settings_list[36]->url) : '' }}">
                                    {{ __('View All') }}
                                </a>
                            </h4>
                        @endif  
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach($data as $watchlater_video)
                                @php
                                    $currentdate = now()->format("D h:i");
                                    $publish_time = 'Published';
                                    $publishType = $watchlater_video->publish_type;
                                    $publishDate = $watchlater_video->publish_time ? $watchlater_video->publish_time->format('D h:i') : 'Published';

                                    if ($publishType == 'publish_later' && $currentdate < $publishDate) {
                                        $publish_time = $publishDate;
                                    } elseif ($publishType == 'publish_now' && now()->format("y M D") == $publishDate) {
                                        $publish_time = $publishDate;
                                    }
                                @endphp
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->image ? URL::to('public/uploads/images/' . $watchlater_video->image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">

                                                </a>
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->player_image ? URL::to('public/uploads/images/' . $watchlater_video->player_image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">
                                                

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('category/videos/' . $watchlater_video->slug) }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">
                                                            {{ strlen($watchlater_video->title) > 17 ? substr($watchlater_video->title, 0, 18) . '...' : $watchlater_video->title }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1 && !($watchlater_video->age_restrict == 0))
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                {{ $watchlater_video->age_restrict . ' +' }}
                                                            </div>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $watchlater_video->duration) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ __($watchlater_video->rating) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->published_year == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ __($watchlater_video->year) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1)
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
                                                                ->where('categoryvideos.video_id', $watchlater_video->id)
                                                                ->pluck('video_categories.name');
                                                        @endphp
                                                        @if($ThumbnailSetting->category == 1 && $CategoryThumbnail_setting->isNotEmpty())
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                {{ $CategoryThumbnail_setting->implode(', ') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-1 mb-0 btn" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"> {{ __('Watch Now') }}
                                                </a>
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
