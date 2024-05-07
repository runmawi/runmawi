@extends('admin.master')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/schedule_drag_drop.css')}}">
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=">
    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>

    <style>


    .drag-container {
        text-align: center;
        border: 1px solid #cecece;
        border-radius: 5px;
        box-shadow: 0px 0px 1px #747474;
    }

    .ScrollStyle {
        overflow-y: auto;
        max-height: 250px; /* Set a maximum height for the scrollable area */
    }

    .main-data-scr .draggable {
        margin-bottom: 0;
         width: 100%;
         flex-basis:45%;
         padding:0;
        /* display:flex;
        align-items:center; */
    }
    .draggable{
        width:100%;
        padding:0;
    }
    .drop-side .drag-container{
        display:flex;
        align-items:center;
        gap:10px;
    }
    
    input#video_id{
        border:none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100px;
    }
    /* body.dark .drop-zone{background-color: <?php echo GetAdminDarkBg(); ?>;} */
    body.dark input#video_id{background-color: <?php echo GetAdminDarkBg(); ?> !important; color: <?php echo GetAdminDarkText(); ?>!important;}

    .drop-zone {
        min-height: 100px; /* Set a minimum height for the drop zone */
        border: none;
        margin-bottom: 10px;
        display: list-item;
        flex-wrap:wrap;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Adjust the column width as needed */
        gap: 10px;
        padding: 10px;
        overflow-x:hidden;
        margin:2px;
        border-radius:0;
    }

    .form-control {
        width: 100%; /* Ensure the form controls take up the full width of their container */
    }
    .select2-selection__rendered{
        height: calc(1.5em + 0.75rem + 2px);
    }
    .select2-container--default .select2-selection--single{
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        height: calc(1.5em + 0.75rem + 2px) !important;
        background: transparent !important;
        line-height: 1.2 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top:5px !important;
    }
        .drag-container .form-control:disabled, .drag-container .form-control[readonly] {
        background-color: transparent !important;
        padding: 10px 5px;
        font-size: 14px;
        border:none;
        text-align:left;
    }

    .drag-container img {
        /* object-fit: cover !important; */
        height: auto !important;
        width: 3%;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .drag-container {
        text-align: center;
        border: 0px solid #cecece;
        border-radius: 5px;
        box-shadow: none;
        display:flex;
    }
    .filterButton{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        flex-basis: 30%;
    }
    .main-data-scr input{
        text-align:center;
    }
    .main-data-scr img{
        width: 10%;
    }
    tbody{
        border: 1px solid #dee2e6;
    }
    table.dataTable thead th, table.dataTable thead td{
        border-bottom: 0px !important;
    }
    .form-control{
        border-radius: 0px !important;
    }
    .border-rigt{
        border-right: 1px solid #dee2e6;
    }
    .border-lft{
        border-left: 1px solid #dee2e6;
    }
    div.dataTables_wrapper div.dataTables_filter input{
        border: 1px solid #aaa !important;
        border-radius: 0px;
    }
    .drop-side input{
        border: none;
    }
    </style>

<style>
  .action-icons {
        position: relative;
        display: flex;
    }

    .hidden-buttons {
        position: absolute;
        top: 100%;
        left: 0;
        display: none;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .action-icons:hover .hidden-buttons {
        display: block;
    }

    .hidden-buttons button {
        display: block;
        width: 100%;
        text-align: left;
    }
    input{
        color:#000 !important;
    }
    body.dark table.dataTable.no-footer{border-bottom: 1px solid <?php echo GetAdminDarkText(); ?>!important;} /* #9b59b6 */

</style>

    @section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Scheduler :</h4>
                </div>
            </div>
             

                <div class="clear"></div>
                <br>
                <h4 class="card-title container-fluid"> </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control js-example-basic-single" name="channe_id" id="channe_id">
                                @foreach($Channels as $key => $Channel)
                                    <option value="{{ @$Channel->id }}">{{ @$Channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control js-example-basic-single" name="time_zone_id" id="time_zone_id">
                                @foreach($TimeZone as $key => $time_zone)
                                    <option value="{{ @$time_zone->id }}">{{ @$time_zone->time_zone }} {{ '(UTC'.@$time_zone->utc_difference.')' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="date form-control" value="{{ date('m-d-Y') }}">
                        </div>
                    </div>
                    
                </div>
              
                <!-- <div class="row"> -->
                    <!-- <h4 class="container-fluid mt-3">Drag Video and Drop for Scheduling:</h4> -->
                <div class="col-md-12">
                    <div class="row mt-4">
                        <div class="col-md-8 col-sm-8"></div>
                        <div class="col-md-4 col-sm-4 d-flex">
                            <div class="search-container" style="flex-basis:70%; padding: 0 5px 0 0;">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                            </div>
                            <div class="filter-container">
                                    <select id="filterDropdown" class="form-control">
                                        <option value="all">All</option>
                                        <option value="Video">Video</option>
                                        <option value="LiveStream">LiveStream</option>
                                        <option value="Episode">Episode</option>
                                    </select>
                                </div>
                            <!-- <div class="filterButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </div> -->
                        </div>
                            
                        <!-- </div> -->
                            <div class="d-flex justify-content-end" style="width:100%">
                                
                            </div>
                        </div>
                    </div>
                    <!-- Time Update Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Channel Scheduler Time</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <label for="editStartTime">Start Time:</label>
                                <input type="text" id="editStartTime" class="form-control" />

                                <label for="editEndTime">Video Duration:</label>
                                <input type="text" id="Duration" class="form-control" readonly/>

                                <label for="editEndTime">End Time:</label>
                                <input type="text" id="editEndTime" class="form-control" readonly />
                                <input type="hidden" id="channel_Id">
                                <input type="hidden" id="Scheduler_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id ="saveChangesBtn" >Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>

                     <!-- Reschedule Modal -->
                     <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rescheduleModalLabel">Channel Video Re-Scheduler</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                
                                <label for="rescheduleDate">Choose Date to Re-Schedule:</label>
                                <input type="text" id="Scheduler_date" class="re-schedule-date form-control" value="{{ date('m-d-Y') }}">
                                <input type="hidden" id="channel_Id">
                                <input type="hidden" id="Scheduler_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id ="saveReSchedule" >Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                     <div class="row mt-4">
                        <div class="col-md-3 p-0">
                            <div class="drop-zone ScrollStyle MainData main-data-scr" >
                                @foreach(@$VideoCollection as $value)

                                <div class="draggable" draggable="true" ondragstart="drag(event)">
                                    <div class="drag-container" data-class="{{ $value->id }}" data-socure_type="{{ $value->socure_type }}">
                                        <img src="{{ URL::to('/public/uploads/images/').'/'.$value->image }}" alt="" width="100" height="100">
                                        <input type="text" class="form-control  video_{{ $value->id }}" value="{{ $value->title }}" readonly>
                                        <input type="hidden" class="form-control video_{{ $value->socure_type }}" value="{{ $value->socure_type }}" readonly>
                                        <p>{{ $value->duration != null ? gmdate('H:i:s', $value->duration)  : null  }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-9 drop-side p-0">
                                <div class="drop-zone ScrollStyle" ondrop="drop(this)" ondragover="allowDrop(this)" style="height:100%;"></div>

                        </div>
                </div>
            </div>
            <br>
            <!-- <button style="margin-bottom: 10px" class="btn btn-primary delete_all" >Delete Selected Video</button> -->

                    <div class="row">
                            <div class="col-md-12">
                                        <table class="table " id="schedule_videos_table" style="width:100%">
                                            <thead>
                                                <tr class="r1">
                                                    <!-- <th>#</th> -->
                                                    <th class="border-lft">Content Name</th>
                                                    <!-- <th>Content Title</th> -->
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Duration</th>
                                                    <th class="border-rigt">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                
                            </div>
                    </div>
            </div>

            <br>
        <br>

        </div>
    </div>
</div>
    

@section('javascript')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  
    <script src="<?=URL::to("/assets/js/jquery.mask.min.js") ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

        <!-- Include DataTables CSS and JS files -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <script type="text/javascript">



     $(document).on('click', '.remove-btn', function () {

            var dataId = $(this).data('id');
            if (confirm('Are you sure you want to delete this item?')) {
                RemoveSchedulers(dataId);
            }
        });

        function RemoveSchedulers(dataId) {
              
            // alert(dataId);
            $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
                url: "{{ URL::to('admin/remove-scheduler/') }}",
                type: "post",
                data: {
                        _token: '{{ csrf_token() }}',
                        Scheduler_id : dataId,
                },        
                success: function(value){
                    $('tbody').html(value.table_data);
                        Swal.fire({
                                title: 'Removed the Video !',
                        })
                    location.reload();                            
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching Channel details:', error);
                }
            });

        }

    // Script For Time Update for Scheduler 


        $(document).on('change', '.date,#time_zone_id,#channe_id', function () {
                getAllChannelDetails();
        });

        function getAllChannelDetails() {
            $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
                url: "{{ URL::to('admin/get-all-channel-details/') }}",
                type: "post",
                data: {
                        _token: '{{ csrf_token() }}',
                        time     : $('.date').val(),
                        time_zone: $('#time_zone_id').val(),
                        channe_id: $('#channe_id').val(),
                },        
                success: function(value){
                    $('tbody').html(value.table_data);
                    $('#schedule_videos_table').DataTable();
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching Channel details:', error);
                }
            });

        }

    // Script For Time Update for Scheduler 

        var originalStartTime = '';
        var originalEndTime = '';
        var originalDuration = '';

        $(document).ready(function($){
            $('#editStartTime').mask("00:00:00");
            $('#editEndTime').mask("00:00:00");
            $('#Duration').mask("00:00:00");
        });

        $('#editStartTime').on('change', function () {
            calculateEndTime();
        });

        function calculateEndTime() {
            var startTime = $('#editStartTime').val();
            var duration = $('#Duration').val();

            if (startTime && duration) {
                var startTimeMoment = moment(startTime, 'HH:mm:ss');
                var durationMoment = moment(duration, 'HH:mm:ss');

                var endTimeMoment = startTimeMoment.add(durationMoment.hours(), 'hours');
                endTimeMoment.add(durationMoment.minutes(), 'minutes');
                endTimeMoment.add(durationMoment.seconds(), 'seconds');

                var endTime = endTimeMoment.format('HH:mm:ss');

                $('#editEndTime').val(endTime);
            }
        }

        function getVideoDetails(channelId) {
            $.ajax({
                url: "{{ URL::to('admin/get-channel-details/') }}" + "/" + channelId,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    $('#editStartTime').val(data.start_time);
                    $('#editEndTime').val(data.end_time);
                    $('#Duration').val(data.duration);
                    $('#channel_Id').val(data.channe_id);
                    $('#Scheduler_id').val(data.id);
                    originalStartTime = data.start_time;
                    originalEndTime = data.end_time;
                    originalDuration = data.duration;
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching video details:', error);
                }
            });
        }

        $(document).on('click', '.edit-btn', function () {
                var channelId = $(this).data('id');
                // alert(channelId);
                getVideoDetails(channelId);
                $('#editModal').modal('show');
        });

        $(document).on('click', '#saveChangesBtn', function () {
            saveChanges();
        });

        

        function saveChanges() {   
                if ($('#editStartTime').val() !== originalStartTime) {

                    $.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ URL::to('admin/Scheduler-UpdateTime/')  }}",
                        type: "post", // Use "get" instead of "post"
                        data: {
                            _token: '{{ csrf_token() }}',
                            editStartTime:  $('#editStartTime').val(),
                            editEndTime:    $('#editEndTime').val(),
                            Duration:       $('#Duration').val(),
                            channe_id:      $('#channel_Id').val(),
                            Scheduler_id:   $('#Scheduler_id').val(),
                            SchedulerDate:  $('.date').val(),
                        },        
                        success: function(value){
                            $('#editModal').modal('hide');
                            Swal.fire({
                                title: 'Updated Time for Scheduled Videos !',
                            })
                            location.reload();                            
                        }
                    });
                } else {
                    Swal.fire({
                    title: 'Edit StartTime not changed !',
                })
            }
        }

        // Script For rescheduler
        
        $(document).on('click', '.rescheduler-btn', function () {
                var channelId = $(this).data('id');
                // alert(channelId);
                getVideoDetails(channelId);
                $('#editModal').modal('show');
        });

        function getChannelDetail(channelId) {

            $.ajax({
                url: "{{ URL::to('admin/get-channel-details/') }}" + "/" + channelId,
                type: "get",
                dataType: 'json',
                success: function (data) {

                    $('#Scheduler_date').val(data.choosed_date);
                    $('#channel_Id').val(data.channe_id);
                    $('#Scheduler_id').val(data.id);

                },
                error: function (xhr, status, error) {
                    console.error('Error fetching Channel details:', error);
                }
            });

        }

        $(document).on('click', '#saveReSchedule', function () {
            saveReScheduleChanges();
        });

        
        function saveReScheduleChanges() {   
                    $.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        url: "{{ URL::to('admin/Scheduler-ReSchedule/')  }}",
                        type: "post", // Use "get" instead of "post"
                        data: {
                            _token: '{{ csrf_token() }}',
                            channe_id:      $('#channel_Id').val(),
                            Scheduler_id:   $('#Scheduler_id').val(),
                            SchedulerDate:  $('.re-schedule-date').val(),
                        },        
                        success: function(value){
                            $('#editModal').modal('hide');
                            if(value == 0){
                                Swal.fire({
                                    title: "Can't Set Re Schedule In same day",
                                })
                            }else{
                                Swal.fire({
                                    title: 'Re Scheduled Videos !',
                                })
                                location.reload();    
                            }
                      
                        }
                    });
            }
        


    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ URL::to('admin/Scheduled-videos/')  }}",
            type: "get", // Use "get" instead of "post"
            data: {
                _token: '{{ csrf_token() }}',
                time: $('.date').val(),
                time_zone:  $('#time_zone_id').val(),
                channe_id: $('#channe_id').val(),
            },        
            success: function(value){
                
                $('tbody').html(value.table_data);
                $('#schedule_videos_table').DataTable();
            }
        });

    });
