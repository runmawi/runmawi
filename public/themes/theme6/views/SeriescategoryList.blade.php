@php
    include(public_path('themes/default/views/header.php'));
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
                                    <a href="{{ URL::to('category/videos/'.$latest_video->slug ) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> {{ strlen($category_lists->name) > 17 ? substr($category_lists->name, 0, 18) . '...' : $category_lists->name }}
                                                </h6>
                                                <!-- <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($category_lists)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $category_lists->duration != null ? gmdate('H:i:s', $category_lists->duration) : null }}
                                                    </span>
                                                </div> -->

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
                                                    <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li>
                                                </ul>
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
                                <a href="{{ URL::to('/series/category').'/'.$category_lists->slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$category_lists->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="{{ URL::to('/series/category').'/'.$category_lists->slug   }}">
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp