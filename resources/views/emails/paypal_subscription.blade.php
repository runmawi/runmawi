<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
        
        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>

        <hr>
        <h2 style="color:#3d4852;margin-left: 5%;">Hello {{ $name }} </h2> <br>
        <p style="color:#718096;margin-left: 5%;"> Welcome to <b>EliteClub</b>.</p>
        <br>
        <div style="width: 500px; color:#718096;margin-left: 5%;">
            YOUR MEMBERSHIP<br>
            <table style="width: 500px;color:#718096;">
                <tr>
                    <td>Membership:</td>
                    <td>Subscriber</td>
                </tr>
                <tr>
                    <td>Your Subscription End At:</td>
                    <td>{{ $paypal_end_at }}</td>
                </tr>
            </table>
            <br />
        </div>
        <?php echo html_entity_decode (MailSignature()) ; ?>
    </div>
</div>
