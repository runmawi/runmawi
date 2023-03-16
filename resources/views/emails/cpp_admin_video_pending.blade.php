<?php 
            // Partner Content Video is Pending & waiting for Admin Approval 
            
    $template = App\EmailTemplate::where('id','=',43)->first(); 
    $template_description = $template->description ;

    $template_change = array( 
        "{Name}", 
        "{ContentName}",
        "{video_title}",
        "{Admin video approval link}",
        "{Website Name}", 
    );

    $template_content= array( 
        $username,
        $Content_Name,
        $video_title,
        $Admin_video_approval_link,
        $website_name ,
    ) ;

    $Template_description = str_replace($template_change, $template_content, $template_description);

?>
    <div>
        <div style=" background: #edf2f7;">
            <div class="content" style="background: #fff;margin: 5%;">
                    <?php $settings = App\Setting::first(); ?>
                    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed(public_path().'/uploads/settings/'.$settings->logo) }}" class="c-logo" > </a>
            <div>

            <div style="margin:2% !important">
                <p> <?php echo html_entity_decode($Template_description) ?> </p>
            </div>

        </div>
    </div>