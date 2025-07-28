
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                        {{ $order_settings_list[11]->header_name ? __($order_settings_list[11]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($category_videos_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($category_videos_pagelist as $key => $Categories)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                           <div class="img-box">
                                              <a class="playTrailer" aria-label="{{ $Categories->name }}" href="{{ url('/category/' . $Categories->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $Categories->image ? URL::to('public/uploads/videocategory/' . $Categories->image) : $default_vertical_image_url }}" alt="{{ $Categories->name }}">
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
                                                       <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> {{ __('Watch Now') }}
                                                 </a>
                                              </div>
                                           </a>
                                        </div>
                                  </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $category_videos_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
