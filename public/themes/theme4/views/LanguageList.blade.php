
@php
    include(public_path('themes/theme4/views/header.php'));
@endphp
     
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title">{{ __("Language List") }}</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($Languages)) 
                        @foreach($Languages as $language)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('language').'/'.$language->slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                        @if(!empty($language->language_image) && $language->language_image != null)
                                            <img src="<?php echo  URL::to('/') . '//public/uploads/Language/'.$language->language_image;  ?>" class="img-fluid w-100" alt="">
                                        @else
                                            <img src="<?= URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>" class="img-fluid w-100" alt="">
                                        @endif
                                        </div>
                            
                                        <div class="content_user" >
                                                <a href="{{ URL::to('language').'/'.$language->slug   }}">
                                                    <h4><?php  echo (strlen($language->name) > 17) ? substr($language->name,0,18).'...' : $language->name; ?></h4>
                                                </a>
                                            
                                    <div>
                                        
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
                        <h5 class="modal-title">{{ __('Share') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="icon-container1 d-flex">
                            <div class="smd">
                                <i class=" img-thumbnail fab fa-twitter fa-2x"
                                    style="color:#4c6ef5;background-color: aliceblue"></i>
                                <p>{{ __('Twitter') }}</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-facebook fa-2x"
                                    style="color: #3b5998;background-color: #eceff5;"></i>
                                <p>{{ __('Facebook') }}</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-reddit-alien fa-2x"
                                    style="color: #FF5700;background-color: #fdd9ce;"></i>
                                <p>{{ __('Reddit') }}</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-discord fa-2x "
                                    style="color: #738ADB;background-color: #d8d8d8;"></i>
                                <p>{{ __('Share') }}Discord</p>
                            </div>
                        </div>
                        <div class="icon-container2 d-flex">
                            <div class="smd">
                                <i class="img-thumbnail fab fa-whatsapp fa-2x"
                                    style="color:  #25D366;background-color: #cef5dc;"></i>
                                <p>{{ __('Whatsapp') }}</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-facebook-messenger fa-2x"
                                    style="color: #3b5998;background-color: #eceff5;"></i>
                                <p>{{ __('Share') }}Messenger</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-telegram fa-2x"
                                    style="color:  #4c6ef5;background-color: aliceblue"></i>
                                <p>{{ __('Telegram') }}</p>
                            </div>
                            <div class="smd">
                                <i class="img-thumbnail fab fa-weixin fa-2x"
                                    style="color: #7bb32e;background-color: #daf1bc;"></i>
                                <p>{{ __('WeChat') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label style="font-weight: 600">{{ __('Page Link') }} <span class="message"></span></label><br />
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
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp