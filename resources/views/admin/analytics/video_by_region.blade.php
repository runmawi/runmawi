@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
  <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<style>
    .highcharts-figure, .highcharts-data-table table {
  min-width: 300px; 
  max-width: 450px;
  margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
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
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
.highcharts-credits{
  display: none !important;
}

input[type="number"] {
	min-width: 50px;
}
</style>

@section('content')

<div id="content-page" class="content-page">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header  justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Video Analytics By Region</h4>
                           </div>
                            </div>
                    <!-- <div class="row"> -->
                    <div class="col-sm-12">
                    <div class="row">
                         <div class="col-sm-4">                  
                         <label>Country :</label>
                <select class="form-control" id="country" name="country">
                    <option selected disabled="">Choose Country</option>
                    <option name="Allcountry" value="Allcountry" >Choose All Country</option>
                    @foreach($Country as $value)
                    <option name="country" value="{{ $value->id }}" >{{ $value->name }}</option>
                    @endforeach
                </select>
                  </div>
                     <div class="col-sm-4">                  
                <label for="state">State</label>
                <select class="form-control" id="state-dropdown" name="state">
                    <option selected disabled="">Choose State</option>
                    <option name="Allstate" value="Allstate" >Choose All State</option>
                </select>
                  </div>
                         <div class="col-sm-4">                  
                <label for="city">City</label>
                <select class="form-control" id="city-dropdown" name="city">
                    <option selected disabled="">Choose City</option>
                    <option name="Allcity" value="Allcity" >Choose All City</option>
                </select>
                  </div>
              </div>
              </div>

                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " id="player_table" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>#</th>
                                    <!-- <th>User Name</th> -->
                                    <th>Video Name</th>
                                    <th>Viewed Count</th>
                                    <th>Watch Percentage (Minutes)</th>
                                    <th>Seek Time (Seconds)</th>
                                    <th>Buffered Time (Seconds)</th>
                                    <th>Country Name</th>
                                    <th>State Name</th>
                                    <th>City Name</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    @foreach($player_videos as $key => $playervideo)
                                        <td>{{ $key+1  }}</td>   
                                        <!-- <td>{{ $playervideo->username  }}</td>    -->
                                        <td>{{ $playervideo->title  }}</td>   
                                        <td>{{ $playervideo->count  }}</td>   
                                        <td>{{ $playervideo->watchpercentage  }}</td>   
                                        <td>{{ $playervideo->seekTime  }}</td>   
                                        <td>@if(!empty($playervideo->bufferedTime)){{ $playervideo->bufferedTime  }} @else {{ 'No Buffer' }} @endif</td>   
                                        <td>{{ $playervideo->country_name  }}</td>   
                                        <td>{{ $playervideo->state_name  }}</td>   
                                        <td>{{ $playervideo->city_name  }}</td>   
                                        </tr>

                                    @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>
                           <div class="col-sm-12 ">
                           <div class="row">
                                <div class="col-md-6">
                                <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                                    </div>
                                    </div>
                                </div> 
                         
                                <!-- </div>  -->
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
<script>
$(document).ready(function() {
$('#country').on('change', function() {
var country_id = this.value;
if(country_id == "Allcountry"){
// alert(country_id)

	$.ajax({
   url:"{{ URL::to('admin/analytics/VideoAllCountry') }}",
   method:'get',
   data:{query:country_id},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#player_table').DataTable();
    $('#total_records').text(data.total_data);
    $('#city-dropdown').append('<option value="Allcity">Select All City</option>'); 


   }
    });
}
else{
// alert('country_id')
  $("#state-dropdown").html('');
$.ajax({
url:"{{ url::to('admin/analytics/getState')}}",
type: "POST",
data: {
country_id: country_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#state-dropdown').html('<option value="">Select State</option>'); 
$('#state-dropdown').append('<option value="Allstate">Choose All State</option>'); 
$.each(result.states,function(key,value){
$("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
});
$('#city-dropdown').html('<option value="">Select State First</option>'); 
}
});
}
}); 



$('#state-dropdown').on('change', function() {
var state_id = this.value;
$("#city-dropdown").html('');
$.ajax({
url:"{{ url::to('admin/Analytics/RegionGetCity')}}",
type: "POST",
data: {
state_id: state_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#city-dropdown').html('<option value="">Select City</option>'); 
$('#city-dropdown').append('<option value="Allcity">Choose All City</option>'); 
$.each(result.cities,function(key,value){
$("#city-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');
});
}
});
});
});


$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
	$(document).ready(function(){
    $('#state-dropdown').change(function(){
   var Allstate = $('#state-dropdown').val();
  //  alert(Allstate);
   if(Allstate == Allstate){
	$.ajax({
   url:"{{ URL::to('admin/analytics/Videostate') }}",
   method:'get',
   data:{query:Allstate},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#player_table').DataTable();


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




   }
    });
   }
})

});



$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
	$(document).ready(function(){
    $('#city-dropdown').change(function(){
   var Allcity = $('#city-dropdown').val();
//    alert(country);
   if(Allcity == "Allcity"){
	$.ajax({
   url:"{{ URL::to('admin/analytics/VideoAllCity') }}",
   method:'get',
   data:{query:Allcity},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#player_table').DataTable();



   }
    });
   }
})

});


$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
	$(document).ready(function(){
    $('#city-dropdown').change(function(){
   var city = $('#city-dropdown').val();
//    alert(country);
   if(city == city){
	$.ajax({
   url:"{{ URL::to('admin/analytics/Videocity') }}",
   method:'get',
   data:{query:city},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#player_table').DataTable();



   }
    });
   }
})

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



      </script>