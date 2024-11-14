@extends('admin.master')

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
                                <h4 class="card-title">Partner Payouts</h4>
                            </div>

                            <div class="iq-card-header-toolbar d-flex align-items-baseline">
                                <div class="form-group mr-2">
                                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body table-responsive p-0">
                            <div class="table-view">
                                <table class="table table-striped table-bordered table movie_table iq-card text-center"
                                    id="channeluser" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>Id</th>
                                            <th>Channel Name</th>
                                            <th>Total Views</th>
                                            <th>Total Payout</th>
                                            <th>Pay Commission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $user->channeluser->channel_name }}</td>
                                                <td>{{ $user->total_views_sum }}</td>
                                                <td>{{ $user->total_commission_sum }} {{ $currencySymbol }} </td>
                                                <td colspan="2">
                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top"
                                                        style="cursor: pointer;" data-original-title="View" id="viewButton"
                                                        data-id="{{ $user->channeluser->id }}" onclick="show(this)">
                                                        <img class="ply" src="<?php echo URL::to('/') . '/assets/img/icon/view.svg'; ?>">
                                                    </a>

                                                    <a class="iq-bg-success" data-placement="top"
                                                        href="{{ URL::to('admin/partner_monetization_payouts/partner_payment') . '/' . $user->channeluser->id }}"><img
                                                            class="ply" src="<?php echo URL::to('/') . '/assets/img/icon/edit.svg'; ?>"></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center;">
                                <th>#</th>
                                <th>Date of payment</th>
                                <th>Amount Paid</th>
                                <th>Entry Date/time</th>
                            </tr>
                        </thead>
                        <tbody id="modalContent"></tbody>
                    </table>
                    <div class="py-2">
                        <h6 id="summary"></h6>
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
@section('javascript')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function show(element) {
            const userId = element.getAttribute('data-id');
            $('#viewModal').modal('show');

            $.ajax({
                url: '{{ route('get.user.details', ':id') }}'.replace(':id', userId),
                method: 'GET',
                success: function(data) {


                    $('#viewModalLabel').html(`  
                     Channel ID : ${data.user_id}
                  `);
                    $('#modalContent').html(`
                  <tr style="text-align: center;">
                                    <td> 1. </td>
                                    <td> ${data.latest_payment_date}</td>
                                    <td> ${data.latest_paid_amount} ${data.currencySymbol} </td>
                                    <td> ${data.latest_payment_datetime}</td>
                  </tr>
               `);
                    $('#summary').html(`
                        <div style="padding:10px 0px;" >Total Amount Paid      :${data.total_paid} ${data.currencySymbol}</div>
                        <div style="padding:10px 0px;" >Balance Amount Payable   :${data.latest_balance_amount} ${data.currencySymbol}</div>
                        <div style="padding:10px 0px;" >Last Payment Was on   : ${data.latest_payment_date}</div>
                  `);
                },
                error: function(error) {
                    console.error('Error fetching user data:', error);
                    $('#modalContent').html('<p>Failed to load user details.</p>');
                }
            });
        }
    </script>

@stop

@stop
