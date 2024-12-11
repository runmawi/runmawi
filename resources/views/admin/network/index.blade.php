@extends('admin.master')

<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }

    .make-switch {
        z-index: 2;
    }

    #nestable1 .iq-card {
        padding: 15px;
        margin-bottom: 0 !important;
        box-shadow: none !important;
    }
    /* #nestable1 table td{padding: 0;} */

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
            <a class="black" href="{{ URL::to('admin/series-list') }}"> TV Shows List</a>
            <a class="black" href="{{ URL::to('admin/series/create') }}"> Add New TV Shows</a>
            <a class="black" href="{{ URL::to('admin/Series/Genre') }}">Manage TV Shows Genre</a>
            <a class="black"  style="background:#fafafa!important;color: #006AFF!important;" href="{{ route('admin.Network_index') }}">Manage TV Shows Network</a>
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
                            <h4><i class="entypo-archive"></i> TV Shows Networks</h4>
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
                                <p>Organize the Networks below: </p>
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
                                        <th><label>Networks Name</label></th>
                                        <th><label>Networks Image</label></th>
                                        <th><label>Series List</label></th>
                                        <th><label>Operation</label></th>
                                    </tr>

                                    @foreach ($Series_Network as $key => $network_data )
                                        <tr id="{{ $network_data->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $network_data->name }}</td>
                                            <td valign="bottom"><img src="{{ $network_data->image_url }}" width="50" height="50"></td>
                                            <td valign="bottom">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="{{'#SeriesList-'.$key}}">
                                                    Open
                                                </button>
                                            </td>

                                            <td>
                                                <div class=" align-items-center list-user-action" style="display: inline !important;">
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

            @foreach ($Series_Network as $key => $network_data )
                <div class="modal fade network-container" id="{{'SeriesList-'.$key}}" tabindex="-1" role="dialog" aria-labelledby="SeriesListTitle" aria-hidden="true" data-network-id="{{ $network_data->id }}">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Series List for {{ $network_data->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="nestable1" class="table table-bordered iq-card text-center">
                                    <table class="table table-bordered iq-card text-center" id="nerwork_series_order">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Series Name</th>
                                                <th>Series Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $order_no = 0;
                                            @endphp
                                            @foreach ($network_data->series as $series_key => $series)
                                                <tr data-id="{{ $series->id }}">
                                                    <td>{{ $order_no + 1 }}</td>
                                                    <td>{{ $series->title }}</td>
                                                    <td>
                                                        <img src="{{ URL::to('public/uploads/images/'.$series->player_image) }}" width="50" height="50">
                                                    </td>
                                                </tr>
                                                @php
                                                    $order_no = $order_no + 1
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" onClick="savenetworkOrder()" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


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

        <!-- network series order-->
        <script>
            $(function () {
                $(".network-container").each(function () {
                    const networkContainer = $(this); // Reference to the current network container

                    // Make the series list sortable for each network
                    networkContainer.find("#nerwork_series_order tbody").sortable({
                        cursor: "move",
                        axis: "y",
                        update: function (event, ui) {
                            let sortedData = [];
                            
                            // Collect the IDs of the sorted rows
                            networkContainer.find("#nerwork_series_order tbody tr").each(function () {
                                sortedData.push($(this).data("id"));
                            });

                            // Pass the sorted data and the current network container to the function
                            updateSeriesOrder(sortedData, networkContainer);
                        }
                    });
                });

                function updateSeriesOrder(data, element) {
                    const networkId = $(element).data('network-id'); // Get the network ID from the current container
                    console.log('network id: ' + networkId);

                    $.ajax({
                        url: '{{ route("admin.Network_series_order") }}',
                        type: 'POST',
                        data: {
                            position: data,
                            network_id: networkId,
                            _token: $('#_token').val()
                        },
                        success: function () {
                            // alert("Position changed successfully.");
                            // location.reload();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert("An error occurred.");
                        }
                    });
                }
            });


            function savenetworkOrder(){
                // alert('submit');
                location.reload();
            };

        </script>
    @stop
@stop