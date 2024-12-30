@if (!is_null($Livestream_details))
    @php
        $epg_program_title = $Livestream_details->epg_program_title;
        $epg_program_start_time = $Livestream_details->epg_program_start_time;
        $epg_program_end_time = $Livestream_details->epg_program_end_time;

        $now = \Carbon\Carbon::now();
    @endphp

    <div class="epg-schedule">
        @if ($Livestream_details->publish_type == 'schedule_program')
            @isset($epg_program_title)
                @if (is_array($epg_program_title) && count($epg_program_title) > 0)
                    @foreach ($epg_program_title as $index => $title)
                        @if ($title && isset($epg_program_start_time[$index], $epg_program_end_time[$index]))
                            @php
                                try {
                                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $epg_program_start_time[$index]);
                                    $endTime = \Carbon\Carbon::createFromFormat('H:i', $epg_program_end_time[$index]);
                                } catch (\Exception $e) {
                                    continue;
                                }
                            @endphp

                            <div class="program-item d-flex align-items-center mb-3">
                                <div class="time-section">
                                    <p>{{ $startTime->format('h:i A') }} to {{ $endTime->format('h:i A') }} </p>
                                </div>
                                <div class="title-section text-left">
                                    <h6 class="px-3" >{{ $title }}</h6>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p>No programs scheduled for today.</p>
                @endif
            @else
                <p>No program data available.</p>
            @endisset
        @elseif ($Livestream_details->publish_type == 'publish_now')
            <div class="program-item d-flex align-items-center mb-3">
                <div class="time-section text-left me-3">
                    <p class="mb-1">Start: {{ $epg_program_start_time }}</p>
                    <p class="mb-0">End: {{ $epg_program_end_time }}</p>
                </div>
                <div class="title-section text-left">
                    <h3 class="mb-0">{{ $epg_program_title }}</h3>
                </div>
            </div>
        @elseif ($Livestream_details->publish_type == 'publish_later')
            <div class="program-item d-flex align-items-center mb-3">
                <div class="time-section text-left me-3">
                    <p class="mb-1">Start: {{ $epg_program_start_time }}</p>
                    <p class="mb-0">End: {{ $epg_program_end_time }}</p>
                </div>
                <div class="title-section text-left">
                    <h3 class="mb-0">{{ $epg_program_title }}</h3>
                </div>
            </div>
        @else
            <p>No programs scheduled for today.</p>
        @endif
    </div>

@else
    <p>No programs scheduled for today.</p>
@endif
