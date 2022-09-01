@section('javascript')
            {{-- Select 2 --}}
    <script>
        $(document).ready(function () {
            $(".js-example-basic-multiple").select2();
            $('#mySelect2').select2({
                selectOnClose: true
            });
        });
    </script>

            {{-- validation --}}

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $('form[id="channel_package"]').validate({
            rules: {
                channel_package_name: "required",
                channel_package_plan_id: "required",
                channel_package_price: "required",
                channel_plan_interval: "required",
                'add_channels[]':"required",
            },
            messages: {
                channel_package_name: "This field is required",
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    </script>

@stop
