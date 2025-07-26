{{-- resources/views/media.blade.php --}}
@extends('layouts.app')

@section('title', trans_dynamic('page.media_gallery_title', app()->getLocale()))

@section('content')
<!-- Page Header -->
<section class="page-header position-relative overflow-hidden">
    @php
        $mediaHeaderBg = \App\Models\SiteContent::getContent('page_headers', app()->getLocale())['media_gallery']['background_image'] ?? null;
    @endphp
    
    @if($mediaHeaderBg)
        <div class="page-header-bg" style="background-image: url('{{ $mediaHeaderBg }}')"></div>
        <div class="page-header-overlay"></div>
    @else
        <div class="page-header-gradient"></div>
    @endif
    
    <div class="container position-relative">
        <div class="row min-vh-50 align-items-center text-white">
            <div class="col-12 text-center py-5">
                <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">
                    {{ trans_dynamic('page.media_gallery', app()->getLocale()) }}
                </h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="200">
                    {{ trans_dynamic('page.media_gallery_desc', app()->getLocale()) }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Media Grid -->
<section class="media-grid-section py-5">
    <div class="container">
        <!-- Filter Buttons -->
        <div class="text-center mb-5">
            <div class="btn-group" role="group" data-aos="fade-up">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">
                    {{ trans_dynamic('filter.all', app()->getLocale()) }}
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="image">
                    {{ trans_dynamic('filter.photos', app()->getLocale()) }}
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="video">
                    {{ trans_dynamic('filter.videos', app()->getLocale()) }}
                </button>
            </div>
        </div>

        <!-- Media Grid -->
        <div class="row g-4" id="mediaGrid">
            @foreach($mediaItems as $media)
                <div class="col-6 col-md-4 col-lg-3 media-grid-item" data-type="{{ $media->type }}" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="media-grid-card position-relative overflow-hidden rounded shadow-sm">
                        @if($media->type === 'video')
                            <video class="media-grid-image" muted preload="metadata" poster="{{ $media->media_url }}#t=1">
                                <source src="{{ $media->media_url }}" type="video/mp4">
                            </video>
                            <div class="media-type-badge position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">
                                    <i class="fas fa-video me-1"></i>{{ trans_dynamic('media.video', app()->getLocale()) }}
                                </span>
                            </div>
                            <div class="play-overlay-large position-absolute top-50 start-50 translate-middle">
                                <div class="play-button-large">
                                    <i class="fas fa-play text-white fa-3x"></i>
                                </div>
                            </div>
                        @else
                            <img src="{{ $media->media_url }}" alt="{{ $media->getTitle(app()->getLocale()) }}" class="media-grid-image">
                            <div class="media-type-badge position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-image me-1"></i>{{ trans_dynamic('media.photo', app()->getLocale()) }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="media-overlay position-absolute bottom-0 start-0 w-100 p-3">
                            <h6 class="text-white mb-1">{{ $media->getTitle(app()->getLocale()) }}</h6>
                            @if($media->getDescription(app()->getLocale()))
                                <p class="text-light small mb-0">{{ Str::limit($media->getDescription(app()->getLocale()), 60) }}</p>
                            @endif
                        </div>
                        
                        <!-- Click overlay for modal -->
                        <div class="media-click-overlay position-absolute top-0 start-0 w-100 h-100" 
                             data-bs-toggle="modal" 
                             data-bs-target="#mediaModal"
                             data-src="{{ $media->media_url }}"
                             data-type="{{ $media->type }}"
                             data-title="{{ $media->getTitle(app()->getLocale()) }}"
                             data-description="{{ $media->getDescription(app()->getLocale()) }}"
                             style="cursor: pointer;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $mediaItems->links() }}
        </div>
    </div>
</section>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="mediaModalContent"></div>
            </div>
            <div class="modal-footer">
                <p class="text-muted mb-0" id="mediaModalDescription"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    const mediaItems = document.querySelectorAll('.media-grid-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items with animation
            mediaItems.forEach((item, index) => {
                if (filter === 'all' || item.dataset.type === filter) {
                    item.style.display = 'block';
                    item.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s both`;
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Modal functionality
    const mediaModal = document.getElementById('mediaModal');
    const modalTitle = document.getElementById('mediaModalTitle');
    const modalContent = document.getElementById('mediaModalContent');
    const modalDescription = document.getElementById('mediaModalDescription');
    
    document.querySelectorAll('.media-click-overlay').forEach(overlay => {
        overlay.addEventListener('click', function() {
            const src = this.dataset.src;
            const type = this.dataset.type;
            const title = this.dataset.title;
            const description = this.dataset.description;
            
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            
            if (type === 'video') {
                modalContent.innerHTML = `<video src="${src}" class="w-100" controls autoplay muted></video>`;
            } else {
                modalContent.innerHTML = `<img src="${src}" alt="${title}" class="w-100">`;
            }
        });
    });
    
    // Clean up video when modal closes
    mediaModal.addEventListener('hidden.bs.modal', function() {
        modalContent.innerHTML = '';
    });
});

// Add fadeInUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
