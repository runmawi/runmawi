
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ __("Movies") }}
                    </h2>  
                </div>

                @if (($All_movies_list)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="list-inline row p-0 mb-0">
                            @forelse($All_movies_list as $key => $video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        
                                        <a href="{{ URL::to('category/videos/'.$video->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $video->image ?  URL::to('public/uploads/images/'.$video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                

                                                <div class="hover-buttons">
                                                    <a class="" href="{{ URL::to('category/videos/'.$video->slug ) }}">
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

                                            
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $All_movies_list->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    li.slide-item{padding:15px 6px;}
    section#iq-favorites{margin-top: 2%;}
</style>


<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
