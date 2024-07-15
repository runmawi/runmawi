@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{ __("Category List") }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">

                                <div class="block-images position-relative">
                                    <div class="border-bg">
                                       <div class="img-box">
                                          <a class="playTrailer" aria-label="{{ $category_lists->name }}" href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $category_lists->image ? URL::to('public/uploads/videocategory/' . $category_lists->image) : $default_vertical_image_url }}" alt="{{ $category_lists->name }}">
                                          </a>
                                       </div>
                                    </div>

                                    <div class="block-description">
                                       <a aria-label="{{ $category_lists->name }}" href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                          <div class="hover-buttons text-white">
                                             <a aria-label="{{ $category_lists->name }}" href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                      <p class="epi-name text-left mt-2 m-0">
                                                         {{ Str::limit($category_lists->name, 18) }}
                                                      </p>

                                                   <p class="desc-name text-left m-0 mt-1">
                                                      {{ strlen($category_lists->description) > 75 ? substr(html_entity_decode(strip_tags($category_lists->description)), 0, 75) . '...' : strip_tags($category_lists->description) }}
                                                   </p>

                                             </a>
                                             <a class="epi-name mt-2 mb-0 btn" aria-label="{{ $category_lists->name }}" href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                   <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> {{ __('Visit Category') }}
                                             </a>
                                          </div>
                                       </a>
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

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp