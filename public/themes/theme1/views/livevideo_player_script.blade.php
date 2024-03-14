<script>

    let live_ads = <?php echo json_encode( $live_ads ); ?> ;

    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#live_player_mp4',{

           controls: [   'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings','pip','airplay',
                        'fullscreen'
		            ],

            ads:{ 
                  enabled: true, 
                  tagUrl: live_ads 
            }
        });
    });


    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#acc_audio',{

        controls: [   'play-large','play','progress',
                        'current-time','mute','volume','captions','settings','airplay',
                        'fullscreen'
                    ],

            ads:{ 
                enabled: true, 
                tagUrl: live_ads 
            },
        });
    });

    document.addEventListener('DOMContentLoaded', () => { 

    const player = new Plyr('#Embed_player',{

          controls: [   'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings','pip','airplay',
                        'fullscreen'
		            ],
        });
    });


    document.addEventListener("DOMContentLoaded", () => {
        const video = document.querySelector("#live_player");
        const source = video.getElementsByTagName("source")[0].src;
  
        const defaultOptions = {};

        if (!Hls.isSupported()) {

            defaultOptions.ads = {
                enabled: true, 
                tagUrl: live_ads
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
                tagUrl: live_ads
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
    });
</script>