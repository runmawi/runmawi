@extends('admin.master')

<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/schedule_drag_drop.css')}}">
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=">
    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>

    <style>
         .ScrollStyle {
        overflow-y: auto;
        max-height: 200px; /* Set a maximum height for the scrollable area */
    }

    .draggable {
        margin-bottom: 10px;
    }

    .drop-zone {
        min-height: 100px; /* Set a minimum height for the drop zone */
        border: 2px dashed #ccc;
        margin-bottom: 10px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Adjust the column width as needed */
        gap: 10px;
        padding: 10px;
    }

    .form-control {
        width: 100%; /* Ensure the form controls take up the full width of their container */
    }
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
                                    <option value="{{ @$time_zone->id }}">{{ @$time_zone->time_zone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="date form-control">
                        </div>
                    </div>
                    
                </div>
              
                <!-- <div class="row"> -->
                    <h4 class="container-fluid mt-3">Drag Video and Drop for Scheduling:</h4>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="search-container">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                            </div>
                        </div>
                            <div class="col-md-2 filterButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                                <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </div>
                        <!-- </div> -->
                            <div class="filter-container">
                                <select id="filterDropdown" class="form-control">
                                    <option value="all">All</option>
                                    <option value="Video">Video</option>
                                    <option value="LiveStream">LiveStream</option>
                                    <option value="Episode">Episode</option>
                                    <option value="Audio">Audio</option>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                     <div class="col-md-6 p-0">
                        <div class="drop-zone ScrollStyle MainData">
                                        @foreach(@$VideoCollection as $value)
                                        <div class="draggable">
                                            <img src="{{ URL::to('/public/uploads/images/').'/'.$value->image }}" alt="" width="50" height="50">
                                            <input type="text" data-class="{{ $value->id }}" id="source_id" draggable="true" ondragstart="drag(this)" class=" form-control video_{{ $value->id }}" value="{{ $value->title }}" readonly>
                                            <!-- <div class="video_id{{ $value->id }}" data-toggle="modal" data-target="#video" data-name="{{ $value->id }}"  onclick="dropZoneDropHandler(this)"  >{{ $value->title }}</div> -->
                                        </div>
                                        @endforeach
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="drop-zone ScrollStyle" ondrop="drop(this)" ondragover="allowDrop(this)"></div>
                        </div>
                </div>
            </div>
            <br>
            <button style="margin-bottom: 10px" class="btn btn-primary delete_all" >Delete Selected Video</button>

                <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="schedule_videos_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>Select All <input type="checkbox" id="select_all"></th>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Schedule Date</th>
                                            <th>Scheduled Starttime</th>
                                            <th>Schedule Endtime</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    
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

    <script type="text/javascript">


$(document).ready(function () {

        $('#filterDropdown').hide();
        $('.filterButton').click(function(){ 
            // alert();
            $('#filterDropdown').toggle();
        });

        // Function to filter items based on the selected filter option
        function filterItems(filterValue) {

            $.ajax({
                url:"{{ URL::to('admin/filter-scheduler') }}",
                type: 'GET',
                data: { filter: filterValue },
                dataType: 'json',
                success: function (data)
                {

                    $('.MainData').empty();
                    var imageURL = "{{ URL::to('/public/uploads/images/') }} ";
                    // Append new items based on the returned data
                    $.each(data, function (index, value) {
                    console.log(value);
                        var newItem = $('<div class="draggable">' +
                            '<img src="' + imageURL +'/'+ value.image + '" alt="" width="50" height="50">' +
                            '<input type="text" data-class="' + value.id + '" id="source_id" draggable="true" ondragstart="drag(this)" class="form-control video_' + value.id + '" value="' + value.title + '" readonly>' +
                            '</div>');
                        $('.MainData').append(newItem); // Append to .MainData
                    });
                },
                error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
                }
            });


            // $('.draggable').each(function () {
            //     var itemCategory = $(this).find('input[type="text"]').data('category');
            //     if (filterValue === 'all' || itemCategory === filterValue) {
            //         $(this).show();
            //     } else {
            //         $(this).hide();
            //     }
            // });
        }

        // Event listener for the dropdown change
        $('#filterDropdown').on('change', function () {
            var filterValue = $(this).val();
            filterItems(filterValue);
        });

        // Initial filtering based on the default selected option
        filterItems($('#filterDropdown').val());
    });


    // Search Data 
    
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

    $('.date').datepicker({  
       format: 'mm-dd-yyyy'
     });  
    
    var currentDate = new Date();
    var formattedDate = (currentDate.getMonth() + 1) + '-' + currentDate.getDate() + '-' + currentDate.getFullYear();
    $('.date').val(formattedDate);
// $(".deleteVideo").click(function(){
//         var id = $(this).data("id");
//         var token = $(this).data("token");
//         var url = '<?php echo URL::to('admin/schedule/delete') ?>';

//         alert(url+'/'+id);
//         $.ajax(
//         {
//             url:url+'/'+id,
//             type: 'GET',
//             dataType: "JSON",
//             data: {
//                 "id": id,
//                 "_method": 'get',
//                 "_token": token,
//             },
//             success: function ()
//             {
//                 // console.log("it Work");
//                 location.reload();
//             }
//         });

//         console.log("It failed");
//     });


      $('#choose_start_time').mask("00:00 AM");
      $('#choose_end_time').mask("00:00 AM");
      $('.js-example-basic-single').select2();

    </script>

  <script>
    

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    $(document).ready(function(){

        var url = "{{ URL::to('admin/IndexScheduledVideos/')  }}";

        $.ajax({
            url: url,
            type: "GET",      
            success: function (data) {
                console.log(data);
            },
            error: function() { 
                console.log(data);
            }
        });
    });

  </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $('#reschedule_oneday').click(function(){
                // alert();
                let oneday = $('#reschedule_oneday').val();
                  var url = "{{ URL::to('admin/reschedule_oneday/')  }}";
                let time_zone = $('#time_zone').val();
                
                    $.ajax({
                    url: url,
                    type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                                oneday: 'one',
                                month: month,
                                year: year,
                                date: date,
                                schedule_id: schedule_id,
                        },        
                        success: function(value){
                        console.log(value.message);
                        if(value.message == 'Added Successfully'){
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Videos Reschedule Successfully</div>');
                                setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                                }, 3000);
                        }else if(value.message == 'No Video'){
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">No Video Available to Reschedule</div>');
                                setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                                }, 3000);
                        }else if(value.message == 'Already Added'){
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Alreay Video is Reschedule</div>');
                                setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                                }, 3000);
                        }
                    }
                });
            });

            $('#reschedule_week').click(function(){
                

            });
        // 
    </script>
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
    e.dataTransfer.setData("text/plain", this.textContent.trim());
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
 


function allowDrop(ev) {
//   ev.preventDefault();
}

function drag(ev) {

var video_id = $(ev).attr('data-class');
// console.log(video_id);
drop(video_id);
}

function drop(video_id) {

    console.log(video_id);

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


        var url = "{{ URL::to('admin/dragdropScheduledVideos/')  }}";
        var time = $('#time').val();
        let time_zone = $('#time_zone').val();

        $.ajax({
           url: url,
           type: "post",
            data: {
                  _token: '{{ csrf_token() }}',
            },        
            success: function(value){
   			console.log(value);
               if(value == ''){
                        alert('Please Choose Time');
                    }else if(value.schedule_time == 'Today Slot Are Full'){
                        swal.fire({
                    // title: 'Oops', 
                    text: 'Today Slot Are Full Please Change The Calendar and Start Schedule!', 
                    allowOutsideClick:false,
                    // icon: 'error',
                    // title: 'Oops...',
                    });
                        // alert('Today Slot Are Full Please Change The Calendar and Start Schedule.');
                    }else if(value.schedule_time == 'Change the Slot time'){
                        swal.fire({
                    // title: 'Oops', 
                    text: 'Change The Slot And Please Start to Schedule!', 
                    allowOutsideClick:false,

                    });
                    }else if(value.schedule_time == 'Video End Time Exceeded today Please Change the Calendar Date to Add Schedule'){
                        swal.fire({
                    // title: 'Oops', 
                    text: 'Video End Time Exceeded today Please Change the Calendar Slot to Add Schedule!', 
                    allowOutsideClick:false,

                    });
                    }else{
                        $('tbody').html(value.table_data);
                    }
           }
       });

}


$(".deleteVideo").click(function(){
        var id = $(this).data("id");
        var token = $(this).data("token");
        var url = '<?php echo URL::to('admin/schedule/delete') ?>';

        // alert(url+'/'+id);
        $.ajax(
        {
            url:url+'/'+id,
            type: 'GET',
            dataType: "JSON",
            data: {
                "id": id,
                "_method": 'get',
                "_token": token,
            },
            success: function ()
            {
                // console.log("it Work");
                // location.reload();
                // history.go(0);
                alert('Deleted Succefully..!');

            }
        });

        console.log("It failed");
        
    });

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
    // alert(allVals);
 if(allVals.length <=0)  
 {  
       alert("Please select Anyone video");  
 }  
 else 
 {  
    var check = confirm("Are you sure you want to delete selected videos?");  
    if(check == true){  
        var join_selected_values =allVals.join(","); 
      
        $.ajax({
          url: '{{ URL::to('admin/ScheduleVideoBulk_delete') }}',
          type: "get",
          data:{ 
             _token: "{{csrf_token()}}" ,
             video_id: join_selected_values, 
             month: month, 
             date: date, 
             year: year, 
          },

          success: function(value){
   			console.log(value);
               if(value == ''){
                    swal.fire({
                    title: 'Oops', 
                    text: 'Something went wrong!', 
                    allowOutsideClick:false,
                    icon: 'error',
                    title: 'Oops...',
                    });
                }else{
                    $('tbody').html(value.table_data);
                }
           }


       });
    }  
 }  
});


</script>

@stop

@stop
