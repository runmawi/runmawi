@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<script src="https://js.recurly.com/v4/recurly.js"></script>
<link href="https://js.recurly.com/v4/recurly.css" rel="stylesheet" type="text/css">

<section>
    <div class="container-fluid">

        <div class="row col-md-12">
            <form id="my-form">

                <div class="col-md-4" id="recurly-elements">
                    <!-- Recurly Elements will be attached here -->
                </div>
            
                <input type="hidden" name="recurly-token" data-recurly="token">
            
                <button>submit</button>
            </form>
        </div>
    </div>
</section>

<script>
    recurly.configure('ewr1-vqBCG3NdYAcm94MqtiVWlb');

    const elements = recurly.Elements();

    const cardElement = elements.CardElement({
        inputType: 'mobileSelect',
        style: {
            fontSize: '1em',
            placeholder: {
                color: 'gray !important',
                fontWeight: 'bold',
                displayIcon: 'true',
                content: {
                    number: 'Card number',
                    cvv: 'CVC',
                    expiry: 'MM / YY'
                }
            },
            invalid: {
                fontColor: 'red'
            }
        }
    });
    cardElement.attach('#recurly-elements');

    document.querySelector('#my-form').addEventListener('submit', function(event) {
        const form = this;
        event.preventDefault();
        recurly.token(elements, form, function(err, token) {
            if (err) {
                console.log(err);
                // handle error using err.code and err.fields
            } else {

                // let ddd = recurly.token(elements, document.querySelector('form'), tokenHandler);
                console.log(token);

                // recurly.js has filled in the 'token' field, so now we can submit the
                // form to your server
                // form.submit();
            }
        });
    });
</script>

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
