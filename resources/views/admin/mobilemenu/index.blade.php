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
                        <h4><i class="entypo-list"></i> Mobile Side Menu </h4>
                        <a href="javascript:;" onclick="jQuery('#add-new').modal('show');"  class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="col-md-8 p-0">
                    <div class="panel panel-primary menu-panel" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="p1">Organize the Mobile Sid Menu below: (max of 3 levels)</p>
                            </div>
                        </div>

                        <div class="">
                            <table id="table " class="table table-bordered iq-card text-center">
                                <thead>
                                    <tr class="r1">
                                        <th width="30px">#</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Short Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tablecontents">
                                    @foreach($MobileSideMenu as $SideMenu)
                                        <tr class="row1" data-id="{{ $SideMenu->id }}"> 

                                            <td class="pl-3"><i class="fa fa-sort"></i>{{ $SideMenu->id }}</td>
                                            <td>
                                                <img src="{{ $SideMenu->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt="">
                                            </td>
                                            <td>{{ $SideMenu->name }}</td> 

                                            <td>{{ $SideMenu->short_note }}</td> 

                                            <td> 

                                                <a href="{{ URL::to('/admin/mobile/side_menu_edit/') }}/{{ $SideMenu->id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>">
                                                </a>

                                                <a href="{{ URL::to('/admin/mobile/side_delete/') }}/{{ $SideMenu->id }}"  class="iq-bg-danger ml-2"
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
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


    <!-- Add New Modal -->

<div class="modal fade" id="add-new">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">New Mobile Side Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="new-mobilemenu-form" class="mobilemenu" accept-charset="UTF-8" action="{{url('admin/mobile/side_link_store')}}" method="post" enctype="multipart/form-data">

            <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                    <div class="form-group">
                        <label>Upload Icon Image:</label>
                        <input type="file" name="image" id="image" >
                    </div>

                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter the Name">
                    </div>

                    <div class="form-group">
                        <label>Short Note:</label>
                        <input type="text" id="short_note" name="short_note" value="" class="form-control" placeholder="Enter the Short Note">
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="submit-new-mobilemenu">Save changes</button>
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
                    url: "{{ url('admin/mobile/side_order_update') }}",
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
			$('#submit-new-mobilemenu').click(function(){
				$('#new-mobilemenu-form').submit();
			});

        // Validation 
            // $('form[id="new-mobilemenu-form"]').validate({
            //     rules: {
            //         footer_name: "required",
            //         footer_link: {
            //             required: true,
            //             // url: true
            //         }
            //     },
               
            //     submitHandler: function (form) {
            //         form.submit();
            //     },
            // });

    </script>

	@stop

@stop