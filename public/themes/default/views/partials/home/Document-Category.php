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

            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <a href="<?php echo URL::to('/document/category') . '/' . $category->slug; ?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if (!empty($category->name)) {
                            echo __($category->name);
                        } else {
                            echo __($category->name);
                        }
                        ?>
                    </h4>
                    <?php if( $settings->homepage_views_all_button_status == 1 ):?>
                        <h4 class="main-title"><a href="<?php echo URL::to('/document/category') . '/' . $category->slug; ?>"><?php echo (__('View All')); ?></a></h4>
                    <?php endif; ?>
                    </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php if (!Auth::guest() && !empty($data['password_hash'])) {
                        $id = Auth::user()->id;
                    } else {
                        $id = 0;
                    } ?>
                    <?php  if(isset($Documents)) :
                            foreach($Documents as $Document): 
                        ?>
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer" target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                                        <img src="<?php echo URL::to('/') . '/public/uploads/Document/' . $Document->image; ?>" class="img-fluid lazyload w-100" alt="cate">
                                    </a>
                                </div>
                            </div>

                                <div class="block-description">
                                    <a class="playTrailer" target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                                            <img src="<?php echo URL::to('/') . '/public/uploads/Document/' . $Document->image; ?>" class="img-fluid lazyload w-100" alt="cate">
                                    </a>
                                <div class="hover-buttons text-white">
                                    <a target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                                        <?php if($ThumbnailSetting->title == 1) { ?>
                                            <!-- Title -->
                                            <p class="epi-name text-left m-0">
                                                <?php echo strlen($Document->name) > 17 ? substr($Document->name, 0, 18) . '...' : $Document->name; ?>
                                            </p>
                                        <?php } ?>
                                    </a>
                                <a type="button" class="epi-name mt-3 mb-0 btn"
                                target="_blank" href="<?php URL::to('public/uploads/Document/'.$Document->document) ?>">
                                    <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>"
                                        width="10%" height="10%" /> View Now
                                </a>
                            </div>
                        </div>
                    </li>
                    <?php   endforeach;  endif; ?>
                </ul>
            </div>
       

