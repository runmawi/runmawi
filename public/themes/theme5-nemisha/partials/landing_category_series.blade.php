@forelse($SeriesCategory  as  $key => $Series_Category)
    @php
        if($Series_Category->series_trailer == 1):

            $season_trailer = App\SeriesSeason::where('id', $Series_Category->season_trailer)
                ->pluck('landing_mp4_url')
                ->first();
        
            $season_trailer_url = $season_trailer != null ? $season_trailer : null ;

        else:
            $season_trailer_url = null ;
        endif;
        
        $video_key_id = $key + 1;
    @endphp

    <div class="col-md-4" data-series-id="{{ $Series_Category->id }}" data-trailer-series="{{ $season_trailer_url }}">
        <div class="card" style="">
            <div style="position: relative;">
                @if ($season_trailer_url != null)

                    <div onmouseover="season_trailer(this)" data-video-key-id = "{{ 'trailer-'. $video_key_id }}" >
                        <a href="{{ URL::to('play_series/'.  $Series_Category->slug )}}" class="voda">
                            <div class="vida">
                            <video playsinline  class="vid" id="{{ 'trailer-'. $video_key_id }}" src="{{ $season_trailer_url }}"   poster="{{ URL::to('/public/uploads/images/' . $Series_Category->image) }}" 
                                type="video/mp4" muted=false  controlsList="nodownload nofullscreen noremoteplayback" style="border: 1px solid ddd; width: 350px;height:200px;">
                            </video></div>
                        </a>
                    </div>
                @else
                    <a href="{{ URL::to('play_series/'.  $Series_Category->slug )}}" aria-label="{{ $Series_Category->title }}">
                        <img class="lazyload" data-src="{{ URL::to('/public/uploads/images/' . $Series_Category->image )}}" width="340" height="180" alt="series">
                    </a>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="col-md-3 p-0">
        <div class="card" style="">
            <h2 class="text-center text-black"> No Series found </h2>
        </div>
    </div>
@endforelse
