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
                    <h4>Episode Deleted Logs</h4>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                    {{-- <th scope="col">#</th> --}}
                    <th scope="col">Episode Id</th>
                    {{-- <th scope="col">Episode Title</th> --}}
                    <th scope="col">Series Id</th>
                    <th scope="col">Season Id</th>
                    <th scope="col">User Id</th>
                    <th scope="col">Deleted At</th>
                    <th scope="col">Pdf file</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $data )
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->series_id }}</td>
                            <td>{{ $data->season_id }}</td>
                            <td>{{ $data->user_id }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td>
                                <a href="{{ $data->pdf_path ? asset('public/deletedPDF/' . $data->pdf_path) : '#' }}" target="_blank">
                                   {{ $data->pdf_path ? "Click to view" : 'N/A'}}
                                </a>
                            </td>
                            
                            {{-- <td><a href="{{ $data->pdf_path ? URL::to('storage/app/public/deletedPDF/deleted_episodes/'.$data->pdf_path) : '#' }}">{{ "Click to view" }}</a></td> --}}
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
