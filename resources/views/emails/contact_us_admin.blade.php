
    <div>
        <div style=" background: #edf2f7;">
            <div class="content" style="background: #fff;margin: 5%;">
                    <?php $settings = App\Setting::first(); ?>
                    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }} " class="c-logo" > </a>
            <div>

            <div style="margin:2% !important">
                
                <p>  &nbsp;&nbsp;&nbsp;&nbsp; Dear Admin,  &nbsp;&nbsp;&nbsp;&nbsp; </p>

                <p>    &nbsp;&nbsp;&nbsp;&nbsp; New Notification Message from {{ $username }}. &nbsp;&nbsp;&nbsp;&nbsp; </p>

                <p>    &nbsp;&nbsp;&nbsp;&nbsp; Message {{ $originalMessage}} &nbsp;&nbsp;&nbsp;&nbsp; </p>

                <p>    &nbsp;&nbsp;&nbsp;&nbsp; Sincerely,  &nbsp;&nbsp;&nbsp;&nbsp; </p>

                <p>    &nbsp;&nbsp;&nbsp;&nbsp; Team {{ $website_name }}  &nbsp;&nbsp;&nbsp;&nbsp; </p>
  
                </p>

                <p> &nbsp;&nbsp;&nbsp;&nbsp;  {!! html_entity_decode (MailSignature()) !!}  &nbsp;&nbsp;&nbsp;&nbsp; </p>
            </div>

        </div>
    </div>
    

