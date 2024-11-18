@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')

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




                        <h2>Edit {{ $transaction->transaction_type }}</h2>


                        @php
                            $isSubscription = strpos($transaction->unique_id, 'sub_') !== false;
                        @endphp

                        <form
                            action="{{ route('admin.transaction-details.update', ['unique_id' => $transaction->unique_id]) }}"
                            method="POST">
                            @csrf

                            <input type="hidden" name="unique_id" value="{{ $transaction->unique_id }}">

                            <div class="form-group">
                                <label for="transaction_type">Transaction Type</label>
                                <input type="text" class="form-control" id="transaction_type"
                                    value="{{ $transaction->transaction_type }}" readonly>
                            </div>

                            <!-- Payment Gateway -->
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID</label>
                                <input type="text" class="form-control" id="transaction_id" name="{{ $isSubscription ? 'stripe_id' : 'payment_id' }}"
                                    value="{{ $isSubscription ? $transaction->stripe_id :  $transaction->payment_id }}">
                            </div>


                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.transaction-details.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>


                        {{-- @dd($transaction); --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
@stop
