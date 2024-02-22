<?php 

    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();

    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
    $video_id = $video->id ; 
    $advertisement_id = $video->ads_tag_url_id ;
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();

    if(!Auth::guest()){
        $free_duration_condition = ( ( $ppv_exist == 0 && $video->access = "subscriber" &&  Auth::user()->role == "registered"  ) ||  $video->access = "ppv"  ) && $video->free_duration_status == 1 && $video->free_duration != null  ? 1 : 0;

    }else{
        $free_duration_condition = $video->access !="guest" && $video->free_duration_status == 1 && $video->free_duration != null ? 1 : 0;
    }

    // dd( $free_duration_condition );

    $data = App\PPVFreeDurationLogs::where('source_id', $video_id )->where('source_type','video');
        
        if( !Auth::guest()  ){
            $data = $data->where('user_id',Auth::user()->id) ;
        }
        else{
            $data =  $data->where('IP_address', $userIp ) ;
        }

    $result = $data->pluck('duration')->first();

    $free_duration_start_time = $result != null ? $result : 0 ;

    if( $free_duration_condition == 1 ){
        echo '<style>
                .plyr__controls__item.plyr__progress__container{ pointer-events: none;  cursor: not-allowed; }
            </style>' ;
    }

?>

<input type="hidden" id="free_duration_seconds"    value="<?php echo $video->free_duration ?>" >
<input type="hidden" id="free_duration_condition"  value="<?php echo $free_duration_condition ?>" >
<input type="hidden" id="free_duration_start_time" value="<?php echo $free_duration_start_time ?>" >

