@extends('admin.master')

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



<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h3><i class="entypo-globe"></i> Site Settings</h3> 
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/settings/save_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row">
			
			<div class="col-md-4">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title">Site Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<p>Enter Your Website Name Below:</p> 
						<input type="text" class="form-control" name="website_name" id="website_name" placeholder="Site Title" value="@if(!empty($settings->website_name)){{ $settings->website_name }}@endif" />
					</div> 
				</div>
			</div>

			<div class="col-md-8">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title">Site Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<p>Enter Your Website Description Below:</p> 
						<input type="text" class="form-control" name="website_description" id="website_description" placeholder="Site Description" value="@if(!empty($settings->website_description)){{ $settings->website_description }}@endif" />
					</div> 
				</div>
			</div>

		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Logo</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block; background:#f1f1f1;"> 
				@if(!empty($settings->logo))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->logo }}" style="max-height:100px" />
				@endif
				<p>Upload Your Site Logo:</p> 
				<input type="file" multiple="true" class="form-control" name="logo" id="logo" />
				
			</div> 
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Favicon</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				@if(!empty($settings->favicon))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->favicon }}" style="max-height:20px" />
				@endif
				<p>Upload Your Site Favicon:</p> 
				<input type="file" multiple="true" class="form-control" name="favicon" id="favicon" />
				
			</div> 
		</div>
        
           <div class="row">
          	<div class="panel panel-primary" data-collapsed="0">
               <h2>Video Player Watermark Settings</h2>
                <div class="panel-body"> 
            
                 <div class="col-md-1">
            <p> Right:</p>
				    <div class="form-group">
				        <input type="text"  class="form-control"  name="watermark_right" id="watermark_right" value="<?=$settings->watermark_right;?>" />
				    </div>
          </div>
          <div class="col-md-1">
                    <p> Top:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_top" id="watermark_top" value="<?=$settings->watermark_top;?>" />
				    </div>
          </div>
          <div class="col-md-1">
            <p> Bottom:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_bottom" id="watermark_bottom" value="<?=$settings->watermark_bottom;?>" />
				    </div>
          </div>
          <div class="col-md-1">
                    <p> Left:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_left" id="watermark_left" value="<?=$settings->watermark_left;?>" />
				    </div>
          </div>
          <div class="col-md-1">
              <p> Opacity:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_opacity" id="watermark_opacity" value="<?=$settings->watermark_opacity;?>" />
				    </div> 
          </div>
            
            <div class="col-md-4">
                <p> Link:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermar_link" id="watermar_link" value="<?=$settings->watermar_link;?>" />
				    </div>
            
          </div>
            
        <div class="col-md-2">
            <p>Upload Watermark:</p> 
            <input type="file" multiple="true" class="form-control" name="watermark" id="watermark" />
             @if(!empty($settings->watermark))
                            <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->watermark }}" style="max-height:100px" />
            @endif
          </div>
                </div>
            
            </div>
        </div>

		   <div class="row">
              <input type="hidden" value="0" name="demo_mode" id="demo_mode" />
           </div>
        
			<div class="col-sm-6"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Enable https:// sitewide</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>Make sure you have purchased an SSL before anabling https://</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->enable_https) || (isset($settings->enable_https) && $settings->enable_https))checked="checked" value="1"@else value="0"@endif name="enable_https" id="enable_https" />
				            </div>
						</div>
					</div>
				</div>
			</div>

		</div>		
        
        <div class="row">
			<div class="col-sm-4">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Pay per View</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>Enable Pay per View:</p>

						<div class="form-group">
				        
				                <input type="checkbox"  name="ppv_status" id="ppv_status"  @if(!isset($settings->ppv_status) || (isset($settings->ppv_status) && $settings->ppv_status))checked="checked" value="1"@else value="0"@endif />
				            
						</div>
						
					</div>
				</div>

			</div>
            
           <div class="col-sm-4"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">PPV Global Price </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>PPV Price (USD):</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
                                
                                <input type="text" class="form-control" name="ppv_price" id="ppv_price" placeholder="# of PPV Global Price" value="@if(!empty($settings->ppv_price)){{ $settings->ppv_price }}@endif" />
				            </div>
						</div>
					</div>
				</div>
			</div>
            
			<div class="col-sm-4"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Pay Per view Hours</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>Hours :</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
                                
                                <input type="number" class="form-control" name="ppv_hours" id="ppv_hours" placeholder="# of pay Per view hours" value="@if(!empty($settings->ppv_hours)){{ $settings->ppv_hours }}@endif" />
				            </div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Videos Per Page</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>Default number of videos to show per page:</p> 
						<input type="text" class="form-control" name="videos_per_page" id="videos_per_page" placeholder="# of Videos Per Page" value="@if(!empty($settings->videos_per_page)){{ $settings->videos_per_page }}@endif" />
					</div>
				</div>

			</div>
			<div class="col-sm-6"> 
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Posts Per Page</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body"> 
						<p>Default number of posts to show per page:</p> 
						<input type="text" class="form-control" name="posts_per_page" id="posts_per_page" placeholder="# of Posts Per Page" value="@if(!empty($settings->posts_per_page)){{ $settings->posts_per_page }}@endif" />
					</div>
				</div>
			</div>

		</div>

		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading"> <div class="panel-title">Registration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body"> 
				<div class="row">
					<div class="col-md-4 align-center">
						<p>Enable Free Registration:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->free_registration) || (isset($settings->free_registration) && $settings->free_registration))checked="checked" value="1"@else value="0"@endif name="free_registration" id="free_registration" />
				            </div>
						</div>
					</div>


					<div class="col-md-4 align-center" id="activation_email_block" style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
						<p>Require users to verify account by email:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->activation_email) || (isset($settings->activation_email) && $settings->activation_email))checked="checked" value="1"@else value="0"@endif name="activation_email" id="activation_email" />
				            </div>
						</div>
					</div>

					<div class="col-md-4 align-center" id="premium_upgrade_block" style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
						<p>Enable registered users ability to upgrade to subscriber:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($settings->premium_upgrade) || (isset($settings->premium_upgrade) && $settings->premium_upgrade))checked="checked" value="1"@else value="0"@endif name="premium_upgrade" id="premium_upgrade" />
				            </div>
						</div>
					</div>

				</div>
				
			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">System Email</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<p>Email address to be used to send system emails:</p> 
				<input type="text" class="form-control" name="system_email" id="system_email" placeholder="Email Address" value="@if(!empty($settings->system_email)){{ $settings->system_email }}@endif" />
			</div> 
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Social Networks</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				
				<p>Facebook Page ID: ex. facebook.com/page_id (without facebook.com):</p> 
				<input type="text" class="form-control" name="facebook_page_id" id="facebook_page_id" placeholder="Facebook Page" value="@if(!empty($settings->facebook_page_id)){{ $settings->facebook_page_id }}@endif" />
				<br />
				<p>Google Plus User ID:</p>
				<input type="text" class="form-control" name="google_page_id" id="google_page_id" placeholder="Google Plus Page" value="@if(!empty($settings->google_page_id)){{ $settings->google_page_id }}@endif" />
				<br />
				<p>Twitter Username:</p>
				<input type="text" class="form-control" name="twitter_page_id" id="twitter_page_id" placeholder="Twitter Username" value="@if(!empty($settings->twitter_page_id)){{ $settings->twitter_page_id }}@endif" />
				<br />
				<p>YouTube Channel ex. youtube.com/channel_name:</p>
				<input type="text" class="form-control" name="youtube_page_id" id="youtube_page_id" placeholder="YouTube Channel" value="@if(!empty($settings->youtube_page_id)){{ $settings->youtube_page_id }}@endif" />
			
			</div> 
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Google Analytics Tracking ID</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				
				<p>Google Analytics Tracking ID (ex. UA-12345678-9)::</p> 
				<input type="text" class="form-control" name="google_tracking_id" id="google_tracking_id" placeholder="Google Analytics Tracking ID" value="@if(!empty($settings->google_tracking_id)){{ $settings->google_tracking_id }}@endif" />
				
			</div> 
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Google Analytics API Integration (This will integrate with your dashboard analytics)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				
				<p>Google Oauth Client ID Key:</p> 
				<input type="text" class="form-control" name="google_oauth_key" id="google_oauth_key" placeholder="Google Client ID Key" value="@if(!empty($settings->google_oauth_key)){{ $settings->google_oauth_key }}@endif" />
				

			</div> 
		</div>	
    
    
    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Refferal Settings </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;">
                <label class="panel-title">Enable / Disable:</label>
				 <div class="form-group add-profile-pic checkbox">
                    
                        <label><input type="checkbox"  @if($settings->coupon_status == 1)checked="checked" value="1"@else value="0"@endif name="coupon_status"></label>
                </div>
            
			</div> 
		</div>     
    
    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"> Settings For New Subscription </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
        <div class="row">
            <div class="col-sm-4">
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Coupon Enable / Disable:</label>
                         <div class="form-group add-profile-pic checkbox">

                                <label><input type="checkbox"  @if($settings->new_subscriber_coupon == 1)checked="checked" value="1"@else value="0"@endif name="new_subscriber_coupon"></label>
                        </div>

                    </div> 
            </div> 
            
            <div class="col-sm-4">
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Coupon Code:</label>
                         <div class="form-group add-profile-pic checkbox">
                             <input type="text"  class="form-control" @if(isset($settings->coupon_code)) value="<?=$settings->coupon_code;?>"@endif placeholder="Enter Coupon Code" name="coupon_code">
                        </div>

                    </div> 
            </div> 
            
            <div class="col-sm-4">
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Discount %:</label>
                         <div class="form-group add-profile-pic checkbox">
                             <input type="text"  class="form-control" @if(isset($settings->discount_percentage)) value="<?=$settings->discount_percentage;?>"@endif placeholder="Discount %:" name="discount_percentage">
                        </div>

                    </div> 
            </div>
        </div>
		</div> 
        
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Login Page Content Image</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<p>Login Page Content:</p> 
                    <div class="form-group add-profile-pic">                        
                    @if(!empty($settings->login_content))
                        <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->login_content }}" style="max-height:100px" />
                    @endif
                         <label>Cover Image:</label>
                            <input id="f02" type="file" name="login_content" placeholder="Upload Image" />
                         
                          <p class="padding-top-20">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
                      </div>
                <div class="form-group add-profile-pic">
                    <label>Login Text:</label>
                    <input id="login_text" type="text" name="login_text" class="form-control" placeholder="Login Text" value="@if(!empty($settings->login_text)){{ $settings->login_text }}@endif"/>
                </div>
			</div> 
		</div>    
    
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Email Signature </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
                <div class="form-group add-profile-pic">
                    <label>Email Signature:</label>
                    <textarea id="summary-ckeditor"  name="signature" class="form-control" placeholder="Email signature" value="@if(!empty($settings->signature)){{ $settings->signature }}@endif"><?php echo $settings->signature; ?></textarea>
                </div>
			</div> 
		</div>
    
    
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                <div class="panel-title">Pusher Notification</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                        <div class="panel-body" style="display: block;"> 
                            <p>Notification Server Key:</p> 
                            <input type="text" class="form-control" name="notification_key" id="notification_key" placeholder="Notification Server Key" value="@if(!empty($settings->notification_key)){{ $settings->notification_key }}@endif" />
                        </div> 
            </div>
            </div>
        </div>
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                <div class="panel-title">Notification Icon</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body" style="display: block; background:#f1f1f1;"> 
                    @if(!empty($settings->notification_icon))
                        <img src="{{ URL::to('/public/uploads/') . '/settings/' . $settings->notification_icon }}" style="max-height:100px" />
                    @endif
                    <p>Upload Your Site Notification Icon:</p> 
                    <input type="file" multiple="true" class="form-control" name="notification_icon" id="notification_icon" />

                </div> 
            </div>

    
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Settings" class="btn btn-black pull-right" />

	</form>

	<div class="clear"></div>

</div><!-- admin-container -->

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