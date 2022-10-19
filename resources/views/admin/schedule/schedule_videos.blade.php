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

    <?php
$embed_url = URL::to("/schedule/videos/embed");
$embed_media_url = $embed_url . "/" . $schedule->name;
$url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '" frameborder="0" allowfullscreen></iframe>';
$media_url = URL::to("/schedule/videos") . "/" . $schedule->name;
?>

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Video Schedule :</h4>
                </div>
            </div>
             

                <div class="clear"></div>
                <br>
                <h4 class="card-title container-fluid">{{ $Calendar['date'].'/'.$Calendar['month'].'/'.$Calendar['year'] }} </h4>
                        <label for=""><h4 class="fs-title m-0 container-fluid">{{ $schedule->name }}</h4></label>
                    <div class="pull-right" style="margin-top: -5%;">
                        <form action="{{ URL::to('/schedule/videos') }}" accept-charset="UTF-8" method="post">
                            <input type="hidden" name="date" id= "date" value="{{ $Calendar['date'] }}">
                            <input type="hidden" name="month" id= "month" value="{{ $Calendar['month'] }}">
                            <input type="hidden" name="year" id= "year" value="{{ $Calendar['year'] }}">
                            <input type="hidden" name="schedule_id" id= "schedule_id" value="{{ $Calendar['schedule_id'] }}">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <button type="submit" class="btn btn-primary" id="submit-update-menu">Preview</button>
                        </form>
                    </div>
                <div class="row mt-4 container-fluid">
                    <div class="col-5">
                        <label for="">Choose Time</label><br>
                        <p style="color:black"> Select Timing Before Upload Video <span style="color:red;">*</span></p>
                        <select class="form-control" name="time" id="time" >
                            <option value="">Select Schedule Timing</option>
                            <option value="12:00 AM to 12:00 PM" {{ $current_time ==  'AM'? 'selected' : '' }}>12:00 AM to 12:00 PM</option>
                            <option value="12:00 PM to 12:00 AM" {{ $current_time == 'PM' ? 'selected' : '' }}>12:00 PM to 12:00 AM</option>
                            <!-- <option value="12:00 AM to 01:00 AM">12:00 AM to 01:00 AM</option>
                            <option value="01:00 AM to 02:00 AM">01:00 AM to 02:00 AM</option>
                            <option value="02:00 AM to 03:00 AM">02:00 AM to 03:00 AM</option>
                            <option value="03:00 AM to 04:00 AM">03:00 AM to 04:00 AM</option>
                            <option value="04:00 AM to 05:00 AM">04:00 AM to 05:00 AM</option>
                            <option value="05:00 AM to 06:00 AM">05:00 AM to 06:00 AM</option>
                            <option value="06:00 AM to 07:00 AM">06:00 AM to 07:00 AM</option>
                            <option value="07:00 AM to 08:00 AM">07:00 AM to 08:00 AM</option>
                            <option value="08:00 AM to 09:00 AM">08:00 AM to 09:00 AM</option>
                            <option value="09:00 AM to 10:00 AM">09:00 AM to 10:00 AM</option>
                            <option value="10:00 AM to 11:00 AM">10:00 AM to 11:00 AM</option>
                            <option value="11:00 AM to 12:00 PM">11:00 AM to 12:00 PM</option>
                            <option value="12:00 PM to 01:00 PM">12:00 PM to 01:00 PM</option>
                            <option value="01:00 PM to 02:00 PM">01:00 PM to 02:00 PM</option>
                            <option value="02:00 PM to 03:00 PM">02:00 PM to 03:00 PM</option>
                            <option value="03:00 PM to 04:00 PM">03:00 PM to 04:00 PM</option>
                            <option value="04:00 PM to 05:00 PM">04:00 PM to 05:00 PM</option>
                            <option value="05:00 PM to 06:00 PM">05:00 PM to 06:00 PM</option>
                            <option value="06:00 PM to 07:00 PM">06:00 PM to 07:00 PM</option>
                            <option value="07:00 PM to 08:00 PM">07:00 PM to 08:00 PM</option>
                            <option value="08:00 PM to 09:00 PM">08:00 PM to 09:00 PM</option>
                            <option value="09:00 PM to 10:00 PM">09:00 PM to 10:00 PM</option>
                            <option value="10:00 PM to 11:00 PM">10:00 PM to 11:00 PM</option>
                            <option value="11:00 PM to 12:00 AM">11:00 PM to 12:00 AM</option> -->
                        </select>
                        <!-- <label class="m-0">Start Time <small>(Please Time in this Format Hours:minutes PM/PM)</small></label>
                        <input type="text" class="form-control" id="choose_start_time" name="choose_start_time" value=""> -->
                        
                    </div>
                    <!-- <div class="col-3">
                        <label class="m-0">End Time <small>(Please Time in this Format Hours:minutes PM/PM)</small></label>
                        <input type="text" class="form-control" id="choose_end_time" name="choose_end_time" value="">

                    </div> -->
                    <div class="col-5">
                            <label for=""><h5 class="fs-title m-0">Your IFRAME URL:</h5></label><br>
                        <a href="#" onclick="EmbedCopy();" class="share-ico">
                            <!-- {{ $url_path }} -->
                        Click Here To Copy IFRAME URL
                            </a>
                    </div>
                    
                </div>
                
                <div class="row mt-4 container-fluid">
                    <!-- Reschudel for One day  -->

                    <div class="col-5">
                        <button id="reschedule_oneday" class="btn btn-info" value="reschedule_oneday">Re-Schedule To Tomorrow</button>
                    </div>
                    <!-- Reschudel for week -->
                    <!-- <div class="col-5">
                        <button id="reschedule_week" class="btn btn-secondary" value="reschedule_week">Re-Schedule for thisWeek</button>
                    </div> -->
                    
                </div>
                <div class="row mt-3 container-fluid">
                    <div class="col-md-5">
                    <!-- Video upload -->   
                        <div id="video_upload" style="">
                            <div class='content file'>
                                <h3 class="card-title upload-ui font-weight-bold">Upload Full Video Here</h4>
                                <!-- Dropzone -->
                                <form action="{{URL::to('admin/schedule/uploadFile')}}" method= "post" class='dropzone' ></form>
                                <div class="row justify-content-center">
                                    <div class="col-md-9 text-center">
                                    <p class="c1" style="">Trailers Can Be Uploaded From Video Edit Screen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              

                <!-- <div class="row"> -->
                    <h4 class="container-fluid mt-3">Drag Video and Drop for Scheduling:</h4>
                <div class="col-md-12">
                     <div class="row">
                     <div class="col-md-6 p-0">

                        <div class="drop-zone ScrollStyle">
                                <!-- <div class="draggable"> -->
                                        @foreach(@$Video as $value)
                                        <div class="draggable">
                                            <input type="text" data-class="{{ $value->id }}" id="video_id" draggable="true" ondragstart="drag(this)" class=" form-control video_{{ $value->id }}" value="{{ $value->title }}" readonly>
                                            <!-- <div class="video_id{{ $value->id }}" data-toggle="modal" data-target="#video" data-name="{{ $value->id }}"  onclick="dropZoneDropHandler(this)"  >{{ $value->title }}</div> -->
                                        </div>
                                        @endforeach
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="drop-zone ScrollStyle" ondrop="drop(this)" ondragover="allowDrop(this)"></div>
                        </div>

                        <!-- <div class="drop-zone"></div> -->
                </div>
            </div>
                <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="schedule_videos_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
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
                                    @foreach($ScheduledVideo as $key => $video)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $video->title  }}</td>  
                                        <td>{{ $video->type  }}</td>   
                                        <td>{{ $video->shedule_date  }}</td>   
                                        <td>{{ $video->sheduled_starttime  }}</td>  
                                        <td>{{ $video->shedule_endtime  }}</td>   
                                        </tr>                               

                                     @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>

            <br>


<br>
            <!-- <div class="row">
                <table id="customers" class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Video Type</th>
                            <th>Shedule Dte</th>
                            <th>Sheduled Start Time</th>
                            <th>Shedule End Time</th>
                        </tr>
                    </thead>

                </table>
            </div> -->

        </div>
    </div>
</div>
    
<input type="hidden" name="token" id= "token" value="{{ csrf_token() }}">
<input type="hidden" name="schedule_id" id= "schedule_id" value="{{ $schedule->id }}">
<input type="hidden" name="url" id= "url" value="{{ URL::to('admin/calendar/schedule')  }}">


@section('javascript')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script src="<?=URL::to("/assets/js/jquery.mask.min.js") ?>"></script>
    
    <script type="text/javascript">
      $('#choose_start_time').mask("00:00 AM");
      $('#choose_end_time').mask("00:00 AM");


        var month = '{{ $Calendar['month'] }}';
        var year = '{{ $Calendar['year'] }}';
        var date = '{{ $Calendar['date'] }}';
        var schedule_id = '{{ $Calendar['schedule_id'] }}';
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone",{ 
            //   maxFilesize: 900,  // 3 mb
                maxFilesize: 150000000,
                acceptedFiles: "video/mp4,video/x-m4v,video/*",
            });
        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
            formData.append("month", month);
            formData.append("year", year);
            formData.append("date", date);
            formData.append("schedule_id", schedule_id);
            formData.append("schedule_time", $('#time').val());
            // formData.append("choose_start_time", $('#choose_start_time').val());
            // formData.append("choose_end_time", $('#choose_end_time').val());

            // console.log(value)
            this.on("success", function(file, value) {
                console.log(value.video_title);
                    // $("#data").append(value);
                    if(value == 'Please Choose Time'){
                        alert('Please Choose Time');
                    }else if(value == ''){
                        alert('Please Choose Time');
                    }else{
                        $('tbody').html(value.table_data);
                    }
            });
        }); 
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
                // alert(data);
                // $("#data").append(data);
                // $('tbody').html(data.table_data);
            },
            error: function() { 
                console.log(data);
            }
        });
    });





   function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?=$url_path ?>';
   var url =  navigator.clipboard.writeText(window.location.href);
   var path =  navigator.clipboard.writeText(media_path);
   $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
              setTimeout(function() {
               $('.add_watch').slideUp('fast');
              }, 3000);
   // console.log(url);
   // console.log(media_path);
   // console.log(path);
   }

  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <script>
        
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
            $('#reschedule_oneday').click(function(){
                // alert();
                let oneday = $('#reschedule_oneday').val();
                var month = '{{ $Calendar['month'] }}';
                var year = '{{ $Calendar['year'] }}';
                var date = '{{ $Calendar['date'] }}';
                var schedule_id = '{{ $Calendar['schedule_id'] }}';
                var url = "{{ URL::to('admin/reschedule_oneday/')  }}";
                
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

/**
 * Set all event listeners for draggable element
 * https://developer.mozilla.org/en-US/docs/Web/API/DragEvent#Event_types
 */
function initDraggable(draggable) {
    draggable.addEventListener("dragstart", dragStartHandler);
    draggable.addEventListener("drag", dragHandler);
    draggable.addEventListener("dragend", dragEndHandler);

    // set draggable elements to draggable
    draggable.setAttribute("draggable", "true");
}

/**
 * Set all event listeners for drop zone
 * https://developer.mozilla.org/en-US/docs/Web/API/DragEvent#Event_types
 */
function initDropZone(dropZone) {
    dropZone.addEventListener("dragenter", dropZoneEnterHandler);
    dropZone.addEventListener("dragover", dropZoneOverHandler);
    dropZone.addEventListener("dragleave", dropZoneLeaveHandler);
    dropZone.addEventListener("drop", dropZoneDropHandler);
}

/**
 * Start of drag operation, highlight drop zones and mark dragged element
 * The drag feedback image will be generated after this function
 * https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API/Drag_operations#dragfeedback
 */
function dragStartHandler(e) {
    setDropZonesHighlight();
    this.classList.add('dragged', 'drag-feedback');
    // we use these data during the drag operation to decide
    // if we handle this drag event or not
    e.dataTransfer.setData("type/dragged-box", 'dragged');
    e.dataTransfer.setData("text/plain", this.textContent.trim());
    deferredOriginChanges(this, 'drag-feedback');
}

/**
 * While dragging is active we can do something
 */
function dragHandler() {
    // do something... if you want
}

/**
 * Very last step of the drag operation, remove all added highlights and others
 */
function dragEndHandler() {
    setDropZonesHighlight(false);
    this.classList.remove('dragged');
}

/**
 * When entering a drop zone check if it should be allowed to
 * drop an element here and highlight the zone if needed
 */
function dropZoneEnterHandler(e) {
    // we can only check the data transfer type, not the value for security reasons
    // https://www.w3.org/TR/html51/editing.html#drag-data-store-mode
    if (e.dataTransfer.types.includes('type/dragged-box')) {
        this.classList.add("over-zone");
        // The default action of this event is to set the dropEffect to "none" this way
        // the drag operation would be disallowed here we need to prevent that
        // if we want to allow the dragged element to be drop here
        // https://developer.mozilla.org/en-US/docs/Web/API/Document/dragenter_event
        // https://developer.mozilla.org/en-US/docs/Web/API/DataTransfer/dropEffect
        e.preventDefault();
    }
}

/**
 * When moving inside a drop zone we can check if it should be
 * still allowed to drop an element here
 */
function dropZoneOverHandler(e) {
    if (e.dataTransfer.types.includes('type/dragged-box')) {
        // The default action is similar as above, we need to prevent it
        e.preventDefault();
    }
}

/**
 * When we leave a drop zone we check if we should remove the highlight
 */
function dropZoneLeaveHandler(e) {
    if (e.dataTransfer.types.includes('type/dragged-box') &&
        e.relatedTarget !== null &&
        e.currentTarget !== e.relatedTarget.closest('.drop-zone')) {
        // https://developer.mozilla.org/en-US/docs/Web/API/MouseEvent/relatedTarget
        this.classList.remove("over-zone");
    }
}

/**
 * On successful drop event, move the element
 */
function dropZoneDropHandler(e,ele) {
            // var videos = $('.video_17').val();
            // console.log(allvideos);
            // var obj = JSON.parse(allvideos);
            // console.log(obj)

            // $.each(obj, function(i, $val)
            // {
                
            //     if('video_'+$val.id == '' ){

            //     }
            //    console.log($val.id);

            // });
                        
            // console.log(allvideos);
    // alert((videos));
    // We have checked in the "dragover" handler (dropZoneOverHandler) if it is allowed
    // to drop here, so it should be ok to move the element without further checks
    let draggedElement = document.querySelector('.dragged');
    e.currentTarget.appendChild(draggedElement);

    // We  drop default action (eg. move selected text)
    // default actions detailed here:
    // https://www.w3.org/TR/html51/editing.html#drag-and-drop-processing-model
    e.preventDefault();

}


/**
 * Highlight all drop zones or remove highlight
 */
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

/**
 * After the drag feedback image has been generated we can remove the class we added
 * for the image generation and/or change the originally dragged element
 * https://javascript.info/settimeout-setinterval#zero-delay-settimeout
 */
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
        $.ajax({
           url: url,
           type: "post",
            data: {
                  _token: '{{ csrf_token() }}',
                    video_id: video_id,
                    month: month,
                    year: year,
                    date: date,
                    schedule_id: schedule_id,
                    schedule_time: time
            },        
            success: function(value){
   			console.log(value);
               if(value == ''){
                        alert('Please Choose Time');
                    }else{
                        $('tbody').html(value.table_data);
                    }
           }
       });

}

</script>

@stop

@stop
