<script>
    function video_watchlater(ele) {
        
        let source_id     = $(ele).data('source_id');
        let where_column  = $(ele).data('wherecolumn');
        let type          = $(ele).data('type');
        let watchlater_unique_key  = $(ele).data('watchlater-unique-key');

        // alert(watchlater_unique_key);

        $.ajax({
            url: '<?php echo route('home-page.watchlater') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                source_id: source_id,
                type : type ,
                where_column : where_column ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.watchlater_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.watchlater_status == "Add" ? 'ri-subtract-line' : 'ri-add-line';

                    const Watchlater_tooltip = response.data.watchlater_status == "Add" ? 'Remove To Watchlater' : 'Add To Watchlater';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.home-page-watchlater-'+watchlater_unique_key).removeClass('ri-subtract-line ri-add-line').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }

    function video_wishlist(ele){
        
        let source_id     = $(ele).data('source_id');
        let where_column  = $(ele).data('wherecolumn');
        let type          = $(ele).data('type');
        let wishlist_unique_key  = $(ele).data('wishlist-unique-key');

        // alert(wishlist_unique_key);

        $.ajax({
            url: '<?php echo route('home-page.wishlist') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                source_id: source_id,
                type : type ,
                where_column : where_column ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.wishlist_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.wishlist_status == "Add" ? 'ri-heart-fill' : 'ri-heart-line';

                    const wishlist_tooltip = response.data.wishlist_status == "Add" ? 'Remove To Watchlater' : 'Add To Watchlater';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.home-page-wishlist-'+wishlist_unique_key).removeClass('ri-heart-fill ri-heart-line').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    $('.wishlist-tooltip-text').text(wishlist_tooltip);

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }
</script>