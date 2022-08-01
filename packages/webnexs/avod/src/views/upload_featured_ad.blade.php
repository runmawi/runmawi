@include('avod::ads_header')

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <style>
      .row.ages {
      padding: 2%;
      }
   .row.household_Income {
      padding: 2%;
      }
       label{
           height: 25px;
       }
   </style>
    
        <div id="main-admin-content">

           <div id="content-page" class="content-page">
               <div class="iq-card">
            <div class="container p-0">
               <div class="row">
               <div class="col-lg-12">
                  <div class="iq-card-body">
                     <h2 class="mb-4">Upload Advertisement</h2>
                     <div id="nestable" class="nested-list dd with-margins p-0">
                        <div class="panel panel-default ">
                        <div class="row">
                         <div class="col-md-12 mx-0 p-0">
                           <form id="msform" accept-charset="UTF-8" enctype="multipart/form-data">
                             <!-- progressbar -->
                             <ul id="progressbar">
                               <li class="active" id="account"><img class="" src="<?php echo  URL::to('/assets/img/icon/ads1.svg')?>">Ads Info</li>
                               <li id="personal"><img class="" src="<?php echo  URL::to('/assets/img/icon/ads2.svg')?>">Upload Ads</li>
                               <li id="payment"><img class="" src="<?php echo  URL::to('/assets/img/icon/ads3.svg')?>">Choose Region</li>
                               <li id="confirm"><img class="" src="<?php echo  URL::to('/assets/img/icon/ads4.svg')?>">Pay and Publish</li>
                            </ul> <!-- fieldsets -->
                            <fieldset>
                               <div class="form-card">
                                 <h2 class="fs-title mb-4">General Information</h2> 

                                 <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                     <label>Age:</label>
                                    <p class="error-message" style="color:red;font-size:10px;">This filed is required</p>

                                    <div class="row ages">
                                       <div class="col-sm-4"> <label for=""> 18-24 </label> </div>
                                       <div class="col-sm-4"> 
                                          <input type="checkbox" id="" class="age" name="age[]" value="18-24">
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
                                     <p class="error-message" style="color:red;font-size:10px;">This filed is required</p>

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
                                   <p class="error-message" style="color:red;font-size:10px;">This filed is required</p>

                                    <select class="js-example-basic-multiple" name="gender[]" multiple="multiple" id="gender">
                                       <option value="male">Male</option>
                                       <option value="female">Female</option>
                                       <option value="kids">Kids</option>
                                    </select>
                                 </div>

                               </div> </div> 
                               <input type="button" name="next" class="next action-button" value="Next Step" id="Next1" />
                            </fieldset>
                            <fieldset>
                               <div class="form-card">
                                 <h2 class="fs-title mb-4">Ads Details</h2> 
                                   <div class="row p-0">
                                       <div class="col-md-6">
                                    <div class="form-group">
                                     <label class="d-flex align-items-baseline">Ads Name: <p class="error-message" style="color:red;font-size:10px;">This filed is required</p></label>
                                   

                                     <input type="text" id="ads_name" name="ads_name" required class="form-control">
                                  </div>
                                  <div class="form-group">
                                     <label>Ads Category:</label>
                                     <select class="form-control" name="ads_category" id="ads_category">
                                        @foreach($ads_category as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                     </select>
                                  </div>

                                  <div class="form-group">
                                    <label > Ads Play:</label>
                                    <select class="form-control" name="ads_position" id="ads_position" onchange="return showprice(this);">
                                      <option value="pre" data-val="{{$settings->featured_pre_ad}}">Pre</option>
                                      <option value="mid" data-val="{{$settings->featured_mid_ad}}">Mid</option>
                                      <option value="post" data-val="{{$settings->featured_post_ad}}">Post</option>
                                   </select>
                               </div>
                                           
                                   </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label> Featured Ad Cost:</label>
                                       <input type="text" value="{{$settings->featured_pre_ad}}" class="form-control" id="price">
                                    </div>

                                    <div class="form-group">
                                       <label> Ads upload Type:</label>
                                       <p class="error-message" style="color: red;font-size:10px;">This filed is required</p>
                                       <select class="form-control ads_type" name="">
                                           <option value="null">select Ads Type </option>
                                           <option value="tag_url">Ad Tag Url </option>
                                           <option value="ads_video_upload">Ads Video Upload </option>
                                       </select>
                                   </div>

                                    <div class="form-group tag_url">
                                       <label class="d-flex align-items-baseline"> Ad Tag Url:</label>
                                       <input type="text" id="ads_path" name="ads_path"  class="form-control" />
                                   </div>

                                    <div class="form-group ads_video_upload">
                                       <label class="d-flex align-items-baseline"> Ads Video Upload:    <p class="error-messages" style="color:red;font-size:10px;">This filed is required</p></label>
                                       <input type="file" id="ads_video" name="ads_video" required class="form-control">
                                    </div>
                                 </div>

                              </div>
                              
                           </div>
                               
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                           <input type="button" name="next" class="next action-button" value="Next Step" id="Next2" />
                        
                        </fieldset>
                               
                        <fieldset>
                           <div class="form-card">
                               <h2 class="fs-title">Location Details</h2>


                             <div class="row">
                               <div class="col-sm-1"> <input type="radio" class="location-hide" id="" name="location" value="all_countries" /></div>
                               <div class="col-sm-4"> <label for="" class="">{{ ucwords('all countries & territories') }}</label></div>
                             </div>

                             <div class="row">
                               <div class="col-sm-1"> <input type="radio" class="location-hide" id="" name="location" value="India" /></div>
                               <div class="col-sm-1"> <label for="" class="">India</label></div>
                             </div>

                             <div class="row">
                               <div class="col-sm-1"> <input type="radio" class="location-show" id="" name="location" value="enter_location" /></div>
                               <div class="col-sm-4"> <label for="" class="">{{ ucwords('enter the location') }}</label></div>
                             </div>

                               <div class="col-md-6 location_input">
                                   <div class="form-group">
                                       <input type="text" id="locations" name="locations"  class="form-control" placeholder="Enter the Location"/>
                                   </div>
                               </div>
                           </div>
                           <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                           <input type="button" name="next" class="next action-button" value="Next Step" id="Next2" />
                       </fieldset>

                         <!--Schedule Ads Details fieldsets -->
                        <fieldset>
                           <div class="col-md-6">
                               <label>Set your weekly hours</label>
                           </div>
                               <div class="row align-items-center">
                                   <div class="col-sm-2 ">
                                       <input type="checkbox" id="Monday" class="date" name="date[Monday]" value="{{ $Monday }}" @if(!empty($Monday_time['0'])) checked @endif/></div>
                                   <div class="col-sm-4">
                                       <label for="">Monday</label></div>
                                   <div class="col-sm-4">
                                       <span id="" class="Monday_add ml-4">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                   </div>

                                   @forelse ($Monday_time as $Monday_times)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center">
                                                               <input type="time" name="Monday_Start_time[]" class="form-control" value={{  $Monday_times->start_time }} />
                                                               -</div>
                                                           <div class="col-md-4 p-0">
                                                               <input type="time" name="Monday_end_time[]" class="form-control" id="" value={{  $Monday_times->end_time }} />
                                                           </div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty

                                   @endforelse

                                   <table class="table col-md-12" id="Monday_add"> </table>
                              

                               <div class="row align-items-center">
                                   <div class="col-sm-2 ">
                                       <input type="checkbox" id="Tuesday" class="date" name="date[Tuesday]" value="{{ $Tuesday }}" @if(!empty($Tuesday_time['0'])) checked @endif /></div>
                                   <div class="col-sm-4">
                                       <label for=""> Tuesday </label></div>
                                   <div class="col-sm-4">
                                       <span id="" class="Tuesday_add ml-4">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                   

                                   @forelse ($Tuesday_time as $tuesday_tym)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="tuesday_start_time[]" class="form-control" value="{{ $tuesday_tym->start_time }}" />-</div>
                                                           <div class="col-md-4 p-0"><input type="time" name="Tuesday_end_time[]" class="form-control" id="" value="{{ $tuesday_tym->end_time }}" /></div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty
                                       
                                   @endforelse

                                   <table class="table col-md-12" id="Tuesday_add"> </table>
                       
                               </div>
               
                               <div class="row align-items-center">
                                   <div class="col-sm-2 ">
                                       <input type="checkbox" class="date" id="Wednesday" name="date[Wednesday]" value="{{ $Wednesday }}" @if(!empty($Wednesday_time['0'])) checked @endif /></div>
                                   <div class="col-sm-4">
                                       <label for=""> Wednesday </label></div>
                                   <div class="col-sm-4">
                                       <span  class="wednesday_add ml-4">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                 

                                   @forelse ($Wednesday_time as $tym)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="wednesday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                           <div class="col-md-4 p-0"><input type="time" name="wednesday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td></td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty
                                   @endforelse

                                   <table class="table col-md-12" id="wednesday_add"> </table>
                               </div>
               
                               <div class="row align-items-center">
                                   <div class="col-sm-2">
                                       <input type="checkbox" class="date" id="thrusday" name="date[thrusday]" value="{{ $Thrusday }}"  @if(!empty($Thursday_time['0'])) checked @endif /></div>
                                   <div class="col-sm-4">
                                       <label for=""> Thrusday </label></div>
                                   <div class="col-sm-4">
                                       <span id="add" class="thrusday_add">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                   

                                   @forelse ($Thursday_time as $tym)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="thursday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                           <div class="col-md-4 p-0"><input type="time" name="thursday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td></td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty
                                   @endforelse

                                   <table class="table col-md-12" id="thrusday_add"> </table>
                               </div>
               
                               <div class="row align-items-center">
                                   <div class="col-sm-2">
                                       <input type="checkbox" class="date" id="friday" name="date[friday]" value="{{ $Friday }}"  @if(!empty($Friday_time['0'])) checked @endif /></div>
                                   <div class="col-sm-4">
                                       <label for="">Friday </label></div>
                                   <div class="col-sm-4">
                                       <span id="add" class="friday_add ml-4">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                 

                                   @forelse ($Friday_time as $tym)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center">
                                                               <input type="time" name="friday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-
                                                           </div>
                                                           <div class="col-md-4 p-0">
                                                               <input type="time" name="friday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" />
                                                           </div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td></td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty
                                   @endforelse

                                   <table class="table" id="friday_add"> </table>
                               </div>
               
                               <div class="row align-items-center">
                                   <div class="col-sm-2">
                                       <input type="checkbox" class="date" id="saturday" name="date[saturday]" value="{{ $Saturday }}" @if(!empty($Saturday_time['0'])) checked @endif /></div>
                                   <div class="col-sm-4">
                                       <label for="">Saturday </label></div>
                                   <div class="col-sm-4">
                                       <span id="add" class="saturday_add">
                                           <i class="fa-solid fa-plus"></i>
                                       </span></div>
                                  

                                   @forelse ($Saturday_time as $tym)
                                       <table class="table col-md-12" id=""> 
                                           <tr>
                                               <td>
                                                   <div class="container">
                                                       <div class="row">
                                                           <div class="col-md-4 p-0 d-flex align-items-center"><input type="time" name="saturday_start_time[]" class="form-control" value= "{{ $tym->start_time }}" />-</div>
                                                           <div class="col-md-4 p-0"><input type="time" name="saturday_end_time[]" class="form-control" id=""  value= "{{ $tym->end_time }}" /></div>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td></td>
                                               <td><i class="fa-solid fa-trash-can remove-tr"> </i></td>
                                           </tr>
                                       </table>
                                   @empty
                                   @endforelse

                                   <table class="table" id="saturday_add"> </table>
                               </div>
               
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                               <input type="submit" class="btn btn-primary action-button" id="submit-update-cat" value="Save" />
                       </fieldset>


                   <fieldset>
                      <div class="form-card">
                        <h2 class="fs-title">Payment</h2>
                        <div class="col-md-6">
                           <div class="d-flex align-items-baseline">
                              <input type="radio" name="gateway_payment" value="razorpay" style="width: 15px;">
                              <h5 class="ml-4">Razorpay Payment Gateway</h5>
                           </div>
                           <div class="action_block razorpay">
                              
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="d-flex align-items-baseline">
                           <input type="radio" name="gateway_payment" value="stripe" style="width: 15px;">
                           <h5 class="ml-4">Stripe Payment Gateway</h5>

                        </div>
                        <div class="action_block stripe">
                          <div class="mt-3 pl-5">
                            <div class="form-group row">
                              <div class="col-md-8"> 
                                 <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                              </div>
                           </div>
                           <!-- Stripe Elements Placeholder -->
                           <div id="card-element" ></div><br>
                           
                             <input type="hidden" id="stripe_key" value="{{ env('STRIPE_KEY') }}">
                             <input type="hidden" id="rz_key" value="{{ env('RAZORPAY_KEY') }}">
                          </div>

                       </div>
                    </div>
                 </div>
                 <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                 <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
           </form>
                 <div class="sign-up-buttons pay-button-stripe">
                   <a type="button" id="card-button" class="btn btn-primary pay"  data-secret="{{ $intent->client_secret }}">Pay Now</a></div>
                   <div class="sign-up-buttons rzpaybtn">
                     <a href="javascript:void(0)" class="btn btn-sm btn-primary pay buy_now">Pay Now</a> 
                  </div>
              </fieldset>
              
        </div>
     </div>
                    
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
      
      
   
    <input type="hidden" id="base_url" value="<?php echo URL::to('/').'/advertiser';?>">

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

<script>
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

</script>
  <script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
       var base_url = $('#base_url').val();
       
       var stripe_key = $("#stripe_key").val();
       const stripe = Stripe(stripe_key);
        const elements = stripe.elements();
      var style = {
        base: {
         color: '#303238',
         fontSize: '16px',
         fontFamily: '"Open Sans", sans-serif',
         fontSmoothing: 'antialiased',
         '::placeholder': {
           color: '#ccc',
         },
        },
        CardNumberField : {
           background: '#f1f1f1', 
           padding: '10px',
           borderRadius: '4px', 
           transform: 'none',
        },
        invalid: {
         color: '#e5424d',
         ':focus': {
           color: '#303238',
         },
        },
      };
   
      var elementClasses = {
         class : 'CardNumberField',
         empty: 'empty',
         invalid: 'invalid',
        };

   
      // Create an instance of the card Element.
      var cardElement = elements.create('card', {style: style, classes: elementClasses });


        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
       
        const clientSecret = cardButton.dataset.secret;
        cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );
        if (error) {
             swal("Your Payment is failed !");
            // Display "error.message" to the user...
        } else {
               
                var py_id = setupIntent.payment_method;
                var ads_name = $("#ads_name").val();
                var ads_category = $("#ads_category").find(":selected").val();
                var ads_position = $("#ads_position").val();
                var ads_path = $("#ads_path").val();
                var age = $('input[type=checkbox]:checked').map(function(_, el) {
                     return $(el).val();
               }).get();
                var location = $("#location").val();
                var household_income = $('input[name="household_income"]:checked').val();
                var gender = $("#gender").val();
                var price =  $('#ads_position').find(":selected").attr('data-val');
               
                   $.post(base_url+'/buyfeaturedad_stripe', {
                     py_id:py_id,ads_path:ads_path, ads_category:ads_category,ads_name:ads_name,ads_position:ads_position,ads_position:ads_position,price:price,age:age,location:location,household_income:household_income,gender:gender, _token: '<?= csrf_token(); ?>' 
                   }, 
                function(data){
                  if(data == 'success'){
                    swal("You have done  Payment !");
                    setTimeout(function() {
                    window.location.replace(base_url+'/featured_ads');
                        
                  }, 2000);
                 }else{
                  swal('Error');
                  window.location.replace(base_url);
                 }
               });

            // The card has been verified successfully...
        }
    });



