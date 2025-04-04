@extends('admin.master')

@section('content')
    <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="iq-card">

                    <div class="modal-body">
                        <form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/footer_update') }}" method="post">

                            <div class="form-group col-md-6">
                                <label>Name:</label>
                                <input type="text" id="footer_name" name="footer_name"  class="form-control"  value=" {{ $footer->name  }}" placeholder="Enter the Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Url Type:</label>
                                <select name="url_type" id="url_type" class="form-control">
                                    <option value="" {{ $footer->url_type == ' ' ? 'selected':'' }} > Select the type</option>
                                    <option value="base_url" {{ $footer->url_type == 'base_url' ? 'selected':'' }} > Base Url</option>
                                    <option value="custom_url" {{ $footer->url_type == 'custom_url' ? 'selected':'' }} > Custom Url</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Link:</label>
                                <input type="text" id="footer_link" name="footer_link" value=" {{ $footer->link  }}" class="form-control" placeholder="Enter the Link">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Column position :</label>

                                <select name="column_position" id="column_position" class="form-control">
                                    <option value="" {{ $footer->column_position == ' ' ? 'selected':'' }} > Select the Position</option>
                                    <option value="1" {{ $footer->column_position == '1' ? 'selected':'' }} > Column 1</option>
                                    <option value="2" {{ $footer->column_position == '2' ? 'selected':'' }} > Column 2</option>
                                    <option value="3" {{ $footer->column_position == '3' ? 'selected':'' }} > Column 3</option>
                                    <option value="4" {{ $footer->column_position == '4' ? 'selected':'' }} > Column 4</option>
                                  </select>
                            
                            </div>

                            <input type="hidden" name="id" id="id" value="{{ $footer->id }}" />
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit-update-menu">Update</button>
                        <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/menu') }}">Close</a>
                    </div>

                </div>
            </div>
    </div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

    @section('javascript')

            <script>
                $(document).ready(function(){
                    $('#submit-update-menu').click(function(){
                        $('#update-menu-form').submit();
                    });
                });
                
            </script>

            {{-- validate --}}

            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
            <script>
                $('form[id="update-menu-form"]').validate({
                    rules: {
                        footer_name : 'required',
                        footer_link : 'required',
                        column_position: 'required'
                        },
                    submitHandler: function(form) {
                        form.submit(); }
                    });
            </script>

    @stop

