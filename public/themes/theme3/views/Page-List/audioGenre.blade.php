
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[21]->header_name ? __($order_settings_list[21]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($audiogenre_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($audiogenre_pagelist as $key => $audioGenre)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <!-- block-images -->
                                        <div class="border-bg">
                                           <div class="img-box">
                                                 <a class="playTrailer" href="{{ URL::to('album/'.$audioGenre->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $audioGenre->album ? URL::to('public/uploads/audios/'.$audioGenre->album) : $default_vertical_image_url }}" alt="{{ $audioGenre->albumname }}">
                                                 </a>   
                                           </div>
                                        </div>
                                        <div class="block-description">
                                           <div class="hover-buttons text-white">
                                                 <a class="epi-name mt-5 mb-0" href="{{ URL::to('album/'.$audioGenre->slug) }}">
                                                    <i class="ri-play-fill"></i>
                                                 </a>                         
                                                 <a href="{{ URL::to('album/'.$audioGenre->slug) }}">
                                                    <p class="epi-name text-left m-0 mt-3">{{ $Audio_Category->name }}</p>
                                                 </a>
                                                 <div class="d-flex align-items-center justify-content-between">
                                                    <span class="text-white"><small>{{ get_audio_artist($audioGenre->id) }}</small></span>
                                                 </div>
                                           </div>
                                        </div>
                                     </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $audiogenre_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
