<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php $settings = App\Setting::find(1); ?>
        <?php $template = App\EmailTemplate::where('id','=',4)->get();  ?>
        <?php $user = App\User::where('email','=',$email)->get();  ?>

        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>
        <!-- <h2><?php //echo $template[0]->template_type;?></h2> -->

        <div>
       <p>          Dear <?php echo $user[0]->username;?>,       </p>
       <p>          We have received a request to reset your password on <?php echo $user[0]->username;?>.       </p>
       <p>          Click on the below link or copy/paste the link in your browser address bar to reset your password.       </p>
       <p>          to reset your password: <?php echo URL::to('/').'/password/reset/'.$token ;?>       </p>
       <p>          Kindly ignore this email if you do not wish to reset the password or if you have not made the request. If you have any questions or if you need further assistance, please contact us at support@webnexs.com       </p>
       <p>     Thanks,       </p>
       <p>     Team <?php echo $settings->website_name;?>       </p>

           <!-- <a href="<?php// echo URL::to('/').'/password/reset/'.$token ;?>">Click here</a> to reset your password: <?php //echo URL::to('/').'/password/reset/'.$token ;?> -->
           <br>
        </div>
    </body>
       <p>     <?php echo MailSignature();?>       </p>

    </html>