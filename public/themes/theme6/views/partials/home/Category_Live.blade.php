@php
   include(public_path('themes/theme6/views/header.php'));
@endphp

<style>
/* <!-- BREADCRUMBS  */
.bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
    content: none;
}

ol.breadcrumb {
    color: white;
    background-color: transparent !important;
    font-size: revert;
}

.nav-div.container-fluid {
    padding: 0;
}
.nav-tabs{border-bottom: none;}
</style>
<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title text-center">{{ __("Live Category Video") }}</h4>
                </div>

                <!-- BREADCRUMBS -->
                <div class="row d-flex">
                    <div class="nav nav-tabs nav-fill nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="black-text" href="{{ route('liveList') }}">{{ ucwords('live Stream') }}</a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="black-text" href="{{ route('CategoryLive') }}">{{ ucwords('Live Category') }}</a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="black-text">
                                        {{ strlen($category_title) > 50 ? ucwords(substr($category_title, 0, 120) . '...') : ucwords($category_title) }}
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if(count($Live_Category) > 0)

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @foreach($Live_Category as $LiveCategory)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{ url('live/' . $LiveCategory->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ url('/public/uploads/images/' . $LiveCategory->image) }}"
                                                        class="img-fluid w-100" alt="{{ $LiveCategory->title }}">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($LiveCategory->title) > 17 ? substr($LiveCategory->title, 0, 18) . '...' : $LiveCategory->title }}
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
                        <h5 class="text-center">{{ ('Content is not available currently.') }}</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>



@php
   include(public_path('themes/theme6/views/footer.blade.php'));
@endphp