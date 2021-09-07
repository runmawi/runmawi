


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
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/sliders/update') }}" method="post" enctype="multipart/form-data">
       
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label>Image:</label>
                        @if(!empty($categories[0]->slider))
                        <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $categories[0]->slider }}" class="movie-img" width="200"/>
                        @endif
                        <p>Select the movie image (1280x720 px or 16:9 ratio):</p> 
                        <input type="file" multiple="true" class="form-control" name="slider" id="slider" />                        

                    </div>
        
                       <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Target Link:</label>
                        <input type="text" multiple="true" class="form-control" name="link" id="link" value="<?php if( isset($categories[0]->link)) { echo $categories[0]->link;} ?>" />

                    </div>

                    <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Title:</label>
                        <input type="text" multiple="true" class="form-control" name="title" id="title" value="<?php if( isset($categories[0]->title)) { echo $categories[0]->title;} ?>" />
                    </div>
        
                    <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Status:</label>
                        <input type="radio" id="in_home" name="active" value="1" <?php if( $categories[0]->active == 1) { echo "checked";} ?>>Yes
                        <input type="radio" id="active" name="active" value="0" <?php if( $categories[0]->active == 0) { echo "checked";} ?>>No

                    </div>
        

        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        
        
        <div class="modal-footer form-group">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
	<a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/sliders') }}">Close</a>
	<button type="submit" class="btn btn-primary" id="submit-update-cat" action="{{ URL::to('admin/sliders/update') }}" >Update</button>
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