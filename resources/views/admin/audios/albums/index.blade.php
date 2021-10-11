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
							<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Audio Album</a>
						</div>
					</div>
					<div class="iq-card-body">

						<div id="nestable" class="nested-list dd with-margins">
							<table class="data-tables table audio_table " style="width:100%">
                     		<thead>
                     			<tr>
                     				<th><label>Name</label></th>
                     				<th><label>Image</label></th>
                     				<th><label>Action</label></th>
                     			</tr>
                     		</thead>
                     		<tbody>

								@foreach($allAlbums as $album)
								<tr>
                     				<td>{{ $album->albumname }}</td>
                     				<td><?php if($album->album != '') { ?><img src="{{ URL::to('/public/uploads/albums/') . '/'.$album->album }}" width="50"><?php }else{} ?></td>
                     				<td class="list-user-action">
                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('/admin/audios/albums/edit/') }}/{{ $album->id }}" class="edit"><i class="ri-pencil-line"></i></a> 
                     				<a href="{{ URL::to('/admin/audios/albums/delete/') }}/{{ $album->id }}" onclick="return confirm('Are you sure?')"   class=" iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></td>
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

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
                    <h4 class="modal-title">New Audio Albums</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

$('.edit').click(function(e){
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

$('.delete').click(function(e){
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