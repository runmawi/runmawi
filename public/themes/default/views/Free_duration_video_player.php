<?php 

    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();

    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
    $video_id = $video->id ; 
    $advertisement_id = $video->ads_tag_url_id ;
    $adverister_id = App\Advertisement::where('id',$advertisement_id)->pluck('advertiser_id')->first();

    $free_duration_condition = ($video->free_duration_status == 1 && $video->free_duration != null && $video->access == "ppv" && Auth::guest()) || ($video->free_duration_status == 1 && $video->free_duration != null && $video->access == "ppv" && Auth::user()->role == "registered") ? 1 : 0;

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

<input type="hidden" id="free_duration_seconds" value="<?php echo $video->free_duration ?>" >
<input type="hidden" id="free_duration_condition" value="<?php echo $free_duration_condition ?>" >
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
            
            video.addEventListener('timeupdate', () => {

                $.ajax({
                    type:'get',
                    url:'<?= route('PPV_Free_Duration_Logs') ?>',
                    data: {
                            "source_id"   : "<?php echo $video_id ?>",
                            "source_type" : "video",
                            "duration"    : "0.20" ,
                        },
                        success:function(data) {

                            let PPVFreeDuration = data ;

                            let freeduration_sec = free_duration_seconds.defaultValue  ;
                            
                            if ( PPVFreeDuration >= freeduration_sec ) {

                                video.pause();

                                const controlsElements = document.getElementsByClassName("plyr__controls");

                                $('.plyr__controls').hide();
                                $('#PPV_free_duration_videoPlayer').hide();
                                
                                displayModal();
                            }
                        }
                });
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
                    default: 0, //Default - AUTO
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

            video.addEventListener('timeupdate', () => {

                if( video.duration >= free_duration_start_time  ){

                    $.ajax({
                    type:'get',
                    url:'<?= route('PPV_Free_Duration_Logs') ?>',
                    data: {
                            "source_id"   : "<?php echo $video_id ?>",
                            "source_type" : "video",
                            "duration"    : "0.20" ,
                        },
                        success:function(data) {

                            let PPVFreeDuration = data ;

                            let freeduration_sec = free_duration_seconds.defaultValue  ;
                            
                            if ( PPVFreeDuration >= freeduration_sec ) {

                                video.pause();

                                const controlsElements = document.getElementsByClassName("plyr__controls");

                                $('.plyr__controls').hide();
                                $('#PPV_free_duration_videoPlayer').hide();
                                
                                displayModal();
                            }
                        }
                    });
                }
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
                    default: 0, //Default - AUTO
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

                video.addEventListener('timeupdate', () => {
                
                let onplay_CurrentTime = sessionStorage.getItem("onplay_current_time") ;
                let seconds_count   = Math.abs(onplay_CurrentTime - video.currentTime)  ;

                $.ajax({
                    type:'get',
                    url:'<?= route('PPV_Free_Duration_Logs') ?>',
                    data: {
                            "source_id"   : "<?php echo $video_id ?>",
                            "source_type" : "video",
                            "duration"    : "0.20" ,
                        },
                        success:function(data) {

                            let PPVFreeDuration = data ;

                            let freeduration_sec = free_duration_seconds.defaultValue  ;
                            
                            if ( PPVFreeDuration >= freeduration_sec ) {

                                video.pause();

                                const controlsElements = document.getElementsByClassName("plyr__controls");

                                $('.plyr__controls').hide();
                                $('#PPV_free_duration_videoPlayer_M3U8_url').hide();
                                
                                displayModal();
                            }
                        }
                 });

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

</script>

<style>
    .modal-ppv-free-purchase{
        right: 0 !important ;
        position: absolute !important ;
        top : 15% !important ;
        height: 500px !important;
    }
</style>



<div id="modal" class="modal modal-ppv-free-purchase">
    <div class="modal-content">
        <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>); background-repeat: no-repeat; background-size: cover; padding:250px 10px;">
            <div id="video_bg_dim"></div>
            <div class="row justify-content-center pay-live">
                <div class="col-md-4 col-sm-offset-4">
                    <div class="ppv-block">
                        <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>
                        <div class="clear"></div>
                        <?php if(Auth::guest()){ ?>
                            <a href="<?php echo URL::to('/login');?>"><button class="btn btn-primary btn-block" >Purchase For Pay <?php echo $currency->symbol.' '.$video->ppv_price; ?></button></a>
                        <?php }else{ ?>
                            <h4 class="text-center" style="margin-top:40px;"><a href="<?=URL::to('/') . '/stripe/billings-details' ?>"><p>Click Here To Become Subscriber</p></a></h4>
                            <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)">Purchase For Pay <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>