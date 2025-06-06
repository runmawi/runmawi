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
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"> EPG List</a>
            <a class="black" href="{{ route('admin.epg.create') }}"> Generate New EPG </a>
            <a class="black"  href="{{ route('admin.Channel.index') }}">EPG Channels List</a>
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
                            <h4><i class="entypo-archive"></i> {{ __('EPG') }}</h4>
                        </div>

                        <div class="col-md-6" align="right">
                            <a href="{{ route('admin.epg.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Generate New EPG </a>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="panel panel-primary category-panel" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                <p> Organize the EPG below: </p>
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>

                        <div class="gallery-env mt-2">
                            <table class="data-tables table iq-card text-center p-0" style="width:100%" id="epg_table">
                                <thead>
                                    <tr class="r1">
                                        <th>S.No</th>
                                        <th>Channel Name </th>
                                        <th>Start Date </th>
                                        <th>End Date </th>
                                        <th>Time Zone </th>
                                        <th>Operation</</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($EPG as $key => $epg_data )
                                        <tr id="{{ $epg_data->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $epg_data->channel_name }}</td>
                                            <td>{{ ($epg_data->epg_start_date) ? Carbon\Carbon::createFromFormat('Y-m-d', $epg_data->epg_start_date)->format('d-m-Y')  : '-' }}</td>
                                            <td>{{ $epg_data->epg_end_date ? Carbon\Carbon::createFromFormat('Y-m-d', $epg_data->epg_end_date)->format('d-m-Y')  : "-" }}</td>
                                            <td>{{ $epg_data->time_zone_id ?  App\TimeZone::where('id',$epg_data->time_zone_id)->pluck('time_zone')->first()  : "-" }}</td>

                                            <td>
                                                <div class=" align-items-center list-user-action" style="display: inline !important;">
                                                    
                                                    <a class="iq-bg-success" data-epg-url={{ URL::to('public/uploads/EPG-Channel/'.$epg_data->xml_file_name) }} onclick="Copy(this)"  >
                                                        <img class="ply" src="{{ URL::to('/assets/img/icon/links-line.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit"
                                                            href="{{ URL::to('public/uploads/EPG-Channel/'.$epg_data->xml_file_name) }}" download >
                                                        <img class="ply" src="{{ URL::to('/assets/img/icon/download-line.svg') }}">
                                                    </a>

                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit" 
                                                        href="{{ route('admin.download.json',[$epg_data->id]) }}">
                                                        <img class="ply" src="https://localhost/flicknexs/assets/img/json.svg">
                                                    </a>

                                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top"
                                                        title="" onclick="return confirm('Are you sure?')" data-original-title="Delete"
                                                        href="{{ route('admin.epg.delete',[$epg_data->id] ) }}">
                                                        <img class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
        </div>

    @section('javascript')

        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>

        <script type="text/javascript">
            
            $(document).ready(function() {

                $('#submit-new-cat').click(function() {
                    $('#new-cat-form').submit();
                });

                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            });

            $(document).ready( function () {
                $('#epg_table').DataTable();
            });

            function Copy(ele) {

                const url  = $(ele).attr('data-epg-url');
                navigator.clipboard.writeText(url);

            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 33%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 16%; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
                );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }
        </script>
    @stop
@stop