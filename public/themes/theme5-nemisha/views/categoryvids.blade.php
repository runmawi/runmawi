@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<?php

if (!Auth::guest() && !empty($data['password_hash'])) {
    $id = Auth::user()->id;
} else {
    $id = 0;
}

$category_id = App\VideoCategory::where('name', $categoryVideos['category_title'])
    ->pluck('id')
    ->first();

$category_slug = App\VideoCategory::where('name', $categoryVideos['category_title'])
    ->pluck('slug')
    ->first();
?>

<div class="main-content">
    <section id="iq-favorites">
        <h2 class="text-center  mb-3"><?php echo __($categoryVideos['category_title']); ?></h2>
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">

                    {{-- filter Option --}}


                        {{-- @partial('categoryvids_section_filter') --}}

                    <div class="data">
                        @partial('categoryvids_section')
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Modal Starts -->
<!-- MainContent End-->

@php
    include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp

{{-- Multiple Select  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">


<script>
    $(".filter").click(function() {
        var age = [];
        var rating = [];
        var sorting = [];
        var Category_id = $('#category_id').val();


        for (var option of document.getElementById('age').options) {
            if (option.selected) {
                age.push(option.value);
            }
        }

        for (var option of document.getElementById('rating').options) {
            if (option.selected) {
                rating.push(option.value);
            }
        }

        for (var option of document.getElementById('sorting').options) {
            if (option.selected) {
                sorting.push(option.value);
            }
        }

        $.ajax({
            type: "get",
            url: "{{ url('/categoryfilter') }}",
            data: {
                _token: "{{ csrf_token() }}",
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
    $('.mywishlist').click(function() {
        var video_id = $(this).data('videoid');
        if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                $.ajax({
                    url: "<?php echo URL::to('/mywishlist'); ?>",
                    type: "POST",
                    data: {
                        video_id: $(this).data('videoid'),
                        _token: '<?= csrf_token() ?>'
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == "Added To Wishlist") {
                            $(this).html('<i class="ri-heart-fill"></i>');
                            $('#' + video_id).text('');
                            $('#' + video_id).text('Remove From Wishlist');
                            $("body").append(
                                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>'
                                );
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {
                            $(this).html('<i class="ri-heart-line"></i>');
                            $('#' + video_id).text('');
                            $('#' + video_id).text('Add To Wishlist');
                            $("body").append(
                                '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>'
                                );
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
