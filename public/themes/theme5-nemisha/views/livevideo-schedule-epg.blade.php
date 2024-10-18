
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
    .epg-program{background-color:#444;border-radius:8px;height:75px;position:relative;margin:0 5px;color:#fff;text-align:center;line-height:75px}
    .clearfix::after{content:"";display:table;clear:both}
    .epg-navigation{width:15%;height:38px;z-index:0;position:relative;overflow-x:auto;border-bottom:1px solid #555}
    .nav-arrow{background:grey;border:none;height:30px;margin-top:5px;margin-left:3px}
    .day-nav{margin:0 50px}
    .date-nav{gap:25px;white-space:nowrap;align-items:center;border-bottom:1px solid #555;background-color:#333;padding-left:20px}
    .epg-programs::-webkit-scrollbar,.epg-navigation::-webkit-scrollbar,.epg-grid::-webkit-scrollbar{display:none}
</style>


<div class="epg-container">

    <div class="epg-header">
        <img src="{{ @$Livestream_details->Player_thumbnail }}" alt="Program Image">

        <div class="epg-info">
            <h2> {{ ucwords(@$Livestream_details->title) }}</h2>
            <p>{!! html_entity_decode( @$Livestream_details->details) !!}</p>
        </div>
        
        <div class="epg-time">
            <span>4 Mar Fri: 1:30PM - 2:30PM</span>
        </div>
    </div>

    <div class="epg-grid clearfix">

        <div class="epg-navigation d-flex" style="overflow: auto;">
            <div class="date-nav d-flex">
                <div class="day-nav active">Today</div>
                <div class="day-nav">Tomorrow</div>
                <div class="day-nav">Day After Tomorrow</div>
            </div>
            <button class="nav-arrow" style="position: absolute;">&lt;</button>
            <button class="nav-arrow" style="left: 85%; position: absolute;">&gt;</button>
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
                        @endphp
                        
                        <div class="timeline">{{ $timeFormatted }}</div>

                        @if ( $Livestream_details->publish_type == "schedule_program" )

                            @php
                                $scheduler_program_title      = json_decode($Livestream_details->scheduler_program_title);
                                $scheduler_program_start_time = json_decode($Livestream_details->scheduler_program_start_time);
                                $scheduler_program_end_time   = json_decode($Livestream_details->scheduler_program_end_time);
                            @endphp

                            @foreach ( $scheduler_program_title as $index => $title)
                                @if ($title) 
                                    <?php
                                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $scheduler_program_start_time[$index]);
                                        $endTime = \Carbon\Carbon::createFromFormat('H:i', $scheduler_program_end_time[$index]);
                                    ?>
                                    
                                    @if ($time->between($startTime, $endTime)) 
                                        <div class="epg-program" style="background-color: lightblue;">{{ $title }}</div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endfor
                </div>
            </div>
        </div>                        
    </div>
</div>
