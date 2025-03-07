@extends('admin.master')

@include('admin.favicon')

@section('css')

<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


@section('content')

    <div id="content-page" class="content-page">
        <div class="iq-card" id="file_log_data">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title p-0">
                    <h4>Upload Activity Lists</h4>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                    {{-- <th scope="col">#</th> --}}
                    <th scope="col">Source Type</th>
                    <th scope="col">Source Title</th>
                    <th scope="col">User Id</th>
                    <th scope="col">Message</th>
                    <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $data )
                        <tr>
                            <td>{{ $data->socure_type }}</td>
                            <td>
                                <span data-bs-toggle="tooltip" title="{{ $data->socure_title }}">
                                    {{ \Illuminate\Support\Str::limit($data->socure_title, 17) }}
                                </span>
                            </td>
                            <td>{{ $data->user_id }}</td>
                            <td>
                                <span data-bs-toggle="tooltip" title="{{ $data->error_message }}">
                                    {{ \Illuminate\Support\Str::limit($data->error_message, 17) }}
                                </span>
                            </td>
                            <td>{{ $data->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                        <!-- Pagination Links -->
            <div class="d-flex justify-content-end">
                {{ $datas->links() }}
            </div>
        </div> 
    </div> 
@stop

<style>
    #file_log_data thead {background-color: #e4ecfe;}
    #file_log_data .table thead th {font-size: 13px;}
    .table td, .table th{text-align: center;}
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
