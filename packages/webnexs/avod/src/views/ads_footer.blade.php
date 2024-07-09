<?php
    use Carbon\Carbon;
?>

<footer class="iq-footer">
   <div class="container-fluid p-5">
       <div class="row">
           <div class="col-lg-6">
               <ul class="list-inline mb-0">
                   <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                   <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
               </ul>
           </div>
           <div class="col-lg-6 text-right">
            <?php echo $settings->website_name . ' ' . '<i class="ri-copyright-line"></i>' . ' ' . Carbon::now()->year ; ?> <?php echo (__('All Rights Reserved')); ?> 

           
           </div>
       </div>
   </div>
</footer>
