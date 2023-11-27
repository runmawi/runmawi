@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[5]->url ? URL::to($order_settings_list[5]->url) : null }} ">{{ optional($order_settings_list[5])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $audios_details)
                                <li class="slide-item">
                                    <a href="{{ URL::to('audio/'.$audios_details->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{  $audios_details->image ? URL::to('public/uploads/images/'.$audios_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($audios_details->title) > 17 ? substr($audios_details->title, 0, 18) . '...' : $audios_details->title }}
                                                </h6>
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($audios_details)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $audios_details->duration != null ? gmdate('H:i:s', $audios_details->duration) : null }}
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
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