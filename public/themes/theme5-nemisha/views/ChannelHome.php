<!-- Header Start -->
<?php include('header.php'); 
   $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
   $order_settings_list = App\OrderHomeSetting::get();  
   $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
   
   ?>
<?php 
if(count($latest_video) > 0 || count($livetream) > 0 || count($latest_series) > 0 || count($audios) > 0){
      if(count($latest_video) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>

   <?php 
      if(count($livetream) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/live-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>


   <?php 
      if(count($latest_series) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-series.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>


   <?php 
      if(count($audios) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-audios.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }else{ ?>
      <div class="col-md-12 text-center mt-4">
             <img class="w-50" src="<?php echo  URL::to('/assets/img/sub.png')?>">
         </div>
<?php   } ?>
   <?php
   include(public_path('themes/default/views/partials/home/Trailer-script.php'));
   include(public_path('themes/default/views/partials/home/home_pop_up.php'));
   ?>
<?php include('footer.blade.php');?>