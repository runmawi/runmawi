@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="iq-card">

                <div class="admin-section-title">
                    <h3><i class="entypo-archive"></i>Update Advertiser</h3>
                </div>

                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                @if (count($errors) > 0)
                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger display-hide" id="successMessage">
                            <button id="successMessage" class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                        </div>
                    @endforeach
                @endif

                <div class="clear"></div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="modal-body">
                    <form accept-charset="UTF-8" action="{{ URL::to('admin/advertiser/update') }}" method="post"
                        id="advertiser_edit">

                        <div class="row">

                            <div class="col-md-6 mt-2">
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label class="mb-1">Company Name:</label></div>
                                    </div>
    
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="company_name" name="company_name" value="{{ $advertisers->company_name }}" class="form-control" placeholder="Enter ">
                                    </div>
                                </div>
    
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label class="mb-1"> License Number:</label></div>
                                    </div>
    
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="license_number" name="license_number"
                                        value="{{ $advertisers->license_number }}" class="form-control" placeholder="Please! Enter the Adverister License Number">
                                    </div>
                                </div>
    
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"> <label class="mb-1"> Mobile Number: </label></div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="mobile_number" name="mobile_number" value="{{ $advertisers->mobile_number }}" class="form-control" placeholder="Enter ">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label class="mb-1"> Address :</label></div>
                                    </div>
    
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="address" name="address" value="{{ $advertisers->address }}"
                                        class="form-control" placeholder="Please! Enter the Adverister Address ">
                                    </div>
                                </div>
    
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label class="mb-1"> E-Mail Address:</label></div>
                                    </div>
                                    
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="email_id" name="email_id" value="{{ $advertisers->email_id }}"
                                        class="form-control" placeholder="Please! Enter the Adverister E-Mail Address  ">
                                    </div>
                                </div>
    
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label class="mb-1"> Password:</label></div>
                                        <p class="p1">( Leave empty to keep your original password )</p>
                                    </div>
    
                                    <div class="panel-body" style="display: block;">
                                        <input type="text" id="" name="password" value=""
                                            class="form-control" placeholder="Change of password">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="panel panel-primary mt-2" data-collapsed="0">
                                    <div class="panel-body" style="display: block;">
                                        <label class="mb-1">Adverister Active Status </label>
                                        <input type="checkbox" id="status" name="status"  {{ isset($advertisers->status) && $advertisers->status == 1 ? 'checked' : null }} />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="id" id="id" value="{{ $advertisers->id }}" />
                       
                        <div class="clear" style="margin-bottom: 36px;"></div>

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
                            <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/advertisers') }}">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop


@section('javascript')

    {{-- validate --}}

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $('form[id="advertiser_edit"]').validate({
            rules: {
                company_name: 'required',
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })
    </script>
@stop