$('input[type=radio][name=gateway_payment]').change(function() {
    if (this.value == 'stripe') {
        $(".action_block.razorpay").css('display','none');
        $(".rzpaybtn").css('display','none');
        $(".action_block.stripe").css('display','inline');
        $(".pay-button-stripe").css('display','inline');
    }
    else if (this.value == 'razorpay') {
        $(".action_block.stripe").css('display','none');
        $(".pay-button-stripe").css('display','none');
        $(".action_block.razorpay").css('display','inline-flex');
        $(".rzpaybtn").css('display','inline-flex');
    }
});


function showprice(sel) {
   var opt = sel.options[sel.selectedIndex];
  var val = opt.dataset.val;
  $("#price").val("");
  $("#price").val(val);
}


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

});
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    
     var base_url = $('#base_url').val();
$('body').on('click', '.buy_now', function(e){
   
   var ads_name = $("#ads_name").val();
   var ads_category = $("#ads_category").find(":selected").val();
   var ads_position = $("#ads_position").val();
   var ads_path = $("#ads_path").val();
   var age = $('input[type=checkbox]:checked').map(function(_, el) {
        return $(el).val();
    }).get();
   var location = $("#location").val();
   var household_income = $('input[name="household_income"]:checked').val();
   var gender = $("#gender").val();
   var price =  $('#ads_position').find(":selected").attr('data-val');
   var rz_key = $("#rz_key").val();
var options = {
"key": rz_key,
"amount": price*100,
"name": "Flicknexs",
"description": "Featured Ad Purchase",
"image": "<?php echo URL::to('/').'/public/uploads/settings/logo (1).png';?>",
"handler": function (response){
$.ajax({
url: base_url+'/buyrz_ad',
type: 'post',
dataType: 'json',
data: {
      razorpay_payment_id: response.razorpay_payment_id ,
       ads_path:ads_path,
        ads_category:ads_category,
        ads_name:ads_name,
        ads_position:ads_position,
        ads_position:ads_position,
        price:price,
        age:age,
        location:location,
        household_income:household_income,
        gender:gender,
       _token: '<?= csrf_token(); ?>'
}, 
success: function (msg) {
window.location.href = base_url+'/featured_ads';
}
});
},
"theme": {
"color": "#528FF0"
}
};
var rzp1 = new Razorpay(options);
rzp1.open();
e.preventDefault();
});
</script>

