@extends('moderator.master')

@include('admin.favicon')

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Audio Lists :</h4>
                </div>
            </div>
            <br>
            <div class="iq-card-header-toolbar d-flex align-items-center">
               <a href="{{ URL::to('/cpp/audios/create') }}" class="btn btn-primary">Add Audio</a>
            </div>
            <br>

                <div class="clear"></div>



                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="audios_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Title</th>
                                            <!-- <th>Video Title</th> -->
                                            <th>Rating</th>
                                            <th>Category</th>
                                            <th>Views</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                @foreach($audios as $key => $audio)
                                    <tr>
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $audio->title  }}</td>   
                                        <td>{{ $audio->rating  }}</td>   
                                        <td>@if(isset($audio->categories->name)) {{ $audio->categories->name }} @endif</td>   
                                        <td>{{ $audio->views  }}<img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></td>   
                                        
                                        <td>
                                        <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/cpp/audio') . '/' . $audio->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('/cpp/audios/edit') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" onclick="return confirm('Are you sure?')"
                                             data-original-title="Delete" href="{{ URL::to('/cpp/audios/delete') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                   
                                        </td>  
                                    </tr>
                                @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
    
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

     $(document).ready(function(){
        $('#audios_table').DataTable();
    });
</script>
 