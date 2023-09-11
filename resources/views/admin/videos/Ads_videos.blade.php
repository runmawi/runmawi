<script>

       $("#tag_url_ads_position").change(function(){

         let position = $("#tag_url_ads_position").val();

         $('#ads_tag_url_id').empty();
         $('#ads_tag_url_id').append( $('<option value=" "> Searching...  </option>')) ;

         $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ route('tag_url_ads') }}",
                  data: {
                     _token  : "{{ csrf_token() }}" ,
                     position: position,
            },
            success: function(data) {

                  if(data.status == true){

                     if(data.ads_videos.length  === 0){
                        $('#ads_tag_url_id_div').show();
                        $('#ads_tag_url_id').empty();
                        $('#ads_tag_url_id').append( $('<option value=" "> No Ads Found</option>')) ;
                     }else{
                        $('#ads_tag_url_id_div').show();
                     }

                     $.each(data.ads_videos , function (i, ads_videos) {
                        $('#ads_tag_url_id').empty();
                        $('#ads_tag_url_id').append( $('<option value=" "> Select the Advertisement</option>')) ;
                        $('#ads_tag_url_id').append( $('<option></option>').val(ads_videos.id).html( ads_videos.ads_name) )}
                     );
                  }
               },
         });
      });

</script>  