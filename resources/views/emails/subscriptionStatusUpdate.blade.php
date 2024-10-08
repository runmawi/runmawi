<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        <?php $settings = App\Setting::find(1);
        
        ?>
        <div>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo @$username; ?>,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;&nbsp; We wanted to inform you that your <?php echo $stripe_status; ?>  has been successfully updated. You can check your current status on our website. &nbsp;&nbsp;&nbsp;&nbsp; </p>
            <p> &nbsp;&nbsp;&nbsp;Sincerely,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p>&nbsp;&nbsp;&nbsp;Team <?php echo $settings->website_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;<?php echo html_entity_decode (MailSignature()) ; ?> &nbsp;&nbsp;&nbsp;&nbsp;</p>
        </div>
</div>
