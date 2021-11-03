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
                           <h4 class="card-title">Revenue System</h4>
                        </div>
                        </div>
                            <div class="row">
                        <div class="col-sm-6 ">
                                <figure class="highcharts-figure">
                                <div id="container"></div>
                                </figure>
                                </div> 
                         
                                <div class="col-sm-6 ">
                               <figure class="highcharts-figure">
                                <div id="container1"></div>
                                </figure>
                                </div> 
                                </div> 
                     </div>
                  </div>
               </div>
         </div>

      <script>
          var subscription_revenues = <?php echo $subscription_revenue ?>;
          var ppv_revenues = <?php echo $ppv_revenue ?>;


          Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'PPV Payment'
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
    name: 'Payment',
    colorByPoint: true,
    data: [{
      name: 'PPV Payment',
      y: ppv_revenues
    }]
  }]
});





Highcharts.chart('container1', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Subscription Payment'
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
    name: 'Payment',
    colorByPoint: true,
    data: [{
      name: 'Subscription Payment',
      y: subscription_revenues,
      sliced: true,
      selected: true
    }]
  }]
});
      </script>