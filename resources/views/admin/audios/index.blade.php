@extends('admin.master')
<style>
     .form-control {
   /* background: #fff!important; */
   
}
     .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
    .table.dataTable thead th, table.dataTable thead td{
        border-bottom: 1px solid #dee2e6!important;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

     <div id="content-page" class="content-page">
         <div class="d-flex">
         <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/audios') }}">Audio List</a>
        <a class="black" href="{{ URL::to('admin/audios/create') }}">Add New Audio</a>
        <a class="black" href="{{ URL::to('admin/audios/categories') }}">Manage Audio Categories</a>
             <a class="black" href="{{ URL::to('admin/audios/albums') }}">Manage Albums</a></div>
         <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between mb-3">
                        <div class="iq-header-title">
                           <h4 class="card-title">Audio Lists</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center col-md-6">
                           <a href="{{ URL::to('admin/audios/create') }}" class="btn btn-primary">Add Audio</a>
                        </div>

                          {{-- Bulk video delete --}}
			 	            <button style="margin-bottom: 10px" class="btn btn-primary delete_all"> Delete Selected Video </button>
                     </div>
                     <div class=" p-0">
                        <div class="table-view">
                           <table class="data-tables table audio_table iq-card text-center p-0" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Select All <input type="checkbox" id="select_all"></th>
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <th>Category</th>
                                     <th>Views</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($audios as $key => $audio)
                              <?php 
                                 $CategoryAudio = App\CategoryAudio::where('audio_id',@$audio->id)
                                 ->Join('audio_categories','audio_categories.id','=','category_audios.category_id')->pluck('audio_categories.name');
                                 
                              // dd($Category_Audio);
                              ?>

                                 <tr id="tr_{{ $audio->id }}">

                                    <td><input type="checkbox"  class="sub_chk" data-id="{{ $audio->id }}"></td>

                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-audio">
                                             <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $audio->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $audio->title }}</p>
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $audio->rating }}</td>
                                    <!-- <td>@if(isset($audio->categories->name)) {{ $audio->categories->name }} @endif</td> -->
                                    <td>
                                   <?php 
                                       if(count($CategoryAudio) > 0){
                                       foreach($CategoryAudio as $Category_Audio){
                                       echo  $Category_Audio. ' ' ;
                                          
                                       }
                                    } 
                                    ?>
                                    </td>
                                    <td>
                                        {{ $audio->views }}
                                    </td>
                                    <td>
                                       <div class=" align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/audio') . '/' . $audio->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/audios/edit') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" onclick="return confirm('Are you sure?')"
                                             data-original-title="Delete" href="{{ URL::to('admin/audios/delete') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>

		<div class="pagination-outter"><?= $audios->appends(Request::only('s'))->render(); ?></div>
		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      

@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this audio?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

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
                  alert("Please select Anyone Audios");  
             }  
             else 
             {  
               var check = confirm("Are you sure you want to delete selected Audios ?");  
               if(check == true){  
                  var join_selected_values =allVals.join(","); 
    
                  $.ajax({
                    url: '{{ URL::to('admin/Audios_bulk_delete') }}',
                    type: "get",
                    data:{ 
                      _token: "{{csrf_token()}}" ,
                      audio_id: join_selected_values, 
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
                           location.href = '{{ URL::to('admin/audios') }}';
                        });
                      }
                    },
                  });
               }  
             }  
         });
    
      });
   </script>

	@stop

@stop


 