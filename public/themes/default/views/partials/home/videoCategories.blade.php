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
                        <h4 class="main-title view-all">
                              <a href="{{ $order_settings_list[11]->header_name ? url('/' . $order_settings_list[11]->url) : '' }}">
                                 {{ __('View all') }}
                              </a>
                        </h4>
                     @endif
                  </div>

                  <div class="favorites-contens">
                     <div class="video-category home-sec list-inline row p-0 mb-0">
                        @php
                              $parentCategories = App\VideoCategory::where('in_home', '=', 1)->orderBy('order', 'ASC')->get();
                        @endphp

                        @if(isset($parentCategories))
                              @foreach($parentCategories as $Categories)
                                 <div class="items">
                                    <div class="block-images position-relative">
                                          <div class="border-bg">
                                             <div class="img-box">
                                                <a class="playTrailer" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                      <div>
                                                         @if ($multiple_compress_image == 1)
                                                             <img class="img-fluid w-100 flickity-lazyloaded" alt="{{ $Categories->title }}" src="{{ $Categories->image }}"
                                                                 srcset="{{ $Categories->responsive_image ? (URL::to('public/uploads/PCimages/'.$Categories->responsive_image.' 860w')) : $Categories->image }},
                                                                 {{ $Categories->responsive_image ? URL::to('public/uploads/Tabletimages/'.$Categories->responsive_image.' 640w') : $Categories->image }},
                                                                 {{ $Categories->responsive_image ? URL::to('public/uploads/mobileimages/'.$Categories->responsive_image.' 420w') : $Categories->image }}" >
                                                         @else
                                                             <img src="{{ $Categories->image ? URL::to('public/uploads/videocategory/' . $Categories->image) : $default_vertical_image }}" class="img-fluid w-100 flickity-lazyloaded" alt="{{ $Categories->title }}">
                                                         @endif
                                                     </div>
                                                </a>
                                             </div>
                                          </div>

                                          <div class="block-description">
                                             <a aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                <div class="hover-buttons text-white">
                                                   <a aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                         @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left mt-2 m-0">
                                                               {{ Str::limit($Categories->name, 18) }}
                                                            </p>
                                                         @endif

                                                         @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                               {{ strlen($Categories->description) > 75 ? substr(html_entity_decode(strip_tags($Categories->description)), 0, 75) . '...' : strip_tags($Categories->description) }}
                                                            </p>
                                                         @endif

                                                   </a>
                                                   <a class="epi-name mt-2 mb-0 btn" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                         <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                                   </a>
                                                </div>
                                             </a>
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
    var elem = document.querySelector('.video-category');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: true,
    });
 </script>