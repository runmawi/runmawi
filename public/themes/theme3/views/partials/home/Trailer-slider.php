    <!-- Trailer for video banner  -->
<?php if( $item->trailer != null && $item->trailer_type == 'm3u8' ){  ?>

    <div class="trailor-video">
        <a href="#video-trailer-1" class="video-open playbtn bd ml-2" data-trailer-url="<?= $item->trailer ?>"
            data-trailer-type="<?= $item->trailer_type ?>" onclick="trailer_slider_videos(this)"> 
            <?= html_entity_decode( $play_button_svg ) ?>
            <span class="w-trailor">Watch Trailer</span>
        </a>
    </div>
    

<?php }elseif($item->trailer != null && $item->trailer_type == 'm3u8_url' ){ ?>

    <div class="trailor-video">
        <a href="#M3U8_video-trailer" class="video-open playbtn bd ml-2" data-trailer-url="<?= $item->trailer ?>"
            data-trailer-type="<?= $item->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <?= html_entity_decode( $play_button_svg ) ?>
            <span class="w-trailor">Watch Trailer</span>
        </a>
    </div>


<?php  }elseif( $item->trailer != null && $item->trailer_type == 'mp4_url' || $item->trailer_type == 'video_mp4' ){ ?>

    <div class="trailor-video">
        <a href="#MP4_videos-trailer" class="video-open playbtn bd ml-2" data-trailer-url="<?= $item->trailer ?>"
            data-trailer-type="<?= $item->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <?= html_entity_decode( $play_button_svg ) ?>
            <span class="w-trailor">Watch Trailer</span>
        </a>
    </div>


<?php  }elseif( $item->trailer != null && $item->trailer_type == "embed_url" ){ ?>

    <div class="trailor-video">
        <a href="#Embed_videos-trailer" class="video-open playbtn bd ml-2" data-trailer-url="<?= $item->trailer ?>"
            data-trailer-type="<?= $item->trailer_type ?>" onclick="trailer_slider_videos(this)">
            <?= html_entity_decode( $play_button_svg ) ?>
            <span class="w-trailor">Watch Trailer</span>        
        </a>
    </div>

<?php } ?>

    <div class="col-md-12">
        <div id="video-trailer-1" class="mfp-hide">
            <video id="Trailer-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $item->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                <source type="application/x-mpegURL" src="<?php echo $item->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="M3U8_video-trailer" class="mfp-hide">
            <video id="M3U8_video-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $item->player_image ?>" controls
                    data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                    <source type="application/x-mpegURL" src="<?php echo $item->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="MP4_videos-trailer" class="mfp-hide">
            <video id="MP4_Trailer-videos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $item->player_image ?>" controls
                data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
                <source type="application/x-mpegURL" src="<?php echo $item->trailer; ?>">
            </video>
        </div>
    </div>


    <div class="col-md-6">
        <div id="Embed_videos-trailer" class="mfp-hide">
            <div id="Embed_url-videos"></div>
        </div>
    </div>


<?php  include(public_path('themes/theme3/views/partials/home/Trailer-script.php')); ?>
