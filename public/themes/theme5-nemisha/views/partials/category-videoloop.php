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
<?php 
    $check_Kidmode = 0 ;

    $data = App\VideoCategory::query()->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })

    ->with(['category_videos' => function ($videos) use ($check_Kidmode) {
        $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
            ->where('videos.active', 1)
            ->where('videos.status', 1)
            ->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $videos->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $videos->latest('videos.created_at')->get();
    }])
    ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
    ->where('video_categories.in_home', 1)
    ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })
    ->orderBy('video_categories.order')
    ->get()
    ->map(function ($category) {
        $category->category_videos->map(function ($video) {
            $video->image_url = URL::to('/public/uploads/images/'.$video->image);
            $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
            return $video;
        });
        $category->source =  "category_videos" ;
        return $category;
    });
?>

<?php if (!empty($data) && $data->isNotEmpty()):
    foreach( $data as $key => $video_category ): ?>
        <div class="">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                        <a href="<?php echo URL::to('/category/').'/'.$video_category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
                            <h4 class="movie-title">
                                <?php 
                                if(!empty($video_category->home_genre)){ echo optional($video_category)->name ; }else{ echo optional($video_category)->name ; }  
                                //   echo __($category->name);
                                ?>
                            </h4>
                        </a>
                        <a href="<?php echo URL::to('/category/').'/'.$video_category->slug;?>" class="see" >See All</a>
                    </div>
                    <div class="favorites-contens">
                            <div class="video-based-categories home-sec list-inline row p-0 mb-0" id="video-category-{{ $key }}">
                            <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                                $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                            <?php  if(isset($video_category)) :
                            foreach($video_category->category_videos as $category_video): 
                                if (!empty($category_video->publish_time) && !empty($category_video->publish_time))
                                {
                                $currentdate = date("M d , y H:i:s");
                                date_default_timezone_set('Asia/Kolkata');
                                $current_date = Date("M d , y H:i:s");
                                $date = date_create($current_date);
                                $currentdate = date_format($date, "D h:i");
                                $publish_time = date("D h:i", strtotime($category_video->publish_time));
                                if ($category_video->publish_type == 'publish_later')
                                {
                                    if ($currentdate < $publish_time)
                                    {
                                        $publish_time = date("D h:i", strtotime($category_video->publish_time));
                                    }else{
                                        $publish_time = 'Published';
                                    }
                                }
                                elseif ($category_video->publish_type == 'publish_now')
                                {
                                    $currentdate = date_format($date, "y M D");

                                    $publish_time = date("y M D", strtotime($category_video->publish_time));

                                    if ($currentdate == $publish_time)
                                    {
                                        $publish_time = 'Today'.' '.date("h:i", strtotime($category_video->publish_time));
                                    }else{
                                        $publish_time = 'Published';
                                    }
                                }else{
                                    $publish_time = '';
                                }
                                }else{
                                    $publish_time = '';
                                }
                                ?>
                            <div class="items">
                                <div class="block-images position-relative"> <!-- block-images -->
                                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"
                                                class="img-fluid w-100" alt=""> 
                                    </a>
                                
                                    <!-- PPV price -->
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                            <?php  if(!empty($category_video->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$category_video->ppv_price; ?></p>
                                            <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($ThumbnailSetting->published_on == 1) { ?>                                            
                                                <p class="published_on1"><?php echo $publish_time; ?></p>
                                            <?php  } ?>
                                </div>

                                <div class="block-description">
                                    <div class="hover-buttons">
                                        <a type="button" class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                        </a>
                                        <div class="d-flex">
                                            <!-- <span style="color: white;"class="mywishlist <?php // if(isset($mywishlisted->id)): ?>active<?php // endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $category_video->id ?>">
                                                <i style="" <?php //if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line " <?php //endif; ?> style="" ></i>
                                            </span>
                                            <div style="color:white;" id="<?= $category_video->id ?>"><?php // if(@$category_video->mywishlisted->user_id == $id && @$category_video->mywishlisted->video_id == $category_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div>  </div>
                                            <a   href="<?php // echo URL::to('category') ?><? // '/wishlist/' . $category_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                        </div>

                                        <!-- <div>
                                            <button class="show-details-button" data-id="<?= $category_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                            </button>
                                        </div> -->
                            
                                    </div>
                                </div>

                                <div class="mt-2 d-flex justify-content-between p-0">
                                    <?php if($ThumbnailSetting->title == 1) { ?>
                                        <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                                    <?php } ?>

                                    <?php if($ThumbnailSetting->age == 1) { ?>
                                        <div class="badge badge-secondary"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                    <?php } ?>
                                </div>

                                <div class="movie-time my-2">
                                
                                    <!-- Duration -->

                                    <?php if($ThumbnailSetting->duration == 1) { ?>
                                        <span class="text-white">
                                            <i class="fa fa-clock-o"></i>
                                            <?= gmdate('H:i:s', $category_video->duration); ?>
                                        </span>
                                    <?php } ?>

                                    <!-- Rating -->

                                    <?php if($ThumbnailSetting->rating == 1 && $category_video->rating != null) { ?>
                                        <span class="text-white">
                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                            <?php echo __($category_video->rating); ?>
                                        </span>
                                    <?php } ?>

                                    <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
                                        <!-- Featured -->
                                        <span class="text-white">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                        </span>
                                    <?php }?>
                                </div>

                                <div class="movie-time my-2">
                                    <!-- published_year -->

                                    <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $category_video->year != null ) ) { ?>
                                        <span class="text-white">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo __($category_video->year); ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <div class="movie-time my-2">
                                    <!-- Category Thumbnail  setting -->
                                    <?php
                                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                ->where('categoryvideos.video_id',$category_video->video_id)
                                                ->pluck('video_categories.name');   
                                    ?>
                                    <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                    <span class="text-white">
                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        <?php
                                            $Category_Thumbnail = array();
                                                foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                }
                                            echo implode(','.' ', $Category_Thumbnail);
                                        ?>
                                    </span>
                                    <?php } ?>
                                </div>
                                    
                            </div>
                            <?php     endforeach; endif; ?>

                                <!-- Episode -->
                                
                            <?php  if(isset($Episode_videos)) :
                            foreach($Episode_videos as $Episode): ?>
                                <div class="slide-item">
                                    <div class="block-images position-relative">  <!-- block-images -->
                                        <a href="<?php echo URL::to('episode') ?><?= '/' .@$Episode->series_slug .'/'. $Episode->slug ?>">
                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$Episode->image;  ?>"
                                                    class="img-fluid" alt=""> 
                                        </a>
                                    </div>

                                    <div class="block-description">
                                        <div class="hover-buttons">
                                            <a type="button" class="text-white btn-cl" href="<?php echo URL::to('episode') ?><?= '/' .@$Episode->series_slug .'/'. $Episode->slug ?>">
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="mt-2 d-flex justify-content-between p-0">
                                        <?php if($ThumbnailSetting->title == 1) { ?>
                                            <h6><?php  echo (strlen($Episode->title) > 17) ? substr($Episode->title,0,18).'...' : $Episode->title; ?></h6>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->age == 1) { ?>
                                            <div class="badge badge-secondary"><?php echo $Episode->age_restrict.' '.'+' ?></div>
                                        <?php } ?>
                                    </div>

                                    <div class="movie-time my-2">
                                    
                                        <!-- Duration -->

                                        <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $Episode->duration); ?>
                                            </span>
                                        <?php } ?>

                                        <!-- Rating -->

                                        <?php if($ThumbnailSetting->rating == 1 && $Episode->rating != null) { ?>
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($Episode->rating); ?>
                                            </span>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->featured == 1 && $Episode->featured == 1) { ?>
                                            <!-- Featured -->
                                            <span class="text-white">
                                                <i class="fa fa-flag" aria-hidden="true"></i>
                                            </span>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php   endforeach;  endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.video-based-categories');
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
