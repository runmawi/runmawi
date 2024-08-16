@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-topten">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title topten-title-sm"> {{ optional($order_settings_list[0])->header_name }} </h4>
                    </div>
                    <div class="topten-contens">
                        <h4 class="main-title topten-title"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[0])->header_name }}</a></h4>
                        <ul id="top-ten-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                            @foreach ($data as $key => $featured_videos)
                                <li>
                                    <a href="{{ URL::to('category/videos/'.$featured_videos->slug ) }}">
                                        <img src="{{ URL::to('public/uploads/images/' . $featured_videos->player_image) }}"
                                            class="img-fluid w-100" alt="">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="vertical_s">
                            <ul id="top-ten-slider-nav" class="list-inline p-0 m-0  d-flex align-items-center">

                                @foreach ($data as $featured_videos)
                                    <li>
                                        <div>
                                            <a class="block-images position-relative" href="{{ URL::to('category/videos/'.$featured_videos->slug ) }}">
                                                <img src="{{ URL::to('public/uploads/images/' . $featured_videos->image) }}" class="img-fluid w-100" alt="featured_videos">
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<br>

<style>
    li.slick-slide.slick-current.slick-center .block-images::before{
        opacity: 1 !important;
        -webkit-transition: all 0.45s ease 0s;
    }

</style>