<script>

    let user = <?php echo json_encode($user); ?>

    let video_ads = <?php echo json_encode( $video_tag_url ); ?> ;

    document.addEventListener('DOMContentLoaded', () => { 

        const free_duration_seconds = document.getElementById("free_duration_seconds");
        const free_duration_condition = $("#free_duration_condition").val();

        let playerOptions = {
                
            controls: ['play-large', 'restart', 'rewind', 'play', 'fast-forward', 'progress', 'rewind',
                'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'
            ],

            ads: {
                enabled: true,
                tagUrl: video_ads
            }
        };

        if ( free_duration_condition == 1) {
            playerOptions.keyboard = {
                focused: false,
                global: false
            };
        }

        const player = new Plyr('#PPV_free_duration_videoPlayer_MP4', playerOptions);

            // Ads Views Count
        player.on('adsloaded', (event) => {
            Ads_Views_Count();
        });

            // Ads Redirection Count
        player.on('adsclick', (event) => {
            Ads_Redirection_URL_Count(event.timeStamp);
        });

        if( free_duration_condition == 1 ){

            const video = document.getElementById('PPV_free_duration_videoPlayer_MP4');

            video.pause();
        
            let isVideoPlaying = false;
            let interval;

            function checkPPVFreeDuration() {

                if (isVideoPlaying == true ) {

                    $.ajax({
                        type: 'get',
                        url: '<?= route('PPV_Free_Duration_Logs') ?>',
                        data: {
                            "source_id": "<?php echo $video_id ?>",
                            "source_type": "video",
                            "duration": "2",
                        },
                        success: function (data) {
                            let PPVFreeDuration = data;

                            let freeduration_sec = free_duration_seconds.defaultValue;

                            if (PPVFreeDuration >= freeduration_sec) {
                                video.pause();
                                const controlsElements = document.getElementsByClassName("plyr__controls");
                                $('.plyr__controls').hide();
                                $('#PPV_free_duration_videoPlayer_MP4').hide();
                                displayModal();
                            }
                        }
                    });
                }
            }

            video.addEventListener('play', () => {
                isVideoPlaying = true;
                interval = setInterval(checkPPVFreeDuration, 2000 ); //2 seconds
            });

            video.addEventListener('pause', () => {
                isVideoPlaying = false;
                clearInterval(interval);
            });

            video.addEventListener('ended', () => {
                isVideoPlaying = false;
                clearInterval(interval);
            });

        }

        function displayModal() {

            const modal = document.getElementById("modal");
            modal.style.display = "block";
        }
    });

    document.addEventListener("DOMContentLoaded", () => {

        const video = document.querySelector("#PPV_free_duration_videoPlayer");
        const source = video.getElementsByTagName("source")[0].src;

        const free_duration_seconds = document.getElementById("free_duration_seconds");
        const free_duration_condition = $("#free_duration_condition").val();
        const free_duration_start_time = $("#free_duration_start_time").val();

        const defaultOptions = {};

        if ( free_duration_condition == 1) {

            defaultOptions.keyboard = {
                focused: false,
                global: false
            };
        }

        if (!Hls.isSupported()) {

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: video_ads
            }

            video.src = source;
            var player = new Plyr(video, defaultOptions);
        } 
        else
        {
            const hls = new Hls();
            hls.loadSource(source);
            
                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                const availableQualities = hls.levels.map((l) => l.height)
                availableQualities.unshift(0) 

                defaultOptions.quality = {
                    default: 0, //theme7 - AUTO
                    options: availableQualities,
                    forced: true,        
                    onChange: (e) => updateQuality(e),
        }

          // Add Auto Label 
            defaultOptions.i18n = {
                qualityLabel: { 0: 'Auto', },
            }

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: video_ads
            }

            hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
                var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
                if (hls.autoLevelEnabled) {
                    span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                } else {
                    span.innerHTML = `AUTO`
                }
            })

            var player = new Plyr(video, defaultOptions);

                // Ads Views Count
             player.on('adsloaded', (event) => {
                Ads_Views_Count();
            });

                // Ads Redirection Count
            player.on('adsclick', (event) => {
                Ads_Redirection_URL_Count(event.timeStamp);
            });

            if( free_duration_condition == 1 ){

                player.on('play', (event) => {

                    if(video.duration <= free_duration_start_time){

                        video.pause();
                        const controlsElements = document.getElementsByClassName("plyr__controls");

                        $('.plyr__controls').hide();
                        $('#PPV_free_duration_videoPlayer').hide();

                        displayModal();
                    }

                    video.currentTime = free_duration_start_time ;
                    video.play();
                });
            }   
        });	

        hls.attachMedia(video);
            window.hls = hls;		 
        }
        

        if( free_duration_condition == 1  ){

            let isVideoPlaying = false;
            let interval;

            function checkPPVFreeDuration() {

                if ( (video.duration >= free_duration_start_time) && isVideoPlaying == true ) {

                    $.ajax({
                        type: 'get',
                        url: '<?= route('PPV_Free_Duration_Logs') ?>',
                        data: {
                            "source_id": "<?php echo $video_id ?>",
                            "source_type": "video",
                            "duration": "2",
                        },
                        success: function (data) {
                            let PPVFreeDuration = data;
                            let freeduration_sec = free_duration_seconds.defaultValue;

                            if (PPVFreeDuration >= freeduration_sec) {
                                video.pause();
                                const controlsElements = document.getElementsByClassName("plyr__controls");
                                $('.plyr__controls').hide();
                                $('#PPV_free_duration_videoPlayer').hide();
                                displayModal();
                            }
                        }
                    });
                }
            }

            video.addEventListener('play', () => {
                isVideoPlaying = true;
                interval = setInterval(checkPPVFreeDuration, 2000 ); //2 seconds
            });

            video.addEventListener('pause', () => {
                isVideoPlaying = false;
                clearInterval(interval);
            });

            video.addEventListener('ended', () => {
                isVideoPlaying = false;
                clearInterval(interval);
            });
        }
    
        function updateQuality(newQuality) {
            if (newQuality === 0) {
            window.hls.currentLevel = -1;
            } else {
            window.hls.levels.forEach((level, levelIndex) => {
                if (level.height === newQuality) {
                console.log("Found quality match with " + newQuality);
                window.hls.currentLevel = levelIndex;
                }
            });
            }
        }

        function displayModal() {

            const modal = document.getElementById("modal");
            modal.style.display = "block";

        }
    });

    
    document.addEventListener("DOMContentLoaded", () => {

        const video = document.querySelector("#PPV_free_duration_videoPlayer_M3U8_url");
        const source = video.getElementsByTagName("source")[0].src;

        const free_duration_seconds = document.getElementById("free_duration_seconds");
        const free_duration_condition = $("#free_duration_condition").val();

        const defaultOptions = {};

        if ( free_duration_condition == 1) {

            defaultOptions.keyboard = {
                focused: false,
                global: false
            };

        }

        if (!Hls.isSupported()) {

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: video_ads
            }

            video.src = source;
            var player = new Plyr(video, defaultOptions);
        } 
        else
        {
            const hls = new Hls();
            hls.loadSource(source);
            
                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                const availableQualities = hls.levels.map((l) => l.height)
                availableQualities.unshift(0) 

                defaultOptions.quality = {
                    default: 0, //theme7 - AUTO
                    options: availableQualities,
                    forced: true,        
                    onChange: (e) => updateQuality(e),
        }

          // Add Auto Label 
            defaultOptions.i18n = {
                qualityLabel: { 0: 'Auto', },
            }

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: video_ads
            }

            hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
                var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
                if (hls.autoLevelEnabled) {
                    span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                } else {
                    span.innerHTML = `AUTO`
                }
            })

            var player = new Plyr(video, defaultOptions);

                // Ads Views Count
             player.on('adsloaded', (event) => {
                Ads_Views_Count();
            });

                // Ads Redirection Count
            player.on('adsclick', (event) => {
                Ads_Redirection_URL_Count(event.timeStamp);
            });

            
            if( free_duration_condition == 1 ){

                let isVideoPlaying = false;
                let interval;

                function checkPPVFreeDuration() {

                    if ( isVideoPlaying == true ) {

                        $.ajax({
                            type: 'get',
                            url: '<?= route('PPV_Free_Duration_Logs') ?>',
                            data: {
                                "source_id": "<?php echo $video_id ?>",
                                "source_type": "video",
                                "duration": "2",
                            },
                            success: function (data) {
                                let PPVFreeDuration = data;
                                let freeduration_sec = free_duration_seconds.defaultValue;

                                if (PPVFreeDuration >= freeduration_sec) {
                                    video.pause();
                                    const controlsElements = document.getElementsByClassName("plyr__controls");
                                    $('.plyr__controls').hide();
                                    $('#PPV_free_duration_videoPlayer_M3U8_url').hide();
                                    displayModal();
                                }
                            }
                        });
                    }
                }

                video.addEventListener('play', () => {
                    isVideoPlaying = true;
                    interval = setInterval(checkPPVFreeDuration, 2000 ); //2 seconds
                });

                video.addEventListener('pause', () => {
                    isVideoPlaying = false;
                    clearInterval(interval);
                });

                video.addEventListener('ended', () => {
                    isVideoPlaying = false;
                    clearInterval(interval);
                });
            }
        });	

        hls.attachMedia(video);
            window.hls = hls;		 
        }
        

        function updateQuality(newQuality) {
            if (newQuality === 0) {
            window.hls.currentLevel = -1;
            } else {
            window.hls.levels.forEach((level, levelIndex) => {
                if (level.height === newQuality) {
                console.log("Found quality match with " + newQuality);
                window.hls.currentLevel = levelIndex;
                }
            });
            }
        }

        function displayModal(){
            
            const modal = document.getElementById("modal");
            modal.style.display = "block";

        }
    });


    function Ads_Redirection_URL_Count(timestamp_time){

        $.ajax({
            type:'get',
            url:'<?= route('Advertisement_Redirection_URL_Count') ?>',
            data: {
                    "Count" : 1 , 
                    "source_type" : "video",
                    "source_id"   : "<?php echo $video_id ?>",
                    "adverister_id" : "<?php echo $adverister_id ?>",
                    "adveristment_id" : "<?php echo $advertisement_id ?>",
                    "user" : "<?php echo $user ?>",
                    "timestamp_time" : timestamp_time ,
                },
                success:function(data) {
            }
        });
    }

    function Ads_Views_Count(){

        $.ajax({
              type:'get',
              url:'<?= route('Advertisement_Views_Count') ?>',
              data: {
                        "Count" : 1 , 
                        "source_type" : "video",
                        "source_id"   : "<?php echo $video_id ?>",
                        "adverister_id" : "<?php echo $adverister_id ?>",
                        "adveristment_id" : "<?php echo $advertisement_id ?>",
                        "user" : "<?php echo $user ?>",
                  },
                  success:function(data) {
                }
        });
    }

    $(document).ready(function() {

        let free_duration_condition  = Number($("#free_duration_condition").val());
        let free_duration_start_time = Number($("#free_duration_start_time").val());
        let free_duration_seconds    = Number($("#free_duration_seconds").val()); 

        if (free_duration_condition === 1 && free_duration_start_time >= free_duration_seconds) {
            
            const modal = document.getElementById("modal");
            modal.style.display = "block";
            $("#PPV_free_duration_videoPlayer_M3U8_url").hide();
            $("#PPV_free_duration_videoPlayer_MP4").hide();
            $(".plyr__controls").css("display", "none");
        }
    });

