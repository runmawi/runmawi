
@extends('admin.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')

@stop
 
    <style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #008000; width:0%; height:20px; }
         .percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
         #translator-table_filter input[type="search"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            width: 200px; /* Adjust as needed */
            background: rgb(230, 228, 227); /* Your background color */
            }

            #translator-table_filter input[type="search"]:focus {
            outline: none;
            border-color: #66afe9;
            box-shadow: 0 0 5px rgba(102, 175, 233, 0.6);
            }
   </style>

@section('content')
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="container">

                <h1>Language Translation</h1>

                    <form method="POST" action="{{ route('translations.create') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>Key:</label>
                                <input type="text" name="key" class="form-control" placeholder="Enter Key...">
                            </div>
                            <div class="col-md-4">
                                <label>Value:</label>
                                <input type="text" name="value" class="form-control" placeholder="Enter Value...">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </form>


                    <table class="table table-hover table-bordered" id="translator-table">
                        <thead>
                        <tr>
                            <th>Key</th>
                            @if($languages->count() > 0)
                                @foreach($languages as $language)
                                    <th>{{ $language->name }}({{ $language->code }})</th>
                                @endforeach
                            @endif
                            <th width="80px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($columnsCount > 0)
                                @foreach($columns[0] as $columnKey => $columnValue)
                                    <tr>
                                        <td><a href="#" class="translate-key" data-title="Enter Key" data-type="text" data-pk="{{ $columnKey }}" data-url="{{ route('translation.update.json.key') }}">{{ $columnKey }}</a></td>
                                        @for($i=1; $i<=$columnsCount; ++$i)
                                        <td><a href="#" data-title="Enter Translate" class="translate" data-code="{{ $columns[$i]['lang'] }}" data-type="textarea" data-pk="{{ $columnKey }}" data-url="{{ route('translation.update.json') }}">{{ isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '' }}</a></td>
                                        @endfor
                                        <td><button data-action="{{ route('translations.destroy', $columnKey) }}" class="btn btn-danger btn-xs remove-key">Delete</button></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
            $('#translator-table').DataTable();
         });

    $('.translate').editable({
        params: function(params) {
            params.code = $(this).editable().data('code');
            return params;
        }
    });


    $('.translate-key').editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'Key is required';
            }
        }
    });


    $('body').on('click', '.remove-key', function(){
        var cObj = $(this);


        if (confirm("Are you sure want to remove this item?")) {
            $.ajax({
                url: cObj.data('action'),
                method: 'DELETE',
                success: function(data) {
                    cObj.parents("tr").remove();
                    alert("Your imaginary file has been deleted.");
                }
            });
        }


    });
</script>

@stop

@stop
