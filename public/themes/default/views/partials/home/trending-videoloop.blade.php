@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        @if (!preg_match('/^channel\/.+$/', request()->path()))
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                    {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                                </a>
                            </h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h5 class="main-title view-all">
                                    <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                        {{ __('View all') }}
                                    </a>
                                </h5>
                            @endif
                        @else
                        <h4 class="main-title fira-sans-condensed-regular"><a href="{{ URL::to('channel/Featured_videos/'.$channel_partner_slug) }}">{{ optional($order_settings_list[0])->header_name }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h5 class="main-title view-all fira-sans-condensed-regular"><a href="{{ URL::to('channel/Featured_videos/'.$channel_partner_slug) }}">{{ 'View all' }}</a></h5>
                            @endif
                        @endif
                    </div>

                  <div class="favorites-contens">
                      <div class="featured-video home-sec list-inline row p-0 mb-0">
                          @if(isset($data))
                              @php
                                  $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
                              @endphp
                              @foreach($data as $watchlater_video)
                                  @php
                                      $currentdate = date("M d , y H:i:s");
                                      date_default_timezone_set('Asia/Kolkata');
                                      $current_date = date("M d , y H:i:s");
                                      $date = date_create($current_date);
                                      $currentdate = date_format($date, "D h:i");
                                      $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));
                                      if ($watchlater_video->publish_type == 'publish_later') {
                                          $publish_time = $currentdate < $publish_time ? $publish_time : 'Published';
                                      } elseif ($watchlater_video->publish_type == 'publish_now') {
                                          $currentdate = date_format($date, "y M D");
                                          $publish_time = date("y M D", strtotime($watchlater_video->publish_time));
                                          $publish_time = $currentdate == $publish_time ? 'Today ' . date("h:i", strtotime($watchlater_video->publish_time)) : 'Published';
                                      } else {
                                          $publish_time = '';
                                      }
                                  @endphp
                                  <div class="items">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                    <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}" aria-label="Trending">
                                                        <div>
                                                            @if ($multiple_compress_image == 1)
                                                                <img class="img-fluid w-100 flickity-lazyloaded" alt="{{ $watchlater_video->title }}" data-flickity-lazyload="{{ $watchlater_video->image }}"
                                                                srcset="{{ $watchlater_video->responsive_image ? (URL::to('public/uploads/PCimages/'.$watchlater_video->responsive_image.' 860w')) : $watchlater_video->image }},
                                                                {{ $watchlater_video->responsive_image ? URL::to('public/uploads/Tabletimages/'.$watchlater_video->responsive_image.' 640w') : $watchlater_video->image }},
                                                                {{ $watchlater_video->responsive_image ? URL::to('public/uploads/mobileimages/'.$watchlater_video->responsive_image.' 420w') : $watchlater_video->image }}" >
                                                            @else
                                                                <img data-flickity-lazyload="{{ $watchlater_video->image ? URL::to('public/uploads/images/'.$watchlater_video->image) : $default_vertical_image_url }}" class="img-fluid w-100 flickity-lazyloaded" alt="{{ $watchlater_video->title }}">
                                                            @endif
                                                        </div>
                                                    </a>
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @elseif($watchlater_video->access == 'registered')
                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @elseif(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @elseif(!empty($watchlater_video->global_ppv) || (!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null))
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @endif
                                                    @endif
                                              </div>
                                          </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}" aria-label="Trending">
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @elseif($watchlater_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @elseif(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @elseif(!empty($watchlater_video->global_ppv) || (!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null))
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @endif
                                                    @endif
                                                </a>
                                                <div class="hover-buttons text-white">
                                                    <a href="{{ url('category/videos/' . $watchlater_video->slug) }}" aria-label="{{ $watchlater_video->title }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0 mt-2">
                                                                {{ Str::limit($watchlater_video->title, 18) }}
                                                            </p>
                                                        @endif
                                                        
                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($watchlater_video->description) > 75 ? substr(html_entity_decode(strip_tags($watchlater_video->description)), 0, 75) . '...' : strip_tags($watchlater_video->description) }}
                                                            </p>
                                                        @endif
                                                        

                                                            <div class="movie-time d-flex align-items-center row pt-2">
                                                                @if($ThumbnailSetting->age == 1 && !($watchlater_video->age_restrict == 0))
                                                                    <span class="position-relative badge p-1 mr-2">{{ $watchlater_video->age_restrict }}</span>
                                                                @endif

                                                                @if($ThumbnailSetting->duration == 1)
                                                                    <span class="position-relative text-white mr-2">
                                                                        {{ (floor($watchlater_video->duration / 3600) > 0 ? floor($watchlater_video->duration / 3600) . 'h ' : '') . floor(($watchlater_video->duration % 3600) / 60) . 'm' }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->published_year == 1 && !($watchlater_video->year == 0))
                                                                    <span class="position-relative badge p-1 mr-2">
                                                                        {{ __($watchlater_video->year) }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1)
                                                                    <span class="position-relative text-white">
                                                                        {{ __('Featured') }}
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            @php
                                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $watchlater_video->id)
                                                                ->pluck('video_categories.name');
                                                                @endphp
                                                            @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <div class="movie-time d-flex align-items-center pt-1 text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                            </div>
                                                            @endif
                                                    </a>
                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Watch Now') }}
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
    var elem = document.querySelector('.featured-video');
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