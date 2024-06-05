<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title"><?= __('Series Category') ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        @if(isset($SeriesCategory) && count($SeriesCategory) > 0)
                            @foreach($SeriesCategory as $Series_Category)

                                <li class="slide-item">
                                    <a href="{{ URL::to('/play_series/' . $Series_Category->slug) }}">
                                        <!-- block-images -->
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ URL::to('public/uploads/images/'.$Series_Category->image) }}" class="img-fluid w-100" alt="">
                                            </div>
                                            <div class="block-description">
                                                <div class="hover-buttons d-flex">
                                                    <a class="text-white" href="{{ URL::to('/play_series/' . $Series_Category->slug) }}">
                                                        <img class="ply" src="{{ URL::to('/') . '/assets/img/default_play_buttons.svg' }}" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                                <a href="{{ URL::to('/play_series/' . $Series_Category->slug) }}">
                                                    <h6>{{ __($Series_Category->title) }}</h6>
                                                </a>
                                                <div class="badge badge-secondary p-1 mr-2">{{ $Series_Category->age_restrict }} +</div>
                                            </div>
                                            <div class="seaplue mb-2" style="display:flex">
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    @php
                                                        $SeriesSeason = App\SeriesSeason::where('series_id', $Series_Category->id)->count();
                                                    @endphp
                                                    {{ $SeriesSeason }} {{ __('Season') }}
                                                </div>
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    @php
                                                        $Episode = App\Episode::where('series_id', $Series_Category->id)->count();
                                                    @endphp
                                                    {{ $Episode }} {{ __('Episodes') }}
                                                </div>
                                            </div>
                                            <span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $Series_Category->duration) }}</span>
                                        </div>
                                    </a>
                                </li>

                                
                            @endforeach
                        @else
                            <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
                                <h4 class="main-title mb-4">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
                                <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


