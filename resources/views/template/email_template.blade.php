@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Email Templates</h4>
                        </div>
                        
                        
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table id="template" class="table table-striped table-bordered table movie_table " style="width:100%">
                              <thead>
                                 <tr>
                                    <th>ID</th>
                                    <th>Template</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($email_template as $template)
                                 <tr>
                                 <td> <p class="mb-0">{{ $template->id }}</p></td>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $template->template_type }}</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $template->heading }}</td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('admin/template/view') . '/' . $template->id }}"><i class="lar la-eye"></i></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/template/edit') . '/' . $template->id }}"><i class="ri-pencil-line"></i></a>
                                       </div>
                                    </td>
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
      
         <script>
$(document).ready(function(){

   $('#template').DataTable();

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('admin/template_search') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>

@stop

