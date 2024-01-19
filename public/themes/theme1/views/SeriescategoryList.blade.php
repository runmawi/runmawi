@php
    include(public_path('themes/theme1/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{ "Category List" }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('/series/category').'/'.$category_lists->slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <!-- <a href="{{ URL::to('/series/category').'/'.$category_lists->slug   }}">
                                                    <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid w-100" alt="">
                                                </a> -->
                                            <div class="hover-buttons">
                                                <a class="text-white" href="{{ URL::to('/series/category').'/'.$category_lists->slug   }}">
                                                    <i class="fa fa-play mr-1"></i>{{ __('watch now')}} 
                                                </a>
                                               
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $category_lists->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div> </div>
                                </a>
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
    include(public_path('themes/theme1/views/footer.blade.php'));
@endphp