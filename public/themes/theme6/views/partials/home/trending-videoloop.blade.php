@if (!empty($data))
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
                                        <div class="block-images position-relative">
                                            <a href="{{ URL::to('category/videos/'.$featured_videos->slug ) }}">
                                                <img src="{{ URL::to('public/uploads/images/' . $featured_videos->image) }}"
                                                    class="img-fluid w-100" alt="">
                                            </a>
                                            <div class="block-description">
                                                <h5> {{ strlen($featured_videos->title) > 17 ? substr($featured_videos->title, 0, 18) . '...' : $featured_videos->title }}

                                                    <div class="movie-time d-flex align-items-center my-2">
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            {{ optional($featured_videos)->age_restrict . '+' }}
                                                        </div>
                                                        <span class="text-white">
                                                            {{ $featured_videos->duration !=null ? Carbon\CarbonInterval::seconds($featured_videos->duration)->cascade()->format('%im %ss') : null }}
                                                        </span>
                                                    </div>

                                                    <div class="hover-buttons">
                                                        <a href="{{ URL::to('category/videos/'.$featured_videos->slug ) }}" class="btn btn-hover"
                                                            tabindex="0">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i> Play Now
                                                        </a>
                                                    </div>
                                            </div>
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