// $(document).ready(function () {

        // $('#filterDropdown').hide();
        $('.filterButton').click(function(){ 
            // alert();
            // $('#filterDropdown').toggle();
        });

//         // Function to filter items based on the selected filter option
//         function filterItems(filterValue) {

//             $.ajax({
//                 url:"{{ URL::to('admin/filter-scheduler') }}",
//                 type: 'GET',
//                 data: { filter: filterValue },
//                 dataType: 'json',
//                 success: function (data)
//                 {

//                     $('.MainData').empty();
//                     var imageURL = "{{ URL::to('/public/uploads/images/') }} ";
//                     // Append new items based on the returned data
//                     $.each(data, function (index, value) {
//                     // console.log(value);
//                         var newItem = $('<div class="draggable">' +
//                             '<img src="' + imageURL +'/'+ value.image + '" alt="" width="50" height="50">' +
//                             '<input type="text" data-class="' + value.id + '" data-socure_type="' + value.socure_type + '" id="source_id" draggable="true" ondragstart="drag(this)" class="form-control video_' + value.id + '" value="' + value.title + '" readonly>' +
//                             '</div>');
//                         $('.MainData').append(newItem); // Append to .MainData
//                     });
//                 },
//                 error: function (xhr, status, error) {
//                 console.error('Error fetching data:', error);
//                 }
//             });
//         }

