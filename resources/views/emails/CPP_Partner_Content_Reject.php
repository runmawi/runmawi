<?php 
            // Partner Content Video Rejected! {video_title} is couldn't be published.
            
    $template = App\EmailTemplate::where('id','=',13)->first(); 
    $template_description = $template->description ;

    $template_change = array( 
        "{Name}", 
        "{ContentName}",
        "{Website Name}", 
    );

    $template_content= array( 
        $Name,
        $ContentName,
        $website_name ,
    ) ;

    $Template_description = str_replace($template_change, $template_content, $template_description);

?>
    <div>
        <div style=" background: #edf2f7;">
            <div class="content" style="background: #fff;margin: 5%;">
                    <?php $settings = App\Setting::first(); ?>
                    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>
            <div>

            <div style="margin:2% !important">
                <p> <?php echo html_entity_decode($Template_description) ?> </p>
                <p>  <?php echo MailSignature() ?> </p>
            </div>

        </div>
    </div>