<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">

        <a style="margin-left: 39%;" class="navbar-brand" href="<?php ( route('comment_section') ); ?>"> <img src="{{ $message->embed(Mail_Image()) }}" class="c-logo"></a>

        <div>
            <p> &nbsp;&nbsp;&nbsp;&nbsp;Dear Admin ,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo Auth::user()->username; ?> submitted the Comments and is awaiting approval . &nbsp;&nbsp;&nbsp;&nbsp; </p>

            <p> &nbsp;&nbsp;&nbsp;Sincerely,&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p>&nbsp;&nbsp;&nbsp;Team <?php echo GetWebsiteName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>

            <p> &nbsp;&nbsp;&nbsp;<?php echo html_entity_decode(MailSignature()); ?> &nbsp;&nbsp;&nbsp;&nbsp;</p>

        </div>
    </div>
</div>