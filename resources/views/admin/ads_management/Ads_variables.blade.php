@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Ads Variable') }}</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <a data-toggle="modal" data-target='#edit_modal'
                                    class="btn btn-primary create_variable"> {{ _('Create Ads Variable') }}</a>
                            </div>
                        </div>
                        <div class="iq-card-body table-responsive">
                            <div class="table-view">
                                <table class="table table-striped table-bordered table movie_table " style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>{{ _('Variable Name') }}</th>
                                            <th> {{ _('website')}} </th>
                                            <th>{{ _('andriod')}}</th>
                                            <th>{{ _('ios')}}</th>
                                            <th>{{ _('tv')}}</th>
                                            <th>{{ _('roku')}}</th>
                                            <th>{{ _('lg')}}</th>
                                            <th>{{ _('samsung')}}</th>
                                            <th>{{ _('Fire Tv')}}</th>
                                            <th>{{ _('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ads_variables as $key => $ads_variable)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $ads_variable->name ?? ' -' }}</td>
                                                <td>{{ $ads_variable->website ?? ' -'  }}</td>
                                                <td>{{ $ads_variable->andriod ?? ' -'  }}</td>
                                                <td>{{ $ads_variable->ios ?? ' -'  }}</td>
                                                <td>{{ $ads_variable->tv ?? ' -' }}</td>
                                                <td>{{ $ads_variable->roku ?? ' -' }}</td>
                                                <td>{{ $ads_variable->lg ?? ' -' }}</td>
                                                <td>{{ $ads_variable->samsung ?? ' -' }}</td>
                                                <td>{{ $ads_variable->firetv ?? ' -' }}</td>
                                                <td>
                                                    <a class="iq-bg-success edit_variable" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"
                                                        data-toggle="modal" data-target='#edit_modal' data-id="{{ $ads_variable->id }}"><img class="ply"
                                                        src="{{ URL::to('/assets/img/icon/edit.svg') }}">
                                                    </a>

                                                    <a onclick="return confirm('Are you sure?')" href="{{ URL::to('/admin/ads/variable-delete') . '/' . $ads_variable->id }}"
                                                        class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                        <img class="ply" src="{{ URL::to('/assets/img/icon/delete.svg') }}">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clear"></div>

                                <div class="pagination-outter"><?= $ads_variables->appends(Request::only('s'))->render() ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_modal">
        <div class="modal-dialog">
            <form id="variable_data">
                <div class="modal-content">
                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" id="url" name="url" value="">
                    <div class="modal-body">

                        <label>{{ _('Variable Name') }}</label>
                        <input type="text" name="name" id="name" value="" class="form-control" placeholder="Enter the Variable Name">

                        <label>{{ _('Website')}}</label>
                        <input type="text" name="website" id="website" value="" class="form-control" placeholder="Enter the Website">

                        <label>{{ _('Andriod')}}</label>
                        <input type="text" name="andriod" id="andriod" value="" class="form-control" placeholder="Enter the Andriod">

                        <label>{{ _('Ios')}}</label>
                        <input type="text" name="ios" id="ios" value="" class="form-control" placeholder="Enter the IOS">

                        <label>{{ _('Tv')}}</label>
                        <input type="text" name="tv" id="tv" value="" class="form-control" placeholder="Enter the TV">
                            
                        <label>{{ _('Roku')}}</label>
                        <input type="text" name="roku" id="roku" value="" class="form-control" placeholder="Enter the Roku">

                        <label>{{ _('Lg')}}</label>
                        <input type="text" name="Lg" id="Lg" value="" class="form-control" placeholder="Enter the LG">

                        <label>{{ _('Samsung')}}</label>
                        <input type="text" name="samsung" id="samsung" value="" class="form-control" placeholder="Enter the Samsung">
                         
                        <label>{{ _('Fire Tv')}}</label>
                        <input type="text" name="firetv" id="firetv" value="" class="form-control" placeholder="Enter the fire tv">
                         
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    </div>
                    <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-info">
                </div>
            </form>
        </div>
    </div>

    @section('javascript')

        <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('body').on('click', '#submit', function(event) {
                    event.preventDefault()
                    var url = $("#url").val();
                    var formData = $("#variable_data").serialize();

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            $('#variable_data').trigger("reset");
                            $('#edit_modal').modal('hide');
                            window.location.reload(true);
                        }
                    });
                });

                $('body').on('click', '.edit_variable', function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    $.get('variable-edit/' + id, function(data) {

                        $('#userCrudModal').html("Edit Plan");
                        $('#submit').val("Edit Plan");
                        $('#edit_modal').modal('show');
                        
                        $('#name').val(data.data.name);
                        $('#website').val(data.data.website);
                        $('#andriod').val(data.data.andriod);
                        $('#ios').val(data.data.ios);
                        $('#tv').val(data.data.tv);
                        $('#roku').val(data.data.roku);
                        $('#Lg').val(data.data.lg);
                        $('#samsung').val(data.data.samsung);
                        $('#firetv').val(data.data.firetv);
                        $('#url').val('variable-update/' + id);
                    })
                });

                $('body').on('click', '.create_variable', function(event) {
                    event.preventDefault();
                    $('#userCrudModal').html("Add Variable");
                    $('#submit').val("Add Variable");
                    $('#edit_modal').modal('show');
                    $('#url').val('variable-store');
                });
            });
        </script>
    @stop

@stop