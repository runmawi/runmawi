@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[26]->url ? URL::to($order_settings_list[26]->url) : null }} ">{{ optional($order_settings_list[26])->header_name }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline p-0 mb-0">
                            @foreach ($data as $My_Playlist)
                                <li class="slide-item">
                                    <a href="{{ URL::to('playlist/' . $My_Playlist->slug) }}">
                                        <div class="block-images position-relative">
                                          
                                            <div class="img-box">
                                                <img src="{{ $My_Playlist->image != null ? URL::to('public/uploads/images/'. $My_Playlist->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p> {{ strlen($My_Playlist->title) > 17 ? substr($My_Playlist->title, 0, 18) . '...' : $My_Playlist->title }} </p>

                                                <div class="movie-time d-flex align-items-center my-2"></div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit My PlayList
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

