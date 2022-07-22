<!-- M3U8 - Player  -->

<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>

<script>

    function trailer_slider_videos(ele) 
        {
            var trailer_url   = $(ele).attr('data-trailer-url');
            var trailer_type = $(ele).attr('data-trailer-type');
            var poster_url = $(ele).attr('data-poster-url');

            if( trailer_type == "m3u8" ){
                    
                const video = document.querySelector('#Trailer-videos');
                const source = trailer_url ;
                const defaultOptions = {};

                if (Hls.isSupported()) {
                        const hls = new Hls();
                        hls.loadSource(source);

                        hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                        const availableQualities = hls.levels.map((l) => l.height)

                        defaultOptions.quality = {
                            default: availableQualities[0],
                            options: availableQualities,
                            forced: true,        
                            onChange: (e) => updateQuality(e),
                        }

                        const player = new Plyr(video, defaultOptions);
                        });
                        hls.attachMedia(video);
                        window.hls = hls;
                }

                function updateQuality(newQuality) {
                    window.hls.levels.forEach((level, levelIndex) => {
                    if (level.height === newQuality) {
                        console.log("Found quality match with " + newQuality);
                        window.hls.currentLevel = levelIndex;
                    }
                    });
                }

            }else if(trailer_type == "mp4_url" || trailer_type == "video_mp4"  ){

                const player = new Plyr('#MP4_Trailer-videos',{
                    controls: [
                        'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings',
                        'pip','airplay','fullscreen'
                    ],
                });

                player.source = {
                    type: 'video',
                    sources: [
                        {
                            src: trailer_url,
                            type: type,
                            size: 720
                        }
                    ],
                    poster: poster_url
                };

                $('#MP4_Trailer-videos').attr('src', trailer_url);

            }else if( trailer_type == "m3u8_url"){

                const video = document.querySelector('#M3U8_video-videos');
                const source = trailer_url ;
                const defaultOptions = {};

                if (Hls.isSupported()) {
                        const hls = new Hls();
                        hls.loadSource(source);

                        hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                        const availableQualities = hls.levels.map((l) => l.height)

                        defaultOptions.quality = {
                            default: availableQualities[0],
                            options: availableQualities,
                            forced: true,        
                            onChange: (e) => updateQuality(e),
                        }

                        const player = new Plyr(video, defaultOptions);
                        });
                        hls.attachMedia(video);
                        window.hls = hls;
                }

                function updateQuality(newQuality) {
                    window.hls.levels.forEach((level, levelIndex) => {
                    if (level.height === newQuality) {
                        console.log("Found quality match with " + newQuality);
                        window.hls.currentLevel = levelIndex;
                    }
                    });
            }
        }
    }

    function trailer_slider_season(ele) 
         {
            var trailer_url   = $(ele).attr('data-trailer-url');
            var trailer_type = $(ele).attr('data-trailer-type');
            var poster_url = $(ele).attr('data-poster-url');
                  

            if(trailer_type == "m3u8_url"){

                const video = document.querySelector('#Trailer-videos');
                const source = trailer_url ;
                const defaultOptions = {};

                if (Hls.isSupported()) {
                        const hls = new Hls();
                        hls.loadSource(source);

                        hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                        const availableQualities = hls.levels.map((l) => l.height)

                        defaultOptions.quality = {
                            default: availableQualities[0],
                            options: availableQualities,
                            forced: true,        
                            onChange: (e) => updateQuality(e),
                        }

                        const player = new Plyr(video, defaultOptions);
                        });
                        hls.attachMedia(video);
                        window.hls = hls;
                }

                function updateQuality(newQuality) {
                    window.hls.levels.forEach((level, levelIndex) => {
                    if (level.height === newQuality) {
                        console.log("Found quality match with " + newQuality);
                        window.hls.currentLevel = levelIndex;
                    }
                    });
                }

            }else{
                    
                const players = new Plyr('#Series_MP4_Trailer-videos',{
                    controls: [
                        'play-large','restart','rewind','play','fast-forward','progress',
                        'current-time','mute','volume','captions','settings',
                        'pip','airplay','fullscreen'
                    ],
                });

                players.source = {
                    type: 'video',
                    sources: [
                        {
                            src: trailer_url,
                            type: type,
                            size: 720
                        }
                    ],
                    poster: poster_url
                }

                $('#Series_MP4_Trailer-videos').attr('src', trailer_url);
            }
        }
</script>