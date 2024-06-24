@if(!empty($data) && $data->isNotEmpty())
    @php
        $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
    @endphp

    <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
          <div class="row">
              <div class="col-sm-12 ">

                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                      <h4 class="main-title">
                          <a href="{{ $order_settings_list[12]->header_name ? URL::to('/') . '/' . $order_settings_list[12]->url : '' }}">
                              {{ $order_settings_list[12]->header_name ? __($order_settings_list[12]->header_name) : '' }}
                          </a>
                      </h4>

                      @if($settings->homepage_views_all_button_status == 1)
                          <h4 class="main-title">
                              <a href="{{ $order_settings_list[12]->header_name ? URL::to('/') . '/' . $order_settings_list[12]->url : '' }}">
                                  {{ __('View All') }}
                              </a>
                          </h4>
                      @endif
                  </div>

                  <div class="favorites-contens">
                      <ul class="favorites-slider list-inline row p-0 mb-0">
                          @php
                              $data = App\LiveCategory::orderBy('order', 'ASC')->get();
                          @endphp

                            @foreach($data as $Categories)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('LiveCategory') . '/' . $Categories->slug }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $Categories->image ? URL::to('/public/uploads/livecategory/' . $Categories->image) : $default_vertical_image_url }}" src="{{ $Categories->image ? URL::to('/public/uploads/livecategory/' . $Categories->image) : $default_vertical_image_url }}" alt="{{ $Categories->title }}">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('LiveCategory') . '/' . $Categories->slug }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $Categories->player_image ? URL::to('/public/uploads/livecategory/' . $Categories->player_image) : $default_vertical_image_url }}" src="{{ $Categories->player_image ? URL::to('/public/uploads/livecategory/' . $Categories->player_image) : $default_vertical_image_url }}" alt="{{ $Categories->title }}">
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a class="text-white d-flex align-items-center" href="{{ URL::to('LiveCategory') . '/' . $Categories->slug }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">
                                                            {{ strlen($Categories->name) > 17 ? substr($Categories->name, 0, 18) . '...' : $Categories->name }}
                                                        </p>
                                                    @endif
                                                </a>

                                                <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('LiveCategory') . '/' . $Categories->slug }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/') . '/assets/img/default_play_buttons.svg' }}" width="10%" height="10%"> {{ __('Watch Now') }}
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
