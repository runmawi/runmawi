


@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link href = "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<!--
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Category</h4>
</div>
-->

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/currency/update') }}" method="post" enctype="multipart/form-data">
					<div class="row">
                    <div class="col-md-6 form-group {{ $errors->has('image') ? 'has-error' : '' }}">
					<label class="p-2">Default Currency Settings:</label>
                <select class="form-control" id="country" name="country">
                    <option selected disabled="">Choose Currency</option>
                    @foreach($currency as $value)
                    <!-- <option value="{{ $value->country }}" @if(!empty($allCurrency->country) ==  $value->country ){{ 'selected' }}@endif>{{ $value->symbol .'-'. $value->currencies }}</option> -->
					<option value="{{ $value->country }}"  {{  ($allCurrency->country == $value->country ) ? 'selected' : '' }} > {{ $value->symbol .'-'.$value->currencies.'   '.$value->country.'   '.$value->code }}</option>

                    @endforeach
                </select>
                    </div> 
        
					<div class="col-md-6 form-group {{ $errors->has('image') ? 'has-error' : '' }}">
						<label class="p-2" for="">Today Currency Rate </label>
						@foreach($currency as $value)
							<p> {{  ($allCurrency->country == $value->country && $default_Currency == $value->code ) ?  $current_rate.'   '. $value->symbol  : '' }}  </p>
						@endforeach

                    </div>
                    </div>
					</div>
                    </div>
        

        <input type="hidden" name="id" id="id" value="{{ $allCurrency->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        
        
        <div class="modal-footer form-group">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
	<button type="submit" class="btn btn-primary" id="submit-update-cat" action="{{ URL::to('admin/currency/update') }}" >Update</button>
</div>
    </form>
</div>


						<div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="all_current_rate" style="width:100%">
                                    <thead>
                                        <tr class="r1">
											<th>#</th>
                                            <th>Country Name</th>
                                            <th>Country Code</th>
                                            <th>Currency Rate</th>
                                        </tr>
                                    </thead>
                                <tbody>
								@if(count($currency) > 0 && !empty($all_current_rate) > 0 )
                                    @foreach($currency as $key => $currency_value)
                                    	@foreach($all_current_rate as $rate_key => $value)
											@if($currency_value->code == $rate_key)
											<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $currency_value->country  }}</td>  
											<td>{{ $currency_value->code  }}</td>   
											<td>{{ $value  }}</td>  
											@endif
											</tr>

										@endforeach
                                    @endforeach
								@endif

                                </tbody>

                           </table>
                        </div>
                    </div>
             </div></div></div>
	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


	@section('javascript')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function(){
        $('#all_current_rate').DataTable();

		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>
		<script src="<?= URL::to('/assets/admin/js/jquery.nestable.js');?>"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-category').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-category .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this category?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
    			$('.category-panel').addClass('reloading');
    			$.post('<?= URL::to('admin/videos/categories/order');?>', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

			});


		});
		</script>
<script src="<?= URL::to('/'). '/assets/css/vue.min.js';?>"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	@stop

@stop