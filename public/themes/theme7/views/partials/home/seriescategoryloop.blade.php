@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{  URL::to('/series/category/' . $category->slug ) }} ">
                                {{ !empty($category->home_genre) ?  $category->home_genre : $category->name }}
                            </a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{  URL::to('/series/category/' . $category->slug ) }} ">
                                {{ 'view all' }}
                            </a>
                        </h4>
                    </div>
                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $series_details)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                                <img src="{{ $series_details->image ? URL::to('public/uploads/images/' . $series_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
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
@endif