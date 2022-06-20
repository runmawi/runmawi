@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">{{ "Category List" }}</h3>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                    <h6><?php  echo (strlen($category_lists->name) > 17) ? substr($category_lists->name,0,18).'...' : $category_lists->name; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp