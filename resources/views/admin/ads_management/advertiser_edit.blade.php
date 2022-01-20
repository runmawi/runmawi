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
        <div class="row">
            <div class="col-md-12">
                <h3><i class="entypo-archive"></i>Update Advertiser</h3>
            </div>
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
				<div class="clear"></div>
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
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/advertiser/update') }}" method="post" id="advertiser_edit">
                        <div class="form-group">
                            <label>  Company Name:</label>
                            <input type="text" id="company_name" name="company_name" value="{{ $advertisers->company_name }}" class="form-control" placeholder="Enter ">
                        </div>
                        <div class="form-group">
                            <label>  License Number:</label>
                            <input type="text" id="license_number" name="license_number" value="{{ $advertisers->license_number }}" class="form-control" placeholder="Enter ">
                        </div>
                        <div class="form-group">
                            <label>  Address:</label>
                            <input type="text" id="address" name="address" value="{{ $advertisers->address }}" class="form-control" placeholder="Enter ">
                        </div>
                        <div class="form-group">
                            <label>  Mobile Number:</label>
                            <input type="text" id="mobile_number" name="mobile_number" value="{{ $advertisers->mobile_number }}" class="form-control" placeholder="Enter ">
                        </div>
                        <div class="form-group">
                            <label>  Email Name:</label>
                            <input type="text" id="email_id" name="email_id" value="{{ $advertisers->email_id }}" class="form-control" placeholder="Enter ">
                        </div>  
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                <input type="hidden" name="id" id="id" value="{{ $advertisers->id }}" />

              <div class="modal-footer">
              
                <input  type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
                    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/advertisers') }}">Close</a>
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
        <script>
            $('form[id="devices_edit"]').validate({
                rules: {
                    devices_name : 'required',
                    },
                submitHandler: function(form) {
                    form.submit(); }
                });

                $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
        </script>
    @stop
