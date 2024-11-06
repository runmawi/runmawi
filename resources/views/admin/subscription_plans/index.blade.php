@extends('admin.master')

<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }

    .make-switch {
        z-index: 2;
    }

    .admin-container {
        padding: 10px;
    }

    .iq-card {
        padding: 15px !important;
    }

    .p1 {
        font-size: 12px !important;
    }

    #devices_valid {
        border: transparent;
    }

    label#devices\[\]-error {
        width: 370px;
        margin-top: 18px;
    }
</style>

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="admin-section-title">
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><i class="entypo-archive"></i> Subscription Plans </h4>
                        </div>

                        <div class="col-md-6" align="right">
							<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary">
								<i class="fa fa-plus-circle"></i> Add New
							</a>
						</div>
                    </div>

					<div class="row">
                        <div class="col-sm-6 d-flex">
                            <label class="m-0">Enable / Disable Multiple Plans  </label>
                            <div class="panel-body">
                                <div class="mt-1 p-1">
                                    <label class="switch">
                                        <input name="multiple_subscription_plan" class="Multiple_Subscription_Plan" type="checkbox" {{ ($setting->multiple_subscription_plan) == "1" ? 'checked' : ''  }}  onchange="Update_Multiple_Subscription_Plans(this)" >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
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

                    <div class="clear"></div>

                    <!-- Add New Modal -->

                    <div class="modal fade" id="add-new">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Add Plan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/subscription-plans/store') }}" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                       
										<div class="form-group">
                                            <label> Plan Name:</label>
                                            <input type="text" id="slug" name="plans_name" value="" class="form-control" placeholder="Plan Name">
                                        </div>

                                        <div class="form-group">
                                            @forelse ($payment_settings as $payment_setting)
                                                @if ($payment_setting->status == 1)
                                                    <label>{{ $payment_setting->payment_type }} Plan ID:</label>
                                                    <input type="text" id="plan_id" name="plan_id[]" value="" class="form-control" placeholder="Plan ID">
                                                    <p>* Get Plan Key From {{ $payment_setting->payment_type }}</p>
                                                @endif
                                            @empty
                                            @endforelse
                                        </div>

                                        <div class="form-group">
                                            <label>Billing Interval:</label>
                                            <input type="text" id="billing_interval" name="billing_interval" value="" class="form-control" placeholder="  etc .. Monthly , Yearly , 3 months ..">
                                        </div>

                                        <div class="form-group">
                                            <label>Billing Type:</label>
                                            <input type="text" id="billing_type" name="billing_type" value="" class="form-control" placeholder="Example .. Non Refundable">
                                        </div>

                                        <div class="form-group p-1">
                                            <label> Plan Content :</label>
                                            <textarea class="form-control" id="plan_content" name="plan_content"> </textarea>
                                        </div>

                                        <!-- @if ($paystack_status != null)
                                            <div class="form-group p-1">
                                                <label> {{ ucwords('andriod paystack url') }}</label>
                                                <input type="url" class="form-control" id="andriod_paystack_url" name="andriod_paystack_url">
                                            </div>
                                        @endif -->

                                        <div class="form-group">
                                            <label>Payment Type:</label><br>
                                            <input type="radio" name="payment_type" value="recurring" checked='checked'> Recurring
                                        </div>

                                        <div class="form-group">
                                            @foreach ($payment_settings as $payment_setting)
                                                <input type="hidden" name="type[]" value="{{ $payment_setting->payment_type }}">
                                            @endForeach
                                        </div>

                                        <div class="form-group">
                                            <label> Price ( {{ @$allCurrency->symbol }} ):</label>
                                            <input type="text" id="price" name="price" value="" class="form-control" placeholder="Price">
                                        </div>

                                        <div class="form-group">
                                            <label> Days :</label>
                                            <input type="text" id="days" name="days" value="" class="form-control" placeholder="Days">
                                        </div>

                                        <div class="form-group">
                                            <label>Video Quality:</label>
                                            <input type="text" id="video_quality" name="video_quality" value="" class="form-control" placeholder="Quality">
                                        </div>

                                        <div class="form-group">
                                            <label>Resolution :</label>
                                            <input type="text" id="resolution" name="resolution" value="" class="form-control" placeholder="Resolution">
                                        </div>

                                        <div class="form-group">
                                            <label> IOS Product ID :</label>
                                            <input type="text" id="ios_product_id" name="ios_product_id" value="" class="form-control" placeholder="IOS Product ID">
                                        </div>

                                        <div class="form-group">
                                            <label>IOS Plan Price ( {{ @$allCurrency->symbol }} ):</label>
                                            <input type="text" id="ios_plan_price" name="ios_plan_price" value="" class="form-control" placeholder="IOS Plan Price">
                                        </div>

                                                {{--  coupon on checkout --}}

                                        <div class="d-flex form-group">
                                            <div class="form-group">
                                                <label> {{ ucwords('enable promo code on checkout') }} : <br> <small> (only for Stripe Payment) </small> </label>
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input name="auto_stripe_promo_code_status" class="auto_stripe_promo_code_status" id="auto_stripe_promo_code_status" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
    
                                            <div class="form-group">
                                                <label> {{ ucwords('Apply promo code on checkout') }} : <br> <small> (only for Stripe Payment) </small> </label>
                                                <input type="text" id="auto_stripe_promo_code" name="auto_stripe_promo_code"  class="form-control" placeholder="Promo Code">
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label> {{ ucwords('enable ads') }} :</label>
                                            <div class="mt-1">
                                                <label class="switch">
                                                    <input name="ads_status" class="ads_status" id="ads_status" type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div> <label> Devices :</label> </div>

                                        @forelse($devices as $val)
                                            <div class="col-md-5 " style="width:35%; float:left;">
                                                <div class="d-flex align-items-center justify-content-around">
                                                    <div> <label> {{ $val->devices_name }}</label> </div>
                                                    <div>
                                                        <label class="switch cod-md-6">
                                                            <input type="checkbox" name="devices[]"
                                                                value="{{ $val->id }}">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <input type="text" name="devices_valid" id="devices_valid" value="" readonly>
                                        @endforelse
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary category-panel" data-collapsed="0"></div>

                    <div class="panel-body mt-3 p-0">
                        <div id="nestable" class="nested-list dd with-margins">
                            <table class="table plan_table iq-card text-center" id="Subscription_Plans">
                                <thead>
                                    <tr class="r1">
                                        <th>S.No</th>
                                        <th>Plan Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
									<?php $i = 1 ;?>
                                    @foreach ($plans as $k => $plan)
                                        <tr>
                                            <td>{{  $i++  }}</td>
                                            <td>{{ $plan[0]->plans_name }}</td>
                                            <td class="">
												<a href="{{ URL::to('/') }}/admin/subscription-plans/edit/{{ $plan[0]->id }}"
                                                    class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<img class="ply" src="<?php echo URL::to('assets/img/icon/edit.svg'); ?>">
												</a>
                                                
												<a onclick="return confirm('Are you sure?')"
                                                    href="{{ URL::to('/') }}/admin/subscription-plans/delete/{{ $plan[0]->id }}"
													class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
													<img class="ply" src="<?php echo URL::to('/') . '/assets/img/icon/delete.svg'; ?>">
												</a>
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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#submit-new-cat').click(function() {
				$('#new-cat-form').submit(); // Add New Category
			});
		});

		//  validate 
		$('form[id="new-cat-form"]').validate({
			rules: {
				'plans_name': 'required',
				'billing_interval': 'required',
				'billing_type': 'required',
				'price': 'required',
				'days': 'required',
				'video_quality': 'required',
				'resolution': 'required',
				'plan_id[]': 'required',
				'devices_valid': 'required',
				'devices[]': {
					required: true,
					maxlength: 2
				}
			},
			messages: {
				'plans_name': "Please Enter the Plan Name",
				'billing_interval': "Please Enter the Billing Interval",
				'billing_type': "Please Enter the Billing Type",
				'price': "Please Enter the Billing Price",
				'days': "Please Enter the Subscription Days",
				'video_quality': "Please Enter the Video Quality",
				'resolution': "Please Enter the Resolution",
				'plan_id[]': "Please Enter the Plan-Id",
				'devices[]': "Please Enable one of the device toggles.",
				'devices_valid': "Please Add devices."

			},

			submitHandler: function(form) {
				form.submit();
			}
		})
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#plan_content' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

	<script>
		$(document).ready(function() {
			setTimeout(function() {
				$('#successMessage').fadeOut('fast');
			}, 3000);
		})


		$(document).ready(function() {

			$('#Subscription_Plans').DataTable({ });
		});
        
        function Update_Multiple_Subscription_Plans(ele) {

            var Status = $('.Multiple_Subscription_Plan').prop("checked");

            var actionText = Status ? "active" : "remove";

            var Multiple_Subscription_Plan = Status ? '1' : '0';

            var confirmationMessage = "Are you sure you want to " + actionText + " this Multiple Subscription Plan?";
            var check = confirm(confirmationMessage);

            if (check) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('Update_Multiple_Subscription_Plans') }}",
                    data: {
                        _token: "{{csrf_token()}}",
                        Multiple_Subscription_Plan: Multiple_Subscription_Plan,
                    },
                    success: function (data) {
                        if (data.message == 'false') {
                            swal.fire({
                                title: 'Oops',
                                text: 'Something went wrong!',
                                allowOutsideClick: false,
                                icon: 'error',
                                title: 'Oops...',
                            }).then(function () {
                                location.href = '{{ URL::to('admin/subscription-plans') }}';
                            });
                        }
                    },
                });
            } else {
                $(ele).prop('checked', !Status);
            }
        }

    </script>

@stop