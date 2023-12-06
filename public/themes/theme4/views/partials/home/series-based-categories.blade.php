<?php
    $data = App\SeriesGenre::query()
        ->whereHas('category_series', function ($query) {
        })
        ->with([
            'category_series' => function ($audios_videos) {
                $audios_videos
                    ->select('series.*')
                    ->where('series.active', 1)
                    ->latest('series.created_at');
            },
        ])
        ->select('series_genre.id', 'series_genre.name', 'series_genre.slug', 'series_genre.order')
        ->orderBy('series_genre.order')
        ->get();

    $data->each(function ($category) {
        $category->category_series->transform(function ($item) {
            $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
            $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
            $item['description'] = $item->description;
            $item['source'] = 'Series';
            $item['source_Name'] = 'category_series';
            return $item;
        });
        $category->source = 'Series_Genre_videos';
        return $category;
    });

?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach ($data as $key => $series_genre)
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a
                                    href="">{{ optional($series_genre)->name }}</a>
                            </h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($series_genre->category_series as $key => $series_details)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('play_series/' . $series_details->slug) }}">
                                            <div class="block-images position-relative">

                                                <div class="img-box">
                                                    <img src="{{ $series_details->image ? URL::to('public/uploads/images/' . $series_details->image) : default_vertical_image_url() }}"
                                                        class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <h6> {{ strlen($series_details->title) > 17 ? substr($series_details->title, 0, 18) . '...' : $series_details->title }}
                                                    </h6>

                                                    <div class="movie-time d-flex align-items-center my-2">

                                                        <span class="text-white">
                                                            {{ $series_details->duration != null ? gmdate('H:i:s', $series_details->duration) : null }}
                                                        </span>
                                                    </div>

                                                    <div class="hover-buttons">
                                                        <span class="btn btn-hover">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            Play Now
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="block-social-info">
                                                    <ul class="list-inline p-0 m-0 music-play-lists">
                                                        {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
                                                        <li><span><i class="ri-heart-fill"></i></span></li>
                                                        <li><span><i class="ri-add-line"></i></span></li>
                                                    </ul>
                                                </div>
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
