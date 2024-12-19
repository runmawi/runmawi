@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')
    @php
        $isSubscription = strpos($transaction->unique_id, 'sub_') !== false;
    @endphp

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Transaction Details</h2>
                    <a href="{{ route('admin.transaction-details.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-secondary border-bottom pb-2 mb-3">Transaction Information</h5>
                    <p><strong>ID :</strong> {{ $transaction->id }}</p>
                    <p><strong>Transaction ID:</strong>
                        {{  $transaction->payment_id ?? 'N/A' }}
                    </p>
                    <p><strong>Transaction Type:</strong> {{ $transaction->transaction_type }}</p>
                    <p><strong>Payment Gateway:</strong>
                        {{ $isSubscription ? $transaction->PaymentGateway ?? 'N/A' : $transaction->payment_gateway ?? 'N/A' }}
                    </p>
                    <p><strong>Amount:</strong>
                        {{ currency_symbol() }}{{ $isSubscription ? $transaction->price ?? 'N/A' : $transaction->total_amount ?? 'N/A' }}
                    </p>
                    <p><strong>Created At:</strong>
                        {{ $transaction->created_at ? $transaction->created_at->format('M d, Y H:i A') : '-' }}</p>
                    <p><strong>Updated At:</strong>
                        {{ $transaction->updated_at ? $transaction->updated_at->format('M d, Y H:i A') : '-' }}</p>

                    @if ($isSubscription)
                        <p><strong>Days:</strong> {{ $transaction->days ?? '-' }}</p>
                        @if ($transaction->user)
                            <p><strong>Start Date:</strong> {{ $transaction->user->subscription_start ?? '-' }}</p>
                        @endif
                        @if ($transaction->user)
                            <p><strong>End date:</strong> {{ $transaction->user->subscription_ends_at ?? '-' }}</p>
                        @endif
                    @endif
                    @if (!$isSubscription)
                        @if ($transaction->video)
                            <p><strong>Video:</strong> {{ $transaction->video->title }}</p>
                            <p><strong>Resolution:</strong> {{ $transaction->ppv_plan ? $transaction->ppv_plan : '-' }}</p>
                            <p><strong>Type:</strong> Video</p>
                        @elseif($transaction->series)
                            <p><strong>Series:</strong> {{ $transaction->series->title }}</p>
                            <p><strong>Season:</strong> {{ $transaction->SeriesSeason->series_seasons_name }}</p>
                            <p><strong>Resolution:</strong> {{ $transaction->ppv_plan ? $transaction->ppv_plan : '-' }}</p>
                            <p><strong>Type:</strong> Season</p>
                        @elseif($transaction->livestream)
                            <p><strong>Video:</strong> {{ $transaction->livestream->title }}</p>
                            <p><strong>Resolution:</strong> {{ $transaction->ppv_plan ? $transaction->ppv_plan : '-' }}</p>
                            <p><strong>Type:</strong> Livestream</p>
                        @else
                            <p><strong>Video:</strong> -</p>
                            <p><strong>Type:</strong> -</p>
                        @endif
                    @endif
                </div>

                <div class="col-lg-6">
                    <h5 class="text-secondary border-bottom pb-2 mb-3">User Information</h5>
                    @if ($transaction->user)
                        <p><strong>Name:</strong> {{ $transaction->user->username }}</p>
                    @endif
                    @if ($transaction->user)
                        <p><strong>Email:</strong> {{ $transaction->user->email }}</p>
                    @endif
                    @if ($transaction->user)
                        <p><strong>Mobile:</strong> {{ $transaction->user->mobile }}</p>
                    @endif
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
