@php
    include(public_path('themes/theme4/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title text-center">{{ __("List of Categories") }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <a href="{{ URL::to('/series/category').'/'.$category_lists->slug   }}">
                                            <div class="block-description" >
                                                <div>
                                                    <span class="d-flex justify-content-center mt-3">
                                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" style="width:22px;"/>

                                                        <p class="hover_tex pl-4 m-0"><?php  echo (strlen($category_lists->name) > 17) ? substr($category_lists->name,0,18).'...' : $category_lists->name; ?></p>
                                                    
                                                        <!-- <button class="btn btn-hover">View Channel</button> -->
                                                    </span>
                                                </div>
                                            <div>
                                        </a>
                                    </div>
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
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp