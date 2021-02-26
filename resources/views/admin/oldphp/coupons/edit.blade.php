@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection

@section('content')

<div class="admin-section-title">
       <!--  <div class="row">
            <div class="col-md-12">
                <h3><i class="entypo-archive"></i>  Room Topic </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
        </div> -->
    </div>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Update Plans</h3>
</div>

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
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/coupons/update') }}" method="post">
             <div class="form-group">
                            <label>  Coupon Name:</label>
                            <input type="text" id="name" name="coupon_code" value="{{ $edit_coupons[0]->coupon_code }}" class="form-control" placeholder="Enter ">
                        </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                <input type="hidden" name="id" id="id" value="{{ $edit_coupons[0]->id }}" />

              <div class="modal-footer">
                <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
                <input  type="submit" class="btn btn-white" id="submit-update-cat" value="Update" />
            </div>
        </form>
</div>
    @stop