//         // Event listener for the dropdown change
        $('#filterDropdown').on('change', function () {
            var filterValue = $(this).val();
            filterItems(filterValue);
        });
        function filterItems(filterValue) {

            if(filterValue == 'all'){
                location.reload();                            
            }
            
            searchTerm = filterValue.toLowerCase();
        
            $('.draggable').each(function () {
                var itemText = $(this).find('input[type="hidden"]').val().toLowerCase();
                if (itemText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

        }

//         // Initial filtering based on the default selected option
//         filterItems($('#filterDropdown').val());
//     });


//     // Search Data 
    
    $(document).ready(function () {
        // Function to filter items based on the search input
        function filterItems(searchTerm) {
            searchTerm = searchTerm.toLowerCase();
            $('.draggable').each(function () {
                var itemText = $(this).find('input[type="text"]').val().toLowerCase();
                if (itemText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Event listener for the search input
        $('#searchInput').on('input', function () {
            var searchTerm = $(this).val();
            filterItems(searchTerm);
        });
    });


        // $('.re-schedule-date').datepicker({  
        //     format: 'm-dd-yyyy'
        // });  

        $('.re-schedule-date').datepicker({
            format: 'm-dd-yyyy',
            startDate: '+1d', // Set the minimum date to tomorrow
            autoclose: true
        });

        var currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + 1); // Set the date to tomorrow
        var formattedDate = (currentDate.getMonth() + 1) + '-' + currentDate.getDate() + '-' + currentDate.getFullYear();
    
        $('.re-schedule-date').datepicker('setDate', formattedDate); // Set the selected date

        $('.date').datepicker({  
            format: 'm-dd-yyyy'
        });  


        var currentDate = new Date();
        var formattedDate = (currentDate.getMonth() + 1) + '-' + currentDate.getDate() + '-' + currentDate.getFullYear();
        // alert(formattedDate);
        $('.date').val(formattedDate);
        // $('.re-schedule-date').val(formattedDate);
        $('.js-example-basic-single').select2();

//     </script>
   <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script src="<?=URL::to("/assets/js/jquery.mask.min.js") ?>"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>

    initDragAndDrop();

    function initDragAndDrop() {
        // Collect all draggable elements and drop zones
        let draggables = document.querySelectorAll(".draggable");
        let dropZones = document.querySelectorAll(".drop-zone");
        initDraggables(draggables);
        initDropZones(dropZones);
    }

    function initDraggables(draggables) {
        for (const draggable of draggables) {
            initDraggable(draggable);
        }
    }

    function initDropZones(dropZones) {
        for (let dropZone of dropZones) {
            initDropZone(dropZone);
        }
    }


    function initDraggable(draggable) {
        draggable.addEventListener("dragstart", dragStartHandler);
        draggable.addEventListener("drag", dragHandler);
        draggable.addEventListener("dragend", dragEndHandler);

        // set draggable elements to draggable
        draggable.setAttribute("draggable", "true");
    }

    function initDropZone(dropZone) {
        dropZone.addEventListener("dragenter", dropZoneEnterHandler);
        dropZone.addEventListener("dragover", dropZoneOverHandler);
        dropZone.addEventListener("dragleave", dropZoneLeaveHandler);
        dropZone.addEventListener("drop", dropZoneDropHandler);
    }

    function dragStartHandler(e) {
        setDropZonesHighlight();
        this.classList.add('dragged', 'drag-feedback');
        e.dataTransfer.setData("type/dragged-box", 'dragged');
        e.dataTransfer.setData("text/plain", this.innerHTML);
        deferredOriginChanges(this, 'drag-feedback');
    }

    function dragHandler() {
        // do something... if you want
    }

    function dragEndHandler() {
        setDropZonesHighlight(false);
        this.classList.remove('dragged');
    }

    function dropZoneEnterHandler(e) {

        if (e.dataTransfer.types.includes('type/dragged-box')) {
            this.classList.add("over-zone");
            e.preventDefault();
        }
    }
        
    function dropZoneOverHandler(e) {
        if (e.dataTransfer.types.includes('type/dragged-box')) {
            e.preventDefault();
        }
    }


    function dropZoneLeaveHandler(e) {
        if (e.dataTransfer.types.includes('type/dragged-box') &&
            e.relatedTarget !== null &&
            e.currentTarget !== e.relatedTarget.closest('.drop-zone')) {
            this.classList.remove("over-zone");
        }
    }

    function dropZoneDropHandler(e,ele) {
              
        let draggedElement = document.querySelector('.dragged');
        e.currentTarget.appendChild(draggedElement);
        e.preventDefault();

    }


    function setDropZonesHighlight(highlight = true) {
        const dropZones = document.querySelectorAll(".drop-zone");
        for (const dropZone of dropZones) {
            if (highlight) {
                dropZone.classList.add("active-zone");
            } else {
                dropZone.classList.remove("active-zone");
                dropZone.classList.remove("over-zone");
            }
        }
    }

    function deferredOriginChanges(origin, dragFeedbackClassName) {
        setTimeout(() => {
            origin.classList.remove(dragFeedbackClassName);
        });
    }


    var video_id = '';
    var socure_type = '';
 


    function allowDrop(ev) {
    //   ev.preventDefault();
    }

    // function drag(ev) {

    // var video_id = $(ev).attr('data-class');
    // var socure_type = $(ev).attr('data-socure_type');
    // drop(video_id,socure_type);
    // }


    function drag(ev) {
        var container = ev.target.closest('.draggable');
        var video_id = container.querySelector('.drag-container').getAttribute('data-class');
        var socure_type = container.querySelector('.drag-container').getAttribute('data-socure_type');
        drop(video_id, socure_type);
    }


    function drop(video_id,socure_type) {

        console.log(video_id);
        console.log(socure_type);

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });


            var url = "{{ URL::to('admin/drag-drop-Scheduler-videos/')  }}";
            var time = $('.date').val();
            let time_zone = $('#time_zone_id').val();
            let channe_id = $('#channe_id').val();
            $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
            url: url,
            type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                        socure_id: video_id,
                        time: time,
                        time_zone: time_zone,
                        channe_id: channe_id,
                        socure_type: socure_type,
                },        
                success: function(value){
                    if(value == "Can't Set Video before current date"){
                        Swal.fire({
                                title: "Can't Set Scheduled Before Current date",
                        })
                    }
                    $('tbody').html(value.table_data);
                    $('#schedule_videos_table').DataTable();
                    
            }
        });

    }



    </script>

@stop

@stop
