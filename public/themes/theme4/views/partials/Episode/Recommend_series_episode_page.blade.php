<div class="iq-main-header ">
    <h4 class="main-title"> <?= __('Series') ?> </h4>
</div>

        <div class="col-sm-12 overflow-hidden pl-0 mb-5">
            <div class="channels-list favorites-contens">
                <div class="channel-row favorites-contens sub_dropdown_image">
                    <div class="video-list recommend-series-videos pl-0">
                        <?php  
                            $ThumbnailSetting = App\ThumbnailSetting::first();

                            $series_lists = !empty($series_lists) ? $series_lists->slice(0,15) : $series_lists  ; 

                            foreach($series_lists as $key => $series_list):
                        ?>
                            <div class="item depends-row">
                                <a href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                                    <div class="position-relative">
                                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" class="flickity-lazyloaded">
                                        <div class="controls">
                                            <a href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>

                                        </div>
                                        
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

                <!-- Model -->
        <?php  
        foreach($series_lists as $key => $series_list):
        ?>
            <div class="modal fade info_model" id= <?= "Recommend_series-episode-videos-Modal-".$key ?> tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background-color:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->player_image; ?>" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2"> <?= $series_list->title ?></h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="trending-dec mt-4"> <?= html_entity_decode($series_list->details) ?> </div>

                                            <a href="<?= URL::to('play_series/' . $series_list->slug) ?>" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <script>
    var elem = document.querySelector('.recommend-series-videos');
    var flkty = new Flickity( elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
</script>