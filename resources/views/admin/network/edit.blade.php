@extends('admin.master')

@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                </div>
            </div>

            <div class="iq-card">
                <h4><i class="entypo-archive"></i> Edit TV-Shows Networks</h4>
                <div class="modal-body">
                    <form id="update-cat-form" accept-charset="UTF-8" action="{{ route('admin.Network_update',[ 'id' => $Series_Network->id ]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label class="m-0">Name:</label>
                            <input type="text" id="name" name="name" value="{{ $Series_Network->name }}" class="form-control" placeholder="Enter Name">
                        </div>

                        <div class="form-group">
                            <label class="m-0">Slug:</label>
                            <input type="text" id="slug" name="slug" value="{{ $Series_Network->slug }}" class="form-control" placeholder="Enter Slug">
                        </div>

                        <div class="form-group">
                            <label>Display In Menu :</label>
                            <label><input type="radio" name="in_menu" value="1" {{ ($Series_Network->in_menu == 1) ? 'checked' : '' }} >Yes</label>
                            <label><input type="radio" name="in_menu" value="0" {{  $Series_Network->in_menu == 0 ? 'checked' : '' }}>No</label>
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Display In Home :</label>
                            <input type="radio" id="in_home" id="in_home" name="in_home" value="1" {{ ($Series_Network->in_home == 1) ? 'checked' : '' }} >Yes
                            <input type="radio" id="in_home" name="in_home" value="0" {{ ($Series_Network->in_home == 0) ? 'checked' : '' }}  >No
                        </div>

                        <div class="form-group">
                            <label>Display In Category List :</label>
                            <input type="radio" name="network_list_active" value="1" {{ $Series_Network->network_list_active == 1 ? 'checked' : ' ' }} />Yes
                            <input type="radio" name="network_list_active" value="0" {{ $Series_Network->network_list_active == 0 ? 'checked' : ' ' }} />No
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="m-0">Image:</label>
                                    @if (!empty($Series_Network->image))
                                        <img src="{{ $Series_Network->image_url }}" class="movie-img" width="200" />
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input type="file" multiple="true" class="form-control" name="image" id="image" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="m-0">Banner Image:</label>
                                    @if (!empty($Series_Network->banner_image))
                                        <img src="{{ $Series_Network->banner_image_url }}" class="movie-img" width="200" />
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input type="file" multiple="true" class="form-control" name="banner_image" id="banner_image" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="m-0">Networks:</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value=null>Select</option>
                                @foreach ($All_SeriesNetwork as $rows)
                                    <option value="{{ $rows->id }}" @if ($rows->id == $Series_Network->parent_id) selected @endif>
                                        {{ $rows->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ route('admin.Network_index') }}">Close</a>
                    <button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
                </div>
            </div>
        </div>
    </div>

    @section('javascript')

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#submit-update-cat').click(function() {
                    $('#update-cat-form').submit();
                });

                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000);
            });
                
            $('form[id="update-cat-form"]').validate({
                rules: {
                    name: 'required',
                },
                messages: {
                    title: 'This field is required',
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
    </script>
    @stop
@stop