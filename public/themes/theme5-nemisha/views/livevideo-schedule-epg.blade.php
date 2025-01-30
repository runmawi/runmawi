<style>
    body{background-color:#000;color:#fff;font-family:Arial,sans-serif}
    .epg-header {display: flex; align-items: center; background-color: #1c1c1c; padding: 10px;  border-top-left-radius: 5px; border-top-right-radius: 5px; gap: 15px;}
    .epg-header img { width: 120px; height: auto; border-radius: 8px; flex-shrink: 0;}
    .epg-info { flex-grow: 1; flex-basis: 60%;}
    .epg-info h2 {font-size: 22px;font-weight: 700;margin: 0 0 10px;color: #ffffff;}
    .epg-info p {font-size: 14px;color: #bbb;margin: 0;line-height: 1.4;}
    .epg-time {flex-basis: 20%;text-align: right;align-self: flex-start;}
    .epg-time span {font-size: 12px;color: #f0f0f0;}
    .epg-left{width: 20%}
    .epg-right{width: 80%}

    @media (max-width: 768px) {
        .epg-header {flex-wrap: nowrap;flex-direction: row;align-items: flex-start;padding: 10px;}
        .epg-header img {width: 90px;}
        .epg-info {flex-grow: 1;flex-basis: auto;margin: 0 10px;}
        .epg-info h2 {font-size: 18px;}
        .epg-info p {font-size: 13px;}
        .epg-time {flex-basis: auto;text-align: left;font-size: 12px;}
        .epg-left{width: 30%}
        .epg-right{width: 70%}
    }
    @media (max-width: 480px) {
        .epg-header {flex-wrap: nowrap;flex-direction: row;gap: 10px;}
        .epg-header img {width: 70px;}
        .epg-info h2 {font-size: 16px;}
        .epg-info p {font-size: 12px;}
        .epg-time {text-align: left;font-size: 10px}
        .epg-left{width: 30%}
        .epg-right{width: 70%}
    }

    .epg-grid{margin-top:25px;background-color:#000;border-radius:8px;padding:10px;height:50vh!important;overflow:overlay}

    .epg-channels{padding-right:10px}
    .epg-channels div{margin-bottom:10px;padding:10px;background-color:#333;border-radius:8px;height:75px;text-align: center;}
    .epg-program-row{display:flex;margin-bottom:10px}
    .epg-program{position:relative;color:#fff;text-align:center;line-height:75px; height: 75px; width: 100%;}
    .epg-navigation{z-index:0;position:relative;overflow-x:auto; background-color: #333; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;}
    .nav-arrow{background:grey;border:none;height:30px;margin-top:5px;time-section-left:3px}
    .day-nav{margin:0 10px; cursor: pointer;  transition: background-color 0.3s ease, color 0.3s ease; font-size: 15px;}
    .day-nav.active {background-color: #000000; color: white; border-radius: 5px; padding: 10px;}
    .date-nav{align-items:center;background-color:#1c1c1c;display:flex; height:50px;  }
    .epg-programs::-webkit-scrollbar,.epg-navigation::-webkit-scrollbar,.epg-grid::-webkit-scrollbar{display:none}
    .epg-channel {width: 100%; white-space: nowrap; overflow: auto;text-overflow: ellipsis;max-width: 250px; display: inline-block; }
    @media (max-width: 480px) {
        .day-nav {
            font-size: 8px;
        }
    }


    .epg-program {
        position: relative;
        padding: 5px;
        /* margin: 5px 0; */
    }

    
    .timeline {
        text-align: center;
        font-size: 12px;
        color: white;
        padding: 12px 0px;
    }
    .program-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .time-section {
        width: 20%;
        height: 55px;
        text-align: center;
        background-color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white; 
        font-size: 14px;
    }
    @media (max-width: 480px) {
        .time-section{
            font-size: 8px;
        }
    }
  
    .title-section {
        width: 80%;
        text-align: left;
    }

</style>

@php
    $now = \Carbon\Carbon::now(); 
   
    $scheduleDays = isset($Livestream_details->scheduler_program_days) ? json_decode($Livestream_details->scheduler_program_days, true) : [];

    $currentDay = $now->format('N');


@endphp
<div class="epg-container mt-3">

    <div class="epg-header">
        <p>  {!! html_entity_decode( @$Livestream_details->details) !!} </p>


        <div class="epg-info">
            <h2 style="color: #ffffff !important;" > {{ ucwords(@$Livestream_details->title) }} </h2>
            
        </div>
        
        <div class="epg-time">
            <span>{{ $now->toDayDateTimeString() }}</span>
        </div>
    </div>

    <div class="epg-navigation">
        <div class="date-nav">
            @for ($i = 0; $i < 7; $i++)
                @php $day = $now->copy()->addDays($i); @endphp
                <h6 style="color: #ffffff !important;" class="day-nav" data-day="{{ $day->format('N') }}" data-date="{{ $day->format('Y-m-d\TH:i') }}" >
                    {{ $day->format('l') }} ({{ $day->format('d-m-Y') }})
                </h6>
            @endfor
        </div>
    </div>
    <div class="">
        <div id="data" class="" >
            {!! Theme::uses("{$current_theme}")->load("public/themes/{$current_theme}/views/livevideo-schedule-epg-partial",  
            ['Livestream_details' => $Livestream_details ,'current_theme' => $current_theme, 'now' => $now])->content() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var scheduleDays = {!! json_encode($Livestream_details->scheduler_program_days) !!};
        var programTitle = "{{ ucwords(@$Livestream_details->title) }}";
        var currentDay = new Date().getDay();
       
        function checkProgramAvailability(day) {
            if (scheduleDays.includes(String(day))) {
                $.ajax({
                    url: "{{ route('livestream-fetch-timeline') }}",
                    type: "GET",
                    data: {
                        day: day,
                        date: new Date().toISOString(),
                        publish_type: "{{ $Livestream_details->publish_type }}",
                        Livestream_id: "{{ $Livestream_details->id }}"
                    },
                    success: function (response) {
                        if (response.trim() === '' || response === null) {
                            $('#data').html('<h2 style="text-align:center; padding-top:50%; color: #ffffff !important;"  >No program scheduled.</h2>');
                        } else {
                            $('#data').html(response);
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        $('#data').html('<p>Error loading the EPG data.</p>');
                    }
                });
            } else {
                $('#data').html('<h2  style="text-align:center; padding-top:10%; color: #ffffff !important;" >No program scheduled.</h2>');
            }
        }

        checkProgramAvailability(currentDay);
        $('.day-nav').click(function () {
            var selectedDay = $(this).data('day');
            var selectedDate = $(this).data('date');
            checkProgramAvailability(selectedDay);
        });

    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dayNavElements = document.querySelectorAll('.day-nav');
        const currentDate = new Date();
        const currentDateFormatted = currentDate.toISOString().slice(0, 10); // Format as 'YYYY-MM-DD'

        dayNavElements.forEach(element => {
            // Extract the date from the data-date attribute in 'YYYY-MM-DD' format
            const elementDate = element.getAttribute('data-date').split('T')[0]; 

            // Check if the element corresponds to today's date
            if (elementDate === currentDateFormatted) {
                element.classList.add('active'); // Highlight the current day
            }

            // Add click event for changing the active day
            element.addEventListener('click', () => {
                dayNavElements.forEach(el => el.classList.remove('active'));
                element.classList.add('active');
            });
        });
    });
</script>
