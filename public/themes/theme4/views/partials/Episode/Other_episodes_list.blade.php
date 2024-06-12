<?php 
    $ThumbnailSetting = App\ThumbnailSetting::first();
?>

<div class="iq-main-header ">
    <h4 class="main-title"><?= __('Episode') ?></h4>
</div>

<div class="col-sm-12 overflow-hidden pl-0 mb-5">
    <div class="channels-list favorites-contens">
        <div class="channel-row favorites-contens sub_dropdown_image">
            <div class="video-list other-episodes-videos pl-0">
                <?php  
                foreach($season as $key => $seasons):
                    $season_episode =  !empty($seasons->episodes) ? $seasons->episodes->slice(0,15) : $seasons->episodes ;
                    foreach( $season_episode as $episode_key => $episodes):
                        if($episodes->id != $episode->id): ?>
                            <div class="item depends-row">
                                <a  href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">	
                                    <div class="position-relative">
                                        <img src="<?= URL::to('public/uploads/images/'.$episodes->image) ?>" class="flickity-lazyloaded" alt="<?= $episodes->title ?>">
                                        <div class="controls">
                                            <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Model -->
<?php  
foreach($season as $key => $seasons):
    $season_episode =  !empty($seasons->episodes) ? $seasons->episodes->slice(0,15) : $seasons->episodes ;

    foreach( $season_episode as $episode_key => $episodes):
        if($episodes->id != $episode->id): ?>
            <div class="modal fade info_model" id=<?= "Other-episode-videos-Modal-".$episode_key ?> tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background-color:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="<?= URL::to('public/uploads/images/'.$episodes->image) ?>" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2"> <?= $episodes->title ?></h2>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <?php if (optional($episodes)->episode_description): ?>
                                                <div class="trending-dec mt-4"><?php echo html_entity_decode( optional($episodes)->episode_description) ?> </div>
                                            <?php endif; ?>

                                            <a href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>

<script>
    var elem = document.querySelector('.other-episodes-videos');
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

<style>
    li.slick-slide {
    padding: 3px;
    display: block;
}
</style>
