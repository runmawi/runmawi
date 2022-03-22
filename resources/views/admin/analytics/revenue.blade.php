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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div id="content-page" class="content-page">
            <div class="row">
                     <div class="iq-card-header  justify-content-between">
                            <div class="iq-header-title">
                            <h4 class="card-title">Users Analytics</h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <input type="text" class="daterange" /> -->
                                    <label for="">Registration:</label> <br>
                                    <label for="">Free Registration:</label><br>
                                    <label for="">Free Users:</label><br>
                                    <label for="">PPV Users:</label><br>
                                    <label for="">Pre-Order:</label>
                                </div>
                                 <div class="col-md-8">
                                    <figure class="highcharts-figure">
                                    <div id="container"></div>
                                    </figure>
                                </div> 
                            </div> 
                        </div> 

            </div>
        </div>

<script>
    Highcharts.chart('container', {

title: {
//   text: 'Solar Employment Growth by Sector, 2010-2016'
},

subtitle: {
//   text: 'Source: thesolarfoundation.com' 
},

yAxis: {
  title: {
    text: 'Number of Users'
  }
  
},

xAxis: {
  accessibility: {
    rangeDescription: 'Range: 0 to 100'
  }
},

legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'middle'
},

plotOptions: {
  series: {
    label: {
      connectorAllowed: false
    },
    pointStart: 0
  }
},

series: [{
  name: 'Registration',
  data: [112]
},
 {
  name: 'Manufacturing',
  data: [202]
}
// {
//   name: 'Sales & Distribution',
//   data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
// }, {
//   name: 'Project Development',
//   data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
// }, {
//   name: 'Other',
//   data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
// }
],

responsive: {
  rules: [{
    condition: {
      maxWidth: 500
    },
    chartOptions: {
      legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
      }
    }
  }]
}

});

</script>
