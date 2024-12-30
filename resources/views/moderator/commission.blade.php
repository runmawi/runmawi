@extends('admin.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('dropzone/dist/min/dropzone.min.css') }}">

<!-- JS -->
<script src="{{ asset('dropzone/dist/min/dropzone.min.js') }}" type="text/javascript"></script>
@section('content')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Add Commission</h4>
                        </div>
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
                    <div class="iq-card-body">
                        <form method="POST" action="{{ URL::to('admin/add/commission') }}"  >
						@csrf

                            <div class="row mt-8 align-items-center">
                                <label>{{ ucfirst(trans('Enable Percentage Commission :')) }}</label>

                                <div class="d-flex col-md-12 " style="width:50%;justify-content: space-evenly;">
                                    <div style="color:#006AFF;">Commission Percentage(%) for CPP</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="CPP_Commission_Status" class="CPP_Commission_Status" id="CPP_Commission_Status" type="checkbox" {{ ($settings->CPP_Commission_Status) == "1" ? 'checked' : ''  }}   >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div style="color:green;">Commission Percentage(%) for CPP Individual Content </div>
                                </div>
                            </div><br>

                            <div class="row mt-12 align-items-center">
                                <div class="col-md-4 p-0">
                                    <div class="panel panel-primary " data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>Percentage (%) :</label></div>
                                            <div class="panel-options"> 
												<a href="#" data-rel="collapse">
													<i class="entypo-down-open"></i>
												</a> 
											</div>
                                        </div>

                                        <div class="panel-body" style="display: block;">
                                            <p class="p1">Add the Commissiom for Admin <small>{{ "( Only for CPP )" }} </small> </p> 
                                            <p class="p1">{{ "( Note: while CPP signup, remaining (%) will be allowed for CPP Users )" }} </p> 
											<input type="number" class="form-control" name="percentage" id="percentage"  value="{{ ( !empty($commission->percentage)) ? $commission->percentage : null }}" 
													min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
										</div>
                                    </div>
                                </div>
							</div>

                            <div class="row mt-12 align-items-center">
                                <div class="col-md-6 mt-3">
                                    <input type="hidden" name="id" value="@if (!empty($commission->id)) {{ $commission->id }} @endif" />
                                    <input type="submit" value="Update Percentage" class="btn btn-primary pull-right" />
                                </div>
                            </div>
                        </form>

                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')

    <script>

        $("#CPP_Commission_Status").click(function(ele) {

            var Status = $('#CPP_Commission_Status').prop("checked");

            var CPP_Commission_Status = Status ? '1' : '0';

            var confirmationMessage = "Are you sure you want to Change the CPP Commission Status?";
            var check = confirm(confirmationMessage);

            if (check) {
                $.ajax({
                    type: "get",
                    dataType: "json",
                    url: "{{ route('admin.CPP_commission_status_update') }}",
                    data: {
                        CPP_Commission_Status:  CPP_Commission_Status,
                    },
                    success: function (data) {
                        if (data.message == 'false') {

                            alert('Please try again later; the status has not yet updated');

                            location.href = "{{ URL::to('admin/moderator/commission') }}";
                        }else{
                            location.href = "{{ URL::to('admin/moderator/commission') }}";
                        }
                    },
                });
            } else {
                $(ele).prop('checked', !Status);
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })
    </script>
@stop

<style>
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	input[type="number"] {
		-moz-appearance: textfield;
	}
</style>
