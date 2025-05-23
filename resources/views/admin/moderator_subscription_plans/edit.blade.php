@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<div class="admin-section-title">
    <h4 class="p-3">Subscription Plan Update</h4>
       <!--  <div class="row">
            <div class="col-md-12">
                <h3><i class="entypo-archive"></i>  Room Topic </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
        </div> -->
    </div>

<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Update Plans</h3>
</div>-->


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif   



    <div class="modal-body">
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/moderator-subscription-plans/update') }}" method="post" id="subscription_edit">
            <div class="row col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>  Plans Name:</label>
                        <input type="text" id="name" name="plans_name" value="{{ $edit_plan[0]->plans_name }}" class="form-control" placeholder="Enter ">
                    </div>

                    @foreach($edit_plan as $plan)
                        <div class="form-group">
                            <label>{{ $plan->type }} Recurring Plan ID:</label>
                            <input type="text" id="plans_id" name="plan_id[{{ $plan->subscription_plan_name }}]" value="{{ $plan->plan_id }}" class="form-control" placeholder="Plan ID">

                            <label>{{ $plan->type }} One Time Plan ID:</label>
                            <input type="text" id="one_time_subscription_plan_id" name="one_time_subscription_plan_id[{{ $plan->subscription_plan_name }}]" value="{{ $plan->one_time_subscription_plan_id }}" class="form-control" placeholder="Plan ID">

                        </div> 
                    @endforeach

                    <!-- @foreach($payment_settings as $payment_setting)
						@if($payment_setting->status == 1)
							<label>{{ $payment_setting->payment_type }} Plan ID:</label>
                            @foreach($edit_plan as $plan)
                            <input type="text" id="plans_id" name="plan_id[{{ $payment_setting->payment_type }}]" value="@if($plan->type == $payment_setting->payment_type){{ $plan->plan_id }} @endif" class="form-control" placeholder="Plan ID">
                            @endForeach
							<p>* Get Plan Key From {{ $payment_setting->payment_type }}</p>
                        @endif
				    @endForeach -->
                           
                    <div class="form-group">
                        <label>Video Quality:</label>
                        <input type="text" id="video_quality" name="video_quality"  value="{{ $edit_plan[0]->video_quality }}" class="form-control" placeholder="Quality">
                    </div> 
                           
                    <div class="form-group">
                        <label> Price ( {{ @$allCurrency->symbol }} ):</label>
                        <input type="text" id="price" name="price" value="{{ $edit_plan[0]->price }}" class="form-control" placeholder="Price">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Payment Type:</label><br>
                        One Time Payment  <input type="radio"  name="payment_type"  value="one_time" @if ($edit_plan[0]->payment_type=='one_time') checked='checked' @endif>
                        Recurring   <input type="radio"  name="payment_type"  value="recurring"  @if ($edit_plan[0]->payment_type=='recurring') checked='checked' @endif>
                    </div> 

                    <div class="form-group">
                        <label>Resolution :</label>
                        <input type="text" id="resolution" name="resolution"  value="{{ $edit_plan[0]->resolution }}" class="form-control" placeholder="Resolution">
                    </div>  

                    <div class="form-group">
                        <label> IOS Product ID :</label>
                        <input type="text" id="ios_product_id" name="ios_product_id" value="{{ $edit_plan[0]->ios_product_id }}"  class="form-control" placeholder="IOS Product ID">
                    </div>
                            
                    <div class="form-group">
                        <label>IOS Plan Price ( {{ @$allCurrency->symbol }} ):</label>
                        <input type="text" id="ios_plan_price" name="ios_plan_price" value="{{ $edit_plan[0]->ios_plan_price }}"  class="form-control" placeholder="IOS Plan Price">
                    </div>
                <div>

                <div class="form-group">
                    <label> Devices :</label>
                </div>

                @foreach($devices as $val)
                    <div class="col-md-7 p-0 d-flex justify-content-between align-items-center" style="float:left;">                                           
                        <div>  <label  >{{ $val->devices_name }}</label></div>
                        <div>
                            <label class="switch">
                                <input class="form-check-input" type="checkbox" name="devices[]" value="{{ $val->id }}" {{ (in_array($val->id, $user_devices)) ? ' checked' : '' }}> 
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row col-md-12">
            <div class="form-group col-md-6">
                    <label>Upload Video Content Limit:</label>
                    <input type="text" onkeypress="return VideoIsNumeric(event);" ondrop="return false;" onpaste="return false;" id="upload_video_limit" name="upload_video_limit" value="{{ $edit_plan[0]->upload_video_limit }}" class="form-control" placeholder="Video Content Limit">
                    <span id="Videoerror" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                </div>

                <div class="form-group col-md-6">
                    <label>Upload LiveStream Content Limit:</label>
                    <input type="text" onkeypress="return LiveStreamIsNumeric(event);" ondrop="return false;" onpaste="return false;" id="upload_live_limit" name="upload_live_limit" value="{{ $edit_plan[0]->upload_live_limit }}" class="form-control" placeholder="LiveStream Content Limit">
                    <span id="LiveStreamerror" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                </div>
            </div>  
            <div class="row col-md-12">

                <div class="form-group col-md-6">
                    <label>Upload Episode Content Limit:</label>
                    <input type="text" onkeypress="return EpisodeIsNumeric(event);" ondrop="return false;" onpaste="return false;" id="upload_episode_limit" name="upload_episode_limit" value="{{ $edit_plan[0]->upload_episode_limit }}" class="form-control" placeholder="Episode Content Limit">
                    <span id="Episodeerror" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                </div>

                <div class="form-group col-md-6">
                    <label>Upload Audio Content Limit:</label>
                    <input type="text" onkeypress="return AudioIsNumeric(event);" ondrop="return false;" onpaste="return false;" id="upload_audio_limit" name="upload_audio_limit" value="{{ $edit_plan[0]->upload_audio_limit }}" class="form-control" placeholder="Audio Content Limit">
                    <span id="Audioerror" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                </div>
            </div>  

            <div class=" col-md-12">
                <div class="form-group">
                    <label> Plan Content :</label>
                    <textarea class="form-control" id="plan_content" name="plan_content" > @if(!empty( $plan->plan_content )){{ ( $plan->plan_content  ) }}@endif </textarea>
                </div>  
            </div>

            <!-- <div class="row d-flex col-md-12">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label> {{ ucwords('enable promo code on checkout') }} : <br> <small> (only for Stripe Payment) </small> </label>
                        <div class="mt-1">
                            <label class="switch">
                                <input name="auto_stripe_promo_code_status" class="auto_stripe_promo_code_status" id="auto_stripe_promo_code_status" type="checkbox" @if( $plan->auto_stripe_promo_code_status != null &&  $plan->auto_stripe_promo_code_status == 1 ) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div> 
                </div> 

                <div class="col-md-6">
                    <div class="form-group ">
                        <label> {{ ucwords('Apply promo code on checkout') }} : <br> <small> (only for Stripe Payment) </small> </label>
                        <input type="text" id="auto_stripe_promo_code" name="auto_stripe_promo_code"  class="form-control" placeholder="Promo Code" value="{{ $plan->auto_stripe_promo_code }}" >
                    </div> 
                </div> 

            </div>

            <div class="row d-flex col-md-12">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label> {{ ucwords('enable ads') }}</label>
                        <div class="mt-1">
                            <label class="switch">
                                <input name="ads_status" class="ads_status" id="ads_status" type="checkbox" @if( $plan->ads_status != null &&  $plan->ads_status == 1 ) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div> 
                </div>  -->

                <!-- @if( $paystack_status != null )
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label> {{ ucwords('andriod paystack url') }}</label>
                            <div class="col-md-12">
                                <input type="url" class="form-control" id="andriod_paystack_url" name="andriod_paystack_url" value="{{ $plan->andriod_paystack_url }}" >
                            </div> 
                        </div> 
                    </div> 
                @endif -->
            </div>

                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
            
                <input type="hidden" name="id" id="id" value="{{ $edit_plan[0]->id }}" />

                @foreach($edit_plan as $plan)
                    <input type="hidden" id="subscription_plan_name" name="subscription_plan_name[]" value="{{ $plan->subscription_plan_name }}" class="form-control" placeholder="Plan ID">
                @endforeach

              <div class="mt-3 ml-3">
                <a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/moderator-subscription-plans') }}">Close</a>
                <input  type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
            </div>
           
        </form>
</div>
             </div>
    </div>
</div>

    @stop

@section('javascript')

	{{-- validate --}}

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

	<script>

        var specialKeys = new Array();
        specialKeys.push(8); //Backspace

    function VideoIsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var inputField = e.target || e.srcElement;
        var inputValue = inputField.value;
        var digitCount = inputValue.replace(/[^0-9]/g, '').length;

        var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

        if (digitCount >= 12) {
            alert('Please enter atleast 12 characters');
            ret = ret || specialKeys.indexOf(keyCode) !== -1;
            document.getElementById("Videoerror").style.display = ret ? "none" : "inline";
            return false;
        }

        document.getElementById("Videoerror").style.display = ret ? "none" : "inline";
        return ret;
    }

    function LiveStreamIsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var inputField = e.target || e.srcElement;
        var inputValue = inputField.value;
        var digitCount = inputValue.replace(/[^0-9]/g, '').length;

        var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

        if (digitCount >= 12) {
            alert('Please enter atleast 12 characters');
            ret = ret || specialKeys.indexOf(keyCode) !== -1;
            document.getElementById("LiveStreamerror").style.display = ret ? "none" : "inline";
            return false;
        }

        document.getElementById("LiveStreamerror").style.display = ret ? "none" : "inline";
        return ret;
    }


    function EpisodeIsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var inputField = e.target || e.srcElement;
        var inputValue = inputField.value;
        var digitCount = inputValue.replace(/[^0-9]/g, '').length;

        var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

        if (digitCount >= 12) {
            alert('Please enter atleast 12 characters');
            ret = ret || specialKeys.indexOf(keyCode) !== -1;
            document.getElementById("Episodeerror").style.display = ret ? "none" : "inline";
            return false;
        }

        document.getElementById("Episodeerror").style.display = ret ? "none" : "inline";
        return ret;
    }


    function AudioIsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var inputField = e.target || e.srcElement;
        var inputValue = inputField.value;
        var digitCount = inputValue.replace(/[^0-9]/g, '').length;

        var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

        if (digitCount >= 12) {
            alert('Please enter atleast 12 characters');
            ret = ret || specialKeys.indexOf(keyCode) !== -1;
            document.getElementById("Audioerror").style.display = ret ? "none" : "inline";
            return false;
        }

        document.getElementById("Audioerror").style.display = ret ? "none" : "inline";
        return ret;
    }

		$('form[id="subscription_edit"]').validate({
            ignore: [],
			rules: {
                plans_name : 'required',
                price : 'required',
                video_quality : 'required',
                resolution : 'required',
                'plan_id[]': {
                required: true
                }
					
				},
			submitHandler: function(form) {
				form.submit(); }
			});

		CKEDITOR.replace( 'plan_content' );

	</script>

@stop
