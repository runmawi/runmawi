@extends('admin.master')

<meta name="csrf-token" content="{{ csrf_token() }}">
   
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
                </div>

                <div class="clear"></div>

                <div class="col-md-8 p-0">
                    <div class="panel panel-primary menu-panel" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="p1">Organize the Menu Items below: (max of 3 levels)</p>
                            </div>
                        </div>

                        <div class="">
                            <table id="table " class="table table-bordered iq-card text-center">
                                <thead>
                                    <tr class="r1">
                                        <th width="30px">#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tablecontents">
                                    @foreach($FooterLink as $footermenu)
                                        <tr class="row1" data-id="{{ $footermenu->id }}"> 
                                            <td class="pl-3"><i class="fa fa-sort"></i>{{ $footermenu->id }}</td>
                                            <td>{{ $footermenu->name }}</td> 
                                            <td> 
                                                <a href="{{ URL::to('/admin/menu/edit/') }}/{{ $footermenu->id }}"  class="iq-bg-success" data-toggle="tooltip" 
                                                    data-placement="top" title="" data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>">
                                                </a> 
                                                <a href="{{ URL::to('/admin/menu/delete/') }}/{{ $footermenu->id }}"  class="iq-bg-danger ml-2"
                                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>">
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
</div>
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