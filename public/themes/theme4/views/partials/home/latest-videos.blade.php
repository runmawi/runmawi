<?php

$data = App\Series::where('active', '=', '1')
    ->get()
    ->map(function ($item) {
        $item['image_url'] = URL::to('/public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('/public/uploads/images/' . $item->player_image);
        $item['season_count'] = App\SeriesSeason::where('series_id', $item->id)->count();
        $item['episode_count'] = App\Episode::where('series_id', $item->id)->count();

        $item['Series_Category'] = App\SeriesCategory::select('category_id', 'series_id', 'name', 'slug')
            ->join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
            ->where('series_id', $item->id)
            ->get();

        $item['Series_Language'] = App\SeriesLanguage::select('language_id', 'series_id', 'name', 'slug')
            ->join('languages', 'languages.id', '=', 'series_languages.language_id')
            ->where('series_id', $item->id)
            ->get();

        $item['Series_artist'] = App\Seriesartist::select('artist_id', 'artist_name as name', 'artist_slug')
            ->join('artists', 'artists.id', '=', 'series_artists.artist_id')
            ->where('series_id', $item->id)
            ->get();

        $item['season'] = App\SeriesSeason::where('series_id', $item->id)->get();

        $item['Episode_details'] = $item->Series_depends_episodes;

        $item['Episode_Traler_details'] = $item->Series_depends_episodes;

        $item['Episode_Similar_content'] = App\Episode::where('series_id','!=',$item->id)->where('status','1')->where('active',1)->get();

        return $item;
    });

?>

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="show-category.html">Latest videos</a></h4>
                    </div>
                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center">
                            @foreach ($data as $series_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_details->image_url }}" class="img-fluid">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider " class="list-inline p-0 m-0  d-flex align-items-center dropdwon-trending">
                            @foreach ($data as $key => $series_details )
                                <li>
                                    <div class="tranding-block position-relative videoInfo"
                                        style="background-image: url( {{ $series_details->Player_image_url }} );">
                                        <div class="trending-custom-tab">
                                                            
                                            <div class="trending-content">

                                                                {{-- overview --}}
                                                <div id="{{'trending-data-overview-'.$key }}" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 p-0 " id=" videoInfo">
                                                    <button class="wtv-close" id="closeButton"><i class="fas fa-times"></i></button>
                                                        <div class="vip"> 
                                                            <div class="caption col-6 pl-0"> 
                                                                <h2 class="mb-2">{{ optional($series_details)->title }}</h2>
                                                                <p class="trending-dec col-6">{!! html_entity_decode( optional($series_details)->details) !!}</p>
                                                            </div>
                                                        </div>

                                                        <nav class=" wtv-buttons-group d-flex">
                                                            <a>
                                                                <button type="button">
                                                                <i class="fas fa-eye"></i></i> View Content
                                                                </button>
                                                            </a>
                                                            <button>
                                                                <i class="fas fa-info-circle"></i> More Info
                                                            </button>
                                                        </nav>
                                                         <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center">
                            @foreach ($data as $series_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_details->image_url }}" class="img-fluid dropdown-slider-img">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                                                    </div>
                                                </div>

                                                
                                                    </div>
                                                </div>
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
@endif

<script>
    $(document).ready(function () {
        // Initially hide the #trending-slider
        $('.tranding-block').hide();

        // Add click event to #trending-slider-nav
        $('#trending-slider-nav').on('click', 'li', function () {
            // Show or hide #trending-slider based on its current visibility
            $('.tranding-block').toggle();
        });

        // Add click event to close button
        $('#closeButton').on('click', function () {
            // Hide #trending-slider when close button is clicked
            $('.tranding-block').hide();
        });
    });
</script>



<style>

    .trending-slider .videoInfo{
        height: 44vw;
    max-height: 460px;
    }
    .trending-dec {
    display:none;
}
.dropdown-slider-img{
    width:50%
}
.wtv-buttons-group button {
    color: #fff;
    background-color: rgba(51, 51, 51, 0.4);
    border-width: 0;
    padding: 8px 16px;
    border-radius: 4px;
    -webkit-box-shadow: none;
    box-shadow: none;
    font-size: calc(12px + 0.5vmin);
    font-weight: bold;
    margin-bottom: 0.75em;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    margin-right: 10px;
    cursor: pointer;
    outline: none;
}
.wtv-buttons-group button {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    align-items: center;
    /* margin-top: 1.5vw; */
}
.wtv-buttons-group button  button svg, .wtv-buttons-group button i {
    margin-right: 8px;
}
.wtv-buttons-group button .far {
    font-family: 'Font Awesome 5 Free';
    font-weight: 400;
}
 .vib .caption h2,  .vib .caption p {
    font-size: calc(14px + 2vmin);
    font-weight: 700;
    margin: 0 0 0.2em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
.wtv-close{
    position: absolute;
    right: 2%;
    top: 4%;
    z-index: 10;
    padding: 0;
    font-size: 30px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    background: none;
    border: none;
    border-radius: 50%;
    color: #fff;
    line-height: 1;
    outline: none;
    text-shadow: 0 0 30px #000;
    cursor: pointer;
    -webkit-transition: all 0.15s ease;
    transition: all 0.15s ease;
}

@media screen and (min-width: 1200px){
 .vib .caption h2, .vib .caption p {
    font-size: 35px;
}
}
@media (min-width: 992px){
.wtv-buttons-group {
    white-space: nowrap;
}
}
@media (min-width: 992px){
.wtv-buttons-group button {
    padding: 0.75em 2.3em;
}
}
</style>

<style>



 
#videoInfo {
    display: none;
    background-color: rgba(0, 0, 0, 0.15);
    z-index: 1;
    position: relative;
    top: -29px;
}

#videoInfo .vib {
    padding: 18px 4% 12px;
    width: 100%;
    position: relative;
    display: none;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
}
#videoInfo .vib .caption {
    position: relative;
    z-index: 2;
    color: var(--text-color);
    width: 100%;
}
#videoInfo .vib .caption h2, {
    font-size: calc(14px + 2vmin);
    font-weight: 700;
    margin: 0 0 0.2em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
#videoInfo .vib .caption .description {
    font-size: calc(14px + 0.7vmin);
    line-height: normal;
    font-weight: 400;
    margin: 0.5vw 0 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
}





@media screen and (min-width: 992px) and (max-width: 1399px){
#videoInfo {
    height: 44vw;
    max-height: 460px;
}
}
@media screen and (min-width: 801px){
#videoInfo .vib .caption {
    padding-right: 30px;
    max-width: 630px;
}
}
@media screen and (min-width: 1200px){
#videoInfo .vib .caption h2 {
    font-size: 35px;
}
}

</style>