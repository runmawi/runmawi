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
