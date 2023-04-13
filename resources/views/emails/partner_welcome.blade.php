<?php 
            // Partner Welcome Template - signup
    $template = App\EmailTemplate::where('id','=',43)->first(); 
    $template_description = $template->description ;

    $template_change = array( 
        "{Partner Name}", 
        "{Website Name}", 
    );

    $template_content= array( 
        $Partner_Name,
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
                <p> {!! html_entity_decode (MailSignature()) !!}</p>
            </div>

        </div>
    </div>
    

