@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-name"><a href="{{ $order_settings_list[10]->url ? URL::to($order_settings_list[10]->url) : null }} ">{{ optional($order_settings_list[10])->header_name }}</a></h4>
                        <h4 class="main-name"><a href="{{ $order_settings_list[10]->url ? URL::to($order_settings_list[10]->url) : null }} ">{{ __('View all') }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline p-0 mb-0">
                            @foreach ($data as $key => $video_details)
                                <li class="slide-item">
                                    <a href="{{ URL::to('schedule/videos/embed/'.$video_details->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $video_details->image ?  $video_details->image : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <p> {{ strlen($video_details->name) > 17 ? substr($video_details->name, 0, 18) . '...' : $video_details->name }}
                                                </p>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
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