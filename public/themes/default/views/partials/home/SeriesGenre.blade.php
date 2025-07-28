
@if (!empty($data) && $data->isNotEmpty())


        <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12 ">

                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            @if(!preg_match('/tv-shows$/', request()->path()))
                                <h4 class="main-title">
                                    <a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">
                                        {{ $order_settings_list[19]->header_name ? __($order_settings_list[19]->header_name) : '' }}
                                    </a>
                                </h4>
                                @if($settings->homepage_views_all_button_status == 1)
                                    <h4 class="main-title view-all">
                                        <a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">
                                            {{ __('View all') }}
                                        </a>
                                    </h4>
                                @endif
                            @else
                                <h4 class="main-title">
                                    <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                        {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                                    </a>
                                </h4>
                                @if($settings->homepage_views_all_button_status == 1)
                                    <h4 class="main-title view-all">
                                        <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                            {{ __('View all') }}
                                        </a>
                                    </h4>
                                @endif
                            @endif
                        </div>


                      <div class="favorites-contens">
                        <div class="series-genre home-sec list-inline row p-0 mb-0">
                              @foreach($data as $Series_Genre)
                                  <li class="items">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ $Series_Genre->image ? URL::to('public/uploads/videocategory/' . $Series_Genre->image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $Series_Genre->image ? URL::to('public/uploads/videocategory/' . $Series_Genre->image) : $default_vertical_image_url }}" alt="{{ $Series_Genre->name }}">
                                                  </a>
                                              </div>
                                          </div>
                                          <div class="block-description">
                                              <a class="playTrailer" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                  {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $Series_Genre->player_image ? URL::to('public/uploads/videocategory/' . $Series_Genre->player_image) : $default_vertical_image_url }}" src="{{ $Series_Genre->player_image ? URL::to('public/uploads/videocategory/' . $Series_Genre->player_image) : $default_vertical_image_url }}" alt="{{ $Series_Genre->name }}"> --}}
                                              </a>
                                              <div class="hover-buttons text-white">
                                                  <a href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                      <p class="epi-name text-left m-0">{{ __($Series_Genre->name) }}</p>
                                                      <div class="movie-time d-flex align-items-center my-2"></div>
                                                  </a>

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($Series_Genre->description) > 75 ? substr(html_entity_decode(strip_tags($Series_Genre->description)), 0, 75) . '...' : strip_tags($Series_Genre->description) }}
                                                        </p>
                                                    @endif

                                                  <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                      {{ __('Visit Series Category')}}
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
        </section>
@endif

<script>
    var elem = document.querySelector('.series-genre');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>