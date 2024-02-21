@php
    include(public_path('themes/theme3/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{ "Category List" }}</h4>                     
                </div>

                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        @if(isset($category_list)) 
                            @foreach($category_list as $category_lists)
                                <li class="slide-item">
                                    <a href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">

                                                <div class="hover-buttons">
                                                    <a class="" href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                        <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                            <span class="text pr-2"> Play </span>
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>




                <!-- <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($category_list)) 
                        @foreach($category_list as $category_lists)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('category').'/'.$category_lists->slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid w-100" alt="">
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
                </div> -->
            </div>
        </div>
    </div>
</section>

@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp