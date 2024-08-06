@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ optional($order_settings_list[4])->header_name }}</a>
                        </h4>
                        <h4 class="main-title text-primary"><a
                                href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ 'view all' }}</a>
                        </h4>
                    </div>
                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $latest_series)
                                <li class="slide-item">
                                    <a href="{{ URL::to('play_series/'.$latest_series->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $latest_series->image ? URL::to('public/uploads/images/' . $latest_series->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ strlen($latest_series->title) > 17 ? substr($latest_series->title, 0, 18) . '...' : $latest_series->title }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                    <span class="text-white"> 
                                                        {{ App\SeriesSeason::where('series_id',$latest_series->id)->count() . " Seasons" }}  
                                                        {{ App\Episode::where('series_id',$latest_series->id)->count() . " Episodes" }}  
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Play Now')}}
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
