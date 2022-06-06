<!-- Page Create on 01/06/2022 -->


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
                    <h4 class="card-title">Player Video Analytics :</h4>
                </div>
            </div>
             

                <div class="clear"></div>

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
                       <label for="">Concurrent Viewers : </label> <span  class="btn btn-default" >{{ $UserLogs_count }}</span>
                        <!--btn btn-success btn-sm-->
                    </div>
                </div>

                <div class="clear"></div>
                            <br>
                <br>

                <h4 class="card-title">Player Video Graph :</h4>
                
                <div class="row">
                    <div class="col-md-6">
                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                 </div>
                </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="player_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <!-- <th>User Name</th> -->
                                            <th>User Name</th>
                                            <th>Viewed Count</th>
                                            <th>Watch Percentage (Minutes)</th>
                                            <th>Seek Time (Seconds)</th>
                                            <th>Buffered Time (Seconds)</th>

                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($player_videos as $key => $playervideo)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $playervideo->username  }}</td>   
                                        <!-- <td>{{ $playervideo->title  }}</td>    -->
                                        <td>{{ $playervideo->count  }}</td>   
                                        <td>{{ $playervideo->watchpercentage  }}</td>   
                                        <td>{{ $playervideo->seekTime  }}</td>   
                                        <td>@if(!empty($playervideo->bufferedTime)){{ $playervideo->bufferedTime  }} @else {{ 'No Buffer' }} @endif</td>   
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
    
@stop
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
         $(document).ready(function(){
            $('#player_table').DataTable();
         });
</script>


<script type="text/javascript">
         $(document).ready(function(){


        var start_time =  $('#start_time').val();
        var end_time =  $('#end_time').val();

        $('#start_time').change(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            // alert(start_time);
            var url = "{{ URL::to('admin/analytics/playerusers_start_date_url')  }}";
       
       if(start_time != "" && end_time == ""){
        // alert(start_time);

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

                    $('tbody').html(value.table_data);
                    $('#player_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_Revenue;
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
        var url = "{{ URL::to('admin/analytics/playerusers_end_date_url')  }}";

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
                    $('tbody').html(value.table_data);
                    $('#total_views').text(value.views_count);  
                    $('#player_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_Revenue;
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



    var player_videos_count = '<?= $player_videos_count ?>';

        if(player_videos_count > 0){
        // alert(player_videos_count);

            // ('#google-line-chart').hide();
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Player Videos'],

                @php
                foreach($player_videos as $key => $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);

        var options = {
          title: 'Player Videos',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

          chart.draw(data, options);
    }
}else{

}

    </script>

    