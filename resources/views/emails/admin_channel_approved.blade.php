<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        <?php $settings = App\Setting::first(); ?>
        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/'); ?>"> <img
                src="{{ $message->embed(Mail_Image()) }}" class="c-logo">
        </a>

        <div>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $settings->website_name; ?>,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Channel Partner Portal <?php echo $Channel->username; ?>. Your Uploaded Content has been
                Submitted for Approved. &nbsp;&nbsp;&nbsp;&nbsp; </p>

            <p> &nbsp;&nbsp;&nbsp;Sincerely,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p>&nbsp;&nbsp;&nbsp;Team <?php echo $settings->website_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>

            <p> &nbsp;&nbsp;&nbsp;<?php echo html_entity_decode (MailSignature()) ; ?> &nbsp;&nbsp;&nbsp;&nbsp;</p>


        </div>
    </div>
