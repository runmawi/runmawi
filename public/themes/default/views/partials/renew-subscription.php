<h2 class="form-signin-heading"><i class="fa fa-credit-card"></i> <?= __('Renew Your Subscription') ?></h2>

<div id="signup-form" style="margin-top:0px;">

<p><?= __('Sorry, it looks like your account is no longer active') ?>...</p>

<form method="POST" action="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?>/<?= $user->username ?>/update_cc" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form">
    
    <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
      
      <div class="panel panel-default registration">
        
        <div class="panel-heading">
          
          <div class="row">
                  
              <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px;"><?= __('Go ahead and re-activate your account below') ?>:</h1>

              <div class="cc-icons col-lg-5 col-md-4">
                  <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
              </div>

          </div>

        </div><!-- .panel-heading -->

        <div class="panel-body">
            
             <div class="form-group row C selectt">
                              <label class="col-md-4 control-label" ><?= __('Choose a Plan') ?></label>
                                 <div class="col-md-8">
                                  <select class="form-control cc-subscrip-plan"  name="subscrip_plan" id="cc-subscrip-plan">
                                      <?php foreach ($plans as $plan) { ?>
                                           <option value="<?php echo $plan->plans_name;?>"> <?php echo $plan->plans_name;?> - <?php echo $plan->price;?><?= __('INR') ?> </option>
                                      <?php }?>
                                     </select>        
                                 </div>
            </div>

            <!-- Credit Card Number -->
            <div class="form-group row">
                <label class="col-md-4 control-label"><?= __('Credit Card Number') ?></label>

                <div class="col-md-8">
                    <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" required="">
                </div>
            </div>


            <!-- Expiration Date -->
            <div class="form-group row">
                <label class="col-md-4 control-label" for="cc-expiration-month"><?= __('Expiration Date') ?></label>

                <div class="col-md-3">
                    <select class="form-control cc-expiration-month" data-stripe="exp-month" id="cc-expiration-month"><option value="1"><?= __('January') ?></option><option value="2"><?= __('February') ?></option><option value="3"><?= __('March') ?></option><option value="4"><?= __('April') ?></option><option value="5"><?= __('May') ?></option><option value="6"><?= __('June') ?></option><option value="7"><?= __('July') ?></option><option value="8"><?= __('August') ?></option><option value="9"><?= __('September') ?></option><option value="10"><?= __('October') ?></option><option value="11"><?= __('November') ?></option><option value="12"><?= __('December') ?></option></select>        </div>
                <div class="col-md-2">
                    <select class="form-control cc-expiration-year" data-stripe="exp-year" id="cc-expiration-year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option></select>        </div>
            </div>


            <!-- CVV Number -->
            <div class="form-group row">
                <label class="col-md-4 control-label" for="cvv"><?= __('CVV Number') ?></label>

                <div class="col-md-3">
                    <input id="cvv" type="text" placeholder="" class="form-control input-md cvc" data-stripe="cvc" required="">
                </div>
            </div>

            
        </fieldset>
      </div><!-- .panel-body -->

      <div class="panel-footer clearfix">
        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>
      
          <div class="pull-right sign-up-buttons">
          	<a href="<?= ($settings->enable_https) ? secure_url('logout') : URL::to('logout') ?>" class="btn"><?= __('Logout') ?></a>
            <button class="btn btn-primary" type="submit" name="create-account"><?= __('Renew My Subscription') ?></button>
            
          </div>

          <div class="payment-errors col-md-8 text-danger" style="display:none"></div>
  
      </div><!-- .panel-footer -->

    </div><!-- .panel -->
  
  </form>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
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
        var $form = $(this);

        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);

        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
      });
      $('#cc-number').payment('formatCardNumber');

    });

</script>
