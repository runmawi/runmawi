@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        @if (preg_match('/^tv-shows(\/.*)?$/', request()->path()))
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                    {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                                </a>
                            </h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all text-primary">
                                    <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                        {{ __('View all') }}
                                    </a>
                                </h4>
                            @endif
                        @else
                            <h4 class="main-title fira-sans-condensed-regular"><a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">{{ optional($order_settings_list[19])->header_name }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all fira-sans-condensed-regular text-primary"><a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">{{ 'View all' }}</a></h4>
                            @endif
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ( $data as $key => $seriesGenre)
                                <li class="slide-item">
                                    <a href="{{ URL::to('series/category/'. $seriesGenre->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $seriesGenre->image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($seriesGenre->name ) > 17 ? substr($seriesGenre->name , 0, 18) . '...' : $seriesGenre->name  }}</p>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit
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