
@php
    include(public_path('themes/default/views/header.php'));
@endphp
     
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title">{{ "Channel List" }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($channels)) 
                        @foreach($channels as $channel)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('channel').'/'.$channel->channel_slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo $channel->channel_image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="{{ URL::to('channel').'/'.$channel->channel_slug   }}">
                                                    <h6><?php  echo (strlen($channel->channel_name) > 17) ? substr($channel->channel_name,0,18).'...' : $channel->channel_name; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $channel->channel_slug;?>">
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp