@php
    include(public_path('themes/theme1/views/header.php'));
@endphp
    
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">{{ __("channel List") }}</h3>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($channels)) 
                        @foreach($channels as $channel)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="{{ URL::to('channel').'/'.$channel->channel_slug   }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                        @if(!empty($channel->channel_image) && $channel->channel_image != null)
                                            <img src="<?php echo $channel->channel_image;  ?>" class="img-fluid w-100" alt="">
                                        @else
                                            <img src="<?= URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>" class="img-fluid w-100" alt="">
                                        @endif
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


@php
include(public_path('themes/theme1/views/footer.blade.php'));
@endphp