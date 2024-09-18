<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $website_name }}</title>
</head>

<body>
    <div>
        <div style=" background: #edf2f7;">

            <div class="content" style="background: #fff;margin: 5%;">
                <a style="margin-left: 39%;" class="navbar-brand" href="{{ URL::to('/') }}">
                    <img src="{{ $message->embed(Mail_Image()) }}" class="c-logo">
                </a>
            <div>

            <div style="margin:2% !important">
                <h2>Verify Your Email Address</h2>

                <p> 
                    Thanks for creating an account with {{ $website_name }}.
                    Kindly activate the account with this code , {{ $activation_code }}.<br/>
                </p>
                <p> {!! html_entity_decode (MailSignature()) !!}</p>
            </div>
        </div>
    </div>
</body>
</html>