<?php include('header.php'); ?>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
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
        font-size: 50px!important;
        font-weight: 500;
    }
    select:invalid { color:grey!important; }
    select:valid { color:#dadada !important; }
    .plyr__video-wrapper::before{
        display: none;
    }
    .img-fluid {
  min-height: 0px!important;
}
    .form-control{
        line-height: 25px!important;
        font-size: 18px!important;
        
    }
    .sea{
        font-size: 14px;
    }
    .pls i{
        font-size: 25px;
        font-size: 25px;
    }
    
    .pls ul{
        list-style: none;
    }
      .close {
    /* float: right; */
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #FF0000	;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
    display: flex!important;
    justify-content: end!important;
}
     .modal-content{
          background-color: transparent;
      }
      .modal-dialog{
          max-width:900px!important;
      }
      .modal {
          top:40px;
      }
    .ply{
        width: 40px;
    }
       /* <!-- BREADCRUMBS  */

       .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
          content: none; 
      } 

      ol.breadcrumb {
            color: white;
            background-color: transparent !important  ;
            font-size: revert;
      }
</style>

<?php 
$series = $series_data ;
$media_url = URL::to('/play_series/') . '/' . $series->slug ;
// dd($series);
 ?>
     <div id="myImage" style="background:linear-gradient(90deg, rgba(0, 0, 0, 1.3)47%, rgba(0, 0, 0, 0.3))40%, url(<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>);background-position:right; background-repeat: no-repeat; background-size:contain;padding:0px 0px 20px; ">
<div class="container-fluid pt-5" >
	<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>

	<div class="row mt-3 align-items-center">
		<?php if( $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
		&& !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
	 	Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
		$settings->free_registration && Auth::user()->role != 'registered' && $series->ppv_status != 1) ):  ?>
		<div class="col-md-7">
			<div id="series_title">
				<div class="container">
					 <h3><?= $series->title ?></h3>
                  
					<!--<div class="col-md-6 p-0">
						<select class="form-control" id="season_id" name="season_id">
							<?php foreach($season_trailer as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div>-->
					<div class="row p-2 text-white">
                        <div class="col-md-7">
                        Season  <span class="sea"> 1 </span> - U/A English
                            <p  style="color:#fff!important;"><?php echo $series->details;?></p>
						<b><p  style="color:#fff;"><?php echo $series->description;?></p></b>
                            <div class="row p-0 mt-3 align-items-center">
                                <div class="col-md-2 text-center">  <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                          <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a>Play</div>
                              <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                <div class="col-md-1 pls  d-flex text-center mt-2">
                                    <div></div><ul>
                                    <li class="share" style="font-size:39px;">
<span><i class="ri-share-fill"></i></span>
    <div class="share-box">
       <div class="d-flex align-items-center"> 
       <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
              class="share-ico"><i class="ri-facebook-fill"></i></a>
          <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
              class="share-ico"><i class="ri-twitter-fill"></i></a>
          <a href="#"onclick="Copy();" class="share-ico"><i
                  class="ri-links-fill"></i></a>
       </div>
    </div>
</li>Share
                                    </ul></div>
                                          
                                          
                              
                              


                            </div>
                            <div class="modal fade modal-xl" id="videoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <button type="button" class="close videoModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-body">
        
            
         <video id="videoPlayer1" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src=""  type="video/mp4" >
            </video>



            <video  id="videos" class=""  
            poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>"
                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                            type="application/x-mpegURL">

                            <source id="m3u8urlsource"
                              type="application/x-mpegURL" 
                              src=""
                            >

                        </video>
        </div>
      </div>
    </div>
  </div>
       <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      
      <script>  const player = new Plyr('#videoPlayer1'); </script>
                        </div>
					</div>
				</div>
               
			</div>
		</div>
		<div class="col-md-6 text-center" id="theDiv">
			<!-- <img id="myImage" src="<? //URL::to('/') . '/public/uploads/images/' . $series->image; ?>" class="w-100"> -->
			<!--<img id="myImage" class="w-100" >-->
          <!--  <div id="series_container">

						 <video id="videoPlayer"  class="video-js vjs-default-skin" 
             poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" 
             controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' width="100%"
              style="width:100%;" type="video/mp4"  data-authenticated="<?= !Auth::guest() ?>">

							<p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 series</a></p>
						</video>
						</div>-->
		</div>
	</div>
</div>
</div>
<section id="tabs" class="project-tab">
	<div class="container-fluid p-0">

                        <!-- BREADCRUMBS -->

    <div class="row">
        <div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('series.tv-shows') ?>"><?= ucwords('Series') ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <?php foreach ($category_name as $key => $series_category_name) { ?>
                    <?php $category_name_length = count($category_name); ?>
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="<?= route('SeriesCategory', [$series_category_name->categories_slug]) ?>">
                            <?= ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                        </a>
                    </li>
                    <?php } ?>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title); ?> </a></li>
                </ol>
            </div>
        </div>
                  </div>

		<div class="row">
			<div class="col-md-12 mt-4">
				<nav class="nav-justified">
					<div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
                        <h4 class="ml-3">Episode</h4>
						<!--<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Episode</a>
						<!--<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Related</a>
						<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Detail</a>-->
					</div>
				</nav>
            </div>
<!-- $series->title -->
			<div class="container-fluid">
				<div class="favorites-contens">
          <div class="col-md-3 p-0 custom-select" style="border: none !important; height:100% !important;">
            <select class="form-control" id="season_id" name="season_id">
							<?php foreach($season as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
          </div>
            <ul class="category-page list-inline row p-3 mb-0">
              <?php 
                    foreach($season as $key => $seasons):  
                      foreach($seasons->episodes as $key => $episodes):
                        if($seasons->ppv_interval > $key):
							 ?>
                           
                  <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id;?>">
                      <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                           <div class="block-images position-relative episodes_div season_<?= $seasons->id;?>">
                                    <div class="img-box">
                                      <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="img-fluid w-100" >
                                   
                                         <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                                 <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$settings->ppv_price; ?></p> -->
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                               <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$seasons->ppv_price; ?></p> -->
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>

                               </div></div>
                                 
                               <div class="block-description" ></div>
                                    
                                 
                                         <h6><?= $episodes->title; ?></h6>
                                          <!--  <p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>-->
                                                                <!--<p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>-->
                                            <p class="text-white desc mb-0"><?= gmdate("H:i:s", $episodes->duration); ?></p>
                               
                                   
                                       <!-- <div class="hover-buttons">
                                            <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                           </a>
                                           <div>
                                           <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> 
                 
                                 </div>
                                        </div>-->
                                    
                                
                              </a>
                            </li>
                           
                           	<?php else : ?>
                             <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id;?>">
                              <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                 <div class="block-images position-relative" >
                                    <div class="img-box">
                                      <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class=" img-fluid w-100" >
                                   
                                   
                                           <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$seasons->ppv_price; ?></p>
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                     </div></div>
                                 
                                  <div class="block-description" ></div>
                                    
                                         <h6><?= $episodes->title; ?></h6>
										<!--<p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>-->
                                       <!-- <p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>-->
										<p class="text-white desc mb-0"><?= gmdate("H:i:s", $episodes->duration); ?></p>
                               

                                   
                                       <div class="hover-buttons">
                                                                       <!-- <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">

                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                           </a>-->
                                           <div>
                                           <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                 
                                 </div>
                                        </div>
                                    
                              </a>
                           </li>
                           <?php endif;	endforeach; 
						                      endforeach; ?>
                        </ul>
                     </div></div>
			<?php elseif( Auth::guest() && $series->access == "subscriber"):
						
					// }
						?>
				</div> 

          <!-- <div  style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $series->image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;"> -->
			<div class="col-sm-12">
					<div id="ppv">
				<h2 class="text-center" style="margin-top:80px;">Purchase to Watch the Series <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
				<div class="clear"></div>
				</div> 
				<!-- </div>  -->


				<div class="col-md-2 text-center text-white">
                <div class="col-md-4">
			<?php if ( $series->ppv_status == 1 && !Auth::guest() && Auth::User()->role !="admin") { ?>
			<button class="btn btn-primary" onclick="pay(<?php echo $settings->ppv_price; ?>)" >
			Purchase For <?php echo $currency->symbol.' '.$settings->ppv_price; ?></button>
			<?php } ?>
            <br>
			<!-- </div> -->

        <!-- </div> -->
				</div>
				</div>
                </div>
            </div>
        </div>
        </div>
		</section>
		
				<?php endif;?>
				<?php $payment_type = App\PaymentSetting::get(); ?>

<?php include('footer.blade.php');?>


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
   
   <input type="hidden" name="m3u8url_datasource" id="m3u8url_datasource" value="">


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

 $('.videoModalClose').click(function (){
  $('#videoPlayer1')[0].pause();
  $('#videos')[0].pause();

});

	var imageseason = '<?= $season_trailer ?>' ;
// console.log(imageseason)
$("#videoPlayer1").hide();
$("#videos").hide();

var obj = JSON.parse(imageseason);
console.log(obj)
var season_id = $('#season_id').val();
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
// alert($val.trailer_type)	
	console.log('season_'+$val.id)
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();
    $("#videoPlayer1").attr("src", $val.trailer);


    $('.videoModalClose').click(function (){
      $('#videoPlayer1')[0].pause();
    });

  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
   $("#m3u8urlsource").attr("src", $val.trailer);
  
  
   $('.videoModalClose').click(function (){
      $('#videos')[0].pause();
    });

  }
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
	// $("#videoPlayer1").attr("src", $val.trailer);
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();

    $("#videoPlayer1").attr("src", $val.trailer);
  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
    $("#m3u8urlsource").attr("src", $val.trailer);
  }

  $(".sea").empty();
  // alert($val.id);
  var id = $val.id;
	$(".sea").html(id);
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

<script>

var imageseason = '<?= $season_trailer ?>' ;
// console.log(imageseason)
$("#videoPlayer1").hide();
$("#videos").hide();

var obj = JSON.parse(imageseason);
console.log(obj)
var season_id = $('#season_id').val();

$.each(obj, function(i, $val)
{

  if( $val.trailer_type == 'm3u8_url'){

    // alert($('#videos').attr("src"));
    // alert(sourcevaltrailer);
  
  document.addEventListener("DOMContentLoaded", () => {

    // alert(sourcevaltrailer);
    var video = document.querySelector('#videos');
    // var sourcess = video.getElementsByTagName("source")[0].src;
    // alert(sourcess);
    var source = $val.trailer;
    // alert(source);

    const defaultOptions = {};
  
    if (!Hls.isSupported()) {
      video.src = source;
      var player = new Plyr(video, defaultOptions);
    } else {
      // For more Hls.js options, see https://github.com/dailymotion/hls.js
      const hls = new Hls();
      hls.loadSource(source);

      // From the m3u8 playlist, hls parses the manifest and returns
                  // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
              hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hls.levels.map((l) => l.height)
            availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
          defaultOptions.quality = {
            default: 0, //Default - AUTO
              options: availableQualities,
              forced: true,        
              onChange: (e) => updateQuality(e),
          }
          // Add Auto Label 
          defaultOptions.i18n = {
            qualityLabel: {
              0: 'Auto',
            },
          }

          hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
              var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
              if (hls.autoLevelEnabled) {
                span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
              } else {
                span.innerHTML = `AUTO`
              }
            })
      
              // Initialize new Plyr player with quality options
          var player = new Plyr(video, defaultOptions);
          });	

    hls.attachMedia(video);
        window.hls = hls;		 
      }

      function updateQuality(newQuality) {
        if (newQuality === 0) {
          window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
          window.hls.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
              console.log("Found quality match with " + newQuality);
              window.hls.currentLevel = levelIndex;
            }
          });
        }
      }
});


  }
});










$('#season_id').change(function(){
	var season_id = $('#season_id').val();
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	console.log('season_'+$val.id)
	$("#myImage").attr("src", $val.image);
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();
    $("#videoPlayer1").attr("src", $val.trailer);
  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
    $("#m3u8urlsource").attr("src", $val.trailer);
    
  if( $val.trailer_type == 'm3u8_url'){

// alert($('#videos').attr("src"));
// alert(sourcevaltrailer);

document.addEventListener("DOMContentLoaded", () => {

// alert(sourcevaltrailer);
var video = document.querySelector('#videos');
// var sourcess = video.getElementsByTagName("source")[0].src;
// alert(sourcess);
var source = $val.trailer;
// alert(source);

const defaultOptions = {};

if (!Hls.isSupported()) {
      video.src = source;
      var player = new Plyr(video, defaultOptions);
    } else {
      // For more Hls.js options, see https://github.com/dailymotion/hls.js
      const hls = new Hls();
      hls.loadSource(source);

      // From the m3u8 playlist, hls parses the manifest and returns
                  // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
              hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hls.levels.map((l) => l.height)
            availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
          defaultOptions.quality = {
            default: 0, //Default - AUTO
              options: availableQualities,
              forced: true,        
              onChange: (e) => updateQuality(e),
          }
          // Add Auto Label 
          defaultOptions.i18n = {
            qualityLabel: {
              0: 'Auto',
            },
          }

          hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
              var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
              if (hls.autoLevelEnabled) {
                span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
              } else {
                span.innerHTML = `AUTO`
              }
            })
      
              // Initialize new Plyr player with quality options
          var player = new Plyr(video, defaultOptions);
          });	

    hls.attachMedia(video);
        window.hls = hls;		 
      }

      function updateQuality(newQuality) {
        if (newQuality === 0) {
          window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
          window.hls.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
              console.log("Found quality match with " + newQuality);
              window.hls.currentLevel = levelIndex;
            }
          });
        }
      }
});


}
  }

  $(".sea").empty();
  // alert($val.id);
  var id = $val.id;
	$(".sea").html(id);
}
});

})

function Copy() {
            var media_path = '<?= $media_url ?>';;
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
                );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }
        
</script>