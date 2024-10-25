
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
    @media(max-width:2800px){    .my-video.vjs-fluid{height:65vh !important;}}
    .embed-responsive::before{display: none;}
</style>

<div class="modal fade" id="video-js-trailer-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="video-js-trailer-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered video-js-trailer-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body video-js-trailer-modal-body">
                <button type="button" class="close video-js-trailer-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="embed-responsive embed-responsive-16by9">
                    <?php if($videodetail->trailer_type == "embed_url" ) : ?>
                        <iframe id="video-js-trailer-player_embed" width="100%" height="auto" src="<?= $videodetail->trailer_videos_url ?>" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    <?php else: ?>
                        <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" controls width="100%" height="auto">
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
    $(document).ready(function() {
        <?php if($videodetail->trailer_type != "embed_url" ): ?>
            var player = videojs('video-js-trailer-player', {  // Video Js Player  - Trailer
                aspectRatio: '16:9',
                fluid: true,
                autoplay: false,

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
        <?php endif; ?>
    
        $(".video-js-trailer-modal-close").click(function(){
            <?php if($videodetail->trailer_type != "embed_url" ): ?>
            player.pause();  
            <?php endif; ?>
    
            <?php if($videodetail->trailer_type == "embed_url" ): ?>
                $('#video-js-trailer-player_embed').attr('src', '');
            <?php endif; ?>
    
            $('#video-js-trailer-modal').modal('hide');
        });
    
        $('#video-js-trailer-modal').on('hidden.bs.modal', function(){
            <?php if($videodetail->trailer_type == "embed_url" ): ?>
                $('#video-js-trailer-player_embed').attr('src', '<?= $videodetail->trailer_videos_url ?>');
            <?php endif; ?>
    
            <?php if($videodetail->trailer_type != "embed_url" ): ?>
                player.currentTime(0);
            <?php endif; ?>
        });
    });
</script>