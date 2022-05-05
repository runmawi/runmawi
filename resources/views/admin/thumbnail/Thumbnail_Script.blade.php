@section('javascript')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

    $('.title').on('change', function(event) {
        var title    = $("#title").prop("checked");
        
            if(title == true){
                Swal.fire({
                    title: 'Thumbnail - Title !',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_title.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });

    $('.age').on('change', function(event) {
        var age      = $("#age").prop("checked");
            if(age == true){
                Swal.fire({
                    title: 'Thumbnail - Age',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_age.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });

    $('.rating').on('change', function(event) {
        var rating   = $("#rating").prop("checked");

            if(rating == true){
                Swal.fire({
                    title: 'Thumbnail - Rating',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_rating.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });

    $('.published_year').on('change', function(event) {
        var published_year     = $("#published_year").prop("checked");

            if(published_year == true){
                Swal.fire({
                    title: 'Thumbnail - Published Year',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_year.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });


    $('.duration').on('change', function(event) {
        var duration = $("#duration").prop("checked");
            if(duration == true){
                Swal.fire({
                    title: 'Thumbnail - Duration',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_duration.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });


    $('.featured').on('change', function(event) {
        var featured = $("#featured").prop("checked");
            if(featured == true){
                Swal.fire({
                    title: 'Thumbnail - Featured',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_featured.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });


    $('.free_or_cost_label').on('change', function(event) {
        var free_or_cost_label = $("#free_or_cost_label").prop("checked");
            if(free_or_cost_label == true){
                Swal.fire({
                    title: 'Thumbnail - Free or Cost Label',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_cost.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });

    $('.category').on('change', function(event) {
        var category = $("#category").prop("checked");
            if(category == true){
                Swal.fire({
                    title: 'Thumbnail - Category',
                    imageUrl: "{{ URL::to('/public/Thumbnai_images/Thumbail_catogery.png')}}" ,
                    imageWidth: 150,
                    imageHeight: 250,
                    imageAlt: 'Custom image',
                })
            }
    });

</script>

@stop