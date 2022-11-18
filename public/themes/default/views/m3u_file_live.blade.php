<?php if(!empty($video->url_type ) && $video->url_type == "m3u_url"){   ?>

    <script>
    
        document.addEventListener('DOMContentLoaded', () => {

            const video = document.querySelector('video');
            const source = video.getElementsByTagName("source")[0].src;
            const defaultOptions = {};
        
            if (!Hls.isSupported()) {
                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } 
            else {
                const hls = new Hls();
                hls.loadSource(source);
        
                    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                    const availableQualities = hls.levels.map((l) => l.height)
        
                    availableQualities.unshift(0) 
                    defaultOptions.quality = {
                        default: 0, 
                        options: availableQualities,
                        forced: true,        
                        onChange: (e) => updateQuality(e),
                    }
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
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
        
                hls.attachMedia(video); window.hls = hls; }
        
                function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; 
                } 
                else {
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

<?php } ?> 