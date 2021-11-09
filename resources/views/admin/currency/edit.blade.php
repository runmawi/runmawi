


@extends('admin.master')
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop
 
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
       
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
					<label class="p-2">Currency :</label>
                <select class="form-control" id="country" name="country">
                    <option selected disabled="">Choose Currency</option>
                    @foreach($currency as $value)
                    <option value="{{ $value->country }}" @if(!empty($allCurrency->country) ==  $value->country ){{ 'selected' }}@endif>{{ $value->symbol .'-'. $value->currencies }}</option>
                    @endforeach
                </select>
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


             </div></div></div>
	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


	@section('javascript')
<script>
	$(document).ready(function(){
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