<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;
    }
</style>
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col-sm-12 ">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading"
                    style="text-decoration: none; color: #fff;">
                    <h4 class="movie-title">
                        <?php 
                         $setting= \App\HomeSetting::first();
                            if($setting['Recommendation'] !=null && $setting['Recommendation'] != 0 ):

                         echo (__('Most watched videos from').__($category->name).__('Genre'));?>
                    </h4>
                </a>
                <h4 class="main-title"><a href="<?php echo URL::to('/category/').'/'.$category->slug;?>">
                        <?php echo (__('View All')); ?>
                    </a></h4>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline row p-0 mb-0">
                    <?php  
                if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                    <?php  if(isset($top_category_videos)) :
                       foreach($top_category_videos as $category_video):
                        
                        ?>
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer"
                                        href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                        <img loading="lazy"
                                            data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"
                                            class="img-fluid loading w-100" alt="m-img" />

                                    </a>

                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php if($category_video->access == 'subscriber' ){ ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($category_video->access == 'registered'){?>
                                    <p class="p-tag">
                                        <?php echo (__('Register Now')); ?>
                                    </p>
                                    <?php } elseif(!empty($category_video->ppv_price)) { 
                             echo $currency->symbol.' '.$category_video->ppv_price ; 
                            } 
                            elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null)
                             { 
                                echo $currency->symbol.' '.$category_video->ppv_price ; 
                        } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) { echo "Free"; } ?>
                                    </p>
                                    <?php }?>
                                </div>
                            </div>


                        </div>
                    </li>
                    <?php           
                          endforeach; 
                     endif; endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>