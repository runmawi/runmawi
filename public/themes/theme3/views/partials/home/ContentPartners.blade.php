@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[14]->url ? URL::to($order_settings_list[14]->url) : null }} ">{{ optional($order_settings_list[14])->header_name }}</a>
                        </h4>
                    </div>
                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $CPP_details)
                                <li class="slide-item">
                                    <a href="{{ URL::to('contentpartner/' . $CPP_details->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src=" {{ $CPP_details->picture ? URL::to('public/uploads/moderator_albums/'.$CPP_details->picture ) : default_vertical_image_url() }}"
                                                    class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ ucwords(optional($CPP_details)->username)  }}
                                                </p>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1"
                                                            aria-hidden="true"></i>
                                                        Visit 
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