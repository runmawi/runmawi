<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
            <a class="navbar-brand" href="<?php echo URL::to('/');?>">
 <?php $settings = App\Setting::find(1); ?>
                    <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
            </a>
            <h2 class="name" style="color:#3d4852;margin-left: 35px;">Hello  {{ $name }} </h2> <br>

                    <p style="color:#718096;margin-left: 35px;"> You have Successfully Cancelled your subscription from Eliteclub.</p>
                    
                    <p style="color:#718096;margin-left: 35px;"> We hope to see you again soon.</p>
            <br>
           <?php echo MailSignature();?>
     </div>
</div>
