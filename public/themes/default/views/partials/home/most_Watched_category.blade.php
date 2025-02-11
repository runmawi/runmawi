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
        <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
            <h4 class="movie-title">
                <?php 
                         $setting= \App\HomeSetting::first();
                            if($setting['Recommendation'] !=null && $setting['Recommendation'] != 0 ):

                         echo (__('Most watched videos from').__($category->name).__('Genre'));?>
            </h4>
        </a>
        <?php if( $settings->homepage_views_all_button_status == 1 ):?>
            <h4 class="main-title view-all"><a href="<?php echo URL::to('/category/').'/'.$category->slug;?>"><?php echo (__('View all')); ?></a></h4>
        <?php endif; ?>
    </div>
    <div class="favorites-contens">
        <div class="most-watched-category home-sec list-inline row p-0 mb-0">
            <?php  
                if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
            <?php  if(isset($top_category_videos)) :
                       foreach($top_category_videos as $category_video):
                        
                        ?>
            <div class="items">
                <div class="block-images position-relative">
                    <!-- block-images -->
                    <div class="border-bg">
                        <div class="img-box">
                    <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                        <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"  alt="m-img" />
                      
                    </a>

                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                    <p class="p-tag1">
                        <?php if($category_video->access == 'subscriber' ){ ?>
                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                            <?php }elseif($category_video->access == 'registered'){?>
                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
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
             
                <div class="block-description">
                <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                        {{-- <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->player_image;  ?>" alt="m-img" /> --}}
                      
                   

                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                    <p class="p-tag1">
                        <?php if($category_video->access == 'subscriber' ){ ?>
                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                            <?php }elseif($category_video->access == 'registered'){?>
                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                            <?php } elseif(!empty($category_video->ppv_price)) { 
                             echo $currency->symbol.' '.$category_video->ppv_price ; 
                            } 
                            elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null)
                             { 
                                echo $currency->symbol.' '.$category_video->ppv_price ; 
                        } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) { echo "Free"; } ?>
                    </p>
                    <?php }?>
                    </a>
                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                    <p class="p-tag1">
                        <?php if($category_video->access == 'subscriber' ){ ?>
                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                            <?php }elseif($category_video->access == 'registered'){?>
                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                            <?php } elseif(!empty($category_video->ppv_price)) { 
                             echo $currency->symbol.' '.$category_video->ppv_price ; 
                            } 
                            elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null)
                             { 
                                echo $currency->symbol.' '.$category_video->ppv_price ; 
                        } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) { echo "Free"; } ?>
                    </p>
                    <?php }?>

                    <div class="hover-buttons text-white">
                       <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                            <?php if($ThumbnailSetting->title == 1) { ?>
                                <!-- Title -->
                            
                                <p class="epi-name text-left m-0">
                                    <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                </p>
                        
                            <?php } ?>

                            @if($ThumbnailSetting->enable_description == 1)
                                <p class="desc-name text-left m-0 mt-1">
                                    <?php echo strlen($category_video->description) > 75 ? substr(html_entity_decode(strip_tags($category_video->description)), 0, 75) . '...' : strip_tags($category_video->description) ?>
                                </p>
                            @endif

                            <div class="movie-time d-flex align-items-center pt-2">
                                <?php if($ThumbnailSetting->age == 1 && !($category_video->age_restrict == 0)) { ?>
                                    <!-- Age -->
                                    <span class="position-relative badge p-1 mr-2"><?php echo $category_video->age_restrict ?></span>
                                <?php } ?>

                                <?php if($ThumbnailSetting->duration == 1) { ?>
                                    <!-- Duration -->
                                    <span class="position-relative text-white mr-2">
                                        <?php echo (floor($category_video->duration / 3600) > 0 ? floor($category_video->duration / 3600) . 'h ' : '') . floor(($category_video->duration % 3600) / 60) . 'm' ?>
                                    </span>       
                                <?php } ?>

                                <?php if($ThumbnailSetting->published_year == 1 && !($category_video->year == 0)) { ?>
                                    <span class="position-relative badge p-1 mr-2">
                                        <?php echo ($category_video->year) ?>
                                    </span>
                                <?php } ?>

                                <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
                                    <span class="position-relative text-white">
                                        <?php echo ('Featured') ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="movie-time d-flex align-items-center pt-1">
                                <!-- Category Thumbnail  setting -->
                                <?php $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id',$category_video->id) ->pluck('video_categories.name'); ?>
                                <?php  if ( ($ThumbnailSetting->category == 1 ) && ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                <span class="text-white">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    <?php
                                                    $Category_Thumbnail = array();
                                                        foreach($CategoryThumbnail_setting as $key =>
                                    $CategoryThumbnail){ $Category_Thumbnail[] = $CategoryThumbnail ; } echo implode(','.' ', $Category_Thumbnail); ?>
                                </span>
                                <?php } ?>
                            </div>
                        </a>

              
                        <a class="epi-name mt-2 mb-0 btn" type="button" class="text-white d-flex align-items-center" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                            <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                        </a>
                    </div>
                </div>
                       </div>
            </div>
            <?php           
                          endforeach; 
                     endif; endif; ?>
        </div>
    </div>
</div>
</div>
</div>

<script>
    var elem = document.querySelector('."most-watched-category');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>