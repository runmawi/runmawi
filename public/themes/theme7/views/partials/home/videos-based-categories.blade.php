<?php 
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
?>

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
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($video_category->category_videos as $key => $latest_video)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="{{ $latest_video->image ? URL::to('category/videos/'.$latest_video->slug ) : default_vertical_image_url() }}">
                                                    <img src="{{  URL::to('public/uploads/images/'.$latest_video->image) }}" class="img-fluid" alt="">
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
    @endforeach
@endif