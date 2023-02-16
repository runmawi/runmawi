<!-- Header Start -->
<?php include('header.php'); 
   $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
   $order_settings_list = App\OrderHomeSetting::get();  
   $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
   
   ?>

<section class="channel-header" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;height:450px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
         
</section>
 <div class="container-fluid">
       <div class="position-relative">
    <div class="channel-img">
      <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class=" " width="150" alt="user">
    </div>
              </div> </div>
<section class="mt-5 mb-5">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-2 col-lg-2">
                
              
                 <a href="#"onclick="Copy();" class="outline-share" ><i class="ri-links-fill"></i></a>
                <a href="" class="outline-danger">Follow</a>
             



            </div>
        </div>
    </div>
</section>
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