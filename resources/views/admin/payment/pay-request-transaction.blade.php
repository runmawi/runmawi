@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <h4 class="card-title text-primary mb-4">Pay Request Transaction:</h4>

        <div class="iq-card-body table-responsive">
            <div class="table-view">
                <table id="payRequestTable" class="table table-striped table-bordered text-center table movie_table "
                    style="width:100%">
                    <thead>
                        <tr class="r1">
                            <th>S.No</th>
                            <th class="text-center">User ID</th>
                            <th>User Name</th>
                            <th>Source ID</th>
                            <th>Source Name</th>
                            <th>Source Type</th>
                            <th>Platform</th>
                            <th>Transform form</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Pay_Request_Transaction as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $data->user_id ?? 'N/A' }}</td>
                                <td>
                                    <img src="https://i.postimg.cc/FR5xjr4g/user.png" alt="User Icon" />
                                    {{ $data->username ?? 'N/A' }}
                                </td>
                                <td>{{ $data->source_id ? $data->source_id : 'N/A' }}</td>
                                <td>{{ $data->source_name ? $data->source_name : 'N/A' }}</td>
                                <td>{{ $data->source_type ? ucwords($data->source_type) : 'N/A' }}</td>
                                <td>{{ $data->platform ? ucwords($data->platform) : 'N/A' }}</td>
                                <td>{{ $data->transform_form ? ucwords($data->transform_form) : 'N/A' }}</td>
                                <td>{{ $data->currency_symbol . ' ' . number_format($data->amount, 2) }}</td>
                                <td>{{ $data->date ? $data->date : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function() {
        $('#payRequestTable').DataTable();
    });
</script>