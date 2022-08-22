@section('javascript')

<script src="{{ URL::to('/assets/admin/js/sweetalertfire.min.js') }}"></script>

<script>

    CKEDITOR.replaceAll( 'summary-ckeditor', {
        toolbar : 'simple'
    });

    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })

</script>

@stop