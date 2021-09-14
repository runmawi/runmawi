@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
    .p1{
        font-size: 12px;
    }
</style>
@section('css')
	<style type="text/css">
	.make-switch{
		z-index:2;
	}
        
      
	</style>

@stop

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i> Site Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/settings/save_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Site Name</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<p class="p1">Enter Your Website Name Below:</p> 
						<input type="text" class="form-control" name="website_name" id="website_name" placeholder="Site Title" value="@if(!empty($settings->website_name)){{ $settings->website_name }}@endif" />
					</div> 
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Site Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<p class="p1">Enter Your Website Description Below:</p> 
						<input type="text" class="form-control" name="website_description" id="website_description" placeholder="Site Description" value="@if(!empty($settings->website_description)){{ $settings->website_description }}@endif" />
					</div> 
				</div>
			</div>

		</div>
<!--        <div class="row">-->

		<div class="panel panel-primary col-md-6 mt-3 p-0" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Logo</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				@if(!empty($settings->logo))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->logo }}" style="max-height:100px" />
				@endif
				<p class="p1">Upload Your Site Logo:</p> 
				<input type="file" multiple="true" class="form-control" name="logo" id="logo" />
				
			</div> 
		</div>

		<div class="panel panel-primary mt-3 col-md-6 p-0" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Favicon</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				@if(!empty($settings->favicon))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->favicon }}" style="max-height:20px" />
				@endif
				<p class="p1">Upload Your Site Favicon:</p> 
				<input type="file" multiple="true" class="form-control" name="favicon" id="favicon" />
				
			</div> 
		</div>
       <!-- </div>-->
        
          
          	<div class="panel panel-primary" data-collapsed="0">
               <!-- <h3>Video Player Watermark Settings</h3> -->
                <div class="panel-body"> 
                    <div class="row">
                        <!-- <div class="col-md-6">
                 <div >
            <p> Right:</p>
				    <div class="form-group">
				        <input type="text"  class="form-control"  name="watermark_right" id="watermark_right" value="<?=$settings->watermark_right;?>" />
				    </div>
          </div>
          <div >
                    <p> Top:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_top" id="watermark_top" value="<?=$settings->watermark_top;?>" />
				    </div>
          </div>
          <div >
            <p> Bottom:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_bottom" id="watermark_bottom" value="<?=$settings->watermark_bottom;?>" />
				    </div>
          </div>
          <div >
                    <p> Left:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_left" id="watermark_left" value="<?=$settings->watermark_left;?>" />
				    </div>
          </div>
          
                </div>
                        <div class="col-md-6">
                        <div >
              <p> Opacity:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_opacity" id="watermark_opacity" value="<?=$settings->watermark_opacity;?>" />
				    </div> 
          </div>
            
            <div >
                <p> Link:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermar_link" id="watermar_link" value="<?=$settings->watermar_link;?>" />
				    </div>
            
          </div>
            
        <div >
            <p>Upload Watermark:</p> 
            <input type="file" multiple="true" class="form-control" name="watermark" id="watermark" />
             @if(!empty($settings->watermark))
                            <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->watermark }}" style="max-height:100px" />
            @endif
          </div> -->
                          <!--  <div class="col-sm-6"> 
				<div class="panel panel-primary row" data-collapsed="0">
					<!-- <div class="panel-heading col-md-10"> <div class="panel-title">Enable https:// sitewide</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body col-md-2"> 
						<!--<p>Make sure you have purchased an SSL before anabling https://</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->enable_https) || (isset($settings->enable_https) && $settings->enable_https))checked="checked" value="1"@else value="0"@endif name="enable_https" id="enable_https" />
				            </div>
						</div>
					</div>
				</div>
			</div>-->

                        </div>
            
            </div>
        </div>
               

		   <div class="row">
              <input type="hidden" value="0" name="demo_mode" id="demo_mode" />
           </div>
        
			

        
        <div class="row mt-3">
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title"><label>Pay per View</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body row"> 
						<p class="col-md-8 p1">Enable Pay per View:</p>

						<div class="form-group col-md-4">
				        
				                <input type="checkbox"  name="ppv_status" id="ppv_status"  @if(!isset($settings->ppv_status) || (isset($settings->ppv_status) && $settings->ppv_status))checked="checked" value="1"@else value="0"@endif />
				            
						</div>
						
					</div>
				</div>
                <div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title"><label>Pay Per view Hours</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p class="p1">Hours :</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
                                
                                <input type="number" class="form-control" name="ppv_hours" id="ppv_hours" placeholder="# of pay Per view hours" value="@if(!empty($settings->ppv_hours)){{ $settings->ppv_hours }}@endif" />
				            </div>
						</div>
					</div>
				</div>

			</div>
            
           <div class="col-sm-6"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title"><label>PPV Global Price</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p class="p1">PPV Price (USD):</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
                                
                                <input type="text" class="form-control" name="ppv_price" id="ppv_price" placeholder="# of PPV Global Price" value="@if(!empty($settings->ppv_price)){{ $settings->ppv_price }}@endif" />
				            </div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<div class="row mt-3">
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title"><label>Videos Per Page</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p class="p1">Default number of videos to show per page:</p> 
						<input type="text" class="form-control" name="videos_per_page" id="videos_per_page" placeholder="# of Videos Per Page" value="@if(!empty($settings->videos_per_page)){{ $settings->videos_per_page }}@endif" />
					</div>
				</div>

			</div>
			<div class="col-sm-6"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title"><label>Posts Per Page</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p class="p1">Default number of posts to show per page:</p> 
						<input type="text" class="form-control" name="posts_per_page" id="posts_per_page" placeholder="# of Posts Per Page" value="@if(!empty($settings->posts_per_page)){{ $settings->posts_per_page }}@endif" />
					</div>
				</div>
			</div>

		</div>

		<div class="panel panel-primary mt-3" data-collapsed="0">
			<div class="panel-heading"> <div class="panel-title"><label>Registration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body"> 
				<div class="row">
					<div class="col-md-4 align-center">
                        <div class="row" >
						<p class="col-md-8 p1">Enable Free Registration:</p>

						<div class="form-group col-md-4">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->free_registration) || (isset($settings->free_registration) && $settings->free_registration))checked="checked" value="1"@else value="0"@endif name="free_registration" id="free_registration" />
				            </div>
						</div>
                        </div>
					</div>


					<div class="col-md-4 align-center" id="activation_email_block" style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
						<p class="p1">Require users to verify account by email:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->activation_email) || (isset($settings->activation_email) && $settings->activation_email))checked="checked" value="1"@else value="0"@endif name="activation_email" id="activation_email" />
				            </div>
						</div>
					</div>

					<div class="col-md-4 align-center" id="premium_upgrade_block" style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
						<p class="p1">Enable registered users ability to upgrade to subscriber:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->premium_upgrade) || (isset($settings->premium_upgrade) && $settings->premium_upgrade))checked="checked" value="1"@else value="0"@endif name="premium_upgrade" id="premium_upgrade" />
				            </div>
						</div>
					</div>

				</div>
				
			</div>
		</div>
        <div class="row mt-3">
            <div class="col-md-6">

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>System Email</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<p class="p1">Email address to be used to send system emails:</p> 
				<input type="text" class="form-control" name="system_email" id="system_email" placeholder="Email Address" value="@if(!empty($settings->system_email)){{ $settings->system_email }}@endif" />
			</div> 
		</div>



		<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Google Analytics Tracking ID</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				
				<p class="p1">Google Analytics Tracking ID (ex. UA-12345678-9)::</p> 
				<input type="text" class="form-control" name="google_tracking_id" id="google_tracking_id" placeholder="Google Analytics Tracking ID" value="@if(!empty($settings->google_tracking_id)){{ $settings->google_tracking_id }}@endif" />
				
			</div> 
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><p class="p1">Google Analytics API Integration (This will integrate with your dashboard analytics)</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body mt-5" style="display: block;"> 
				
				<label>Google Oauth Client ID Key:</label> 
				<input type="text" class="form-control" name="google_oauth_key" id="google_oauth_key" placeholder="Google Client ID Key" value="@if(!empty($settings->google_oauth_key)){{ $settings->google_oauth_key }}@endif" />
				

			</div> 
		</div>	
    
    
    <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Refferal Settings</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;">
                <label class="panel-title">Enable / Disable:</label>
				 
                    
                        <input type="checkbox"  @if($settings->coupon_status == 1)checked="checked" value="1"@else value="0"@endif name="coupon_status">
            
            
			</div> 
		</div>     
            </div>
            <div>
                <div style="padding:15px;">
                		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Social Networks</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				
				<p class="p1">Facebook Page ID: ex. facebook.com/page_id (without facebook.com):</p> 
				<input type="text" class="form-control" name="facebook_page_id" id="facebook_page_id" placeholder="Facebook Page" value="@if(!empty($settings->facebook_page_id)){{ $settings->facebook_page_id }}@endif" />
				<br />
				<p class="p1">Google Plus User ID:</p>
				<input type="text" class="form-control" name="google_page_id" id="google_page_id" placeholder="Google Plus Page" value="@if(!empty($settings->google_page_id)){{ $settings->google_page_id }}@endif" />
				<br />
				<p class="p1">Twitter Username:</p>
				<input type="text" class="form-control" name="twitter_page_id" id="twitter_page_id" placeholder="Twitter Username" value="@if(!empty($settings->twitter_page_id)){{ $settings->twitter_page_id }}@endif" />
				<br />
				<p class="p1">YouTube Channel ex. youtube.com/channel_name:</p>
				<input type="text" class="form-control" name="youtube_page_id" id="youtube_page_id" placeholder="YouTube Channel" value="@if(!empty($settings->youtube_page_id)){{ $settings->youtube_page_id }}@endif" />
			
			</div> 
		</div>
            </div>
        </div>
            <div style="padding:15px;">
    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"> <label>Settings For New Subscription</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
        <div class="row">
            <div class="col-sm-6">
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Coupon Enable / Disable:</label>
                        

                                <label><input type="checkbox"  @if($settings->new_subscriber_coupon == 1)checked="checked" value="1"@else value="0"@endif name="new_subscriber_coupon"></label>
                       

                    </div> 
                 <div class="panel-body mt-3" style="display: block;">
                        <label class="panel-title">Discount %:</label>
                         <div class="form-group add-profile-pic checkbox">
                             <input type="text"  class="form-control" @if(isset($settings->discount_percentage)) value="<?=$settings->discount_percentage;?>"@endif placeholder="Discount %:" name="discount_percentage">
                        </div>

                    </div> 
            </div> 
            
            <div class="col-sm-6 mt-3">
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Coupon Code:</label>
                         <div class="form-group add-profile-pic checkbox">
                             <input type="text"  class="form-control" @if(isset($settings->coupon_code)) value="<?=$settings->coupon_code;?>"@endif placeholder="Enter Coupon Code" name="coupon_code">
                        </div>

                    </div> 
            </div> 
        </div>
		</div> 
        <div class="row">
            <div class="col-md-6">
        
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Login Page Content Image</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<p>Login Page Content:</p> 
                    <div class="form-group add-profile-pic">                        
                    @if(!empty($settings->login_content))
                        <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->login_content }}" style="max-height:100px" />
                    @endif
                         <label>Cover Image:</label>
                            <input id="f02" type="file" name="login_content" placeholder="Upload Image" />
                         
                          <p class="padding-top-20 p1">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
                      </div>
                <div class="form-group add-profile-pic">
                    <label>Login Text:</label>
                    <input id="login_text" type="text" name="login_text" class="form-control" placeholder="Login Text" value="@if(!empty($settings->login_text)){{ $settings->login_text }}@endif"/>
                </div>
			</div> 
		</div>    
    
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Email Signature </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
                <div class="form-group add-profile-pic">
                    <p class="p1">Email Signature:</p>
                    <textarea id="summary-ckeditor"  name="signature" class="form-control" placeholder="Email signature" value="@if(!empty($settings->signature)){{ $settings->signature }}@endif"><?php echo $settings->signature; ?></textarea>
                </div>
			</div> 
		</div>
    
    
       
            </div>
            <div class="col-md-6">
                 <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                <div class="panel-title"><label>Pusher Notification</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                        <div class="panel-body" style="display: block;"> 
                            <p class="p1">Notification Server Key:</p> 
                            <input type="text" class="form-control" name="notification_key" id="notification_key" placeholder="Notification Server Key" value="@if(!empty($settings->notification_key)){{ $settings->notification_key }}@endif" />
                        </div> 
            </div>
            </div>
        </div>
        <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
                <div class="panel-title">Notification Icon</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body" style="display: block; background:#141414;"> 
                    @if(!empty($settings->notification_icon))
                        <img src="{{ URL::to('/public/uploads/') . '/settings/' . $settings->notification_icon }}" style="max-height:100px" />
                    @endif
                    <p>Upload Your Site Notification Icon:</p> 
                    <input type="file" multiple="true" class="form-control" name="notification_icon" id="notification_icon" />

                </div> 
            </div>
            </div>
        </div>
      

    
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Settings" class="btn btn-primary pull-right" />

	

	<div class="clear"></div>

</div>
             </div>
    </form>
        </div></div></div></div><!-- admin-container -->

@section('javascript')
	<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

			$('#free_registration').change(function(){
				if($(this).is(":checked")) {
					$('#activation_email_block').fadeIn();
					$('#premium_upgrade_block').fadeIn();
				} else {
					$('#activation_email_block').fadeOut();
					$('#premium_upgrade_block').fadeOut();
				}
			});

		});
        
        $('#ppv_status').on('change', function(){
                this.value = this.checked ? 1 : 0;
            
        }).change();

	</script>

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'summary-ckeditor', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    </script>

@stop

@stop