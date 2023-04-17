    <!-- Trailer for video banner  -->
<?php if( $videos->trailer != null && $videos->trailer_type == 'm3u8' ){  ?>

    <div class="trailor-video">
        <a href="#video-trailer" class="video-open playbtn btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>"
            data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)"> 
            <i class="fa fa-info" aria-hidden="true"></i> Watch Trailer
        </a>
    </div>
    

<?php }elseif($videos->trailer != null && $videos->trailer_type == 'm3u8_url' ){ ?>

    <div class="trailor-video">
        <a href="#M3U8_video-trailer" class="video-open playbtn btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>"
            data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <i class="fa fa-info" aria-hidden="true"></i> Watch Trailer
        </a>
    </div>


<?php  }elseif( $videos->trailer != null && $videos->trailer_type == 'mp4_url' || $videos->trailer_type == 'video_mp4' ){ ?>

    <div class="trailor-video">
        <a href="#MP4_videos-trailer" class="video-open playbtn btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>"
            data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <i class="fa fa-info" aria-hidden="true"></i> Watch Trailer
        </a>
    </div>


<?php  }elseif( $videos->trailer != null && $videos->trailer_type == "embed_url" ){ ?>

    <div class="trailor-video">
        <a href="#Embed_videos-trailer" class="video-open playbtn btn bd ml-2" data-trailer-url="<?= $videos->trailer ?>"
            data-trailer-type="<?= $videos->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <i class="fa fa-info" aria-hidden="true"></i> Watch Trailer
        </a>
    </div>

<?php } ?>

    <div class="col-md-12">
        <div id="video-trailer" class="mfp-hide">
            <video id="Trailer-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                <source type="application/x-mpegURL" src="<?php echo $videos->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="M3U8_video-trailer" class="mfp-hide">
            <video id="M3U8_video-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>" controls
                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                    <source type="application/x-mpegURL" src="<?php echo $videos->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="MP4_videos-trailer" class="mfp-hide">
            <video id="MP4_Trailer-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $videos->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                <source type="application/x-mpegURL" src="<?php echo $videos->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="Embed_videos-trailer" class="mfp-hide">
            <div id="Embed_url-videos"></div>
        </div>
    </div>


<!-- Note - Trailer Player Script path (themes/default/views/partials/home/Trailer-script.php) -->