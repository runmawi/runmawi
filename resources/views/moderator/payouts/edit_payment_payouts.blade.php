@extends('admin.master')

@include('admin.favicon')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

    <div id="content-page" class="content-page">
        <div class="iq-card">
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
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Content Partners Manual Payouts :</h4>
                </div>
            </div>

            <div class="clear"></div>
                <div class="modal-body">
                    <form id="payouts_form"  accept-charset="UTF-8"  file="1"action="{{ URL::to('RazorpayModeratorPayouts') }}" method="post" enctype="multipart/form-data">
                    
        
                       <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                            <label> Content Partner Name:</label>
                            <input type="text" class="form-control" name="user_name" id="user_name" value="@if(count($payouts) > 0) {{ $payouts[0]->username }} @endif" readonly/>
                        </div>
        
                        <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                            <label> Commission to be Pay:</label>
                            <input type="text"  class="form-control" name="commission" id="commission" value="@if(count($payouts) > 0) {{ $payouts[0]->moderator_commssion }} @endif" readonly/>
                        </div>
        
                        <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                            <label> Total Paid Amount:</label>
                            <input type="text"  class="form-control" name="last_paid" id="last_paid" value="@if(count($payouts) > 0) {{ $last_paid }} @endif" readonly/>
                        </div>

                        <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                            <label> Pending Amount:</label>
                            <input type="text"  class="form-control" name="pending_paid" id="pending_paid" value="@if(count($payouts) > 0) {{ $payouts[0]->moderator_commssion - $last_paid }} @else 0 @endif" readonly/>
                        </div>

                        <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                            <label>Payment Type:</label>&nbsp;&nbsp;
                            <input type="radio" id="Partial_amount" name="payment_type" value="Partial_amount" > Partial Amount &nbsp;&nbsp;&nbsp;
                            <input type="radio" id="full_amount" name="payment_type" value="full_amount" > Full Amount
                        </div>

                        <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                            <label> Paying Amount:</label>
                            <input type="text"  class="form-control" name="commission_paid" id="commission_paid" value="" />
                        </div>

                        <!-- <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label>Invoice:</label>
                            <input type="file" multiple="true" class="form-control" name="invoice" id="invoice" />                        
                        </div> -->

                        <input type="hidden" name="id" id="id" value="@if(count($payouts) > 0) {{ $payouts[0]->user_id }} @endif" />
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        
                        <div>
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <button type="submit" class="btn btn-primary"  >submit</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
</script>

<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>



<script>
// $(document).ready(function () {
//     $('#payouts_form').validate({
//         rules: {
//             // payment_type: "required",
//             commission_paid: "required",
//         },
//         messages: {
//             // payment_type: "This field is required",
//             commission_paid: "This field is required",

//         },
//         submitHandler: function (form) {
//             form.submit();
//         },
//     });
// });

</script>