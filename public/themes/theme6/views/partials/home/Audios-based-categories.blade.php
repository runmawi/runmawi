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
            <div class="container">
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

                                            <a href="{{ URL::to('audio/' . $audios_details->slug) }}">

                                                <div class="img-box">
                                                    <img src="{{ $audios_details->image ? URL::to('public/uploads/images/' . $audios_details->image) : default_vertical_image_url() }}"
                                                        class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <p> {{ strlen($audios_details->title) > 17 ? substr($audios_details->title, 0, 18) . '...' : $audios_details->title }}
                                                    </p>

                                                    <div class="movie-time d-flex align-items-center my-2">

                                                        {{-- <div class="badge badge-secondary p-1 mr-2">
                                                            {{ optional($audios_details)->age_restrict . '+' }}
                                                        </div> --}}

                                                        <span class="text-white">
                                                            @if($audios_details->duration != null)
                                                                @php
                                                                    $duration = Carbon\CarbonInterval::seconds($audios_details->duration)->cascade();
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
                                            
                                                {{-- WatchLater & wishlist --}}

                                            {{-- @php
                                                $inputs = [
                                                    'source_id'     => $audios_details->id ,
                                                    'type'          => null,  
                                                    'wishlist_where_column'    => 'audio_id',
                                                    'watchlater_where_column'  => 'audio_id',
                                                ];
                                            @endphp

                                            {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!} --}}
                                    
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
