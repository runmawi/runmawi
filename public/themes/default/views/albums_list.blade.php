@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title text-center mt-3 mb-3 font-weight-bold">{{  $page_name." ".__("List") }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        @if(count($albums_list) > 0 )
                            @if(isset($albums_list)) 
                                @foreach($albums_list as $albums_lists)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href=" {{ URL::to('home') }} ">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <a href="<?php echo URL::to('album') ?><?= '/' . $albums_lists->slug ?>">
                                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/albums/'.$albums_lists->album;  ?>" class="img-fluid w-100" alt=""> 
                                                    </a>
                                                </div>
                                    
                                                <div class="block-description" >
                                                  
                                                    <div class="hover-buttons">
                                                            <a  href="<?php echo URL::to('album') ?><?= '/' . $albums_lists->slug ?>">
                                                                <h5 class="font-weight-bold"><?php  echo (strlen($albums_lists->albumname) > 17) ? substr($albums_lists->albumname,0,18).'...' : $albums_lists->albumname; ?></h5>
                                                                <p class="text-white mt-2 mb-0" style=" font-size: 14px;">{{  __("View Profile") }}</p>
                                                            </a>
                                                    </div>
                                            </div>
                                                 
                                            </div>
                                              <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $albums_lists->slug  ;?>">
                                                    <span class="text-center thumbarrow-sec"></span>
                                                </button>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @else
                            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                <p ><h3 class="text-center"> {{  __("No").' '. $page_name .' '. __("Available") }} </h3>
                            </div>
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

