@extends('moderator.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
@section('content')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@stop

<style>
    .error{
        color: red;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">My Profile</h4>
						</div>
					</div>
                    @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif
					<div class="iq-card-body">
						<h5></h5>
						<form id="user_update" method="POST" action="{{ URL::to('cpp/update-myprofile') }}" accept-charset="UTF-8" enctype="multipart/form-data">
							<div class=" col-md-12 align-items-center">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> User Name:</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="UserName"  value="@if(!empty($user->username)){{ $user->username }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Email:</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="@if(!empty($user->email)){{ $user->email }}@endif" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> Phone Number:</label>
                                        <input type="number" class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number"  value="@if(!empty($user->mobile_number)){{ $user->mobile_number }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Profile Picture:</label>
                                        <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="picture" id="picture" />
                                        @if(!empty($user->picture))
                                            <img src="{{ URL::to('/') . '/public/uploads/moderator_albums/' . @$user->picture }}" class="video-img" width="200" height="200"/>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> Bank Name:</label>
                                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name"  value="@if(!empty($user->bank_name)){{ $user->bank_name }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Branch Name:</label>
                                        <input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name"  value="@if(!empty($user->branch_name)){{ $user->branch_name }}@endif" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> Account No:</label>
                                        <input type="text" class="form-control" name="account_number" id="account_number" placeholder="Account Number"  value="@if(!empty($user->account_number)){{ $user->account_number }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> IFSC Code:</label>
                                        <input type="text" class="form-control" name="IFSC_Code" id="IFSC_Code" placeholder="IFSC Code"  value="@if(!empty($user->IFSC_Code)){{ $user->IFSC_Code }}@endif" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> Cancelled Cheque:</label>
                                        <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="cancelled_cheque" id="cancelled_cheque" />
                                        @if(!empty($user->cancelled_cheque))
                                            <img src="{{ URL::to('/') . '/public/uploads/moderator_albums/' . @$user->cancelled_cheque }}" class="video-img" width="200" height="200"/>
                                        @endif
                                    </div>
                                </div>
							</div>
                               

								<div class="col-md-6 mt-3">
								<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
								<input type="hidden" name="id" value="{{ @$user->id }}" />
								<input type="submit" value="Update" class="btn btn-primary pull-right" />
                                    </div>
                            </div>
							</form>

							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
				



 
@stop
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

 var  cheque = "{{ $user->cancelled_cheque }}";

//  alert(image);
   $('form[id="user_update"]').validate({
   	rules: {
        bank_name : 'required',
        branch_name : 'required',
        account_number : 'required',
        IFSC_Code : 'required',
        cancelled_cheque: {
                required: function (element) {
                    var  cheque = "{{ $user->cancelled_cheque }}";
                    if (cheque == "") {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            picture: {
                required: function (element) {
                    var  image = "{{ $user->picture }}";
                    if (image == "") {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
        // cancelled_cheque : 'required',
        // picture : 'required',
   	},
   	messages: {
        bank_name: 'This field is required',
   	    branch_name: 'This field is required',
        account_number : 'This field is required',
        IFSC_Code : 'This field is required',
        // cancelled_cheque : 'This field is required',
        // picture : 'This field is required',
   	},
   	submitHandler: function(form) {
   	  form.submit();
   	}
    });

</script>





@stop