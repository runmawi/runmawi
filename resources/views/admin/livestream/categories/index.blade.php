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
    .p1{
        font-size: 12px;
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
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="content-page" class="content-page">
     <div class="d-flex">
                        <a class="black" href="{{ URL::to('admin/livestream') }}">All Live Stream</a>
                        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Stream</a>
                        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Stream For Approval</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Stream Categories</a></div>
            <div class="container-fluid p-0">
	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
				<h4><i class="entypo-archive"></i> Live Stream Categories</h4>
			</div>
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">New Live Stream Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/livestream/categories/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				        <!-- <label for="name">Enter the new category name below</label>
				        <input name="name" id="name" placeholder="Category Name" class="form-control" value="" /><br />
				        <label for="slug">URL slug (ex. videos/categories/slug-name)</label>
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
					<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
						<label>Display In Home page:</label>
						<input type="radio" checked id="in_menu"  id="in_menu" name="in_menu" value="1">Yes
						<input type="radio" id="in_menu" name="in_menu" value="0">No
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
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p class="p1">Organize the Categories below:</p> 
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

				


            <table class="table table-bordered iq-card text-center">
                <tr class="table-header r1">
                    <th><label>Video Category Name</label></th>
                    <th><label>Active</label></th>          
                    <th><label>Operation</label></th>
					<tbody id="tablecontents">
                    @foreach($allCategories as $category)
    	            <tr class="row1" data-id="{{ $category->id }}">
                        <td valign="bottom"><p>{{ $category->name }}</p></td>
                        <td valign="bottom">
                            <div class="mt-1">
                                <label class="switch">
                                    <input name="active" class="active" id="{{ 'category_'.$category->id }}" type="checkbox" @if( $category->in_menu == "1") checked  @endif data-category-id={{ $category->id }}  data-type="category" onchange="update_category(this)" >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="align-items-center list-user-action"><a href="{{ URL::to('admin/livestream/categories/edit/') }}/{{$category->id}}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> <a href="{{ URL::to('admin/livestream/categories/delete/') }}/{{$category->id}}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>" onclick="return confirm('Are you sure?')" ></a></div>
                           
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

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

    </div>
	@section('javascript')
	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    
    
	<script>
		function update_category(ele){

		var category_id = $(ele).attr('data-category-id');
		var status   = '#category_'+category_id;
		var category_Status = $(status).prop("checked");

		if(category_Status == true){
			var status  = '1';
			var check = confirm("Are you sure you want to active this Category?");  

		}else{
			var  status  = '0';
			var check = confirm("Are you sure you want to remove this Category?");  
		}


		if(check == true){ 

		$.ajax({
					type: "POST", 
					dataType: "json", 
					url: "{{ url('admin/livestream_category_active') }}",
						data: {
							_token  : "{{csrf_token()}}" ,
							category_id: category_id,
							status: status,
					},
					success: function(data) {
						if(data.message == 'true'){
							//  location.reload();
						}
						else if(data.message == 'false'){
							swal.fire({
							title: 'Oops', 
							text: 'Something went wrong!', 
							allowOutsideClick:false,
							icon: 'error',
							title: 'Oops...',
							}).then(function() {
								location.href = '{{ URL::to('admin/audios/categories') }}';
							});
						}
					},
				});
		}else if(check == false){
		$(status).prop('checked', true);

		}
		}
	</script>


	<script type="text/javascript">

      $(function () {
        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('admin/live_category_order') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response == 1) {
					alert('Position changed successfully.');
						location.reload();
                } else {
                  console.log(response);
                }
            }
          });
        }
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

	@stop

@stop