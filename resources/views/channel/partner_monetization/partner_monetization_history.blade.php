@extends('channel.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Partner Monetization History</h4>
                            </div>

                            <div class="iq-card-header-toolbar d-flex align-items-baseline">
                                <div class="form-group mr-2">
                                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h5 style="color: white !important">Monetization Summary</h5>
                                        </div>
                                        <div class="card-body" style="background-color: white; color:black; ">
                                            <p><strong>Total Views:</strong>
                                                {{ $monetizationSummary->total_views_sum ?? 0 }}</p>
                                            <p><strong>Total Payout:</strong>
                                                {{ $monetizationSummary->partner_commission_sum ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-success">
                                            <h5 style="color: white !important">Payment Summary</h5>
                                        </div>
                                        <div class="card-body" style="background-color: white; color:black; ">
                                            <p><strong>Monetized Amount:</strong> {{ $totalAmountPaid }}</p>
                                            <p><strong>Balance Amount:</strong> {{ $payment_details->balance_amount ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card my-4 ">
                            <div class="card-header bg-info text-white">
                                <h5 style="color: white !important" >Payment History</h5>
                            </div>
                            <div class="card-body" style="background-color: white;" >
                                <table class="table">
                                    <thead style="text-align: center;" >
                                        <tr>
                                            <th>Month/Year</th>
                                            <th>Paid Amount</th>
                                            <th>Balance Amount</th>
                                            <th>Transaction ID</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        @foreach ($payment_histories as $history)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($history->payment_date)->format('F,Y') }}</td>
                                                <td>{{ $history->paid_amount }}</td>
                                                <td>{{ $history->balance_amount }}</td>
                                                <td>{{ $history->transaction_id ? $history->transaction_id : '-' }}</td>
                                                <td>{{ $history->payment_method == 0 ?  'Manual Payment' : 'Payment Gateway' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="float-right">
                            {{ $payment_histories->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#channeluser').DataTable();

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
    </script>
@stop
