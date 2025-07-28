<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title"><?= __('Category Audio') ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        @if(isset($AudioCategory) && count($AudioCategory) > 0)
                            @foreach($AudioCategory as $Audio_Category)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="<?php echo URL::to('audio/'.$Audio_Category->slug ) ?>">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Audio_Category->image;  ?>" class="img-fluid w-100" alt="">
                                            </div>
                                
                                            <div class="block-description" >
                                                    <a href="<?php echo URL::to('audio').'/'.$Audio_Category->slug  ?>">
                                                        <h6><?php  echo (strlen(@$Audio_Category->title) > 17) ? substr(@$Audio_Category->title,0,18).'...' : @$Audio_Category->title; ?></h6>
                                                    </a>
                                                <div class="hover-buttons"><div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= @$Audio_Category->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div> </div> </div>
                                    </a>
                                </li>
                                
                            @endforeach
                        @else
                            <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
                                <h4 class="main-title mb-4">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
                                <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


