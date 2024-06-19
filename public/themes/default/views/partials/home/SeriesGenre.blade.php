
@php 
    $SeriesGenre = App\SeriesGenre::all();
@endphp

@if (!empty($data) && $data->isNotEmpty())


        <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12 ">

                      <div class="iq-main-header d-flex align-items-center justify-content-between">
                          <h4 class="main-title">
                              <a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">
                                  {{ $order_settings_list[19]->header_name ? __($order_settings_list[19]->header_name) : '' }}
                              </a>
                          </h4>
                          @if($settings->homepage_views_all_button_status == 1)
                              <h4 class="main-title">
                                  <a href="{{ $order_settings_list[19]->header_name ? url('/' . $order_settings_list[19]->url) : '' }}">
                                      {{ __('View All') }}
                                  </a>
                              </h4>
                          @endif
                      </div>


                      <div class="favorites-contens">
                          <ul class="favorites-slider list-inline row p-0 mb-0">
                              @foreach($data as $Series_Genre)
                                  <li class="slide-item">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ $Series_Genre->image ? URL::to('public/uploads/videocategory/' . $Series_Genre->image) : $default_vertical_image_url }}" alt="{{ $Series_Genre->name }}">
                                                  </a>
                                              </div>
                                          </div>
                                          <div class="block-description">
                                              <a class="playTrailer" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                  <img class="img-fluid w-100" loading="lazy" data-src="{{ $Series_Genre->player_image ? URL::to('public/uploads/videocategory/' . $Series_Genre->player_image) : $default_vertical_image_url }}" alt="{{ $Series_Genre->name }}">
                                              </a>
                                              <div class="hover-buttons text-white">
                                                  <a href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
                                                      <p class="epi-name text-left m-0">{{ __($Series_Genre->name) }}</p>
                                                      <div class="movie-time d-flex align-items-center my-2"></div>
                                                  </a>
                                                  <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('series/category/'. $Series_Genre->slug) }}">
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