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
                <a href="<?php echo URL::to('/audios/category') . '/' . $category->slug; ?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h5 class="movie-title">
                        <?php
                        if (!empty($category->name)) {
                            echo $category->name;
                        } else {
                            echo $category->name;
                        }
                        ?>
                    </h5>
                    <a class="see" href="<?php echo URL::to('/audios/category') . '/' . $category->slug; ?>"><?php echo (__('See all')); ?></a>
                </a>
            </div>
            <div class="favorites-contens"> 
                <div class="audio-categoryloop home-sec list-inline row p-0 mb-0">
                    <?php if (!Auth::guest() && !empty($data['password_hash'])) {
                        $id = Auth::user()->id;
                    } else {
                        $id = 0;
                    } ?>
                    <?php  if(isset($audios)) :
                            foreach($audios as $audio): 
                        ?>
                    <div class="items">
                        <a href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                            <div class="block-images position-relative">
                                <div class="img-box">
                                    <!-- block-images -->
                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->image; ?>" class="img-fluid w-100 h-50 flickity-lazyloaded" alt="cate">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($audio->access == 'subscriber' ){ ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }
                                       elseif(!empty($audio->ppv_price)) {
                                          echo $currency->symbol.' '.$audio->ppv_price ; 
                                          }  elseif( $audio->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    </p>
                                    <?php } ?>
                                    
                                </div>
                                <div class="block-description">
                                    <a href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                                        <?php if($ThumbnailSetting->title == 1) { ?>
                                        <!-- Title -->
                                        <h6>
                                            <?php echo strlen($audio->title) > 17 ? substr($audio->title, 0, 18) . '...' : $audio->title; ?>
                                        </h6>
                                        <?php } ?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            
                                            <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <!-- Duration -->
                                             <span class="text-white">
                                                   <i class="fa fa-clock-o"></i>
                                                   <?= gmdate('H:i:s', $audio->duration) ?>
                                             </span>
                                            <?php } ?>
                                        </div>
                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->rating == 1) { ?>
                                             <!--Rating  -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      <?php echo __($audio->rating); ?>
                                                   </span>
                                             </div>
                                            <?php } ?>
                                           
                                            <?php if($ThumbnailSetting->featured == 1 && $audio->featured == 1) { ?>
                                                <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                      <span class="text-white">
                                                         <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                      </span>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <?php } ?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <!-- Category Thumbnail  setting -->
                                            <?php
                                             $CategoryThumbnail_setting = App\CategoryAudio::
                                                    join('audio_categories', 'audio_categories.id', '=', 'category_audios.category_id')
                                                   ->where('category_audios.audio_id', $category->id)
                                                   ->pluck('audio_categories.name');
                                            ?>
                                            <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                            <span class="text-white">
                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                <?php
                                                $Category_Thumbnail = [];
                                                foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                    $Category_Thumbnail[] = $CategoryThumbnail;
                                                }
                                                echo implode(',' . ' ', $Category_Thumbnail);
                                                ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                        <div class="hover-buttons">
                                            <a type="button" class="text-white d-flex align-items-center"
                                                href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                                                <img class="ply mr-1" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>"
                                                    width="10%" height="10%" /> Watch Now
                                            </a>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php   endforeach;  endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.audio-categoryloop');
        elems.forEach(function (elem) {
            new Flickity(elem, {
                cellAlign: 'left',
                contain: true,
                groupCells: true,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyLoad: true,
            });
        });
    });
</script>
