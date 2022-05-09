@include('avod::ads_header')

<style>
   .row.ages {
      padding: 2%;
   }
   .row.household_Income {
      padding: 2%;
   }

</style>
    
        <div id="main-admin-content">

           <div id="content-page" class="content-page">
               <div class="iq-card">
            <div class="container-fluid">
               <div class="row">
               <div class="col-lg-12">
                  <div class="iq-card-body">
                     <h2 class="text-center">Upload Advertisement</h2>
                     <div id="nestable" class="nested-list dd with-margins">
                       
                     <!-- MultiStep Form -->
        
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" accept-charset="UTF-8" action="{{ URL::to('advertiser/store_ads') }}" method="post" enctype="multipart/form-data">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>General</strong></li>
                                <li id="personal"><strong>Ads</strong></li>
                                <li id="payment"><strong>Location</strong></li>
                               
                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">General Information</h2> 
                                    <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                   <label>Age:</label>

                                   <p class="error-message" style="color:red">This filed is required</p>

                                   <div class="row ages">
                                    <div class="col-sm-4"> <label for=""> 18-24 </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" id="" class="age" name="age[]" value="18-24">
                                    </div>
                                   <div>
                                   </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4"> <label for=""> 25-34 </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="25-34">
                                    </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4"> <label for=""> 35-44 </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="35-44">
                                    </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4"> <label for=""> 45-54 </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="45-54">
                                    </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4"> <label for="">55-64 </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="55-64">
                                    </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4">    <label for="">65+ </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="65+">
                                    </div>
                                 </div>

                                 <div class="row ages">
                                    <div class="col-sm-4"> <label for="">unknown </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="checkbox" class="age" id="" name="age[]" value="unknown">
                                    </div>
                                 </div>
                                </div>
                              
                                <div class="form-group col-md-5">
                                 <label>Household Income:</label>

                                 <p class="error-message" style="color:red">This filed is required</p>

                                   <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" class="10">Top 10%</label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="1-10">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" >11 - 20% </label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id=""  name="household_income" value="11-20">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" >21 - 30%</label> </div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="21-30">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" class="10">31 - 40%</label></div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="31-40">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" class="10">41 - 50%</label></div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="41-50">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" class="10">Lower 50%</label></div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="lower_50">
                                    </div>
                                 </div>

                                 <div class="row household_Income">
                                    <div class="col-sm-4"> <label for="household_income_label" class="10">Unknown</label></div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" class="household_income" id="" name="household_income" value="unknown">
                                    </div>
                                 </div>
                              </div> 

                              <div class="form-group col-md-3">
                                 <label>Gender:</label>

                                 <p class="error-message" style="color:red">This filed is required</p>

                                  <select class="js-example-basic-multiple" name="gender[]" multiple="multiple" id="gender" >
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="kids">Kids</option>
                                 </select>
                              </div>

                                </div> </div> <input type="button" name="next" class="next action-button" value="Next Step" id="Next1" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Ads Details</h2> 
                                    <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Ads Name:</label>

                                   <p class="error-message" style="color:red">This filed is required</p>

                                    <input type="text" id="ads_name" name="ads_name" required class="form-control">
                                </div>
                                 <div class="form-group">
                                   <label>Ads Category:</label>
                                   <select class="form-control" name="ads_category">
                                      @foreach($ads_category as $key => $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                   </select>
                                </div>

                                <div class="form-group">
                                 <label> Ads Play:</label>
                                 <select class="form-control" name="ads_position">
                                      <option value="pre">Pre</option>
                                      <option value="mid">Mid</option>
                                      <option value="post">Post</option>
                                   </select>
                              </div>
                              <div class="form-group">
                                 <label> Ad Tag Url:</label>
                                 <p class="error-message" style="color:red">This filed is required</p>
                                 <input type="text" id="ads_path" name="ads_path" required class="form-control">
                              </div>

                              <div class="form-group">
                                 <label> Ads Video Upload:</label>
                                 <p class="error-message" style="color:red">This filed is required</p>
                                 <input type="file" id="ads_video" name="ads_video" required class="form-control">
                              </div>

                                </div> </div> 
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                 <input type="button" name="next" class="next action-button" value="Next Step" id="Next2" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Location Details</h2>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                   <label>Location:</label>
                                    <input type="text" id="location" name="location" required class="form-control">
                                </div>
                                </div>
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input  type="submit" class="btn btn-primary action-button" id="submit-update-cat" value="Save" />
                            </fieldset>
                           
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />


                        </form>
                    </div>
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
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js';?>"></script>
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
<script  type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBROO3Md6_fZD5_fd1u8VTlRxd4VdJnAWU&libraries=places&sensor=false"></script>

<script>

   var input = document.getElementById('location');
   var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed',   function () {

      var place = autocomplete.getPlace();
     
      alert(lat + ", " + long);

  });

  $('.js-example-basic-multiple').select2();

</script>

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
$(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

$(".next").click(function(){

current_fs = $(this).parent();
next_fs = $(this).parent().next();

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 600
});
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});

$('.radio-group .radio').click(function(){
$(this).parent().find('.radio').removeClass('selected');
$(this).addClass('selected');
});

$(".submit").click(function(){
return false;
})

// validation

window.onload=function(){
     document.getElementById("Next1").disabled = true;
     document.getElementById("Next2").disabled = true;
     document.getElementsByClassName('error-message')[0].style.display = 'none';
     document.getElementsByClassName('error-message')[1].style.display = 'none';
     document.getElementsByClassName('error-message')[2].style.display = 'none';
     document.getElementsByClassName('error-message')[3].style.display = 'none';
     document.getElementsByClassName('error-message')[4].style.display = 'none';
     document.getElementsByClassName('error-message')[5].style.display = 'none';

};

      $('.form-card').on('keyup keypress blur change click mouseover', function(event) {

      var age_validation = $(".age").prop("checked");
      var household_income_val = $(".household_income").prop("checked");
      var gender_val = $("#gender").val();
      var ads_name_val = $("#ads_name").val();
      var ads_path_val = $("#ads_path").val();
      var ads_video_val = $("#ads_video").val();
      
      if(age_validation == true && household_income_val == true  && gender_val != null ){
         document.getElementsByClassName("error-message")[0].style.display = "none";
         document.getElementsByClassName('error-message')[1].style.display = 'none';
         document.getElementsByClassName('error-message')[2].style.display = 'none';

         document.getElementById("Next1").disabled = false;
      }else{
         document.getElementsByClassName('error-message')[0].style.display = 'block';
         document.getElementsByClassName('error-message')[1].style.display = 'block';
         document.getElementsByClassName('error-message')[2].style.display = 'block';

         document.getElementById("Next1").disabled = true;
      }

      if(ads_name_val != '' && ads_path_val != '' && ads_video_val != '' ){

         document.getElementsByClassName("error-message")[3].style.display = "none";
         document.getElementsByClassName('error-message')[4].style.display = 'none';
         document.getElementsByClassName('error-message')[5].style.display = 'none';

         document.getElementById("Next2").disabled = false;
      }else{

         document.getElementsByClassName("error-message")[3].style.display = "block";
         document.getElementsByClassName('error-message')[4].style.display = 'block';
         document.getElementsByClassName('error-message')[5].style.display = 'block';

         document.getElementById("Next2").disabled = true;
      }
   });

});


</script>
  
</body>
</html>