<?php

    $data = App\SeriesGenre::query()->whereHas('category_series', function ($query) {})
        ->with([
            'category_series' => function ($series) {
                $series->select('series.*')->where('series.active', 1)->latest('series.created_at');
            },
        ])
        ->select('series_genre.id', 'series_genre.name', 'series_genre.slug', 'series_genre.order')
        ->orderBy('series_genre.order')
        ->get();

    $data->each(function ($category) {
        $category->category_series->transform(function ($item) {

            $item['image_url']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
            $item['Player_image_url'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;

            $item['upload_on'] =  Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY'); 

            $item['duration_format'] =  !is_null($item->duration) ?  Carbon\Carbon::parse( $item->duration)->format('G\H i\M'): null ;

            $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                                        return $item;
                                                });

            $item['source'] = 'Series';
            return $item;
        });
        $category->source = 'Series_Genre';
        return $category;
    });
?>

@if (!empty($data) && $data->isNotEmpty())
    @foreach( $data as $key => $series_genre )
        <section id="iq-tvthrillers" class="s-margin">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                          {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ optional($series_genre)->name }}</a></h4>
                            <h4 class="main-title"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ 'view all' }}</a></h4>
                        </div>

                        <div class="tvthrillers-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @foreach ($series_genre->category_series as $latest_series)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="{{ URL::to('play_series/'.$latest_series->slug) }}">
                                                    <img src="{{ $latest_series->image ? URL::to('public/uploads/images/' . $latest_series->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
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