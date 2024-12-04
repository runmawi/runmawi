<style>
    .my-video.vjs-fluid {
        height: calc(100vh - 350px) !important;
    }

    @media only screen and (max-width: 600px) {
    .my-video.vjs-fluid {
        height: 25vh !important;
    }
    }

</style>

<div id="video_bg">
    <div id="video sda" class="fitvid" style="margin: 0 auto;">

        <div class="row">
            <div class="col-12 col-lg-5">
                <?php if ( $Livestream_details->url_type == "embed" ) : ?>

                <iframe class="responsive-iframe" src="<?= $Livestream_details->livestream_URL ?>"
                    poster="<?= $Livestream_details->Player_thumbnail ?>" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>

                <?php else: ?>
                <button class="staticback-btn" onclick="history.back()" title="Back Button">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <video id="live-stream-player"
                    class="vjs-theme-city my-video video-js vjs-play-control vjs-live-control vjs-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive"
                    controls width="auto" height="auto" playsinline="playsinline" autoplay="autoplay"
                    poster="<?= $Livestream_details->Player_thumbnail ?>">
                    <source src="<?= $Livestream_details->livestream_URL ?>"
                        type="<?= $Livestream_details->livestream_player_type ?>">
                </video>

                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-7">
                <!-- BREADCRUMBS -->
                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div class="row">
                        <div class=" p-0">
                            <div class="">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text"
                                            href="<?= route('liveList') ?>"><?= ucwords('Livestreams') ?></a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>

                                    <?php foreach ($category_name as $key => $video_category_name) { ?>
                                    <?php $category_name_length = count($category_name); ?>
                                    <li class="breadcrumb-item">
                                        <a class="black-text"
                                            href="<?= route('LiveCategory', [$video_category_name->categories_slug]) ?>">
                                            <?= ucwords($video_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($video->title) > 50 ? ucwords(substr($video->title, 0, 120) . '...') : ucwords($video->title); ?> </a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                <div class="">
                    <h1 class="trending-text big-title text-uppercase mt-3">
                        <?php echo __($video->title); ?>
                        <?php if( Auth::guest() ) { ?> <?php } ?></h1>
                    <!-- Category -->
                    <ul class="p-0 list-inline d-flex align-items-center movie-content">
                        <li class="text-white">
                            <?//= $videocategory ;?>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <div class="text-white ">
                        <p class="trending-dec text-white"><?php echo __($video->description); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="video-details-container" style="padding: 0 40px;">
                            <?php if (!empty($video->details)) { ?>
                            <h6 class="mt-3 mb-1">Live Details</h6>
                            <p class="trending-dec w-100 mb-3 text-white">
                                <?= $video->details ?></p>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
           
                <?php
                if (!empty($video->publish_time)) {
                    $originalDate = $video->publish_time;
                    $publishdate = date('d F Y', strtotime($originalDate));
                } else {
                    $originalDate = $video->created_at;
                    $publishdate = date('d F Y', strtotime($originalDate));
                }
                ?>
                <div class=" align-items-center text-white text-detail p-0">
                    <span class="badge badge-secondary p-2"><?php echo __(@$video->languages->name); ?></span>
                    <span class="badge badge-secondary p-2"><?php echo __(@$video->categories->name); ?></span>
                    <span class="badge badge-secondary p-2">Published On :
                        <?php echo $publishdate; ?></span>
                    <span class="badge badge-secondary p-2"><?php echo __($video->age_restrict); ?></span>

                </div>
                <?php if(!Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                            <!-- Social Share, Like Dislike -->
                            <?php
                            include public_path('themes/theme5-nemisha/views/partials/live-social-share.php');
                            ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>


            </div>

            </div>
        </div>
    </div>
</div>
