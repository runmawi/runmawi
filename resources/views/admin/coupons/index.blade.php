@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection
@section('content')


<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i>  Plans </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	</div>


	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Plan</h4>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/plans/store') }}" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

						    <div class="form-group">

		                        <label> Plan Name:</label>

		                        <input type="text" id="slug" name="coupon_code" value="" class="form-control" placeholder="Enter coupon code">
                            </div>

				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-white" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
			<div class="panel panel-primary category-panel" data-collapsed="0">
		</div>
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

					 <ol id="tree1" class="dd-list">

                        @foreach($coupons as $coupon )

                            <li class="dd-item">

                               <div class="dd-handle"> {{ $coupon->coupon_code }} </div>
                               <div class="actions"><a href="{{ URL::to('/') }}/admin/coupons/edit/{{ $coupon->id }}" class="btn btn-black edit">Edit</a> <a href="{{ URL::to('/')}}/admin/coupons/delete/{{ $coupon->id }}" class="btn btn-white delete">Delete</a></div>
                            </li>

                        @endforeach

                    </ol>
						
				</div>
		
			</div>

	<script type="text/javascript">

		jQuery(document).ready(function($){


			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});
		});
	</script>


	@stop




