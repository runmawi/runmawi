<?php include public_path('themes/default/views/header.php'); ?>

<style>
    .btn {
        /* background-color: transparent!important;
        width: 80%;*/
        border-radius: 5px;
    }

    .bootstrap-select>.dropdown-toggle {
        background-color: transparent !important;
        width: 92% !important;

    }


    /* <!-- BREADCRUMBS  */
    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }

    .nav-div.container-fluid {
        padding: 0;
    }
</style>


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
        <div class="container-fluid overflow-hidden">
            <div class="row pageheight">
                <div class="col-sm-12 ">
                    <div class="iq-main-header align-items-center d-flex justify-content-between">
                        <h2 class=""><?php echo __($categoryVideos['category_title']); ?></h2>
                    </div>

                    <!-- BREADCRUMBS -->
                    <div class=" d-flex">
                        <div class="nav nav-tabs nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                            <div class="bc-icons-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text"
                                            href="<?= route('latest-videos') ?>"><?= ucwords(__('videos')) ?></a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>

                                    <li class="breadcrumb-item"><a class="black-text"
                                            href="<?= route('categoryList') ?>"><?= ucwords(__('Category')) ?></a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>

                                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($categoryVideos['category_title']) > 50 ? ucwords(substr($categoryVideos['category_title'], 0, 120) . '...') : ucwords($categoryVideos['category_title']); ?>
                                        </a></li>
                                </ol>
                            </div>
                        </div>
                    </div>


                    @partial('categoryvids_section_filter')

                    {{-- Main Content  --}}

                    <div class="data">
                        @partial('categoryvids_section')
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@php
    include public_path('themes/default/views/footer.blade.php');
@endphp

{{-- Multiple Select  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" defer>
</script>
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

<style>
    button.btn.dropdown-toggle.bs-placeholder.btn-light {
        background: transparent !important;
        border: 1px solid #ddd !important;
        border-radius: 10px !important;
        color: #fff !important;
    }
</style>
