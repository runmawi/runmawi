@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ optional($order_settings_list[8])->header_name }}</a></h4>
                        <h4 class="main-title view-all text-primary"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ( $data as $key => $artist_details)
                                <li class="slide-item">
                                    <a href="{{ URL::to('artist') . '/' . $artist_details->artist_slug }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{  $artist_details->image ? URL::to('public/uploads/artists/'.$artist_details->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <p> {{ strlen($artist_details->artist_name ) > 17 ? substr($artist_details->artist_name , 0, 18) . '...' : $artist_details->artist_name  }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <span class="text-white">
                                                        {{ str_replace('_', ' ', ucwords($artist_details->artist_type))  }}
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                       {{ __('Visit')}}
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