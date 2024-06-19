@if (!Auth::guest())

    @php
        $Wishlist = App\Wishlist::where('user_id', Auth::user()->id)->where('type', 'channel')->pluck('video_id');

        $check_Kidmode = 0 ;

        $data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description',
                                        'expiry_date','active','status','draft')
                            ->where('active',1)
                            ->where('status', 1)
                            ->where('draft',1)
                            ->whereIn('id',$Wishlist);

        if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
        {
            $data = $data->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $check_Kidmode == 1 )
        {
            $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $data = $data->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url'] = $item->image != null ? URL::to('/public/uploads/images/'.$item->image) : default_vertical_image_url();
            $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url();
            $item['TV_image_url'] = $item->video_tv_image != null ? URL::to('public/uploads/images/'.$item->video_tv_image) : default_horizontal_image_url();
            $item['source_type'] = "Videos";
            return $item;
        });
    @endphp

@else
    @php
        $data = [];
    @endphp
@endif

@if(count($data) > 0)

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
  
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[37]->header_name ? URL::to('/').'/'.$order_settings_list[37]->url : '' }}">
                                {{ $order_settings_list[37]->header_name ? __($order_settings_list[37]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[37]->header_name ? URL::to('/').'/'.$order_settings_list[37]->url : '' }}">{{ __('View All') }}</a>
                            </h4>
                        @endif  
                    </div>
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $Wishlist_videos)
                                    @php
                                        $currentdate = date("M d , y H:i:s");
                                        date_default_timezone_set('Asia/Kolkata');
                                        $current_date = Date("M d , y H:i:s");
                                        $date = date_create($current_date);
                                        $currentdate = date_format($date, "D h:i");
                                        $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                                        
                                        if ($Wishlist_videos->publish_type == 'publish_later') {
                                            if ($currentdate < $publish_time) {
                                                $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                                            } else {
                                                $publish_time = 'Published';
                                            }
                                        } elseif ($Wishlist_videos->publish_type == 'publish_now') {
                                            $currentdate = date_format($date, "y M D");
                                            $publish_time = date("y M D", strtotime($Wishlist_videos->publish_time));
                                            if ($currentdate == $publish_time) {
                                                $publish_time = date("D h:i", strtotime($Wishlist_videos->publish_time));
                                            } else {
                                                $publish_time = 'Published';
                                            }
                                        } else {
                                            $publish_time = 'Published';
                                        }
                                    @endphp
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $Wishlist_videos->slug }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $Wishlist_videos->image ? URL::to('public/uploads/images/' . $Wishlist_videos->image) : $default_vertical_image_url }}" alt="{{ $Wishlist_videos->title }}">
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($Wishlist_videos->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break
                                                            @case($Wishlist_videos->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break
                                                            @case(!empty($Wishlist_videos->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $Wishlist_videos->ppv_price }}</p>
                                                            @break
                                                            @case(!empty($Wishlist_videos->global_ppv) && $Wishlist_videos->ppv_price == null)
                                                                <p class="p-tag">{{ $Wishlist_videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break
                                                            @case($Wishlist_videos->global_ppv == null && $Wishlist_videos->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $Wishlist_videos->slug }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $Wishlist_videos->player_image ? URL::to('public/uploads/images/' . $Wishlist_videos->player_image) : $default_vertical_image_url }}" alt="{{ $Wishlist_videos->title }}">

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($Wishlist_videos->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break
                                                            @case($Wishlist_videos->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break
                                                            @case(!empty($Wishlist_videos->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $Wishlist_videos->ppv_price }}</p>
                                                            @break
                                                            @case(!empty($Wishlist_videos->global_ppv) && $Wishlist_videos->ppv_price == null)
                                                                <p class="p-tag">{{ $Wishlist_videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break
                                                            @case($Wishlist_videos->global_ppv == null && $Wishlist_videos->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('category') . '/videos/' . $Wishlist_videos->slug }}" aria-label="movie">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($Wishlist_videos->title) > 17 ? substr($Wishlist_videos->title, 0, 18).'...' : $Wishlist_videos->title }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1 && !($Wishlist_videos->age_restrict == 0))
                                                                <div class="badge badge-secondary p-1 mr-2">{{ $Wishlist_videos->age_restrict.'+' }}</div>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $Wishlist_videos->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($Wishlist_videos->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($Wishlist_videos->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $Wishlist_videos->featured == 1)
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
                                                                $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                            ->where('categoryvideos.video_id',$Wishlist_videos->id)
                                                                            ->pluck('video_categories.name');        
                                                            @endphp
                                                            @if(($ThumbnailSetting->category == 1 ) && (count($CategoryThumbnail_setting) > 0))
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                    @php
                                                                        $Category_Thumbnail = [];
                                                                        foreach($CategoryThumbnail_setting as $CategoryThumbnail){
                                                                            $Category_Thumbnail[] = $CategoryThumbnail;
                                                                        }
                                                                        echo implode(', ', $Category_Thumbnail);
                                                                    @endphp
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>

                                                    <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $Wishlist_videos->slug }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/').'/assets/img/default_play_buttons.svg' }}" width="10%" height="10%" /> {{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endif
