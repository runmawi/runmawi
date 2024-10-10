@extends('admin.master')

@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        .form-control {
            background: #fff !important;
        }

        .btn-danger:hover,
        .btn-danger.focus,
        .btn-danger:focus {
            background-color: var(--iq-danger) !important;
            border-color: var(--iq-danger) !important;
        }
    </style>
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h1 class="my-4">Monthly New User Statistics</h1>

            <div class="row ">
                <div class="col-md-12">
                    <div class="mb-4">
                        <label for="yearSelect">Select Year:</label>
                        <select id="yearSelect" class="form-control d-inline-block w-25">
                            @for ($i = now()->year; $i >= 2000; $i--)
                                <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <button id="filterBtn" class="btn btn-primary">Filter</button>
                        <button id="pastWeekBtn" class="btn btn-primary">Past Week</button>
                        <button id="Showoverall" class="btn btn-secondary">Show All</button>
                    </div>
                </div>

                <div class="col-sm-12 mt-4">
                    <div class="">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title"></div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-view">
                                <table class="table table-striped" id="userStatsTable">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>New Users</th>
                                            <th>Total Users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userStatistics as $stat)
                                            <tr>
                                                <td>{{ $stat['month'] }}</td>
                                                <td>{{ $stat['new_users'] }}</td>
                                                <td>{{ $stat['total_users'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <table class="table table-striped" id="pastWeekTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>New Users</th>
                                            <th>Total Users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pastUserStatisticsQuery as $Pastweek)
                                            <tr>
                                                <td>{{ $Pastweek['date'] }}</td>
                                                <td>{{ $Pastweek['new_users'] }}</td>
                                                <td>{{ $Pastweek['total_users'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pastWeekTable').hide();
            $('#Showoverall').hide();

            $('#filterBtn').click(function () {
                let selectedYear = $('#yearSelect').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('users.statistics.filter') }}", 
                    data: {
                        year: selectedYear
                    },
                    success: function (response) {
                        updateTable(response);
                    },
                    error: function (xhr) {
                        console.error("Error occurred:", xhr);
                    }
                });
            });

            $('#pastWeekBtn').click(function () {
                $('#userStatsTable').hide();
                $('#pastWeekTable').show();
                $('#Showoverall').show();
            });

            $('#Showoverall').click(function () {
                $('#pastWeekTable').hide();
                $('#userStatsTable').show();
                $('#Showoverall').hide();
            });

            function updateTable(response) {
                if (response.userStatistics.length > 0) {
                    let tableBody = '';
                    response.userStatistics.forEach(function (stat) {
                        tableBody += `<tr>
                            <td>${stat.month}</td>
                            <td>${stat.new_users}</td>
                            <td>${stat.total_users}</td>
                        </tr>`;
                    });
                    $('#userStatsTable tbody').html(tableBody);
                } else {
                    $('#userStatsTable tbody').html('<tr><td colspan="3">No data available for the selected year.</td></tr>');
                }
            }
        });
    </script>
@endsection
