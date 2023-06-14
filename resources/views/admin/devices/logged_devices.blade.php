
@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 


@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Site Logged Dvices :</h4>
                </div>
            </div>
             
            {{-- Bulk video delete --}}
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" >Delete Selected Device</button>

                <div class="clear"></div>

             
                
                <div class="row">
                </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="sitemeta_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>Select All <input type="checkbox" id="select_all"></th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User IP</th>
                                            <th>Device Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    
                                    @foreach($LoggedDevice as $key => $Logged_Device)
                                    <tr id="tr_{{ $Logged_Device->id }}">

                                        <td><input type="checkbox" id="Sub_chck" class="sub_chk" data-id="{{$Logged_Device->id}}"></td>
                                        <td>{{ @$Logged_Device->user->username  }}</td>  
                                        <td>{{ @$Logged_Device->user->email  }}</td>  
                                        <td>{{ @$Logged_Device->user_ip  }}</td>   
                                        <td>{{ @$Logged_Device->device_name  }}</td>   
                                        <td>
                                        <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" 
                                             href="{{ URL::to('admin/user-logged-device/delete') . '/' . @$Logged_Device->id }}">
                                             <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                           
                                        </td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
    
@stop
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
         $(document).ready(function(){
            $('#sitemeta_table').DataTable();
         });
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   $(document).ready(function () {

      $(".delete_all").hide();

       $('#select_all').on('click', function(e) {

            if($(this).is(':checked',true))  
            {
               $(".delete_all").show();
               $(".sub_chk").prop('checked', true);  
            } else {  
               $(".delete_all").hide();
               $(".sub_chk").prop('checked',false);  
            }  
       });


      $('.sub_chk').on('click', function(e) {

         var checkboxes = $('input:checkbox:checked').length;

         if(checkboxes > 0){
            $(".delete_all").show();
         }else{
            $(".delete_all").hide();
         }
      });


       $('.delete_all').on('click', function(e) {

           var allVals = [];  
            $(".sub_chk:checked").each(function() {  

                  allVals.push($(this).attr('data-id'));
            });  

            if(allVals.length <=0)  
            {  
                  alert("Please select Anyone device");  
            }  
            else 
            {  
               var check = confirm("Are you sure you want to delete selected devices?");  
               if(check == true){  
                   var join_selected_values =allVals.join(","); 

                   $.ajax({
                     url: '{{ URL::to('admin/logged_device_Bulk_delete') }}',
                     type: "get",
                     data:{ 
                        _token: "{{csrf_token()}}" ,
                        logged_id: join_selected_values, 
                     },
                     success: function(data) {

                        if(data.message == 'true'){

                           location.reload();

                        }else if(data.message == 'false'){

                           swal.fire({
                           title: 'Oops', 
                           text: 'Something went wrong!', 
                           allowOutsideClick:false,
                           icon: 'error',
                           title: 'Oops...',
                           }).then(function() {
                              location.href = '{{ URL::to('admin/videos') }}';
                           });
                        }
                     },
                  });
               }  
            }  
       });

   });
</script>

