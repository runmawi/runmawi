@extends('layouts.app')
@include('/header')
@section('content')
<script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory">
</script>
<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay payment-loader">
        
         
            <div class="panel-heading">
              <div class="row nomargin text-center">
                  
                    <h1 class="panel-title"><?php echo __('Pay Now');?></h1>
              </div>
            </div>
                    <div class="panel-body">
				<div class="form-group row">
					<input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ $plan_id }}">
					
				</div>
				<!-- Stripe Elements Placeholder -->
                     <div class="col-sm-10 col-sm-offset-1">
                            <div id="paypal-button-container"></div>
                    </div>
			</div>
               
			<div class="payment-option">
				<div class="invoice"><h1>Invoice</h1></div>
					 <svg class="svg-inline--fa fa-file fa-w-12" aria-hidden="true" data-prefix="far" data-icon="file" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg><!-- <i class="far fa-file"></i> -->
					 <h4 class="billing-head detail_name" id="detail_name"><?=$plan_name;?></h4>
				 <p class="grey-border"></p>
				 <div class="">
					 <p class="pay-prtext">Grab this plan for your best Movies to Watch.</p>
				 </div>
				 <div class="table-responsive">
					 <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plan_price;?></td>
                             </tr>
						 </tbody>
					 </table>
				 </div>
			</div>
        </div>
        
         
    </div>
</div>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>


<script>
    var base_url = $('#base_url').val();
    
       $('#paypal-button-container').html("");
        var pid = $("#plan_name").val();
               $('#paypal-button-container').html("");
               $('.hide-box').css("display","block");
               $('.hide-box').css("  transition-delay","2s");

      paypal.Buttons({
          style: {
              shape: 'rect',
              color: 'gold',
              layout: 'vertical',
              label: 'subscribe'
          },
          createSubscription: function(data, actions) {
            return actions.subscription.create({
              'plan_id': pid
            });
          },
          onApprove: function(data, actions) {
              var subId = data.subscriptionID;
               $.post(base_url+'/becomePaypal', {
                 subId:subId , _token: '<?= csrf_token(); ?>' 
               }, 
                function(data){
                    setTimeout(function() {
                    //location.reload();
                    window.location.replace(base_url+'/myprofile');
                        
                  }, 2000);
               });              
              
          }
      }).render('#paypal-button-container');
    
</script>

 @include('footer')


@endsection
