<style>
    body{background-color:#000;color:#fff;font-family:Arial,sans-serif}
    .epg-container{padding:20px}
    .epg-header{display:flex;align-items:center;background-color:#1c1c1c;padding:15px;border-radius:8px}
    .epg-header img{width:120px;height:auto;border-radius:8px}
    .epg-info{margin-left:20px;flex-grow:1}
    .epg-info h2{font-size:24px;font-weight:700;margin-bottom:10px}
    .epg-info p{font-size:14px;color:#bbb}
    .epg-time{text-align:right;width:20%;position:relative;top:-25px}
    .epg-time span{font-size:12px;color:#f0f0f0}
    .epg-grid{margin-top:20px;background-color:#1c1c1c;border-radius:8px;padding:10px;height:50vh!important;overflow:overlay}
    .epg-timeline-container{overflow-x:auto;white-space:nowrap;position:relative;top:-37px}
    .epg-timeline{display:flex;justify-content:flex-start;padding:10px;border-bottom:1px solid #555;background-color:#333;color:#ccc;font-size:12px;width:352%}
    .timeline{margin:0 10px}
    .epg-timeline div{flex:0 0 60px;text-align:center}
    .epg-channels{width:16%;float:left;padding-right:10px}
    .epg-channels div{margin-bottom:10px;padding:10px;background-color:#333;border-radius:8px;height:75px}
    .epg-programs{overflow-x:auto;white-space:nowrap}
    .epg-program-row{display:flex;margin-bottom:10px}
    .epg-program{height:75px;position:relative;margin:0 5px;color:#fff;text-align:center;line-height:75px}
    .clearfix::after{content:"";display:table;clear:both}
    .epg-navigation{width:15%;height:38px;z-index:0;position:relative;overflow-x:auto;border-bottom:1px solid #555}
    .nav-arrow{background:grey;border:none;height:30px;margin-top:5px;margin-left:3px}
    .day-nav{margin:0 50px}
    .date-nav{gap:25px;white-space:nowrap;align-items:center;border-bottom:1px solid #555;background-color:#333;padding-left:20px}
    .epg-programs::-webkit-scrollbar,.epg-navigation::-webkit-scrollbar,.epg-grid::-webkit-scrollbar{display:none}
 
    .timeline-slot {
        width: calc(100% / 96); 
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .epg-program {
        background-color: lightblue;
        padding: 5px;
        text-align: center;
        width: 100%;
        margin-top: 5px;
    }

    .epg-timeline-container {
        position: relative;
    }


    .epg-program {
        position: relative;
        padding: 5px;
        margin: 5px 0;
    }

    .timeline-slot {
        position: relative;
        display: inline-block;
        width: calc(100% / 96); /* Assuming 96 slots for 15-minute intervals in a 24-hour period */
    }

    .timeline {
        text-align: center;
        font-size: 12px;
        margin-bottom: 10px;
    }
</style>

@php
    $scheduler_program_title = json_decode($Livestream_details->scheduler_program_title);
    $scheduler_program_start_time = json_decode($Livestream_details->scheduler_program_start_time);
    $scheduler_program_end_time = json_decode($Livestream_details->scheduler_program_end_time);
    $colors = ['lightblue', 'lightgreen', 'lightcoral', 'lightgoldenrodyellow', 'lightpink'];
    $lastShownIndex = null;
    $now = \Carbon\Carbon::now(); 
@endphp

<div class="epg-container">

    <div class="epg-header">
        <img src="{{ @$Livestream_details->Player_thumbnail }}" alt="Program Image">

        <div class="epg-info">
            <h2> {{ ucwords(@$Livestream_details->title) }} </h2>
            <p>  {!! html_entity_decode( @$Livestream_details->details) !!} </p>
        </div>
        
        <div class="epg-time">
            <span>{{ $now->toDayDateTimeString() }}</span>
        </div>
    </div>

    <div class="epg-grid clearfix">

        {{-- <div class="epg-navigation d-flex" style="overflow: auto;">
            <div class="date-nav d-flex">
                <div class="day-nav active">Today</div>
                <div class="day-nav">Tomorrow</div>
                <div class="day-nav">Day After Tomorrow</div>
            </div>
            <button class="nav-arrow" style="position: absolute;">&lt;</button>
            <button class="nav-arrow" style="left: 85%; position: absolute;">&gt;</button>
        </div> --}}

        <div class="epg-navigation ">
            <div class="date-nav">
                @for ($i = 0; $i < 7; $i++)

                    @php $day = $now->copy()->addDays($i);  @endphp

                    <div class="day-nav" data-day="{{ $day->format('N') }}">
                        @switch($i)
                            @case(0)
                                {{ "Today" }}
                                @break

                            @case(1)
                                {{"Tomorrow"}}
                                @break

                            @default
                            {{ $day->format('l') }} 
                        @endswitch
                    </div>
                @endfor
            </div>
        </div>

        <div class="epg-channels mt-2">
            <div class="epg-channel"> {{ ucwords(@$Livestream_details->title) }}</div>
        </div>

        <div class="epg-timeline-container">
            <div class="epg-programs">
                <div class="epg-timeline">
                
                    @for ($i = 0; $i < 96; $i++)
                        @php
                            $time = \Carbon\Carbon::createFromTime(0, 0)->addMinutes($i * 15);
                            $timeFormatted = $time->format('H:i');
                            $nextTime = \Carbon\Carbon::createFromTime(0, 0)->addMinutes(($i + 1) * 15);
                        @endphp

                        <div class="timeline-slot">
                            <div class="timeline">{{ $timeFormatted }}</div>

                            @if ($now->between($time, $nextTime))
                                <div class="current-time-line" style="position: absolute; top: 0; left: 50%; width: 2px; background-color: red; height: 100%;"></div>
                            @endif

                            @foreach ($scheduler_program_title as $index => $title)
                                @if ($title)
                                    @php
                                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $scheduler_program_start_time[$index]);
                                        $endTime = \Carbon\Carbon::createFromFormat('H:i', $scheduler_program_end_time[$index]);
                                        $color = $colors[$index % count($colors)];
                                    @endphp

                                    @if ($time->between($startTime, $endTime))
                                        <div class="epg-program epg-timeline-{{ $index }}" style="background-color: {{ $color }};">
                                            @if ($title && $index !== $lastShownIndex)
                                                <b>{{ "{$title} (Start: {$scheduler_program_start_time[$index]} - End: {$scheduler_program_end_time[$index]})" }}</b>
                                            @endif
                                        </div>
                                        @php $lastShownIndex = $index; @endphp
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.day-nav').click(function() {
            var selectedDate = $(this).data('day'); 

            $.ajax({
                url: "{{ route('livestream-fetch-timeline') }}", 
                type: "GET",
                data: {
                    date: selectedDate 
                },
                success: function(response) {
                    $('#epg-timeline-container').html(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Log errors if any
                }
            });
        });
    });
</script>
