@extends('admin.master')

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
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

<div id="content-page" class="content-page">
            <div class="row">
            <span  id="export" class="btn btn-success btn-sm" >Export</span>
            </div>
            <div class="row">
                     <div class="iq-card-header  justify-content-between">
                            <div class="iq-header-title">
                            <h4 class="card-title">Users Analytics</h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                          <div class="row"> 
                          <div class="col-md-3">
                          <label for="start_time">  Strat time: </label>
                          <input type="date" id="start_time" name="start_time" >
                          <!-- <p>Date of Birth: <input type="text" id="datepicker"></p> -->

                          </div>
                          <div class="col-md-3">
                          <label for="start_time">  End time: </label>
                          <input type="date" id="end_time" name="end_time">
                          </div>
                          <div class="col-md-6">
                          <!-- <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" /> -->
                          </div>
                          </div>
                          <div class="clear"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <input type="text" class="daterange" /> -->
                                    <label for="">Registered User : <?php if(!empty($data1['registered_count'])){ echo $data1['registered_count'] ; }else{ echo $data1['registered_count'] ; } ?></label> <br>
                                    <label for="">Subscribed User : <?php if(!empty($data1['subscription_count'])){ echo $data1['subscription_count'] ; }else{ echo $data1['subscription_count'] ; }?></label><br>
                                    <label for="">Admin Users : <?php if(!empty($data1['admin_count'])){ echo $data1['admin_count'] ; }else{ echo $data1['admin_count']; } ?></label><br>
                                    <!-- <label for="">PPV Users:</label><br>
                                    <label for="">Pre-Order:</label> -->
                                </div>
                                 <div class="col-md-8">
                                    <figure class="highcharts-figure">
                                    <!-- <div id="container"></div> -->
                                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                                    </figure>
                                </div> 
                            </div> 
                        </div> 

            </div>
        </div>
        <input type="hidden" id="exportCsv_url" value="<?php echo URL::to('/admin/exportCsv');?>">
        <input type="hidden" id="start_date_url" value="<?php echo URL::to('/admin/start_date_url');?>">
        <input type="hidden" id="end_date_url" value="<?php echo URL::to('/admin/end_date_url');?>">
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
      var start_time =  $('#start_time').val();
       var end_time =  $('#end_time').val();
       var url =  $('#start_date_url').val();
      if(start_time == "" && end_time == ""){
        var registered = <?php echo $data['registered']; ?>;
        var subscription = <?php echo $data['subscription']; ?>;
        var admin = <?php echo $data['admin']; ?>;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Register Users Count'],
 
                @php
                foreach($data['subscription'] as $d) {
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
                success: function(data){
                  google.charts.load('current', {'packages':['corechart']});
                  var data = google.visualization.arrayToDataTable([
                    ['Month Name', 'Register Users Count'],
        
                        @php
                        foreach($data['registered'] as $d) {
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
                console.log(value);
                   $('#Next').show();
                  $('#video_id').val(value.video_id);

               }
           });
      }
      });

        
    })


    
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
          }
          });
    });
});

</script>


