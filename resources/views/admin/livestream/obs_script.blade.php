<script>

function addRow(ele) 
		{
			var stream_key = $(ele).attr('data-name');
			var Rtmp_url   = $(ele).attr('data-rtmpURL');
			var Rtmp_title = $(ele).attr('data-title');
			var hls_url    = $(ele).attr('data-hls-url');

			var youtube_restream    = $(ele).attr('data-youtube-restream');
			var facebook_restream   = $(ele).attr('data-facebook-restream');
			var twitter_restream    = $(ele).attr('data-twitter-restream');
			var linkedin_restream    = $(ele).attr('data-linkedin-restream');

			var youtube_restream  = '<div class="col-md-4">   <lable> Youtube </lable>  <td> <div class="mt-1"> <label class="switch">  <input name="youtube_restream"   type="checkbox" value= ' + youtube_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
			var facebook_restream = '<div class="col-md-4">   <lable> FaceBook </lable>  <td> <div class="mt-1"> <label class="switch"> <input name="facebook_restream"  type="checkbox" value= ' + facebook_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
			var twitter_restream  = '<div class="col-md-4">   <lable> Twitter </lable>  <td> <div class="mt-1"> <label class="switch">  <input name="twitter_restream"   type="checkbox" value= ' + twitter_restream + '  > <span class="slider round"></span></label></div></td></div>' ;
			var linkedin_restream = '<div class="col-md-4">   <lable> Linkedin </lable>  <td> <div class="mt-1"> <label class="switch"> <input name="linkedin_restream"  type="checkbox" value= ' + linkedin_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
		

			Swal.fire({
					allowOutsideClick:false,
					icon:'success',
					title: 'RTMP Streaming Details for '+ Rtmp_title ,
					html: '<div class="col-md-12">' + ' URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + 'Stream Key :  ' +  stream_key + '</div>'+"<br>"+ 
						  '<div class="col-md-12">' + 'HLS URL :  ' +  hls_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + '<form> <lable> Live Re-stream : </lable> <br> <br> <div class="row">' +  youtube_restream  +  facebook_restream + twitter_restream + linkedin_restream +'</div> </div>' +
						  '<div class="col-md-12"> <input type="submit" value="Start Restream"  class="btn btn-primary" onclick="restream_button(this)" > </div> </form>', 

			})
		}

		function restream_button(ele){

			var youtube_restream_checkbox   = $("input[name=youtube_restream]").prop("checked");
			var facebook_restream_checkbox  = $("input[name=facebook_restream]").prop("checked");
			var twitter_restream_checkbox   = $("input[name=twitter_restream]").prop("checked");
			var linkedin_restream_checkbox  = $("input[name=linkedin_restream]").prop("checked");

   
			var youtube_restream  = $("input[name=youtube_restream]").val();
			var facebook_restream = $("input[name=facebook_restream]").val();
			var twitter_restream  = $("input[name=twitter_restream]").val(); 
			var linkedin_restream = $("input[name=linkedin_restream]").val();


			$.ajax({
				type   : 'POST',
				url    : "{{ route('start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					youtube_restream_checkbox    : youtube_restream_checkbox, 
					facebook_restream_checkbox   : facebook_restream_checkbox, 
					twitter_restream_checkbox    : twitter_restream_checkbox, 
					linkedin_restream_checkbox   : linkedin_restream_checkbox, 
					youtube_restream    : youtube_restream, 
					facebook_restream   : facebook_restream, 
					twitter_restream    : twitter_restream,
					linkedin_restream   : linkedin_restream, 
				},

				success:function(data){
				}
        	});

		}

</script>