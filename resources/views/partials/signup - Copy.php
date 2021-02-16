<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<style>




/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}

</style>

<div class="row" id="signup-form">

  <form method="POST" id="regForm" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form" enctype="multipart/form-data" >
  <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
      
      <div class="panel panel-default registration">
        
        <div class="panel-heading">
          
          <div class="row">

              <?php if(!$settings->free_registration): ?>
                <h1 class="panel-title"><?= ThemeHelper::getThemeSetting(@$theme_settings->signup_message, 'Signup to Gain access to all content on the site for $7 a month.') ?></h1>
              <?php else: ?>
                <h1 class="panel-title">Enter your info below to signup for an account.</h1>
              <?php endif; ?>

          </div>

        </div><!-- .panel-heading -->
          
        <div class="panel-body">
                                                                  
          <fieldset>
                  <div class="tab">
                    
                          <?php $username_error = $errors->first('username'); ?>
                        <?php if (isset($errors) && !empty($errors) && !empty($username_error)): ?>
                            <div class="alert alert-danger"><?= $errors->first('username'); ?></div>
                        <?php endif; ?>
                        <!-- Text input-->
                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="username">Username</label>

                            <div class="col-md-8">
                              <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" />
                            </div>
                        </div>


                        <div class="form-group row">
                                <label class="col-md-4 control-label" for="username">Profile Image</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control" id="profile_image" name="profile_image" value="<?= old('avatar'); ?>" />
                                    </div>
                        </div>

                           <?php $email_error = $errors->first('email'); ?>
                        <?php if (isset($errors) &&  !empty($errors) && !empty($email_error)): ?>
                            <div class="alert alert-danger"><?= $errors->first('email'); ?></div>
                        <?php endif; ?>
                        <!-- Text input-->
                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="email">Email Address</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
                            </div>
                        </div>

                        <?php $password_error = $errors->first('password'); ?>
                        <?php if (isset($errors) &&  !empty($errors) && !empty($password_error)): ?>
                            <div class="alert alert-danger"><?= $errors->first('password'); ?></div>
                        <?php endif; ?>
                        <!-- Text input-->
                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="password">Desired Password</label>

                            <div class="col-md-8">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>


                          <?php $confirm_password_error = $errors->first('password_confirmation'); ?>
                <?php if (isset($errors) && !empty($errors) && !empty($confirm_password_error)): ?>
                    <div class="alert alert-danger"><?= $errors->first('password_confirmation'); ?></div>
                <?php endif; ?>
                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="password_confirmation">Confirm Password</label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
                      
                  </div>

                  <div class="tab">
                        <?php if(!$settings->free_registration): ?>

                          <div class="payment-errors alert alert-danger"></div>

                           <div class="form-group row">
                              <label class="col-md-4 control-label">Skip Subscription</label>

                              <div class="col-md-8">
                                  <input type="checkbox" id="skip" name="skip" class="" data-attr="C" value="0" onclick="$(this).val(this.checked ? 1 : 0)" >
                              </div>
                          </div>

                             <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" for="cc-expiration-month">Choose a Plan</label>
                                 <div class="col-md-8">
                                  <select class="form-control cc-subscrip-plan" data-stripe="exp-month" name="subscrip_plan" id="cc-subscrip-plan">
                                      <?php foreach ($plans as $plan) { ?>
                                           <option value="<?php echo $plan->plans_name;?>"> <?php echo $plan->plans_name;?> - <?php echo $plan->price;?> USD</option>
                                      <?php }?>
                                     </select>        
                                 </div>
                            </div>

                          <!-- Credit Card Number -->
                          <div class="form-group row C selectt">
                              <label class="col-md-4 control-label">Credit Card Number</label>

                              <div class="col-md-8">
                                  <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" required="">
                              </div>
                          </div> 



                          <!-- Expiration Date -->
                          <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" for="cc-expiration-month">Expiration Date</label>

                              <div class="col-md-3">
                                  <select class="form-control cc-expiration-month" data-stripe="exp-month" id="cc-expiration-month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>        </div>
                              <div class="col-md-2">
                                  <select class="form-control cc-expiration-year" data-stripe="exp-year" id="cc-expiration-year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option></select>        </div>
                          </div>


                          <!-- CVV Number -->
                          <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" for="cvv">CVV Number</label>

                              <div class="col-md-3">
                                  <input id="cvv" type="text" placeholder="" class="form-control input-md cvc" data-stripe="cvc" required="">
                              </div>
                          </div>

                        <?php endif; ?>
                      
                  </div>
                  <div style="overflow:auto;">
                    <div style="float:right;">
                      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                      <button type="button" id="nextBtn" name="create-account" class="btn btn-primary" onclick="nextPrev(1)">Next</button>
                    </div>
                  </div>
                  <!-- Circles which indicates the steps of the form: -->
                  <div style="text-align:center;margin-top:40px;">
                    <span class="step active"></span>
                    <span class="step"></span>
                  </div>
            </fieldset>
          </div>
      </div>
