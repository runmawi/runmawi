@include('avod::ads_header')
    
        <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="iq-card">
               <div id="admin-container">
                  <div class="container mt-4">
                     <div class="">
                        <h3>Billing details</h3>
                     </div>
                     <div class="row justify-content-center mt-3">
                        <div class="col-sm-3 p-0 dk">
                           <div class="d-flex align-items-baseline">
                              <i class="fa fa-file-text-o" aria-hidden="true" style="font-size:18px;color:black;"></i>
                              <p class="pl-3">Billing details</p></div>
                              <hr>
                              <div class="">
                                 <p> {{$plan->plan_name}} <br> <span class="text-center" style="font-size:15px;">$ {{$plan->plan_amount}}</span></p>
                              </div>
                              <div class="text-right mr-4">
                                 <p>View Details ></p>
                              </div>
                           </div>
                           <div class="col-sm-8">
                              <div class="d-flex align-items-baseline">
                                 <i class="fa fa-file-text-o" aria-hidden="true" style="font-size:25px;color:black;"></i>
                                 <p class="pl-3">Billing details</p></div>
                                 <hr>
                                 <table class="table table-bordered" style="width:60%;">
                                    <thead style="background: #F2F5FA;border: 0.2px solid rgba(0, 0, 0, 0.5);">
                                       <tr>
                                          <th class="text-left" colspan="2">{{$plan->plan_name}}</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td scope="row">Purchased Date</td>
                                          <td>{{date('d M Y H:i:s',strtotime($planhistory->created_at))}}</td>
                                       </tr>
                                       <tr>
                                          <td scope="row">No. of Ads</td>
                                          <td>{{$plan->no_of_ads}}</td>
                                       </tr>
                                       <tr>
                                          <td scope="row">Total Amount</td>
                                          <td>$ {{$plan->plan_amount}}</td>
                                       </tr>
                                       <tr>
                                          <td scope="row">Paid Amount</td>
                                          <td>$ {{$plan->plan_amount}}</td>
                                       </tr>
                                       <tr>
                                          <td scope="row">Payment Mode</td>
                                          <td>{{ucfirst($planhistory->payment_mode)}}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        
        <!-- Footer -->
        <footer class="iq-footer">
          <div class="container-fluid">
             <div class="row">
                <div class="col-lg-6">
                   <ul class="list-inline mb-0">
                      <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                      <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                   </ul>
                </div>
                <div class="col-lg-6 text-right">
                   Copyright 2021 <a href="<?php echo URL::to('home') ?>">Flicknexs</a> All Rights Reserved.
                </div>
             </div>
          </div>
       </footer>
      </div>
      
      
    </div>

  <!-- Imported styles on this page -->
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/popper.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.dataTables.min.js';?>"></script>
  
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
   <!-- Appear JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.appear.js';?>"></script>
   <!-- Countdown JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/countdown.min.js';?>"></script>
   <!-- Select2 JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/select2.min.js';?>"></script>
   <!-- Counterup JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/waypoints.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.counterup.min.js';?>"></script>
   <!-- Wow JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/wow.min.js';?>"></script>
   <!-- Slick JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/slick.min.js';?>"></script>
   <!-- Owl Carousel JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/owl.carousel.min.js';?>"></script>
   <!-- Magnific Popup JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.magnific-popup.min.js';?>"></script>
   <!-- Smooth Scrollbar JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/smooth-scrollbar.js';?>"></script>
   <!-- apex Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/apexcharts.js';?>"></script>
   <!-- Chart Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/chart-custom.js';?>"></script>
   <!-- Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/custom.js';?>"></script>
  <!-- End Notifications -->

  @yield('javascript')
 <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
<?php if(session('success')){ ?>
    toastr.success("<?php echo session('success'); ?>");
<?php }else if(session('error')){  ?>
    toastr.error("<?php echo session('error'); ?>");
<?php }else if(session('warning')){  ?>
    toastr.warning("<?php echo session('warning'); ?>");
<?php }else if(session('info')){  ?>
    toastr.info("<?php echo session('info'); ?>");

<?php } ?>
</script>
</body>
</html>