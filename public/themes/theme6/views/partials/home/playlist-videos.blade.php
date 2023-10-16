@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[27]->url ? URL::to($order_settings_list[27]->url) : null }} ">{{ optional($order_settings_list[27])->header_name }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $playlist_videos)
                                <li class="slide-item">
                                    <a href="{{ URL::to('video-playlist/' . $playlist_videos->slug) }}">
                                        <div class="block-images position-relative">
                                          
                                            <div class="img-box">
                                                <img src="{{ $playlist_videos->image ? URL::to('public/uploads/images/'.$playlist_videos->image) : default_vertical_image() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <h6> {{ strlen($playlist_videos->title) > 17 ? substr($playlist_videos->title, 0, 18) . '...' : $playlist_videos->title }}

                                                <div class="movie-time d-flex align-items-center my-2"></div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit Video PlayList
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li> -->
                                                    {{-- <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li> --}}
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