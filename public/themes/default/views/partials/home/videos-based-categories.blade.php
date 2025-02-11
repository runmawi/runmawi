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
        <section id="iq-trending iq-favorites-{{ $key }}">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ optional($video_category)->name }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h5 class="main-title view-all"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ 'View all' }}</a></h5>
                            @endif 
                           
                        </div>

                        <div class="favorites-contens">
                            <div class="video-based-categories home-sec list-inline row p-0 mb-0" id="video-category-{{ $key }}">
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
                                        <div class="items">
                                            <div class="block-images position-relative">
                                                <div class="border-bg">
                                                    <div class="img-box">
                                                        <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}" aria-label="VideoBasedPlayTrailer">
                                                            <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $videos->image ? URL::to('public/uploads/images/'.$videos->image) : $default_vertical_image_url }}" alt="{{ $videos->title }}" loading="lazy">
                                                        </a>

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                                @switch(true)
                                                                    @case($videos->access == 'subscriber')
                                                                        <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                    @break
                                                                    @case($videos->access == 'registered')
                                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                                    @break
                                                                    @case(!empty($videos->ppv_price))
                                                                        <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                                    @break
                                                                    @case(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                        <p class="p-tag">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                                    @break
                                                                    @case(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                                    @break
                                                                @endswitch
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="block-description">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}" aria-label="VideoBasedPlayTrailer">

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                            @switch(true)
                                                                @case($videos->access == 'subscriber')
                                                                    <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                @break
                                                                @case($videos->access == 'registered')
                                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                                @break
                                                                @case(!empty($videos->ppv_price))
                                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                                @break
                                                                @case(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                    <p class="p-tag">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                                @break
                                                                @case(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                                @break
                                                            @endswitch
                                                        @endif

                                                    <div class="hover-buttons text-white">
                                                        <a href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            @if($ThumbnailSetting->title == 1)
                                                                <p class="epi-name text-left m-0 mt-2">
                                                                    {{ strlen($videos->title) > 17 ? substr($videos->title, 0, 18) . '...' : $videos->title }}
                                                                </p>
                                                            @endif

                                                            @if($ThumbnailSetting->enable_description == 1)
                                                                <p class="desc-name text-left m-0 mt-1">
                                                                    {{ strlen($videos->description) > 75 ? substr(html_entity_decode(strip_tags($videos->description)), 0, 75) . '...' : strip_tags($videos->description) }}
                                                                </p>
                                                            @endif

                                                            <div class="movie-time d-flex align-items-center pt-2">
                                                                @if($ThumbnailSetting->age == 1 && !($videos->age_restrict == 0))
                                                                    <span class="position-relative badge p-1 mr-2">{{ $videos->age_restrict}}</span>
                                                                @endif
                                                                @if($ThumbnailSetting->duration == 1)
                                                                    <span class="position-relative text-white mr-2">
                                                                        {{ (floor($videos->duration / 3600) > 0 ? floor($videos->duration / 3600) . 'h ' : '') . floor(($videos->duration % 3600) / 60) . 'm' }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->published_year == 1 && !($videos->year == 0))
                                                                    <span class="position-relative badge p-1 mr-2">
                                                                        {{ __($videos->year) }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->featured == 1 && $videos->featured == 1)
                                                                    <span class="position-relative text-white">
                                                                    {{ __('Featured') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @php
                                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                        ->where('categoryvideos.video_id', $videos->video_id)
                                                                        ->pluck('video_categories.name');
                                                                @endphp
                                                                @if ($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                    <span class="text-white">
                                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                        {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </a>

                                                        <a type="button" class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category/videos/'.$videos->slug) }}">
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
    @endforeach
@endif

<script>
    document.querySelectorAll('.video-based-categories').forEach(function(elem) {
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: true,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad:true,
        });
    });
</script>