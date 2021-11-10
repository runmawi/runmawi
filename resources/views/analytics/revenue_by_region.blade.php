@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
                           </div>
                            </div>
                    <!-- <div class="row"> -->
                    <div class="col-sm-12">
                    <div class="row">
                         <div class="col-sm-4">                  
                         <label>Country :</label>
                <select class="form-control" id="country" name="country">
                    <option selected disabled="">Choose Country</option>
                    @foreach($Country as $value)
                    <option name="country" value="{{ $value->id }}" >{{ $value->name }}</option>
                    @endforeach
                </select>
                  </div>
                     <div class="col-sm-4">                  
                <label for="state">State</label>
                <select class="form-control" id="state-dropdown" name="state">
                    <option selected disabled="">Choose State</option>
                </select>
                  </div>
                         <div class="col-sm-4">                  
                <label for="city">City</label>
                <select class="form-control" id="city-dropdown" name="city">
                    <option selected disabled="">Choose City</option>
                </select>
                  </div>
              </div>
              </div>
              <!-- </div> -->




                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " style="width:100%">
                              <thead>
                                 <tr>
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
$('#country').on('change', function() {
var country_id = this.value;
$("#state-dropdown").html('');
$.ajax({
url:"{{url('/getState')}}",
type: "POST",
data: {
country_id: country_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#state-dropdown').html('<option value="">Select State</option>'); 
$.each(result.states,function(key,value){
$("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
});
$('#city-dropdown').html('<option value="">Select State First</option>'); 
}
});
});    
$('#state-dropdown').on('change', function() {
var state_id = this.value;
$("#city-dropdown").html('');
$.ajax({
url:"{{url('/getCity')}}",
type: "POST",
data: {
state_id: state_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('#city-dropdown').html('<option value="">Select City</option>'); 
$.each(result.cities,function(key,value){
$("#city-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');
});
}
});
});
});

// $.ajaxSetup({
//            headers: {
//                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//     });
// 	$(document).ready(function(){
//     $('#country').change(function(){
//    var country = $('#country').val();
// //    alert(country);
//    if(country == country){
// 	$.ajax({
//    url:"{{ URL::to('/Plancountry') }}",
//    method:'get',
//    data:{query:country},
//    dataType:'json',
//    success:function(data)
//    {
//     $('tbody').html(data.table_data);
//     $('#total_records').text(data.total_data);

//     Highcharts.chart('container', {
//   chart: {
//     plotBackgroundColor: null,
//     plotBorderWidth: null,
//     plotShadow: false,
//     type: 'pie'
//   },
//   title: {
//     text: 'Country Wish Revenue'
//   },
//   tooltip: {
//   },
//   accessibility: {
//     point: {
//     }
//   },
//   plotOptions: {
//     pie: {
//       allowPointSelect: true,
//       cursor: 'pointer',
//       dataLabels: {
//         enabled: true,
//       }
//     }
//   },
//   series: [{
//     name: 'Revenue By Region',
//     colorByPoint: true,
//     data: [{
//       name: 'By Region',
//       y: data.total_data,
//     }]
//   }]
// });

//    }
//     });
//    }
// })

// });


// $.ajaxSetup({
//            headers: {
//                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//     });
// 	$(document).ready(function(){
//     $('#state').change(function(){
//    var state = $('#state').val();
// //    alert(country);
//    if(state == state){
// 	$.ajax({
//    url:"{{ URL::to('/Planstate') }}",
//    method:'get',
//    data:{query:state},
//    dataType:'json',
//    success:function(data)
//    {
//     $('tbody').html(data.table_data);
//     $('#total_records').text(data.total_data);

//     Highcharts.chart('container', {
//   chart: {
//     plotBackgroundColor: null,
//     plotBorderWidth: null,
//     plotShadow: false,
//     type: 'pie'
//   },
//   title: {
//     text: 'State Wish Revenue'
//   },
//   tooltip: {
//   },
//   accessibility: {
//     point: {
//     }
//   },
//   plotOptions: {
//     pie: {
//       allowPointSelect: true,
//       cursor: 'pointer',
//       dataLabels: {
//         enabled: true,
//       }
//     }
//   },
//   series: [{
//     name: 'Revenue By Region',
//     colorByPoint: true,
//     data: [{
//       name: 'By Region',
//       y: data.total_data,
//     }]
//   }]
// });

//    }
//     });
//    }
// })

// });


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
   url:"{{ URL::to('/Plancity') }}",
   method:'get',
   data:{query:city},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);

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



      </script>