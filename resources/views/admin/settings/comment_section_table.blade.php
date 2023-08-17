<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="iq-card">
            <div class="iq-card-body table-responsive p-0">
                <div class="table-view">
                    <table class="table table-striped table-bordered table movie_table iq-card">
                        <thead>
                            <tr class="r1">
                                <th> S.No</th>
                                <th> Name</th>
                                <th> Commenter Type </th>
                                <th> Comment </th>
                                <th> Status </th>
                            </tr>
                        </thead>

                        @csrf
                        @foreach ($webcomments as $key => $webcomment)
                            <tbody>
                                <td> {{ $key + 1 }} </td>
                                <td> {{ $webcomment->user_name }} </td>
                                <td> {{ $webcomment->commentable_type }} </td>
                                <td> {{ $webcomment->comment }} </td>
                                <td class={{'status-'.$webcomment->id }} >
                                    <button class="btn btn-success status_change" onclick="return confirmAction(event)" value="1" data-id="{{ $webcomment->id }}"> Approve </button>
                                    <button class="btn btn-danger status_change" onclick="return confirmAction(event)" value="2" data-id="{{ $webcomment->id }}">  Disapprove</button>
                                </td>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@section('javascript')

    <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('body').on('click', '.status_change', function(event) {
                var confirmed = confirm('Are you sure you want to perform this action?');

                if (!confirmed) {
                    event.preventDefault();
                    return false;
                }

                var status = $(this).val();
                var id = $(this).data('id');
                var url = "{{ route('comments.status_update')}}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: status,
                        id: id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('.'+data.id).replaceWith(data.status_button);
                    }
                });
            });
        });
    </script>

@stop
