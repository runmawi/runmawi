@extends('admin.master')
<style>
     .form-control {   
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
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

@section('content')
     <div id="content-page" class="content-page">
         
         <div class="container-fluid p-0">
            <div class="row ">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header ">

                        <div class="col-md-6">
                            <h4><i class="entypo-archive"></i> Bulk Import Export : </h4>
                        </div>
                        <br>

                     @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif

                     @if (Session::has('error_message'))
                            <div id="successMessage" class="alert alert-danger ">{{ Session::get('error_message') }}</div>
                     @endif
                    
                        @if (count($errors) > 0)
                        @foreach ($errors->all() as $message)
                            <div class="alert alert-danger display-hide" id="successMessage">
                                <button id="successMessage" class="close" data-close="alert"></button>
                                <span>{{ $message }}</span>
                            </div>
                        @endforeach
                    @endif
                    <div class="clear"></div>

                        <div class="iq-card-header-toolbar d-flex justify-content-between d-flex align-items-baseline">
                        <div class="form-group mr-2">                  
                           <select id="Bulk_Management" name="Bulk_Management"  class="form-control" >
                              <option value="select">Select Management</option>
                                 <option value="Videos">Videos</option>
                                 <option value="Series">Series</option>
                                 <option value="Episode">Episode</option>
                                 <option value="Audios">Audios</option>
                              </select>
                        </div>

                        <!-- <div class="form-group mr-2">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                        </div> -->

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalImport">
                           Import CSV
                        </button>

                        <button class="btn btn-primary newCSV"  id="newCSV">
                           Export CSV To Create
                        </button>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                           Export CSV To Update
                        </button>

                        </div>
                     </div>
                    <div class="Video_Management" id="Video_Management">
                            @include('admin.bulk_management.Videos')
                    </div>
                    <div class="Series_Management" id="Series_Management">
                           @include('admin.bulk_management.Series')
                    </div>
                    <div class="Episode_Management" id="Episode_Management">
                           @include('admin.bulk_management.Episode')
                    </div>
                    <div class="Audios_Management" id="Audios_Management">
                           @include('admin.bulk_management.Audios')
                    </div>
                    </div>
                    </div>
  

      <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Export Csv</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                       <div class="col-md-12">
                              <label class="m-0">Enter From ID</label>
                              <input type="text" class="form-control" placeholder="Enter From ID" name="video_start_id" id="video_start_id" value="@if(!empty($video->country_by_origin)){{ $video->country_by_origin }}@endif">
                              <span id="video_start_id_error" style="color:red; display:none;">* Please Enter a valid Video Start ID (only numbers)</span>
                       </div>         
                       <div class="col-md-12">
                              <label class="m-0">Enter To ID</label>
                              <input type="text" class="form-control" placeholder="Enter To ID" name="video_end_id" id="video_end_id" value="@if(!empty($video->country_by_origin)){{ $video->country_by_origin }}@endif">
                              <span id="video_end_id_error" style="color:red; display:none;">* Please Enter a valid Video End ID (only numbers)</span>
                       </div>          
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id = "Export" class="btn btn-primary">Export</button>
                  </div>
               </div>
            </div>
            </div>

 <!-- Modal -->
 <div class="modal fade" id="exampleModalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalImport" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelImport">Import Csv</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <form action="{{ URL::to('admin/bulk_import') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-md-12">

                        <label for="create_data">
                              <input type="radio" id="create_data" name="Bulk_Import_Type" value="createdata">
                              Create CSV Data
                           </label>
                           <br>
                           <label for="update_data">
                              <input type="radio" id="update_data" name="Bulk_Import_Type" value="updatedata">
                              Update CSV Data
                           </label>
                            <br>
                            <label for="">Upload Csv</label>
                            <br>
                            <input type="file" name="csv_file" accept=".csv">
                            <br>
                            <span id="csv_file_error" style="color:red;">* Choose Video Csv File</span>
                            <br>
                            <input type="hidden" name="Bulk_Management" id="CSV_Bulk_Management">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </div>           
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" id = "Import" class="btn btn-primary"value="Upload">
                    </div>
                  </form>

               </div>
            </div>
            </div>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

          <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>


document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("Export").addEventListener("click", function () {
            var video_start_id = document.getElementById("video_start_id").value.trim();
            var video_end_id = document.getElementById("video_end_id").value.trim();

            // Regular expression to check if the value contains only numbers
            var numberRegex = /^[0-9]+$/;

            if (!numberRegex.test(video_start_id)) {
                document.getElementById("video_start_id_error").style.display = "block";
                return;
            } else {
                document.getElementById("video_start_id_error").style.display = "none";
            }

            if (!numberRegex.test(video_end_id)) {
                document.getElementById("video_end_id_error").style.display = "block";
                return;
            } else {
                document.getElementById("video_end_id_error").style.display = "none";
            }

            // Proceed with your export functionality if validation passes
            // Add your export code here
        });
    });

  		$(document).ready(function() {
			setTimeout(function() {
				$('#successMessage').fadeOut('fast');
			}, 3000);
		})
    $(document).ready(function() {
        $('.movie_table').DataTable();
        $('.series_table').DataTable();
    });

   $('#video_start_id_error').hide();
   $('#video_end_id_error').hide();
   $('#csv_file_error').hide();

    $(document).ready(function() {

    
        $('#Series_Management').hide();
        $('#Episode_Management').hide();
        $('#Audios_Management').hide();

        $('#Bulk_Management').change(function(){
            var Bulk_Management = $('#Bulk_Management').val();
            $('#CSV_Bulk_Management').val(Bulk_Management);
            if(Bulk_Management == 'Videos'){
                $('#Video_Management').show();
                $('#Series_Management').hide();
                $('#Episode_Management').hide();
                $('#Audios_Management').hide();

            }else if(Bulk_Management == 'Series'){
                $('#Series_Management').show();
                $('#Episode_Management').hide();
                $('#Video_Management').hide();
                $('#Audios_Management').hide();

            }else if(Bulk_Management == 'Episode'){
                $('#Episode_Management').show();
                $('#Video_Management').hide();
                $('#Series_Management').hide();
                $('#Audios_Management').hide();

            }else if(Bulk_Management == 'Audios'){
                $('#Video_Management').hide();
                $('#Series_Management').hide();
                $('#Episode_Management').hide();
                $('#Audios_Management').show();

            }else{
                $('#Video_Management').show();
                $('#Series_Management').hide();
                $('#Episode_Management').hide();
                $('#Audios_Management').hide();
            }

        });


         $('#newCSV').click(function(){

            var Bulk_Management = $('#Bulk_Management').val();

               if(Bulk_Management == 'Videos'){
                  var Excel_url =  "{{ URL::to('storage/app/Createvideos.csv')  }}";
               }else if(Bulk_Management == 'Series'){
                  var Excel_url =  "{{ URL::to('storage/app/Createseries.csv')  }}";
               }else if(Bulk_Management == 'Episode'){
                  var Excel_url =  "{{ URL::to('storage/app/Createepisodes.csv')  }}";
               }else if(Bulk_Management == 'Audios'){
                  var Excel_url =  "{{ URL::to('storage/app/Createaudios.csv')  }}";
               }else{
                  var Excel_url =  "{{ URL::to('storage/app/Createvideos.csv')  }}";
               }
                           location.href = Excel_url;
         });



         $('#Export').click(function(){
            if( $('#video_start_id').val() == ''){
               $('#video_start_id_error').show();
            }else{
               $('#video_start_id_error').hide();
            }
            if( $('#video_end_id').val() == ''){
               $('#video_end_id_error').show();
            }else{
               $('#video_end_id_error').hide();
            }

            if( $('#video_start_id').val() != '' &&  $('#video_end_id').val() != ''){

               var Bulk_Management = $('#Bulk_Management').val();

               if(Bulk_Management == 'Videos'){
                  var url = "{{ url('admin/video_bulk_export') }}";
                  var Excel_url =  "{{ URL::to('storage/app/videos.csv')  }}";
               }else if(Bulk_Management == 'Series'){
                  var url = "{{ url('admin/series_bulk_export') }}";
                  var Excel_url =  "{{ URL::to('storage/app/series.csv')  }}";
               }else if(Bulk_Management == 'Episode'){
                  var url = "{{ url('admin/episode_bulk_export') }}";
                  var Excel_url =  "{{ URL::to('storage/app/episodes.csv')  }}";
               }else if(Bulk_Management == 'Audios'){
                  var url = "{{ url('admin/audios_bulk_export') }}";
                  var Excel_url =  "{{ URL::to('storage/app/audios.csv')  }}";
               }else{
                  var url = "{{ url('admin/video_bulk_export') }}";
                  var Excel_url =  "{{ URL::to('storage/app/videos.csv')  }}";
               }


               $(document).ajaxStart(function() {
                     $('#loader').show();
               });

               // Hide loader when AJAX stops
               $(document).ajaxStop(function() {
                     $('#loader').hide();
               });

               $.ajax({
                  type: "POST", 
                  dataType: "json", 
                  url: url,
                        data: {
                           _token  : "{{csrf_token()}}" ,
                           video_start_id: $('#video_start_id').val(),
                           video_end_id: $('#video_end_id').val(),
                  },
                  success: function(data) {
                        if(data == 1){
                           location.href = Excel_url;
                        }
                       
                     },
               });
            }
            
         });
         
    });
</script>

@stop

