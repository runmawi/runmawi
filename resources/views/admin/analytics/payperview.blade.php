<!-- Page Create on 08/03/2022 -->


@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">PayPerView Users Revenue :</h4>
                </div>

            </div>

                <div class="clear"></div>

                <!-- Start Date  End Date  Download CSV    (SET BY Sanjai Kumar) -->
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="start_time">  Start Date: </label>
                        <input type="date" id="start_time" name="start_time" >               
                    </div>

                    <div class="col-md-4">
                        <label for="start_time">  End Date: </label>
                        <input type="date" id="end_time" name="end_time">     
                    </div>

                    <div class="col-md-4">
                        <span  id="export" class="btn btn-success btn-sm" >Download CSV</span>
                    </div>
                </div>
                <div id="PayPerView_content">
                    
                <div class="row">
                    <div class="col-md-12">
                        <div id="google-line-chart" style="width: 700px; height: 500px"></div>
                    </div>
                </div>

                <div class="clear"></div>
                <br>
                <br>
                <!-- Graph Currency   (SET BY Sanjai Kumar) -->
                <div class="row">
                <div class="tab">
                <a href="{{ URL::to('admin/users/revenue/')  }}">
                <button class="tablinks"  id="openSubscription">Subscription</button>
                </a>
                <button class="tablinks" id="openPayPerView" >PayPer View</button>
                </div>
                </div>
            
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="cpp_revenue_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>User </th>
                                            <th>Transaction REF</th>
                                            <th>User Type</th>
                                            <th>Plan</th>
                                            <th>Content</th>
                                            <th>Price</th>
                                            <th>Country</th>
                                            <th>Date Time</th>
                                            <th>Source</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                @foreach($user_Revenue as $key => $user)
                                        <tr>
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $user->username  }}</td>   
                                        <td>@if(!empty($user->stripe_id))  {{ @$user->stripe_id }} @else No REF @endif</td>
                                        <td>{{ $user->role  }}</td>                                      
                                        <td>@if(!empty($user->plans_name))  {{ @$user->plans_name }} @else Registered @endif</td>
                                        <td> @if(!empty($user->audio_id) ){{ 'Audio' }}@elseif(!empty($user->video_id) ){{ 'Video' }}@elseif(!empty($user->live_id) ){{ 'Live' }}@else @endif
                                        <td>{{ $user->total_amount  }}</td>   
                                        <td>@if(@$user->phoneccode->phonecode == $user->ccode)  {{ @$user->phoneccode->country_name }} @else No Country Added @endif</td>
                                        <td>{{ $user->created_at  }}</td> 
                                        <td>@if(!empty($user->card_type))  {{ @$user->card_type }} @else No Transaction @endif</td>
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

    
@stop
<script>

$('#Subscription_content').hide();
   $('#PayPerView_content').show();
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#cpp_revenue_table').DataTable();
        $('#start_time').change(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url = "{{ URL::to('admin/payperview_start_date_url/')  }}";
       
       if(start_time != "" && end_time == ""){
            $.ajax({
                url: url,
                type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_time: start_time,
                        end_time: end_time,

                    },      
                    success: function(value){       
                    // console.log(value);

                    $('tbody').html(value.tabledata);
                    $('#cpp_revenue_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.ppv_Revenue;
                    var data = new google.visualization.DataTable(linechart);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Month');
                    data.addColumn('number', 'Users Count');

                    linechart.forEach(function (row) {
                        data.addRow([
                        row.month_name,
                        parseInt(row.count),
                        ]);
                    });
                    var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
                    chart.draw(data, {
                        // width: 400,
                        // height: 240
                    });
                    }
                }
            });
       }
    });
        $('#end_time').change(function(){
        var start_time =  $('#start_time').val();
        var end_time =  $('#end_time').val();
        var url = "{{ URL::to('admin/payperview_end_date_url/')  }}";

       if(start_time != "" && end_time != ""){
            $.ajax({
                url: url,
                type: "post",
                data: {
                      _token: '{{ csrf_token() }}',
                      start_time: start_time,
                      end_time: end_time,

                },      
                success: function(value){
                    console.log(value);
                    $('tbody').html(value.tabledata);
                    $('#cpp_revenue_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.ppv_Revenue;
                    var data = new google.visualization.DataTable(linechart);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Month');
                    data.addColumn('number', 'Users Count');

                    linechart.forEach(function (row) {
                        data.addRow([
                        row.month_name,
                        parseInt(row.count),
                        ]);
                    });
                    var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
                    chart.draw(data, {
                        // width: 400,
                        // height: 240
                    });
                }

               }
            });
        }
      });

     });


     
    /////////  Export ///////////////

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
          $('#export').click(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url =  $('#exportCsv_url').val();
        var url = "{{ URL::to('admin/payperview_exportCsv/')  }}";

            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(data){
                var Excel = data ;
                var Excel_url =  "{{ URL::to('public/uploads/csv/')  }}";
                var link_url = Excel_url+'/'+Excel;
                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>');
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);

                location.href = link_url;
            }
            });
        });
    });

</script>



<script type="text/javascript">

        // if(total_Revenue_count == 0){
        //     ('#google-line-chart').hide();
        // }
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'PayPer View Revenue'],

                @php
                foreach($ppv_Revenue as $key => $d) {
                    echo "['".$key."', ".$d."],";
                }
                @endphp
        ]);

        var options = {
          title: 'PayPer View Revenue',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

          chart.draw(data, options);
    }
    </script>

    