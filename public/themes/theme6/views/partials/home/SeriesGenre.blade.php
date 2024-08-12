@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ optional($order_settings_list[19])->header_name }}</a></h4>
                        <h4 class="main-title text-primary"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ( $data as $key => $seriesGenre)
                                <li class="slide-item">
                                    <a href="{{ URL::to('series/category/'. $seriesGenre->slug ) }}">

                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $seriesGenre->image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($seriesGenre->name ) > 17 ? substr($seriesGenre->name , 0, 18) . '...' : $seriesGenre->name  }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    {{-- <span class="text-white">
                                                        {{ str_replace('_', ' ', ucwords($seriesGenre->artist_type))  }}
                                                    </span> --}}
                                                    
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                {{-- <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                                </ul> --}}
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