@extends('admin.master')

@section('content')
    <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="iq-card">

                    <div class="modal-body">
                        <form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/mobile/side_update') }}" enctype="multipart/form-data" method="post">

                            <div class="form-group col-md-6">
                                <label>Icon Image:</label>
                                <input type="file" name="image" id="image" >
                                <br>
                                <br>
                                @if($MobileSideMenu->image != null )
                                 <img src="{{ $MobileSideMenu->image }}" width="200" height="200"  class="" />
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label>Name:</label>
                                <input type="text" id="name" name="name"  class="form-control"  value=" {{ $MobileSideMenu->name  }}" placeholder="Enter the Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Short Note:</label>
                                <input type="text" id="short_note" name="short_note" value=" {{ $MobileSideMenu->short_note  }}" class="form-control" placeholder="Enter the Short Note">
                            </div>

                            <input type="hidden" name="id" id="id" value="{{ $MobileSideMenu->id }}" />
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit-update-menu">Update</button>
                        <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/mobile/side_menu') }}">Close</a>
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
                        name : 'required',
                        short_note : 'required',
                        },
                    submitHandler: function(form) {
                        form.submit(); }
                    });
            </script>

    @stop