<script>
    var i = 0;

    $(".Monday_add").click(function(){
            ++i;
            $('#Monday').prop('checked', true);
            $("#Monday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="Monday_Start_time[]"   class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="Monday_end_time[]" class="form-control" id=""/> </div> </div> </div> </td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
        });

    $(".Tuesday_add").click(function(){
            ++i;
            $('#Tuesday').prop('checked', true);
            $("#Tuesday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="tuesday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="Tuesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
        });

   $(".wednesday_add").click(function(){
       ++i;
       $('#Wednesday').prop('checked', true);
       $("#wednesday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="wednesday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="wednesday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
   });

   $(".thrusday_add").click(function(){
       ++i;
       $('#thrusday').prop('checked', true);
       $("#thrusday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="thursday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="thursday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
   });

   $(".friday_add").click(function(){
       ++i;
       $('#friday').prop('checked', true);
       $("#friday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="friday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="friday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
   });

   $(".saturday_add").click(function(){
       ++i;
       $('#saturday').prop('checked', true);
       $("#saturday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="saturday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="saturday_end_time[]"  class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
   });

   $(".sunday_add").click(function(){
       ++i;
       $('#sunday').prop('checked', true);
       $("#sunday_add").append('<tr> <td> <div class="container"> <div class="row"> <div class="col-md-4 p-0 d-flex align-items-center"> <input type="time" name="sunday_start_time[]" class="form-control" />-</div> <div class="col-md-4 p-0"> <input type="time" name="sunday_end_time[]" class="form-control" id=""/> </div> </div> </div> <td>  <td> <i class="fa-solid fa-trash-can remove-tr"> </i> </td>   </tr>');
   });

   $(document).on('click', '.remove-tr', function(){

        if( $(this).closest('tr').is('tr:only-child') ) {

            // $('#sunday').prop('checked', false);

            $(this).closest('tr').remove();
        }
        else {
            $(this).closest('tr').remove();
        }

   }); 
 
</script>

<script>

$(document).ready(function(){
     $(".location-show").click(function(){
         $('.location_input').show();
      });
 
   $(".location-hide").click(function(){
            $('.location_input').hide();
   });
 
 });

var input = document.getElementById('locations');
var autocomplete = new google.maps.places.Autocomplete(input);

 google.maps.event.addListener(autocomplete, 'place_changed',   function () {

   var place = autocomplete.getPlace();
  
   alert(lat + ", " + long);

});

</script>

<script>

   window.onload=function(){
      document.getElementById("Next1").disabled = true;
     document.getElementById("Next2").disabled = true;
     document.getElementsByClassName('error-message')[0].style.display = 'none';
     document.getElementsByClassName('error-message')[1].style.display = 'none';
     document.getElementsByClassName('error-message')[2].style.display = 'none';
     document.getElementsByClassName('error-message')[3].style.display = 'none';
     document.getElementsByClassName('error-message')[4].style.display = 'none';
     $('.location_input').hide();
     $('.ads_video_upload').hide();
     $('.tag_url').hide();
   };


   $('.form-card').on('keyup keypress blur change click mouseover', function(event) {

      var household_income_val = $("input[type='radio'][name='household_income']:checked").val();
      var gender_val = $("#gender").val();

      var age_validation = new Array();
      $('.age:checked').each(function() {
        age_validation.push($(this).val());
      });

      var ads_name_val = $("#ads_name").val();
      var ads_path_val = $("#ads_path").val();
      var ads_video_val = $("#ads_video").val();
      var Ads_type   = $(".ads_type").val();

      if(age_validation != ""  && household_income_val != null  && gender_val != null ){
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

      if(ads_name_val != '' && Ads_type != 'null' ){

         document.getElementsByClassName("error-message")[3].style.display = "none";
         document.getElementsByClassName('error-message')[4].style.display = 'none';

         document.getElementById("Next2").disabled = false;
      }else{

         document.getElementsByClassName("error-message")[3].style.display = "block";
         document.getElementsByClassName('error-message')[4].style.display = 'block';

         document.getElementById("Next2").disabled = true;
      }

     
   });

      $(".ads_type").change(function(){
         var ads_type = $('.ads_type').val();
        
         if(ads_type == 'tag_url' ){
            $('.tag_url').show();
            $('.ads_video_upload').hide();
           
         }else if(ads_type == 'ads_video_upload'){
            $('.tag_url').hide();
            $('.ads_video_upload').show();
         }
         else if(ads_type == 'null' ){
            $('.tag_url').hide();
            $('.ads_video_upload').hide();
         }
      });

   </script>
</body>
</html>