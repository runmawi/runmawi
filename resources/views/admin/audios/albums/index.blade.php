@extends('admin.master')

@section('content')

<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Audio Album</h4>
						</div>
						<div class="iq-card-header-toolbar d-flex align-items-center">
							<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Audio Album</a>
						</div>
					</div>
					<div class="iq-card-body">
						<div id="nestable" class="nested-list dd with-margins">

							<ol id="tree1" class="dd-list">

								@foreach($allAlbums as $album)

								<li class="dd-item">

									<div class="dd-handle"> {{ $album->albumname }} </div>
									<div class="actions"><a href="{{ URL::to('/admin/audios/albums/edit/') }}/{{ $album->id }}" class="edit">Edit</a> <a href="{{ URL::to('/admin/audios/albums/delete/') }}/{{ $album->id }}" class="delete">Delete</a></div>


								</li>

								@endforeach

							</ol>

						</div>

					</div>

				</div>
			</div>
		</div>
	</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Audio Albums</h4>
				</div>

				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/audios/albums/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

						<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

							<label>Name:</label>

							<input type="text" id="albumname" name="albumname" value="" class="form-control" placeholder="Enter Name">
							@if ($errors->has('name'))
							<span class="text-red" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif

						</div>

						<div class="form-group add-profile-pic">

							<label>Cover Image:</label>
							<input id="f02" type="file" name="album" placeholder="Add profile picture" />

							<p class="padding-top-20">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
						</div>
						<br/>
						<div class="form-group">

							<label>Slug:</label>

							<input type="text" id="slug" name="slug" value="" class="form-control" placeholder="Enter Slug">

						</div>

						
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info" id="submit-new-cat">Save changes</button>
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

	@section('javascript')

	<script src="{{ URL::to('/assets/admin/js/jquery.nestable.js') }}"></script>

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
//alert(href);
$.ajax({
	url: href,
	success: function(response)
	{
//alert('response');
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
	$.post('/admin/audios/albums/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
		console.log(data);
		$('.category-panel').removeClass('reloading');
	});

});


});
</script>

@stop

@stop