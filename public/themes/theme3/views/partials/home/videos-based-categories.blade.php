<?php 
    $check_Kidmode = 0 ;

    $data = App\VideoCategory::query()->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)
              ->where('videos.status', 1)
              ->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })

    ->with(['category_videos' => function ($videos) use ($check_Kidmode) {
        $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict', 'player_image', 'description', 'videos.trailer', 'videos.trailer_type')
            ->where('videos.active', 1)
            ->where('videos.status', 1)
            ->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $videos->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $videos->latest('videos.created_at');
    }])
    ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
    ->where('video_categories.in_home', 1)
    ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)
              ->where('videos.status', 1)
              ->where('videos.draft', 1);

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
        $category->category_videos = $category->category_videos->take(15);

        $category->category_videos->map(function ($video) {
            $video->image_url = URL::to('/public/uploads/images/' . $video->image);
            $video->Player_image_url = URL::to('/public/uploads/images/' . $video->player_image);
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
                            <ul class="favorites-slider list-inline p-0 mb-0">
                                @foreach ($video_category->category_videos as $key => $latest_video)
                                    <li class="slide-item">
                                            <div class="block-images position-relative">
                                                <a href="{{ $latest_video->image ? URL::to('category/videos/'.$latest_video->slug ) : default_vertical_image_url() }}">
                                                
                                                    <div class="img-box">
                                                        <img src="{{  URL::to('public/uploads/images/'.$latest_video->image) }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="block-description">
                                                        

                                                        <div class="hover-buttons">
                                                            <a class="" href="{{ $latest_video->image ? URL::to('category/videos/'.$latest_video->slug ) : default_vertical_image_url() }}">
                                                                <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                    <span class="text pr-2"> Play </span>
                                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                    </svg>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </a>

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
    @endforeach
@endif