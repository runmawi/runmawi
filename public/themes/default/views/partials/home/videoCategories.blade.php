@if (!empty($data) && $data->isNotEmpty())

      @php
         $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
      @endphp

      <section id="iq-favorites">
         <div class="container-fluid overflow-hidden">
            <div class="row">
               <div class="col-sm-12 ">

                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                     <h4 class="main-title">
                        <a href="{{ $order_settings_list[11]->header_name ? url('/' . $order_settings_list[11]->url) : '' }}">
                              {{ $order_settings_list[11]->header_name ? __($order_settings_list[11]->header_name) : '' }}
                        </a>
                     </h4>
                     @if($settings->homepage_views_all_button_status == 1)
                        <h4 class="main-title">
                              <a href="{{ $order_settings_list[11]->header_name ? url('/' . $order_settings_list[11]->url) : '' }}">
                                 {{ __('View All') }}
                              </a>
                        </h4>
                     @endif
                  </div>

                  <div class="favorites-contens">
                     <ul class="favorites-slider list-inline row p-0 mb-0">
                        @php
                              $parentCategories = App\VideoCategory::where('in_home', '=', 1)->orderBy('order', 'ASC')->get();
                        @endphp

                        @if(isset($parentCategories))
                              @foreach($parentCategories as $Categories)
                                 <li class="slide-item">
                                    <div class="block-images position-relative">
                                          <div class="border-bg">
                                             <div class="img-box">
                                                <a class="playTrailer" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ url('public/uploads/videocategory/' . $Categories->image) }}" alt="l-img">
                                                </a>
                                             </div>
                                          </div>

                                          <div class="block-description">
                                             <a class="playTrailer" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                {{-- <img loading="lazy" data-src="{{ url('public/uploads/videocategory/' . $Categories->player_image) }}" class="img-fluid loading w-100" alt="l-img"> --}}
                                             </a>

                                             <div class="hover-buttons text-white">
                                                <a aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                      @if($ThumbnailSetting->title == 1)
                                                         <p class="epi-name text-left m-0">
                                                            {{ Str::limit($Categories->name, 18) }}
                                                         </p>
                                                      @endif
                                                </a>
                                                <a class="epi-name mt-5 mb-0 btn" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                      <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> Watch Now
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