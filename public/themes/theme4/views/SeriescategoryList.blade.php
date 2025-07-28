@php
    include(public_path('themes/theme4/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid pl-0">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title mar-left">{{ __("List of Categories") }}</h4>                     
                </div>

                <div class="favorites-contens sub_dropdown_image">
                    <ul class="category-page list-inline row p-0 mar-left">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <div class=" position-relative">
                                    <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image; ?>" class="img-fluid w-100" alt="">
                                    <div class="controls">
                                        <a href="{{ URL::to('/series/category').'/'.$category_lists->slug}}">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                        <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#series-category-list-{{ $category_lists->id }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                    </div>
                                </div>
                            </li>

                            <div class="modal fade info_model" id="series-category-list-{{ $category_lists->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                    <div class="container">
                                        <div class="modal-content" style="border:none; background:transparent;">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <img src="{{ $category_lists->banner_image ? URL::to('/public/uploads/videocategory/'.$category_lists->banner_image) : URL::to('/public/uploads/videocategory/'.$category_lists->image) }}" class="img-fluid w-100" alt="">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                                    <h2 class="caption-h2">{{ optional($category_lists)->name }}</h2>
                                                                </div>

                                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <a href="{{ URL::to('/series/category').'/'.$category_lists->slug}}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp