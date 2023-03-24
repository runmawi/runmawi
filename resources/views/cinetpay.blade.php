<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>
    <style>
        .sdk {
            display: block;
            position: absolute;
            background-position: center;
            text-align: center;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <script>
        function checkout() {
            CinetPay.setConfig({
                apikey: '17747086006413350a27b974.55294931',//   YOUR APIKEY
                site_id: 751850,//YOUR_SITE_ID
                notify_url: 'https://alorevod.com/category/videos/',
                return_url: 'https://alorevod.com/category/videos/',
                mode: 'PRODUCTION'
            });
            CinetPay.getCheckout({
               transaction_id: Math.floor(Math.random() * 100000000).toString(), // YOUR TRANSACTION ID
               amount: 100,
               currency: 'XOF',
               channels: 'ALL',
               description: 'Test paiement',
               //Provide these variables for credit card payments
               customer_name:"Joe",//Customer name
               customer_surname:"Down",//The customer's first name
               customer_email: "down@test.com",//the customer's email
               customer_phone_number: "088767611",//the customer's email
               customer_address: "BP 0024",//customer address
               customer_city: "Antananarivo",// The customer's city
               customer_country: "CM",// the ISO code of the country
               customer_state: "CM",// the ISO state code
               customer_zip_code: "06510", // postcode

            });
            CinetPay.waitResponse(function(data) {
                if (data.status == "REFUSED") {
                    if (alert("Your payment failed")) {
                        window.location.reload();
                    }
                } else if (data.status == "ACCEPTED") {
                    if (alert("Your payment has been made successfully")) {
                        window.location.reload();
                    }
                }
            });
            CinetPay.onError(function(data) {
                console.log(data);
            });
        }
    </script>
</head>
<body>
    <body>
        <div class="sdk">
            <h1>SDK SEAMLESS</h1>
            <button onclick="checkout()">Checkout</button>
        </div>
    </body>
</html>  