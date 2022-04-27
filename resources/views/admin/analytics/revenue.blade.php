@extends('admin.master')

@include('admin.favicon')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
  
@endsection
<style>
    .highcharts-figure,
.highcharts-data-table table {
  min-width: 360px;
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}

.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
        .admin-container{
            padding: 10px;
        }
        .iq-card{
            padding: 15px!important; 
        }
     .p1{
        font-size: 12px!important;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<?php $jsonString = file_get_contents(base_path('assets/country_code.json'));

$jsondata = json_decode($jsonString, true);
// dd($jsondata);

?>
<div id="content-page" class="content-page">
    <div class="iq-card">
         <div class="iq-card-header  justify-content-between">
                            <div class="iq-header-title p-0">
                            <h4 class="card-title">Users Analytics</h4>
                                  
                            </div>
                        </div>
            <div class="row">
            
            </div>
            <div class="row p-3">
                    
                <hr>
                        <div class="col-md-12">
                          <div class="row mt-3"> 
                          <div class="col-md-4">
                          <label for="start_time">  Start Date: </label>
                          <input type="date" id="start_time" name="start_time" >
                          </div>
                          <div class="col-md-4">
                          <label for="start_time">  End Date: </label>
                          <input type="date" id="end_time" name="end_time">
                          </div>
                          <div class="col-md-4 ">
                             <span  id="export" class="btn btn-success btn-sm" >Export</span>
                          </div>
                          </div>
                          <div class="clear"></div>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <!-- <input type="text" class="daterange" /> -->
                                    <label for="">Registered User : <?php if (!empty($data1['registered_count']))
                                      {
                                          echo $data1['registered_count'];
                                      }
                                      else
                                      {
                                          echo $data1['registered_count'];
                                      } ?></label> <br>
                                    <label for="">Subscribed User : <?php if (!empty($data1['subscription_count']))
                                      {
                                          echo $data1['subscription_count'];
                                      }
                                      else
                                      {
                                          echo $data1['subscription_count'];
                                      } ?></label><br>
                                    <label for="">Admin Users : <?php if (!empty($data1['admin_count']))
                                      {
                                          echo $data1['admin_count'];
                                      }
                                      else
                                      {
                                          echo $data1['admin_count'];
                                      } ?></label><br>
                                    <label for="">PPV Users : <?php if (!empty($data1['ppvuser_count']))
                                      {
                                          echo $data1['ppvuser_count'];
                                      }
                                      else
                                      {
                                          echo $data1['ppvuser_count'];
                                      } ?></label><br>

                                    <!-- <label for="">PPV Users:</label><br>
                                    <label for="">Pre-Order:</label> -->
                                </div>
                                 <div class="col-md-8">
                                    <figure class="highcharts-figure">
                                    <!-- <div id="container"></div> -->
                                    <div id="google-line-chart" style="width: 700px; height: 500px"></div>
                                    </figure>
                                </div> 
                            </div> 
                            <br>
                            <br>
                            <div class="row">
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
                                 <div class="col-md-6">
                                </div> 
                            </div> 
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                <table class="table" id="user_tabledss" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>User</th>
                                    <th>ACC Type</th>
                                    <th>Country</th>
                                    <th>Registered ON </th>
                                    <th>Source</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($total_user as $key => $user)

                             <tr>
                             <td>{{ $user->username  }}</td>   
                             <td>@if($user->role == "registered") Registered User  @elseif($user->role == "subscriber") Subscribed User @endif</td>
                             <td>@if(@$user->phoneccode->phonecode == $user->ccode)  {{ @$user->phoneccode->country_name }} @else No Country Added @endif</td>
                             <td>{{ $user->created_at }}</td> 
                             <td>@if($user->provider == "google") Google User @elseif($user->provider == "facebook") Facebook User @else Web User @endif</td>
                            <?php if ($user->active == 0)
                            { ?>
                              <td > <p class = "bg-warning user_active"><?php echo "InActive"; ?></p></td>
                            <?php
                            }
                            elseif ($user->active == 1)
                            { ?>
                              <td > <p class = "bg-success user_active"><?php echo "Active"; ?></p></td>
                            <?php   } ?> 

                             </tr>
                             @endforeach

                              </tbody>
                           </table>
                                </div>
                                </div>
                                <div style="margin-left:80%"><?php echo $total_user->render(); ?></div>
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
   

  $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
       });
   
    $(document).ready(function(){
    $('#user_table').DataTable();
      // var data['registered'] = 2;
      $('#start_time').change(function(){
       var start_time =  $('#start_time').val();
       var end_time =  $('#end_time').val();
       var url =  $('#start_date_url').val();
       
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
                  $('tbody').html(value.table_data);
                  $('#user_tables').text(value.total_data);  
                  $('#user_table').DataTable();
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
                  var linechart = value.total_users;
                  var data = new google.visualization.DataTable(linechart);
                  var data = new google.visualization.DataTable();
                  data.addColumn('string', 'Month');
                  data.addColumn('number', 'User Count');

                  linechart.forEach(function (row) {
                    data.addRow([
                      row.month_name,
                      row.count,
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
       var url =  $('#end_date_url').val();
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
                  $('tbody').html(value.table_data);
                  $('#user_tables').text(value.total_data);  
                  $('#user_table').DataTable();
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
                  var linechart = value.total_users;
                  var data = new google.visualization.DataTable(linechart);
                  var data = new google.visualization.DataTable();
                  data.addColumn('string', 'Month');
                  data.addColumn('number', 'User Count');

                  linechart.forEach(function (row) {
                    data.addRow([
                      row.month_name,
                      row.count,
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

        
    })


    //////////Chart Before Choosing date////////////

    var start_time =  $('#start_time').val();
       var end_time =  $('#end_time').val();
       var url =  $('#start_date_url').val();
      if(start_time == "" && end_time == ""){
        var total_user = <?php echo $data['total_user']; ?>;

            google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Register Users Count'],
 
                @php
                foreach($data['total_user'] as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);
 
        var options = {
          title: 'Register Users Month Wise',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
 
          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
 
          chart.draw(data, options);
        }
      }



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

            // console.log(link_url);

            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);

            location.href = link_url;
          }
          });
    });
});





//////// Choose Role User /////




$.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
       });
   
    $(document).ready(function(){
          $('#role').change(function(){
          var url =  $('#listusers_url').val();
          var role = $('#role').val();
            // alert($('#role').val());
          $.ajax({
          url: url,
          type: "post",
          data: {
          _token: '{{ csrf_token() }}',
          role: role,
          },  
          dataType:'json',
          success: function(data){
        $('tbody').html(data.table_data);
         $('#user_tables').text(data.total_data);  
    $('#user_table').DataTable();

        }
          });
    });
});



</script>
