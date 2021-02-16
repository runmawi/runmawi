<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;">
            <a class="navbar-brand" href="<?php echo URL::to('/');?>">
 <?php $settings = App\Setting::find(1); ?>
                    <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
            </a>
            <h2 class="name" style="color:#3d4852;">Hello  {{ $name }} </h2> <br>

                    <p style="color:#718096;"> You have Successfully Cancelled your subscription from Eliteclub.</p>
                    <p style="color:#718096;"> Your plan details,</p>
                    <p style="color:#718096;"> Plan Name - {{ $plan_name }}</p>
                    <p style="color:#718096;"> Plan Subscribed Date - {{ $start_date }}</p>
                    <p style="color:#718096;"> Plan Cancelled Data  - {{ $ends_at }}</p>
                    <p style="color:#718096;"> We hope to see you again soon.</p>
                    <br>
            <br>
           <?php echo MailSignature();?>
     </div>
</div>
