<div class="trending-custom-tab ">

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

    <div class="tab-content" id="nav-tabContent"> <!-- Latest Episode -->

        <div id="episodes" class="tab-pane animated fadeInUp active show">
            <div class="row episodes list-inline p-0 mb-0 iq-rtl-direction ">

                @forelse ($season_depends_episode as $item)
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

        <div id="feature-clips" class="tab-pane animated fadeInUp"> <!-- Featured Episode  -->
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
</div>
