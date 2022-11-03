<script>

    $( document ).ready(function() {

      var pre_ads  = $('#pre_ads_value').val();
      var mid_ads  = $('#mid_ads_value').val();
      var post_ads = $('#post_ads_value').val();

      if( pre_ads == null ){
       $('#pre_ads_div').hide();
      }

      if( mid_ads == null ){
         $('#mid_ads_div').hide();
      }

      if( post_ads == null ){
         $('#post_ads_div').hide();
      }

    });

    $("#pre_ads_category").change(function(){

       let ads_category = $("#pre_ads_category").val();

       $('#pre_ads').empty();
       $('#pre_ads').append( $('<option value=" "> Select Pre-Ad </option>')) ;

       $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{{ route('pre_videos_ads') }}",
                data: {
                   _token  : "{{ csrf_token() }}" ,
                   ads_category_id: ads_category,
          },
          success: function(data) {

                if(data.status == true){

                   if(data.ads_videos.length  === 0){
                      $('#pre_ads_div').show();
                      $('#pre_ads').empty();
                      $('#pre_ads').append( $('<option value=" "> No Ads Found</option>')) ;
                   }else{
                      $('#pre_ads_div').show();
                   }

                   $.each(data.ads_videos , function (i, ads_videos) {
                      $('#pre_ads').append( $('<option></option>').val(ads_videos.id).html( ads_videos.ads_name) )}
                   );
                }
             },
       });
    });

    $("#mid_ads_category").change(function(){

       let ads_category = $("#mid_ads_category").val();

       $('#mid_ads').empty();
       $('#mid_ads').append( $('<option value=" "> Select Mid-Ad </option>')) ;

       $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{{ route('mid_videos_ads') }}",
                data: {
                   _token  : "{{ csrf_token() }}" ,
                   ads_category_id: ads_category,
          },
          success: function(data) {

                if(data.status == true){

                   if(data.ads_videos.length  === 0){
                      $('#mid_ads_div').show();
                      $('#mid_ads').empty();
                      $('#mid_ads').append( $('<option value=" "> No Ads Found</option>')) ;
                   }else{
                      $('#mid_ads_div').show();
                   }

                   $.each(data.ads_videos , function (i, ads_videos) {
                      $('#mid_ads').append( $('<option></option>').val(ads_videos.id).html( ads_videos.ads_name) )}
                   );
                }
             },
       });
    });


    $("#post_ads_category").change(function(){

       let ads_category = $("#post_ads_category").val();

       $('#post_ads').empty();
       $('#post_ads').append( $('<option value=" "> Select Post-Ad </option>')) ;

       $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{{ route('post_videos_ads') }}",
                data: {
                   _token  : "{{ csrf_token() }}" ,
                   ads_category_id: ads_category,
          },
          success: function(data) {

                if(data.status == true){

                   if(data.ads_videos.length  === 0){
                      $('#post_ads_div').show();
                      $('#post_ads').empty();
                      $('#post_ads').append( $('<option value=" "> No Ads Found</option>')) ;
                   }else{
                      $('#post_ads_div').show();
                   }

                   $.each(data.ads_videos , function (i, ads_videos) {
                      $('#post_ads').append( $('<option></option>').val(ads_videos.id).html( ads_videos.ads_name) )}
                   );
                }
             },
       });
    });
</script>  