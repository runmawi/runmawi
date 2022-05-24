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
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="admin-section-title">
        <div class="">
		<div class="row justify-content-start">
			<div class="col-md-8 d-flex justify-content-between">
				<h4><i class="entypo-list"></i> Menu Items</h4>
                <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
            <div class="col-md-8" align="right">
                
            </div>
            
		</div>
	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header d-flex ">
                    <h4 class="modal-title">New Menu Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/store') }}" method="post">
				        <label for="name">Enter the new menu item name below</label>
				        <input name="name" id="name" placeholder="Menu Item Name" class="form-control" value="" /><br />
				        <label for="url">Menu Item URL (ex. /site/url)</label>
				        <input name="url" id="url" placeholder="URL" class="form-control" value="" /><br />
				        <label for="dropdown">or Dropdown for:</label>
				        <div class="clear"></div>
				        <input type="radio" class="menu-dropdown-radio" name="type" value="none" checked="checked" /> None
				        <input type="radio" class="menu-dropdown-radio" name="type" value="videos" /> Video Categories 
                        <input type="radio" class="menu-dropdown-radio" name="type" value="audios" /> Audio Categories
				        <input type="radio" class="menu-dropdown-radio" name="type" value="posts" /> Post Categories
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-menu">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-menu">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		<div class="col-md-8 p-0">
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p class="p1">Organize the Menu Items below: (max of 3 levels)</p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="">
		
            <table id="table " class="table table-bordered iq-card text-center">
              <thead>
                <tr class="r1 ">
                  <th width="30px">#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach($menu as $menu_item)
    	            <tr class="row1" data-id="{{ $menu_item->id }}">
    	              <td class="pl-3"><i class="fa fa-sort"></i>{{ $menu_item->id }}</td>
    	              <td>{{ $menu_item->name }}</td>
                      <td><a href="{{ URL::to('/admin/menu/edit/') }}/{{ $menu_item->id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> <a href="{{ URL::to('/admin/menu/delete/') }}/{{ $menu_item->id }}"  class="iq-bg-danger ml-2" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></td>
<!-- </div> -->
    	            </tr>
                @endforeach
              </tbody>                  
            </table>
						
				</div>
		
			</div>
		
            </div></div></div></div></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	<?php if(isset($_GET['menu_first_level'])): ?>
		<input type="hidden" id="menu_first_level" value="1" />
	<?php endif; ?>

	@section('javascript')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript">
      $(function () {
        // $("#table").DataTable();

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
            url: "{{ url('admin/menu/update-order') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>
		<script src="{{ URL::to ('/assets/admin/js/jquery.nestable.js') }}"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			if($('#menu_first_level').val() == 1){
				console.log('yup!');
				toastr.warning('Should only be added as a top level menu item!', "Video Or Post Category Menu Item", opts);
			}

			$('#nestable').nestable({ maxDepth: 3 });

			$('#add-new .menu-dropdown-radio').change(function(){
				changeNewMenuDropdownRadio($(this));
			});

			// Add New Menu
			$('#submit-new-menu').click(function(){
				$('#new-menu-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-menu').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-menu .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this menu item?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
				if($('.video_post').parents('.dd-list').length > 1){
					console.log('show error');
					window.location = '/admin/menu?menu_first_level=true';
				} else {
					alert('test');
	    			$('.menu-panel').addClass('reloading');
	    			$.post('/admin/menu/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val() }, function(data){
	    				console.log(data);
	    				$('.menu-panel').removeClass('reloading');
	    			});

	    		}

			});


		});

		function changeNewMenuDropdownRadio(object){
			if($(object).val() == 'none'){
				$('#new-menu-form #url').removeAttr('disabled');
			} else {
				$('#new-menu-form #url').attr('disabled', 'disabled');
			}
		}

		</script>



	@stop

@stop