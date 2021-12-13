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
		<div class="row">
			<div class="col-md-6">
				<h4><i class="entypo-archive"></i> Age Categories</h4>
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
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">New Video Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/age/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				      
				        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">



                    <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">

                        <label>Age:</label>

                        <input type="text" id="age" name="age" value="" class="form-control" placeholder="Enter Age">
                        @if ($errors->has('age'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('age') }}</strong>
                            </span>
                        @endif

                    </div>  
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Status:</label>
                        <input type="radio" id="active" name="active" value="1">Active
                        <input type="radio" id="active" name="active" value="0">In active
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
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p style="font-size:12px;">Organize the Categories below: </p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			<?php
            $i = 1;
            ?>
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

                            <table class="table table-bordered" id="categorytbl">
                                <tr class="table-header">
                                    <th><label>ID</label></th>
                                    <th><label>Age </label></th>
                                    <th><label>Age Slug Name</label></th>
                                    <th><label>Action</label></th>

                                </tr>
                                    @foreach($allCategories as $category)
                                    <td valign="bottom"><p>{{ $i++ }}</p></td>
                                    <td valign="bottom"><p>{{ $category->age }}</p></td>
                                        <td valign="bottom"><p>{{ $category->slug }}</p></td>
                                        <td>
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Edit" href="{{ URL::to('admin/age/edit/') }}/{{$category->id}}" ><i class="ri-pencil-line"></i></a> 
                                            <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
											onclick="return confirm('Are you sure?')"  data-original-title="Delete" href="{{ URL::to('admin/age/delete/') }}/{{$category->id}}" ><i
                                                                class="ri-delete-bin-line"></i></a></div>

                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
           
				
				</div>
		
			</div>
		
		</div>
    </div>
</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

    </div>
	@section('javascript')


		<script type="text/javascript">

		jQuery(document).ready(function($){

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

		


		});
		</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$("#categorytbl").sortable({
					items: 'tr:not(tr:first-child)',
					cursor: 'pointer',
					axis: 'y',
					dropOnEmpty: false,
					start: function (e, ui) {
						ui.item.addClass("selected");
					},
					stop: function (e, ui) {
						ui.item.removeClass("selected");
						var selectedData = new Array();
						$(this).find("tr").each(function (index) {
							if (index > 0) {
								$(this).find("td").eq(2).html(index);
								selectedData.push($(this).attr("id"));
							}
						});
						updateOrder(selectedData)
					}
				});
			});

			function updateOrder(data) {
				
				$.ajax({
					url:'<?= URL::to('admin/category_order');?>',
					type:'post',
					data:{position:data, _token : $('#_token').val()},
					success:function(){
						alert('Position changed successfully.');
						location.reload();
					}
				})
			}
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