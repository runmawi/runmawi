<div class="trending-custom-tab ">

    <div class="tab-title-info position-relative d-flex justify-content-center">
        <ul class="trending-pills nav nav-pills text-center iq-ltr-direction" role="tablist">
            <li class="nav-item">
                <a class="nav-link m-0 active show" data-toggle="pill" href="#episodes" role="tab" aria-selected="false">Episodes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-0" data-toggle="pill" href="#feature-clips" role="tab"
                    aria-selected="true">Related</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="nav-tabContent"> <!-- Latest Episode -->

        <div id="episodes" class="tab-pane animated fadeInUp active show">
            <div class="row episodes list-inline p-0 mb-0 iq-rtl-direction ">

                @forelse ($season_depends_episode as $item)
                    <div class="e-item col-lg-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga" alt="">
                            </div>
                            <div class="col-7">
                                <h5 class="epi-name text-white mb-0"> {{ $item->title }}</h5>
                                <h6>{{ $item->description }}</h6>
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

        <div id="feature-clips" class="tab-pane animated fadeInUp"> <!-- Featured Episode  -->

            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    @forelse ($featured_season_depends_episode as $item)
                        <li class="slide-item">
                            <div class="block-images position-relative">
                                
                                <a href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">

                                    <div class="img-box">
                                        <img src="{{ $item->image ?  URL::to('public/uploads/images/' . $item->image ) : default_vertical_image_url() }}" class="img-fluid transimga img-zoom" alt="">
                                    </div>
                                    <div class="block-description">
                                        

                                        <div class="hover-buttons">
                                            <a class="" href="{{ route('play_episode',[$series_data->slug,$item->slug]) }}">
                                                <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                    <span class="text pr-2"> Play </span>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    
                                </a>
                            </div>
                        </li>
                    @empty
                        <div class="e-item col-lg-3 col-sm-12 col-md-6">
                            <div class="block-image position-relative">
                                <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                            </div>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .row.episodes.list-inline.p-0.mb-0.iq-rtl-direction {
        display: flex !important;
        flex-direction: column !important;
        gap:10px;
    }
    .row.episodes.list-inline.p-0.mb-0.iq-rtl-direction img{
        border-radius:20px;
    }
</style>