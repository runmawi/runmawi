<table class="table table-bordered iq-card text-center" id="categorytbl">
                            <tr class="table-header r1">
                                <th><label>Episode </label></th>
                                <th><label>Episode Name</label></th>
                                <th><label>Episode Duration</label></th>
                                <th><label>Slider</label></th>
                                <th><label>Status</label></th>
                                <th><label>Action</label></th>
                            </tr>

                            @foreach($episodes as $key => $episode)
                                <input type="hidden" class="seriesid" id="seriesid" value="{{ $episode->series_id }}">
                                <input type="hidden" class="season_id" id="season_id" value="{{ $episode->season_id }}">
                                <tr id="{{ $episode->id }}">
                                    <td valign="bottom"><p> Episode {{ $episode->episode_order }}</p></td>
                                    <td valign="bottom"><p>{{ $episode->title }}</p></td>
                                    <td valign="bottom"><p>@if(!empty($episode->duration)){{ gmdate('H:i:s', $episode->duration) }}@endif</p></td>
                                    <td valign="bottom">
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input name="video_status" class="video_status" id="{{ 'video_'.$episode->id }}" type="checkbox" @if( $episode->banner == "1") checked  @endif data-video-id={{ $episode->id }}  data-type="video" onchange="update_episode_banner(this)" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>

                                    <?php if($episode->active == null){ ?>
                                    <td > <p class = "bg-warning video_active"><?php echo "Draft"; ?></p></td>
                                             <?php }elseif($episode->active == 1){ ?>
                                    <td > <p class = "bg-success video_active"><?php  echo "Published"; ?></p></td>
                                             <?php } ?>
                                    <td>
                                        <div class=" align-items-center">
                                            <a href="{{ URL::to('admin/episode/episode_edit') . '/' . $episode->id }}" class="btn btn-xs btn-primary"><span class="fa fa-edit"></span>Edit Video</a>
                                            <a href="{{ URL::to('admin/episode/edit') . '/' . $episode->id }}" class="btn btn-xs btn-primary"><span class="fa fa-edit"></span> Edit</a>
                                            <a href="{{ URL::to('admin/episode/delete') . '/' . $episode->id }}" class="btn btn-xs btn-danger delete" onclick="return confirm('Are you sure?')" ><span class="fa fa-trash"></span> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>



                        
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		
        <script type="text/javascript">
            $(function () {
                $("#categorytbl").sortable({
                    items: 'tr:not(tr:first-child)',
                    cursor: 'pointer',
                    axis: 'y',
                    dropOnEmpty: false,
                    start: function (e, ui) {
                        ui.item.addClass("selected");
                    },
                    stop: function (e, ui) {
                        ui.item.removeClass("selected");
                        var selectedData = new Array();
                        $(this).find("tr").each(function (index) {
                            if (index > 0) {
                                $(this).find("td").eq(2).html(index);
                                selectedData.push($(this).attr("id"));
                            }
                        });
                        var seriesid  = $('.seriesid').val();
                        var season_id  = $('.season_id').val();
                        updateOrder(selectedData,seriesid,season_id)
                    }
                });
            });
        
            function updateOrder(data,seriesid,season_id) {
        
                $.ajax({
                    url:'{{  URL::to('admin/episode_order') }}',
                    type:'post',
                    data:{
                            position:data,
                            seriesid:seriesid,
                            season_id:season_id,
                             _token :  "{{ csrf_token() }}",
                            },
                    success:function(data){
                        // alert('Position changed successfully.');
                        // location.reload(); id="orderepisode"
                        $("#orderepisode").html(data);
                    }
                })
            }
        </script>
        