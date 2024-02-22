<?php 
    $user = !Auth::guest() ? Auth::User()->id : 'guest' ; 
?>

<script>
    var type = $('#video_type').val();
    var request_url = $('#request_url').val();
    var live = $('live').val();
    var video_video = $('#video_video').val();
    var user_logged_out = $('#user_logged_out').val();
    var hls = $('#hls').val();
    var video_tag_url = $('#video_tag_url').val();
    var processed_low = $('#processed_low').val();
    var episode_type = $('#episode_type').val();

    // Normal MP4 URL Script


    if (type != "" && type != "m3u8_url" && video_video == 'video' && type != 'aws_m3u8') {
        // alert('video_video')

        const player = new Plyr('#videoPlayer', {
            controls: ['play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'progress',
                'current-time',
                'mute',
                'volume',
                'captions',
                'settings',
                'pip',
                'airplay',
                'fullscreen',
                'capture'
            ],
            i18n: {
                capture: 'capture'
            },

            ads: {
                enabled: true,
                tagUrl: video_tag_url
            }
        });

            // Ads Views Count
        player.on('adsloaded', (event) => {
            Ads_Views_Count();
        });

            // Ads Redirection Count
        player.on('adsclick', (event) => {
            Ads_Redirection_URL_Count(event.timeStamp);
        });

        player.on('seeked', () => {
            const seekedTime = player.currentTime;
            const duration = player.duration;
            console.log('Seeked time:', seekedTime);
            // Send seekedTime to Laravel backend

            var videotype = $('#video_type').val();
            var video_title = $('#video_title').val();
            var video_slug = $('#videoslug').val();
            var videoid = $('#video_id').val();
            var url = '<?= URL::to('player_seektime_store') ?>';
            // alert(seekedTime);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: '<?= csrf_token() ?>',
                    video_slug: video_slug,
                    video_id: videoid,
                    duration: duration,
                    seekedTime: seekedTime,
                    video_title: video_title,
                },
                success: function(data) {

                }
            });
        });
    }

    // Normal MP4 URL Script
    else if (type != "" && request_url != 'm3u8' && episode_type != 'm3u8' && episode_type != 'aws_m3u8' && type !=
        'aws_m3u8') {
        // alert('m3u8')

        const player = new Plyr('#videoPlayer', {
            controls: [

                'play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'progress',
                'current-time',
                'mute',
                'volume',
                'captions',
                'settings',
                'pip',
                'airplay',
                'fullscreen',
                'capture'
            ],
            i18n: {
                // your other i18n
                capture: 'capture'
            },
            ads: {
                enabled: true,
                publisherId: '',
                tagUrl: video_tag_url
            }
        });
        player.on('seeked', () => {
            const seekedTime = player.currentTime;
            const duration = player.duration;
            console.log('Seeked time:', seekedTime);
            // Send seekedTime to Laravel backend

            var videotype = $('#video_type').val();
            var video_title = $('#video_title').val();
            var video_slug = $('#videoslug').val();
            var videoid = $('#video_id').val();
            var url = '<?= URL::to('player_seektime_store') ?>';
            // alert(seekedTime);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: '<?= csrf_token() ?>',
                    video_slug: video_slug,
                    video_id: videoid,
                    duration: duration,
                    seekedTime: seekedTime,
                    video_title: video_title,
                },
                success: function(data) {

                }
            });
        });
    }

    // Normal MP4 URL Script
    else if (user_logged_out == 1 && type == '' && type != 'aws_m3u8' && processed_low != 100 || user_logged_out == 1 &&
        type == '' && processed_low == "") {
        // alert('videoPlayer')


        const player = new Plyr('#videoPlayer', {
            controls: [

                'play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'progress',
                'current-time',
                'mute',
                'volume',
                'captions',
                'settings',
                'pip',
                'airplay',
                'fullscreen',
                'capture'
            ],
            i18n: {
                // your other i18n
                capture: 'capture'
            },
            ads: {
                enabled: true,
                publisherId: '',
                tagUrl: video_tag_url
            }
        });
        player.on('seeked', () => {
            const seekedTime = player.currentTime;
            const duration = player.duration;
            console.log('Seeked time:', seekedTime);
            // Send seekedTime to Laravel backend

            var videotype = $('#video_type').val();
            var video_title = $('#video_title').val();
            var video_slug = $('#videoslug').val();
            var videoid = $('#video_id').val();
            var url = '<?= URL::to('player_seektime_store') ?>';
            // alert(seekedTime);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: '<?= csrf_token() ?>',
                    video_slug: video_slug,
                    video_id: videoid,
                    duration: duration,
                    seekedTime: seekedTime,
                    video_title: video_title,
                },
                success: function(data) {

                }
            });
        });
    }
    // Normal Episode HLS and M3U8 URL Script Not for Video
    else if (episode_type == 'm3u8' || episode_type == 'aws_m3u8' && type != 'aws_m3u8') {

        // alert('episode_type')

        document.addEventListener("DOMContentLoaded", () => {
            const video = document.querySelector("video");
            const source = video.getElementsByTagName("source")[0].src;

            const defaultOptions = {};

            if (!Hls.isSupported()) {

                defaultOptions.ads = {
                    enabled: true,
                    tagUrl: video_tag_url
                }

                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } else {
                const hls = new Hls();
                hls.loadSource(source);

                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    defaultOptions.quality = {
                        default: 0, //theme7 - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                        var span = document.querySelector(
                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })
                    // var player = new Plyr(video, defaultOptions);

                    var player = new Plyr(video, {
        ...defaultOptions, // Keep existing default options
        controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
        // Specify only the controls you want to use (excluding rewind and fast-forward)
    });


                    addSeekedEventListener(player);

                    
                    // Create and append custom rewind icon to Plyr control bar
                    const rewindIcon = document.createElement("button");
                        rewindIcon.className = "plyr__controls__item plyr__control";
                        rewindIcon.innerHTML = '<i class="fas fa-backward"></i>';
                        rewindIcon.addEventListener("click", () => {
                            const seekTime = Math.max(0, player.currentTime - 10); // Rewind by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(rewindIcon);
                        const playButton = player.elements.controls.querySelector(".plyr__controls__item[data-plyr='play']");

                        // Create and append custom fast-forward icon to Plyr control bar
                        const fastForwardIcon = document.createElement("button");
                        fastForwardIcon.className = "plyr__controls__item plyr__control";
                        fastForwardIcon.innerHTML = '<i class="fas fa-forward"></i>';
                        fastForwardIcon.addEventListener("click", () => {
                            const seekTime = Math.min(player.duration, player.currentTime + 10); // Fast-forward by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(fastForwardIcon);
                        player.elements.controls.insertBefore(rewindIcon, playButton);
                        player.elements.controls.insertBefore(fastForwardIcon, playButton.nextSibling);
                        });

                // });

                hls.attachMedia(video);
                window.hls = hls;
            }

            function addSeekedEventListener(player) {
                // Get seeked time when Plyr's seeked event is triggered
                player.on('seeked', () => {
                    const seekedTime = player.currentTime;
                    const duration = player.duration

                    // Send seekedTime to Laravel backend

                    var videotype = $('#video_type').val();
                    var video_title = $('#video_title').val();
                    var video_slug = $('#videoslug').val();
                    var videoid = $('#video_id').val();
                    var url = '<?= URL::to('player_seektime_store') ?>';
                    // alert(seekedTime);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            _token: '<?= csrf_token() ?>',
                            video_slug: video_slug,
                            video_id: videoid,
                            duration: duration,
                            seekedTime: seekedTime,
                            video_title: video_title,
                        },
                        success: function(data) {

                        }
                    });

                });
            }

            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
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

        // VIDEO WATCHED TIME CONTINUE WATCHING

        $(window).on("beforeunload", function() {

            var vid = document.getElementById("video");
            var currentTime = vid.currentTime;
            var duration = vid.duration;
            var videotype = $('#video_type').val();

            var videoid = $('#video_id').val();
            $.post('<?= URL::to('continue-watching') ?>', {
                video_id: videoid,
                duration: duration,
                currentTime: currentTime,
                _token: '<?= csrf_token() ?>'
            }, function(data) {
                //    toastr.success(data.success);
            });

            return;
        });

    }
    // Normal HLS Video
    else if (hls == "hls" && type != 'aws_m3u8') {

        const player = new Plyr('#videoPlayer', {
            controls: ['play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'progress',
                'current-time',
                'mute',
                'volume',
                'captions',
                'settings',
                'pip',
                'airplay',
                'fullscreen',
                'capture'
            ],
            i18n: {
                capture: 'capture'
            },

            ads: {
                enabled: true,
                publisherId: '',
                tagUrl: video_tag_url
            }
        });
        
        player.on('seeked', () => {
            const seekedTime = player.currentTime;
            const duration = player.duration;
            console.log('Seeked time:', seekedTime);
            // Send seekedTime to Laravel backend

            var videotype = $('#video_type').val();
            var video_title = $('#video_title').val();
            var video_slug = $('#videoslug').val();
            var videoid = $('#video_id').val();
            var url = '<?= URL::to('player_seektime_store') ?>';
            // alert(seekedTime);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: '<?= csrf_token() ?>',
                    video_slug: video_slug,
                    video_id: videoid,
                    duration: duration,
                    seekedTime: seekedTime,
                    video_title: video_title,
                },
                success: function(data) {

                }
            });
        });
    }
    // Normal Video AND LIVE AWS M3U8 URL Script   
    else if (type == 'aws_m3u8') {

        // alert(type);
        document.addEventListener("DOMContentLoaded", () => {
            const video = document.querySelector("video");
            const source = video.getElementsByTagName("source")[0].src;
            if (!Hls.isSupported()) {

                defaultOptions.ads = {
                    enabled: true,
                    tagUrl: video_tag_url
                }
                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } else {
                const hls = new Hls();
                hls.loadSource(source);

                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: 0, //theme7 - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                        var span = document.querySelector(
                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })

                    // Initialize new Plyr player with quality options
                    // var player = new Plyr(video, defaultOptions);
                    var player = new Plyr(video, {
        ...defaultOptions, // Keep existing default options
        controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
        // Specify only the controls you want to use (excluding rewind and fast-forward)
    });

                    addSeekedEventListener(player);

                    // Create and append custom rewind icon to Plyr control bar
                    const rewindIcon = document.createElement("button");
                        rewindIcon.className = "plyr__controls__item plyr__control";
                        rewindIcon.innerHTML = '<i class="fas fa-backward"></i>';
                        rewindIcon.addEventListener("click", () => {
                            const seekTime = Math.max(0, player.currentTime - 10); // Rewind by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(rewindIcon);
                        const playButton = player.elements.controls.querySelector(".plyr__controls__item[data-plyr='play']");

                        // Create and append custom fast-forward icon to Plyr control bar
                        const fastForwardIcon = document.createElement("button");
                        fastForwardIcon.className = "plyr__controls__item plyr__control";
                        fastForwardIcon.innerHTML = '<i class="fas fa-forward"></i>';
                        fastForwardIcon.addEventListener("click", () => {
                            const seekTime = Math.min(player.duration, player.currentTime + 10); // Fast-forward by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(fastForwardIcon);
                        player.elements.controls.insertBefore(rewindIcon, playButton);
                        player.elements.controls.insertBefore(fastForwardIcon, playButton.nextSibling);
                        });

                // });

                hls.attachMedia(video);
                window.hls = hls;
            }

            function addSeekedEventListener(player) {
                // Get seeked time when Plyr's seeked event is triggered
                player.on('seeked', () => {
                    const seekedTime = player.currentTime;
                    const duration = player.duration

                    // Send seekedTime to Laravel backend

                    var videotype = $('#video_type').val();
                    var video_title = $('#video_title').val();
                    var video_slug = $('#videoslug').val();
                    var videoid = $('#video_id').val();
                    var url = '<?= URL::to('player_seektime_store') ?>';

                    // alert(seekedTime);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            _token: '<?= csrf_token() ?>',
                            video_slug: video_slug,
                            video_id: videoid,
                            duration: duration,
                            seekedTime: seekedTime,
                            video_title: video_title,
                        },
                        success: function(data) {

                        }
                    });


                });
            }

            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
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
    }
    // Normal Video M3U8 URL Script   
    else {
        // alert('ss');

        document.addEventListener("DOMContentLoaded", () => {
            const video = document.querySelector("video");
            const source = video.getElementsByTagName("source")[0].src;

            const defaultOptions = {};

            if (Hls.isSupported()) {

                defaultOptions.ads = {
                    enabled: true,
                    tagUrl: video_tag_url
                }

                const hls = new Hls();
                hls.loadSource(source);

                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    // Transform available levels into an array of integers (height values).
                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: 0, //theme7 - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                        var span = document.querySelector(
                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })

                    // Initialize new Plyr player with quality options
                    // var player = new Plyr(video, defaultOptions);
                    var player = new Plyr(video, {
        ...defaultOptions, // Keep existing default options
        controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
        // Specify only the controls you want to use (excluding rewind and fast-forward)
    });

                        // Ads Views Count
                    player.on('adsloaded', (event) => {
                        Ads_Views_Count();
                    });

                        // Ads Redirection Count
                    player.on('adsclick', (event) => {
                        Ads_Redirection_URL_Count(event.timeStamp);
                    });

                    addSeekedEventListener(player);

                    // Create and append custom rewind icon to Plyr control bar
                        const rewindIcon = document.createElement("button");
                        rewindIcon.className = "plyr__controls__item plyr__control";
                        rewindIcon.innerHTML = '<i class="fas fa-backward"></i>';
                        rewindIcon.addEventListener("click", () => {
                            const seekTime = Math.max(0, player.currentTime - 10); // Rewind by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(rewindIcon);
                        const playButton = player.elements.controls.querySelector(".plyr__controls__item[data-plyr='play']");

                        // Create and append custom fast-forward icon to Plyr control bar
                        const fastForwardIcon = document.createElement("button");
                        fastForwardIcon.className = "plyr__controls__item plyr__control";
                        fastForwardIcon.innerHTML = '<i class="fas fa-forward"></i>';
                        fastForwardIcon.addEventListener("click", () => {
                            const seekTime = Math.min(player.duration, player.currentTime + 10); // Fast-forward by 10 seconds
                            player.currentTime = seekTime;
                        });
                        // player.elements.controls.appendChild(fastForwardIcon);
                        player.elements.controls.insertBefore(rewindIcon, playButton);
                        player.elements.controls.insertBefore(fastForwardIcon, playButton.nextSibling);
                        });

                hls.attachMedia(video);
                window.hls = hls;

                // Get seek time when Plyr's timeupdate event is triggered
                function addSeekedEventListener(player) {
                    // Get seeked time when Plyr's seeked event is triggered
                    player.on('seeked', () => {
                        const seekedTime = player.currentTime;
                        const duration = player.duration

                        // Send seekedTime to Laravel backend

                        var videotype = $('#video_type').val();
                        var video_title = $('#video_title').val();
                        var video_slug = $('#videoslug').val();
                        var url = '<?= URL::to('player_seektime_store') ?>';
                        var videoid = $('#video_id').val();
                        // alert(seekedTime);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: url,
                            type: "post",
                            data: {
                                _token: '<?= csrf_token() ?>',
                                video_id: videoid,
                                video_slug: video_slug,
                                duration: duration,
                                seekedTime: seekedTime,
                                video_title: video_title,
                            },
                            success: function(data) {

                            }
                        });

                    });
                }


                function updateQuality(newQuality) {
                    if (newQuality === 0) {
                        window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                    } else {
                        window.hls.levels.forEach((level, levelIndex) => {
                            if (level.height === newQuality) {
                                console.log("Found quality match with " + newQuality);
                                window.hls.currentLevel = levelIndex;
                            }
                        });
                    }
                }

                // VIDEO WATCHED TIME CONTINUE WATCHING

                $(window).on("beforeunload", function() {

                    var vid = document.getElementById("video");
                    var currentTime = vid.currentTime;
                    var duration = vid.duration;
                    var bufferedTimeRanges = vid.buffered;
                    var bufferedTimeRangesLength = bufferedTimeRanges.length;
                    var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
                    // var videotype= '<? //$video->type ?>';
                    var videotype = $('#video_type').val();

                    var videoid = $('#video_id').val();
                    $.post('<?= URL::to('player_analytics_store') ?>', {
                        video_id: videoid,
                        duration: duration,
                        currentTime: currentTime,
                        seekableEnd: seekableEnd,
                        bufferedTimeRanges: bufferedTimeRangesLength,
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    return;
                });

                // VIDEO WATCHED TIME CONTINUE WATCHING

                $(window).on("beforeunload", function() {

                    var vid = document.getElementById("video");
                    var currentTime = vid.currentTime;
                    var duration = vid.duration;
                    var videotype = $('#video_type').val();

                    var videoid = $('#video_id').val();
                    $.post('<?= URL::to('continue-watching') ?>', {
                        video_id: videoid,
                        duration: duration,
                        currentTime: currentTime,
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {
                        //    toastr.success(data.success);
                    });

                    return;
                });

            } else {

                const player = new Plyr('#video', {
                    controls: [
                        'play-large',
                        'restart',
                        'rewind',
                        'play',
                        'fast-forward',
                        'progress',
                        'current-time',
                        'mute',
                        'volume',
                        'captions',
                        'settings',
                        'pip',
                        'airplay',
                        'fullscreen',
                        'capture'
                    ],
                    i18n: {
                        capture: 'capture'
                    },

                    ads: {
                        enabled: true,
                        tagUrl: video_tag_url
                    }
                });
                player.on('seeked', () => {
                    const seekedTime = player.currentTime;
                    const duration = player.duration;
                    console.log('Seeked time:', seekedTime);
                    // Send seekedTime to Laravel backend

                    var videotype = $('#video_type').val();
                    var video_title = $('#video_title').val();
                    var video_slug = $('#videoslug').val();
                    var videoid = $('#video_id').val();
                    var url = '<?= URL::to('player_seektime_store') ?>';
                    // alert(seekedTime);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            _token: '<?= csrf_token() ?>',
                            video_slug: video_slug,
                            video_id: videoid,
                            duration: duration,
                            seekedTime: seekedTime,
                            video_title: video_title,
                        },
                        success: function(data) {

                        }
                    });
                });
                // VIDEO WATCHED TIME CONTINUE WATCHING

                $(window).on("beforeunload", function() {

                    var vid = document.getElementById("video");
                    var currentTime = vid.currentTime;
                    var duration = vid.duration;
                    var bufferedTimeRanges = vid.buffered;
                    var bufferedTimeRangesLength = bufferedTimeRanges.length;
                    var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
                    // var videotype= '<? //$video->type ?>';
                    var videotype = $('#video_type').val();

                    var videoid = $('#video_id').val();
                    $.post('<?= URL::to('player_analytics_store') ?>', {
                        video_id: videoid,
                        duration: duration,
                        currentTime: currentTime,
                        seekableEnd: seekableEnd,
                        bufferedTimeRanges: bufferedTimeRangesLength,
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    return;
                });

                // VIDEO WATCHED TIME CONTINUE WATCHING

                $(window).on("beforeunload", function() {

                    var vid = document.getElementById("video");
                    var currentTime = vid.currentTime;
                    var duration = vid.duration;
                    var bufferedTimeRanges = vid.buffered;
                    var bufferedTimeRangesLength = bufferedTimeRanges.length;
                    var seekableEnd = vid.seekable.end(vid.seekable.length - 1);
                    // var videotype= '<? //$video->type ?>';
                    var videotype = $('#video_type').val();

                    var videoid = $('#video_id').val();
                    $.post('<?= URL::to('player_analytics_store') ?>', {
                        video_id: videoid,
                        duration: duration,
                        currentTime: currentTime,
                        seekableEnd: seekableEnd,
                        bufferedTimeRanges: bufferedTimeRangesLength,
                        _token: '<?= csrf_token() ?>'
                    }, function(data) {});
                    return;
                });
            }

        });

    }

    function Ads_Redirection_URL_Count(timestamp_time){

        let video_id = $('#video_id').val() ;
        let ads_tag_url_id = $('#ads_tag_url_id').val() ;

        $.ajax({
            type:'get',
            url:'<?= route('Advertisement_Redirection_URL_Count') ?>',
            data: {
                        "Count" : 1 , 
                        "source_type" : "videos",
                        "source_id"   : video_id ,
                        "adveristment_id" : ads_tag_url_id ,
                        "user" : "<?php echo $user ?>",
                        "timestamp_time" : timestamp_time ,
                },
                success:function(data) {
                }
        });
    }

    function Ads_Views_Count(){

        let video_id = $('#video_id').val() ;
        let ads_tag_url_id = $('#ads_tag_url_id').val() ;

        $.ajax({
            type:'get',
            url:'<?= route('Advertisement_Views_Count') ?>',
            data: {
                        "Count" : 1 , 
                        "source_type" : "videos",
                        "source_id"   : video_id ,
                        "adveristment_id" : ads_tag_url_id ,
                        "user" : "<?php echo $user ?>",
                },
                success:function(data) {
                }
        });
    }

</script>
