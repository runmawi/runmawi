@php
    $check_Kidmode = 0 ;

    $data = App\VideoCategory::query()->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })

    ->with(['category_videos' => function ($videos) use ($check_Kidmode) {
        $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
            ->where('videos.active', 1)
            ->where('videos.status', 1)
            ->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $videos->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $videos->latest('videos.created_at')->get();
    }])
    ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
    ->where('video_categories.in_home', 1)
    ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })
    ->orderBy('video_categories.order')
    ->get()
    ->map(function ($category) {
        $category->category_videos->map(function ($video) {
            $video->image_url = URL::to('/public/uploads/images/'.$video->image);
            $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
            return $video;
        });
        $category->source =  "category_videos" ;
        return $category;
    });
@endphp


@if (!empty($data) && $data->isNotEmpty())
    @foreach( $data as $key => $video_category )
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ optional($video_category)->name }}</a></h4>
                            <h4 class="main-title"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ 'view all' }}</a></h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @if (!Auth::guest() && !empty($data['password_hash']))
                                    @php $id = Auth::user()->id; @endphp
                                @else
                                    @php $id = 0; @endphp
                                @endif

                                @if(isset($video_category))
                                    @foreach($video_category->category_videos as $videos )
                                        @php
                                            $currentdate = date("M d , y H:i:s");
                                            date_default_timezone_set('Asia/Kolkata');
                                            $current_date = Date("M d , y H:i:s");
                                            $date = date_create($current_date);
                                            $currentdate = date_format($date, "D h:i");
                                            $publish_time = date("D h:i", strtotime($videos->publish_time));
                                            if ($videos->publish_type == 'publish_later')
                                            {
                                                if ($currentdate < $publish_time)
                                                {
                                                    $publish_time = date("D h:i", strtotime($videos->publish_time));
                                                }
                                                else
                                                {
                                                    $publish_time = 'Published';
                                                }
                                            }
                                            elseif ($videos->publish_type == 'publish_now')
                                            {
                                                $currentdate = date_format($date, "y M D");
                                                $publish_time = date("y M D", strtotime($videos->publish_time));
                                                if ($currentdate == $publish_time)
                                                {
                                                    $publish_time = 'Today'.' '.date("h:i", strtotime($videos->publish_time));
                                                }
                                                else
                                                {
                                                    $publish_time = 'Published';
                                                }
                                            }
                                            else
                                            {
                                                $publish_time = '';
                                            }
                                        @endphp 
                                        <li class="slide-item">
                                            <div class="block-images position-relative">
                                                <div class="border-bg">
                                                    <div class="img-box">
                                                        <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            <img class="img-fluid w-100" loading="lazy" data-src="{{ $videos->image ? URL::to('public/uploads/images/'.$videos->image) : $default_vertical_image_url }}" src="{{ $videos->image ? URL::to('public/uploads/images/'.$videos->image) : $default_vertical_image_url }}" alt="{{ $videos->title }}">
                                                        </a>

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                                @if($videos->access == 'subscriber')
                                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                                @elseif($videos->access == 'registered')
                                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                                @elseif(!empty($videos->ppv_price))
                                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                                @elseif(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                   {{ $currency->symbol . ' ' . $videos->global_ppv }}</p>
                                                                @elseif(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                                @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="block-description">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $videos->player_image ? URL::to('public/uploads/images/'.$videos->player_image) : $default_vertical_image_url }}" src="{{ $videos->player_image ? URL::to('public/uploads/images/'.$videos->player_image) : $default_vertical_image_url }}" alt="{{ $videos->title }}">

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                            @if($videos->access == 'subscriber')
                                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                            @elseif($videos->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @elseif(!empty($videos->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                            @elseif(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $videos->global_ppv }}</p>
                                                            @elseif(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @endif
                                                        @endif
                                                    </a>

                                                    <div class="hover-buttons text-white">
                                                        <a href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            @if($ThumbnailSetting->title == 1)
                                                                <p class="epi-name text-left m-0">
                                                                    {{ strlen($videos->title) > 17 ? substr($videos->title, 0, 18) . '...' : $videos->title }}
                                                                </p>
                                                            @endif
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->age == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">{{ $videos->age_restrict . ' ' . '+' }}</div>
                                                                @endif
                                                                @if($ThumbnailSetting->duration == 1)
                                                                    <span class="text-white">
                                                                        <i class="fa fa-clock-o"></i>
                                                                        {{ gmdate('H:i:s', $videos->duration) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                                <div class="movie-time d-flex align-items-center pt-1">
                                                                    @if($ThumbnailSetting->rating == 1)
                                                                        <div class="badge badge-secondary p-1 mr-2">
                                                                            <span class="text-white">
                                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                                {{ __($videos->rating) }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                    @if($ThumbnailSetting->published_year == 1)
                                                                        <div class="badge badge-secondary p-1 mr-2">
                                                                            <span class="text-white">
                                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                                {{ __($videos->year) }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                    @if($ThumbnailSetting->featured == 1 && $videos->featured == 1)
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
                                                                        ->where('categoryvideos.video_id', $videos->video_id)
                                                                        ->pluck('video_categories.name');
                                                                @endphp
                                                                @if ($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                    <span class="text-white">
                                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                        @php
                                                                            $Category_Thumbnail = [];
                                                                            foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                                $Category_Thumbnail[] = $CategoryThumbnail;
                                                                            }
                                                                            echo implode(',' . ' ', $Category_Thumbnail);
                                                                        @endphp
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </a>

                                                        <a type="button" class="epi-name mt-3 mb-0 btn" href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> {{ __('Watch Now') }} 
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif