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
                                <h4 class="card-title">Partner Monetization Analytics</h4>
                            </div>

                            <div class="iq-card-header-toolbar d-flex align-items-baseline">
                                <div class="form-group mr-2">
                                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-between bg-white py-4 rounded">
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
                                               
                        <div class="iq-card-body table-responsive pt-4">
                            <div class="table-view">
                                <table class="table table-striped table-bordered iq-card text-center" id="channeluser"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Content Title</th>
                                            <th>Content Type</th>
                                            <th>Views</th>
                                            <th>Monetized Amount</th>
                                            <th>Admin Commission</th>
                                            <th>Partner Commission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $user->title }}</td>
                                                <td>{{ $user->type }}</td>
                                                <td>{{ $user->total_views }}</td>
                                                <td>{{ $user->monetization_amount }} {{$currencySymbol}}</td>
                                                <td>{{ $user->admin_commission }} {{$currencySymbol}}</td>
                                                <td>{{ $user->partner_commission }} {{$currencySymbol}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clear"></div>
                            </div>
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
                var url = "{{ URL::to('channel/PartnerAnalyticsCSV') }}";
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


@stop
