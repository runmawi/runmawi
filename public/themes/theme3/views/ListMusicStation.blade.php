
@php
    include(public_path('themes/theme3/views/header.php'));
@endphp
     
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title">{{ "All Music Station" }}</h4>  
                    <div class="pull-right"> 
                    <a href="{{ URL::to('/create-station')   }}">
                        <button  class="btn btn-primary"> Create Station</button>
                    </a>
                    </div>
                </div>
                @if(count($MusicStation) == 0)
                    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p ><h3 class="text-center">No Station Available</h3>
                    </div>
                @else
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($MusicStation)) 
                        @foreach($MusicStation as $Music_Station)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('music-station').'/'.$Music_Station->station_slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="https://via.placeholder.com/128/fe669e/ffcbde.png?text=<?= ucfirst(substr($Music_Station->station_name,0,1)) ?>"
                                             class="img-fluid w-100" alt="">
                                             <!-- src="<?php //echo $Music_Station->image;  ?>" -->
                                        </div>
                            
                                        <div class="Music_Station row justify-content-between" >
                                                <a href="{{ URL::to('music-station').'/'.$Music_Station->station_slug   }}">
                                                    <h4><?php  echo (strlen($Music_Station->station_name) > 12) ? substr($Music_Station->station_name,0,10).'...' : $Music_Station->station_name; ?></h4>
                                                </a>
                                                <a href="{{ URL::to('delete-station').'/'.$Music_Station->id   }}">
                                                   <h6 class='trash'><i class="fa fa-trash"></i></h6>
                                                </a>
                                    <div>
                                        
                                    </div> </div> </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content col-12">
                    <div class="modal-header">
                        <h5 class="modal-title">Share</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="icon-container1 d-flex">
                            <div class="smd">
                                <i class=" img-thumbnail fab fa-twitter fa-2x"
                                    style="color:#4c6ef5;background-color: aliceblue"></i>
                                <p>Twitter</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-facebook fa-2x"
                                    style="color: #3b5998;background-color: #eceff5;"></i>
                                <p>Facebook</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-reddit-alien fa-2x"
                                    style="color: #FF5700;background-color: #fdd9ce;"></i>
                                <p>Reddit</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-discord fa-2x "
                                    style="color: #738ADB;background-color: #d8d8d8;"></i>
                                <p>Discord</p>
                            </div>
                        </div>
                        <div class="icon-container2 d-flex">
                            <div class="smd">
                                <i class="img-thumbnail fab fa-whatsapp fa-2x"
                                    style="color:  #25D366;background-color: #cef5dc;"></i>
                                <p>Whatsapp</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-facebook-messenger fa-2x"
                                    style="color: #3b5998;background-color: #eceff5;"></i>
                                <p>Messenger</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-telegram fa-2x"
                                    style="color:  #4c6ef5;background-color: aliceblue"></i>
                                <p>Telegram</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-weixin fa-2x"
                                    style="color: #7bb32e;background-color: #daf1bc;"></i>
                                <p>WeChat</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label style="font-weight: 600">Page Link <span class="message"></span></label><br />
                        <div class="row">
                            <input class="col-10 ur" type="url" placeholder="https://www.arcardio.app/acodyseyy"
                                id="myInput" aria-describedby="inputGroup-sizing-default" style="height: 40px;">
                            <button class="cpy" onclick="myFunction()"><i class="far fa-clone"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp