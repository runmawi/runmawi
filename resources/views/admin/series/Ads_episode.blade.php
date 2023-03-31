<script>

   $("#ads_position").change(function(){

      let ads_position = $("#ads_position").val();

      $('#episode_ads').empty();
      $('#episode_ads').append( $('<option value=" "> Searching... </option>')) ;

      $.ajax({
         type: "POST", 
         dataType: "json", 
         url: "{{ route('episode_ads_position') }}",
               data: {
                  _token  : "{{ csrf_token() }}" ,
                  ads_position: ads_position,
         },
         success: function(data) {

            console.log(data.episode_ads.length);
               if(data.status == true){

                  if(data.episode_ads.length  === 0){
                     $('#episode_ads').empty();
                     $('#episode_ads').append( $('<option value=" "> No Ads Found</option>')) ;
                  }

                  $.each(data.episode_ads , function (i, episode_ads) {
                     $('#episode_ads').empty();
                     $('#episode_ads').append( $('<option value=" "> Select the Advertisement </option>')) ;
                     $('#episode_ads').append( $('<option></option>').val(episode_ads.id).html( episode_ads.ads_name) )}
                  );
               }
            },
      });
   });
</script>  