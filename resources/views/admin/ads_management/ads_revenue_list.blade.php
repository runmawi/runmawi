@extends('admin.master')

@section('css')
<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Ads Revenue List</h4>
                  </div>
                 
               </div>
               <!-- <div class=" col-md-10 col-md-offset-1">
                <div class="form-group col-md-3">
                  <label for="year">Year</label>
              </div>
              <div class="form-group col-md-5">
                 <input type="text" name="year" id="year" class="form-control">
              </div>
           </div> -->
           <!-- <div class=" col-md-10 col-md-offset-1">
             <div class="form-group col-md-3">
              <label for="month">Month</label>
           </div>
           <div class="form-group col-md-5">
              <input type="text" name="month" id="month" class="form-control">
           </div>
        </div> -->
        <div class=" col-md-10 col-md-offset-1 d-flex mt-2 align-items-center">
             <div class="form-group col-md-3">
              <label for="month">Total Revenue</label>
           </div>
           <div class="form-group col-md-5">
              <input type="text" id="Revenue" value="" class="form-control" disabled>
           </div>
        </div>
               <div class="iq-card-body table-responsive">
                  <div class="table-view">
                     <table class="table table-striped table-bordered table movie_table " style="width:100%">
                        <thead>
                           <tr class="r1">
                              <th>#</th>
                              <th>Advertiser Company Name</th>
                              <th>Plan Name</th>
                              <th>Plan Amount</th>
                              <th>Created at</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($ads_history as $key => $ads_history)
                           <tr>
                                 <td>{{ $key+1 }}</td>
                                 <td>{{ $ads_history->company_name }}</td>
                                 <td>{{ $ads_history->plan_name }}</td>
                                 <td>{{ $ads_history->plan_amount }}</td>
                                 <td>{{ date('Y-m-d',strtotime($ads_history->created_at)) }}</td>
                                 
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>


                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   @section('javascript')
   <script src="//cdn.datatables.net/plug-ins/1.11.3/api/sum().js"></script>
   <script>
    $(document).ready(function() {
      var table = $('.movie_table').DataTable();
        var sum = table.column(3).data().sum();
        $('#Revenue').val(sum);
  
  // Event listener to the two range filtering inputs to redraw on input
  $('#year, #month').keyup(function() {
      table.draw();
  });
  
  $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      var month = parseInt( $('#month').val(), 10 );
      var year = parseInt( $('#year').val(), 10 );
      var date = data[4].split('-');
      
      if ( ( isNaN( year ) && isNaN( month ) ) ||
       ( isNaN( month ) && year == date[0] ) ||
       ( date[1] == month && isNaN( year ) ) ||
       ( date[1] == month && year == date[0] ) 
       )
      {

         return true;
      }
      return false;
   }
   );
});
   </script>
   @stop

   @stop

