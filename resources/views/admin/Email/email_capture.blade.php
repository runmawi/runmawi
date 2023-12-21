<html>
<head>
    <title>New Email Capture on the Teefatv Site</title>
</head>
<body>

    <h1>{{ 'New Email Capture on the Teefatv Site' }}</h1>
    <p>{{ "Email - ". $email }}</p>
   
    <p>Thank you</p>
    <p> {!! html_entity_decode (MailSignature()) !!}</p>

</body>
</html>