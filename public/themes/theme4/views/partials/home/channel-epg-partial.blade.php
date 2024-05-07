<div class="data"> 
    <div class="panel-body">
        <div class="tab-content">
            @forelse ( $epg_channel_data->ChannelVideoScheduler as $item)
                <div role="tabpanel" class="tab-pane fade in active" id="{{ $item->id }}" >
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td  class="time"> {{ $item->converted_start_time }}  -  {{ $item->converted_end_time }}  <small> {{ $item->TimeZone->time_zone }}</small> </td>
                                <td><h6>{{ ucwords($item->socure_title) }}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @empty

                <div role="tabpanel" class="tab-pane fade in active" >
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><h6>{{ ucwords('no events') }}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            @endforelse
        </div>
    </div>
</div>