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
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection
@section('content')
<div id="content-page" class="content-page">
    <div class="mt-5 d-flex">
                        <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                       <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
        <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
    </div>
    <div class="container-fluid p-0">
	   <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="entypo-archive"></i> Video Categories</h4>
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
                    </div>
                    
                    <div class="col-md-6" align="right">
                        <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                    </div>
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
                                <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/categories/store') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                                <div class="form-group">
                                    <label>Home Page Genre Name:</label>
                                    <input type="text" id="home_genre" name="home_genre" value="" class="form-control" placeholder="Enter Home Page Genre Name">
                                </div>  
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    <label>Display In Home page:</label>
                                    <input type="radio" checked id="in_home"  id="in_home" name="in_home" value="1">Yes
                                    <input type="radio" id="in_home" name="in_home" value="0">No
                                </div>
                                <!-- <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    <label>Display In Footer page:</label>
                                    <input type="radio" checked id="footer" name="footer" value="1">Yes
                                    <input type="radio" id="footer" name="footer" value="0">No
                                    <input type="radio" id="footer" name="footer" value="0">No
                                </div> -->
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    <label>Display In Menu :</label>
                                    <input type="radio" checked id="in_menu"  id="in_menu" name="in_menu" value="1">Yes
                                    <input type="radio" id="in_menu" name="in_menu" value="0">No
                                </div>
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image" id="image" required/>
                                    <span id="image-error" style="color:red; display:none;">Please upload an image.</span>
                                   
                                </div>

                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label>Banner Image:</label>
                                    <input type="file" multiple="true" class="form-control" name="banner_image" id="banner_image" />
                                </div>

                                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                                            <label>{{ ucwords('genre:')  }}</label>
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

                                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                        <label>Display In Home Banner:</label>
                                            <input type="checkbox" id="banner"  id="banner" name="banner" value="1">
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

	           <div class="clear"></div>
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p>Organize the Categories below: </p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

                            <table class="table table-bordered iq-card text-center" id="categorytbl">
                                <tr class="table-header r1">
                                    <th><label>Category Image</label></th>
                                    <th><label>Video Category Name</label></th>
                                    <th><label>Active</label></th>          
                                    <th><label>Operation</label></th>
                                </tr>
                                    @foreach($allCategories as $category)
                                    <tr id="{{ $category->id }}">
                                    	<td valign="bottom" class=""><img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $category->image }}" width="50" height="50"></td>
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
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Edit" href="{{ URL::to('admin/videos/categories/edit/') }}/{{$category->id}}" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> 
                                            <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
											onclick="return confirm('Are you sure?')"  data-original-title="Delete" href="{{ URL::to('admin/videos/categories/delete/') }}/{{$category->id}}" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></div>

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

    <script>
        function validateForm() {
            var imageInput = document.getElementById('image').value;
            if (!imageInput) {
                document.getElementById('image-error').style.display = 'inline';
                return false;
            }
            return true;
        }
    </script>
    
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
					url: "{{ url('admin/video_category_active') }}",
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
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		
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


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
$('form[id="new-cat-form"]').validate({
	rules: {
	  name : 'required',
	//   image : 'required',
      parent_id: {
                required: true
            }
	},
	messages: {
	  title: 'This field is required',
	//   image: 'This field is required',
      parent_id: {
                required: 'This field is required',
            }
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

</script>

@stop