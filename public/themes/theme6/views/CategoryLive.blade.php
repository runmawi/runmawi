@php
    include(public_path('themes/theme6/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title">{{ __('Category Live List') }} </h4>
                </div>

                @if(count($category_list) > 0)

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach($category_list as $category_lists)
                                <li class="slide-item">
                                    <a href="{{ URL::to('LiveCategory').'/'.$category_lists->slug   }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/livecategory/'.$category_lists->image;  ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($category_lists->name) > 17 ? substr($category_lists->name, 0, 18) . '...' : $category_lists->name }}
                                                </h6>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __("Play Now") }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h5 class="text-center">{{ __("Content is not available currently.") }}</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@php
    include(public_path('themes/theme6/views/footer.blade.php'));
@endphp