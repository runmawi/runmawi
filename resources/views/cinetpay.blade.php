
<link rel="manifest" href="https://cinetpay.com/assets/favicon/manifest.json">

<link rel="stylesheet" href="https://cinetpay.com/assets/styles.css">
<script src="https://cinetpay.com/assets/js/sdk_seamless.js"></script>
<script src="https://cinetpay.com/assets/js/jquery-3.6.0.min.js"></script>

<body>
<div class="col-md-6">
<form id="payDemo" action="#" method="post">

<div class="col-md-12 text-center mt-3">
<button type="submit" class="btn btn-primary-custom-demo btn-block special-btn" id="submitBtn">
Test the solution
</button>
</div>
</div>
</form>
</div>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://cinetpay.com/assets/js/bootstrap.js"></script>
<script src="https://cinetpay.com/assets/js/script.js"></script>
<script src="https://cinetpay.com/vendor/sweetalert/sweetalert.all.js"></script>
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MFZCV7"
            height="0" width="0" style="display:none;visibility:hidden" title="GTM"></iframe>
</noscript>
<script>
        $("#payDemo").submit(function (event) {
            $("#submitBtn").attr("disabled", !0);
            $("#submitBtn").html("<div class='spinner'><div class='bounce1'></div><div class='bounce2'></div><div class='bounce3'></div></div>");
            event.preventDefault();


            var amount = 100;
            var cpm_currency = 'XOF';

            if (isNaN(amount)) {
                return Swal.fire({
                    icon: 'error',
                    title: 'You must enter an amount',
                    text: 'To make a payment you must enter a correct amount',
                })
            }

            var supported_amount = {
                "USD": [1, 3000],
                "EUR": [1, 3000],
                "XOF": [100, 1500000],
                "XAF": [100, 1500000],
                "CDF": [100, 2000000],
                "GNF": [1000, 15000000]
            }

            var payment_method = supported_amount[cpm_currency],
                type_interval = '',
                direction_interval = '',
                montant_interval = '';

            if (amount < payment_method[0] || amount > payment_method[1]) {
                type_interval = amount < payment_method[0] ? 'minimum' : 'maximum';
                direction_interval = amount < payment_method[0] ? 'supérieur' : 'inférieur';
                montant_interval = amount < payment_method[0] ? payment_method[0] : payment_method[1];
                return Swal.fire({
                    icon: 'error',
                    title: 'The amount' + ' ' + type_interval + ' ' + 'is' + ' ' + montant_interval + ' ' + cpm_currency,
                    text: 'To make a payment you must enter an amount' + ' ' + direction_interval + ' ' + 'or equal to' + ' ' + montant_interval + ' ' + cpm_currency,
                }).then(function () {
                    window.location.reload();
                })
            }

            if (cpm_currency !== 'USD') {
                amount = Math.ceil(amount / 5) * 5;
            }

            CinetPay.setConfig({
                apikey: '12912847765bc0db748fdd44.40081707',
                site_id: 445160,
                notify_url: ''
            });

            CinetPay.getCheckout({
                transaction_id: Math.floor(Math.random() * 100000000).toString(),
                amount: amount,
                currency: cpm_currency,
                channels: 'ALL',
                description: 'CinetPay demo payment test',
                cpm_designation: 'CinetPay demo payment test',
                return_url: '',
                notify_url: '',
                alternative_currency: 'EUR',
                //VISA MASTER/CARD
                customer_surname: 'CINETPAY',
                customer_name: 'CINETPAY ENTREPRISE',
                customer_email: 'cinetpay@cinetpay.com',
                customer_phone_number: '+2250709699688',
                customer_address: '15 BP 1080 ABIDJAN 15',
                customer_city: 'ABIDJAN',
                customer_country: 'CI',
                customer_state: '',
                customer_zip_code: '00225'
            });

            CinetPay.waitResponse(function (data) {
                if (data.status == "REFUSED") {
                    return Swal.fire({
                        icon: 'error',
                        title: 'PAYMENT FAILURE',
                        html: 'Your payment failed.',
                    }).then(function () {
                        window.location.reload();
                    })

                } else if (data.status == "ACCEPTED") {
                    return Swal.fire({
                        icon: 'success',
                        title: 'SUCCESSFUL PAYMENT',
                        text: "Payment success, thank you for using CinetPay.",
                    }).then(function () {
                        window.location.reload();
                    })
                }
            });

            CinetPay.onError(function (data) {
            });
        });

    </script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vb26e4fa9e5134444860be286fd8771851679335129114" integrity="sha512-M3hN/6cva/SjwrOtyXeUa5IuCT0sedyfT+jK/OV+s+D0RnzrTfwjwJHhd+wYfMm9HJSrZ1IKksOdddLuN6KOzw==" data-cf-beacon='{"rayId":"7b076adcce7d4dbc","version":"2023.3.0","r":1,"token":"cbf2b5a979f24a62a977bc2f36b4201a","si":100}' crossorigin="anonymous"></script>
</body>

