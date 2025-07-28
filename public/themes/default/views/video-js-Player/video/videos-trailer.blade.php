
 <!-- video-js Style  -->

 <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
 <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" /> -->
 <link href="<?= asset('public/themes/default/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet" >
 <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
 <link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet" >
 <link href="<?= asset('public/themes/default/assets/css/video-js/videos-player.css') ?>" rel="stylesheet" >
 <link href="<?= asset('public/themes/default/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet" >
 <link href="<?= URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') ?>" rel="stylesheet" >
 
<style>
    .video-js-trailer-modal-dialog {
        /* max-width: 800px; */
        margin: 30px auto;
    }

    .video-js-trailer-modal-body {
        position: relative;
        padding: 0px;
    }

    .video-js-trailer-modal-close {
        position: absolute;
        right: -30px;
        top: 0;
        z-index: 999;
        font-size: 2rem;
        font-weight: normal;
        color: #fff;
        opacity: 1;
    }
    .vjs-controls-enabled .vjs-control-bar {
        display: flex !important;
        opacity: 1 !important;
    }
    
    /* @media(max-width:2800px){    .my-video.vjs-fluid{height:65vh !important;}} */
        #trailermodal .my-video.vjs-fluid{height: 68vh !important;}
    @media screen and (min-width: 1900px){
        #trailermodal .my-video.vjs-fluid{height: 35vh !important;}
        .modal-dialog-centered{align-items: unset;top: 15%;}
        .modal-dialog{max-width: 700px;}
        .trailer-img:hover .trailer-play{left: 1%;}
    }
    @media only screen and (min-height: 2160px){
        #trailermodal .my-video.vjs-fluid{height: 20vh !important;}
        .modal-dialog{max-width: 1000px;}
    }
    @media (max-width:768px){
        .video-js-trailer-modal-close{right: 0;}
        #trailermodal .my-video.vjs-fluid{height: 42vh !important;}
    }
    .embed-responsive::before{display: none;}
    .modal-content{background-color: transparent;}
</style>


<!-- Modal -->
<div class="modal fade" id="trailermodal" tabindex="-1" aria-labelledby="trailermodalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close close video-js-trailer-modal-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <div class="embed-responsive embed-responsive-16by9">
                        <?php if($videodetail->trailer_type == "embed_url" ) : ?>
                            <iframe id="video-js-trailer-player_embed" width="100%" height="auto" src="<?= $videodetail->trailer_videos_url ?>" 
                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        <?php elseif($videodetail->trailer_type == "m3u8_url" ): ?>
                            <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                <source src="<?= $videodetail->trailer ?>" type="application/x-mpegURL">
                            </video>
                        <?php else: ?>
                            <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                <source src="<?= $videodetail->trailer ?>" type="video/mp4">
                            </video>                 
                        <?php endif; ?>
    
                    </div>
                </div>
            </div>
        </div>
    </div>

 
 <!--  video-js Script  -->
 
 <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
 <script src="<?= asset('assets/js/video-js/video.min.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/videojs.ads.min.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/videojs.ima.min.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
 <script src="<?= asset('assets/js/video-js/end-card.js') ?>"></script>
 <script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
 <script src="<?= URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') ?>"></script>
 <script src="<?= URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') ?>"></script>
 

 
<script>

    $(document).ready(function(){
        $('#video-js-trailer-modal .modal-dialog').on('click', function (e) {
            e.stopPropagation();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('video-js-trailer-player', {  // Video Js Player  - Trailer
            aspectRatio: '16:9',
            fluid: true,

            controlBar: {
                volumePanel: {
                    inline: false
                },

                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {}, 
                }
            }
        });

        player.on('mouseout', function() {
            // console.log("hover out..");
            $('.vjs-big-play-button').hide();
            $('.vjs-control-bar').attr('style', 'display: none !important;');
        });

        // Show controls when mouse enters
        player.on('mouseover', function() {
            // console.log("hovering..");
            $('.vjs-big-play-button').show();
            $('.vjs-control-bar').show();
        });

        $(".btn-close").click(function(){
                player.pause();  
        });
        
    });

</script>