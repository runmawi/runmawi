
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular">
                        {{ $order_settings_list[11]->header_name ? __($order_settings_list[11]->header_name) : '' }}
                    </h4>  
                </div>

                @if (($category_videos_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($category_videos_pagelist as $key => $videoCategories)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{ url('/category/' . $videoCategories->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $videoCategories->image ?  URL::to('public/uploads/videocategory/'.$videoCategories->image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <p> {{ strlen($videoCategories->name ) > 17 ? substr($videoCategories->name , 0, 18) . '...' : $videoCategories->name  }}</p>


                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                      {{ __('Visit Category')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
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
