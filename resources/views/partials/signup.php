
<style>

#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}
    .pwd input{
        border: 1px solid!important;
    }
#ck-button label {
    float:left;
    width:4.0em;
}
    .links a{
        color:#fff!important;
    }

#ck-button label span {
    text-align:center;
   
    display:block;
  
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}

#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    .sign-user_card input{
background-color: #30312f !important;
    outline: 1px solid !important;
    color: gray;
    border: none;
    height: 60px;
        
        }
    #signup-form input{
       
    }
    
</style>

<div class="row" id="signup-form">
     <?php if(!$settings->free_registration) { ?>
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay">
        <form method="POST" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>"  id="payment-form" enctype="multipart/form-data">
    
    <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
      
      <div class="registration">
          <div class="stepper">
            <div class="panel-heading">

              <div class="row nomargin text-center">

                  <?php if(!$settings->free_registration): ?>
                    <h1 class="panel-title"><?= ThemeHelper::getThemeSetting(@$theme_settings->signup_message, 'Signup to Gain access to all content on the site!') ?></h1>
                  <?php else: ?>
                    <h1 class="panel-title">Enter your Info below to signup for an account.</h1>
                  <?php endif; ?>
                  
              </div>

            </div><!-- .panel-heading -->
              
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a class="persistant-disabled" href="#stepper-step-1" data-toggle="tab" aria-controls="stepper-step-1" role="tab" title="Step 1">
                  <span class="round-tab">Enter your Details</span>
                </a>
              </li>
              <li role="presentation" class="disabled">
                <a class="persistant-disabled" href="#stepper-step-2" data-toggle="tab" aria-controls="stepper-step-2" role="tab" title="Step 2">
                  <span class="round-tab">Choose Your Plan</span>
                </a>
              </li>
            </ul>


        <div class="panel-body">
                                                                  
          <fieldset>
            <div class="tab-content">
            <div class="tab-pane fade in active" role="tabpanel" id="stepper-step-1">
            <?php $username_error = $errors->first('username'); ?>
            <?php if (!empty($errors) && !empty($username_error)): ?>
                <div class="alert alert-danger"><?= $errors->first('username'); ?></div>
            <?php endif; ?>
            <!-- Text input-->
            <div class="form-group row">
                <label class="col-md-4 control-label" for="username">Username</label>

                <div class="col-md-8">
                  <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" required="" />
                </div>
            </div>

                 <div class="form-group row">
                    <label class="col-md-4 control-label" for="username">Profile Image</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="profile_image" name="profile_image" value="<?= old('avatar'); ?>"  />
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
                    <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>" required="">
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
                    <input type="password" class="form-control" id="password" name="password" required="" />
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
                    
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required="" />
                </div>
                
            </div>
                
               <div class="form-group row">
                   <div class="col-md-4">
                        <input type="checkbox"  id="terms" name="terms"  class="terms" value="0" required="" />
                   </div>
                    
                    <div class="col-md-8">
                       
                        <label class="control-label" for="password_confirmation">  Yes , <a data-toggle="modal" data-target="#myModal" style="text-decoration:none;"> I Agree to Terms and  Conditions and privacy policy </a> </label>
                    </div>


                </div>
                
                
             <ul class="list-inline pull-right">
                <li>
                  <a class="btn btn-primary next-step">Next</a>
                </li>
              </ul>
          </div>
            <?php if(!$settings->free_registration): ?>
               <div class="tab-pane fade" role="tabpanel" id="stepper-step-2">
              <div class="payment-errors alert alert-danger"></div>
                   
       
                   
                     <div class="form-group row">
                              <label class="col-md-4 control-label">Skip Subscription</label>

                                  <div id="ck-button">
                                       <label>
                                          <input type="checkbox" id="skip" name="skip" data-attr="C" value="0" onclick="$(this).val(this.checked ? 1 : 0)"  ><span>Skip</span>
                                       </label>
                                    </div>
<!--                                  <input type="checkbox" id="skip" name="skip" class="" data-attr="C" value="0" onclick="$(this).val(this.checked ? 1 : 0)" >-->
                             
                          </div>

                             <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" >Choose a Plan</label>
                                 <div class="col-md-8">
                                  <select class="form-control cc-subscrip-plan"  name="subscrip_plan" id="cc-subscrip-plan">
                                      <?php foreach ($plans as $plan) { ?>
                                           <option value="<?php echo $plan->plans_name;?>"> <?php echo $plan->plans_name;?> - <?php echo $plan->price;?> INR</option>
                                      <?php }?>
                                     </select>        
                                 </div>
                            </div>

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
                      <select class="form-control cc-expiration-month" data-stripe="exp-month" id="cc-expiration-month"><option value="1">01-January</option><option value="2">02-February</option><option value="3">03-March</option><option value="4">04-April</option><option value="5">05-May</option><option value="6">06-June</option><option value="7">07-July</option><option value="8">08-August</option><option value="9">09-September</option><option value="10">10-October</option><option value="11">11-November</option><option value="12">12-December</option></select>        </div>
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
              <div class="clearfix">
          <div class="pull-left cc-icons terms">
              <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
          </div>
      
          <div class="pull-right sign-up-buttons">
            <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today </button>
              <span> Or </span>
            <a href="/login" class="btn">Log In</a>
          </div>

  
      </div><!-- .panel-footer -->
            <?php endif; ?>
          </div>
              </div>
        </fieldset>
      </div><!-- .panel-body -->

      
    </div>
    </div><!-- .panel -->

  </form>
    </div>
    </div>
<?php } else { ?>
        <div class="overlay">
            <form method="POST" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form" enctype="multipart/form-data">
    
    <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
      
      <div class="panel panel-default registration">
          
       
        <div class="panel-heading">
          
          <div class="row text-center">

              <?php if(!$settings->free_registration): ?>
                <h1 class="panel-title"><?= ThemeHelper::getThemeSetting(@$theme_settings->signup_message, 'Signup to Gain access to all content on the site for $7 a month.') ?></h1>
              <?php else: ?>
                <h1 class="panel-title">Enter your Info below to signup for an Account!</h1>
              <?php endif; ?>

          </div>

        </div><!-- .panel-heading -->

        <div class="panel-body">
                                                                  
          <fieldset>
            <div class="tab-content">
            <div class="tab-pane fade in active" role="tabpanel" id="stepper-step-1">
            <?php $username_error = $errors->first('username'); ?>
            <?php if (!empty($errors) && !empty($username_error)): ?>
                <div class="alert alert-danger"><?= $errors->first('username'); ?></div>
            <?php endif; ?>
            <!-- Text input-->
            <div class="form-group row">
                <label class="col-md-4 control-label" for="username">Username</label>

                <div class="col-md-8">
                  <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" style="background-color:gray!important;"/>
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
                    <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>" >
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
            
            <div class="form-group row">
                                  <div class="col-md-4"></div>
                    
                    <div class="col-md-8">
                        <input type="checkbox"  id="terms" name="terms"  class="terms" value="0" required="" />
                        <label class="control-label" for="password_confirmation">  Yes , <a data-toggle="modal" data-target="#myModal" style="text-decoration:none;"> I Agree to Terms and  Conditions and privacy policy </a> </label>
                    </div>
                

            </div>
                
                    <div class="pull-right sign-up-buttons">
                      <button class="btn btn-primary btn-login" type="submit" name="create-account">Sign Up Today</button>
                      <span>Or</span>
                       <a href="/login" class="btn btn-login">Log In</a>
                     </div>
            </div>
                
              </div>
            </fieldset>
          </div>
          

        </div>
                </form>
        </div>
<?php } ?>

