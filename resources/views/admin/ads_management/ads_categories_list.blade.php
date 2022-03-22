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
                     <h4 class="card-title">Ads Category List</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <a data-toggle="modal" data-target='#edit_modal' class="btn btn-primary create_category">Create Ads Category</a>
                  </div>
               </div>
               <div class="iq-card-body table-responsive">
                  <div class="table-view">
                     <table class="table table-striped table-bordered table movie_table " style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Category Name</th>
                              <th>Created at</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($ads_categories as $key => $ads_category)
                           <tr>
                                 <td>{{ $key+1 }}</td>
                                 <td>{{ $ads_category->name }}</td>
                                 <td>{{ $ads_category->created_at }}</td>
                                 <td><a class="iq-bg-success editcategory" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="Edit" data-toggle="modal" data-target='#edit_modal' data-id="{{ $ads_category->id }}"><i class="ri-pencil-line"></i></a>
                                    <a  onclick="return confirm('Are you sure?')" href="{{ URL::to('/admin/ads_category_delete').'/'. $ads_category->id }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                    <i class="ri-delete-bin-line"></i></a>
                                     <!-- <i class="ri-delete-bin-line delete" data-id="{{ $ads_category->id }}" ></i> -->
                                    </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>

                        <div class="pagination-outter"><?= $ads_categories->appends(Request::only('s'))->render(); ?></div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="edit_modal">
      <div class="modal-dialog">
         <form id="companydata">
          <div class="modal-content">
             <input type="hidden" id="category_id" name="category_id" value="">
             <input type="hidden" id="token" value="{{csrf_token()}}">
             <input type="hidden" id="url" name="url" value="">
             <div class="modal-body">
               <label>Category Name</label>
               <input type="text" name="name" id="name" value="" class="form-control" placeholder="Ads Category Name">
            </div>
            <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-info">
         </div>
      </form>
   </div>
</div>
   @section('javascript')
   <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
   <script>

      $(document).ready(function () {
         $('body').on('click', '#submit', function (event) {
           event.preventDefault()
           var id = $("#category_id").val();
           var name = $("#name").val();
           var url = $("#url").val();

           $.ajax({
            url: url,
            type: "POST",
            data: {
             _token: $("#token").val(),
             id: id,
             name: name,
          },
          dataType: 'json',
          success: function (data) {

           $('#companydata').trigger("reset");
           $('#edit_modal').modal('hide');
           window.location.reload(true);
        }
     });
        });

         $('body').on('click', '.editcategory', function (event) {
           event.preventDefault();
           var id = $(this).data('id');
           $.get('adscategoryedit/' + id , function (data) {
            $('#userCrudModal').html("Edit category");
            $('#submit').val("Edit category");
            $('#edit_modal').modal('show');
            $('#category_id').val(data.data.id);
            $('#name').val(data.data.name);
            $('#url').val('edit_ads_category');
         })
        });

          $('body').on('click', '.create_category', function (event) {
           event.preventDefault();
            $('#userCrudModal').html("Add category");
            $('#submit').val("Add category");
            $('#edit_modal').modal('show');
            $('#category_id').val('');
            $('#name').val('');
            $('#url').val('add_ads_category');
        });

      }); 
   </script>
<script>

      $('body').on('click', '.delete', function (event) {
            delete_link = 'ads_category_delete/'+$(this).data('id');
            swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this category?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
             return false;
         });

   </script>
   @stop

   @stop

