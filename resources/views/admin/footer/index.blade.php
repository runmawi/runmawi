@extends('admin.master')

@include('admin.favicon')
   
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="content-page" class="content-page">
    <div class="container-fluid mt-4">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row justify-content-start">
                    <div class="col-md-8 d-flex justify-content-between">
                        <h4><i class="entypo-list"></i> Footer Menu</h4>
                        <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="col-md-8 p-0">
                    <div class="panel panel-primary menu-panel" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="p1">Organize the Footer Menu below: (max of 3 levels)</p>
                            </div>
                        </div>

                        <div class="">
                            <table id="table " class="table table-bordered iq-card text-center">
                                <thead>
                                    <tr class="r1">
                                        <th width="30px">#</th>
                                        <th>Name</th>
                                        <th>Column Position</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tablecontents">
                                    @foreach($FooterLink as $footermenu)
                                        <tr class="row1" data-id="{{ $footermenu->id }}"> 

                                            <td class="pl-3"><i class="fa fa-sort"></i>{{ $footermenu->id }}</td>

                                            <td>{{ $footermenu->name }}</td> 

                                            <td>{{ 'Column '.$footermenu->column_position }}</td> 

                                            <td valign="bottom">
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input name="active" class="active" id="{{ 'menu_'.$footermenu->id }}" type="checkbox" @if( $footermenu->active == "1") checked  @endif data-menu-id={{ $footermenu->id }}  data-type="menu" onchange="update_menu(this)" >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </td>

                                            <td> 

                                                <a href="{{ URL::to('/admin/footer_menu_edit/') }}/{{ $footermenu->id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>">
                                                </a>

                                                <a href="{{ URL::to('/admin/footer_delete/') }}/{{ $footermenu->id }}"  class="iq-bg-danger ml-2"
                                                    data-toggle="tooltip"  onclick="return confirm('Are you sure?')" data-placement="top" title="" data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>">
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


    <!-- Add New Modal -->

<div class="modal fade" id="add-new">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">New Footer Link</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="new-footer-form" class="footer" accept-charset="UTF-8" action="{{url('admin/footer_link_store')}}" method="post" enctype="multipart/form-data">

            <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" id="footer_name" name="footer_name" value="" class="form-control" placeholder="Enter the Name">
                    </div>

                    <div class="form-group">
                        <label>Url Type:</label>
                        <select name="url_type" id="url_type" class="form-control">
                            <option value=""> Select the type</option>
                            <option value="base_url"> Base Url</option>
                            <option value="custom_url"> Custome Url</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Link:</label>
                        <input type="text" id="footer_link" name="footer_link" value="" class="form-control" placeholder="Enter the Link">
                    </div>

                    <div class="form-group">
                        <label>Column position :</label>
                        
                        <select name="column_position" id="column_position" class="form-control">
                            <option value=""  > Select the Position</option>
                            <option value="1" > Column 1</option>
                            <option value="2" > Column 2</option>
                            <option value="3" > Column 3</option>
                            {{-- <option value="4" > Column 4</option> --}}
                          </select>
                    
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="submit-new-footer">Save changes</button>
            </div>
        </form>

        </div>
    </div>
</div>


<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

@section('javascript')
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>


        
	
	<script>
		function update_menu(ele){

		var active = $(ele).attr('data-menu-id');
		var status   = '#menu_'+active;
		var menu_Status = $(status).prop("checked");
		if(menu_Status == true){
			var status  = '1';
			var check = confirm("Are you sure you want to active this Menu?");  

		}else{
			var  status  = '0';
			var check = confirm("Are you sure you want to remove this Menu?");  
		}


		if(check == true){ 

		$.ajax({
					type: "POST", 
					dataType: "json", 
					url: "{{ url('admin/footer_menu_active') }}",
						data: {
							_token  : "{{csrf_token()}}" ,
							active: active,
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
		$(status).prop('checked', !menu_Status);

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
                    url: "{{ url('admin/footer_order_update') }}",
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

        // Add New Menu
			$('#submit-new-footer').click(function(){
				$('#new-footer-form').submit();
			});

        // Validation 
            $('form[id="new-footer-form"]').validate({
                rules: {
                    footer_name: "required",
                    column_position: "required",
                    footer_link: {
                        required: true,
                        // url: true
                    }
                },
               
                submitHandler: function (form) {
                    form.submit();
                },
            });

    </script>

	@stop

@stop