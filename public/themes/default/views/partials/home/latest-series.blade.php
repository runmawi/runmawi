@php
    $data->map(function($item){
        $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                                        return $item;
                                                });

            return $item;
    });
@endphp

@if (!empty($data) && $data->isNotEmpty())
    @php
        $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
        $order_settings_list = App\OrderHomeSetting::get(); 
        $ThumbnailSetting = App\ThumbnailSetting::first();
    @endphp

    <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
          <div class="row">
              <div class="col-sm-12 ">

                    @if (!Str::endsWith(request()->path(), 'tv-shows'))
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h2 class="main-title">
                                <a href="{{ $order_settings_list[4]->header_name ? URL::to('/') . '/' . $order_settings_list[4]->url : '' }}">
                                    {{ $order_settings_list[4]->header_name ? __($order_settings_list[4]->header_name) : '' }}
                                </a>
                            </h2> 
                            @if($settings->homepage_views_all_button_status == 1)
                                <h2 class="main-title">
                                    <a href="{{ $order_settings_list[4]->header_name ? URL::to('/') . '/' . $order_settings_list[4]->url : '' }}"> 
                                        {{ __('View All') }}
                                    </a>
                                </h2>
                            @endif
                        </div>
                    @else
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h2 class="main-title">
                                {{ $order_settings_list[4]->header_name ? __($order_settings_list[4]->header_name) : '' }}
                            </h2> 
                        </div>
                    @endif
                
                  <div class="favorites-contens">
                        <div class="latest-series-video home-sec list-inline row p-0 mb-0">
                          @if(isset($data))
                              @foreach($data as $latest_serie)
                                  <div class="items">
                                      <div class="block-images position-relative">
                                          <!-- block-images -->
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                      <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $latest_serie->image ? URL::to('/public/uploads/images/' . $latest_serie->image) : $default_vertical_image_url }}"  alt="{{ $latest_serie->title }}">
                                                  </a>
                                                  @if($ThumbnailSetting->free_or_cost_label == 1)
                                                      @if($latest_serie->access == 'subscriber')
                                                          <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                      @elseif($latest_serie->access == 'registered')
                                                          <p class="p-tag">{{ __('Register Now') }}</p>
                                                      @elseif(!empty($latest_serie->ppv_status))
                                                          <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_price }}</p>
                                                      @elseif(!empty($latest_serie->ppv_status) || (!empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null))
                                                          <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_status }}</p>
                                                      @elseif($latest_serie->ppv_status == null && $latest_serie->ppv_price == null)
                                                          <p class="p-tag">{{ __('Free') }}</p>
                                                      @endif
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="block-description">
                                              <a class="playTrailer" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                  @if($ThumbnailSetting->free_or_cost_label == 1)
                                                      @if($latest_serie->access == 'subscriber')
                                                          <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                      @elseif($latest_serie->access == 'registered')
                                                          <p class="p-tag">{{ __('Register Now') }}</p>
                                                      @elseif(!empty($latest_serie->ppv_status))
                                                          <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_price }}</p>
                                                      @elseif(!empty($latest_serie->ppv_status) || (!empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null))
                                                          <p class="p-tag1">{{ $currency->symbol . ' ' . $settings->ppv_status }}</p>
                                                      @elseif($latest_serie->ppv_status == null && $latest_serie->ppv_price == null)
                                                          <p class="p-tag">{{ __('Free') }}</p>
                                                      @endif
                                                  @endif
                                              </a>
                                              <div class="hover-buttons text-white"> 
                                                  <a class="text-white" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                      <p class="epi-name text-left m-0 mt-2">{{ __($latest_serie->title) }}</p>
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($latest_serie->description) > 75 ? substr(html_entity_decode(strip_tags($latest_serie->description)), 0, 75) . '...' : $latest_serie->description }}
                                                        </p>
                                                        <div class="movie-time d-flex align-items-center my-2">

                                                            @if($ThumbnailSetting->age == 1 && !($latest_serie->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $latest_serie->age_restrict . ' +' }}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($latest_serie->duration / 3600) > 0 ? floor($latest_serie->duration / 3600) . 'h ' : '') . floor(($latest_serie->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($latest_serie->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($latest_serie->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $latest_serie->featured == 1)
                                                                <span class="position-relative text-white">
                                                                    {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time d-flex align-items-center my-2">
                                                            <span class="position-relative badge p-1 mr-2">
                                                                @php 
                                                                    $SeriesSeason = App\SeriesSeason::where('series_id', $latest_serie->id)->count(); 
                                                                    echo $SeriesSeason . ' Season';
                                                                @endphp
                                                            </span>
                                                            <span class="position-relative badge p-1 mr-2">
                                                                @php 
                                                                    $Episode = App\Episode::where('series_id', $latest_serie->id)->count(); 
                                                                    echo $Episode . ' Episodes';
                                                                @endphp
                                                            </span>
                                                          <!--<span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $latest_serie->duration) }}</span>-->
                                                      </div>
                                                  </a>
                                                  <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/play_series/' . $latest_serie->slug) }}">
                                                      <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Series') }}
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endif

<script>
    var elem = document.querySelector('.latest-series-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
 </script>