@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Audio Category</h4>
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
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                           <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Audio category</a>
                        </div>
                     </div>
                     <div class="iq-card-body">
                        <div class="table-view">

                     	<table class="table-bordered" id="categorytbl" style="width:100%">
                     		<thead>
                     			<tr class="text-center">
                     				<th><label>Image</label></th>
                     				<th><label>Name</label></th>
                     				<th><label>Action</label></th>
                     			</tr>
                     		</thead>
                     		<tbody>
                     			@foreach($allCategories as $category)
                     			<tr class="text-center">
                     				<td><?php if($category->image != '') { ?><img src="{{ URL::to('/public/uploads/audios/') . '/'.$category->image }}" width="50"><?php }else{} ?></td>
                     				<td><label>{{ ucfirst($category->name) }}</label></td>
                     				<td class=" list-user-action"> 
                     					<a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" class="edit" href="{{ URL::to('admin/audios/categories/edit/') }}/{{$category->id}}"><i class="ri-pencil-line"></i></a>

                     					<a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/audios/categories/delete/') }}/{{$category->id}}"><i class="ri-delete-bin-line"></i></a>
                     				</td>
                     			</tr>
                     			@endforeach
                     		</tbody>
                     	</table>
						
				</div>
			</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title">New Audio Category</h4>

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/audios/categories/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				        <!-- <label for="name">Enter the new category name below</label>
				        <input name="name" id="name" placeholder="Category Name" class="form-control" value="" /><br />
				        <label for="slug">URL slug (ex. audios/categories/slug-name)</label>
				        <input name="slug" id="slug" placeholder="URL Slug" class="form-control" value="" />
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" /> -->
				        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Name:</label>

                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter Name">
                        @if ($errors->has('name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Slug:</label>

                        <input type="text" id="slug" name="slug" value="" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label>Image:</label>
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />

                    </div>


                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">

                        <label>Category:</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="0">Select</option>
                            @foreach($allCategories as $rows)
                                    <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('parent_id'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('parent_id') }}</strong>
                            </span>
                        @endif

                    </div>
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


	@section('javascript')

		<script src="{{ URL::to('/assets/admin/js/jquery.nestable.js') }} "></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.edit').click(function(e){
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
    			$.post('<?= URL::to('admin/audios/categories/order');?>', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

			});


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
	@stop

@stop