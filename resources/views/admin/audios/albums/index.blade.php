@extends('admin.master')
<style>
    .form-control {
        /*background-color: #fff!important;*/
    }
    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }
    .black:hover {
        background: #fff;
        padding: 20px 20px;
        color: rgba(66, 149, 210, 1);
    }
</style>
@section('content')

	<div id="content-page" class="content-page">
		
		<div class="d-flex">
			<a class="black" href="{{ URL::to('admin/audios') }}">Audio List</a>
			<a class="black" href="{{ URL::to('admin/audios/create') }}">Add New Audio</a>
			<a class="black" href="{{ URL::to('admin/audios/categories') }}">Manage Audio Categories</a>
			<a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/audios/albums') }}">Manage Albums</a>
		</div>
		
		<div class="container-fluid p-0">
			<div class="row">
				<div class="col-sm-12">
					<div class="iq-card">
						<div class="iq-card-header d-flex justify-content-between align-items-baseline mb-4">
							<div class="iq-header-title">
								<h4 class="card-title">Audio Album</h4>
							</div>
							@if (Session::has('message'))
							<div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
							@endif
							@if(count($errors) > 0)
							@foreach($errors->all() as $message)
							<div class="alert alert-danger display-hide" id="successMessage">
								<button id="successMessage" class="close" data-close="alert"></button>
								<span>{{ $message }}</span>
							</div>
							@endforeach
							@endif
							<div class="iq-card-header-toolbar d-flex align-items-center">
								<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary">
									<i class="fa fa-plus-circle"></i> Add Audio Album
								</a>
							</div>
						</div>
						<div class="iq-card-body p-0">

							<div id="nestable" class="nested-list dd with-margins p-0">
								<table id="audioAlbumsTable" class="data-tables table audio_table iq-card text-center p-0" style="width:100%">
									<thead>
										<tr class="r1">
											<th><label>Name</label></th>
											<th><label>Image</label></th>
											<th><label>Action</label></th>
										</tr>
									</thead>
									<tbody>
										@foreach($allAlbums as $album)
										<tr>
											<td>{{ $album->albumname }}</td>
											<td>
												@if($album->album)
												<img src="{{ URL::to('/public/uploads/albums/') . '/' . $album->album }}" width="50">
												@endif
											</td>
											<td class="list-user-action">
												<a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit" 
												href="{{ URL::to('/admin/audios/albums/edit/') }}/{{ $album->id }}" class="edit">
												<img class="ply" src="{{ URL::to('/') . '/assets/img/icon/edit.svg' }}">
												</a> 
												<a href="{{ URL::to('/admin/audios/albums/delete/') }}/{{ $album->id }}" 
												onclick="return confirm('Are you sure?')" class="iq-bg-danger" data-toggle="tooltip" 
												data-placement="top" title="Delete">
												<img class="ply" src="{{ URL::to('/') . '/assets/img/icon/delete.svg' }}">
												</a>
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

		<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />

		<!-- Add New Modal -->
		<div class="modal fade" id="add-new">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">New Audio Albums</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form id="new-cat-form" action="{{ URL::to('admin/audios/albums/store') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label>Name:</label>
								<input type="text" id="albumname" name="albumname" class="form-control" placeholder="Enter Name">
							</div>
							<div class="form-group add-profile-pic">
								<label>Cover Image:</label>
								<input id="f02" type="file" name="album" />
								<p class="padding-top-20">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
							</div>
							<div class="form-group">
								<label>Slug:</label>
								<input type="text" id="slug" name="slug" class="form-control" placeholder="Enter Slug">
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
	</div>

	@section('javascript')
		<script src="{{ URL::to('/assets/admin/js/jquery.nestable.js') }}"></script>
		<script>
			$(document).ready(function() {
				if ($.fn.DataTable.isDataTable('#audioAlbumsTable')) {
					$('#audioAlbumsTable').DataTable().destroy();
				}
				$('#audioAlbumsTable').DataTable({
					order: [],
					destroy: true
				});

				setTimeout(function() {
					$('#successMessage').fadeOut('fast');
				}, 3000);

				$('#submit-new-cat').click(function() {
					$('#new-cat-form').submit();
				});
			});
		</script>
	@stop
@stop