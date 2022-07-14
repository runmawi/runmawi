@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title text-center mt-3 mb-3">{{ "Artist List" }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        @if(count($artist_list) > 0 )
                            @if(isset($artist_list)) 
                                @foreach($artist_list as $artist_lists)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href=" {{ URL::to('home') }} ">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <a href="<?php echo URL::to('artist') ?><?= '/' . $artist_lists->artist_slug ?>">
                                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist_lists->image;  ?>" class="img-fluid w-100" alt=""> 
                                                    </a>
                                                </div>
                                    
                                                <div class="block-description" >
                                                  
                                                    <div class="hover-buttons">
                                                          <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                                        <a  href="<?php echo URL::to('artist') ?><?= '/' . $artist_lists->artist_slug ?>">
                                                            <h6><?php  echo (strlen($artist_lists->artist_name) > 17) ? substr($artist_lists->artist_name,0,18).'...' : $artist_lists->artist_name; ?></h6>
                                                            <p class="text-white mt-2">View Profile</p>
                                                        </a>
                                                    <?php } ?> 
                                                        <div>
                                                </div>
                                            </div>
                                            <div>
                                             
                                            </div> </div>
                                                 
                                            </div>
                                              <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $artist_lists->artist_slug  ;?>">
                                                    <span class="text-center thumbarrow-sec"></span>
                                                </button>
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

