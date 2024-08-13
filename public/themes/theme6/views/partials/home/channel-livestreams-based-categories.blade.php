<?php

$data = App\LiveCategory::query()->limit(15)
    ->whereHas('category_livestream', function ($query) use ($channel_partner) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1)->where('live_streams.user_id', $channel_partner->id)->where('live_streams.uploaded_by','Channel');
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) use ($channel_partner) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 
                        'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 
                        'live_streams.description','live_streams.recurring_program','live_streams.program_start_time','live_streams.program_end_time','live_streams.recurring_timezone',
                        'live_streams.custom_start_program_time','live_streams.recurring_timezone','live_streams.user_id','live_streams.uploaded_by')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->where('live_streams.user_id', $channel_partner->id)
                ->where('live_streams.uploaded_by','Channel')
                ->latest('live_streams.created_at')
                ->limit(15);
        },
    ])
    ->select('live_categories.id', 'live_categories.name', 'live_categories.slug', 'live_categories.order')
    ->orderBy('live_categories.order')
    ->get();

$data->each(function ($category) {
    $category->category_livestream->transform(function ($item) {
        $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
        $item['description'] = $item->description;
        $item['source'] = 'Livestream';
        return $item;
    });
    $category->source = 'live_category';
    return $category;
});

?>
@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $live_Category )
        @php
            $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
        @endphp

        <section id="iq-favorites">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 ">
                                
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <!-- <h4 class="main-title"><a href="{{ URL::to('home') }}">Latest Videos</a></h4> -->
                            <a href="{{ URL::to('/live/category/') . '/' . $live_Category->slug }}" class="category-heading" style="text-decoration:none;color:#fff">
                                <h4 class="movie-title">
                                    @if(!empty($live_Category->home_genre))
                                        {{ __('Live') . ' ' . __($live_Category->home_genre) }}
                                    @else
                                        {{ __('Live') . ' ' . __($live_Category->name) }}
                                    @endif
                                </h4>
                            </a>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title">
                                    <a href="{{ URL::to('/live/category/') . '/' . $live_Category->slug }}">{{ __('View All') }}</a>
                                </h4>
                            @endif
                        </div>

                        <div class="favorites-contens">
                            <div class="favorites-slider list-inline">
                                @php
                                    $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
                                @endphp

                                @foreach ($live_Category->category_livestream as $livestream_videos )
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <a href="{{ URL::to('live/'.$livestream_videos->slug ) }}">

                                                <div class="img-box">
                                                    <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <p> {{ strlen($livestream_videos->title) > 17 ? substr($livestream_videos->title, 0, 18) . '...' : $livestream_videos->title }}</p>
                                                    
                                                    <div class="movie-time d-flex align-items-center my-2">
                                                        {{-- <div class="badge badge-secondary p-1 mr-2">
                                                            {{ optional($livestream_videos)->age_restrict.'+' }}
                                                        </div> --}}

                                                        <span class="text-white">
                                                            @if($livestream_videos->duration != null)
                                                                @php
                                                                    $duration = Carbon\CarbonInterval::seconds($livestream_videos->duration)->cascade();
                                                                    $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                    $minutes = $duration->format('%imin');
                                                                @endphp
                                                                {{ $hours }}{{ $minutes }}
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div class="hover-buttons">
                                                        <span class="btn btn-hover">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ __('Play Now')}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    
                                @endforeach
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
