<!-- Page Create on 04/04/2022 -->


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
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Content Partners Analytics :</h4>
                </div>

                <br>
                <br>

                <div class="clear"></div>

                <div class="row">
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

                <div class="clear"></div>
                <br>
                <br>
                <h4 class="card-title">Content Partners Content </h4>

                <div class="row">
                    <div class="col-md-6">
                        <label for="">Total No. Of Video Content : 
                        <?php 
                            if (!empty($total_video_content))
                            {
                                echo $total_video_content;
                            }
                            else
                            {
                                echo $total_video_content;
                            } 
                        ?>
                    </label> <br>
                    <label for="">Total No. Of Live Video Content : 
                        <?php 
                            if (!empty($total_live_streams_content))
                            {
                                echo $total_live_streams_content;
                            }
                            else
                            {
                                echo $total_live_streams_content;
                            } 
                        ?>
                    </label> <br>
                    <label for="">Total No. Of Audio Content : 
                        <?php 
                            if (!empty($total_audio_content))
                            {
                                echo $total_audio_content;
                            }
                            else
                            {
                                echo $total_audio_content;
                            } 
                        ?>
                    </label> <br>
                </div>
                <div class="col-md-6" >
                <p style="color: black;"><input type="radio" value="total_content_users"  id="total_content_users"  checked name="content_users"> Total Content By Users</p> 
                 <br>
                 <p style="color: black;"><input type="radio" value="filter_content"  id="filter_content"  name="content_users" > Filtered Content By Users </p>
                </div>
                </div>
                <br>
                <br>

                <h4 class="card-title">Content View Through Graph :</h4>
                
                <div class="row">
                    <div class="col-md-8">
                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                    <!-- <div id="google-line-chart" style="width: 900px; height: 500px"></div>   -->
                    <!-- <div id="top_x_div" style="width: 900px; height: 500px;"></div> -->
                    <div id="barchart_material" style="width: 900px; height: 500px;"></div>

                 </div>
                 <div class="col-md-4" >
                 <!-- <input type="radio" value="total_content_users" checked name="content_users">Total Content By Users
                 <br>
                 <input type="radio" value="filter_content"  name="content_users"> Filtered Content By Users -->
                 </div>
                </div>
            

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="cpp_analytics_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Email</th>
                                            <th>Uploader Name</th>
                                            <th>No Of Uploads</th>
                                            <th>Total Views</th>
                                            <th>Total Comments</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($total_content as $key => $user)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $user->email  }}</td>   
                                        <td>{{ $user->username  }}</td>   
                                        <td>{{ $user->count  }}</td>   
                                        <?php if (!empty($user->videos_views) && !empty($user->audio_count))
                                        { ?>
                                        <td ><?php echo $user->videos_views + $user->audio_count; ?></td>
                                        <?php
                                        }
                                        elseif (!empty($user->videos_views) && empty($user->audio_count))
                                        { ?>
                                        <td > <?php echo $user->videos_views; ?></td>

                                        <?php   }  elseif (empty($user->videos_views) && !empty($user->audio_count))
                                        { ?>
                                        <td > <?php echo $user->audio_count; ?></td>
                                        <?php   } ?> 
                                        <td>{{ $user->count }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    
@stop
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#google-line-chart').show();
        $('#barchart_material').hide();

        $('#filter_content').click(function(){
            var Audio = "{{ $total_audio_content }}" ;
            var Video = "{{ $total_video_content }}" ;
            var LiveStream = "{{ $total_live_streams_content }}" ;
            $('#google-line-chart').hide();
            $('#barchart_material').show();
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url = "{{ URL::to('admin/cpp_analytics_barchart/')  }}";

            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(value){
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    console.log(value)

                    function drawChart(data) {
                        var Audio = value.total_audio_content ;
                        var Video =  value.total_video_content ;
                        var LiveStream = value.total_live_streams_content ;

                        var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Users Uploded Content');
                            data.addColumn('number', 'Uploded Count');

                        data.addRows([
                            [ 'Audio', parseInt(Audio)],
                            [ 'Video', parseInt(Video)],
                            [ 'Live Stream', parseInt(LiveStream)],
                        ]);

                        var options = {
                            title: 'Content Partners Uploded Content',
                            hAxis: {
                            title: 'Time of Day',
                            //   format: 'h:mm a',
                            viewWindow: {
                                // min: [7, 30, 0],
                                // max: [17, 30, 0]
                            }
                            },
                            vAxis: {
                            title: 'Rating (scale of 1-10)'
                            }
                        };

                        var chart = new google.visualization.ColumnChart(
                            document.getElementById('barchart_material'));

                        chart.draw(data, options);
                        }
      
            }
            });


            $('#start_time').change(function(){
                if($('#filter_content').val() == 'filter_content'){
                    var start_time =  $('#start_time').val();
                    var end_time =  $('#end_time').val();
                    var url = "{{ URL::to('admin/cpp_analytics_barchart/')  }}";
            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(value){
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    console.log(value)

                    function drawChart(data) {
                        var Audio = value.total_audio_content ;
                        var Video =  value.total_video_content ;
                        var LiveStream = value.total_live_streams_content ;

                        var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Users Uploded Content');
                            data.addColumn('number', 'Uploded Count');

                        data.addRows([
                            [ 'Audio', parseInt(Audio)],
                            [ 'Video', parseInt(Video)],
                            [ 'Live Stream', parseInt(LiveStream)],
                        ]);

                        var options = {
                            title: 'Content Partners Uploded Content',
                            hAxis: {
                            title: 'Time of Day',
                            //   format: 'h:mm a',
                            viewWindow: {
                                // min: [7, 30, 0],
                                // max: [17, 30, 0]
                            }
                            },
                            vAxis: {
                            title: 'Rating (scale of 1-10)'
                            }
                        };

                        var chart = new google.visualization.ColumnChart(
                            document.getElementById('barchart_material'));

                        chart.draw(data, options);
                        }
      
            }
            });
        }
            });

            $('#end_time').change(function(){
                if($('#filter_content').val() == 'filter_content'){
                    var start_time =  $('#start_time').val();
                var end_time =  $('#end_time').val();
                var url = "{{ URL::to('admin/cpp_analytics_barchart/')  }}";
            $.ajax({
                
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(value){
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    console.log(value)

                    function drawChart(data) {
                        var Audio = value.total_audio_content ;
                        var Video =  value.total_video_content ;
                        var LiveStream = value.total_live_streams_content ;

                        var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Users Uploded Content');
                            data.addColumn('number', 'Uploded Count');

                        data.addRows([
                            [ 'Audio', parseInt(Audio)],
                            [ 'Video', parseInt(Video)],
                            [ 'Live Stream', parseInt(LiveStream)],
                        ]);

                        var options = {
                            title: 'Content Partners Uploded Content',
                            hAxis: {
                            title: 'Time of Day',
                            //   format: 'h:mm a',
                            viewWindow: {
                                // min: [7, 30, 0],
                                // max: [17, 30, 0]
                            }
                            },
                            vAxis: {
                            title: 'Rating (scale of 1-10)'
                            }
                        };

                        var chart = new google.visualization.ColumnChart(
                            document.getElementById('barchart_material'));

                        chart.draw(data, options);
                        }
      
            }
            });
        }
            });


        });
          

        $('#total_content_users').click(function(){
            $('#google-line-chart').show();
            $('#top_x_div').hide();
        });

        $('#cpp_analytics_table').DataTable();
        $('#start_time').change(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url = "{{ URL::to('admin/cpp_startdate_analytics/')  }}";
       
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

                    $('tbody').html(value.table_data);
                    $('#cpp_analytics_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_content;
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

                    });
                    }
                }
            });
       }
    });
        $('#end_time').change(function(){
        var start_time =  $('#start_time').val();
        var end_time =  $('#end_time').val();
        var url = "{{ URL::to('admin/cpp_enddate_analytics/')  }}";

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
                    $('#cpp_analytics_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_content;
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
        var url = "{{ URL::to('admin/cpp_analytics_exportCsv/')  }}";

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
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Moderator Users Analytics'],

                @php
                foreach($total_content as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);

        var options = {
          title: 'Moderator Users Analytics',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

          chart.draw(data, options);
        }
    </script>

    