<?php include('header.php'); ?>
<style type="text/css">
	.nav-pills li a {color: #fff !important;}
    nav{
       margin: 0 auto;
        align-items: center;
    }
    .desc{
        font-size: 14px;
    }
    h1{
        font-size: 27px!important;
    }
     select:invalid { color:grey!important; }
    select:valid { color:#808080!important; }

</style>

<?php 
$series = $series_data ;
 ?>
<div class="container-fluid" >
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
						<select class="form-control" id="season_id" name="season_id">
							<?php foreach($season as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div><br><br>
					<div class="row p-2">
                        <div class="col-md-7">
						<p class="desc" style="color:#fff;"><?php echo $series->description;?></p></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5 text-center" id="theDiv">
			<!-- <img id="myImage" src="<? //URL::to('/') . '/public/uploads/images/' . $series->image; ?>" class="w-100"> -->
			<img id="myImage" class="w-100" >
		</div>
	</div>
</div>

<section id="tabs" class="project-tab">
	<div class="">
		<div class="row m-5">
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
						
						<?php 
						// if($series->ppv_status == null){						
						foreach($season as $key => $seasons):  
							foreach($seasons->episodes as $key => $episodes):
								// dd($seasons->ppv_interval);
								if($seasons->ppv_interval > $key):
							 ?>
								<a href="<?php echo URL::to('episode').'/'.$series->title.'/'.$episodes->slug;?>">
								<div class="row mt-4 episodes_div season_<?= $seasons->id;?>">
									<div class="col-md-3">
										<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="200" >
										
                                          <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                          <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$settings->ppv_price; ?></p> -->
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                          <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$seasons->ppv_price; ?></p> -->
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        
                                <!-- </div> -->
								</div>
									<div class="col-md-7 trending-info">
										<h1><?= $episodes->title; ?></h1>
										<p class="desc"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>
                                        <p class="date text-white"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>
										<p class="text-white"><?= gmdate("H:i:s", $episodes->duration); ?></p>
									</div>
									<div class="col-md-2">
									</div>
								</div>
							</a>
							<?php else : ?>
								
							<a href="<?php echo URL::to('episode').'/'.$series->title.'/'.$episodes->slug;?>">
								<div class="row mt-4 episodes_div season_<?= $seasons->id;?>">
									<div class="col-md-3">
                                        <div class="block-images position-relative">
                                    <div class="img-box">
										<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="250" >
										
                                          <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$seasons->ppv_price; ?></p>
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                            </div>
                                <!-- </div> -->
                                        </div></div>
									<div class="col-md-7 ">
										<h4><?= $episodes->title; ?></h4>
										<p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>
                                        <p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>
										<p class="text-white desc">Duration: <?= gmdate("H:i:s", $episodes->duration); ?></p>
									</div>
									<div class="col-md-2">
										
									</div>
								</div>
							</a>
							<?php endif;
							endforeach; 
						endforeach;
					// }
						?>
							</div>
							<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
								Related
							</div>
							<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
								Detail
							</div>
						</div>
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
			<?php if ( $series->ppv_status == 1 && Auth::User()->role !="admin") { ?>
			<button class="btn btn-primary" onclick="pay(<?php echo $settings->ppv_price; ?>)" >
			Purchase For <?php echo $currency->symbol.' '.$settings->ppv_price; ?></button>

			<?php } ?>
            <br>
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
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">        
		        <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
				</label>
                <?php }elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">			
				<?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
			</label>
                <?php }elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
				<br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
				<?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
			
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
 </div></div>

   <input type="hidden" name="publishable_key" id="publishable_key" value="<?= $publishable_key ?>">
   <input type="hidden" name="series_id" id="series_id" value="<?= $series->id ?>">

   <script src="https://checkout.stripe.com/checkout.js"></script>
	
<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to("/purchase-series") ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<script type="text/javascript">
var purchase_series = $('#purchase_url').val();
var publishable_key = $('#publishable_key').val();


// alert(livepayment);

$(document).ready(function () {  

	var imageseason = '<?= $season ?>' ;
// console.log(imageseason)


var obj = JSON.parse(imageseason);
// console.log(obj)
var season_id = $('#season_id').val();

$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	// console.log('season_'+$val.id)
	$("#myImage").attr("src", $val.image);
}
});

$('#season_id').change(function(){
	var season_id = $('#season_id').val();
// alert($('#season_id').val())	
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	console.log('season_'+$val.id)
	// $("#theDiv").append("<img id='theImg' src=$val.image/>");
	$("#myImage").attr("src", $val.image);
}
});

})



$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
});

function pay(amount) {
var series_id = $('#series_id').val();

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
description: 'PAY PeR VIEW',
amount: amount * 100
});
}
</script>

	<!-- <script type="text/javascript"> 

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
</script> -->

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
