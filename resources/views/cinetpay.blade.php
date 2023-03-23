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
    <?php
$marchand = array(
    "apikey" => "17747086006413350a27b974.55294931", // Enrer votre apikey
    "site_id" => "751850", //Entrer votre site_ID
    "secret_key" => "32949670764133fbd6e2ec4.97601606" //Entrer votre clé secret
);
?>
    <script>
        function checkout() {
            CinetPay.setConfig({
                apikey: '17747086006413350a27b974.55294931',//   YOUR APIKEY
                site_id: '751850',//YOUR_SITE_ID
                notify_url: 'http://mondomaine.com/notify/',
                mode: 'SANDBOX'
            });
            CinetPay.getCheckout({
                transaction_id: Math.floor(Math.random() * 100000000).toString(), // YOUR TRANSACTION ID
                amount: 100,
                currency: 'XOF',
                channels: 'ALL',
                description: 'Test de paiement',   
                 //Fournir ces variables pour le paiements par carte bancaire
                customer_name:"Joe",//Le nom du client
                customer_surname:"Down",//Le prenom du client
                customer_email: "down@test.com",//l'email du client
                customer_phone_number: "088767611",//l'email du client
                customer_address : "BP 0024",//addresse du client
                customer_city: "Antananarivo",// La ville du client
                customer_country : "CM",// le code ISO du pays
                customer_state : "CM",// le code ISO l'état
                customer_zip_code : "06510", // code postal

            });
            CinetPay.waitResponse(function(data) {
                if (data.status == "REFUSED") {
                    if (alert("Votre paiement a échoué")) {
                        window.location.reload();
                    }
                } else if (data.status == "ACCEPTED") {
                    if (alert("Votre paiement a été effectué avec succès")) {
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
    </head>
    <body>
        <div class="sdk">
            <h1>SDK SEAMLESS</h1>
            <button onclick="checkout()">Checkout</button>
        </div>
    </body>
</html>  