<?php

 $template = App\EmailTemplate::where('id','=',24)->first(); 
 $template_description = $template->description ;

 $username = $name ;
 $subscription_type = $subscription_type;
 $website_name = GetWebsiteName();
 $role = $user_role;
 $current_payment = "$".$plan_price ;
 $next_date = "on ".$next_billing;
 $next_payment = $next_date.', you will be automatically charged '.$current_payment.' for a '.$billing_interval;
 $plan_type =  $billing_interval."(".$current_payment .")"  ;

 $template_change = array( 
     "{username}", 
     "{subscription type}", 
     "{website name}" ,
     "{role}" ,
     "{plan_type}" ,
     "{current_payment}" ,
     "{next_payment}" ,
 );

 $template_content= array( 
     $username,
     $subscription_type ,
     $website_name ,
     $role,
     $plan_type,
     $current_payment,
     $next_payment,
 ) ;

 $Template_description = str_replace($template_change, $template_content, $template_description);

 ?>


<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;border: 34px solid #edf2f7;">
            <a class="navbar-brand" href="<?php echo URL::to('/');?>">
                <?php $settings = App\Setting::find(1); ?>
            <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
        </a>

        <div style="margin:2% !important">
            <p> <?php echo html_entity_decode($Template_description) ?> </p>
        </div>

</div>