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
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Content Partners Video Analytics :</h4>
                </div>
            </div>
             

                <div class="clear"></div>

                <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="start_time">  Start Date: </label>
                        <input type="date" id="start_time" name="start_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">               
                    </div>

                    <div class="col-md-3">
                        <label for="start_time">  End Date: </label>
                        <input type="date" id="end_time" name="end_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">     
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <span  id="export" class="btn btn-primary" >Download CSV</span>
                    </div>
                </div>
                </div>

                <div class="clear"></div>
                <br>


                <div class="row mt-4">
                <div class="col-md-6">
                    <label for="">Filter Moderator</label>
                    <select class="form-control"  name="cpp_userid" id="cpp_userid">
                        <option value="">Choose Moderator</option>
                        @foreach($ModeratorsUser as $Moderators)
                        <option value="{{ $Moderators->id}}"> {{ $Moderators->username}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="cpp_video_analytics_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Uploader</th>
                                            <th>Total %</th>
                                            <th>Admin %</th>
                                            <th>Moderator %</th>
                                            <th>Total Views</th>
                                            <th>Purchased Date</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($ppv_purchases as $key => $videos)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $videos->title  }}</td>  
                                        <td>{{ $videos->slug  }}</td>   
                                        <td>{{ $videos->cppusername  }}</td>   
                                        <td>{{ $videos->total_amount  }}</td>   
                                        <td>{{ $videos->admin_commssion  }}</td>   
                                        <td>{{ $videos->moderator_commssion  }}</td>   
                                        <!-- <td>{{ $videos->cppemail  }}</td>    -->
                                        <td>{{ $videos->views  }}</td>   
                                        <td>{{ date('Y-m-d', strtotime($videos->purchases_created_at))  }}</td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
                    <br>


                <h4 class="card-title">CPP Video View Through Graph :</h4>
                
                <div class="row">
                    <div class="col-md-8">
                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                 </div>
                 <!-- <div class="col-md-4" >
                
                 </div> -->
                </div>
            
            </div>
        </div>
    </div>
</div>
    
@stop

<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#cpp_video_analytics_table').DataTable();
     });
        </script>





<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){


        $('#cpp_userid').change(function(){

            var url = "{{ URL::to('admin/cpp_video_fliter/')  }}";
            var cpp_userid =  $('#cpp_userid').val();
            // alert(cpp_userid);
            $.ajax({
                url: url,
                type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: cpp_userid,
                    },      
                    success: function(value){       
                    // console.log(value);

                    $('tbody').html(value.table_data);
                    $('#cpp_video_analytics_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_content;
                    var data = new google.visualization.DataTable(linechart);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Month');
                    data.addColumn('number', 'Video Views Count');

                    linechart.forEach(function (row) {
                        data.addRow([
                        row.month_name,
                        parseInt(row.views),
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
        });

        
        // alert();

        $('#start_time').change(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
            var url = "{{ URL::to('admin/cpp_video_startdate_analytics/')  }}";
       
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
                    $('#cpp_video_analytics_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_content;
                    var data = new google.visualization.DataTable(linechart);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Month');
                    data.addColumn('number', 'Video Views Count');

                    linechart.forEach(function (row) {
                        data.addRow([
                        row.month_name,
                        parseInt(row.views),
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
        var url = "{{ URL::to('admin/cpp_video_enddate_analytics/')  }}";

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
                    $('#cpp_video_analytics_table').DataTable();
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                    var linechart = value.total_content;
                    var data = new google.visualization.DataTable(linechart);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Month');
                    data.addColumn('number', 'Video Views Count');

                    linechart.forEach(function (row) {
                        data.addRow([
                        row.month_name,
                        parseInt(row.views),
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
        var url = "{{ URL::to('admin/cpp_video_exportCsv/')  }}";

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

var total_video_count   = "{{ $total_video_count }}";
// if(total_Revenue_count == 0){
//     ('#google-line-chart').hide();
// }
if(total_video_count > 0){
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

var data = google.visualization.arrayToDataTable([
    ['Month Name', 'Moderator Video Views'],

        @php
        foreach($total_content as $key => $d) {
            echo "['".$d->month_name."', ".$d->views."],";
        }
        @endphp
]);

var options = {
  title: 'Total Moderator Video Views',
  curveType: 'function',
  legend: { position: 'bottom' }
};

  var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

  chart.draw(data, options);
}
}else{
}
</script>


    