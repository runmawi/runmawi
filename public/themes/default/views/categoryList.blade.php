@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites" class="py-4">
    <div class="container-fluid px-3 px-md-4">
        <!-- Header -->
        <div class="iq-main-header d-flex align-items-center justify-content-between py-3 mb-4">
            <h2 class="vid-title m-0 h4">{{ __("Category List") }}</h2>
        </div>

        <!-- Category Grid -->
        @if($category_list->isNotEmpty())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                @foreach($category_list as $category)
                    <div class="col">
                        <div class="category-card h-100 d-flex flex-column rounded-3 overflow-hidden shadow-sm bg-white transition-all hover:shadow-lg hover:scale-[1.02]">
                            <!-- Image -->
                            <div class="position-relative">
                                <a href="{{ URL::to('category') . '/' . $category->slug }}" class="d-block" aria-label="{{ $category->name }}">
                                    <img 
                                        src="{{ $category->image ? URL::to('public/uploads/videocategory/' . $category->image) : $default_vertical_image_url }}" 
                                        alt="{{ $category->name }}" 
                                        class="w-100 object-fit-cover" 
                                        style="aspect-ratio: 16/9; max-height: 200px;"
                                    >
                                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-25 opacity-0 hover:opacity-100 transition-opacity">
                                        <i class="fa fa-play text-white fs-3"></i>
                                    </div>
                                </a>
                            </div>

                            <!-- Content -->
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <a href="{{ URL::to('category') . '/' . $category->slug }}" class="text-decoration-none text-dark">
                                    <h5 class="fw-bold mb-2 text-truncate">{{ Str::limit($category->name, 30) }}</h5>
                                    <p class="text-muted small mb-3 flex-grow-1">
                                        {{ strlen($category->description) > 100 ? substr(strip_tags(html_entity_decode($category->description)), 0, 100) . '...' : strip_tags($category->description) }}
                                    </p>
                                </a>

                                <!-- CTA Button -->
                                <a href="{{ URL::to('category') . '/' . $category->slug }}" 
                                   class="btn btn-outline-primary btn-sm mt-auto w-100 fw-medium rounded-pill"
                                   aria-label="Visit {{ $category->name }}">
                                    <i class="fa fa-play me-1"></i> {{ __('Visit Category') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {!! $category_list->links() !!}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-5 my-5">
                <img src="{{ URL::to('/assets/img/watch.png') }}" alt="No videos" class="img-fluid mb-4" style="max-height: 300px; opacity: 0.7;">
                <h3 class="text-muted">{{ __('No Categories Available') }}</h3>
                <p class="text-muted mt-2">{{ __('Check back later for new categories.') }}</p>
            </div>
        @endif
    </div>
</section>

<style>
    .category-card {
    transition: all 0.3s ease;
}
.category-card:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.overlay {
    transition: opacity 0.3s ease;
}
.hover\\:opacity-100:hover {
    opacity: 1 !important;
}
.hover\\:shadow-lg:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.transition-all {
    transition: all 0.3s ease;
}
.object-fit-cover {
    object-fit: cover;
}
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp