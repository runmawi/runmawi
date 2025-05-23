<?php

$data = App\LiveCategory::query()
    ->whereHas('category_livestream', function ($query) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1);
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 'live_streams.description')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->latest('live_streams.created_at');
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

    @foreach ($data as $key => $live_Category)
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a
                                    href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ optional($live_Category)->name }}</a>
                            </h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($live_Category->category_livestream as $livestream_videos)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="{{ URL::to('live/' . $livestream_videos->slug) }}">
                                                    <img src="{{ $livestream_videos->image ? URL::to('public/uploads/images/' . $livestream_videos->image) : default_vertical_image_url() }}"
                                                        class="img-fluid" alt="">
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
