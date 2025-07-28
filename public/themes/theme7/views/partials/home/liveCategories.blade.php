@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ optional($order_settings_list[12])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ( $data as $key => $livecategories)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <a href="{{ URL::to('LiveCategory/'.$livecategories->slug) }}">
                                                <img src="{{  $livecategories->image ? URL::to('public/uploads/livecategory/'.$livecategories->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
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