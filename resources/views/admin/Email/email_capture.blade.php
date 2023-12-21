<html>
<head>
    <title>Email Capture Details</title>
</head>
<body>

    <h1>{{ 'Email Capture Details' }}</h1>
    <p>{{ $Email_ }}</p>
   
    <p>Thank you</p>
    <p> {!! html_entity_decode (MailSignature()) !!}</p>

</body>
</html>