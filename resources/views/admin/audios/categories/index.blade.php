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
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@section('content')

<div id="content-page" class="content-page">
<div class="d-flex">
         <a class="black" href="{{ URL::to('admin/audios') }}">Audio List</a>
        <a class="black" href="{{ URL::to('admin/audios/create') }}">Add New Audio</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/audios/categories') }}">Manage Audio Categories</a>
             <a class="black" href="{{ URL::to('admin/audios/albums') }}">Manage Albums</a></div>
         <div class="container-fluid mt-4">
	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row justify-content-start">
			<div class="col-md-12 d-flex justify-content-between">
				<h4><i class="entypo-list"></i></h4>
               	<div>
				   <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary float-right"><i class="fa fa-plus-circle"></i> Add Audio category</a>
			   	</div>
			</div>
            <div class="col-md-8" align="right">
                
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
		
		<div class="col-md-12 p-0">
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<h4 class="card-title">Audio Category</h4>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="">
		
            <table id="table " class="table table-bordered iq-card text-center" >
              <thead>
                <tr class="r1 ">
                  <th width="30px">#</th>
				  <th><label>Image</label></th>
				  <th><label>Name</label></th>
				  <th><label>Active</label></th>
				  <th><label>Action</label></th>
                </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach($allCategories as $key => $category)
    	            <tr class="row1" data-id="{{ $category->id }}">
					<td class="pl-3"><i class="fa fa-sort"></i>{{ $key+1  }}</td>

					  <td><?php if($category->image != '') { ?><img src="{{ URL::to('/public/uploads/audios/') . '/'.$category->image }}" width="50"><?php }else{} ?></td>
    	              <td>{{ ucfirst($category->name) }}</td>
					  <td valign="bottom">
						<div class="mt-1">
							<label class="switch">
								<input name="active" class="active" id="{{ 'category_'.$category->id }}" type="checkbox" @if( $category->active == "1") checked  @endif data-category-id={{ $category->id }}  data-type="category" onchange="update_category(this)" >
								<span class="slider round"></span>
							</label>
						</div>
					</td>
                      <td>
					<a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" class="edit" href="{{ URL::to('admin/audios/categories/edit/') }}/{{$category->id}}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
					<a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/audios/categories/delete/') }}/{{$category->id}}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"  onclick="return confirm('Are you sure?')" ></a>
					</td>
    	            </tr>
                @endforeach
              </tbody>                  
            </table>
						
				</div>
		
			</div>
		
            </div></div></div></div></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />



	@section('javascript')

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
					url: "{{ url('admin/audio_category_active') }}",
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
            url: "{{ url('admin/audio_category_order') }}",
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
	
	{{-- validate --}}

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
				$('form[id="new-cat-form"]').validate({
					rules: {
					name : 'required',
					image : 'required',
					slug : 'required',
					},
					messages: {
					title: 'This field is required',
					image: 'This field is required',
					},
					submitHandler: function(form) {
					form.submit();
					}
				});

	</script>

	{{--End validate --}}

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



	@stop

@stop
