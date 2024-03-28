
    
    
    <div class="col-md-12 p-0">
        <div class="tab-title-info position-relative">
            <ul class="trending-pills nav nav-pills text-center iq-ltr-direction" role="tablist">
                <li class="nav-item">
                    <a class="nav-link m-0 active show" data-toggle="pill" href="#episodes" role="tab" aria-selected="false">Episodes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link m-0" data-toggle="pill" href="#feature-clips" role="tab" aria-selected="true">More Like this</a>
                </li>
            </ul>
        </div>

        <ul class="nav nav-tabs" id="seasonTabs" role="tablist">
            @foreach ($season as $key => $seasons)
                <li class="nav-item" role="presentation">
                    <a class="nav-link{{ $key == 0 ? ' active' : '' }}" id="season{{ $seasons->id }}-tab" data-toggle="tab" href="#season{{ $seasons->id }}" role="tab" aria-controls="season{{ $seasons->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ 'Season '. ($key + 1) }}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="episodes" role="tabpanel" aria-labelledby="episodes-tab">
                @forelse ($season_depends_episode as $item)
                    <div class="e-item col-lg-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-4">
                                <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                    <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga" alt="">
                                </a>
                            </div>
                            <div class="col-7">
                                <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                    <h5 class="epi-name text-white mb-0"> {{ $item->title }}</h5>
                                </a>
                                <div class="d-flex flex-wrap align-items-center text-white text-detail sesson-date mt-2">
                                    <span >{{ 'S'.$item->season_id. ' ' . 'E'.$item->episode_order }}</span>
                                    <span class="trending-year">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                    <span class="trending-year">{{ $item->duration. 'm' }}</span>
                                </div>
                                <p> {!! html_entity_decode( optional($item)->episode_description) !!}</p>
                            </div>
                        </div>
                        
                    </div>
                @empty
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="feature-clips" role="tabpanel" aria-labelledby="feature-clips-tab">
                @forelse ($featured_season_depends_episode as $item)
                    <div class="e-item col-lg-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-4">
                                <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                    <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga" alt="">
                                </a>
                            </div>
                            <div class="col-7">
                                <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                    <h5 class="epi-name text-white mb-0"> {{ $item->title }}</h5>
                                </a>
                                <div class="d-flex flex-wrap align-items-center text-white text-detail sesson-date mt-2">
                                    <span >{{ 'S'.$item->season_id. ' ' . 'E'.$item->episode_order }}</span>
                                    <span class="trending-year">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                    <span class="trending-year">{{ $item->duration. 'm' }}</span>
                                </div>
                                <p> {!! html_entity_decode( optional($item)->episode_description) !!}</p>
                            </div>
                        </div>
                        
                    </div>
                @empty
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>











<!-- <div class="trending-custom-tab ">

    <div class="tab-title-info position-relative">
        <ul class="trending-pills nav nav-pills text-center iq-ltr-direction" role="tablist">
            <li class="nav-item">
                <a class="nav-link m-0 active show" data-toggle="pill" href="#episodes" role="tab" aria-selected="false">Episodes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-0" data-toggle="pill" href="#feature-clips" role="tab"
                    aria-selected="true">FEATURED CLIPS</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="nav-tabContent"> 

        <div id="episodes" class="tab-pane animated fadeInUp active show">
            <div class="row episodes list-inline p-0 mb-0 iq-rtl-direction ">

                @forelse ($season_depends_episode as $item)
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <a href=" {{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga img-zoom" alt="">
                            </a>

                                @php
                                    $series_season = App\SeriesSeason::where('id',$item->season_id)->first(); 
                                @endphp

                            <div class="episode-number episodenum">{{ (strlen($series_season->series_seasons_name) > 17 ? substr($series_season->series_seasons_name, 0, 18) . '...' : $series_season->series_seasons_name).' E'.$item->episode_order }}</div>

                            <div class="episode-play-info">
                                <div class="episode-play">
                                    <a href=" {{ route('play_episode',[$series_data->slug,$item->slug]) }}" tabindex="0"><i class="ri-play-fill"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="epi-desc p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-primary run-time" style="font-weight: 700">{{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%Hh %im %ss') : null }}</span>
                            </div>

                            <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                <h5 class="epi-name text-white mb-0"> {{ $item->title }}</h5>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                        </div>
                    </div>
                @endforelse

            </div>
        </div>

        <div id="feature-clips" class="tab-pane animated fadeInUp"> 
            <div class="row episodes list-inline p-0 mb-0 iq-rtl-direction">

                @forelse ($featured_season_depends_episode as $item)
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <a href=" {{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga img-zoom" alt="">
                            </a>

                            <div class="episode-number episodenum">{{ 'S'.$item->season_id.'E'.$item->episode_order }}</div>

                            <div class="episode-play-info">
                                <div class="episode-play">
                                    <a href=" {{ route('play_episode',[$series_data->slug,$item->slug]) }}" tabindex="0"><i class="ri-play-fill"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="epi-desc p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-primary run-time" style="font-weight: 700">{{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%Hh %im %ss') : null }}</span>
                            </div>

                            <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                <h5 class="epi-name text-white mb-0"> {{ $item->title }}</h5>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="e-item col-lg-3 col-sm-12 col-md-6">
                        <div class="block-image position-relative">
                            <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                        </div>
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
</div> -->

<style>
    .d-flex.flex-wrap.align-items-center.text-white.text-detail.sesson-date.mt-2 {
        opacity: 0.8;
    }
    .e-item.col-lg-12.col-sm-12.col-md-12 {
        padding: 10px;
    }
    img.img-fluid.transimga {
        border-radius: 5px;
    }
</style>