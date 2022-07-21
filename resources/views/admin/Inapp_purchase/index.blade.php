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
</style>

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection
@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="admin-section-title">
            <div class="iq-card">

                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                 @endif

                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="entypo-archive"></i> Manage In App Purchase Plans </h4>
                    </div>

                    @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                            <div class="alert alert-danger display-hide" id="successMessage" >
                                <button id="successMessage" class="close" data-close="alert"></button>
                                <span>{{ $message }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="col-md-6" align="right">
                        <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
                    </div>
	

                <!-- Add New Modal -->
                <div class="modal fade" id="add-new">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h4 class="modal-title">New In App Purchase Plans</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            
                            <div class="modal-body">
                                <form id="new-cat-form" accept-charset="UTF-8" action="{{  route('inapp_purchase_store')  }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Plan Price  ( ₹ ) :</label>
                                        <input type="text" id="plan_price" name="plan_price" value="" class="form-control" placeholder="Enter Plan Price">
                                    </div>  

                                    <div class="form-group" >
                                        <label>Product ID :</label>
                                        <input type="text" id="product_id" name="product_id" value="" class="form-control" placeholder="Enter Product ID">
                                    </div>
                                    
                                    <div class="modal-footer form-group">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                                        
                                        {{-- Table --}}

                <div class="panel panel-primary category-panel" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <p style="font-size:12px;"></p>
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <div id="nestable" class="nested-list dd with-margins">
                            <table class="table table-bordered" id="categorytbl">

                                <tr class="table-header">
                                    <th><label> S.No        </label></th>
                                    <th><label> Plan Price  </label></th>
                                    <th><label> Product ID  </label></th>
                                    <th><label> Action      </label></th>
                                </tr>
                                            
                                @forelse($Inapp_Purchase as $key => $ios_purchase)
                                    <td valign="bottom"><p>{{ $key+1 }}</p></td>

                                    <td valign="bottom"><p>{{ $ios_purchase->plan_price }}</p></td>

                                    <td valign="bottom"><p>{{ $ios_purchase->product_id }}</p></td>

                                    <td>
                                        <div class=" align-items-center list-user-action">
                                            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit" href="{{ URL::to('admin/inapp-purchase_edit/') }}/{{$ios_purchase->id}}" >
                                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>">
                                            </a> 
                                            <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                                onclick="return confirm('Are you sure?')"  data-original-title="Delete" href="{{ URL::to('admin/inapp-purchase_delete/') }}/{{$ios_purchase->id}}" >
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>">
                                            </a>
                                        </div>
                                    </td>
                                    </tr>

                                @empty
                                    <td colspan="4" style="text-align: center;">{{ 'No Data Available'}}</td>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	        <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
    </div>


	@section('javascript')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

		<script type="text/javascript">

            jQuery(document).ready(function($){

                $('#submit-new-cat').click(function(){
                    $('#new-cat-form').submit();
                });
            });

            $(document).ready(function(){
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            })

            $('form[id="new-cat-form"]').validate({
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


		</script>
	@stop
@stop