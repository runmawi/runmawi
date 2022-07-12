@php
    include(public_path('themes/theme2/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">{{  "Artist List" }}</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between"> </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(count($artist_list) > 0 )
                                @if(isset($artist_list)) 
                                    @foreach($artist_list as $artist_lists)

                                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                            <a href="{{ URL::to('artist').'/'.$artist_lists->artist_slug  }}">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist_lists->image;  ?>" class="img-fluid loading" alt=""> 
                                                    </div>

                                                    <div class="block-description">
                                                        <div class="hover-buttons">
                                                            <a href="{{ URL::to('artist').'/'.$artist_lists->artist_slug   }}">
                                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                            </a>
                                                        <div>
                                                    </div>
                                                </div> </div> </div>
                
                                                <div class="">
                                                    <div class="mt-2 d-flex justify-content-between p-0">
                                                        <h6><?php  echo (strlen($artist_lists->artist_name) > 17) ? substr($artist_lists->artist_name,0,18).'...' : $artist_lists->artist_name; ?></h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                @else
                                <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p ><h3 class="text-center">No Artist Available</h3>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</section>
@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp