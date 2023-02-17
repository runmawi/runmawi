@extends('channel.master')
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
						<form id="user_update" method="POST" action="{{ URL::to('channel/update-myprofile') }}" accept-charset="UTF-8" enctype="multipart/form-data">
							<div class=" col-md-12 align-items-center">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> User Name:</label>
                                        <input type="text" class="form-control" name="channel_name" id="channel_name"  value="@if(!empty($channel->channel_name)){{ $channel->channel_name }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Email:</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="@if(!empty($channel->email)){{ $channel->email }}@endif" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> Phone Number:</label>
                                        <input type="number" class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number"  value="@if(!empty($channel->mobile_number)){{ $channel->mobile_number }}@endif" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Profile Picture:</label>
                                        <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="picture" id="picture" />
                                        @if(!empty($channel->channel_image))
                                            <img src="{{ @$channel->channel_image }}" class="video-img" width="200" height="200"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6 form-group">
                                        <label> Channel Logo:</label>
                                        <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="channel_logo" id="channel_logo" />
                                        @if(!empty($channel->channel_logo))
                                            <img src="{{ @$channel->channel_logo }}" class="video-img" width="200" height="200"/>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label> Channel Banner:</label>
                                        <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="channel_banner" id="channel_banner" />
                                        @if(!empty($channel->channel_banner))
                                            <img src="{{ @$channel->channel_banner }}" class="video-img" width="200" height="200"/>
                                        @endif
                                    </div>
                                </div>
                               

								<div class="col-md-6 mt-3">
								<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
								<input type="hidden" name="id" value="{{ @$channel->id }}" />
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

 var  cheque = "{{ @$channel->cancelled_cheque }}";

//  alert(image);
   $('form[id="user_update"]').validate({
   	rules: {
        upi_mobile_number : 'required',
        upi_id : 'required',
        // account_number : 'required',
        // upi_mobile_number : 'required',
        // cancelled_cheque: {
        //         required: function (element) {
        //             var  cheque = "{{ @$channel->cancelled_cheque }}";
        //             if (cheque == "") {
        //                 return true;
        //             } else {
        //                 return false;
        //             }
        //         },
        //     },
            // picture: {
            //     required: function (element) {
            //         var  image = "{{ @$channel->picture }}";
            //         if (image == "") {
            //             return true;
            //         } else {
            //             return false;
            //         }
            //     },
            // },
        // cancelled_cheque : 'required',
        // picture : 'required',
   	},
   	messages: {
        // upi_mobile_number: 'This field is required',
        // upi_id: 'This field is required',
        // account_number : 'This field is required',
        // IFSC_Code : 'This field is required',
        // cancelled_cheque : 'This field is required',
        // picture : 'This field is required',
   	},
   	submitHandler: function(form) {
   	  form.submit();
   	}
    });

</script>





@stop