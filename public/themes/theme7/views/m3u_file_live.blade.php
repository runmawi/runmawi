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

        function m3u_url(ele){

           var m3u_url_category   = $(ele).attr('data-MU3-category');
           let m3u_url = $(ele).attr('data-MU3-url');

           $.ajax({

            url: "<?=  route('m3u_file_m3u8url') ?>",
            type: "get",
            data: {
                    m3u_url : m3u_url ,
                    m3u_url_category : m3u_url_category ,
                    async: false,
                },       
                
                success: function( data  ){

                if( data.status == true ){

                    var count = data.M3u_url_array.length ;

                    if( count > 0 && data.status == true ){

                        html = "";
                        html += '<div class="modal-body">';
                            html += '<div class="list-group list-group-flush" style="height: calc(100vh - 80px - 75px)!important;">';
                                    
                                    $.each( data.M3u_url_array , function( index, M3u_url_array ) {
                               
                                         let M3u_video_name = M3u_url_array.M3u_video_name ;
                                         let replace_string = M3u_video_name.replace('tvg-id=','') ;

                                        html +='<a data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action list-group-item-light"  data-m3u-urls="'+ M3u_url_array.M3u_video_url +'" onclick="M3U_video_url(this)" > "'+ replace_string.replace( '"','') ; +'"  </a>';
                                    });

                            html += '</div>';
                        html += '</div>';

                        Title_name  = "";
                        Title_name += ' <h4 class="modal-title" id="myModalLabel" > '+ data.M3u_category +' </h4>';
                       
                        $('.data-plans').empty('').append(html);
                        $('#myModalLabel').empty('').append(Title_name);

                    }
                }

                else if( data.status == false ){
                   alert('Sorry! No Data Found');
                   location.reload();
                }
            } 
        });
    }   

    function M3U_video_url(ele){

           var data_m3u_urls   = $(ele).attr('data-m3u-urls');

           $.ajax({

            url: "<?=  route('M3U_video_url') ?>",
            type: "get",
            data: {
                    data_m3u_urls : data_m3u_urls ,
                    async: false,
                },       
                
                success: function( data  ){

                if( data.status == true ){
                    location.reload();
                }
                else if( data.status == false ){
                   alert('Incorrect Access');
                   location.reload();
                }
            } 
        });
    }

    </script>

<?php } ?> 