@if (!empty($data) && $data->isNotEmpty())

      @php 
          $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
          $my_play_list_settings_list = App\OrderHomeSetting::where('video_name', 'my_play_list')->first(); 
          $MyPlaylist = App\MyPlaylist::where('user_id', Auth::user()->id)->get();
      @endphp

      <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $my_play_list_settings_list->header_name ? url('/' . $my_play_list_settings_list->url) : '' }}">
                                {{ $my_play_list_settings_list->header_name ? __($my_play_list_settings_list->header_name) : '' }}
                            </a>
                        </h4> 
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $my_play_list_settings_list->header_name ? url('/' . $my_play_list_settings_list->url) : '' }}">
                                    {{ __('View All') }}
                                </a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="my-playlist home-sec list-inline row p-0 mb-0">
                              @foreach($data as $My_Playlist)
                                  <div class="items">
                                      <div class="block-images position-relative">
                                          <div class="border-bg">
                                              <div class="img-box">
                                                  <a class="playTrailer" href="{{ url('/playlist/' . $My_Playlist->slug) }}">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ $My_Playlist->image ? $My_Playlist->image : $default_vertical_image_url }}" alt="{{ $My_Playlist->title }}">
                                                  </a>
                                              </div>
                                          </div>
                                          <div class="block-description">
                                              <a class="playTrailer" href="{{ url('/playlist/' . $My_Playlist->slug) }}">
                                                  {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $My_Playlist->player_image ? $My_Playlist->player_image : $default_vertical_image_url }}" alt="{{ $My_Playlist->title }}"> --}}
                                              </a>
                                              <div class="hover-buttons text-white">
                                                  <a href="{{ url('/playlist/' . $My_Playlist->slug) }}">
                                                        <p class="epi-name text-left mt-2 m-0">{{ $My_Playlist->title }}</p>

                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($My_Playlist->description) > 75 ? substr(html_entity_decode(strip_tags($My_Playlist->description)), 0, 75) . '...' : strip_tags($My_Playlist->description) }}
                                                        </p>
                                                  </a>
                                                  <a class="epi-name mt-3 mb-0 btn" href="{{ url('/playlist/' . $My_Playlist->slug) }}">
                                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                     {{ __(' Visit Audio PlayList') }}
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
    var elem = document.querySelector('.my-playlist');
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