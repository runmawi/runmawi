@php
    include(public_path('themes/theme7/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{ __("My Playlist") }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($MyPlaylist)) 
                        @foreach($MyPlaylist as $My_Playlist)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('/playlist').'/'.$My_Playlist->slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo $My_Playlist->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="{{ URL::to('/playlist').'/'.$My_Playlist->slug   }}">
                                                    <h6><?php  echo (strlen($My_Playlist->title) > 17) ? substr($My_Playlist->title,0,18).'...' : $My_Playlist->title; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $My_Playlist->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div> </div>
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
    include(public_path('themes/theme7/views/footer.blade.php'));
@endphp