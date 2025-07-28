<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}


</style>

<div class="row" id="signup-form">
 <?php if(!$settings->free_registration): ?>
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
              
              <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step col-xs-6"> 
                            <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                            <p><small>Customer Details</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p><small>Payment Details</small></p>
                        </div>

                    </div>
            </div>

          </div>

        </div><!-- .panel-heading -->
          
        <div class="panel-body">
                                                                  
          <fieldset>
               <div class="panel panel-primary setup-content" id="step-1">  
                    
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
                   <button class="btn btn-primary nextBtn pull-right" type="button">Next</button> 
                   
              </div>     
                  
                <div class="panel panel-primary setup-content" id="step-2"> 
                        <?php if(!$settings->free_registration): ?>

                          <div class="payment-errors alert alert-danger"></div>

                           <div class="form-group row">
                              <label class="col-md-4 control-label">Skip Subscription</label>

                              <div class="col-md-8">
                                  <input type="checkbox" id="skip" name="skip" class="" data-attr="C" value="0" onclick="$(this).val(this.checked ? 1 : 0)" >
                              </div>
                          </div>

                             <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" >Choose a Plan</label>
                                 <div class="col-md-8">
                                  <select class="form-control cc-subscrip-plan"  name="subscrip_plan" id="cc-subscrip-plan">
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
            </fieldset>
          </div>
            <div class="panel-footer clearfix">
          <div class="pull-left cc-icons terms">
              <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
          </div>
      
          <div class="pull-right sign-up-buttons">
            <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today</button>
              <span>Or</span>
            <a href="<?= URL::to('/login')?>" class="btn">Log In</a>
          </div>

  
      </div><!-- .panel-footer -->
      </div>
</form>

<?php endif; ?>
    
   <?php if($settings->free_registration): ?> 
  <form method="POST" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form" enctype="multipart/form-data" >
    
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
            <?php $username_error = $errors->first('username'); ?>
            <?php if (!empty($errors) && !empty($username_error)): ?>
                <div class="alert alert-danger"><?= $errors->first('username'); ?></div>
            <?php endif; ?>
            <!-- Text input-->
    <section>
        <div class="inner">
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
            <?php if (!empty($errors) && !empty($email_error)): ?>
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
            <?php if (!empty($errors) && !empty($password_error)): ?>
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
            <?php if (!empty($errors) && !empty($confirm_password_error)): ?>
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
              </section>
              <section>
        <div class="inner">
            <?php if(!$settings->free_registration): ?>

              <hr />

              <div class="payment-errors alert alert-danger form-content"></div>

              <!-- Credit Card Number -->
              <div class="form-group row">
                  <label class="col-md-4 control-label">Credit Card Number</label>

                  <div class="col-md-8">
                      <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" required="">
                  </div>
              </div>


              <!-- Expiration Date -->
              <div class="form-group row">
                  <label class="col-md-4 control-label" for="cc-expiration-month">Expiration Date</label>

                  <div class="col-md-3">
                      <select class="form-control cc-expiration-month" data-stripe="exp-month" id="cc-expiration-month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>        </div>
                  <div class="col-md-2">
                      <select class="form-control cc-expiration-year" data-stripe="exp-year" id="cc-expiration-year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option></select>        </div>
              </div>


              <!-- CVV Number -->
              <div class="form-group row">
                  <label class="col-md-4 control-label" for="cvv">CVV Number</label>

                  <div class="col-md-3">
                      <input id="cvv" type="text" placeholder="" class="form-control input-md cvc" data-stripe="cvc" required="">
                  </div>
              </div>

            <?php endif; ?>
                  </div>
              </section>
            <div class="panel-footer clearfix">
          <div class="pull-left cc-icons terms">
              <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
          </div>
      
          <div class="pull-right sign-up-buttons">
            <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today</button>
              <span>Or</span>
            <a href="<?= URL::to('/login')?>" class="btn">Log In</a>
          </div>

  
      </div><!-- .panel-footer -->
              
        </fieldset>
      </div><!-- .panel-body -->

      
    </div><!-- .panel -->

    <?php if($settings->demo_mode == 1 && !$settings->free_registration): ?>
      <div class="alert alert-info demo-info" role="alert">
        <p class="title">Demo Credit Card Info</p>
        <p><strong>Credit Card Number:</strong> <span>4242 4242 4242 4242</span></p>
        <p><strong>Expiration Date:</strong> <span>January 2020</span></p>
        <p><strong>CVV Code:</strong> <span>123</span></p>
      </div>
    <?php endif; ?>
  
  </form>
<?php endif; ?>
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
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-success').trigger('click');
});

</script>


<?php endif; ?>
