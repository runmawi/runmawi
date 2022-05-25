@include('avod::ads_header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css">

<div id="content-page" class="content-page">
    <div class="iq-card">
        <div class="container-fluid">
            <div class="row col-sm-12">
                <div class="col-sm-9">
                    <h5>Ads Schedule</h5>
                </div>

                <div class="col-sm-3">
                    <a href="{{ URL::to('advertiser/Ads_Scheduled') }}" class="btn btn-primary" style="margin-left: 80%;">Back</a>
                </div>
            </div>

            <form action="{{ route('AdsScheduleStore') }}" method="POST" enctype="multipart/form-data" id="Ads_schedule">
            @csrf
            <div class="container">
                <div class="row">

                    <div class="col-md-6 form-group mt-3">
                            <label>Event Title :</label>
                            <input type="text" name="title" class="form-control" placeholder="Event Title" />
                    </div>

                    <div class="col-md-3 form-group mt-3 color-picker">
                            <label>Color :</label>
                            <input type="color" name="color" class="form-control" placeholder="Color" />
                    </div>

                    <div class="col-md-6 form-group mt-3">
                            <label>Start Date & time :</label>
                            <input type="text" name="start" class="form-control timepicker datetime date   " placeholder="Start Date & time" />
                    </div>

                    <div class="col-sm-6 form-group mt-3">
                        <label class="">End Date & time :</label>
                        <input type="text" name="end" class="form-control timepicker" placeholder="End Date & time" />
                     </div>

                    <div class="col-sm-6 form-group mt-3">
                        <label class="">Choose Ad Category</label>
                        <select class="form-control" name="ads_category">
                           <option value=" ">Select Category</option>
                                @foreach($ads_category as $ad)
                                    <option value="{{ $ad->id }}" > {{ ucwords($ad->name) }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 form-group mt-3">
                            <input type="hidden" name="type" class="form-control" value={{ 'add' }} />
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error{
        color: #d52525;
    }
</style>

@yield('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.14.30/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script type="text/javascript">
	$('.timepicker').datetimepicker({ 
				allowInputToggle: true,
				showClose: false, //close the picker
				format: 'YYYY-MM-DD HH:mm:ss', //YYYY-MMM-DD LT
				calendarWeeks: false,
				inline: false,
        sideBySide: true
		});


    $('form[id="Ads_schedule"]').validate({
        rules: {
            title: "required",
            start: "required",
            end: "required",
            ads_category: "required",
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
</script> 


