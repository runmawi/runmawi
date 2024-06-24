@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                      <h2 class="main-title">
                          <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                              {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                          </a>
                      </h2>
                      @if($settings->homepage_views_all_button_status == 1)
                          <h2 class="main-title">
                              <a href="{{ $order_settings_list[0]->header_name ? url('/' . $order_settings_list[0]->url) : '' }}">
                                  {{ __('View All') }}
                              </a>
                          </h2>
                      @endif
                  </div>

                  <div class="favorites-contens">
                      <ul class="favorites-slider list-inline row p-0 mb-0">
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
                                  <li class="slide-item">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}" aria-label="Trending">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->image ? URL::to('public/uploads/images/' . $watchlater_video->image) : $default_vertical_image_url }}" src="{{ $watchlater_video->image ? URL::to('public/uploads/images/' . $watchlater_video->image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">
                                                  </a>
                                                  @if($ThumbnailSetting->free_or_cost_label == 1)
                                                      @if($watchlater_video->access == 'subscriber')
                                                          <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
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
                                                  <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->player_image ? URL::to('public/uploads/images/' . $watchlater_video->player_image) : $default_vertical_image_url }}" src="{{ $watchlater_video->player_image ? URL::to('public/uploads/images/' . $watchlater_video->player_image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">
                                                  @if($ThumbnailSetting->free_or_cost_label == 1)
                                                      @if($watchlater_video->access == 'subscriber')
                                                          <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
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
                                                          <p class="epi-name text-left m-0">
                                                              {{ Str::limit($watchlater_video->title, 18) }}
                                                          </p>
                                                      @endif

                                                      <div class="movie-time d-flex align-items-center pt-1">
                                                          @if($ThumbnailSetting->age == 1)
                                                              <div class="badge badge-secondary p-1 mr-2">{{ $watchlater_video->age_restrict . ' +' }}</div>
                                                          @endif

                                                          @if($ThumbnailSetting->duration == 1)
                                                              <span class="text-white">
                                                                  <i class="fa fa-clock-o"></i>
                                                                  {{ gmdate('H:i:s', $watchlater_video->duration) }}
                                                              </span>
                                                          @endif
                                                      </div>

                                                      @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                          <div class="movie-time d-flex align-items-center pt-1">
                                                              @if($ThumbnailSetting->rating == 1)
                                                                  <div class="badge badge-secondary p-1 mr-2">
                                                                      <span class="text-white">
                                                                          <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                          {{ __($watchlater_video->rating) }}
                                                                      </span>
                                                                  </div>
                                                              @endif

                                                              @if($ThumbnailSetting->published_year == 1)
                                                                  <div class="badge badge-secondary p-1 mr-2">
                                                                      <span class="text-white">
                                                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                          {{ __($watchlater_video->year) }}
                                                                      </span>
                                                                  </div>
                                                              @endif

                                                              @if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1)
                                                                  <div class="badge badge-secondary p-1 mr-2">
                                                                      <span class="text-white">
                                                                          <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                      </span>
                                                                  </div>
                                                              @endif
                                                          </div>
                                                      @endif

                                                      <div class="movie-time d-flex align-items-center pt-1">
                                                          @php
                                                              $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                  ->where('categoryvideos.video_id', $watchlater_video->id)
                                                                  ->pluck('video_categories.name');
                                                          @endphp
                                                          @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                              <span class="text-white">
                                                                  <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                  {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                              </span>
                                                          @endif
                                                      </div>
                                                  </a>
                                                  <a class="epi-name mt-3 mb-0 btn" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                      <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />
                                                      Watch Now
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>

                </div>
            </div>
        </div>
    </section>


@endif
