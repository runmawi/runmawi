@extends('admin.master')

<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">
    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>

    <?php
        $embed_url = URL::to('/schedule/videos/embed');
        $embed_media_url = $embed_url . '/' . $schedule->name;
        $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
        $media_url = URL::to('/schedule/videos').'/'.$schedule->name;
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
                <h4 class="card-title">{{ $Calendar['date'].'/'.$Calendar['month'].'/'.$Calendar['year'] }} </h4>
                        <label for=""><h4 class="fs-title m-0">{{ $schedule->name }}</h4></label>

                <div class="row">
                    <div class="col-3">
                        <!-- <label for="">Choose Time</label><br>
                        <p style="color:black"> Select Timing Before Upload Video <span style="color:red;">*</span></p> -->
                        <!-- <select class="form-control" name="time" id="time" >
                            <option value="">Select Schedule Timing</option>
                            <option value="12:00 AM to 01:00 AM">12:00 AM to 01:00 AM</option>
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
                            <option value="11:00 PM to 12:00 AM">11:00 PM to 12:00 AM</option>
                        </select> -->
                        <label class="m-0">Start Time <small>(Please Time in this Format Hours:minutes PM/PM)</small></label>
                        <input type="text" class="form-control" id="choose_start_time" name="choose_start_time" value="">
                        
                    </div>
                    <div class="col-3">
                        <label class="m-0">End Time <small>(Please Time in this Format Hours:minutes PM/PM)</small></label>
                        <input type="text" class="form-control" id="choose_start_time" name="choose_start_time" value="">

                    </div>
                    <div class="col-3">
                            <label for=""><h5 class="fs-title m-0">Your IFRAME URL:</h5></label>
                    </div>
                    <div class="col-3">
                        <a href="#" onclick="EmbedCopy();" class="share-ico">
                            {{ $url_path }}
                            </a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                    <!-- Video upload -->   
                        <div id="video_upload" style="">
                            <div class='content file'>
                                <h3 class="card-title upload-ui font-weight-bold">Upload Full Video Here</h4>
                                <!-- Dropzone -->
                                <form action="{{URL::to('admin/schedule/uploadFile')}}" method= "post" class='dropzone' ></form>
                                <div class="row justify-content-center">
                                    <div class="col-md-9 text-center">
                                    <p class="c1" style="margin-left: 25%;">Trailers Can Be Uploaded From Video Edit Screen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <th>Shedule Date</th>
                                            <th>Sheduled Starttime</th>
                                            <th>Shedule Endtime</th>
                                        </tr>
                                    </thead>
                                <tbody>

                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>
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
    <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
    
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
            formData.append("choose_time", $('#time').val());

            // var choose_time = ;

            // console.log(value)
            this.on("success", function(file, value) {
                console.log(value.video_title);
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
                $('tbody').html(data.table_data);
            },
            error: function() { 
                console.log(data);
            }
        });
    });





   function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?= $url_path ?>';
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



@stop

@stop

