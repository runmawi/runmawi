@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 


@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="col-md-12">
                <div class="iq-card-header  justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Users Analytics :</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_time">  Start Date: </label>
                                <input type="date" id="start_time" name="start_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">
                            </div>

                            <div class="col-md-6">
                                <label for="end_time">  End Date: </label>
                                <input type="date" id="end_time" name="end_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">
                            </div>
                            <div class="col-md-6 mt-4 pl-0">
                                <span  id="export" class="btn btn-primary btn-sm" >Export</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 contantlabel">
                        <label for="">Registered User : <?php if (!empty($data1['registered_count'])) {
                                echo $data1['registered_count'];
                            } else {
                                echo $data1['registered_count'];
                            } ?></label> <br>
                            <label for="">Subscribed User : <?php if (!empty($data1['subscription_count'])) {
                                echo $data1['subscription_count'];
                            } else {
                                echo $data1['subscription_count'];
                            } ?></label><br>
                            <label for="">Admin Users : <?php if (!empty($data1['admin_count'])) {
                                echo $data1['admin_count'];
                            } else {
                                echo $data1['admin_count'];
                            } ?></label><br>
                            <label for="">PPV Users : <?php if (!empty($data1['ppvuser_count'])) {
                                echo $data1['ppvuser_count'];
                            } else {
                                echo $data1['ppvuser_count'];
                            } ?>
                        </label>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <select class="form-control"  id="role" name="role">
                            <option value="" >Choose Users</option>
                            <option value="registered" >Registered Users </option>
                            <option value="subscriber">Subscriber</option>     
                            <option value="admin" >Admin</option>
                            <option value="ppv_users" >PPV Users</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <h5> User Count : <span id="user_tables"> </span></h5>
                    </div>
                </div>

                <div class="col-md-12">

                    <table class="table text-center movie_table" id="user_tabledss" style="width:100%">
                        <thead>
                            <tr class="r1">
                                <th>#</th>
                                <th>User</th>
                                <th>ACC Type</th>
                                <th>Country</th>
                                <th>Registered ON </th>
                                <th>DOB </th>
                                <th>Source</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($total_user as $key => $user)
                                    <td>{{ $key+1  }}</td>   
                                    <td>{{ $user->username  }}</td>   
                                    <td>@if($user->role == "registered") Registered User  @elseif($user->role == "subscriber") Subscribed User @endif</td>
                                    <td>{{ $user->countryname  }}</td>   
                                    <td>{{ $user->created_at }}</td> 
                                    <td>{{ $user->DOB }}</td> 
                                    <td>@if($user->provider == "google") Google User @elseif($user->provider == "facebook") Facebook User @else Web User @endif</td>
                                    <?php if ($user->active == 0)
                                    { ?>
                                    <td > <button class = "bg-warning user_active"><?php echo "InActive"; ?></button></td>
                                    <?php
                                    }
                                    elseif ($user->active == 1)
                                    { ?>
                                    <td > <button class = "bg-success user_active"><?php echo "Active"; ?></button></td>
                                    <?php   } ?> 
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                    <div class="col-md-8">
                        <figure class="highcharts-figure">
                            <div id="google-line-chart" style="width: 700px; height: 500px"></div>
                        </figure>
                    </div> 

            </div>
        </div>
    </div>

<input type="hidden" value="" id="chart_users">
<input type="hidden" id="exportCsv_url" value="<?php echo URL::to('/admin/exportCsv'); ?>">
<input type="hidden" id="start_date_url" value="<?php echo URL::to('/admin/start_date_url'); ?>">
<input type="hidden" id="end_date_url" value="<?php echo URL::to('/admin/end_date_url'); ?>">
<input type="hidden" id="listusers_url" value="<?php echo URL::to('/admin/list_users_url'); ?>">


<link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script>
    $(document).ready(function(){
        $('#user_tabledss').DataTable();
        var userTable = $('#user_tabledss').DataTable();


         // Role Change Event
         $('#role').change(function(){
            var role = $('#role').val();
            var url = $('#listusers_url').val();

            
            if(start_time && end_time) {
                updateTableDataBasedOnRole(url, role);
            }
        });

        function updateTableDataBasedOnRole(url, role) {
            $.post(url, { _token: '{{ csrf_token() }}',role }, function(value) {


                userTable.destroy();

                // Update the table body with the new data
                $('tbody').html(value.table_data);
                $('#user_tables').text(value.total_data);

                // Re-initialize the DataTable
                userTable = $('#user_tabledss').DataTable();

                // $('tbody').html(value.table_data);
                // $('#user_tables').text(value.total_data);
                // $('#user_tabledss').DataTable();
            });
        }


        // Start Date Change Event
        $('#start_time').change(function(){
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            var url = $('#start_date_url').val();

            if(start_time && !end_time) {
                updateTableAndChart(url, start_time, end_time);
            }
        });

        // End Date Change Event
        $('#end_time').change(function(){
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            var url = $('#end_date_url').val();

            if(start_time && end_time) {
                updateTableAndChart(url, start_time, end_time);
            }
        });

        // Export CSV
        $('#export').click(function(){
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            var url = $('#exportCsv_url').val();

            $.post(url, { _token: '{{ csrf_token() }}', start_time, end_time }, function(data){
                var link_url = `{{ URL::to('public/uploads/csv/') }}/${data}`;
                alert('Downloaded User CSV File');
                window.location.href = link_url;
            });
        });

        // Load chart on page load
        loadInitialChart();
    });

    function updateTableAndChart(url, start_time, end_time) {
        $.post(url, { _token: '{{ csrf_token() }}', start_time, end_time }, function(value) {
            $('tbody').html(value.table_data);
            $('#user_tables').text(value.total_data);
            $('#user_tabledss').DataTable();
            drawChart(value.total_users);
        });
    }

    function loadInitialChart() {
        @php $total_user = $data['total_user']; @endphp
        var initialData = [
            ['Month Name', 'Register Users Count'],
            @foreach($total_user as $d)
                ["{{ $d->month_name }}", {{ $d->count }}],
            @endforeach
        ];

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(function() {
            drawChart(initialData);
        });
    }

    function drawChart(chartData) {
        var data = google.visualization.arrayToDataTable(chartData);
        var options = {
            title: 'Register Users Month Wise',
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
        chart.draw(data, options);
    }
    
</script>