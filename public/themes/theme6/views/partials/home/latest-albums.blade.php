@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[6]->url ? URL::to($order_settings_list[6]->url) : null }} ">{{ optional($order_settings_list[6])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $key => $albums)
                                <li class="slide-item">
                                    <a href="{{ URL::to('album/'.$albums->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $albums->album ?  URL::to('public/uploads/albums/'.$albums->album ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <p> {{ strlen($albums->albumname ) > 17 ? substr($albums->albumname , 0, 18) . '...' : $albums->albumname  }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    {{-- <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($albums)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $albums->duration != null ? gmdate('H:i:s', $albums->duration) : null }}
                                                    </span> --}}
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="block-social-info">
                                                {{-- <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <li><span><i class="ri-add-line"></i></span></li>
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