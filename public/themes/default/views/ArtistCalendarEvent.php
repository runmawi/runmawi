<?php include('header.php'); ?>


<meta name="csrf-token" content="{{ csrf_token() }}">


<style>
    table{
        width: 100%;
      
        
    }td,thead{
        text-align: center;
    }
    .modal-body{
        padding-left:30px!important;
    }
    .fc-widget-content{
        height: 80px!important;
    }
    .fc-day-number{
        color: #000;
    }
    .fc-button-group{
        margin-bottom: 10px;
        display: none;
    }
    .fc-prev-button{
         padding: 10px;
        background-color: #000
      
    }
    .fc-next-button{
         padding: 10px;
        float:right;
         background-color: #000;
    }
    .fc-month-button{
        background-color: red;
        border: none;
    }
    .fc-agendaWeek-button{
        background-color: green;
        border: none;
    }
    .fc-agendaDay-button{
        background-color: orange;
        border:
         none;
    }
    .fc-scroller.fc-day-grid-container {
        height: 500px !important;
    }
    .fc-right .fc-button-group{
        display: none;
    }
    .fc-today-button {
        display: none;
    }
    .ffc-center {
        display: none;
    }
    h2{
        color: black;
    }
</style>


<section style='background-color: white;'>
    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="container-fluid">
                <div class=" row col-sm-12">
                    <div class="col-sm-9">
                        <h5> Artist Event Calendar :</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div id="full_calendar_events"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var SITEURL = "<?= url('/admin/') ?>";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var calendar = $('#full_calendar_events').fullCalendar({
            // editable: true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events: SITEURL + "/calendar-event",
            displayEventTime: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            // select: function (start, end, allDay) {
            //     var title = prompt('Surge Price:');
            //     if (title) {
            //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
            //         $.ajax({
            //             url: SITEURL + "/calendar-crud-ajax",
            //             data: {
            //                 title: title,
            //                 start: start,
            //                 end: end,
            //                 type: 'create'
            //             },
            //             type: "POST",
            //             success: function (data) {
            //                 displayMessage("Event created.");
            //                 calendar.fullCalendar('renderEvent', {
            //                     id: data.id,
            //                     title: title,
            //                     start: start,
            //                     end: end,
            //                     allDay: allDay
            //                 }, true);
            //                 calendar.fullCalendar('unselect');
            //             }
            //         });
            //     }
            // },
            // eventDrop: function (event, delta) {
            //     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            //     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            //     $.ajax({
            //         url: SITEURL + '/calendar-crud-ajax',
            //         data: {
            //             title: event.title,
            //             start: start,
            //             end: end,
            //             id: event.id,
            //             type: 'edit'
            //         },
            //         type: "POST",
            //         success: function (response) {
            //             displayMessage("Event updated");
            //         }
            //     });
            // },
            // eventClick: function (event) {
            //     var eventDelete = confirm("Are you sure want to remove?");
            //     if (eventDelete) {
            //         $.ajax({
            //             type: "POST",
            //             url: SITEURL + '/calendar-crud-ajax',
            //             data: {
            //                 id: event.id,
            //                 type: 'delete'
            //             },
            //             success: function (response) {
            //                 calendar.fullCalendar('removeEvents', event.id);
            //                 displayMessage("Event removed");
            //             }
            //         });
            //     }
            // }
        });
    });
    function displayMessage(message) {
        toastr.success(message, 'Event');            
    }
</script>

<?php // include('footer.blade.php'); ?>
