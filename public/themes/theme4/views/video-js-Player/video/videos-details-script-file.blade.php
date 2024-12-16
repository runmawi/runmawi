<script>
    function video_watchlater(ele) {
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.watchlater') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.watchlater_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.watchlater_status == "Add" ? 'fal fa-minus' : 'fal fa-plus';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-watchlater').removeClass('fal fa-minus fal fa-plus').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }

    function video_wishlist(ele){
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.wishlist') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.wishlist_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.wishlist_status === "Add" ? 'ri-heart-fill' : 'ri-heart-line';
                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-wishlist').removeClass('ri-heart-line ri-heart-fill').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });

    }

    function video_like(ele){
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.like') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.like_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.like_status == "Add" ? 'ri-thumb-up-fill' : 'ri-thumb-up-line';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-like').removeClass('ri-thumb-up-fill ri-thumb-up-line').addClass(iconClass);

                    $('.video-dislike').removeClass('ri-thumb-down-fill ri-thumb-down-line').addClass('ri-thumb-down-line');

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });

    }

    
    function video_dislike(ele){
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.dislike') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.dislike_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.dislike_status == "Add" ? 'ri-thumb-down-fill' : 'ri-thumb-down-line';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-dislike').removeClass('ri-thumb-down-fill ri-thumb-down-line').addClass(iconClass);

                    $('.video-like').removeClass('ri-thumb-up-fill ri-thumb-up-line').addClass('ri-thumb-up-line');

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });

    }

    function EmbedCopy() {
        var media_path = '<?= $url_path ?>';
        var url = navigator.clipboard.writeText(window.location.href);
        var path = navigator.clipboard.writeText(media_path);
        $("body").append(
            '<div class="add_watch" style="z-index: 100; position: fixed; top: 66px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>'
        );
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    }
  
</script>