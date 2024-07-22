<script src="https://checkout.stripe.com/checkout.js"></script>

<script>

    function pay(amount) {

        let publishable_key = '<?php echo @$publishable_key ; ?>';

        let video_id = '<?php echo @$videodetail->id ; ?>';

        var handler = StripeCheckout.configure({

            key: publishable_key,
            locale: 'auto',
            token: function(token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                console.log('Token Created!!');
                console.log(token);
                $('#token_response').html(JSON.stringify(token));

                $.ajax({
                    url: '<?php echo URL::to('purchase-video'); ?>',
                    method: 'post',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        tokenId: token.id,
                        amount: amount,
                        video_id: video_id
                    },
                    success: (response) => {
                        alert("You have done  Payment !");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    },
                    error: (error) => {
                        swal('error');
                    }
                })
            }
        });

        handler.open({
            name: '<?php $settings = App\Setting::first();
            echo $settings->website_name; ?>',
            description: 'Rent a Video',
            amount: amount * 100
        });
    }

</script>