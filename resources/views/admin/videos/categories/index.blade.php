@extends('admin.master')
<style type="text/css">
	/* .has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    } */

</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>


    <style>
        /* .footer {
            position: fixed;
            left: 0; 
            bottom: 0;
            width: 100%;
            background-color: #9C27B0;
            color: white;
            text-align: center;
        }

        body {
            background-color: #EDF7EF
        } */

    </style>

@endsection
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
	<div class="admin-section-title">
	<button class="" id='Video_Category'>Video Categories</button>
  		<button id='Age_Category'>Age Category</button>
         <div class="iq-card">
			<div class="Video_Category">

		<div class="row">
			<div class="col-md-6">

				<h4><i class="entypo-archive"></i> Video Categories</h4>
			</div>
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
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/categories/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				      
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
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Display In Home page:</label>
                        <input type="radio" id="in_home" name="in_home" value="1">Yes
                        <input type="radio" id="in_home" name="in_home" value="0">No
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
                        
                             <div class="modal-footer form-group">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                            </div>
				    </form>
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
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

                            <table class="table table-bordered" id="categorytbl">
                                <tr class="table-header">
                                    <th><label>Category Image</label></th>
                                    <th><label>Video Category Name</label></th>
                                    <th><label>Operation</label></th>
                                </tr>
                                    @foreach($allCategories as $category)
                                    <tr id="{{ $category->id }}">
                                    	<td valign="bottom" class=""><img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $category->image }}" width="50" height="50"></td>
                                        <td valign="bottom"><p>{{ $category->name }}</p></td>
                                        <td>
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Edit" href="{{ URL::to('admin/videos/categories/edit/') }}/{{$category->id}}" ><i class="ri-pencil-line"></i></a> 
                                            <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Delete" href="{{ URL::to('admin/videos/categories/delete/') }}/{{$category->id}}" ><i
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
	</div>
	<div class="Age_Category">
	<div class="row">
			<div class="col-md-6">

				<h4><i class="entypo-archive"></i> Age Categories</h4>
			</div>
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-news').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-news">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">New Age Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/age/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				        <div class="form-group">
                        <label>AGE :</label>
                        <input type="text" id="age" name="age" value="" class="form-control" placeholder="Enter Age">
                    </div>

                    <div class="form-group ">
                        <label>Slug:</label>
                        <input type="text" id="slug" name="slug" value="" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>  
                    <!-- <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Display In Home page:</label>
                        <input type="radio" id="in_home" name="in_home" value="1">Yes
                        <input type="radio" id="in_home" name="in_home" value="0">No
                    </div> -->

                    <!-- <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label>Image:</label>
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />
                    </div> -->

                        <!-- <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
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
                        </div> -->
                        
                             <div class="modal-footer form-group">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                            </div>
				    </form>
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
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

                            <table class="table table-bordered" id="categorytbl">
                                <tr class="table-header">
                                    <th><label>#</label></th>
                                    <th><label>Age Category Name</label></th>
                                    <th><label>Age Slug Name</label></th>
                                    <th><label>Operation</label></th>
                                </tr>
                                    @foreach($ageCategories as $category)
                                    <tr>
									<td>{{ $category->id }}</td>

                                        <td>{{ $category->age }}</td>
                                        <td>{{ $category->slug }}</td>

                                        <td>
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Edit" href="{{ URL::to('admin/age/edit/') }}/{{$category->id}}" ><i class="ri-pencil-line"></i></a> 
                                           
															 <a data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ URL::to('admin/age/delete/') }}/{{$category->id}}" title="Delete Project">
                    <i class="fas fa-trash text-danger  fa-lg"></i>
                </a>

<!-- small modal -->
<div class="modal fade" id="smallModal"  tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="sample">
            <div class="modal-header" id="demo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // display a modal (small modal)
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            }
            , complete: function() {
                $('#loader').hide();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

</script>


				
															</div>

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
	</div>
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


			$(document).ready(function(){
				$('.Age_Category').hide();

				$('#Video_Category').click(function(){
					$('.Age_Category').hide();
					$('.Video_Category').toggle();
				});
				$('#Age_Category').click(function(){
					$('.Video_Category').hide();
					$('.Age_Category').toggle();
				});
			});
		</script>
	@stop

@stop