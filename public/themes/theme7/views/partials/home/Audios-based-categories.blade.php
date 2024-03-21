<?php
    $data = App\AudioCategory::query()
        ->whereHas('category_audios', function ($query) {
            $query->where('audio.active', 1);
        })
        ->with([
            'category_audios' => function ($audios_videos) {
                $audios_videos
                    ->select('audio.id', 'audio.title', 'audio.slug', 'audio.year', 'audio.rating', 'audio.access', 'audio.ppv_price', 'audio.duration', 'audio.rating', 'audio.image', 'audio.featured', 'audio.player_image', 'audio.description', 'audio.mp3_url')
                    ->where('audio.active', 1)
                    ->latest('audio.created_at');
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
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('audio/' . $audios_details->slug) }}">
                                                        <img src="{{ $audios_details->image ? URL::to('public/uploads/images/' . $audios_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
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
    @endforeach
@endif
