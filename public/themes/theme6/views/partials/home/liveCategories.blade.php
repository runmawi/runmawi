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
                                    <a href="{{ URL::to('LiveCategory/'.$livecategories->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{  $livecategories->image ? URL::to('public/uploads/livecategory/'.$livecategories->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($livecategories->name ) > 17 ? substr($livecategories->name , 0, 18) . '...' : $livecategories->name  }}</h6>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    {{-- <span class="text-white">
                                                        {{ str_replace('_', ' ', ucwords($livecategories->artist_type))  }}
                                                    </span> --}}
                                                    
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                       Visit
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                {{-- <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <li><span><i class="ri-volume-mute-fill"></i></span></li>
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