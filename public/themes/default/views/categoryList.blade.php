@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-favorites" class="category-list-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between py-3">
                    <h4 class="vid-title">{{ __("Category List") }}</h4>                     
                </div>
                
                @if (($category_list)->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="list-inline row p-0 mb-0">
                            @forelse($category_list as $category_lists)
                                <li class="slide-item col-sm-3 col-md-2 col-lg-2 col-xl-2 col-xs-12">

                                    <div class="card category-card shadow rounded mb-4">
                                        <img src="{{ $category_lists->image ? URL::to('public/uploads/videocategory/' . $category_lists->image) : $default_vertical_image_url }}" alt="{{ $category_lists->name }}" class="card-img-top img-fluid" style="object-fit: cover; height: 200px;">

                                        <div class="card-body p-3">
                                            <h6 class="card-title text-truncate">{{ Str::limit($category_lists->name, 20) }}</h6>
                                            
                                            <p class="card-text text-truncate mb-1">
                                                {{ strlen($category_lists->description) > 75 ? substr(html_entity_decode(strip_tags($category_lists->description)), 0, 75) . '...' : strip_tags($category_lists->description) }}
                                            </p>

                                            <a href="{{ URL::to('category').'/'.$category_lists->slug   }}" class="btn btn-primary btn-sm mt-2">
                                                {{ __('Visit Category') }}
                                            </a>
                                        </div>
                                    </div>

                                </li>
                                @empty
                                <div class="col-md-12 text-center mt-4"
                                     style="background: url(<?= URL::to('/assets/img/watch.png') ?>); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                         style="background: url(<?= URL::to('/assets/img/watch.png') ?>); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp
