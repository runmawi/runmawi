@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
@section('content')
   <script src="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"></script>
   <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
   <script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Transaction Details</h4>
                            </div>

                            <div class="iq-card-header-toolbar d-flex align-items-baseline">
                                <div class="form-group mr-2">
                                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body table-responsive p-0">
                            <div class="table-view">
                                <table class="data-tables table table-striped table-bordered iq-card text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Phone</th>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Transaction Type</th>
                                            <th>Transaction Date</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paginatedTransactions as $i => $transaction)
                                        @if($transaction)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                @if($transaction->user)
                                                <td>{{ $transaction->user->mobile }}</td>
                                                @else
                                                <td>-</td>
                                                @endif
                                               
                                                <td>{{ $transaction->payment_id ? $transaction->payment_id : 'N/A' }}</td>
                                               
                                                @if ($transaction->transaction_type == 'Subscription')
                                                    <td>{{ $transaction->price ? $transaction->price : 'N/A' }}</td>
                                                @else
                                                <td>{{ $transaction->total_amount ? $transaction->total_amount : 'N/A' }}</td>
                                                @endif
                                                <td>{{ $transaction->transaction_type }}</td>
                                                <td> {{ $transaction->created_at ? $transaction->created_at->format('M d, Y H:i A') : '-' }}</td>
                                                <td>
                                                    <a class="iq-bg-warning pt-1" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="View" href="{{ route('admin.transaction-details.show', $transaction->unique_id) }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>

                                                    @if($transaction->created_at == $transaction->updated_at)
                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit"  href="{{ route('admin.transaction-details.edit', $transaction->unique_id) }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5">No valid transaction data available</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
		                        <div style="position: relative;top: -50px;" class="pagination-outter mt-3 pull-right"><?= $paginatedTransactions->appends(Request::only('s'))->render(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {

            $('#transaction_detials').DataTable();

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ URL::to('/live_search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script> --}}
    <script>
        $(document).ready(function(){
             $('#DataTables_Table_0_paginate').hide();
         });
     </script>
@stop
