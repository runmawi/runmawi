@section('javascript')

<script src="{{ URL::to('/assets/admin/js/sweetalertfire.min.js') }}"></script>

   <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);
        });

    function update_status(ele){

        var landing_page_id = $(ele).attr('data-landing-page-id');
        var status   = '#landing_id'+landing_page_id;
        var landing_page_Status = $(status).prop("checked");

        if(landing_page_Status == true){
            var status  = '1';
            var check = confirm("Are you sure you want to active this Landing Page?");  

        }else{
            var status  = '0';
            var check = confirm("Are you sure you want to remove this Landing Page?");  
        }

        if(check == true){ 

        $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: "{{ route('landing_page_update_status') }}",
                        data: {
                            _token  : "{{csrf_token()}}" ,
                            landing_page_id: landing_page_id,
                            status: status,
                    },
                    success: function(data) {
                        if(data.message == 'true'){
                        }
                        else if(data.message == 'false'){
                            swal.fire({
                            title: 'Oops', 
                            text: 'Something went wrong!', 
                            allowOutsideClick:false,
                            icon: 'error',
                            title: 'Oops...',
                            }).then(function() {
                                location.href = '{{ route("landing_page_index") }}';
                            });
                        }
                    },
                });
        }else if(check == false){
            $(status).prop('checked', true);
        }
    }

    </script>

@stop