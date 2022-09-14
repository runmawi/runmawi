
@extends('admin.master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <hr>

            <table id="customers" class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th width="70">Action</th>
                    </tr>
                </thead>

            </table>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

            <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
            <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

            <!--js code here-->
            
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $.noConflict();
        var token = ''
        // var modal = $('.modal')
        // var form = $('.form')
        // var btnAdd = $('.add'),
            // btnSave = $('.btn-save'),
            // btnUpdate = $('.btn-update');
        
        var table = $('#customers').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'name'},
                    {data: 'type', name: 'phone'},
                    {data: 'shedule_date', name: 'dob'},
                    {data: 'sheduled_starttime', name: 'action'},
                ]
            });
      

        $(document).on('click','.btn-delete',function(){
            if(!confirm("Are you sure?")) return;

            var rowid = $(this).data('rowid')
            var el = $(this)
            if(!rowid) return;

            
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "/" + rowid,
                data: {_method: 'delete',_token:token},
                success: function (data) {
                    if (data.success) {
                        table.row(el.parents('tr'))
                            .remove()
                            .draw();
                    }
                }
             }); //end ajax
        })
    })
</script>