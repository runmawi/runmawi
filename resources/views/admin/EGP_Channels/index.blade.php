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
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ route('admin.EGP-Channel.index') }}"> {{ ucwords('All EGP Channel') }} </a>
            <a class="black"   href="{{ route('admin.EGP-Channel.create') }}"> {{ ucwords('Create EGP Channel') }} </a>
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
                            <h4><i class="entypo-archive"></i> EGP Channel Manage </h4>
                        </div>

                        <div class="col-md-6" align="right">
                            <a href="{{ route('admin.EGP-Channel.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="panel panel-primary category-panel" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                <p>Organize the EGP Channel below: </p>
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
                                        <th><label>EGP Channel Logo</label></th>
                                        <th><label>EGP Channel Name</label></th>
                                        <th><label>EGP Channel Image</label></th>
                                        <th><label>Operation</label></th>
                                    </tr>

                                    @foreach ($Admin_EGP_Channel as $key => $Admin_EGP_Channel_data )
                                        <tr id="{{ $Admin_EGP_Channel_data->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td valign="bottom"><img src="{{ $Admin_EGP_Channel_data->Logo_url }}" width="50" height="50"></td>
                                            <td>{{ $Admin_EGP_Channel_data->name }}</td>
                                            <td valign="bottom"><img src="{{ $Admin_EGP_Channel_data->image_url }}" width="50" height="50"></td>
                                            <td>
                                                <div class=" align-items-center list-user-action" style="display: inline !important;">
                                                    <a class="iq-bg-warning mt-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"
                                                        href="#">
                                                        <img class="ply" src="{{ URL::to('assets/img/icon/view.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit"
                                                            href="{{ route('admin.EGP-Channel.edit',$Admin_EGP_Channel_data->id) }}">
                                                        <img class="ply" src="{{ URL::to('/assets/img/icon/edit.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top"
                                                        title="" onclick="return confirm('Are you sure?')" data-original-title="Delete"
                                                        href="{{ route('admin.EGP-Channel.destroy',$Admin_EGP_Channel_data->id ) }}">
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
        </div>

    @section('javascript')

        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <script type="text/javascript">

        </script>
    @stop
@stop