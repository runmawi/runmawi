<?php include('header.php'); ?>
<style type="text/css">
	.nav-pills li a {color: #fff !important;}
    nav{
       margin: 0 auto;
        align-items: center;
    }
</style>

<?php //dd($season) ?>
<div class="container" >
	<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>

	<div class="row mt-3">
		<?php if( $ppv_exits > 0 || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
		&& !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
	 	Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
		$settings->free_registration && Auth::user()->role != 'registered' && $series->ppv_status != 1) ): ?>
		<div class="col-md-7 p-0">
			<div id="series_title">
				<div class="container">
					<span class="label"></span> <h1><?= $series->title ?></h1><br><br>
					<div class="col-md-6 p-0">
						<select class="form-control">
							<?php foreach($season as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div><br><br>
					<div class="row p-2">
						<p class="desc" style="color:#fff;"><?php echo $series->description;?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 text-center">
			<img src="<?= URL::to('/') . '/public/uploads/images/' . $series->image; ?>" class="w-100">
		</div>
	</div>
</div>

<section id="tabs" class="project-tab">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-4">
				<nav class="nav-justified">
					<div class="nav nav-tabs nav-fill " id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Episode</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Related</a>
						<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Detail</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<!-- $series->title -->
						
						<?php foreach($season as $key => $seasons):  
							foreach($seasons->episodes as $key => $episodes): ?>
								<a href="<?php echo URL::to('episode').'/'.$series->title.'/'.$episodes->title;?>">
								<div class="row mt-4 episodes_div season_<?= $seasons->id;?>">
									<div class="col-md-3">
										<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="200" >
									</div>
									<div class="col-md-7">
										<h2><?= $episodes->title; ?></h2>
										<p class="desc"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>
                                        <p class="date"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>
										<p><?= gmdate("H:i:s", $episodes->duration); ?></p>
									</div>
									<div class="col-md-2">
										
									</div>
								</div>
							</a>
							<?php endforeach; 
						endforeach; ?>
							</div>
							<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
								Related
							</div>
							<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
								Detail
							</div>
						</div>
						

		<?php else: ?>
			<div style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $series->image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
					<div id="ppv">
				<h2>Purchase to Watch the Series <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
				<div class="clear"></div>
				</div>

				<div class="col-md-2 text-center text-white">
                <div class="col-md-4">
			<?php if ( $series->ppv_status == 1 && Auth::User()->role =="admin") { ?>
			<button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-episode">
			<?php echo __('Purchase for').' '.$currency->symbol.' '.$settings->ppv_price;?> </button>
			<?php } ?>
            <br>
			</div>

        </div>
				</div>
				</div>
			</div>
		</section>
		
				<?php endif;?>
				<?php $payment_type = App\PaymentSetting::get(); ?>



				          <!-- Modal -->
   <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
         </div>
         <div class="modal-body">
             <div class="row">
                 <div class="col-sm-2" style="width:52%;">
                   <span id="paypal-button"></span> 
                 </div>
                <?php $payment_type = App\PaymentSetting::get(); ?>
                 
                 <div class="col-sm-4">
                 <label for="method"><h3>Payment Method</h3></label>
                <label class="radio-inline">
				<?php  foreach($payment_type as $payment){
                          if($payment->stripe_status == 1 || $payment->paypal_status == 1){ 
                          if($payment->live_mode == 1 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">Stripe</label>
                <?php }elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">PayPal</label>
                <?php }elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">Stripe</label><br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">PayPal</label>
						<?php  } }else{
                            echo "Please Turn on Payment Mode to Purchase";
                            break;
                         }
                         }?>

                 </div>
             </div>                    
         </div>
         <div class="modal-footer">
         <a onclick="pay(<?php echo $settings->ppv_price ;?>)">
					<button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
                   </a>
           <button type="button" class="btn btn-primary"  data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <input type="hidden" name="publishable_key" id="publishable_key" value="<?= $publishable_key ?>">
   <input type="hidden" name="series_id" id="series_id" value="<?= $series->id ?>">

   <script src="https://checkout.stripe.com/checkout.js"></script>
	
	<script type="text/javascript"> 

	// videojs('Player').videoJsResolutionSwitcher(); 
	$(document).ready(function () {  
		 $.ajaxSetup({
		   headers: {
			 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   }
		 });
	   });

function pay(amount) {
var publishable_key = $('#publishable_key').val();

var series_id = $('#series_id').val();
// alert(series_id);
// alert(publishable_key);

var handler = StripeCheckout.configure({

key: publishable_key,
locale: 'auto',
token: function (token) {
// You can access the token ID with `token.id`.
// Get the token ID to your server-side code for use.
console.log('Token Created!!');
console.log(token);
$('#token_response').html(JSON.stringify(token));

$.ajax({
url: '<?php echo URL::to("purchase-series") ;?>',
method: 'post',
data: {"_token": "<?= csrf_token(); ?>",tokenId:token.id, amount: amount , series_id: series_id },
success: (response) => {
alert("You have done  Payment !");
setTimeout(function() {
 location.reload();
}, 2000);

},
error: (error) => {
swal('error');

}
})
}
});


handler.open({
name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
description: 'Rent a Episode',
amount: amount * 100
});
}
</script>

<script type="text/javascript">
	var first = $('select').val();
	$(".episodes_div").hide();
	$("."+first).show();

	$('select').on('change', function() {
		$(".episodes_div").hide();
		$("."+this.value).show();
	});
</script>
<?php include('footer.blade.php'); ?>