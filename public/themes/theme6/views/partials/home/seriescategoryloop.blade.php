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
                                    <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $series_details->image ? URL::to('public/uploads/images/' . $series_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <h6>{{ strlen($series_details->title) > 17 ? substr($series_details->title, 0, 18) . '...' : $series_details->title }}</h6>

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
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li> -->
                                                    <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li>
                                                </ul>
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