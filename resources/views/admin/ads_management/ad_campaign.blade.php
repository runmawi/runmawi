
@extends('admin.master')
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
    .fc-day-number{
        color: #000;
    }
    .fc-widget-content{
        height: 80px!important;
    }
    .fc-button-group{
        margin-bottom: 10px;
       
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
        border: none;
    }
</style>
@section('content')



<div id="content-page" class="content-page">
    <div class="iq-card">
        <div class="container-fluid">
            <div class=" row col-sm-12">
                <div class="col-sm-9">
                    <h5>Ads Campaign</h5>
                    <p></p>
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

<!-- ADD EVENT MODAL -->
      
      <div class="modal fade" tabindex="-1" role="dialog" id="newEventModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
              <h4 class="modal-title">Create new <span class="eventType"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
          
                <div class="row">
                    <div class="col-xs-12">
                        <label class="col-xs-4" for="title">Event title</label>
                        <input class="inputModal" type="text" name="title" id="title" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label class="col-xs-4" for="starts-at">Cost</label>
                        <input class="inputModal" type="text" name="cost" id="cost" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label class="col-xs-4" for="ends-at">No of Ads</label>
                        <input class="inputModal" type="text" name="no_of_ads" id="no_of_ads" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label class="col-xs-4" for="ends-at">Cost per view Advertiser</label>
                        <input class="inputModal" type="text" name="cpv_advertiser" id="cpv_advertiser" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label class="col-xs-4" for="ends-at">Cost per view Admin</label>
                        <input class="inputModal" type="text" name="cpv_admin" id="cpv_admin" />
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-event">Save changes</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />


@section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var SITEURL = "{{ url('/admin/') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var calendar = $('#full_calendar_events').fullCalendar({
            editable: true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events: SITEURL + "/ad_campaign",
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
            select: function (start, end, allDay) {
             $('#newEventModal').modal('show');
             $('#save-event').unbind();
             var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
             var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
             $('#save-event').on('click', function() {
              var title = $('input#title').val();
              var cost = $('input#cost').val();
              var no_of_ads = $('input#no_of_ads').val();
              var cpv_advertiser = $('input#cpv_advertiser').val();
              var cpv_admin = $('input#cpv_admin').val();
              if (title != '') {

                $.ajax({
                    url: SITEURL + "/ad_campaign_ajax",
                    data: {
                        title: title,
                        cost: cost,
                        no_of_ads: no_of_ads,
                        cpv_advertiser: cpv_advertiser,
                        cpv_admin: cpv_admin,
                        start: start,
                        end: end,
                        type: 'create'
                    },
                    type: "POST",
                    success: function (data) {
                        displayMessage("Event created.");
                        calendar.fullCalendar('renderEvent', {
                            id: data.id,
                            title: title+ ' ' +cost,
                            start: start,
                            end: end,
                            allDay: allDay
                        }, true);
                        calendar.fullCalendar('unselect');
                        $('#newEventModal').modal('hide');                    }
                });
            }
        });
         },
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                $.ajax({
                    url: SITEURL + '/ad_campaign_ajax',
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event updated");
                    }
                });
            },
            eventClick: function (event) {
                var eventDelete = confirm("Are you sure want to remove?");
                if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/ad_campaign_ajax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event removed");
                        }
                    });
                }
            }
        });
    });
    function displayMessage(message) {
        toastr.success(message, 'Event');            
    }
</script>
   @stop

   @stop