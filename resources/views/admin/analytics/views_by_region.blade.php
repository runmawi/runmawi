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
                           <h4 class="card-title">View By Region</h4>
                     </div>
                            </div>
                            <div class="col-sm-12">
                    <div class="row">
                    <div class="col-sm-4"> 
                   <label class="p-2">Region :</label>
                <select class="form-control" id="country" name="country">
                    <option selected disabled="">Choose Country</option>
                    <option name="allcountry" value="allcountry" >Select All Country</option>
                    @foreach($Country as $value)
                    <option name="country" value="{{ $value->id }}" >{{ $value->name }}</option>
                    @endforeach
                </select>
                  </div>
                  <!-- <div class="col-sm-4"> 
                 <label class="p-2">All Country :</label>
                <select class="form-control" id="allcountry" name="allcountry">
                    <option selected disabled="">Choose Country</option>
                    <option name="allcountry" value="allcountry" >Select All Country</option>
                </select>
                  </div>
                  </div> -->
              </div>
              <div class="col-sm-12 ">
                        <figure class="highcharts-figure">
                                <div id="container"></div>
                                </figure>
                                </div> 
                                <!-- </div>  -->
                     </div>
                     <!-- <p id="chart_data" style="margin-left: 80%;" >Total Viewed Videos</p><div id="chart_data1" style="margin-left:50%;"></div> -->
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " id="page" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>ID</th>
                                    <th>Video Name</th>
                                    <th>Country Name</th>
                                    <th>IP Number</th>
                                    <th>Views</th>
                                     <!-- <th>Country Name</th> -->
                                     <!-- <th>Action</th> -->
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                           <div class="clear"></div>
                          


                        </div>
                  </div>
               </div>
         </div>
    </div>
@stop
<input type="hidden" id="url" name="url" value="{{ URL::to('admin/Allregionvideos') }}">
<script>


$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
	$(document).ready(function(){
    $('#chart_data').hide();
    var url = $('#url').val();
    $('#country').change(function(){
   var country = $('#country').val();
   if(country == "allcountry"){
  //  alert(url);

	$.ajax({
   url:url,
   method:'get',
   data:{query:country},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#page').DataTable();
    $('#chart_data').show();
    $('#chart_data1').text(data.total_data);

    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Analytics'
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
    name: 'Videos Viewed By Region',
    colorByPoint: true,
    data: [{
      name: 'By Region',
      y: data.total_data,
    }]
  }]
});

   }
    });
   } else {

    $.ajax({
   url:"{{ URL::to('admin/regionvideos') }}",
   method:'get',
   data:{query:country},
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
    text: 'Analytics'
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
    name: 'Videos Viewed By Region',
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
    $('#allcountry').change(function(){
   var country = $('#allcountry').val();
//    alert(country);
   if(country == 'allcountry'){
	$.ajax({
   url:"{{ URL::to('admin/Allregionvideos') }}",
   method:'get',
   data:{query:country},
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
    text: 'Analytics'
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
    name: 'Videos Viewed By Region',
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