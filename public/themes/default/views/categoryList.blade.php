@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-favorites" class="category-section">
    <div class="container-fluid px-3 px-md-4">
        <div class="row">
            <div class="col-12">
                <!-- Enhanced Header -->
                <div class="section-header mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="header-content">
                            <h1 class="section-title mb-2">{{ __("Browse Categories") }}</h1>
                            <p class="section-subtitle text-muted mb-0">{{ __("Discover content across different categories") }}</p>
                        </div>
                        @if (($category_list)->isNotEmpty())
                            <div class="view-controls d-none d-md-flex">
                                <button class="btn btn-outline-secondary btn-sm me-2" id="gridView" title="Grid View">
                                    <i class="fas fa-th" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="listView" title="List View">
                                    <i class="fas fa-list" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                @if (($category_list)->isNotEmpty())
                    <div class="categories-container">
                        <!-- Loading Skeleton (hidden by default) -->
                        <div class="loading-skeleton d-none" id="loadingSkeleton">
                            <div class="row g-3 g-md-4">
                                @for($i = 0; $i < 8; $i++)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="skeleton-card">
                                            <div class="skeleton-image"></div>
                                            <div class="skeleton-content">
                                                <div class="skeleton-title"></div>
                                                <div class="skeleton-description"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Categories Grid -->
                        <div class="categories-grid" id="categoriesGrid">
                            <div class="row g-3 g-md-4">
                                @forelse($category_list as $category_lists)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <article class="category-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                            <div class="card-wrapper">
                                                <!-- Image Container -->
                                                <div class="image-container">
                                                    <a href="{{ URL::to('category').'/'.$category_lists->slug }}" 
                                                       class="image-link" 
                                                       aria-label="{{ __('Browse') }} {{ $category_lists->name }}">
                                                        <img class="category-image" 
                                                             src="{{ $category_lists->image ? URL::to('public/uploads/videocategory/' . $category_lists->image) : $default_vertical_image_url }}" 
                                                             alt="{{ $category_lists->name }}"
                                                             loading="lazy"
                                                             onerror="this.src='{{ $default_vertical_image_url }}'">
                                                        <div class="image-overlay">
                                                            <div class="overlay-content">
                                                                <i class="fas fa-play-circle play-icon" aria-hidden="true"></i>
                                                                <span class="sr-only">{{ __('Play') }}</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    
                                                    <!-- Category Badge -->
                                                    <div class="category-badge">
                                                        <i class="fas fa-folder" aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="card-content">
                                                    <h3 class="category-title">
                                                        <a href="{{ URL::to('category').'/'.$category_lists->slug }}" 
                                                           class="title-link"
                                                           aria-label="{{ __('Browse') }} {{ $category_lists->name }}">
                                                            {{ Str::limit($category_lists->name, 20) }}
                                                        </a>
                                                    </h3>
                                                    
                                                    @if($category_lists->description)
                                                        <p class="category-description">
                                                            {{ Str::limit(strip_tags($category_lists->description), 60) }}
                                                        </p>
                                                    @endif

                                                    <div class="card-actions">
                                                        <a href="{{ URL::to('category').'/'.$category_lists->slug }}" 
                                                           class="btn btn-primary btn-sm browse-btn"
                                                           aria-label="{{ __('Browse') }} {{ $category_lists->name }}">
                                                            <i class="fas fa-arrow-right me-1" aria-hidden="true"></i>
                                                            {{ __('Browse') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-video-slash" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="empty-title">{{ __('No Categories Available') }}</h3>
                                            <p class="empty-description">{{ __('Categories will appear here once they are added.') }}</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($category_list->hasPages())
                            <div class="pagination-wrapper mt-5">
                                <nav aria-label="{{ __('Category pagination') }}">
                                    {{ $category_list->links('pagination::bootstrap-4') }}
                                </nav>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Enhanced Empty State -->
                    <div class="empty-state-container">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-video-slash" aria-hidden="true"></i>
                            </div>
                            <h2 class="empty-title">{{ __('No Categories Available') }}</h2>
                            <p class="empty-description">{{ __('Categories will appear here once they are added. Check back later for new content.') }}</p>
                            <a href="{{ URL::to('/') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2" aria-hidden="true"></i>
                                {{ __('Back to Home') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
/* Modern Category Section Styles */
.category-section {
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-attachment: fixed;
    padding: 2rem 0 3rem;
    position: relative;
}

.category-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.category-section > .container-fluid {
    position: relative;
    z-index: 2;
}

/* Section Header */
.section-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.section-title {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.section-subtitle {
    font-size: 1rem;
    color: #718096;
}

.view-controls button {
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
}

.view-controls button.active,
.view-controls button:hover {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
    transform: translateY(-2px);
}

/* Categories Container */
.categories-container {
    margin-top: 2rem;
}

/* Category Card */
.category-card {
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-card:hover {
    transform: translateY(-8px);
}

.card-wrapper {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

.category-card:hover .card-wrapper {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Image Container */
.image-container {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #f7fafc;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .image-overlay {
    opacity: 1;
}

.play-icon {
    font-size: 3rem;
    color: white;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.category-card:hover .play-icon {
    transform: scale(1);
}

.category-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(102, 126, 234, 0.9);
    color: white;
    padding: 0.5rem;
    border-radius: 50%;
    backdrop-filter: blur(10px);
}

/* Card Content */
.card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.5rem;
    line-height: 1.4;
}

.title-link {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.title-link:hover {
    color: #667eea;
}

.category-description {
    color: #718096;
    font-size: 0.875rem;
    line-height: 1.5;
    margin: 0 0 1rem;
    flex: 1;
}

.card-actions {
    margin-top: auto;
}

.browse-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    width: 100%;
}

.browse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

/* Loading Skeleton */
.skeleton-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    overflow: hidden;
    animation: pulse 1.5s ease-in-out infinite alternate;
}

.skeleton-image {
    height: 200px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

.skeleton-content {
    padding: 1rem;
}

.skeleton-title,
.skeleton-description {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}

.skeleton-title {
    height: 20px;
    width: 80%;
}

.skeleton-description {
    height: 16px;
    width: 60%;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes pulse {
    0% { opacity: 1; }
    100% { opacity: 0.7; }
}

/* Empty State */
.empty-state-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
}

.empty-state {
    text-align: center;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 3rem 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    max-width: 500px;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #718096;
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.pagination .page-link {
    border: none;
    color: #667eea;
    margin: 0 0.25rem;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
}

.pagination .page-link:hover,
.pagination .page-item.active .page-link {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-section {
        padding: 1rem 0 2rem;
    }
    
    .section-header {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .card-content {
        padding: 1rem;
    }
    
    .empty-state {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }
    
    .empty-icon {
        font-size: 3rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
    }
}

@media (max-width: 576px) {
    .image-container {
        aspect-ratio: 4/3;
    }
    
    .play-icon {
        font-size: 2.5rem;
    }
    
    .category-title {
        font-size: 1rem;
    }
    
    .category-description {
        font-size: 0.8rem;
    }
}

/* High-resolution displays */
@media (min-width: 1400px) {
    .categories-grid .col-lg-2 {
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
}

/* Print styles */
@media print {
    .category-section {
        background: white;
        color: black;
    }
    
    .category-card:hover {
        transform: none;
    }
    
    .image-overlay {
        display: none;
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    .category-card,
    .category-image,
    .play-icon,
    .browse-btn {
        transition: none;
    }
    
    .category-card:hover {
        transform: none;
    }
}

/* Focus styles for accessibility */
.image-link:focus,
.title-link:focus,
.browse-btn:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Screen reader only content */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const categoriesGrid = document.getElementById('categoriesGrid');
    
    if (gridViewBtn && listViewBtn) {
        gridViewBtn.classList.add('active');
        
        gridViewBtn.addEventListener('click', function() {
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            categoriesGrid.classList.remove('list-view');
        });
        
        listViewBtn.addEventListener('click', function() {
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            categoriesGrid.classList.add('list-view');
        });
    }
    
    // Lazy loading for images
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const image = entry.target;
                    image.classList.add('fade-in');
                    observer.unobserve(image);
                }
            });
        });
        
        images.forEach(function(image) {
            imageObserver.observe(image);
        });
    }
    
    // Add loading states
    const categoryLinks = document.querySelectorAll('.image-link, .browse-btn');
    categoryLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const loadingSkeleton = document.getElementById('loadingSkeleton');
            if (loadingSkeleton) {
                loadingSkeleton.classList.remove('d-none');
                categoriesGrid.style.opacity = '0.5';
            }
        });
    });
});
</script>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp