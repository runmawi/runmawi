@extends('admin.master')

<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }

    .make-switch {
        z-index: 2;
    }

    .iq-card {
        padding: 15px;
    }

    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }

    .black:hover {
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
            <a class="black" href="{{ URL::to('admin/series-list') }}"> Series List</a>
            <a class="black" href="{{ URL::to('admin/series/create') }}"> Add New Series</a>
            <a class="black" href="{{ URL::to('admin/Series/Genre') }}">Manage Series Genre</a>
            <a class="black"  style="background:#fafafa!important;color: #006AFF!important;" href="{{ route('admin.Network_index') }}">Manage Series Network</a>
        </div>

        <div class="container-fluid p-0">
            <div class="admin-section-title">
                <div class="iq-card">
                    <div class="row">
                        <div class="col-md-12">
                            @if (Session::has('message'))
                                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4><i class="entypo-archive"></i> Series Network</h4>
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
                                    <h4 class="modal-title">{{ ucwords('New Series Network') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form id="new-cat-form" accept-charset="UTF-8" action="{{ route('admin.Network_store') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                                        <div class="form-group">
                                            <label>Name:</label>
                                            <input type="text" id="name" name="name"  class="form-control" placeholder="Enter Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Slug:</label>
                                            <input type="text" id="slug" name="slug" value="" class="form-control" placeholder="Enter Slug">
                                        </div>

                                        <div class="form-group">
                                            <label>Display In Menu :</label>
                                            <input type="radio" checked id="in_menu" id="in_menu" name="in_menu" value="1">Yes
                                            <input type="radio" id="in_menu" name="in_menu" value="0">No
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Display In Home :</label>
                                            <input type="radio" checked id="in_home" id="in_home" name="in_home" value="1">Yes
                                            <input type="radio" id="in_home" name="in_home" value="0">No
                                        </div>

                                        <div class="form-group ">
                                            <label>Display In Network List :</label>
                                            <input type="radio" name="network_list_active" value="1">Yes
                                            <input type="radio" name="network_list_active" value="0" checked>No
                                        </div>

                                        <div class="form-group">
                                            <label>Image:</label>
                                            <input type="file" multiple="true" class="form-control" name="image" id="image" />
                                        </div>

                                        <div class="form-group">
                                            <label>Banner Image:</label>
                                            <input type="file" multiple="true" class="form-control" name="banner_image" id="banner_image" />
                                        </div>

                                        <div class="form-group">
                                            <label>{{ ucwords('network:') }}</label>

                                            <select id="parent_id" name="parent_id" class="form-control">
                                                <option value="0">Select</option>
                                                @foreach ($Series_Network as $key => $rows)
                                                    <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                                                @endforeach
                                            </select>
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
                                <p>Organize the Network below: </p>
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div id="nestable" class="nested-list dd with-margins">
                                <table class="table table-bordered iq-card text-center" id="categorytbl">
                                    <tr class="table-header r1">
                                        <th><label>S.No</label></th>
                                        <th><label>Network Name</label></th>
                                        <th><label>Network Image</label></th>
                                        <th><label>Network Banner Image</label></th>
                                        <th><label>Operation</label></th>
                                    </tr>

                                    @foreach ($Series_Network as $key => $network_data )
                                        <tr id="{{ $network_data->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $network_data->name }}</td>
                                            <td valign="bottom"><img src="{{ $network_data->image_url }}" width="50" height="50"></td>
                                            <td valign="bottom"><img src="{{ $network_data->banner_image_url }}" width="50" height="50"></td>

                                            <td>
                                                <div class=" align-items-center list-user-action">
                                                    <a class="iq-bg-warning mt-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"
                                                        href="{{ URL::to('/series/category/'. $network_data->slug) }}">
                                                        <img class="ply" src="{{ URL::to('assets/img/icon/view.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit"
                                                            href="{{ route('admin.Network_edit',$network_data->id) }}">
                                                        <img class="ply" src="{{ URL::to('/assets/img/icon/edit.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top"
                                                        title="" onclick="return confirm('Are you sure?')" data-original-title="Delete"
                                                        href="{{ route('admin.Network_delete',$network_data->id ) }}">
                                                        <img class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}">
                                                    </a>
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

    @section('javascript')

        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

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
					url:'{{ route("admin.Network_order")}}',
                    type: 'post',
                    data: {
                        position: data,
                        _token: $('#_token').val()
                    },
                    success: function() {
                        alert('Position changed successfully.');
                        location.reload();
                    }
                })
            }
       
            $(document).ready(function() {

                $('#submit-new-cat').click(function() {
                    $('#new-cat-form').submit();
                });

                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            });

            $('form[id="new-cat-form"]').validate({
                rules: {
                    name: 'required',
                },
                messages: {
                    title: 'This field is required',
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        </script>
    @stop
@stop