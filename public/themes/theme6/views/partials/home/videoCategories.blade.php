@if (!empty($data))

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ optional($order_settings_list[11])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ( $data as $key => $videoCategories)
                                <li class="slide-item">
                                    <a href="{{ URL::to('artist-list') }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{  URL::to('public/uploads/videocategory/'.$videoCategories->image ) }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($videoCategories->name ) > 17 ? substr($videoCategories->name , 0, 18) . '...' : $videoCategories->name  }}</h6>

                                                <div class="movie-time d-flex align-items-center my-2">

                                                    {{-- <span class="text-white">
                                                        {{ str_replace('_', ' ', ucwords($videoCategories->artist_type))  }}
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