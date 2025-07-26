{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', trans_dynamic('page.home_title', app()->getLocale()))

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden">
    @if(isset($data['hero']['background_image']))
        <div class="hero-bg" style="background-image: url('{{ $data['hero']['background_image'] }}')"></div>
    @endif
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-3 fw-bold mb-4" data-aos="fade-up">
                    {{ $data['hero']['title'] ?? trans_dynamic('hero.default_title', app()->getLocale()) }}
                </h1>
                <p class="lead mb-5" data-aos="fade-up" data-aos-delay="200">
                    {{ $data['hero']['subtitle'] ?? trans_dynamic('hero.default_subtitle', app()->getLocale()) }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Counters Section -->
<section class="counters-section py-5 bg-light">
    <div class="container">
        <div class="row">
            @foreach($data['counters'] as $counter)
                <div class="col-6 col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="counter-item text-center">
                        <div class="counter-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                            @if($counter->icon)
                                <i class="{{ $counter->icon }} fa-2x text-primary"></i>
                            @else
                                <span class="counter-number display-4 fw-bold text-primary">{{ $counter->count }}</span>
                            @endif
                        </div>
                        <h5 class="counter-title">{{ $counter->getTitle(app()->getLocale()) }}</h5>
                        @if($counter->icon)
                            <div class="counter-number display-6 fw-bold text-primary">{{ number_format($counter->count) }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Take Action Section -->
@if(isset($data['takeAction']))
<section class="take-action-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="{{ $data['takeAction']['image'] }}" alt="{{ trans_dynamic('labels.take_action', app()->getLocale()) }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-4">
                    <h2 class="display-5 fw-bold mb-4">{{ $data['takeAction']['title'] }}</h2>
                    <p class="lead mb-4">{{ $data['takeAction']['subtitle'] }}</p>
                    @if(isset($data['takeAction']['button_url']))
                        <a href="{{ $data['takeAction']['button_url'] }}" class="btn btn-primary btn-lg">
                            {{ $data['takeAction']['button_text'] ?? trans_dynamic('button.learn_more', app()->getLocale()) }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Media Gallery Section -->
<section class="media-gallery-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" data-aos="fade-up">{{ trans_dynamic('section.media_gallery', app()->getLocale()) }}</h2>
            <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">{{ trans_dynamic('section.media_gallery_desc', app()->getLocale()) }}</p>
        </div>
        
        <div class="media-scroll-container" data-aos="fade-up" data-aos-delay="400">
            <div class="media-scroll d-flex">
                @foreach($data['mediaItems'] as $media)
                    <div class="media-item flex-shrink-0 me-3">
                        <div class="media-card position-relative overflow-hidden rounded" 
                             data-bs-toggle="modal" 
                             data-bs-target="#homeMediaModal"
                             data-src="{{ $media->media_url }}"
                             data-type="{{ $media->type }}"
                             data-title="{{ $media->getTitle(app()->getLocale()) }}"
                             style="cursor: pointer;">
                            @if($media->type === 'video')
                                <video class="w-100 h-100 object-cover" muted preload="metadata" poster="{{ $media->media_url }}#t=1">
                                    <source src="{{ $media->media_url }}" type="video/mp4">
                                </video>
                                <div class="play-overlay position-absolute top-50 start-50 translate-middle">
                                    <div class="play-button">
                                        <i class="fas fa-play text-white fa-2x"></i>
                                    </div>
                                </div>
                            @else
                                <img src="{{ $media->media_url }}" alt="{{ $media->getTitle(app()->getLocale()) }}" class="w-100 h-100 object-cover">
                            @endif
                            <div class="media-overlay position-absolute bottom-0 start-0 w-100 p-3">
                                <h6 class="text-white mb-0">{{ $media->getTitle(app()->getLocale()) }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('media') }}" class="btn btn-outline-primary">{{ trans_dynamic('button.view_all_media', app()->getLocale()) }}</a>
        </div>
    </div>
</section>

<!-- Stories Section -->
<section class="stories-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" data-aos="fade-up">{{ trans_dynamic('section.stories_of_hope', app()->getLocale()) }}</h2>
            <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">{{ trans_dynamic('section.stories_desc', app()->getLocale()) }}</p>
        </div>
        
        <div class="stories-scroll-container" data-aos="fade-up" data-aos-delay="400">
            <div class="stories-scroll d-flex">
                @foreach($data['stories'] as $story)
                    <div class="story-item flex-shrink-0 me-4">
                        <div class="story-card">
                            <img src="{{ $story->image_url }}" alt="{{ $story->getTitle(app()->getLocale()) }}" class="story-image">
                            <div class="story-content p-4">
                                <h5 class="story-title mb-3">{{ $story->getTitle(app()->getLocale()) }}</h5>
                                <p class="story-excerpt text-muted mb-3">{{ $story->getExcerpt(app()->getLocale()) }}</p>
                                <a href="{{ route('story.show', $story->id) }}" class="btn btn-sm btn-outline-primary">
                                    {{ trans_dynamic('button.view_full_story', app()->getLocale()) }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="partners-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" data-aos="fade-up">{{ trans_dynamic('section.our_partners', app()->getLocale()) }}</h2>
            <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">{{ trans_dynamic('section.partners_desc', app()->getLocale()) }}</p>
        </div>
        
        <div class="row justify-content-center">
            @foreach($data['partners'] as $partner)
                <div class="col-6 col-md-4 col-lg-3 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="partner-item text-center">
                        @if($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank" class="text-decoration-none partner-link">
                                <div class="partner-logo-circle mx-auto mb-3">
                                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->getName(app()->getLocale()) }}" class="partner-logo">
                                </div>
                                <h6 class="partner-name">{{ $partner->getName(app()->getLocale()) }}</h6>
                            </a>
                        @else
                            <div class="partner-logo-circle mx-auto mb-3">
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->getName(app()->getLocale()) }}" class="partner-logo">
                            </div>
                            <h6 class="partner-name">{{ $partner->getName(app()->getLocale()) }}</h6>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Home Media Modal -->
<div class="modal fade" id="homeMediaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="homeMediaModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="homeMediaModalContent"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Home media modal functionality
    const homeMediaModal = document.getElementById('homeMediaModal');
    const homeModalTitle = document.getElementById('homeMediaModalTitle');
    const homeModalContent = document.getElementById('homeMediaModalContent');
    
    document.querySelectorAll('.media-card').forEach(card => {
        card.addEventListener('click', function() {
            const src = this.dataset.src;
            const type = this.dataset.type;
            const title = this.dataset.title;
            
            homeModalTitle.textContent = title;
            
            if (type === 'video') {
                homeModalContent.innerHTML = `<video src="${src}" class="w-100" controls autoplay muted></video>`;
            } else {
                homeModalContent.innerHTML = `<img src="${src}" alt="${title}" class="w-100">`;
            }
        });
    });
    
    // Clean up video when modal closes
    homeMediaModal.addEventListener('hidden.bs.modal', function() {
        homeModalContent.innerHTML = '';
    });
});
</script>
@endpush
