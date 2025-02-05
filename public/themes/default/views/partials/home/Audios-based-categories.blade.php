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
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a href="">{{ optional($audios_genre)->name }}</a>
                            </h4>
                        </div>

                        <div class="favorites-contens">
                            <div class="audio-categories list-inline  row p-0 mb-0">
                                @foreach ($audios_genre->category_audios as $key => $audios_details)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('artist/'.$audios_details->artist_slug)}}">
                                                        <img loading="lazy" data-src="{{ $audios_details->image ? URL::to('/public/uploads/images/' . $audios_details->image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $audios_details->image ? URL::to('/public/uploads/images/' . $audios_details->image) : $default_vertical_image_url }}" class="img-fluid loading w-100" alt="{{ $audios_details->title }}">
                                                    </a>
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($audios_details->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                @break

                                                            @case(!empty($audios_details->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $audios_details->ppv_price }}</p>
                                                                @break

                                                            @case(!empty($audios_details->global_ppv) || (!empty($audios_details->global_ppv) && $audios_details->ppv_price == null))
                                                                <p class="p-tag">{{ $audios_details->global_ppv . ' ' . $currency->symbol }}</p>
                                                                @break

                                                            @case($audios_details->global_ppv == null && $audios_details->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                                @break
                                                        @endswitch
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('artist/'.$audios_details->artist_slug)}}">
                                                    <img loading="lazy" data-src="{{ $audios_details->player_image ? URL::to('/public/uploads/images/' . $audios_details->player_image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $audios_details->player_image ? URL::to('/public/uploads/images/' . $audios_details->player_image) : $default_vertical_image_url }}" class="img-fluid loading w-100" alt="{{ $audios_details->title }}">
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($audios_details->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                @break

                                                            @case(!empty($audios_details->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $audios_details->ppv_price }}</p>
                                                                @break

                                                            @case(!empty($audios_details->global_ppv) || (!empty($audios_details->global_ppv) && $audios_details->ppv_price == null))
                                                                <p class="p-tag">{{ $audios_details->global_ppv . ' ' . $currency->symbol }}</p>
                                                                @break

                                                            @case($audios_details->global_ppv == null && $audios_details->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                                @break
                                                        @endswitch
                                                    @endif
                                                </a>
                                                
                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('artist/'.$audios_details->artist_slug)}}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <!-- Title -->
                                                            <p class="epi-name text-left mt-2 m-0">
                                                                {{ strlen($audios_details->title) > 17 ? substr($audios_details->title, 0, 18) . '...' : $audios_details->title }}
                                                            </p>
                                                        @endif
                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($audios_details->duration / 3600) > 0 ? floor($audios_details->duration / 3600) . 'h ' : '') . floor(($audios_details->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($audios_details->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($audios_details->year) }}
                                                            </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $audios_details->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                        
                                                    </a>

                                                    <a class="epi-name mt-2 mb-0 btn" type="button" href="{{ URL::to('artist/'.$audios_details->artist_slug)}}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif

<script>
    var elem = document.querySelector('.audio-categories');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>