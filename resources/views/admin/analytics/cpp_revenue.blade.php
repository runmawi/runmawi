<!-- Page Create on 31/03/2022 -->


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


@section('content')
    <div id="content-page" class="content-page">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Content Partners Revenue :</h4>
                </div>

                <br>
                <br>

                <div class="clear"></div>

                <!-- Start Date  End Date  Download CSV    (SET BY Sanjai Kumar) -->
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
                <!-- Graph Currency   (SET BY Sanjai Kumar) -->
                <div class="row">
                    <div class="col-md-9">
                        <?php if($total_Revenue_count > 0){ ?> 
                            <div id="google-line-chart" style="width: 900px; height: 500px"></div>       
                        <?php }elseif($total_Revenue_count == 0){ ?> 
                            <div id="" style=""> <label for="">Graph :</label><h5>No Revenue Data Found</h5></div>  
                            <br>     
                        <?php } ?>
                 </div>
                 <div class="col-md-3" >
                    <p > <h5 style="margin-left: 15%;">Currency Used : {{ $currency->symbol .' '.$currency->country}}</h5> </p>
                    <h5 style="margin-left: 15%;"> Total Views : <span id="total_views"> </span></h5>
                </div>
                </div>
            

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="cpp_revenue_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Content Partner</th>
                                            <th>Total Views</th>
                                            <th> % Shared Commission</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach($moderators_users as $key => $user)
                                        <tr>
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $user->username  }}</td>   
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

                 <input type="hidden" name="view_count" id="view_count" value="{{ $views_count }}">                   
    
@stop
<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#cpp_revenue_table').DataTable();
        var view_count = $('#view_count').val();
        $('#total_views').text(view_count);  
        $('#start_time').change(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url = "{{ URL::to('admin/cpp_startdate_revenue/')  }}";
       
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
                    $('#total_views').text(value.views_count);  
                    $('#cpp_revenue_table').DataTable();
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
        var url = "{{ URL::to('admin/cpp_enddate_revenue/')  }}";

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
                    $('#cpp_revenue_table').DataTable();
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
        var url = "{{ URL::to('admin/cpp_exportCsv/')  }}";

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

        var total_Revenue_count   = "{{ $total_Revenue_count }}";
        // if(total_Revenue_count == 0){
        //     ('#google-line-chart').hide();
        // }
        if(total_Revenue_count > 0){
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Moderator Users Commssion'],

                @php
                foreach($total_Revenue as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);

        var options = {
          title: 'Total Moderator Users Commssion',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

          chart.draw(data, options);
        }
    }else{
    }
    </script>

    