@php
    include(public_path('themes/theme3/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">{{  "Category List" }}</h3>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between"> </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($category_list)) 
                                @foreach($category_list as $category_lists)

                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('category').'/'.$category_lists->slug  }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                        </a>
                                                    <div>
                                                </div>
                                            </div> </div> </div>
            
                                            <div class="">
                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    <h6><?php  echo (strlen($category_lists->name) > 17) ? substr($category_lists->name,0,18).'...' : $category_lists->name; ?></h6>
                                                </div>
                                            </div>
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
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp