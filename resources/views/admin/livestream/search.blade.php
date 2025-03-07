@foreach($videos as $key => $video)

<tr id="tr_{{ $video->id }}">
    <td><input type="checkbox"  class="sub_chk" data-id="{{$video->id}}"></td>

    <td><img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" width="50" /></td>
    <td><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></td>
    <td> <?php if(!empty(@$video->cppuser->username)){ echo @$video->cppuser->username; }else{ @$video->usernames->username; }?></td>
    
    <?php if($video->access == "ppv" ){ ?>
        <td> <?php echo "Paid"; ?></td>
    <?php }else{ ?>
        <td> <?php  echo "Free"; ?></td>
    <?php }?>  
    <td>{{ $video->access }}</td>

    <?php if($video->active == 0){ ?>
        <td> <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
    <?php }elseif($video->active == 1){ ?>
        <td> <p class = "bg-primary video_active"> <?php  echo "Published"; ?></p></td>
    <?php }elseif($video->active == 2){ ?>
        <td>  <p class = "bg-danger video_active"><?php  echo "Rejected"; ?></p></td>
    <?php }?>  

    <td> @if( $video->url_type != null && $video->url_type == "Encode_video") {{ 'Video Encoder' }} @elseif( $video->url_type != null && $video->url_type == "live_stream_video") {{ 'Live Stream Video' }} @else {{  ucwords($video->url_type)  }} @endif
        
        @if( $video->url_type != null && $video->url_type == "Encode_video")
            <i class="fa fa-info-circle encode_video_alert"  aria-hidden="true" 
                    data-title = "{{ $video->title }}" data-name="{{$video->Stream_key}}"
                    data-rtmpURL= "{{ $video->rtmp_url ? $video->rtmp_url : null }}" 
                    data-hls-url= "{{ $video->hls_url ? $video->hls_url : null }}" 
                    
                    data-linkedin-restream = "{{ $video->linkedin_restream_url && $video->linkedin_streamkey  ? $video->youtube_restream_url.'/'. $video->linkedin_streamkey : " " }}" 
                    data-youtube-restream  = "{{ $video->youtube_restream_url && $video->youtube_streamkey  ? $video->youtube_restream_url.'/'. $video->youtube_streamkey : " " }}" 
                    data-facebook-restream = "{{ $video->fb_restream_url && $video->fb_streamkey  ? $video->fb_restream_url."/".$video->fb_streamkey : " " }}"
                    data-twitter-restream  = "{{ $video->twitter_restream_url && $video->twitter_streamkey ? $video->twitter_restream_url."/".$video->twitter_streamkey : " " }}"   
                    value="{{$video->Stream_key}}" onclick="addRow(this)" >
            </i>
        @endif

    </td>

    <td>{{ ucwords(str_replace('_', ' ', $video->publish_type))}}</td>

    {{-- Publish Time --}}
    <td>
        @if ($video->publish_type == "publish_now" || ($video->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($video->publish_time))) 
                                                
            <ul class="vod-info m-0 pt-1">
                <li><span></span> <small>LIVE NOW</small> </li>
            </ul>

        @elseif ($video->publish_type == "publish_later")
            <small> {{ 'Live Start On '.  Carbon\Carbon::createFromFormat('Y-m-d\TH:i',$video->publish_time)->format('j F Y g:ia') }} </small>
        
        @elseif ( $video->publish_type == "recurring_program" )

            @php
                $recurring_timezone = App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first();
                $Current_time = Carbon\Carbon::now(current_timezone());
                $convert_time = $Current_time->copy()->timezone($recurring_timezone);
            @endphp
            
            @if ( $video->recurring_program != "custom")
                
                @php

                    switch ($video->recurring_program_week_day) {

                        case 1 :
                            $recurring_program_week_day =  'Monday' ;
                        break;

                        case 2:
                            $recurring_program_week_day =  'Tuesday' ;
                        break;

                        case 3 :
                            $recurring_program_week_day = 'Wednesday' ;
                        break;

                        case 4:
                            $recurring_program_week_day =  'Thursday' ;
                        break;

                        case 5:
                            $recurring_program_week_day =  'Friday' ;
                        break;

                        case 6:
                            $recurring_program_week_day =  'Saturday' ;
                        break;

                        case 7:
                            $recurring_program_week_day = 'Sunday' ;
                        break;

                        default:
                            $recurring_program_week_day =  null ;
                        break;
                    }
                @endphp


                @if ( $video->recurring_program == "daily")

                    @if ( $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) 
                        <ul class="vod-info m-0 pt-1">
                            <li><span></span> <small>LIVE NOW</small> </li>
                        </ul>
                    @else
                        <small> {{ 'Live Starts daily from '. Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
                    @endif

                    
                @elseif( $video->recurring_program == "weekly" )
                    
                    @if ( $video->recurring_program_week_day == $convert_time->format('N') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) 
                        <ul class="vod-info m-0 pt-1">
                            <li><span></span> <small>LIVE NOW</small> </li>
                        </ul>
                    @else
                        <small> {{ 'Live Starts On Every '. $video->recurring_program . " " . @$recurring_program_week_day . $video->recurring_program_month_day ." from ". Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
                    @endif


                @elseif( $video->recurring_program == "monthly" )

                    @if ( $video->recurring_program_month_day == $convert_time->format('d') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')   )
                        <ul class="vod-info m-0 pt-1">
                            <li><span></span> <small>LIVE NOW</small> </li>
                        </ul>
                    @else
                        <small> {{ 'Live Starts On Every '. $video->recurring_program . " " . $video->recurring_program_month_day ." from ". Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
                    @endif

                @endif
            

            @elseif (  $video->recurring_program == "custom" )

                @if ( $video->custom_start_program_time <= $convert_time->format('Y-m-d\TH:i:s') &&  $video->custom_end_program_time >= $convert_time->format('Y-m-d\TH:i:s') ) 
                    <ul class="vod-info m-0 pt-1">
                        <li><span></span> <small>LIVE NOW</small> </li>
                    </ul>
                @else
                    <small> {{ 'Live Starts On '. Carbon\Carbon::parse($video->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
                @endif
            @endif
        @endif
    </td>
    
        <td> 
        <div class="mt-1">
            <label class="switch">
                <input name="video_status" class="video_status" id="{{ 'video_'.$video->id }}" type="checkbox" @if( $video->banner == "1") checked  @endif data-video-id={{ $video->id }}  data-type="video" onchange="update_video_banner(this)" >
                <span class="slider round"></span>
            </label>
        </div>
        </td>

    <td class=" align-items-center list-inline">								
        <a href="{{ route( $inputs_details_array['view_route']  , $video->slug ) }}" target="_blank" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
        <a href="{{ route( $inputs_details_array['edit_route'] , $video->id) }}" class="iq-bg-success ml-2 mr-2"><img class="ply " src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
        <a href="{{ route( $inputs_details_array['delete_route'] ,  $video->id ) }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
    </td>
</tr>
@endforeach
