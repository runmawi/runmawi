@php
    include(public_path('themes/theme4/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid pl-0">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between mt-4">
                    <h4 class="vid-title mar-left">{{ __("List of Categories") }}</h4>                     
                </div>

                <div class="trending-contens sub_dropdown_image mt-3">
                        <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                        @if(isset($category_list)) 
                        @foreach($category_list as $key => $category_lists)
                                <div class="network-image">
                                    <div class="movie-sdivck position-relative">
                                        <img src="{{ $category_lists->image ?  URL::to('public/uploads/videocategory/'.$category_lists->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                      
                                        <div class="controls">        
                                            <a href="{{ URL::to('category').'/'.$category_lists->slug   }}">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>
                                            <nav>
                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#network-series-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade info_model" id="network-series-{{ $key }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                        <div class="container">
                                            <div class="modal-content" style="border:none; background:transparent;">
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <img src="{{ $category_lists->image ?  URL::to('public/uploads/videocategory/'.$category_lists->banner_image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                                        <h2 class="caption-h2">{{ optional($category_lists)->name }}</h2>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if (optional($category_lists)->description)
                                                                    <div class="trending-dec">{!! html_entity_decode( optional($category_lists)->description) !!}</div>
                                                                @endif
                                                                <a href="{{ URL::to('category').'/'.$category_lists->slug   }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                                    <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                                </a>
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
                        </div>
                    </div>


            </div>
        </div>
    </div>
</section>

@php
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp

<style>
    
div#trending-slider-nav{display: flex;
    flex-wrap: wrap;}
    .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
    .network-image img{width: 100%; height:auto;}
    .movie-sdivck{padding:2px;}
    #trending-slider-nav div.slick-slide{padding:2px;}
    div#trending-slider-nav .slick-slide.slick-current .movie-sdivck.position-relative{border:2px solid red}
    .sub_dropdown_image .network-image:hover .controls {
    opacity: 1;
    background-image: linear-gradient(0deg, black, transparent);
    border: 2px solid #2578c0 !important;
}
    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
    }
</style>