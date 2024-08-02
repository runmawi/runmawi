<?php

$data = App\Series::where('active', '1')->limit(15)
    ->get()
    ->map(function ($item) {
        $item['image_url'] = URL::to('/public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('/public/uploads/images/' . $item->player_image);
        $item['season_count'] = App\SeriesSeason::where('series_id', $item->id)->count();
        $item['episode_count'] = App\Episode::where('series_id', $item->id)->count();

        $item['Series_Category'] = App\SeriesCategory::select('category_id', 'series_id', 'name', 'slug')
            ->join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['Series_Language'] = App\SeriesLanguage::select('language_id', 'series_id', 'name', 'slug')
            ->join('languages', 'languages.id', '=', 'series_languages.language_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['Series_artist'] = App\Seriesartist::select('artist_id', 'artist_name as name', 'artist_slug')
            ->join('artists', 'artists.id', '=', 'series_artists.artist_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['season'] = App\SeriesSeason::where('series_id', $item->id)->limit(15)->get();

        $item['Episode_details'] = App\Episode::where('series_id', $item->id)->get();

        $item['Episode_Traler_details'] = $item->Series_depends_episodes;

        $item['Episode_Similar_content'] = App\Episode::where('series_id','!=',$item->id)->where('status','1')->where('active',1)->limit(15)->get();

        return $item;
    });

?>

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="#">{{ optional($order_settings_list[29])->header_name }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list episode-overview">
                                @foreach ($data as $key => $Episode)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $Episode->title }}" src="{{ $Episode->image ?  URL::to('public/uploads/images/'.$Episode->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$Episode->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$Episode->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$Episode->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $Episode->image_url }}" class="flickity-lazyloaded" alt="Videos">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        

                        <div id="videoInfo" class="episode-dropdown-overview" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $Episode)
                                    @foreach ($Episode['Episode_details'] as $episode)
                                        <div class="caption" data-index="{{ $key }}">
                                            <h2 class="caption-h2">{{ optional($episode)->title }}</h2>

                                            @if (optional($episode)->episode_description)
                                                <div class="trending-dec">{{ (strip_tags(html_entity_decode(optional($episode)->episode_description))) }}</div>
                                            @endif

                                            <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                    <a href="{{ URL::to('episode/'.$episode->series_id .'/'. $episode->id ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                    <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-episode-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumbnail" data-index="{{ $key }}">
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{$episode->title}}" src="{{$episode->player_image ?  URL::to('public/uploads/images/'.$episode->player_image) : $default_horizontal_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$episode->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$episode->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$episode->responsive_player_image.' 420w') }}" >
                                            @else
                                                <img class="flickity-lazyloaded" src="{{ $episode->player_image ? URL::to('public/uploads/images/'. $episode->player_image ) : $default_vertical_image_url }}" alt="{{$episode->title}}">
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<script>

    var elem = document.querySelector('.episode-overview');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
    document.querySelectorAll('.episode-overview .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.episode-overview .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.episode-dropdown-overview .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.episode-dropdown-overview .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.episode-dropdown-overview .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.episode-dropdown-overview .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('episode-dropdown-overview')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.episode-dropdown-overview').hide();
    });
</script>
