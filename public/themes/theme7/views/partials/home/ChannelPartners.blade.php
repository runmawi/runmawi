@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ optional($order_settings_list[13])->header_name }}</a>
                        </h4>
                    </div>

                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($data as $channel)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        
                                        <div class="img-box">
                                            <a href="{{ URL::to('channel/' . $channel->channel_slug) }}">
                                                <img src="{{ $channel->channel_image ? $channel->channel_image : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif