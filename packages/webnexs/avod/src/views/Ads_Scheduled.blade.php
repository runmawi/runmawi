@include('avod::ads_header')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

<style>
.row.col-sm-12 {
    padding: 26px;
}
    </style>

    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="container-fluid">
                <div class=" row mb-5">
                    <div class="col-sm-9">
                        <h5>Ads Schedule Calender</h5>
                    </div>

                    <div class="col-sm-3 text-right">
                        <a href="{{ URL::to('advertiser/Ads-Events') }}" class="btn btn-primary">Add Scheduling Time</a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
           
        var SITEURL = "{{ url('/advertiser') }}";
          
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN':" {{ csrf_token() }}"
            }
        });
          
        var calendar = $('#calendar').fullCalendar({
                            editable: true,
                            events: SITEURL + "/Ads_Scheduled",
                            displayEventTime: true,
                            editable: true,
                            allowCalEventOverlap : true,
                            overlapEventsSeparate: true,
                            firstDayOfWeek : 1,
                            displayEventTime: true,
                            timeFormat: 'h(:mm)a',
                            displayEventEnd: true,
                            eventColor: '#006AFF',
                            header: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'month,agendaWeek,agendaDay'
                                },
                            
                            eventDrop: function (event, delta) {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
          
                                $.ajax({
                                    url: SITEURL + '/AdsScheduleStore',
                                    data: {
                                        title: event.title,
                                        start: start,
                                        end: end,
                                        id: event.id,
                                        type: 'update'
                                    },
                                    type: "POST",
                                    success: function (response) {
                                        displayMessage("Event Updated Successfully");
                                    }
                                });
                            },
                            eventClick: function (event) {
                                var deleteMsg = confirm("Do you really want to delete?");
                                if (deleteMsg) {
                                    $.ajax({
                                        type: "POST",
                                        url: SITEURL + '/AdsScheduleStore',
                                        data: {
                                                id: event.id,
                                                type: 'delete'
                                        },
                                        success: function (response) {
                                            calendar.fullCalendar('removeEvents', event.id);
                                            displayMessage("Event Deleted Successfully");
                                        }
                                    });
                                }
                            }

                            //    eventRender: function (event, element, view) {
                            //     if (event.allDay === 'true') {
                            //             event.allDay = true;
                            //     } else {
                            //             event.allDay = false;
                            //     }
                            // },
                            // header: {
                            //         left: 'prev,next today',
                            //         center: 'title',
                            //         right: 'month,agendaWeek,agendaDay'
                            //     },
                            
                            // selectable: true,
                            // selectHelper: true,
                            // select: function (start, end, allDay) {
                            //     var title = prompt('Event Title:');


                            //     if (title) {
                            //         var start = $.fullCalendar.formatDate(start, "YYYY-MM-DD HH:mm");
                            //         var end = $.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm");
                            //         $.ajax({
                            //             url: SITEURL + "/AdsScheduleStore",
                            //             data: {
                            //                 title: title,
                            //                 start: start,
                            //                 end: end,
                            //                 type: 'add'
                            //             },
                            //             type: "POST",
                            //             success: function (data) {
                            //                 displayMessage("Event Created Successfully");
          
                            //                 calendar.fullCalendar('renderEvent',
                            //                     {
                            //                         id: data.id,
                            //                         title: title,
                            //                         start: start,
                            //                         end: end,
                            //                         allDay: allDay
                            //                     },true);
          
                            //                 calendar.fullCalendar('unselect');
                            //             }
                            //         });
                            //     }
                            // },
         
                        });
         
        });
         
        function displayMessage(message) {
            toastr.success(message, 'Event');
        } 
          
        </script>
  
