@php
    include(public_path('themes/theme6/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{  __("Category List") }}</h4>                     
                </div>

                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        @if(isset($category_list)) 
                            @foreach($category_list as $category_lists)

                            <li class="slide-item">
                                <div class="block-images position-relative">
                                    
                                    <a href="{{ URL::to('category/videos/'.$category_lists->slug ) }}">

                                        <div class="img-box">
                                            <img src="{{ $category_lists->image ?  URL::to('public/uploads/videocategory/'.$category_lists->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                        </div>

                                        <div class="block-description">
                                            <p> {{ strlen($category_lists->name) > 17 ? substr($category_lists->name, 0, 18) . '...' : $category_lists->name }}
                                            </p>
                                            <div class="movie-time d-flex align-items-center my-2">

                                                <!-- <div class="badge badge-secondary p-1 mr-2">
                                                    {{ optional($category_lists)->age_restrict.'+' }}
                                                </div> -->

                                                <span class="text-white">
                                                    {{ $category_lists->duration != null ? gmdate('H:i:s', $category_lists->duration) : null }}
                                                </span>
                                            </div>

                                            <div class="hover-buttons">
                                                <span class="btn btn-hover">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    Visit Now
                                                </span>
                                                
                                            </div>
                                        </div>
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
    include(public_path('themes/theme6/views/footer.blade.php'));
@endphp