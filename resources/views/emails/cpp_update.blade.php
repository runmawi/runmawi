<?php 
            // Partner Content Partner Content Update
            
    $template = App\EmailTemplate::where('id','=',14)->first(); 
    $template_description = $template->description ;

    $template_change = array( 
        "{Name}", 
        "{ContentName}",
        "{ContentPermalink}",
        "{Website Name}", 
    );

    $template_content= array( 
        $username,
        $ContentName,
        $ContentPermalink,
        $website_name ,
    ) ;

    $Template_description = str_replace($template_change, $template_content, $template_description);

?>
    <div>
        <div style=" background: #edf2f7;">
            <div class="content" style="background: #fff;margin: 5%;">
                    <?php $settings = App\Setting::find(1); ?>
                    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed(public_path().'/uploads/settings/'.$settings->logo) }}" class="c-logo" > </a>
            <div>

            <div style="margin:2% !important">
                <p> <?php echo html_entity_decode($Template_description) ?> </p>
            </div>

        </div>
    </div>
    

