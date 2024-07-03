<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(!empty($errors) && count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage" >
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif

    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with <?= $website_name ?>.
            Please follow the link below to verify your email address
            <?= URL::to('verify/' . $activation_code) ?>.<br/>

        </div>
        <?php echo html_entity_decode (MailSignature()) ;?>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
    

    </script>
</html>


