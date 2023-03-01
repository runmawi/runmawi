@forelse($SeriesCategory  as  $key => $Series_Category)
    @php
        $season_trailer = App\SeriesSeason::where('id', $Series_Category->season_trailer)
            ->pluck('landing_mp4_url')
            ->first();
        
        $season_trailer_url = $season_trailer != null ? $season_trailer : null ;
        
    @endphp

    <div class="col-md-3 p-0" data-series-id="{{ $Series_Category->id }}" data-trailer-series="{{ $season_trailer_url }}">
        <div class="card" style="">
            <div style="position: relative;">
                @if ($season_trailer_url != null)

                    <div onmouseover="season_trailer(this)" >
                        <video playsinline  class="vid" id="{{ 'trailer'.$key }}" src="{{ $season_trailer_url }}"   poster="{{ URL::to('/public/uploads/images/' . $Series_Category->image) }}" 
                            type="video/mp4" muted=false controls controlsList="nodownload nofullscreen noremoteplayback" style="border: solid; width: 320px;height:198px;">
                        </video>
                    </div>

                @else
                    <img class="w-100 " src="{{ URL::to('/public/uploads/images/' . $Series_Category->image )}}" style="">
                @endif

                <p class="small bkm"><i class="fa fa-clock-o" aria-hidden="true"></i>
                    {{ sprintf('%dh %dm', $Series_Category->duration / 3600, floor($Series_Category->duration / 60) % 60) }}
                </p>
            </div>

            <div class="card-body">
                <p class="card-text">{{ strip_tags($Series_Category->description) }}</p>
                <div class="d-flex small-t ">
                    <a herf="" class="btn btn-success suce mr-3"><i class="fa fa-thumbs-up mr-2"
                            aria-hidden="true"></i> {{ $Series_Category->views }} </a>
                    <p><i class="fa fa-eye" aria-hidden="true"></i> {{ $Series_Category->views }} </p>
                </div>
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
