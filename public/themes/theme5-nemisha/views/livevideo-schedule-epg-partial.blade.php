@if (!is_null($Livestream_details))

    @php
        $epg_program_title = $Livestream_details->epg_program_title;
        $epg_program_start_time = $Livestream_details->epg_program_start_time;
        $epg_program_end_time = $Livestream_details->epg_program_end_time;
        $epg_program_timeloop_parse = $Livestream_details->epg_program_timeloop_parse;

        $colors = ['#333', '#8f8d8d'];

        $program_title_once_show = true;
        $lastShownIndex = null;

        $now = \Carbon\Carbon::now();
    @endphp

    <div class="epg-timeline" id="timeline">

        @for ($i = 0; $i < 96; $i++)
            @php
                $time = \Carbon\Carbon::createFromTime(0, 0)
                    ->addMinutes($i * 15)
                    ->setDateFrom($epg_program_timeloop_parse);
                $timeFormatted = $time->format('H:i');
                $nextTime = \Carbon\Carbon::createFromTime(0, 0)->addMinutes(($i + 1) * 15);
            @endphp

            <div class="timeline-slot">
                <div class="timeline">{{ $timeFormatted }}</div>

                {{-- Current Time Line --}}
                {{-- @if ($now->between($time, $nextTime))
                    <div class="current-time-line" style="position: absolute; top: 0; left: 50%; width: 2px; background-color: red; height: 100%;"></div>
                @endif --}}

                {{-- Publish now  --}}

                @if ($Livestream_details->publish_type == 'publish_now')
                    <div class="epg-program" style="background-color: {{ $colors[0] }};">
                        <b>{{ $program_title_once_show ? @$Livestream_details->epg_program_title : null }}</b>
                        @php $program_title_once_show = false; @endphp
                    </div>
                @endif

                {{-- Publish later  --}}

                @if ($Livestream_details->publish_type == 'publish_later')
                    @if ($time->greaterThan($epg_program_start_time))
                        <div class="epg-program" style="background-color: {{ $colors[1] }};">
                            <b>{{ $program_title_once_show ? "{$Livestream_details->epg_program_title}" : null }}</b>
                            @php $program_title_once_show = false; @endphp
                        </div>
                    @endif
                @endif

                {{-- Schedular Program --}}

                @if ($Livestream_details->publish_type == 'schedule_program')
                @isset($epg_program_title)
                    @if (is_array($epg_program_title) && count($epg_program_title) > 0)
                        @foreach ($epg_program_title as $index => $title)
                            @if ($title)
                                @php
                                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $epg_program_start_time[$index]);
                                    $endTime = \Carbon\Carbon::createFromFormat('H:i', $epg_program_end_time[$index]);
                                    $color = $colors[$index % count($colors)]; // Select a color from the $colors array
                                @endphp
            
                                @if ($time->between($startTime, $endTime))
                                    <div class="epg-program epg-timeline-{{ $index }}"
                                        style="background-color: {{ $color }};">
                                        @if ($time->greaterThanOrEqualTo($startTime) && $time->lessThan($startTime->copy()->addMinutes(15)))
                                            @if ($index !== $lastShownIndex)
                                                <b style="position: absolute; top: 3px; left: 10px; z-index: 2;">
                                                    {{ "{$title} " }}
                                                </b>
                                            @endif
                                        @endif
                                    </div>
                                    @php $lastShownIndex = $index; @endphp
                                @endif
                            @endif
                        @endforeach
                    @else
                        <p>No programs scheduled for today.</p>
                    @endif
                @else
                    <p>No program data available.</p>
                @endisset
            @endif
            
            </div>
        @endfor
    </div>
@else
    <p>No programs scheduled for today.</p>
@endif
