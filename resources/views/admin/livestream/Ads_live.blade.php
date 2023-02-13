<script>

   $("#ads_position").change(function(){

      let ads_position = $("#ads_position").val();

      $('#live_ads').empty();
      $('#live_ads').append( $('<option value=" "> Select the Advertisement </option>')) ;

      $.ajax({
         type: "POST", 
         dataType: "json", 
         url: "{{ route('live_ads_position') }}",
               data: {
                  _token  : "{{ csrf_token() }}" ,
                  ads_position: ads_position,
         },
         success: function(data) {

            console.log(data.live_ads.length);
               if(data.status == true){

                  if(data.live_ads.length  === 0){
                     $('#live_ads').empty();
                     $('#live_ads').append( $('<option value=" "> No Ads Found</option>')) ;
                  }

                  $.each(data.live_ads , function (i, live_ads) {
                     $('#live_ads').append( $('<option></option>').val(live_ads.id).html( live_ads.ads_name) )}
                  );
               }
            },
      });
   });
</script>  