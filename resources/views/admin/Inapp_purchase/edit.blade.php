@extends('admin.master')

@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="iq-card">

                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                <h4><i class="entypo-archive"></i>  Manage In App Purchase Plans </h4>
                <div class="modal-body">
	                <form id="update-cat-form" accept-charset="UTF-8" action="{{ route('inapp_purchase_update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group ">
                            <label> Plan Price :</label>
                            <input type="text" id="plan_price" name="plan_price" value="{{ $Inapp_Purchase->plan_price }}" class="form-control" placeholder="Enter Plan Price">
                        </div>

                        <div class="form-group">
                            <label> Product ID :</label>
                            <input type="text" id="product_id" name="product_id" value="{{ $Inapp_Purchase->product_id }}" class="form-control" placeholder="Enter Product ID">
                        </div>
                        <input type="hidden" name="id" id="id" value="{{ $Inapp_Purchase->id }}" />
                </form>
            </div>

            <div class="modal-footer">
                <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ route('inapp_purchase') }}">Close</a>
                <button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
            </div>
        </div>
    </div>
</div>
</div>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});

    $('form[id="update-cat-form"]').validate({
        rules: {
            plan_price: "required",
            product_id: "required",
        },
        messages: {
            plan_price: "This field is required",
            product_id: "This field is required",
        },
        submitHandler: function (form) {
            form.submit();
        },
    });

    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })

</script>

@stop
@stop