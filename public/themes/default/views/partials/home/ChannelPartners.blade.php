@if (!empty($data) && $data->isNotEmpty())


    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[13]->header_name ? URL::to('/') . '/' . $order_settings_list[13]->url : '' }}">
                                {{ $order_settings_list[13]->header_name ? __($order_settings_list[13]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title view-all">
                                <a href="{{ $order_settings_list[13]->header_name ? URL::to('/') . '/' . $order_settings_list[13]->url : '' }}">
                                    {{ __('View all') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="channel-partner home-sec list-inline row p-0 mb-0">
                              @foreach($data as $channel)
                              <div class="items">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ URL::to('/channel/' . $channel->channel_slug) }}">
                                                      <img data-flickity-lazyload="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" data-src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $channel->channel_name }}">
                                                  </a>
                                              </div>
                                          </div>

                                          <div class="block-description">
                                              <div class="hover-buttons text-white">
                                                  <a href="{{ URL::to('/channel/' . $channel->slug) }}">
                                                      <p class="epi-name text-left m-0">{{ __($channel->channel_name) }}</p>
                                                  </a>

                                                  <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/channel/' . $channel->channel_slug) }}">
                                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                      {{ __('Visit Channel') }}
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                              @endforeach
                            </div>
                    </div>
                
                </div>
            </div>
        </div>
    </section>

@endif
<script>
    var elem = document.querySelector('.channel-partner');
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