</div><!-- #signup-form -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color:#000;">Terms and Conditions</h4>
      </div>
      <div class="modal-body">
        <p style="color:#000;"><?php echo $terms ;?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
 $(document).ready(function() { 
$('.terms').on('change', function(){
   // alert();
   this.value = this.checked ? 1 : 0;
   // alert(this.value);
}).change();
 });
</script>

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
    /*jslint browser: true*/
/*global $, jQuery, alert*/
(function($) {
  'use strict';

  $(function() {

    $(document).ready(function() {
      function triggerClick(elem) {
        $(elem).click();
      }
      var $progressWizard = $('.stepper'),
        $tab_active,
        $tab_prev,
        $tab_next,
        $btn_prev = $progressWizard.find('.prev-step'),
        $btn_next = $progressWizard.find('.next-step'),
        $tab_toggle = $progressWizard.find('[data-toggle="tab"]'),
        $tooltips = $progressWizard.find('[data-toggle="tab"][title]');

      // To do:
      // Disable User select drop-down after first step.
      // Add support for payment type switching.

      //Initialize tooltips
      $tooltips.tooltip();

      //Wizard
      $tab_toggle.on('show.bs.tab', function(e) {
        var $target = $(e.target);

        if (!$target.parent().hasClass('active, disabled')) {
          $target.parent().prev().addClass('completed');
        }
        if ($target.parent().hasClass('disabled')) {
          return false;
        }
      });

      $btn_next.on('click', function() {
        $tab_active = $progressWizard.find('.active');

        $tab_active.next().removeClass('disabled');

        $tab_next = $tab_active.next().find('a[data-toggle="tab"]');
        triggerClick($tab_next);

      });
      $btn_prev.click(function() {
        $tab_active = $progressWizard.find('.active');
        $tab_prev = $tab_active.prev().find('a[data-toggle="tab"]');
        triggerClick($tab_prev);
      });
    });
  });

}(jQuery, this));
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

    
<?php endif; ?>
