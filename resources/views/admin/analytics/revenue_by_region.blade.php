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
                           <h4 class="card-title">Revenue By Region</h4>

          <img id="loader-image" src="{{ URL::to('/assets/icons/loader.gif') }}" 
          style="width: 30px; position: absolute;margin-left: 39%;
          margin-top: 19%;height: 30px;" alt="No GIF">

                    <div class="row mt-3">
                    <!-- <div class="col-md-4">
                        <label for="start_time">  Start Date: </label>
                        <input type="date" id="start_time" name="start_time" >               
                    </div>

                    <div class="col-md-4">
                        <label for="start_time">  End Date: </label>
                        <input type="date" id="end_time" name="end_time">     
                    </div> -->

                    <div class="col-md-4">
                        <span  id="export" class="btn btn-primary" >Download CSV</span>
                    </div>
                    
                    </div>
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
              <!-- <div class="col-sm-12">
                    <div class="row">
                         <div class="col-sm-4">                  
                         <label>ALL Country</label>
                <select class="form-control" id="Allcountry" name="country">
                    <option selected disabled="">Choose Country</option>
                    <option name="Allcountry" value="Allcountry" >Choose All Country</option>
                </select>
                  </div>
                     <div class="col-sm-4">                  
                <label for="state">ALL State</label>
                <select class="form-control" id="Allstate" name="Allstate">
                    <option selected disabled="">Choose State</option>
                    <option name="Allstate" value="Allstate" >Choose All State</option>
                </select>
                  </div>
                         <div class="col-sm-4">                  
                <label for="city">ALL City</label>
                <select class="form-control" id="Allcity" name="Allcity">
                    <option selected disabled="">Choose City</option>
                    <option name="Allcity" value="Allcity" >Choose All City</option>
                </select>
                  </div>
              </div>
              </div> -->
              <!-- </div> -->




                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " id="page" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>ID</th>
                                    <th>User Name</th>
                                     <th>Plan Name</th>
                                     <!-- <th>Action</th> -->
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                           <div class="clear"></div>
                           <div class="col-sm-12 ">
                        <figure class="highcharts-figure">
                                <div id="container"></div>
                                </figure>
                                </div> 
                         
                                <!-- </div>  -->
                     </div>


                        </div>
                  </div>
               </div>
         </div>

@stop

<script>

$(document).ready(function() {
$('#loader-image').hide();

$('#country').on('change', function() {
var country_id = this.value;
if(country_id == "Allcountry"){
// alert(country_id)

	$.ajax({
   url:"{{ URL::to('admin/PlanAllCountry') }}",
   method:'get',
   data:{query:country_id},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#page').DataTable();
    $('#total_records').text(data.total_data);
    $('#city-dropdown').append('<option value="Allcity">Select All City</option>'); 


    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'All Country Revenue'
  },
  tooltip: {
  },
  accessibility: {
    point: {
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
      }
    }
  },
  series: [{
    name: 'Revenue By Region',
    colorByPoint: true,
    data: [{
      name: 'By Region',
      y: data.total_data,
    }]
  }]
});

   }
    });
}
else{
// alert('country_id')
$('#loader-image').show();

  $("#state-dropdown").html('');
$.ajax({
url:"{{url::to('admin/getState')}}",
type: "POST",
data: {
country_id: country_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#loader-image').hide();

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
$('#loader-image').show();
$.ajax({
url:"{{url::to('admin/getCity')}}",
type: "POST",
data: {
state_id: state_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#loader-image').hide();

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
   if(Allstate == 'Allstate'){
	$.ajax({
   url:"{{ URL::to('admin/Planstate') }}",
   method:'get',
   data:{query:Allstate},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#page').DataTable();


    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'All State Revenue'
  },
  tooltip: {
  },
  accessibility: {
    point: {
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
      }
    }
  },
  series: [{
    name: 'Revenue By Region',
    colorByPoint: true,
    data: [{
      name: 'By Region',
      y: data.total_data,
    }]
  }]
});

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
// $('#loader-image').show();

	$.ajax({
   url:"{{ URL::to('admin/PlanAllCity') }}",
   method:'get',
   data:{query:Allcity},
   dataType:'json',
   success:function(data)
   {
$('#loader-image').hide();

    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#page').DataTable();


    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'All City Revenue'
  },
  tooltip: {
  },
  accessibility: {
    point: {
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
      }
    }
  },
  series: [{
    name: 'Revenue By Region',
    colorByPoint: true,
    data: [{
      name: 'By Region',
      y: data.total_data,
    }]
  }]
});

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
// $('#loader-image').show();

	$.ajax({
   url:"{{ URL::to('admin/Plancity') }}",
   method:'get',
   data:{query:city},
   dataType:'json',
   success:function(data)
   {
$('#loader-image').hide();

    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#page').DataTable();


    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Country State City Wish Revenue'
  },
  tooltip: {
  },
  accessibility: {
    point: {
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
      }
    }
  },
  series: [{
    name: 'Revenue By Region',
    colorByPoint: true,
    data: [{
      name: 'By Region',
      y: data.total_data,
    }]
  }]
});

   }
    });
   }
})

});


$(document).ready(function(){
          $('#export').click(function(){
            var country = $('#country').val();
            var state = $('#state-dropdown').val();
            var City = $('#city-dropdown').val();
            // alert(country);
            // alert(state);
            // alert(City);
          var url = "{{ URL::to('admin/analytics/RevenueRegionCSV/')  }}";

            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                country: country,
                state: state,
                City: City,

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