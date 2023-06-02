@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 


@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Site Meta Tag Setting :</h4>
                </div>
            </div>
             

                <div class="clear"></div>

             
                
                <div class="row">
                </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center" id="sitemeta_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <!-- <th>User Name</th> -->
                                            <th>Page Name</th>
                                            <th>Page Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($SiteMeta_settings as $key => $SiteMeta)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $SiteMeta->page_name  }}</td>  
                                        <td>{{ $SiteMeta->page_title  }}</td>   
                                        <td><a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Edit Meta" href="{{ URL::to('admin/site-meta-edit'). '/' . $SiteMeta->id }}">
                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
         $(document).ready(function(){
            $('#sitemeta_table').DataTable();
         });
</script>
