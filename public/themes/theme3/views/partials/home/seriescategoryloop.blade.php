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
                                {{ 'View all' }}
                            </a>
                        </h4>
                    </div>
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline p-0 mb-0">
                            @foreach ($data as $series_details)
                                <li class="slide-item">
                                    <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $series_details->image ? URL::to('public/uploads/images/' . $series_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ strlen($series_details->title) > 17 ? substr($series_details->title, 0, 18) . '...' : $series_details->title }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                    <span class="text-white"> 
                                                        {{ App\SeriesSeason::where('series_id',$series_details->series_id)->count() . " Seasons" }}  
                                                        {{ App\Episode::where('series_id',$series_details->series_id)->count() . " Episodes" }}  
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif