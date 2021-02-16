@include('header')

<style>
    .lablecolor{
        color: #000;
    }
    #update_profile_form label {
    color: #756969;
    } .list-group-item {
        color: #000;
    }
 

</style>

<div class="container">
    <div class="row justify-content-center">	
        	<div class="col-md-10 col-sm-offset-1">
			<div class="referral">
                    <h1 class="title"  style="color:#fff;"><i class="fa fa-comments"></i> Tell friends about Eliteclub <a href="<?php echo URL::to('/my-refferals');?>"><span class="pull-right" style="background: #c3ab06;padding: 10px;border-radius: 30px;color: #fff;font-size: 16px;">My referrals</span> </a> 
                </h1>
				    <p class="grey-border"></p>
               
		        	<div class="clear"></div>
					
                
                	<div class="referral-body">
						<div class="row">
							<div class="col-md-12">
								<div class=""><h2 class="sub-title">Share this link so your friends can join the conversation around all your favorite TV shows and movies.</h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									
								</div>
								
							</div>
							
						</div>
                        
                   
                </div>
               
                </div>
        </div>
    </div>
</div>
<script>
function myFunction() {
    //alert();
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  //alert("Copied the text: " + copyText.value);
}
</script>

@extends('footer')