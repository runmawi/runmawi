<?php
    $data = App\AudioCategory::query()
        ->whereHas('category_audios', function ($query) {
            $query->where('audio.active', 1)->limit(15);
        })
        ->with([
            'category_audios' => function ($audios_videos) {
                $audios_videos
                    ->select('audio.id', 'audio.title', 'audio.slug', 'audio.year', 'audio.rating', 'audio.access', 'audio.ppv_price', 'audio.duration', 'audio.rating', 'audio.image', 'audio.featured', 'audio.player_image', 'audio.description', 'audio.mp3_url')
                    ->where('audio.active', 1)
                    ->latest('audio.created_at')
                    ->limit(15);
            },
        ])
        ->select('audio_categories.id', 'audio_categories.name', 'audio_categories.slug', 'audio_categories.order')
        ->orderBy('audio_categories.order')
        ->get();

    $data->each(function ($category) {
        $category->category_audios->transform(function ($item) {
            $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
            $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
            $item['description'] = $item->description;
            $item['source'] = 'Audios';
            $item['source_Name'] = 'category_audios';
            return $item;
        });
        $category->source = 'Audio_Genre_audios';
        return $category;
    });

?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach ($data as $key => $audios_genre)
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a
                                    href="">{{ optional($audios_genre)->name }}</a>
                            </h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @foreach ($audios_genre->category_audios as $key => $audios_details)
                                    <li class="slide-item">
                                        <a href="{{ URL::to('audio/' . $audios_details->slug) }}">
                                            <div class="block-images position-relative">

                                                <div class="img-box">
                                                    <img src="{{ $audios_details->image ? URL::to('public/uploads/images/' . $audios_details->image) : default_vertical_image_url() }}"
                                                        class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <h6> {{ strlen($audios_details->title) > 17 ? substr($audios_details->title, 0, 18) . '...' : $audios_details->title }}
                                                    </h6>

                                                    <div class="movie-time d-flex align-items-center my-2">

                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            {{ optional($audios_details)->age_restrict . '+' }}
                                                        </div>

                                                        <span class="text-white">
                                                            {{ $audios_details->duration != null ? gmdate('H:i:s', $audios_details->duration) : null }}
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