</form>



</div><!-- #signup-form -->


<?php if(!$settings->free_registration): ?>
  
  <script type="text/javascript" src="<?= THEME_URL ?>/assets/js/jquery.payment.js"></script>
  <script type="text/javascript">

    // This identifies your website in the createToken call below
    <?php if($payment_settings->live_mode): ?>
      Stripe.setPublishableKey('<?= $payment_settings->live_publishable_key; ?>');
    <?php else: ?>
      Stripe.setPublishableKey('<?= $payment_settings->test_publishable_key; ?>');
    <?php endif; ?>

    var stripeResponseHandler = function(status, response) {
        var $form = $('#payment-form');
        var skip_option = $('#skip').val();
   if ( skip_option == 0 ) {
        if (response.error) {
          // Show the errors on the form
          $form.find('.payment-errors').text(response.error.message);
          $form.find('button').prop('disabled', false);
          $('.payment-errors').fadeIn();
        } else {
          // token contains id, last4, and card type
          var token = response.id;
          // Insert the token into the form so it gets submitted to the server
          $form.append($('<input type="hidden" name="stripeToken" />').val(token));
          // and re-submit
          $form.get(0).submit();
        } 
   }
      };

      jQuery(function($) {
        $('#payment-form').submit(function(e) {
  var skip_option = $('#skip').val();
   if ( skip_option == 0 ) {
          $('.payment-errors').fadeOut();

          var $form = $(this);

          // Disable the submit button to prevent repeated clicks
          $form.find('button').prop('disabled', true);

          Stripe.card.createToken($form, stripeResponseHandler);

          // Prevent the form from submitting with the default action
          return false;
   }
        });
        $('#cc-number').payment('formatCardNumber');

      });

  </script>

    <script type="text/javascript"> 
            $(document).ready(function() { 
                $('input[type="checkbox"]').click(function() { 
                    var inputValue = $(this).attr("data-attr"); 
                    $("." + inputValue).toggle(); 
                }); 
            }); 
        </script> 


    <script> 
        $(document).ready(function() { 
            $("#skip").on('click',function(){
            
                var clk_value = $(this).val();
                if (clk_value == 0)
                  {
                        $('#cc-number').removeAttr("disabled");
                        $('#cc-expiration-month').removeAttr("disabled");
                        $('#cc-subscrip-plan').removeAttr("disabled");
                        $('#cc-expiration-year').removeAttr("disabled");
                        $('#cc-expiration-year').removeAttr("disabled");
                        $('#cvv').removeAttr("disabled");
                 }
                
                if (clk_value == 1)
                  {
                        $('#cc-number').prop("disabled", true);
                        $('#cc-expiration-month').prop("disabled", true);
                        $('#cc-subscrip-plan').prop("disabled", true);
                        $('#cc-expiration-year').prop("disabled", true);
                        $('#cc-expiration-year').prop("disabled", true);
                        $('#cvv').prop("disabled", true);
                 }
              
                
            }); 
        }); 
    </script> 
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == x.length) {
    document.getElementById("nextBtn").innerHTML = "Sign Up Today";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>


<?php endif; ?>