</script>

<style>
    .modal-ppv-free-purchase{
        right: 0 !important ;
        position: absolute !important ;
        top : 15% !important ;
        height: 570px !important;
    }
</style>

<div id="modal" class="modal modal-ppv-free-purchase">
    <div class="modal-content">
        <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 100vh;">
            <div id="video_bg_dim"></div>
            <div class="row justify-content-center pay-live">
                <div class="col-md-4 col-sm-offset-4">
                    <div class="ppv-block freeblock" style="">
                        <div style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>);background-repeat: no-repeat;background-size: cover;height: 25vh;background-position: center;border-top-left-radius: 5px;border-top-right-radius: 5px;"></div>
                            <div class="row freebwrapper" style="" >
                                <div class="col-md-9">
                                    <h2 class="mb-3" style=""><?php echo __('Pay now to watch'); ?> <br /><?php echo $video->title; ?></h2>
                                    <?php if(Auth::guest()){ ?>
                                        <a href="<?= URL::to('/login'); ?>" class="btn btn-primary btn-block" style="">
                                            <?php echo $currency->symbol.''.$video->ppv_price; ?> <?php echo __('Purchase Now'); ?>
                                        </a>
                                    <?php }else{ ?>
                                        <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)"><?php echo $currency->symbol.''.$video->ppv_price; ?> <?php echo __('Purchase Now'); ?></button>
                                    <?php } ?>
                                </div>

                                <div class="col-md-3 text-right" style=""> 
                                    <p class="free_price">
                                        <?php echo $currency->symbol.''.$video->ppv_price; ?>
                                    </p>
                                    <small style="color: #fff;"><?php echo __('Per'); ?> <?php echo $video->ppv_hours; ?> Hrs</small> 
                                </div>
                            </div>
                            
                            <div class="freebwrapper_footer">
                                <div class="row">
                                    <?php if(Auth::guest()){ ?>
                                        <div class="col-md-8">
                                            <p><?php echo __('If you are already a member Login using this link'); ?></p>
                                        </div>
                                        <div class="col-md-4 text-right" style="">
                                            <a href="<?= URL::to('/login') ?>" class="btn btn-primary btn-block"><?php echo __('Login'); ?> </a>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="col-md-8">
                                            <h3 style=""><a href="<?=URL::to('/') . '/stripe/billings-details' ?>"><?php echo __('Get a Subscription and Watch unlimited Contents'); ?></a></h3>
                                        </div>
                                        <div class="col-md-4 text-right" style="">
                                            <a class="btn btn-primary btn-block" href="<?=URL::to('/') . '/stripe/billings-details' ?>"><?php echo __('Subscribe Now'); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .freeblock{box-shadow: 0 0 10px #000000;border-radius: 5px;margin: 30px 0;}
    .freebwrapper{background: #0f0f0f;margin: 0 auto;border-bottom: 1px solid #2a2a2a;padding: 15px 0;}
    .freebwrapper h2{font-size: 25px;font-weight: 700;text-align: left;}
    .freebwrapper a{ width: 60%; font-weight: 500;color: #ffffff !important; }
    .free_price{font-size: 35px;font-weight: 700;line-height: 44px;color: #ffffff;padding: 15px 0 0;margin: 0;}
    .freebwrapper_footer{padding: 15px;background: #000;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;}
    .freebwrapper_footer p{color: #ffffff;}
    .freebwrapper_footer a {font-weight: 500;color: #ffffff !important;}
    .freebwrapper_footer h3{font-size: 18px;text-align:left;font-weight: 400;}
</style>