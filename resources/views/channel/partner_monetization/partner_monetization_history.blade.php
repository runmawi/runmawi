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
                                                {{ $monetizationSummary->partner_commission_sum ?? 0 }} {{$currencySymbol}} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-success">
                                            <h5 style="color: white !important">Payment Summary</h5>
                                        </div>
                                        <div class="card-body" style="background-color: white; color:black; ">
                                            <p><strong>Monetized Amount:</strong> {{ $totalAmountPaid }} {{$currencySymbol}} </p>
                                            <p><strong>Balance Amount:</strong> {{ $payment_details->balance_amount ?? 0 }} {{$currencySymbol}} 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-between bg-white py-4 mt-5 rounded">
                            <div class="col-md-4">
                                <label class="mb-1"> Start Date:</label>
                                <input type="date" id="start_date" name="start_date" value="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-1"> End Date:</label>
                                <input type="date" id="end_date" name="end_date" value="" class="form-control">
                            </div>
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                            <div class="col-md-2 mt-4">
                                <label class="mb-1"> </label>
                                <input style="" type="submit" class="btn btn-primary" id="Export"
                                    value="Download CSV" />
                            </div>
                        </div>

                        <div class="card my-4 ">
                            <div class="card-header bg-info text-white">
                                <h5 style="color: white !important">Payment History</h5>
                            </div>
                            <div class="card-body" style="background-color: white;">
                                <table class="table">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th>Month/Year</th>
                                            <th>Paid Amount</th>
                                            <th>Balance Amount</th>
                                            <th>Transaction ID</th>
                                            <th>Payment Method</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        @foreach ($payment_histories as $history)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($history->payment_date)->format('d F,Y') }}</td>
                                                <td>{{ $history->paid_amount }} {{$currencySymbol}} </td>
                                                <td>{{ $history->balance_amount }} {{$currencySymbol}} </td>
                                                <td>{{ $history->transaction_id ? $history->transaction_id : '-' }}</td>
                                                <td>{{ $history->payment_method == 0 ? 'Manual Payment' : 'Payment Gateway' }}
                                                </td>
                                                <td>
                                                    <button class="downloadPDF btn btn-warning text-white" data-id="{{ $history->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                                        </svg>
                                                    </button>
                                                </td>
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#Export').click(function() {
                var start_time = $('#start_date').val();
                var end_time = $('#end_date').val();
                var url = "{{ URL::to('channel/PartnerHistoryCSV') }}";
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_time: start_time,
                        end_time: end_time,

                    },
                    success: function(data) {
                        var Excel = data;
                        var Excel_url = "{{ URL::to('public/uploads/csv/') }}";
                        var link_url = Excel_url + '/' + Excel;
                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>'
                        );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                        location.href = link_url;
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.downloadPDF', function() {
                var partnerpaymentId = $(this).data('id');
                var url = "<?php echo url('channel/partner-invoice'); ?>/" + partnerpaymentId;
                $(this).blur();
                $(this).css('pointer-events', 'none');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        id: partnerpaymentId
                    },
                    xhrFields: {
                        responseType: 'text'
                    },
                    success: function(data, status, xhr) {
                        var byteCharacters = atob(data);
                        var byteArrays = [];
                        for (var offset = 0; offset < byteCharacters.length; offset += 1024) {
                            var slice = byteCharacters.slice(offset, offset + 1024);
                            var byteNumbers = new Array(slice.length);
                            for (var i = 0; i < slice.length; i++) {
                                byteNumbers[i] = slice.charCodeAt(i);
                            }
                            byteArrays.push(new Uint8Array(byteNumbers));
                        }
                        var blob = new Blob(byteArrays, {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "partner_invoice_" + new Date().toISOString().slice(0,
                            10) + ".pdf";
                        link.click();
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to download the PDF:", error);
                        alert("Failed to download the PDF.");
                    }
                });
            });
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@stop

<style>
    .btn-warning {
        background-color: #f0ad4e;
        color: #fff;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px; /* space between icon and text */
        transition: background-color 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #ec971f;
    }

    .btn-warning svg {
        fill: #fff;
    }
</style>