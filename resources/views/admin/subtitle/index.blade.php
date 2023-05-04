@extends('admin.master')
<style>
    .form-control{
        /*background-color: #fff!important;*/
    }
    .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>
@section('content')

<div id="content-page" class="content-page">      
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between align-items-baseline mb-4">
						<div class="iq-header-title">
							<h4 class="card-title">Subtitles</h4>
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
							<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Subtitle</a>
						</div>
					</div>
					<div class="iq-card-body p-0">

						<div id="nestable" class="nested-list dd with-margins p-0">
							<table class="data-tables table audio_table iq-card text-center p-0" style="width:100%">
                     		<thead>
                     			<tr class="r1">
                     				<th><label>#</label></th>
                     				<th><label>Language</label></th>
                     				<th><label>Short Code</label></th>
                     				<th><label>Action</label></th>
                     			</tr>
                     		</thead>
                     		<tbody>

								@foreach($subtitles as $key => $subtitle)
								<tr>
                     				<td>{{ $key+1 }}</td>
                     				<td>{{ $subtitle->language }}</td>
                     				<td>{{ $subtitle->short_code }}</td>
                     				<td class="list-user-action">
                                        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('/admin/subtitles/edit/') }}/{{ $subtitle->id }}" class="edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> 
                     				<a href="{{ URL::to('/admin/subtitles/delete/') }}/{{ $subtitle->id }}" onclick="return confirm('Are you sure?')"   class=" iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></td>
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
                    <h4 class="modal-title">New Subtitle</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>

				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/subtitles/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

						<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

							<label>Name:</label>

							<input type="text" id="language" name="language" value="" class="form-control" placeholder="Enter Language Name">
							@if ($errors->has('name'))
							<span class="text-red" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif

						</div>

						<div class="form-group">

							<label>Slug:</label>

							<input type="text" id="shortcode" name="shortcode" value="" class="form-control" placeholder="Enter Short Code">

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
    
  