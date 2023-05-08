<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        <?php $settings = App\Setting::find(1);
            $user = Session::get('user');
        ?>

        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/'); ?>"> <img
                src="{{ $message->embed(Mail_Image()) }}" class="c-logo"> </a>


        <div>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $settings->website_name; ?>,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Content Partner Portal <?php echo $user->username; ?>.Uploaded Content has been Submitted
                for Approval. &nbsp;&nbsp;&nbsp;&nbsp; </p>
            <p> &nbsp;&nbsp;&nbsp;{{ @$UploadMessage }}&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;Sincerely,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p>&nbsp;&nbsp;&nbsp;Team <?php echo $settings->website_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>

            <p> &nbsp;&nbsp;&nbsp;<?php echo html_entity_decode (MailSignature()) ; ?> &nbsp;&nbsp;&nbsp;&nbsp;</p>


        </div>
    </div>
