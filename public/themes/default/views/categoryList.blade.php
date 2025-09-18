@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites" class="category-section">
    <div class="container-fluid px-3 px-md-5 py-4">
        <!-- Section Header -->
        <div class="section-header mb-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h1 class="section-title mb-2">{{ __("Browse Categories") }}</h1>
                    <p class="section-subtitle text-muted mb-0">{{ __("Explore content organized by category") }}</p>
                </div>
                @if (($category_list)->isNotEmpty())
                    <div class="view-controls d-flex">
                        <button class="btn btn-outline-light btn-icon active" id="gridView" title="{{ __('Grid View') }}">
                            <i class="fas fa-th"></i>
                            <span class="sr-only">{{ __('Grid View') }}</span>
                        </button>
                        <button class="btn btn-outline-light btn-icon ms-2" id="listView" title="{{ __('List View') }}">
                            <i class="fas fa-list"></i>
                            <span class="sr-only">{{ __('List View') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @if (($category_list)->isNotEmpty())
            <div class="categories-container position-relative">
                <!-- Loading Skeleton -->
                <div class="loading-skeleton d-none" id="loadingSkeleton">
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-4">
                        @for($i = 0; $i < 6; $i++)
                            <div class="col">
                                <div class="skeleton-card rounded-3 overflow-hidden">
                                    <div class="skeleton-image" style="height: 180px;"></div>
                                    <div class="p-3">
                                        <div class="skeleton-title mb-2"></div>
                                        <div class="skeleton-description"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Categories Grid -->
                <div class="categories-grid" id="categoriesGrid">
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-4">
                        @forelse($category_list as $category)
                            <div class="col">
                                <article class="category-card h-100" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    <div class="card-wrapper h-100 d-flex flex-column rounded-3 overflow-hidden shadow-sm bg-white">
                                        <!-- Image -->
                                        <div class="image-container flex-shrink-0 position-relative" style="height: 180px;">
                                            <a href="{{ URL::to('category').'/'.$category->slug }}" 
                                               class="image-link d-block h-100"
                                               aria-label="{{ __('Browse') }} {{ $category->name }}">
                                                <img class="category-image w-100 h-100 object-fit-cover" 
                                                     src="{{ $category->image ? URL::to('public/uploads/videocategory/' . $category->image) : $default_vertical_image_url }}" 
                                                     alt="{{ $category->name }}"
                                                     loading="lazy"
                                                     onerror="this.src='{{ $default_vertical_image_url }}'">
                                                <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0">
                                                    <div class="overlay-content text-white text-center">
                                                        <i class="fas fa-play-circle play-icon display-4 mb-2"></i>
                                                        <span class="d-block fw-medium">{{ __('Browse') }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="category-badge position-absolute top-3 end-3 bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="card-content p-3 d-flex flex-column flex-grow-1">
                                            <h3 class="category-title fs-5 fw-semibold mb-2 lh-sm">
                                                <a href="{{ URL::to('category').'/'.$category->slug }}" 
                                                   class="text-decoration-none link-primary link-underline-opacity-0 link-underline-opacity-100-hover">
                                                    {{ Str::limit($category->name, 24) }}
                                                </a>
                                            </h3>
                                            
                                            @if($category->description)
                                                <p class="category-description text-muted small flex-grow-1 mb-3">
                                                    {{ Str::limit(strip_tags($category->description), 80) }}
                                                </p>
                                            @endif

                                            <a href="{{ URL::to('category').'/'.$category->slug }}" 
                                               class="btn btn-outline-primary btn-sm mt-auto text-uppercase fw-bold"
                                               aria-label="{{ __('Browse') }} {{ $category->name }}">
                                                {{ __('Browse') }} <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon text-muted mb-3">
                                        <i class="fas fa-video-slash display-1"></i>
                                    </div>
                                    <h3 class="empty-title h4">{{ __('No Categories Available') }}</h3>
                                    <p class="empty-description text-muted">{{ __('Check back later — new categories coming soon!') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($category_list->hasPages())
                    <div class="pagination-wrapper mt-5 d-flex justify-content-center">
                        <nav aria-label="{{ __('Category pagination') }}" class="bg-white rounded-3 p-3 shadow-sm">
                            {{ $category_list->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state-container d-flex align-items-center justify-content-center py-5">
                <div class="empty-state text-center p-5 bg-white rounded-4 shadow-lg max-w-500">
                    <div class="empty-icon text-muted mb-4">
                        <i class="fas fa-video-slash display-1"></i>
                    </div>
                    <h2 class="empty-title h3 fw-bold mb-3">{{ __('No Categories Available') }}</h2>
                    <p class="empty-description text-muted mb-4">{{ __('Categories will appear here once they are added. Check back later for new content.') }}</p>
                    <a href="{{ URL::to('/') }}" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-home me-2"></i> {{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Modern, Clean Category Section */
.category-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem 0;
    position: relative;
    overflow-x: hidden;
}

.category-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.03);
    z-index: 1;
}

.container-fluid {
    position: relative;
    z-index: 2;
}

/* Header */
.section-header {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.section-title {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
    font-weight: 700;
    color: white;
    margin: 0;
}

.section-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.85);
}

.view-controls .btn-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    transition: all 0.25s ease;
}

.view-controls .btn-outline-light.active,
.view-controls .btn-outline-light:hover {
    background: white;
    color: #667eea;
    transform: translateY(-2px);
}

/* Cards */
.category-card {
    transition: transform 0.3s ease, opacity 0.2s ease;
    will-change: transform;
}

.category-card:hover {
    transform: translateY(-6px);
}

.card-wrapper {
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.category-card:hover .card-wrapper {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.image-container {
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.image-link {
    display: block;
    position: relative;
}

.category-image {
    transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.category-card:hover .category-image {
    transform: scale(1.03);
}

.image-overlay {
    background: rgba(102, 126, 234, 0.85);
    transition: opacity 0.3s ease;
}

.category-card:hover .image-overlay {
    opacity: 1;
}

/* Content */
.card-content {
    min-height: 140px;
}

.category-title a {
    transition: color 0.2s ease;
}

.category-title a:hover {
    color: #667eea;
}

.btn-outline-primary {
    border-width: 2px;
    transition: all 0.25s ease;
}

.btn-outline-primary:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

/* Skeleton */
.skeleton-card {
    animation: pulse 1.5s ease-in-out infinite;
    background: #ffffff;
}

.skeleton-image,
.skeleton-title,
.skeleton-description {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

.skeleton-title {
    height: 16px;
    border-radius: 4px;
}

.skeleton-description {
    height: 12px;
    border-radius: 4px;
    width: 80%;
}

/* Empty State */
.empty-state-container {
    min-height: 60vh;
}

.empty-state {
    max-width: 500px;
}

.empty-icon {
    color: rgba(255, 255, 255, 0.3);
}

.empty-title {
    color: white;
}

.empty-description {
    color: rgba(255, 255, 255, 0.7);
}

/* Pagination */
.pagination .page-link {
    color: #667eea;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    margin: 0 0.15rem;
    transition: all 0.2s ease;
}

.pagination .page-link:hover,
.pagination .page-item.active .page-link {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .section-header {
        padding: 1.5rem;
    }
    .section-title {
        font-size: 2rem;
    }
    .image-container {
        height: 160px !important;
    }
}

@media (max-width: 576px) {
    .section-header {
        text-align: center;
    }
    .view-controls {
        justify-content: center;
    }
}

/* Animations */
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.9; }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .category-card,
    .category-image,
    .btn {
        transition: none !important;
        animation: none !important;
    }
}

/* Accessibility */
.image-link:focus,
.card-content a:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const grid = document.getElementById('categoriesGrid');

    if (gridViewBtn && listViewBtn) {
        gridViewBtn.addEventListener('click', () => {
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            grid.classList.remove('list-view');
        });

        listViewBtn.addEventListener('click', () => {
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            grid.classList.add('list-view');
        });
    }

    // Hover Overlay
    document.querySelectorAll('.category-card').forEach(card => {
        const overlay = card.querySelector('.image-overlay');
        const link = card.querySelector('.image-link');

        link.addEventListener('mouseenter', () => overlay?.classList.add('opacity-100'));
        link.addEventListener('mouseleave', () => overlay?.classList.remove('opacity-100'));
    });

    // Loading State on Navigation
    document.querySelectorAll('.image-link, .browse-btn').forEach(link => {
        link.addEventListener('click', function() {
            const skeleton = document.getElementById('loadingSkeleton');
            const grid = document.getElementById('categoriesGrid');
            if (skeleton && grid) {
                skeleton.classList.remove('d-none');
                grid.style.opacity = '0.6';
            }
        });
    });
});
</script>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp