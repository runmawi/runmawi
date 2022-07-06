    @partial('category_header')
<!-- Header End -->
<style>
    .btn{
        background-color: transparent!important;
    }
</style>
<!-- MainContent -->
<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; } 

$category_id = App\VideoCategory::where('name',$data['category_title'])->pluck('id')->first();
$category_slug = App\VideoCategory::where('name',$data['category_title'])->pluck('slug')->first();

?>

      <div class="main-content">
         <section id="iq-favorites">
            <div class="container-fluid">
               <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header align-items-center d-flex justify-content-between">
                        <h2 class=""><?php echo __($data['category_title']);?></h2>
                    </div>

                    {{-- filter Option --}}

                        <div class="row mt-2 p-0">

                            {{-- <div class="col-md-3">
                                <select class="selectpicker" multiple title="Refine" data-live-search="true">
                                    <option value="videos">Movie</option>
                                    <option value="tv_Shows">TV Shows</option>
                                    <option value="live_stream">Live stream</option>
                                    <option value="audios">Audios</option>
                                </select>
                            </div> --}}

                            <div class="col-md-3">
                                <select class="selectpicker" multiple title="Age" name="age[]" id="age" data-live-search="true">
                                    @foreach($data['age_categories'] as $age)
                                        <option value="{{ $age->age  }}">{{ $age->slug }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select class="selectpicker" multiple title="Rating" id="rating" name="rating[]" data-live-search="true">
                                    <option value="1" >1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>

                            
                            <div class="col-md-3">
                                <select class="selectpicker " multiple  title="Newly added First" id="sorting" name="sorting" data-live-search="true">
                                    <option value="latest_videos">Latest Videos</option>
                                </select>
                            </div>

                            <input type="hidden" id="category_id" value={{ $category_id  }} name="category_id">

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary filter">Filter</button>
                            </div>
                        </div>  

                        <div class="data">
                            @partial('categoryvids_section')
                        </div>

                  </div>
               </div>
            </div>
</section>
</div>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

{{--Multiple Select  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">


<script>

$(".filter").click(function(){
    var age = [];
    var rating = [];
    var sorting = [];
    var Category_id = $('#category_id').val();


    for (var option of document.getElementById('age').options)
    {
        if (option.selected) {
            age.push(option.value);
        }
    }

    for (var option of document.getElementById('rating').options)
    {
        if (option.selected) {
            rating.push(option.value);
        }
    }

    for (var option of document.getElementById('sorting').options)
    {
        if (option.selected) {
            sorting.push(option.value);
        }
    }

    $.ajax({
            type: "get", 
            url: "{{ url('/categoryfilter') }}",
             data: {
                 _token  : "{{csrf_token()}}" ,
                 age: age,
                 rating: rating,
                 sorting: sorting,
                 category_id: Category_id,
            },
            success: function(data) {
                    $(".data").html(data);
                },
            });
        });

</script>


<script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            $(this).html('<i class="ri-heart-fill"></i>');                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            $(this).html('<i class="ri-heart-line"></i>');
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });



</script>

