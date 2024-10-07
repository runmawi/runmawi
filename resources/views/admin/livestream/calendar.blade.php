@extends('admin.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
            <div class="container-fluid">
                <div class=" row col-sm-12">
                    <div class="col-sm-9">
                        <h5>{{ ucwords('Livestream Calender') }}</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12" style="padding: 2rem;">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($events);

        console.log(events);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '{{ $Current_date }}',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventSources: [
                {
                    events: events 
                }
            ]
        });

        calendar.render();
    });
</script>

@stop

@endsection
