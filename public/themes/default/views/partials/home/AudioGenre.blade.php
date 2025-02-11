@php
    $latest_series = isset($latest_series) ? $latest_series : null;
    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
    $order_settings_list = App\OrderHomeSetting::where('video_name', 'Audio_Genre')->first();
    $AudioCategory = App\AudioCategory::get();
@endphp

@if(!empty($data) && $data->isNotEmpty())


      <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                      <h4 class="main-title">
                          <a href="{{ $order_settings_list->header_name ? url('/' . $order_settings_list->url) : '' }}">
                              {{ $order_settings_list->header_name ? __($order_settings_list->header_name) : '' }}
                          </a>
                      </h4>
                      @if($settings->homepage_views_all_button_status == 1)
                          <h4 class="main-title view-all">
                              <a href="{{ $order_settings_list->header_name ? url('/' . $order_settings_list->url) : '' }}">
                                  {{ __('View all') }}
                              </a>
                          </h4>
                      @endif
                  </div>

                  <div class="favorites-contens">
                    <div class="audio-genre home-sec list-inline row p-0 mb-0">
                          @foreach($data as $Audio_Category)
                            <div class="items">
                                  <div class="block-images position-relative">
                                      <div class="border-bg">
                                          <div class="img-box">
                                              <a class="playTrailer" href="{{ url('/audios/category/' . $Audio_Category->slug) }}">
                                                  <img data-src="{{ $Audio_Category->image ? URL::to('/public/uploads/audios/' . $Audio_Category->image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $Audio_Category->image ? URL::to('/public/uploads/audios/' . $Audio_Category->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $Audio_Category->name }}">
                                              </a>
                                          </div>
                                      </div>
                                      <div class="block-description">
                                          <a class="playTrailer" href="{{ url('/audios/category/' . $Audio_Category->slug) }}">
                                              <img data-flickity-lazyload="{{ $Audio_Category->banner_image ? URL::to('/public/uploads/audios/' . $Audio_Category->banner_image) : $default_vertical_image_url }}" data-src="{{ $Audio_Category->banner_image ? URL::to('/public/uploads/audios/' . $Audio_Category->banner_image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $Audio_Category->name }}">
                                          </a>
                                          <div class="hover-buttons text-white">
                                              <a href="{{ url('/audios/category/' . $Audio_Category->slug) }}">
                                                  <p class="epi-name text-left m-0">{{ __($Audio_Category->name) }}</p>
                                              </a>
                                              <a class="epi-name mt-2 mb-0 btn" href="{{ url('/audios/category/' . $Audio_Category->slug) }}">
                                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                  {{ __('Visit Audio Category') }}
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
    var elem = document.querySelector('.audio-genre');
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